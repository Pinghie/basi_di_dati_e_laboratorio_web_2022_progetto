<?php
    try
    {
        session_start();
        $IDutente = $_SESSION["sessioneUtente"];

        include("dbconnection.php");

        $username = trim($_POST["username"]);
        $email = trim($_POST["email"]);
        $data = trim($_POST["dataNascita"]);

        include("scriptPrevenzione.php");
        controlloTokenInput($username);
        controlloTokenInput($email);

        $username = $username;
        $email = addslashes($email);

        if(isset($_POST["pswVecchia"]) and isset($_POST["pswNuova"])){
            $pswVecchia = trim($_POST["pswVecchia"]);
            $pswNuova = trim($_POST["pswNuova"]);

            controlloTokenInput($pswVecchia);
            controlloTokenInput($pswNuova);

            $pswVecchia = addslashes($pswVecchia);
            $pswNuova = addslashes($pswNuova);
        }
        else{
            $pswVecchia = "";
            $pswNuova = "";
        }

        //Controllo se lo username esiste già
        $stmt = $conn -> prepare("SELECT username FROM utente WHERE username = :username and IDutente != '$IDutente'");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch();

        if($row){
            die("1");
        }

        //Controllo se l'email esiste già
        $stmt = $conn -> prepare("SELECT email FROM utente WHERE email = :email and IDutente != '$IDutente'");
        $stmt -> bindParam(":email", $email);
        $stmt->execute();
        $row = $stmt->fetch();

        if($row){
            die("2");
        }

        //Controllo se i campi per la modifica della password sono vuoti
        if($pswNuova == "" and $pswVecchia == ""){
            aggiornaImmagine();
            $stmt = $conn -> prepare("UPDATE utente SET username = :username, email = :email, dataNascita = :data WHERE IDutente = '$IDutente'");

                $stmt -> bindParam(":username", $username);
                $stmt -> bindParam(":email", $email);
                $stmt -> bindParam(":data", $data);
                $stmt->execute();

                $_SESSION["nomeUtente"] = $username;

                die("ok");
        }

        //Controllo se la vecchia psw corrisponde
        $q = ("SELECT password FROM utente WHERE IDutente = '$IDutente'");
        $result = $conn->query($q);
        $row = $result->fetch();

        if(password_verify($pswVecchia, $row["password"])){
            if(password_verify($pswNuova, $row["password"])){
                //la vecchia password e quella nuova coincidono
                die("4");
            }
            else{
                aggiornaImmagine();
                $stmt = $conn -> prepare("UPDATE utente SET username = :username, email = :email, password = :pswNuova, dataNascita = :data WHERE IDutente = '$IDutente'");

                $pswNuovaHashed = password_hash($pswNuova, PASSWORD_DEFAULT);

                $stmt -> bindParam(":username", $username);
                $stmt -> bindParam(":email", $email);
                $stmt -> bindParam(":pswNuova", $pswNuovaHashed);
                $stmt -> bindParam(":data", $data);
                $stmt->execute();

                $_SESSION["nomeUtente"] = $username;

                aggiornaImmagine();

                die("ok");
            }
        }
        else{
            //la vecchia password inserita non corrisponde
            die("3");
        }
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }

function aggiornaImmagine()
{
    global $IDutente, $conn;

    if($_FILES["proPic"]["name"] and !empty($_FILES["proPic"]["name"])) //l'utente ha caricato un file? 
    {
        $fileName = basename($_FILES["proPic"]["name"]);
        $pathDestinazione = "immagini/proPics/" . $fileName;
        $fileType = pathinfo($pathDestinazione,PATHINFO_EXTENSION);

        $estensioniAccettate = array('jpg','png','jpeg');
        if(!in_array($fileType, $estensioniAccettate))
        {
            $conn = null;
            die("b");   //l'estensione dell'immagine non va bene
        }
        if($_FILES["proPic"]["size"] > 1000*1024)
        {
            $conn = null;
            die("c");   //l'immagine non può occupare più di 1000byte
        }

        $successo = false;

        $pathDestinazione =  "immagini/proPics/" . $IDutente . "." . $fileType;

        if(file_exists("immagini/proPics/" . $IDutente . ".png"))
            unlink("immagini/proPics/" . $IDutente . ".png");

        if(file_exists("immagini/proPics/" . $IDutente . ".jpg"))
            unlink("immagini/proPics/" . $IDutente . ".jpg"); 

        if(file_exists("immagini/proPics/" . $IDutente . ".jpeg"))
            unlink("immagini/proPics/" . $IDutente . ".jpeg"); 

        if(move_uploaded_file($_FILES["proPic"]["tmp_name"], $pathDestinazione)){
            $img = $IDutente . "." . $fileType;

            $stmt = ("UPDATE utente SET proPic = '$img' WHERE IDutente = '$IDutente'");
            $conn->exec($stmt);
        }

    }

    if(isset($_POST["defaultProPic"]))
    {
        if(file_exists("immagini/proPics/" . $IDutente . ".png"))
            unlink("immagini/proPics/" . $IDutente . ".png");

        if(file_exists("immagini/proPics/" . $IDutente . ".jpg"))
            unlink("immagini/proPics/" . $IDutente . ".jpg"); 

        if(file_exists("immagini/proPics/" . $IDutente . ".jpeg"))
            unlink("immagini/proPics/" . $IDutente . ".jpeg"); 

        $stmt = $conn -> prepare("UPDATE utente SET proPic = 'default.png' WHERE IDutente = '$IDutente'");
        $stmt->execute();
    }
}

?>