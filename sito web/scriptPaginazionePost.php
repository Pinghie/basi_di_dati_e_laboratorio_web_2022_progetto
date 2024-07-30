<?php
    try
    {
        $limit = 4;

        if (isset($_GET["page"]))
            $page = $_GET["page"]; 
        else 
            $page=1;

        if (isset($_GET["IDblog"]))
            $IDblog = $_GET["IDblog"]; 

        include("dbconnection.php");

        //PAGINAZIONE POST
            $q = "SELECT COUNT(*) FROM post as p WHERE p.IDblog = '$IDblog'";
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $nRisultati = $result["COUNT(*)"];
            $nPagine = ceil($nRisultati/$limit);

            echo "<div id='indicePagineContainer'>";
            if($nPagine>1)
            {
                for($i = 1; $i <= $nPagine; $i++)
                    {
                        if($i  == $page)
                        {
                            echo "<b><a href='scriptPaginazionePost.php?page=" . $i ."'>". $i . "</a></b>"; 
                        }
                        else
                        {
                            echo "<a href='scriptPaginazionePost.php?page=" . $i ."'>". $i . "</a>"; 
                        }
                    }
            }
            echo "</div>"; //chiudo indicePagineContainer

        session_start();
        $sessione = false;
        if(isset($_SESSION["sessioneUtente"]))
        {
            $IDutente = $_SESSION["sessioneUtente"];
            $sessione = true;
        }

        $q = ("SELECT IDutente FROM autore WHERE IDblog = '$IDblog'");
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $IDautore = $result["IDutente"];

        if($sessione==true)
            {
                $q = ("SELECT IDautore FROM coautore WHERE IDblog = '$IDblog' and IDautore = '$IDutente'");
                $sth = $conn->query($q);
                $result = $sth->fetch(PDO::FETCH_ASSOC);

                if($IDautore == $_SESSION["sessioneUtente"])
                    $tipoUtente = "proprietario";

                else if($result)
                    $tipoUtente = "coautore";

                else
                    $tipoUtente = "registrato";
            }
            else
                $tipoUtente = "visitatore";

        $inizio = ($page-1)*$limit;
        $q = "SELECT titolo, sottotitolo, data, immagine, IDpost, username FROM post as p, utente as u WHERE IDblog = '$IDblog' and p.IDutente = u.IDutente ORDER BY IDpost DESC LIMIT $inizio, $limit";
        $sth = $conn->query($q);

        while($row = $sth->fetch(PDO::FETCH_ASSOC))
        {
                echo "<div class='cardBlog'> 
                <div class='blogImg'>
                    <img src='immagini/postPics/" . $row["immagine"] . "' alt='immagine post'>
                </div>
                <p class='blogData' style='padding: 2% 0 0 0'>" . $row["data"] . " </p>
                <p class='blogTitle'>" . stripslashes($row["titolo"]) . "</p>
                <p class='blogSubtitle'>" . stripslashes($row["sottotitolo"]). " </p>
                <p style='margin:0'>di <a class='blogAutore' href='paginaUtente.php?username=". $row["username"] . "'>" 
                . $row["username"] . "</a></p>";
                ?>

                <br>
                <button class="button-17" onClick="location.href='post.php?IDpost=<?php echo $row["IDpost"] ?>'">Vai al Post</button>
                <?php
        if($sessione)
        {
            if($tipoUtente == "proprietario" || ($tipoUtente == "coautore" && $_SESSION["nomeUtente"] == $row["username"]))
            {

            echo "<div class='containerBottoni'>";
                echo "<p style='display:inline-block; margin:10% 5% 5% 5%' class='elimina' id='" . $row["IDpost"] . "'><i class='fa fa-trash' aria-hidden='true'></i></p>";
                echo "<p style='display:inline-block; margin:10% 5% 5% 5%' class='modifica' id='" . $row["IDpost"] . "'><i class='fa fa-pencil' aria-hidden='true'></i></p>";
            echo "</div>";
            }
        echo "</div>";
        }



        echo "</div><br>";
        }
    }
    catch(PDOException $e)
    {
        echo "<p style='text-align: center; color: red'>Errore nel caricamento dei post</p>";
    }

?>