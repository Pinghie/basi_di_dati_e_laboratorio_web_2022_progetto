<?php
//pagina in cui sono mostrate le info di un utente
    if(!isset($_GET["username"]))
        header('Location: index.php');

    $utenteVisitato = $_GET["username"];

    session_start();
    $sessione = false;
    if(isset($_SESSION["nomeUtente"]) and isset($_SESSION["sessioneUtente"]))
    {
        $sessione = true;
        $IDvisitatore = $_SESSION["sessioneUtente"];
        $utenteVisitatore = $_SESSION["nomeUtente"];
    }
    else{
        $IDvisitatore = -1;
        $utenteVisitatore = "-";
    }

    try
    {
        include("dbconnection.php");
        $q = ("SELECT IDutente, abbonato, proPic FROM utente WHERE username = '$utenteVisitato'");
        $sth = $conn->query($q);
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if(!$result)
        {
            echo "Questo utente non esiste";
            echo "<a href='index.php'>Home</a>";
            die();
        }
        else
            $IDutenteVisitato = $result["IDutente"];
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<title>Pagina Utente</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header id="topNav">
        <a href="index.php">Home</a>
        <?php
            if($sessione){
                echo "<a href='areaPersonale.php'>Area Personale</a>";
                echo "<a href='logout.php'>Logout</a>";
            }
            else{
                echo "<a href='registrazione.php'>Registrati</a>";
                echo "<a href='login.php'>Login</a>";
            }
        ?>
        <a href="index.php" class="logo"> <img src="immagini/stile/logoBlog.png"  alt="Logo Blog"> </a>
	</header>
    
    <div class="mainContainer" style="padding:1% 2%">
    
        <?php 
        
            if($sessione and $utenteVisitatore == $utenteVisitato){
                ?>
                <div class='post' style='background-color: lightGray'>
                    <p class='littleP'>Stai visitando la tua pagina utente. Se vuoi modificare le tue informazioni o creare nuovi blog, vai alla tua <a href='areaPersonale.php'>Area Personale</a></p>
                </div>
          <?php  }

            echo "<h1 style='margin-bottom:0'>" . $utenteVisitato . "</h1>";
         
            if($result["abbonato"]==1)
                echo "<h3 class='blogAutore' style='margin-top:0; padding-top:0'>Utente premium</h3>";
            
            echo "<div class='blogImg' style='margin:2%;'><img src='immagini/proPics/" . $result["proPic"] . "' alt='immagine profilo'></div>";
        
            //Statistiche utente
            echo "<div class='flexContainer post'>";
        
            try
            {
                $q = ("SELECT COUNT(*) FROM giudizio WHERE IDutente = '$IDutenteVisitato'");
                $sth = $conn->query($q);
                $result = $sth->fetch(PDO::FETCH_ASSOC);
                echo "<p class='littleP'><b>Numero di giudizi ai post: </b>" . $result["COUNT(*)"] . "</p>";
            }
            catch(PDOException $e)
            {
                echo "<p class='littleP'>Si è verificato un errore nel caricamento del numero dei giudizi ai post</p>";
            }
        
            try
            {
                $q = ("SELECT COUNT(*) FROM commento WHERE IDutente = '$IDutenteVisitato'");
                $sth = $conn->query($q);
                $result = $sth->fetch(PDO::FETCH_ASSOC);
                echo "<p class='littleP'><b>Numero di commenti ai post: </b>" . $result["COUNT(*)"] . "</p>";
            }
            catch(PDOException $e)
            {
                echo "<p class='littleP'>Si è verificato un errore nel caricamento del numero dei giudizi ai post</p>";
            }
        
            try
            {
                $q = ("SELECT COUNT(*) FROM likes WHERE IDutente = '$IDutenteVisitato'");
                $sth = $conn->query($q);
                $result = $sth->fetch(PDO::FETCH_ASSOC);
                echo "<p class='littleP'><b>Numero di like ai commenti: </b>" . $result["COUNT(*)"] . "</p>";
                $conn = null; //chiudo la connessione perché non mi serve più
            }
            catch(PDOException $e)
            {
                echo "<p class='littleP'>Si è verificato un errore nel caricamento del numero dei giudizi ai post</p>";
            }
?>
            
    </div>
    
    <br><br>
        
        <div class='postContainer'>
            <div id='containerBlogAutore' class='post'>
            </div>
        </div>

        <div class='postContainer'>
            <div id='containerBlogIscritto' class='post'>
            </div>
        </div>
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
             var username = "<?php echo $utenteVisitato; ?>";
            
             jQuery("#containerBlogAutore").load("scriptPaginazioneUtente.php?username=" + username + "&pageAutore=1");
            
            jQuery("#containerBlogIscritto").load("scriptPaginazioneUtente.php?username=" + username + "&pageIscritto=1");
            
            $(document).on("click", "#indicePagineContainerAutore a", function(e){
                e.preventDefault();
                var page = $(this).text();
                jQuery("#containerBlogAutore").load("scriptPaginazioneUtente.php?username=" + username + "&pageAutore=" + page);
            })
            
            $(document).on("click", "#indicePagineContainerIscritto a", function(e){
                e.preventDefault();
                var pageIscritto = $(this).text();
                jQuery("#containerBlogIscritto").load("scriptPaginazioneUtente.php?username=" + username + "&pageIscritto=" + pageIscritto);
            })
            
        })
    </script>
    
</body>
</html>