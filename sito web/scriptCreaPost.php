<?php
    try
    {
        $titolo = trim($_POST["titolo"]);
        $sottotitolo = trim($_POST["sottotitolo"]);
        $contenuto = trim($_POST["contenuto"]);
        $dataCreazione = date("Y-m-d");

        $IDblog = $_POST["IDblog"];

        session_start();
        $IDutente = $_SESSION["sessioneUtente"];

        include("dbconnection.php");
        include("scriptPrevenzione.php");
        controlloTokenInput($titolo);
        controlloTokenInput($sottotitolo);
        controlloTokenInput($contenuto);

        $titolo = addslashes($titolo);
        $sottotitolo = addslashes($sottotitolo);
        $contenuto = addslashes($contenuto);

        $stmt = $conn -> prepare("SELECT titolo FROM post WHERE titolo = :titolo and IDblog = '$IDblog'");
        $stmt->bindParam(':titolo', $titolo);
        $stmt->execute();
        $row = $stmt->fetch();

        if($row){
            $conn = null;
            die("a");
            //Esiste già un post in questo blog con questo titolo
        }

        //controllo l'estensione e il peso dell'immagine
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
            if($_FILES["imgPost"]["size"] > 1000*1024)
            {
                $conn = null;
                die("c");   //l'immagine non può occupare più di 1000KB
            }
        }
        else//l'immagine non è stata selezionata
            $img = "default.png";


        $stmt = $conn -> prepare("INSERT INTO post(titolo, sottotitolo, data, testoPost, IDblog, IDutente) VALUES (:titolo, :sottotitolo, :data, :testoPost, $IDblog, $IDutente)");

        $stmt -> bindParam(":titolo", $titolo);
        $stmt -> bindParam(":sottotitolo", $sottotitolo);
        $stmt -> bindParam(":data", $dataCreazione);
        $stmt -> bindParam(":testoPost", $contenuto);
        $stmt->execute();

        $last_id = $conn->lastInsertId();

        //aggiorno il numero di post del blog
        $stmt = ("UPDATE blog SET numPost = numPost + 1 WHERE IDblog = '$IDblog'");
        $conn->exec($stmt);

        //GESTIONE IMMAGINE POST
        if($_FILES["imgPost"]["name"])
        {
            $pathDestinazione =  "immagini/postPics/" . $last_id . "." . $fileType;

            if(move_uploaded_file($_FILES["imgPost"]["tmp_name"], $pathDestinazione))
                $img = $last_id . "." . $fileType;
            else
                $img = "default.png";
        }

        $stmt = ("UPDATE post SET immagine = '$img' WHERE IDpost = '$last_id'");
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