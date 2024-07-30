<?php
    try
    {
        session_start();
        $IDutente = $_SESSION["sessioneUtente"];

        $IDblog = key($_POST);
        $dataIscrizione = date("Y-m-d");

        include("dbconnection.php");
        $q =("SELECT IDutente FROM iscritto WHERE IDblog = '$IDblog' and IDutente = '$IDutente'");
        $result = $conn->query($q);
        $row = $result->fetch();

        if($row){
            $stmt = "UPDATE blog SET numIscritti = numIscritti - 1 WHERE IDblog = '$IDblog'";
            $conn->exec($stmt);

            $stmt = ("DELETE FROM iscritto WHERE IDblog = '$IDblog' and IDutente = '$IDutente'");
            $conn->exec($stmt);

            $conn = null;
            die("disiscritto");
        }
        else{
            $stmt = "UPDATE blog SET numIscritti = numIscritti + 1 WHERE IDblog = '$IDblog'";
            $conn->exec($stmt);

            $stmt = ("INSERT INTO iscritto(IDutente, IDblog, dataIscrizione) VALUES ('$IDutente', '$IDblog', '$dataIscrizione')");
            $conn->exec($stmt);
            
            $conn = null;
            die("iscritto");
        }
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }

?>