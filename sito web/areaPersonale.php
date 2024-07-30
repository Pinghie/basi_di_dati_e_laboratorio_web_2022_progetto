<?php
//pagina per la gestione dei blog e dei dati dell'utente
    session_start();
    if(isset($_SESSION["sessioneUtente"]) and isset($_SESSION["nomeUtente"]))
        $IDutente = $_SESSION["sessioneUtente"];
    else
        header('Location: login.php');

    //Prendo alcune informazioni sull'utente
    try
    {    
        include("dbconnection.php");
        $q = ("SELECT proPic, abbonato FROM utente WHERE IDutente = '$IDutente'");
        $sth = $conn->query($q);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $proPic = $result["proPic"];
        $abbonato = $result["abbonato"];
        $conn = null; //chiudo la connessione perché non mi serve più
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Area Personale</title>
</head>
<body>
    <header id="topNav">
        <a href="index.php">Home</a>
        <a href='logout.php'>Logout</a>
        <a href="index.php" class="logo"> <img src="immagini/stile/logoBlog.png"  alt="Logo Blog"> </a>
	</header>
    
    <div class="mainContainer" style="padding:1% 2%">
        <div class="flexContainer">
            <div class="leftContainer">
                <h1>AREA PERSONALE di <?php echo $_SESSION["nomeUtente"] ?></h1>
                    <div class="blogImg" style="margin:0;">
                        <img  src="immagini/proPics/<?php echo $proPic ?>">
                    </div>
            </div>
            <div class="rightContainer">
                
                <button class="button-62" onclick="window.location.href='modificaDatiUtente.php'" id="linkCreaBlog" style="margin: 1%; float: right;">Modifica i tuoi dati</button>
                
                <button class="button-62" onclick="window.location.href='creaBlog.php'" id="linkCreaBlog" style="margin: 1%; float: right;">Crea Blog</button>
                
            </div>
        </div>
        
        <!-- I MIEI BLOG -->
        <div id='containerMieiBlog' ></div>
        
        <!-- I BLOG AI QUALI SONO ISCRITTO -->
        <div id='containerIscritto'></div>
        
        <!-- I BLOG DEI QUALI SONO COAUTORE -->
        <div id='containerCoautore'></div>
        
        <!-- I MIEI BLOG ARCHIVIATI -->
        <div id='containerArchiviato'></div>
        
        
    <?php
        if($abbonato==0){ ?>
        <div class="banner flexContainer">
            <div class="flexContainer contentContainer">
                <div>
                    <h1>Passa a premium</h1>
                    <p>Crea tutti i blog che desideri senza limiti</p>
                    <a href='abbonamento.php'>Inizia subito</a>
               </div>
            </div>
        </div>
          <?php  
        }
    ?>
                
    </div>
    
    <div class="popupElimina" id="messaggioElimina" style="display:none">
        <h2>Vuoi eliminare il blog?</h2>
        <button id="s" value="sì">Sì</button>
        <button id="n" value="no">No</button>
    </div>
    
    <div class="popupElimina" style="padding:1%" id="messaggioCoautore" >
        <div id="listaCoautori"></div>
        <label class='formP' for="userCoautore">Inserisci un coautore:</label>
        <input class='sottotema' type="text" id="userCoautore"  name="userCoautore" placeholder="username coautore"/>
        <button class="button-17" id="confermaCoautore">Conferma</button>
        <button class="button-17" id="annullaCoautore">Annulla</button>
        <label class="error1" id="err" for="userCoautore" display="none"></label>
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
        $('document').ready(function() {
            
            //gestione della paginazione dei blog
            var IDutente = <?php echo $IDutente; ?>;
            jQuery("#containerMieiBlog").load("scriptPaginazioneAP.php?utente=" + IDutente + "&pageBlog=1");
            
            jQuery("#containerIscritto").load("scriptPaginazioneAP.php?utente=" + IDutente + "&pageIscritto=1");
            
            jQuery("#containerCoautore").load("scriptPaginazioneAP.php?utente=" + IDutente + "&pageCoautore=1");
    
            jQuery("#containerArchiviato").load("scriptPaginazioneAP.php?utente=" + IDutente + "&pageArchiviato=1");
            
            $(document).on("click", "#indicePagineContainerMieiBlog a", function(e){
                e.preventDefault();
                var page = $(this).text();
                jQuery("#containerMieiBlog").load("scriptPaginazioneAP.php?utente=" + IDutente + "&pageBlog=" + page);
            })
            
            $(document).on("click", "#indicePagineContainerIscritto a", function(e){
                e.preventDefault();
                var page = $(this).text();
                jQuery("#containerIscritto").load("scriptPaginazioneAP.php?utente=" + IDutente + "&pageIscritto=" + page);
            })
            
            $(document).on("click", "#indicePagineContainerCoautore a", function(e){
                e.preventDefault();
                var page = $(this).text();
                jQuery("#containerCoautore").load("scriptPaginazioneAP.php?utente=" + IDutente + "&pageCoautore=" + page);
            })
            
            $(document).on("click", "#indicePagineContainerArchiviato a", function(e){
                e.preventDefault();
                var page = $(this).text();
                jQuery("#containerArchiviato").load("scriptPaginazioneAP.php?utente=" + IDutente + "&pageArchiviato=" + page);
            })
            
            //gestione eliminazione blog
            var IDblogElimina;
            $(document).on("click", ".elimina" , function()
                                  {
                $("#messaggioElimina").css("display", "inline-block");
                IDblogElimina = $(this).parent().attr("id");
            });
            
            $("#s").click(function(){
                $.ajax({
                    type: "POST",
                    url: "scriptEliminaBlog.php",
                    data: IDblogElimina,
                    success: function(response) {
                        if(response == "ok")
                            {
                                jQuery("#containerMieiBlog").load("scriptPaginazioneAP.php?utente=" + IDutente + "&pageBlog=1");
                                $("#messaggioElimina").css("display", "none");
                            }
                        else if(response == "errore")
                            {
                                alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                            }
                    }
                });
            });
            
            $("#n").click(function(){
                $("#messaggioElimina").css("display", "none");
            });
            
            //gestione modifica blog
            $(document).on("click", ".modifica", function()
                                  {
                var IDblogModifica = $(this).parent().attr("id");
                window.location.href="modificaBlog.php?blog=" + IDblogModifica;
            });
            
            //gestione archiviazione blog
            $(document).on("click", ".archivia", function(){
                archivia($(this).parent().attr("id"));
            });
            
            $(document).on("click", ".disarchivia", function(){
                archivia($(this).parent().attr("id"));
            });
            
            function archivia(IDblog){
                $.ajax({
                    type: "POST",
                    url: "scriptArchiviaBlog.php",
                    data: {
                        IDblog: IDblog,
                    },
                    success: function(response) {
                        if(response == "ok")
                            {
                                jQuery("#containerMieiBlog").load("scriptPaginazioneAP.php?utente=" + IDutente + "&pageBlog=1");
                                jQuery("#containerArchiviato").load("scriptPaginazioneAP.php?utente=" + IDutente + "&pageArchiviato=1");
                            }
                        else if(response="errore")
                            {
                                alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                            }
                    }
                });
            }
            
            //gestione coautori blog
            function annullaCoautore()
            {
                $("#err").css("display", "none");
                $("#userCoautore").val("");
                $("#messaggioCoautore").css("display", "none");
            }
            
            var IDblogCoautore;
            $(document).on("click", ".coautore", function(){     
                IDblogCoautore = $(this).parent().attr("id");
                annullaCoautore();
                $("#messaggioCoautore").css("display", "block");
                jQuery("#listaCoautori").load("scriptMostraCoautori.php?IDblog=" + IDblogCoautore);

            });
            
            $("#annullaCoautore").click(function()
                                       {
                annullaCoautore();
            });
            
            $("#confermaCoautore").click(function(){
                var userCoautore = $("#userCoautore").val();
                
                $.ajax({
                    type: "POST",
                    url: "scriptAggiungiCoautore.php",
                    data: {
                        IDblogCoautore: IDblogCoautore,
                        userCoautore: userCoautore,
                    },
                    success: function(response) {
                        if(response == "5")
                        {
                            alert("È stato rilevato un tentativo di SQL Injection.");
                            $("#userCoautore").val("");
                        }
                        else if(response == "errore")
                        {
                            alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                        }
                        else if (response!="ok")
                        {
                            $("#err").text(response);
                        }
                        else if (response=="ok")
                        {
                            $("#err").text("L'utente è stato aggiunto come coautore");
                            $("#userCoautore").val("");
                            jQuery("#listaCoautori").load("scriptMostraCoautori.php?IDblog=" + IDblogCoautore);
                        }
                    $("#err").css("display", "block");
                    }
                });
            });
            
            $(document).on("click", ".rimuoviCoautore", function(){
                
                var IDcoautore = $(this).attr("id");

                $.ajax({
                    type: "POST",
                    url: "scriptEliminaCoautore.php",
                    data: {
                        IDcoautore: IDcoautore,
                        IDblogCoautore: IDblogCoautore
                    },
                    success: function(response) {
                        if(response == "ok"){
                            jQuery("#listaCoautori").load("scriptMostraCoautori.php?IDblog=" + IDblogCoautore);
                        }
                        else if(response == "errore")
                        {
                            alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                        }
                }
                
            });
        });
            
            $("#userCoautore").on("keyup", function(){
                $("#err").css("display", "none");
            })
        });
    </script>
    
    
</body>
</html>