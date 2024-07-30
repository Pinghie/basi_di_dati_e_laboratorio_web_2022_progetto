<?php
    try
    {
        $IDcoautore = $_POST["IDcoautore"];
        $IDblogCoautore = $_POST["IDblogCoautore"];

        include("dbconnection.php");
        $stmt = ("DELETE FROM coautore WHERE IDblog = '$IDblogCoautore' and IDautore = '$IDcoautore'");
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