<?php
    try
    {
        session_start();
        $IDutente = $_SESSION["sessioneUtente"];
        $IDcommento = key($_POST);

        include("dbconnection.php");
        $q = ("SELECT IDutente FROM likes WHERE IDcommento = '$IDcommento' and IDutente = '$IDutente'");
        $result = $conn->query($q);
        $row = $result->fetch();

        if($row){
            $stmt = ("UPDATE commento SET numLike = numLike - 1 WHERE IDcommento = '$IDcommento'");
            $conn->exec($stmt);

            $stmt = ("DELETE FROM likes WHERE IDcommento = '$IDcommento' and IDutente = '$IDutente'");
            $conn->exec($stmt);

            $conn = null;
            die("dislike");
            //Hai già messo like al commento
        }
        else{
            $stmt = ("UPDATE commento SET numLike = numLike + 1 WHERE IDcommento = '$IDcommento'");
            $conn->exec($stmt);

            $stmt = ("INSERT INTO likes(IDutente, IDcommento) VALUES ('$IDutente', '$IDcommento')");
            $conn->exec($stmt);
            $conn = null;
            die("like");
        }
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }
?>