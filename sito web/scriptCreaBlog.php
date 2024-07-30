<?php
    try
    {
        $titolo = trim($_POST["titolo"]);
        $presentazione = trim($_POST["presentazione"]);
        $arrayIdSottotemi = $_POST["arrayIdSottotemi"]; //sottotemi scelti tra le opzioni
        $arrayNuoviSottotemi = $_POST["arrayNuoviSottotemi"]; //sottotemi nuovi, da inserire nella tabella TEMI
        $dataCreazione = date("Y-m-d");
        $stile = $_POST["stile"];

        if(isset($_POST["limiteEta"]))
            $limiteEta = 1;
        else
            $limiteEta = 0;

        include("scriptPrevenzione.php");
        controlloTokenInput($titolo);
        controlloTokenInput($presentazione);

        $titolo = addslashes($titolo);
        $presentazione = addslashes($presentazione);

        include("dbconnection.php");
        $stmt = $conn -> prepare("SELECT titolo FROM blog WHERE titolo = :titolo");
        $stmt->bindParam(':titolo', $titolo);
        $stmt->execute();
        $row = $stmt->fetch();

        if($row){
            $conn = null;
            die("a");
            //Esiste già un blog con questo titolo
        }

        //controllo l'estensione e il peso dell'immagine
        if($_FILES["imgBlog"]["name"])
        {
            $fileName = basename($_FILES["imgBlog"]["name"]);
            $pathDestinazione = "immagini/blogPics/" . $fileName;
            $fileType = pathinfo($pathDestinazione,PATHINFO_EXTENSION);

            $estensioniAccettate = array('jpg','png','jpeg');
            if(!in_array($fileType, $estensioniAccettate))
            {
                $conn = null;
                die("b");//l'estensione dell'immagine non va bene
            }
            if($_FILES["imgBlog"]["size"] > 1000*1024)
            {
                $conn = null;
                die("c");   //l'immagine non può occupare più di 1000KB
            }
        }
        else//l'immagine non è stata selezionata
            $img = "default.png";

        //Inserimento in tabella BLOG
        $stmt = $conn -> prepare("INSERT INTO blog(titolo, limiteEta, data, presentazione, IDstile) VALUES (:titolo, :limiteEta, :data, :presentazione, :stile)");

        $stmt -> bindParam(":titolo", $titolo);
        $stmt -> bindParam(":limiteEta", $limiteEta);
        $stmt -> bindParam(":data", $dataCreazione);
        $stmt -> bindParam(":presentazione", $presentazione);
        $stmt -> bindParam(":stile", $stile);
        $stmt->execute();

        session_start();
        $user_id = $_SESSION["sessioneUtente"];
        $last_id = $conn->lastInsertId(); //prendo l'id del blog appena creato

        //Aggiornamento tabella AUTORE
        $stmt = ("INSERT INTO autore(IDutente, IDblog) VALUES ('$user_id', '$last_id')");
        $conn->exec($stmt);

        //Inserimento in tabella temiblog delle categorie associate al blog
        $arrayIdSottotemi = explode(",", $arrayIdSottotemi);
        if(count($arrayIdSottotemi)>0)
        {
            for($i = 0; $i < count($arrayIdSottotemi)-1; $i++)
            {
                $stmt = ("INSERT INTO temiblog(IDblog, IDtema) VALUES ('$last_id', '$arrayIdSottotemi[$i]')");
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

                    $q = "SELECT IDblog FROM temiblog WHERE IDblog = '$last_id' and IDtema = '$sottotemaEsistente'";
                    $sth2 = $conn->query($q);
                    $result2 = $sth2->fetch(PDO::FETCH_ASSOC);

                    if(!$result2)
                    {
                        $stmt = ("INSERT INTO temiblog(IDblog, IDtema) VALUES ('$last_id', '$sottotemaEsistente')");
                        $conn->exec($stmt);
                    }
                }
                else
                {
                    $stmt = ("INSERT INTO sottotema (sottotema, macrotema) VALUES ('$stringaSottotema', '$IDmacrotema')");
                    $conn->exec($stmt);

                    $idSottotemaNuovo = $conn->lastInsertId();

                    $stmt = ("INSERT INTO temiblog(IDblog, IDtema) VALUES ('$last_id', '$idSottotemaNuovo')");
                    $conn->exec($stmt);
                }
            }
        }

        //GESTIONE IMMAGINE BLOG
        if($_FILES["imgBlog"]["name"])
        {
            $pathDestinazione =  "immagini/blogPics/" . $last_id . "." . $fileType;

            if(move_uploaded_file($_FILES["imgBlog"]["tmp_name"], $pathDestinazione))
                $img = $last_id . "." . $fileType;
            else
                $img = "default.png";
        }

        $stmt = ("UPDATE blog SET immagine = '$img' WHERE IDblog = '$last_id'");
        $conn->exec($stmt);

        $conn = null;
        die($last_id);
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }
?>