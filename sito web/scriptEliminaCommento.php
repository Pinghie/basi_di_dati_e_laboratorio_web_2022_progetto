<?php
    try
    {
        $IDcommento = $_POST["IDcommento"];
        $IDpost = $_POST["IDpost"];      

        include("dbconnection.php");

        $stmt = ("DELETE FROM commento WHERE IDcommento = '$IDcommento'");
        $conn->exec($stmt);

        $stmt = ("UPDATE post SET numCommenti = numCommenti - 1 WHERE IDpost = '$IDpost'");
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