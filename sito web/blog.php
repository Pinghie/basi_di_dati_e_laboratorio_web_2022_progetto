<?php
//pagina del blog
    if(!isset($_GET["IDblog"]))
        header("Location: index.php");

    $IDblog = $_GET["IDblog"];
    
    session_start();
    $sessione = false;
    if(isset($_SESSION["sessioneUtente"]))
    {
        $IDutente = $_SESSION["sessioneUtente"];
        $sessione = true;
    }

    try
    {
        include("dbconnection.php");
        $q = ("SELECT b.titolo, b.limiteEta, b.data, b.numPost, b.numIscritti, b.presentazione, b.immagine, s.sfondo, s.font, u.IDutente as IDproprietarioBlog, u.username, u.dataNascita, b.archiviato FROM blog as b, autore as a, utente as u, stile as s WHERE b.IDblog = '$IDblog' and u.IDutente = a.IDutente and a.IDblog = b.IDblog and s.IDstile = b.IDstile");
        $sth = $conn->query($q);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        
        if(!$result)
            header("Location: index.php");
        
        include("scriptBloccoEta.php"); //importando questo script, importo una variabile $blocco di tipo booleano che mi dice se l'utente può visualizzare o no il blog.
    }
    catch(PDOException $e)
    {
        echo "Si è verificato un errore imprevisto. Impossibile terminare il caricamento della pagina. Torna alla <a href='index.php'>home</a><br><br>";
        die("Codice errore: " . $e->getMessage());
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>BLOG: <?php if($result) echo stripslashes($result["titolo"]);?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    
    <header id="topNav">
        <?php
            if($sessione){
                echo "<a href='areaPersonale.php'>Area Personale</a>";
                echo "<a href='logout.php'>Logout</a>";
            }
            else{
                echo "<a href='registrazione.php'>Registrati</a>\t";
                echo "<a href='login.php'>Login</a>";
            }
        ?>

        <a href="index.php" class="logo"> <img src="immagini/stile/logoBlog.png"  alt="Logo Blog"> </a>
	</header>
    
    
    <div class="mainContainer" style="padding:1% 2%">
    <?php
            //VERIFICO IL TIPO DI UTENTE CHE STA VISITANDO IL BLOG IN MODO DA PERSONALIZZARE LA VIEW DEL SITO
            $IDproprietarioBlog = $result["IDproprietarioBlog"];
        
            if($sessione==true)
            {
                try
                {
                    $q = ("SELECT IDautore FROM coautore WHERE IDblog = '$IDblog' and IDautore = '$IDutente'");
                    $sth = $conn->query($q);
                    $resultCoautore = $sth->fetch(PDO::FETCH_ASSOC);
                }
                catch(PDOException $e)
                {
                    echo "Si è verificato un errore imprevisto. Impossibile terminare il caricamento della pagina. Torna alla <a href='index.php'>home</a><br><br>";
                    die("Codice errore: " . $e->getMessage());
                }
                
                if($IDproprietarioBlog == $_SESSION["sessioneUtente"])
                    $tipoUtente = "proprietario";

                else if($resultCoautore)
                    $tipoUtente = "coautore";

                else
                    $tipoUtente = "registrato";
            }
            else
                $tipoUtente = "visitatore";

        
        //gestione dei messaggi nel caso in cui il blog visitato sia archiviato
        if($result["archiviato"]==1)
        {
            if($sessione){
                if($tipoUtente == "proprietario")
                {
                    echo "
                    <div class='post' style='background-color: lightGray'>
                        <p class='littleP'>Questo blog è archiviato. È accessibile solo a te che sei il proprietario</p>
                    </div>";
                }
                else
                {
                    if($tipoUtente == "coautore")
                    {
                        echo "
                        <div class='post' style='background-color: lightGray'>
                            <p class='littleP'>Questo blog è stato archiviato dal suo proprietario. Potrai riprendere a svolgere le tue funzioni di coautore una volta che sarà disarchiviato.</p>
                        </div>";
                        die();
                    }
                    else
                    {
                       header("Location: index.php");
                    }
                }
            }
            else
            {
                header("Location: index.php");
            }
        } 
           
        //gestione dei messaggi se l'utente è minorenne e il blog è vietato ai minori
        if($blocco and $result["limiteEta"]==1)
        {
            echo"<p class='littleP'>Il contenuto è vietato ai minori. Non puoi visualizzarlo, torna alla <a href='index.php'>home</a>.</p>";
            if(!$sessione)
                echo"<p class='littleP'>Accedi per confermare la tua età. Fai il <a href='login.php'>login</a></p>";
            die();
        }
        
        $sfondo = $result["sfondo"];
        $font = $result["font"];
    ?>
        
        <div class="flexContainer leftContainer" style="padding-bottom:0">
            <h1><?php echo stripslashes($result["titolo"])?></h1>
        
            <button id="<?php echo $IDblog ?>" class="buttonIscriviti button-17" type="submit" style="align-self:center; margin-left:5%;">

                <?php
                    if($sessione)
                    {
                        try
                        {
                            $q = ("SELECT IDutente FROM iscritto WHERE IDblog = '$IDblog' and IDutente = '$IDutente'");
                            $sth = $conn->query($q);
                            $resultIscritto = $sth->fetch(PDO::FETCH_ASSOC);

                            if($resultIscritto)
                                echo "Disiscriviti";
                            else
                               echo "Iscriviti";
                        }
                        catch(PDOException $e)
                        {
                            echo "Si è verificato un errore imprevisto. Impossibile terminare il caricamento della pagina. Torna alla <a href='index.php'>home</a><br><br>";
                            die("Codice errore: " . $e->getMessage());
                        }
                    }
                ?>
            </button>
            
        </div>
        
        
        <div class='blogImgBig' style='margin:0% 2% 2% 2%;'>
            <img src='immagini/blogPics/<?php echo $result["immagine"];?>' alt='immagine blog'>
        </div>

        <div class='flexContainer postLeft'>
            <p class='littleP'><b> Creato il:</b> <?php echo $result["data"] ?> da <a href='paginaUtente.php?username=<?php echo $result["username"]?>'><?php echo $result["username"]?></a></p>
            
            <p class='littleP'><b>Numero di post:</b> <span id="numeroPost"><?php echo $result["numPost"] ?></span></p>
            
            <p class='littleP'><b>Numero di iscritti:</b> <span id='numeroIscritti'><?php echo $result["numIscritti"] ?> </span></p>
        </div>
        
        <br>
        
        <div class='flexContainer postLeft '>
            <div class="leftContainer">
                <h2>Presentazione</h2>
                <p><?php echo stripslashes($result["presentazione"])?></p>
            </div>
        </div>
        
        <br>
            
        <div class='flexContainer postLeft'>
            <div class="leftContainer">
                <h2>Categorie</h2>
                <?php
                    //Stampo temi e sottotemi del blog
                    try
                    {
                        $q = ("SELECT t.IDtema, t.tema, st.sottotema FROM temiblog as tb, sottotema as st, tema as t WHERE tb.IDtema = st.IDsottotema and st.macrotema = t.IDtema and tb.IDblog = '$IDblog' ORDER BY t.tema");
                        $sth = $conn->query($q);

                        if($row = $sth->fetch(PDO::FETCH_ASSOC))
                        {
                            $lastTema = 0;
                            do
                            {
                                if($lastTema != $row["IDtema"])
                                    echo "<br><p style='margin:0;'>Tema: <b>" . $row["tema"] . "</b></p>";
                                $lastTema = $row["IDtema"];
                                echo "<p style='margin:0;'>" . $row["sottotema"] . "</p>";
                            }while($row = $sth->fetch(PDO::FETCH_ASSOC));
                        }
                        else
                            echo "<p style='margin:0;'>Non ci sono categorie per questo blog</p>";
                    }
                    catch(PDOException $e)
                    {
                        echo "Si è verificato un errore nel caricamento delle categorie.";
                    }

                ?>
             
            </div>
        </div>
        <br>
        <?php
        
        //stampo i coautori del blog
        try
        {
            $q = ("SELECT u.username FROM coautore c, utente u WHERE u.IDutente = c.IDautore and c.IDblog = '$IDblog'");
            $sth = $conn->query($q);

            if($row = $sth->fetch(PDO::FETCH_ASSOC))
            {
                echo "<div class='flexContainer postLeft '> 
                        <div class='leftContainer'><h2>Coautori</h2>";
                            do
                            {
                                echo $row["username"] . "<br>";
                            }while($row = $sth->fetch(PDO::FETCH_ASSOC));
                
                echo "</div>
                    </div>";
            }
        }
        catch(PDOException $e)
        {
            echo "Si è verificato un errore nel caricamento dei coautori.";
        }

        //stampo i post del blog
        try
        {
            $q = ("SELECT * FROM post as p, utente as u WHERE IDblog = '$IDblog' and p.IDutente = u.IDutente LIMIT 1");
            $sth = $conn->query($q);

            echo"<h1>Post</h1>";
            
            if($row = $sth->fetch(PDO::FETCH_ASSOC)){
                echo "<button id='linkCreaPost' class='button-17'>Crea un post</button> <br>";
  
                echo"<div class='postContainer'>";
                echo "<div id='containerPost' class='post'>";


                echo "</div></div>"; //chiudo containerPost e postcontainer
           }
           else
           {
               echo"<h3>Non ci sono ancora post</h3>";
               echo "<button id='linkCreaPost' class='button-17'>Crea il primo post</button>";
           }
        }
        catch(PDOException $e)
        {
            echo "Si è verificato un errore nel caricamento dei post.";
        }

        ?>

    </div>  
    
        <div id="messaggioElimina" class="popupElimina">
            <h2>Vuoi eliminare il post?</h2>
            <button id="s" value="sì" class="button-17">Sì</button>
            <button id="n" value="no" class="button-17">No</button>
        </div>
    
    <footer>
		<div class="flexContainer footerContainer">
			<div class="leftContainer">
				<h2>Contatti</h2>
				<p><span class="pFooter">Email</span> &nbsp; <a class="link" href="mailto:s.diviesti@studenti.unipi.it">s.diviesti@studenti.unipi.it</a> &nbsp;&nbsp;<a class="link" href="mailto:f.melasi@studenti.unipi.it">f.melasi@studenti.unipi.it</a></p>
				<p><span class="pFooter">Matricola</span> &nbsp; 618063 &nbsp; &nbsp;614488</p>
			</div>
			<div class="rightContainer icons">
				<a href="#"><img src="immagini/stile/facebookLogo.png" alt="logo facebook"/></a>
				<a href="#"><img src="immagini/stile/instagramLogo.png" alt="logo instagram"/></a>
				<a href="#"><img src="immagini/stile/twitterLogo.png" alt="logo twitter"/></a>
			</div>
		</div>
	</footer>
    
    <script>
        $('document').ready(function(){
            var iscritti;
            var IDblog = "<?php echo $IDblog; ?>";
            jQuery("#containerPost").load("scriptPaginazionePost.php?IDblog=" + IDblog + "page=1");
            $(document).on("click", "#indicePagineContainer a", function(e){
                e.preventDefault();
                var page = $(this).text();
                jQuery("#containerPost").load("scriptPaginazionePost.php?IDblog=" + IDblog + "&page=" + page);
            })
            
            var sfondo = "<?php echo $sfondo; ?>";
            var font = "<?php echo $font; ?>";
            var stringaSfondo = "url('immagini/sfondiStile/" + sfondo + "')";

            $("body").css("background-image", stringaSfondo);
            $("body").css("background-repeat", "repeat");
            $("body").css("font-family", font);
            
            $(".buttonIscriviti").click(function()
                                  {
                $.ajax({
                    type: "POST",
                    url: "scriptIscrizione.php",
                    data: IDblog,
                    success: function(response) {
                        if(response == "iscritto")
                            {
                                iscritti = parseInt($("#numeroIscritti").text()) + 1;
                                $("#numeroIscritti").text(iscritti);
                                $(".buttonIscriviti").text("Disiscriviti");
                            }
                        else if(response =="disiscritto")
                            {
                                iscritti = parseInt($("#numeroIscritti").text()) - 1;
                                $("#numeroIscritti").text(iscritti);
                                $(".buttonIscriviti").text("Iscriviti");
                            }
                        else if(response =="errore")
                            {
                                alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                            }
                    }
                });
            });
            
            var ruoloVisitatore = "<?php echo $tipoUtente;?>";
            if(ruoloVisitatore==("proprietario").trim() || ruoloVisitatore==("coautore").trim())
                {
                    $("#linkCreaPost").css("display", "block");
                    $(".buttonIscriviti").remove();
                }
            else if(ruoloVisitatore==("visitatore").trim())
                {
                    $("#linkCreaPost").remove();
                    $(".buttonIscriviti").remove();
                    $(".containerBottoni").remove();
                }
            else
            {
                $("#linkCreaPost").remove();
                $(".containerBottoni").remove();
            }

            $(document).on("click", ".modifica", function(){
                window.location.href="modificaPost.php?IDpost=" + $(this).attr("id");
            });
            
            $(document).on("click", ".elimina", function(){
                IDpostElimina = $(this).attr("id");
                
                $("#messaggioElimina").css("display", "block");
            });
            
            
            $("#s").click(function(){
                $.ajax({
                    type: "POST",
                    url: "scriptEliminaPost.php",
                    data: 
                    {
                        IDpostElimina: IDpostElimina,
                        IDblogElimina: IDblog
                    },
                    success: function(response) {
                        if(response == "ok")
                            {
                                $("#messaggioElimina").css("display", "none");
                                jQuery("#containerPost").load("scriptPaginazionePost.php?IDblog=" + IDblog + "&page=1");
                                numPost = parseInt($("#numeroPost").text()) - 1;
                                $("#numeroPost").text(numPost);
                            }
                    }
                });
            });
            
            $("#n").click(function(){
                $("#messaggioElimina").css("display", "none");
            });
            
            $("#linkCreaPost").click(function(){
                window.location.href="creaPost.php?IDblog=" + IDblog;
            });
            
        });
        
    </script>
</body>
</html>