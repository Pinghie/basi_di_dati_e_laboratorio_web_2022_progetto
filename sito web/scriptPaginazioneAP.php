<?php
    if(!isset($_GET["utente"]))
        die();

    $IDutente = $_GET["utente"];

    $limit = 4;
    
    include("dbconnection.php");

    $q = ("SELECT abbonato FROM utente WHERE IDutente = '$IDutente'");
    $sth = $conn->query($q);
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    $abbonato = $result["abbonato"];

    if(isset($_GET["pageBlog"]))
    {
        try
        {
            $page = $_GET["pageBlog"]; 
            $q = "SELECT COUNT(*) FROM blog as b, autore as a WHERE a.IDutente = '$IDutente' and a.IDblog = b.IDblog and b.archiviato = 0";
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $nRisultati = $result["COUNT(*)"];
            $nPagine = ceil($nRisultati/$limit);

            echo "<h1 style='margin-bottom:1%'>I miei blog</h1>";

            if($nRisultati >=5 and $abbonato==0)
            {
                echo "<div class='post' style='background-color: lightGray; padding:1%;'>
                        <h2 id='limiteBlog' class='boldP'>Non puoi creare più di cinque blog! Se vuoi crearne un numero illimitato, <a href='abbonamento.php'>passa a premium</a>.</h2>
                    </div>";
            }

            if($nRisultati<1)
                 echo "<div class='post' style='background-color: lightGray; padding:1%;'><h2>Non hai ancora creato blog.</h2></div>";
            else
            {
                echo "<br><div class='postContainer'><div class='post'>";
                echo "<div id='indicePagineContainerMieiBlog' style='width: 100%; text-align: left;'>";
                if($nPagine>1)
                {
                    for($i = 1; $i <= $nPagine; $i++)
                        {
                            if($i  == $page)
                                echo "<b><a href='scriptPaginazioneAP.php?pageBlog=" . $i ."'>". $i . "</a></b>"; 
                            else
                                echo "<a href='scriptPaginazioneAP.php?pageBlog=" . $i ."'>". $i . "</a>"; 
                        }
                }
                echo "</div>"; //chiudo indicePagineContainer

                $inizio = ($page-1)*$limit;
                $q = ("SELECT titolo, data, immagine, a.IDblog FROM blog as b, autore as a WHERE a.IDutente = '$IDutente' and a.IDblog = b.IDblog and b.archiviato = 0 ORDER BY IDblog DESC LIMIT $inizio, $limit");
                $sth = $conn->query($q);

                while($row = $sth->fetch(PDO::FETCH_ASSOC))
                {
                    echo"<div id='containerBlogCards' class='cardBlog' style='display: inline-block'>";
                        echo "<div class='blogImg'><img src='immagini/blogPics/" . $row["immagine"] . "'></div><p class='blogTitle' style='padding-top: 3%;'>".
                            stripslashes($row["titolo"]) . "</p><p class='blogData'>" . $row["data"] . "</p>";
                        ?>
                    <button class="button-17" onclick="window.location.href='blog.php?IDblog=<?php echo $row["IDblog"] ?>';">Vai al Blog</button> 
                    <div class='containerBottoni' id="<?php echo $row["IDblog"] ?>">

                        <p style="display:inline-block; margin:10% 5% 5% 5%" class="elimina"><i class='fa fa-trash' aria-hidden='true'></i></p>
                        <p style="display:inline-block; margin:10% 5% 5% 5%" class="modifica"><i class='fa fa-pencil' aria-hidden='true'></i></p>
                        <p style="display:inline-block; margin:10% 5% 5% 5%" class="archivia" alt="archivia"><i class="fa fa-archive" aria-hidden='true'></i></p> 
                        <p class="coautore" style="display:inline-block; margin:10% 5% 5% 5%"><i class="fa fa-user-plus" aria-hidden="true"></i></p>
                    </div>
                </div>
              <?php          
                } //chiudo while
            } //chiudo else
            echo"</div></div>";
        }
        catch(PDOException $e)
        {
            echo "<p style='text-align: center; color: red'>Errore nel caricamento dei tuoi blog</p>";
        }

    }
    else if(isset($_GET["pageIscritto"]))
    {
        try
        {
            $page = $_GET["pageIscritto"]; 
            $q = "SELECT COUNT(*) FROM blog as b, iscritto as i WHERE i.IDutente = '$IDutente' and i.IDblog = b.IDblog and b.archiviato = 0";
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $nRisultati = $result["COUNT(*)"];
            $nPagine = ceil($nRisultati/$limit);

            if($nRisultati>0){
                echo "<h1>I blog ai quali sono iscritto</h1>";
                echo "<div class='postContainer'><div class='post'>";
                echo "<div id='indicePagineContainerIscritto' style='width: 100%; text-align: left;'>";
                if($nPagine>1)
                {
                    for($i = 1; $i <= $nPagine; $i++)
                        {
                            if($i  == $page)
                                echo "<b><a href='scriptPaginazioneAP.php?pageIscritto=" . $i ."'>". $i . "</a></b>"; 
                            else
                                echo "<a href='scriptPaginazioneAP.php?pageIscritto=" . $i ."'>". $i . "</a>"; 
                        }
                }
                echo "</div>"; //chiudo indicePagineContainer

                $inizio = ($page-1)*$limit;
                $q = ("SELECT titolo, data, immagine, i.IDblog FROM blog as b, iscritto as i WHERE i.IDutente = '$IDutente' and i.IDblog = b.IDblog and b.archiviato = 0 ORDER BY b.IDblog DESC LIMIT $inizio, $limit");
                $sth = $conn->query($q);

                while($row = $sth->fetch(PDO::FETCH_ASSOC))
                {
                    echo"<div id='containerBlogCards' class='cardBlog' style='display: inline-block'>";
                    echo "<div class='blogImg'> <img src='immagini/blogPics/" . $row["immagine"] . "' alt='immagine blog'></div><p class='blogTitle' style='padding-top: 3%;'>" . stripslashes($row["titolo"]) . "</p><p class='blogData'>" . $row["data"] . "</p>";

                ?>

                <button class="button-17" onclick="window.location.href='blog.php?IDblog=<?php echo $row["IDblog"] ?>';">Vai al Blog</button> 
                </div>
                <?php
                }
                echo"</div></div>";
            }
        }
        catch(PDOException $e)
        {
            echo "<p style='text-align: center; color: red'>Errore nel caricamento dei blog ai quali sei iscritto</p>";
        }

    }
    else if(isset($_GET["pageCoautore"]))
    {
        try
        {
            $page = $_GET["pageCoautore"]; 
            $q = "SELECT COUNT(*) FROM blog as b, coautore as c WHERE c.IDautore = '$IDutente' and c.IDblog = b.IDblog and b.archiviato = 0";
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $nRisultati = $result["COUNT(*)"];
            $nPagine = ceil($nRisultati/$limit);

            if($nRisultati>0){
                echo "<h1>I blog dei quali sono coautore </h1>";
                echo "<div class='postContainer'><div class='post'>";
                echo "<div id='indicePagineContainerCoautore' style='width: 100%; text-align: left;'>";
                if($nPagine>1)
                {
                    for($i = 1; $i <= $nPagine; $i++)
                        {
                            if($i  == $page)
                                echo "<b><a href='scriptPaginazioneAP.php?pageCoautore=" . $i ."'>". $i . "</a></b>"; 
                            else
                                echo "<a href='scriptPaginazioneAP.php?pageCoautore=" . $i ."'>". $i . "</a>"; 
                        }
                }
                echo "</div>"; //chiudo indicePagineContainer

                $inizio = ($page-1)*$limit;
                $q = ("SELECT titolo, data, immagine, c.IDblog FROM blog as b, coautore as c WHERE c.IDautore = '$IDutente' and c.IDblog = b.IDblog and b.archiviato = 0 ORDER BY b.IDblog DESC LIMIT $inizio, $limit");
                $sth = $conn->query($q);

                while($row = $sth->fetch(PDO::FETCH_ASSOC))
                {    echo"<div id='containerBlogCards' class='cardBlog' style='display: inline-block'>";
                    echo "<div class='blogImg'> <img src='immagini/blogPics/" . $row["immagine"] . "' alt='immagine blog'></div><p class='blogTitle' style='padding-top: 3%;'>" . stripslashes($row["titolo"]) . "</p><p class='blogData'>" . $row["data"] . "</p>";

                 ?>
                    <button class="button-17" onclick="window.location.href='blog.php?IDblog=<?php echo $row["IDblog"] ?>';">Vai al Blog</button> 
                <?php

                    echo "</div>";
                }
                echo"</div></div>";
            }
        }
        catch(PDOException $e)
        {
            echo "<p style='text-align: center; color: red'>Errore nel caricamento dei blog dei quali sei coautore</p>";
        }
        
    }
    else if(isset($_GET["pageArchiviato"]))
    {
        try
        {
            $page = $_GET["pageArchiviato"]; 
            $q = "SELECT COUNT(*) FROM blog as b, autore as a WHERE a.IDutente = '$IDutente' and a.IDblog = b.IDblog and b.archiviato = 1";
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $nRisultati = $result["COUNT(*)"];
            $nPagine = ceil($nRisultati/$limit);

            if($nRisultati>0){
                echo "<h1>I miei blog archiviati </h1>";
                echo "<div class='postContainer'><div class='post'>";
                echo "<div id='indicePagineContainerArchiviato' style='width: 100%; text-align: left;'>";
                if($nPagine>1)
                {
                    for($i = 1; $i <= $nPagine; $i++)
                        {
                            if($i  == $page)
                                echo "<b><a href='scriptPaginazioneAP.php?pageArchiviato=" . $i ."'>". $i . "</a></b>"; 
                            else
                                echo "<a href='scriptPaginazioneAP.php?pageArchiviato=" . $i ."'>". $i . "</a>"; 
                        }
                }
                echo "</div>"; //chiudo indicePagineContainer

                $inizio = ($page-1)*$limit;
                $q = ("SELECT titolo, data, immagine, a.IDblog FROM blog as b, autore as a WHERE a.IDutente = '$IDutente' and a.IDblog = b.IDblog and b.archiviato = 1 ORDER BY b.IDblog DESC LIMIT $inizio, $limit");
                $sth = $conn->query($q);

                while($row = $sth->fetch(PDO::FETCH_ASSOC))
                {
                        echo"<div id='containerBlogCards' class='cardBlog' style='display: inline-block'>";
                            echo "<div class='blogImg'><img src='immagini/blogPics/" . $row["immagine"] . "'></div><p class='blogTitle' style='padding-top: 3%;'>".
                                stripslashes($row["titolo"]) . "</p><p class='blogData'>" . $row["data"]. "</p>";
                            ?>

                        <button class="button-17" onclick="window.location.href='blog.php?IDblog=<?php echo $row["IDblog"] ?>';">Vai al Blog</button> 

                        <div id="<?php echo $row["IDblog"] ?>">
                            <p style="display:inline-block; margin:10% 5% 5% 5%" class="disarchivia" alt="disarchivia"><i class="fa fa-archive" aria-hidden='true'></i></p> 
                        </div>

                  <?php       
                    echo"</div>";
                }
                echo"</div></div>";
            }
        }
        catch(PDOException $e)
        {
            echo "<p style='text-align: center; color: red'>Errore nel caricamento dei blog archiviati</p>";
        }
    }
?>
 

