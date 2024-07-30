<?php
    try
    {
        session_start();
        $IDutente = $_SESSION["sessioneUtente"];    
        $x = $_POST["x"];

        //modifica la tupla del pagamento dal DB
        include("dbconnection.php");
        $stmt = "UPDATE utente SET rinnovoAutomatico = '$x' WHERE IDutente = '$IDutente'";
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