<?php
    try
    {
        include("dbconnection.php");

        $titolo = trim($_POST["titolo"]);
        $sottotitolo = trim($_POST["sottotitolo"]);
        $contenuto = trim($_POST["contenuto"]);
        $imgDefault = $_POST["imgDefault"];

        $IDblog = $_POST["IDblog"];
        $IDpost = $_POST["IDpost"];

        session_start();
        $IDutente = $_SESSION["sessioneUtente"];

        include("scriptPrevenzione.php");
        controlloTokenInput($titolo);
        controlloTokenInput($sottotitolo);
        controlloTokenInput($contenuto);

        $titolo = addslashes($titolo);
        $sottotitolo = addslashes($sottotitolo);
        $contenuto = addslashes($contenuto);

        $stmt = $conn -> prepare("SELECT IDpost, titolo FROM post WHERE titolo = :titolo and IDblog = '$IDblog'");
        $stmt->bindParam(':titolo', $titolo);
        $stmt->execute();
        $row = $stmt->fetch();

        if($row){
            if($row["IDpost"]==$IDpost)
            {
                $stmt = $conn -> prepare("UPDATE post SET sottotitolo = :sottotitolo, testoPost = :testoPost WHERE IDpost = '$IDpost'");
                $stmt -> bindParam(":sottotitolo", $sottotitolo);
                $stmt -> bindParam(":testoPost", $contenuto);
                $stmt->execute();
            }
            else
            {
                $conn = null;
                die("a");
                //Esiste già un post in questo blog con questo titolo"
            }
        }
        else
        {
            $stmt = $conn -> prepare("UPDATE post SET titolo = :titolo, sottotitolo = :sottotitolo, testoPost = :testoPost WHERE IDpost = '$IDpost'");
            $stmt -> bindParam(":titolo", $titolo);
            $stmt -> bindParam(":sottotitolo", $sottotitolo);
            $stmt -> bindParam(":testoPost", $contenuto);
            $stmt->execute();
        }

        if($_FILES["imgPost"]["name"])
        {
            $fileName = basename($_FILES["imgPost"]["name"]);
            $pathDestinazione = "immagini/postPics/" . $fileName;
            $fileType = pathinfo($pathDestinazione,PATHINFO_EXTENSION);

            $estensioniAccettate = array('jpg','png','jpeg');
            if(!in_array($fileType, $estensioniAccettate))
            {
                $conn = null;
                die("b");//l'estensione dell'immagine non va bene
            }
            if($_FILES["imgPost"]["size"] > 1024*1024)
            {
                $conn = null;
                die("c");   //l'immagine non può occupare più di 1MB
            }
        }
        else
            $img = "default.png";//l'immagine non è stata selezionata


        //GESTIONE IMMAGINE POST
        if($imgDefault == 1)
        {
                //elimino la vecchia immagine dal server
            if(file_exists("immagini/postPics/" . $IDpost . ".png"))
                unlink("immagini/postPics/" . $IDpost . ".png");

            if(file_exists("immagini/postPics/" . $IDpost . ".jpg"))
                unlink("immagini/postPics/" . $IDpost . ".jpg"); 

            if(file_exists("immagini/postPics/" . $IDpost . ".jpeg"))
                unlink("immagini/postPics/" . $IDpost . ".jpeg");

            $stmt = "UPDATE post SET immagine = 'default.png' WHERE IDpost = '$IDpost'";
            $conn->exec($stmt);
            
            $conn = null;
            die($IDpost);
        }

        if($_FILES["imgPost"]["name"])
        {
            //elimino la vecchia immagine dal server
            if(file_exists("immagini/postPics/" . $IDpost . ".png"))
                unlink("immagini/postPics/" . $IDpost . ".png");

            if(file_exists("immagini/postPics/" . $IDpost . ".jpg"))
                unlink("immagini/postPics/" . $IDpost . ".jpg"); 

            if(file_exists("immagini/postPics/" . $IDpost . ".jpeg"))
                unlink("immagini/postPics/" . $IDpost . ".jpeg");

            $pathDestinazione =  "immagini/postPics/" . $IDpost . "." . $fileType;

            if(move_uploaded_file($_FILES["imgPost"]["tmp_name"], $pathDestinazione))
                $img = $IDpost . "." . $fileType;
            else
                $img = "default.png";

            $stmt = "UPDATE post SET immagine = '$img' WHERE IDpost = '$IDpost'";
            $conn->exec($stmt);
        }

        $conn = null;
        die($IDpost);
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }

?>