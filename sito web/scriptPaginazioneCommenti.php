<?php
    try
    {
        $limit = 4;

        if (isset($_GET["page"]))
            $page = $_GET["page"]; 
        else 
            $page=1;

        if (isset($_GET["IDpost"]))
            $IDpost = $_GET["IDpost"];

        include("dbconnection.php");

        $q = "SELECT COUNT(*) FROM commento WHERE IDpost = '$IDpost'";
                $sth = $conn->query($q);
                $result = $sth->fetch(PDO::FETCH_ASSOC);
                $nRisultati = $result["COUNT(*)"];
                $nPagine = ceil($nRisultati/$limit);

                if($nRisultati>0)
                    echo "<h1>Commenti</h1>";
                else
                     echo "<h3>Non sono ancora presenti commenti</h3>";

                echo "<div id='indicePagineContainer'>";
                if($nPagine>1)
                {
                    for($i = 1; $i <= $nPagine; $i++)
                    {
                        if($i  == $page)
                        {
                            echo "<b><a href='scriptPaginazioneCommenti.php?page=" . $i ."'>". $i . "</a></b>"; 
                        }
                        else
                        {
                            echo "<a href='scriptPaginazioneCommenti.php?page=" . $i ."'>". $i . "</a>"; 
                        }
                    }
                }
                echo "</div>"; //chiudo indicePagineContainer

        $inizio = ($page-1)*$limit;

        $q = ("SELECT IDcommento, testoCommento, data, dataModifica, numLike, username, proPic FROM commento as c, utente as u WHERE c.IDpost = '$IDpost' and c.IDutente = u.IDutente ORDER BY IDcommento DESC LIMIT $inizio, $limit");
        $sth = $conn->query($q);

        session_start();
        while($row = $sth->fetch(PDO::FETCH_ASSOC))
        {
            echo 
                "<div class='commento'>
                    <img width='100px' style='object-fit: contain; border-radius: 5px; width:100px; height:100px' src='immagini/proPics/".$row["proPic"] . "'>
                    <br>   
                <a href='paginaUtente.php?username=" . $row["username"] . "'>" . $row["username"] . "</a>
                <br>
                <p class='blogData' style='padding-bottom:1%'>"
                .$row["data"];

                if($row["dataModifica"]!=NULL)
                {
                    echo "<br>Modificato il " . $row["dataModifica"] . "";
                }

                echo "</p>";

                echo "
                <p style='background-color:skyblue; border-radius: 5px; padding:2%; margin-top: 0;' class='testoCommento'>" . stripslashes($row["testoCommento"]). "</p><br>";

                echo "<div class='divLike'><i class='fa fa-thumbs-up' aria-hidden='true'></i>

                <span>" . $row["numLike"] . "</span><br></div>";

                if(isset($_SESSION["nomeUtente"]))
                {
                    if($row["username"]==$_SESSION["nomeUtente"])
                    {
                        echo "<div class='containerBottoni'>";
                        echo "<p style='display:inline-block; margin:1% 1% 1% 0%' class='elimina' id='" . $row["IDcommento"] . "'><i class='fa fa-trash' aria-hidden='true'></i></p>";
                        echo "<p style='display:inline-block; margin:1%' class='modifica modificaBottone' id='" . $row["IDcommento"] . "'><i class='fa fa-pencil' aria-hidden='true'></i></p>";
                        echo "</div>";
                    }
                    else
                        echo "<button class='buttonLike button-17' style='margin:1% 0%' type='submit' id='" . $row["IDcommento"] . "'>Like</button>";
                        echo "</div>";

                }
            echo "</div>";
        }
        echo "</div><br>";
    }
    catch(PDOException $e)
    {
        echo "<p style='text-align: center; color: red'>Errore nel caricamento dei commenti</p>";
    }

?>