<?php
    try
    {
        $IDblog = key($_POST);

        include("dbconnection.php");
        //elimino l'immagine del blog dal server
        $q = "SELECT immagine FROM blog WHERE IDblog='$IDblog'";
        $result = $conn->query($q);
        $row = $result->fetch();

        if($row["immagine"]!="default.png")
            unlink("immagini/blogPics/" . $row["immagine"]);

        //elimino le immagini dei post del blog dal server
        $q = ("SELECT IDpost, immagine FROM post WHERE IDblog = '$IDblog'");
        $sth = $conn->query($q);

        while($row = $sth->fetch(PDO::FETCH_ASSOC))
        {
            if($row["immagine"]!="default.png")
                unlink("immagini/postPics/" . $row["immagine"]);
        }

        $stmt = $conn -> prepare("DELETE FROM blog WHERE IDblog = '$IDblog'");
        $stmt->execute();

        $conn = null;
        die("ok");
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }
?>