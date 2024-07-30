<?php
//pagina di un post
    if(!isset($_GET["IDpost"]))
        header("Location: index.php");

    $IDpost = $_GET["IDpost"];

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
        $q = ("SELECT p.titolo, sottotitolo, p.data, testoPost, numCommenti, mediaGiudizio, p.immagine, p.IDblog, p.IDutente, b.limiteEta, b.archiviato, a.IDutente as IDproprietarioBlog, s.sfondo, s.font, u.username FROM post as p, blog as b, autore as a, stile as s, utente as u WHERE p.IDpost = '$IDpost' and p.IDblog = b.IDblog and a.IDblog = b.IDblog and b.IDstile = s.IDstile and p.IDutente = u.IDutente");
        $sth = $conn->query($q);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $IDblog = $result["IDblog"];
        include("scriptBloccoEta.php");//importando questo script, importo una variabile $blocco di tipo booleano che mi dice se l'utente può visualizzare o no il blog.
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
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<title>POST: <?php echo stripslashes($result["titolo"])?></title>
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

        <a href="blog.php?IDblog=<?php echo $IDblog?>">Vai al blog</a>
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
                        echo "<div class='post' style='background-color: lightGray'>
                                <p class='littleP'>Questo blog non esiste. Torna alla <a href='index.php'>Home</a></p>
                            </div>";
                        die();
                    }
                }
            }
            else
            {
                echo "<div class='post' style='background-color: lightGray'>
                        <p class='littleP'>Questo blog non esiste. Torna alla <a href='index.php'>Home</a></p>
                    </div>";
                die();
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
        
        <div class="flexContainer" style="padding-bottom:0"> 
            <div class="leftContainer">
                <h1 style="margin-top:0; margin-bottom:0"><?php echo stripslashes($result["titolo"])?></h1>
                <h2 style="margin-top:0; font-weight:500;"><?php echo stripslashes($result["sottotitolo"])?></h2>
                <div class="blogImgBig" style="margin:0% 2% 2% 2%;">
                    <img src="immagini/postPics/<?php echo $result["immagine"]?>" alt="immagine blog">
                </div>
                <br>
                <div class='flexContainer postLeft '>
                    <p class="littleP"><b>Creato il:</b> <?php echo $result["data"]?> da <a href="paginaUtente.php?username=<?php echo $result["username"] ?>"><?php echo $result["username"] ?></a></p>
                    <p class="littleP"><b>Numero di commenti:</b> <span id="nCommenti"><?php echo $result["numCommenti"]?></span></p>
                    <p class="littleP"><b>Valutazione:</b><span id='valutazione'> <?php echo $result["mediaGiudizio"]?></span></p>
                </div>
                
                <p style="font-size:1.5em"><?php echo $result["testoPost"]?></p>
                <form id="formGiudizio">
                    <input id="IDpost" name="IDpost" type="text" style="display: none" value="<?php echo $IDpost ?>">
                    <label class="littleP" for="giudizio" id="labelGiudizio">Assegna un giudizio numerico da 1 a 5:</label>
                    <input class="sottotema" style="padding:1%;" id="giudizio" name="giudizio" type="number" min="1" max="5" placeholder="3">
                    <button type="submit" class="button-17" style="padding:4%;" id="bottoneFormGiudizio" <?php if(!$sessione) echo "disabled";?>>Invia</button>
                </form>
            </div>
        </div>
        
        <form id="formCommento" style="margin:2%">
            <input id="IDpost" name="IDpost" type="text" style="display: none" value="<?php echo $IDpost ?>">
            <textarea id="commento" name="commento" rows="5" cols="70" placeholder="Scrivi un commento..."></textarea><br>
            <button class="button-17" id="pubblica" type="submit">Pubblica</button>
        </form>

        <div id='containerCommenti'></div>
        
    </div>
    
    <div id="messaggioElimina" style="display:none" class="popupElimina">
        <p>Vuoi eliminare il commento?</p>
        <button class="button-17" id="s" value="sì">Sì</button>
        <button class="button-17" id="n" value="no">No</button>
    </div>
    
    <div id="modificaCommento" style="display: none" class="popupElimina">
        <textarea style='' id='commentoModificato' rows='5' cols='70' placeholder='Modifica il commento...'></textarea><br>
        <p id="errcommento" style="display: none; color:red;">Il commento non soddisfa i requisiti di lunghezza</p>
        <button class="button-17" id='modifica' type='submit'>Modifica</button>
        <button class="button-17" id='annulla' type='submit'>Annulla</button>
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
            
            var tipoUtente = "<?php echo $tipoUtente; ?>";
            var IDpost = "<?php echo $IDpost; ?>";
            
            //carico i commenti del post
             jQuery("#containerCommenti").load("scriptPaginazioneCommenti.php?IDpost=" + IDpost + "page=1");

            $(document).on("click", "#indicePagineContainer a", function(e){
                e.preventDefault();
                page = $(this).text();
                jQuery("#containerCommenti").load("scriptPaginazioneCommenti.php?IDpost=" + IDpost + "&page=" + page);
            })
            
            //imposto sfondo e font secondo lo stile del blog
            var sfondo = "<?php echo $sfondo; ?>";
            var font = "<?php echo $font; ?>";
            var stringaSfondo = "url('immagini/sfondiStile/" + sfondo + "')";

            $("body").css("background-image", stringaSfondo);
            $("body").css("background-repeat", "repeat");
            $("body").css("font-family", font);
            
            //personalizzo la view sulla base del tipo di utente
            if(tipoUtente == "visitatore")
                {
                    $("#commento").prop('disabled', true);
                    $("#commento").prop('placeholder', "Per commentare devi aver effettuato l'accesso");
                    $("#pubblica").remove();
                    
                    $("#labelGiudizio").html("<a href='login.php'> Accedi </a> per esprimere un giudizio");
                    $("#giudizio").prop('disabled', true);
                }
            else if(tipoUtente=="proprietario" || tipoUtente == "coautore")
                $("#formGiudizio").remove();
                
            //gestione commento
            $("#formCommento").validate({
               rules: {
                   commento: {
                       required: true,
                       minlength: 5,
                       maxlength: 255
                   },
               },
                messages:{
                    commento: "Inserisci un commento valido",
                },
                submitHandler: submitFormCommento
            });
            
            function submitFormCommento(){
                var data = $("#formCommento").serialize();
                
                 $.ajax({
                    type: "POST",
                    url: "scriptCommento.php",
                    data: data,
                    success: function(response) {
                        if(response == "ok")
                            {
                                jQuery("#containerCommenti").load("scriptPaginazioneCommenti.php?IDpost=" + IDpost + "&page=1");
                                $("#msgNoCommenti").remove();
                                $("#commento").val("");
                                $("#nCommenti").text(parseInt($("#nCommenti").text())+1);
                            }
                        else if(response == "5")
                            {
                                alert("È stato rilevato un tentativo di SQL Injection.");
                                $("#commento").val("");
                            }
                        else if(response == "errore")
                            {
                                alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                            }
                    }
                });
            }
            
            //gestione modifica commento
            var IDcommentoModifica;
            $(document).on("click", ".modificaBottone", function()
            {
                var testoCommento = $(this).parent().parent().children(".testoCommento").text();
                IDcommentoModifica = $(this).attr("id");
                $("#commentoModificato").val(testoCommento);
                $("#modificaCommento").css("display", "block");
            });
            
            $("#modifica").on("click", function(){
                var commentoModificato = $("#commentoModificato").val();
                if($("#commentoModificato").val().length>5 && $("#commentoModificato").val().length<255)
                    {
                        $("#errcommento").css("display", "none");
                        $.ajax({
                            type: "POST",
                            url: "scriptModificaCommento.php",
                            data: {
                                IDcommentoModifica: IDcommentoModifica,
                                commentoModificato: commentoModificato
                            },
                            success: function(response) {
                                if(response == "5")
                                    {
                                        alert("È stato rilevato un tentativo di SQL Injection.");
                                        $("#commentoModificato").val("");
                                    }
                                else if(response == "errore")
                                    {
                                        alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                                    }
                                else if("ok")
                                    {
                                        jQuery("#containerCommenti").load("scriptPaginazioneCommenti.php?IDpost=" + IDpost + "&page=1");
                                        $("#modificaCommento").css("display", "none");
                                        $("#commentoModificato").text("");
                                    }
                            }
                        });   
                    }
                else
                    {
                        $("#errcommento").css("display", "block");
                    }
            });
                              
            
            $("#annulla").on("click", function(){
                $("#modificaCommento").css("display", "none");
            });
            
            //gestione giudizio al post
            $("#formGiudizio").validate({
               rules: {
                   giudizio: {
                       required: true,
                       range:[1,5]
                   },
               },
                messages:{
                    giudizio: {
                        max: "Inserire un valore tra 1 e 5",
                        min: "Inserire un valore tra 1 e 5",
                        required: "",
                    },
                },
                submitHandler: submitFormGiudizio
            });
            
            function submitFormGiudizio()
                                            {
                var valoreGiudizio = $("#giudizio").val();
                
                $.ajax({
                    type: "POST",
                    url: "scriptGiudizio.php",
                    data: {
                        valoreGiudizio: valoreGiudizio,
                        IDpost: IDpost
                    },
                    success: function(response) {
                        if(response == "errore")
                            {
                                alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                            }
                        else if(!isNaN(response))
                            {
                                var n = Number(response).toFixed(2);
                                $("#valutazione").html(n);
                            }
                    }
                });
            }
            
            //gestione elimina commento
            var IDcommentoElimina;
            $(document).on("click", ".elimina", function(){
                IDcommentoElimina = $(this).attr("id");
                
                $("#messaggioElimina").css("display", "inline-block");
            });
            
            $("#s").click(function(){
                $.ajax({
                    type: "POST",
                    url: "scriptEliminaCommento.php",
                    data: 
                    {
                        IDcommento: IDcommentoElimina,
                        IDpost: IDpost
                    },
                    success: function(response) {
                        if(response == "ok")
                            {
                                jQuery("#containerCommenti").load("scriptPaginazioneCommenti.php?IDpost=" + IDpost + "&page=1");
                                $("#messaggioElimina").css("display", "none");
                                $("#nCommenti").text($("#nCommenti").text()-1);
                            }
                        else if(response=="errore")
                            {
                                alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                            }
                    }
                });
            });
            
            $("#n").click(function(){
                $("#messaggioElimina").css("display", "none");
            });
            
            //gestione like al commento
            $(document).on("click", ".buttonLike", function(){
                var nodoNumLike = $(this).parent().find("span");
                var IDcommento = $(this).attr("id");
                
                $.ajax({
                    type: "POST",
                    url: "scriptLike.php",
                    data: IDcommento,
                    success: function(response) {
                        if(response == "like")
                            {
                                var newLikeNum = parseInt(nodoNumLike.text())+1;
                              nodoNumLike.text(newLikeNum);
                            }
                        else if(response == "dislike")
                            {
                              var newLikeNum = parseInt(nodoNumLike.text())-1;
                              nodoNumLike.text(newLikeNum);
                            }
                        else if(response == "errore")
                            {
                              alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                            }
                    }
                });
            });
        });
    </script>
</body>
</html>