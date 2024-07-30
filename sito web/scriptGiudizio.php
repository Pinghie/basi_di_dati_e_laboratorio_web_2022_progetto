<?php
    try
    {
        session_start();
        $IDutente = $_SESSION["sessioneUtente"];

        $valoreGiudizio = $_POST["valoreGiudizio"];
        $IDpost = $_POST["IDpost"];

        include("dbconnection.php");
        $q = ("SELECT IDutente FROM giudizio WHERE IDutente = '$IDutente' and IDpost = '$IDpost'");
        $result = $conn->query($q);
        $row = $result->fetch();

        if($row)
        {
            $stmt =("UPDATE giudizio SET voto = '$valoreGiudizio' WHERE IDutente = '$IDutente' and IDpost = '$IDpost'");
            $conn->exec($stmt);
        }
        else
        {
            $stmt = ("INSERT INTO giudizio(IDutente, IDpost, voto) VALUES ('$IDutente', '$IDpost', '$valoreGiudizio')");
            $conn->exec($stmt);
        }

        $q = ("SELECT AVG(voto) FROM giudizio WHERE IDpost = '$IDpost'");
        $result = $conn->query($q);
        $row = $result->fetch();

        $media = $row[0];

        $stmt = ("UPDATE post SET mediaGiudizio = '$media' WHERE IDpost = '$IDpost'");
        $conn->exec($stmt);
        
        $conn = null;
        die($media);
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }
?>