<?php
    if(!isset($_GET["username"]))
        die();

    $usernameUtente = $_GET["username"];

    $limit = 4;

    include("dbconnection.php");

    if (isset($_GET["pageAutore"]))
    {
        try
        {
            $page = $_GET["pageAutore"];

            $q = "SELECT COUNT(*) FROM blog b, autore a, utente u WHERE b.IDblog = a.IDblog and u.IDutente = a.IDutente and u.username = '$usernameUtente' and b.archiviato = 0";
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $nRisultati = $result["COUNT(*)"];
            $nPagine = ceil($nRisultati/$limit);

            if($nRisultati>0)
                echo "<h1>Blog che ha creato</h1>";
            else
                 echo "<h3>Questo utente non ha ancora creato blog</h3>";

            echo "<div id='indicePagineContainerAutore'>";
            if($nPagine>1)
            {
                for($i = 1; $i <= $nPagine; $i++)
                    {
                        if($i  == $page)
                        {
                            echo "<b><a href='scriptPaginazioneUtente.php?username=" . $usernameUtente ."&pageAutore=" . $i ."'>". $i . "</a></b>"; 
                        }
                        else
                        {
                            echo "<a href='scriptPaginazioneUtente.php?username=" . $usernameUtente ."&pageAutore=" . $i ."'>". $i . "</a>"; 
                        }
                    }
            }
            echo "</div>"; //chiudo indicePagineContainer

            $inizio = ($page-1)*$limit;
            $q = "SELECT b.titolo, b.data, b.immagine, a.IDblog, u.username FROM blog b, autore a, utente u WHERE b.IDblog = a.IDblog and u.IDutente = a.IDutente and u.username = '$usernameUtente' and b.archiviato = 0 ORDER BY b.IDblog DESC LIMIT $inizio, $limit";
            $sth = $conn->query($q);

            while($row = $sth->fetch(PDO::FETCH_ASSOC))
            {       
                echo "<div class='cardBlog'>";
                echo "<div class='blogImg'><img src='immagini/blogPics/" . $row["immagine"] . "'/></div>";
                echo "<p class='blogAutore'><a href='paginaUtente.php?username=" . $row["username"] . "'>".$row["username"]." </a></p> 
                <p class='blogTitle'>" . stripslashes($row["titolo"]) . "</p> <p class='blogData'>" . $row["data"] . "</p>";
                ?>

                    <button class="button-17" onclick="window.location.href='blog.php?IDblog=<?php echo $row["IDblog"] ?>';">Vai al Blog</button> 
                            <?php echo "</div>"; ?><br>
             <?php   
            }
        }
        catch(PDOException $e)
        {
            echo "<p style='text-align: center; color: red'>Errore nel caricamento dei blog dell'utente</p>";
        }
        
    }
    else if(isset($_GET["pageIscritto"]))
    {
        try
        {
            $page = $_GET["pageIscritto"];

            $q = "SELECT COUNT(*) FROM blog b, iscritto i, utente u WHERE b.IDblog = i.IDblog and u.IDutente = i.IDutente and u.username = '$usernameUtente' and b.archiviato = 0";
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $nRisultati = $result["COUNT(*)"];
            $nPagine = ceil($nRisultati/$limit);

            if($nRisultati>0)
                echo "<h1>Blog a cui è iscritto</h1>";
            else
                 echo "<h3>Questo utente non è iscritto a nessun blog</h3>";

            echo "<div id='indicePagineContainerIscritto'>";
            if($nPagine>1)
            {
                for($i = 1; $i <= $nPagine; $i++)
                    {
                        if($i  == $page)
                        {
                            echo "<b><a href='scriptPaginazioneUtente.php?username=". $usernameUtente ."&pageIscritto=" . $i ."'>". $i . "</a></b>"; 
                        }
                        else
                        {
                            echo "<a href='scriptPaginazioneUtente.php?username=". $usernameUtente ."&pageIscritto=" . $i ."'>". $i . "</a>"; 
                        }
                    }
            }
            echo "</div>"; //chiudo indicePagineContainer

            $inizio = ($page-1)*$limit;
            $q = "SELECT titolo, data, immagine, i.IDblog, u.username FROM blog b, iscritto i, autore a, utente u, utente u1 WHERE i.IDblog = b.IDblog and i.IDutente = u1.IDutente and u1.username = '$usernameUtente' and b.IDblog = a.IDblog and a.IDutente = u.IDutente and b.archiviato = 0 ORDER BY i.dataIscrizione DESC LIMIT $inizio, $limit";
            $sth = $conn->query($q);

            while($row = $sth->fetch(PDO::FETCH_ASSOC))
            {
                echo "<div class='cardBlog'>";
                echo "<div class='blogImg'><img src='immagini/blogPics/" . $row["immagine"] . "' alt='immagine blog'></div>";
                stripslashes($row["titolo"]) . "<br>" . $row["data"];
                echo "<p class='blogAutore'><a href='paginaUtente.php?username=" . $row["username"] . "'>".$row["username"]." </a></p> 
                <p class='blogTitle'>" .stripslashes($row["titolo"]) . "</p> 
                <p class='blogData'>" . $row["data"] . "</p>";

                ?>
                    <button class="button-17" onclick="window.location.href='blog.php?IDblog=<?php echo $row["IDblog"] ?>';">Vai al Blog</button> 
                            <?php echo "</div>"; ?><br>
            <?php
            }
        }
        catch(PDOException $e)
        {
            echo "<p style='text-align: center; color: red'>Errore nel caricamento dei blog ai quali l'utente è iscritto</p>";
        }

    }

                    
?>