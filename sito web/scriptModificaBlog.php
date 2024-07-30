    <?php
    try
    {
        include("dbconnection.php");
        $titolo = trim($_POST["titolo"]);
        $presentazione = trim($_POST["presentazione"]);
        $imgDefault = $_POST["imgDefault"];
        $stile = $_POST["stile"];
        $IDblog = $_POST["IDblog"];

        $arrayIdSottotemi = $_POST["arrayIdSottotemi"]; //sottotemi scelti tra le opzioni
        $arrayNuoviSottotemi = $_POST["arrayNuoviSottotemi"]; //sottotemi nuovi, da inserire nella tabella TEMI

        if(isset($_POST["limiteEta"]))
            $limiteEta = 1;
        else
            $limiteEta = 0;

        include("scriptPrevenzione.php");
        controlloTokenInput($titolo);
        controlloTokenInput($presentazione);

        $titolo = addslashes($titolo);
        $presentazione = addslashes($presentazione);

        $stmt = $conn -> prepare("SELECT IDblog, titolo FROM blog WHERE titolo = :titolo");
        $stmt->bindParam(':titolo', $titolo);
        $stmt->execute();
        $row = $stmt->fetch();

        if($row)
        {
            if($IDblog == $row["IDblog"])
            {//non vuoi cambiare titolo del blog
                $stmt = $conn -> prepare("UPDATE blog SET presentazione = :presentazione, limiteEta = :limiteEta, IDstile = :stile WHERE IDblog = '$IDblog'");
                $stmt -> bindParam(":presentazione", $presentazione);
                $stmt -> bindParam(":limiteEta", $limiteEta);
                $stmt -> bindParam(":stile", $stile);
                $stmt->execute();
            }
            else
            {
                $conn = null;
                die("a");
                //Esiste già un blog con questo titolo
            }
        }
        else
        {//il titolo del blog è cambiato
            $stmt = $conn -> prepare("UPDATE blog SET titolo = :titolo, presentazione = :presentazione, limiteEta = :limiteEta, IDstile = :stile WHERE IDblog = '$IDblog'");
            $stmt -> bindParam(":titolo", $titolo);
            $stmt -> bindParam(":presentazione", $presentazione);
            $stmt -> bindParam(":limiteEta", $limiteEta);
            $stmt -> bindParam(":stile", $stile);
            $stmt->execute();
        }

        //controllo l'estensione e il peso dell'immagine
        if($_FILES["imgBlog"]["name"])
        {
            $fileName = basename($_FILES["imgBlog"]["name"]);
            $pathDestinazione = "immagini/blogPics/" . $fileName;
            $fileType = pathinfo($pathDestinazione,PATHINFO_EXTENSION);

            $estensioniAccettate = array('jpg','png','jpeg');
            if(!in_array($fileType, $estensioniAccettate))
                die("b");//l'estensione dell'immagine non va bene
            if($_FILES["imgBlog"]["size"] > 1000*1024)
                die("c");   //l'immagine non può occupare più di 100OKB
        }
        else
            $img = "default.png";//l'immagine non è stata selezionata

        //Elimino i temi associati al blog
        $stmt = "DELETE FROM temiblog WHERE IDblog = '$IDblog'";
        $conn->exec($stmt);

        //Inserimento in tabella temiblog
        $arrayIdSottotemi = explode(",", $arrayIdSottotemi);

        if(count($arrayIdSottotemi)>0)
        {
            for($i = 0; $i < count($arrayIdSottotemi)-1; $i++)
            {
                $stmt = ("INSERT INTO temiblog(IDblog, IDtema) VALUES ('$IDblog', '$arrayIdSottotemi[$i]')");
                $conn->exec($stmt);
            }
        }
        
        //Inserimento in tabella temi (sottotemi nuovi)
        $arrayNuoviSottotemi = explode(",", $arrayNuoviSottotemi);
        if(count($arrayNuoviSottotemi)>1)
        {
            for($i = 0; $i < count($arrayNuoviSottotemi); $i=$i+2)
            {
                $stringaSottotema = $arrayNuoviSottotemi[$i];
                $IDmacrotema = $arrayNuoviSottotemi[$i+1];

                //controllo se i temi inseriti a mano non esistono già
                $q = "SELECT IDsottotema FROM sottotema WHERE sottotema = '$stringaSottotema' and macrotema = '$IDmacrotema'";
                $sth = $conn->query($q);
                $result = $sth->fetch(PDO::FETCH_ASSOC);

                if($result)
                {
                    $sottotemaEsistente = $result["IDsottotema"];

                    $q = "SELECT IDblog FROM temiblog WHERE IDblog = '$IDblog' and IDtema = '$sottotemaEsistente'";
                    $sth2 = $conn->query($q);
                    $result2 = $sth2->fetch(PDO::FETCH_ASSOC);

                    if(!$result2)
                    {
                        $stmt = ("INSERT INTO temiblog(IDblog, IDtema) VALUES ('$IDblog', '$sottotemaEsistente')");
                        $conn->exec($stmt);
                    }
                }
                else
                {
                    $stmt = ("INSERT INTO sottotema (sottotema, macrotema) VALUES ('$stringaSottotema', '$IDmacrotema')");
                    $conn->exec($stmt);

                    $idSottotemaNuovo = $conn->lastInsertId();

                    $stmt = ("INSERT INTO temiblog(IDblog, IDtema) VALUES ('$IDblog', '$idSottotemaNuovo')");
                    $conn->exec($stmt);
                }
            }
        }

        //GESTIONE IMMAGINE BLOG
        if($imgDefault == 1)
        {
            //elimino la vecchia immagine dal server
            if(file_exists("immagini/blogPics/" . $IDblog . ".png"))
                unlink("immagini/blogPics/" . $IDblog . ".png");

            if(file_exists("immagini/blogPics/" . $IDblog . ".jpg"))
                unlink("immagini/blogPics/" . $IDblog . ".jpg"); 

            if(file_exists("immagini/blogPics/" . $IDblog . ".jpeg"))
                unlink("immagini/blogPics/" . $IDblog . ".jpeg");

            $stmt = $conn -> prepare("UPDATE blog SET immagine = 'default.png' WHERE IDblog = '$IDblog'");
            $stmt->execute();
            die("ok");
        }

        if($_FILES["imgBlog"]["name"])
        {
            //elimino la vecchia immagine dal server
            if(file_exists("immagini/blogPics/" . $IDblog . ".png"))
                unlink("immagini/blogPics/" . $IDblog . ".png");

            if(file_exists("immagini/blogPics/" . $IDblog . ".jpg"))
                unlink("immagini/blogPics/" . $IDblog . ".jpg"); 

            if(file_exists("immagini/blogPics/" . $IDblog . ".jpeg"))
                unlink("immagini/blogPics/" . $IDblog . ".jpeg");

            $pathDestinazione =  "immagini/blogPics/" . $IDblog . "." . $fileType;

            if(move_uploaded_file($_FILES["imgBlog"]["tmp_name"], $pathDestinazione))
                $img = $IDblog . "." . $fileType;
            else
                $img = "default.png";

            $stmt = ("UPDATE blog SET immagine = '$img' WHERE IDblog = '$IDblog'");
            $conn->exec($stmt);
        }

        $conn = null;
        die("ok");
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }
    
?>