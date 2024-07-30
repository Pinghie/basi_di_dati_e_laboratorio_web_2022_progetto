<?php
    try
    {
        include("dbconnection.php");
        
        $username = trim($_POST["username"]);
        $password = trim($_POST["psw"]);

        include("scriptPrevenzione.php");
        controlloTokenInput($username);
        controlloTokenInput($password);

        $password = addslashes($password);

        $q = "SELECT IDutente, username, password FROM utente WHERE username='$username'";
        $result = $conn->query($q);
        $row = $result->fetch();

        if($row){
            //esiste un utente con quel username
            if(password_verify($password, $row["password"])) 
            {
                //username e password corrispondono (login effettuato)
                session_start();
                $_SESSION["sessioneUtente"] = $row["IDutente"];
                $_SESSION["nomeUtente"] = $row["username"];

                $conn = null;
                die("ok");
            }
            else
            {
                //password non corretta
                $conn = null;
                die("2");
            }
        }
        else
            {
            //username non esistente
                $conn = null;
                die("1");
            }
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }

?>