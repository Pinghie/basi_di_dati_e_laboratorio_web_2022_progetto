<?php
    include("dbconnection.php");

    $limit = 4;

    if (isset($_GET["page"]))
        $page = $_GET["page"]; 
    else 
        $page=1; 

    $inizio = ($page-1)*$limit;

    function creaImpaginazione($nRisultati)
    {
        global $limit, $page;
        $nPagine = ceil($nRisultati/$limit);
        
        echo "<div id='indicePagineContainer'>";
        if($nPagine>1)
        {
            for($i = 1; $i <= $nPagine; $i++)
            {
                if($i  == $page)
                {
                    echo "<b><a href='scriptRicerca.php?page=" . $i ."'>". $i . "</a></b>"; 
                }
                else
                {
                    echo "<a href='scriptRicerca.php?page=" . $i ."'>". $i . "</a>"; 
                }
            }
        }
        echo "</div> <br>"; //chiudo indicePagineContainer
    }
    
    $filtro = $_GET["filtro"];

    if(!empty($_GET["testo"]))
    {
        $campoRicerca = $_GET["testo"];
        $arrayTokenInput = explode(" ", strtolower($campoRicerca));
        $vietate = ["select", "insert", "update", "delete", "drop", "alter", "--"];
        $intersezione = array_intersect($arrayTokenInput, $vietate);
        if(count($intersezione)>0)
            die("Ricerca non valida. Tentativo di SQL Injection.");//è stato rilevato un tentativo di injection
        
        if($filtro=="Blog")
        {
            $q = "SELECT COUNT(*) FROM blog WHERE titolo LIKE '%$campoRicerca%' and archiviato = 0";
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $nRisultati = $result["COUNT(*)"];
            creaImpaginazione($nRisultati);
            
            $q = "SELECT b.IDblog, b.titolo, b.data, b.immagine, u.username FROM blog b, autore a, utente u WHERE b.IDblog = a.IDblog and a.IDutente = u.IDutente and b.archiviato = 0 and b.titolo LIKE '%$campoRicerca%' LIMIT $inizio, $limit";
            $sth = $conn->query($q);

            if($row = $sth->fetch(PDO::FETCH_ASSOC))
            {        
                do
                {
                    echo "<div class='cardBlog'>";
                    echo "<div class='blogImg'><img src='immagini/blogPics/" . $row["immagine"] . "'/></div>";
                    echo "<p class='blogAutore'><a href='paginaUtente.php?username=" . $row["username"] . "'>".$row["username"]." </a></p> 
                    <p class='blogTitle'>" . stripslashes($row["titolo"]) . "</p> <p class='blogData'>" . $row["data"] . "</p>";
        ?>
            
            <button class="button-17" onclick="window.location.href='blog.php?IDblog=<?php echo $row["IDblog"] ?>';">Vai al Blog</button> 
                    <?php echo "</div>"; ?><br>

        <?php
                }while($row = $sth->fetch(PDO::FETCH_ASSOC));     
            }
            else
            {
                echo"<p class='littleP boldP'> La ricerca non ha prodotto risultati </p>";
            }
        }
        
        else if($filtro=="Post")
        {
            $q = "SELECT COUNT(*) FROM post p, blog b WHERE b.IDblog = p.IDblog and b.archiviato = 0 and p.titolo LIKE '%$campoRicerca%'";
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $nRisultati = $result["COUNT(*)"];
            creaImpaginazione($nRisultati);
            
            $q = "SELECT p.IDpost, p.titolo as titoloPost, p.data, p.immagine, b.IDblog, b.titolo as titoloBlog FROM post p, blog b WHERE p.IDblog = b.IDblog and b.archiviato = 0 and p.titolo LIKE '%$campoRicerca%' LIMIT $inizio, $limit";
            $sth = $conn->query($q);

            if($row = $sth->fetch(PDO::FETCH_ASSOC))
            {
                do
                {
                    echo "<div class='cardBlog'>";
                    
                    echo "<div class='blogImg'><img src='immagini/postPics/" . $row["immagine"] . "'></div>";
                    
                    echo "<p class='blogAutore'><a href='blog.php?IDblog=" . $row["IDblog"] . "'>". stripslashes($row["titoloBlog"])." </a></p> ";
                    
                    echo "<p class='blogTitle'>" . stripslashes($row["titoloPost"]) . "</p> <p class='blogData'>" . $row["data"] . "</p>";
            ?>
                <button class="button-17" onclick="window.location.href='post.php?IDpost=<?php echo $row["IDpost"] ?>';">Vai al Post</button> 
                    <?php echo "</div>"; ?><br>

            <?php
                    }while($row = $sth->fetch(PDO::FETCH_ASSOC));     
            }
            else
            {
                echo"<p class='littleP boldP'> La ricerca non ha prodotto risultati </p>";
            }
        }
        
        else if($filtro=="Utente")
        {
            $q = "SELECT COUNT(*) FROM utente WHERE username LIKE '%$campoRicerca%'";
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $nRisultati = $result["COUNT(*)"];
            creaImpaginazione($nRisultati);
            
            $q = "SELECT IDutente, username, proPic FROM utente WHERE username LIKE '%$campoRicerca%' LIMIT $inizio, $limit";
            $sth = $conn->query($q);

            if($row = $sth->fetch(PDO::FETCH_ASSOC))
            {
                do
                {
                    echo "<div class='cardBlog'>";
                    
                    echo "<div class='blogImg'><img src='immagini/proPics/" . $row["proPic"] . "'></div>";
                    
                    echo "<p class='blogTitle'>" . $row["username"] . "</p> <br>";
                    
        ?>
                <button class="button-17" onclick="window.location.href='paginaUtente.php?username=<?php echo $row["username"] ?>';">Vai al profilo</button> 
                    <?php echo "</div>"; ?><br>

        <?php
                   

                }while($row = $sth->fetch(PDO::FETCH_ASSOC));     
            }
            else
            {
                echo"<p class='littleP boldP'> La ricerca non ha prodotto risultati </p>";
            }
        }
        
        else if($filtro=="Categoria")
        {
            $q = "SELECT COUNT(DISTINCT b.IDblog) FROM blog b, temiblog tb, sottotema st, tema t WHERE tb.IDblog = b.IDblog and st.IDsottotema = tb.IDtema and b.archiviato = 0 and t.IDtema = st.macrotema and (st.sottotema LIKE '%$campoRicerca%' OR t.tema LIKE '%$campoRicerca%')";
            $sth = $conn->query($q);
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            $nRisultati = $result["COUNT(DISTINCT b.IDblog)"];
            creaImpaginazione($nRisultati);
            
            $q = "SELECT DISTINCT b.IDblog, titolo, data, immagine FROM blog b, temiblog tb, sottotema st, tema t WHERE tb.IDblog = b.IDblog and b.archiviato=0 and st.IDsottotema = tb.IDtema and t.IDtema = st.macrotema and (st.sottotema LIKE '%$campoRicerca%' OR t.tema LIKE '%$campoRicerca%') LIMIT $inizio, $limit";
            $sth = $conn->query($q);

            if($row = $sth->fetch(PDO::FETCH_ASSOC))
            {
                do
                {
                    $IDblog = $row['IDblog'];
                    
                    echo "<div class='cardBlog'>";
                    echo "<div class='blogImg'><img src='immagini/blogPics/" . $row["immagine"] . "'></div>";
                    echo "<p class='blogTitle'>" . stripslashes($row["titolo"]) . "</p> <p class='blogData'>" . $row["data"] . "</p>";

                    //stampo i temi del blog
                    $q2 = ("SELECT t.IDtema, t.tema, st.sottotema FROM temiblog as tb, sottotema as st, tema as t WHERE tb.IDtema = st.IDsottotema and st.macrotema = t.IDtema and tb.IDblog = '$IDblog' ORDER BY t.tema");
                    $sth2 = $conn->query($q2);

                    if($row2 = $sth2->fetch(PDO::FETCH_ASSOC))
                    {
                        $lastTema = 0;
                        do
                        {
                            if($lastTema != $row2["IDtema"]){

                                echo "<br>Tema: <b>" . $row2["tema"] . "</b><br>";
                            }
                            $lastTema = $row2["IDtema"];
                            echo $row2["sottotema"] . "<br>";

                        }while($row2 = $sth2->fetch(PDO::FETCH_ASSOC));
                    }
                ?><br>
                    <button class="button-17" onclick="window.location.href='blog.php?IDblog=<?php echo $row["IDblog"] ?>';">Vai al Blog</button> 
                    <?php echo "</div>"; ?><br>
                    
                <?php    
                    

                }while($row = $sth->fetch(PDO::FETCH_ASSOC));     
            }
            else
            {
                echo"<p class='littleP boldP'> La ricerca non ha prodotto risultati </p>";
            }
        }
    }
?>