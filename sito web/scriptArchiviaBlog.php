<?php
    try
    {
        $IDblog = $_POST["IDblog"];

        include("dbconnection.php");
        $q = "SELECT archiviato FROM blog WHERE IDblog = '$IDblog'";
        $sth = $conn->query($q);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $archiviato = $result["archiviato"];

        if($archiviato == 0){
            $stmt = $conn -> prepare("UPDATE blog SET archiviato = 1 WHERE IDblog = '$IDblog'");
            $stmt->execute();  
        }
        else{
            $stmt = $conn -> prepare("UPDATE blog SET archiviato = 0 WHERE IDblog = '$IDblog'");
            $stmt->execute();  
        }

        $conn = null;
        die("ok");
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }

?>