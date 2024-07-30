<?php
    try
    {
        session_start();
        $IDutente = $_SESSION["sessioneUtente"];    

        include("dbconnection.php");
        $stmt = ("UPDATE utente SET abbonato = 0, rinnovoAutomatico = 0 WHERE IDutente = '$IDutente'");
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