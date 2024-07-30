<?php
    try
    {
        include("dbconnection.php");

        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["psw"]);
        $data = trim($_POST["dataNascita"]);

        include("scriptPrevenzione.php");
        controlloTokenInput($username);
        controlloTokenInput($email);
        controlloTokenInput($password);
        
        $email = addslashes($email);
        $password = addslashes($password); 
        $data = addslashes($data);


        //CONTROLLO CHE IL NOME UTENTE NON ESISTA GIA'
        $stmt = $conn -> prepare("SELECT username FROM utente WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch();

        if($row){
            die("1");
            //Il nome utente esiste già
        }

        //CONTROLLO CHE L'EMAIL NON ESISTA GIA'
        $stmt = $conn -> prepare("SELECT email FROM utente WHERE email = :email");
        $stmt -> bindParam(":email", $email);
        $stmt->execute();
        $row = $stmt->fetch();

        if($row){
            $conn = null;
            die("2");
            //L'email esiste già
        }

        if($_FILES["proPic"]["name"])
        {
            $fileName = basename($_FILES["proPic"]["name"]);
            $pathDestinazione = "immagini/proPics/" . $fileName;
            $fileType = pathinfo($pathDestinazione,PATHINFO_EXTENSION);

            $estensioniAccettate = array('jpg','png','jpeg');
            if(!in_array($fileType, $estensioniAccettate))
            {
                $conn = null;
                die("3");   //l'estensione dell'immagine non va bene
            }
            if($_FILES["proPic"]["size"] > 1000*1024)
            {
                $conn = null;
                die("4");   //l'immagine non può occupare più di 1000byte
            }
        }
        else
            $img = "default.png";//l'immagine non è stata selezionata

        $stmt = $conn -> prepare("INSERT INTO utente(username, password, email, dataNascita) VALUES (:username, :password, :email, :data)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt -> bindParam(":username", $username);
        $stmt -> bindParam(":password", $hashedPassword);
        $stmt -> bindParam(":email", $email);
        $stmt -> bindParam(":data", $data);
        $stmt->execute();

        $last_id = $conn->lastInsertId();

        //GESTIONE IMMAGINE PROFILO
        if($_FILES["proPic"]["name"])
        {
            $pathDestinazione =  "immagini/proPics/" . $last_id . "." . $fileType;

            if(move_uploaded_file($_FILES["proPic"]["tmp_name"], $pathDestinazione))
                $img = $last_id . "." . $fileType;
            else
                $img = "default.png";
        }

        $stmt = ("UPDATE utente SET proPic = '$img' WHERE IDutente = '$last_id'");
        $conn->exec($stmt);

        $conn = null;
        die("ok");
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }
?>