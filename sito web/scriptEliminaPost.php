<?php
    try
    {
        $IDpost = $_POST["IDpostElimina"];
        $IDblog = $_POST["IDblogElimina"];      

        include("dbconnection.php");
        $q = "SELECT immagine FROM post WHERE IDpost='$IDpost'";
        $result = $conn->query($q);
        $row = $result->fetch();

        if($row["immagine"]!="default.png")
            unlink("immagini/postPics/" . $row["immagine"]);

        $stmt = ("DELETE FROM post WHERE IDpost = '$IDpost'");
        $conn->exec($stmt);

        $stmt = ("UPDATE blog SET numPost = numPost - 1 WHERE IDblog = '$IDblog'");
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