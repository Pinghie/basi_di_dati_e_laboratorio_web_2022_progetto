<?php
    try
    {
        session_start();
        $IDutente = $_SESSION["sessioneUtente"];    

        include("dbconnection.php");

        //elimino le immagini dei blog dell'utente
        $q = ("SELECT IDblog FROM autore WHERE IDutente = '$IDutente'");
        $sth = $conn->query($q);

        while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $IDblog = $row['IDblog'];

            $q2 = ("SELECT immagine FROM blog WHERE IDblog = '$IDblog'");
            $sth2 = $conn->query($q2);
            $result2 = $sth2->fetch(PDO::FETCH_ASSOC);

            if($result2)
                if($result2["immagine"]!="default.png")
                    unlink("immagini/blogPics/" . $result2["immagine"]);

            //elimino le immagini dei post dei blog dell'utente
            $q4 = ("SELECT immagine FROM post WHERE IDblog = '$IDblog'");
            $sth4 = $conn->query($q4);

            while($row4 = $sth4->fetch(PDO::FETCH_ASSOC))
            {
                if($row4)
                    if($row4["immagine"]!="default.png")
                        unlink("immagini/postPics/" . $row4["immagine"]);
            }

            $stmt = "DELETE FROM blog WHERE IDblog = '$IDblog'";
            $conn->exec($stmt);
        }

        //elimino l'immagine dell'utente
        $q = ("SELECT proPic FROM utente WHERE IDutente = '$IDutente'");
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);

        if($result)
            if($result["proPic"]!="default.png")
                unlink("immagini/proPics/" . $result["proPic"]);

        $stmt = "DELETE FROM utente WHERE IDutente = '$IDutente'";    
        $conn->exec($stmt);

        unset($_SESSION["sessioneUtente"]);
        unset($_SESSION["nomeUtente"]);
        if (session_destroy())
        {
            $conn = null;
            die("ok");  
        }
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }

?>