<?php
    try
    {
        session_start();
        $IDutente = $_SESSION["sessioneUtente"];

        $IDblogCoautore = $_POST["IDblogCoautore"];
        $userCoautore = $_POST["userCoautore"];

        include("scriptPrevenzione.php");
        controlloTokenInput($userCoautore);

        $userCoautore = addslashes($userCoautore);

        include("dbconnection.php");
        $stmt = $conn -> prepare("SELECT IDutente FROM utente WHERE username = :userCoautore");
        $stmt->bindParam(':userCoautore', $userCoautore);
        $stmt->execute();
        $row = $stmt->fetch();

        if($row){
            //esiste un utente con lo username inserito dall'utente
            $IDcoautore = $row["IDutente"];

            if($IDutente == $IDcoautore){ //l'utente sta cercando di nominare coautore sè stesso
                $conn = null;
                die("Non puoi nominare te stesso coautore");
            }

            $stmt = $conn -> prepare("SELECT IDautore FROM coautore WHERE IDautore = '$IDcoautore' and IDblog = '$IDblogCoautore'");
            $stmt->execute();
            $row = $stmt->fetch();

            if($row) //l'utente che si sta inserendo, era già coautore
            {
                $conn = null;
                die("L'utente è già coautore del blog");
            }

            //controllo se il blog è vietato ai minori
            $q = ("SELECT limiteEta FROM blog WHERE IDblog = '$IDblogCoautore'");
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            if($result["limiteEta"] == 1)
            {
                //controllo che l'utente non sia minorenne
                $q = ("SELECT dataNascita FROM utente WHERE IDutente = '$IDcoautore'");
                $sth = $conn->query($q);
                $resultData = $sth->fetch(PDO::FETCH_ASSOC);

                $dataNascita = $resultData["dataNascita"];
                $dataNascita = explode("-", $dataNascita);
                $eta = (date("md", date("U", mktime(0, 0, 0, $dataNascita[2], $dataNascita[1], $dataNascita[0]))) > date("md") ? ((date("Y") - $dataNascita[0]) - 1) : (date("Y") - $dataNascita[0]));

                if($eta < 18)
                {
                    $conn = null;
                    die("L'utente è minorenne. Non può essere coautore di un blog vietato ai minori.");
                }
            }

            //INSERISCO IL COAUTORE
            $stmt = $conn -> prepare("INSERT INTO coautore(IDautore, IDblog) VALUES (:IDcoautore, :IDblogCoautore)");

            $stmt -> bindParam(":IDcoautore", $IDcoautore);
            $stmt -> bindParam(":IDblogCoautore", $IDblogCoautore);

            $stmt->execute();

            $conn = null;
            die("ok");
        }
        else{
            $conn = null;
            die("Non esiste nessun utente con questo username");
        }
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }

?>