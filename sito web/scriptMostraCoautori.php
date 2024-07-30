<?php
    try
    {
        if(!isset($_GET["IDblog"]))
            die();
        $IDblog = $_GET["IDblog"];

        include("dbconnection.php");

        $q = "SELECT titolo FROM blog WHERE IDblog = '$IDblog'";
        $sth = $conn->query($q);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $titoloBlog = stripslashes($result["titolo"]);

        $q = "SELECT u.IDutente, u.username FROM coautore c, utente u WHERE c.IDblog = '$IDblog' AND c.IDautore = u.IDutente";
        $sth = $conn->query($q);

        echo "<h2 style='text-align:center;'>Gestione coautori</h2> <h3 style='margin:1%'> " . $titoloBlog . "</h3>";
        while($row = $sth->fetch(PDO::FETCH_ASSOC))
        {
            echo "<div style='display:flex;'>
                    <p style='font-size:1em; font-weight: 500; display:flex; margin:2% 1% 0% 0%;'>" . $row["username"] . "</p>
                    <p class='rimuoviCoautore' id='" . $row["IDutente"] ."' style='display:flex; margin:2% 0% 0% 0%;'>
                        <i class='fa fa-trash' aria-hidden='true'></i>
                    </p>
                </div>";
        }
    }
    catch(PDOException $e)
    {
        die("Errore nel caricamento dei coautori");
    }

?>