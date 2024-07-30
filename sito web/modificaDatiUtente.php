<?php
//pagina per la modifica dei dati dell'utente
    session_start();
    if(!isset($_SESSION["sessioneUtente"]))
        header('Location: login.php');

    $IDutente = $_SESSION["sessioneUtente"];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<title>Modifica dati</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header id="topNav">
        <a href="areaPersonale.php">Area Personale</a>;
        <a href="index.php">Home</a>;
        <a href="logout.php">Logout</a>
        <a href="index.php" class="logo"> <img src="immagini/stile/logoBlog.png"  alt="Logo Blog"> </a>
	</header>
    
    <div class="mainContainer">
        <div class="flexContainer">
            <div class="leftContainer">
                <form id='formModifica'>
                    <div id="modificaok" style="display: none"><p class='mediumP boldP'>Modifica effettuata!</p></div>
                    
                    <h1>Modifica i tuoi dati</h1>
                    <?php 
                        try
                        {
                            include("dbconnection.php");
                            $q = ("SELECT * FROM utente WHERE IDutente = '$IDutente'");
                            $sth = $conn->query($q);
                            $row = $sth->fetch(PDO::FETCH_ASSOC);
                        }
                        catch(PDOException $e)
                        {
                            echo "Si è verificato un errore imprevisto. Impossibile terminare il caricamento della pagina. Torna alla <a href='index.php'>home</a><br><br>";
                            die("Codice errore: " . $e->getMessage());
                        }
                    ?>
                            
                    <div class="input-container ic1">
                        <input type="text" name="username" id="username" class="input" placeholder="" value="<?php echo $row["username"] ?>"/>
                        <div class="cut"></div>
                        <label for="username" class="placeholder">Username</label>
                        <label for="username" id="errusername" style="display:none" class="error1">Il nome utente esiste già</label>
                    </div>
                      
                    <div class="input-container ic2">
                        <input type="email" name="email" id="email" class="input" placeholder="" value="<?php echo $row["email"] ?>"/>
                        <div class="cut"></div>
                        <label for="email" class="placeholder">Email</label>
                        <label for="email" id="erremail" style="display:none" class="error1">Questa email è già registrata</label>
                    </div>
                    
                    <div class="input-container ic2">
                        <input type="password" name="pswVecchia" id="pswVecchia" placeholder="" class="input"/>
                        <div class="cut"></div>
                        <label for="pswVecchia" class="placeholder">Password attuale</label>
                        <label for="pswVecchia" id="errpswVecchia" style="display:none" class="error1">La password inserita non corrisponde a quella attuale</label>
                    </div>
                
                    <div class="input-container ic2">
                        <input type="password" name="pswNuova" id="pswNuova" class="input" placeholder="" disabled/>
                        <div class="cut"></div>
                        <label for="pswNuova" class="placeholder">Nuova Password</label>
                        <label for="pswNuova" id="errpswNuova" style="display:none" class="error1">La password inserita corrisponde a quella attuale</label>
                    </div>

                    <div class="input-container ic2">
                        <input type="password" name="pswConferma" id="pswConferma" class="input" placeholder="" disabled/>
                        <div class="cut"></div>
                        <label for="pswConferma" class="placeholder">Conferma Password</label>
                    </div>
                    
                    <div class="input-container ic2">
                        <input type="date" name="dataNascita" id="dataNascita" class="input" min="1900-01-01" value="<?php echo $row["dataNascita"]?>">
                        <div class="cut"></div>
                        <label for="dataNascita" class="placeholder">Data di nascita</label>
                    </div>

                    <br>
                    
                    <label for="proPic" class="formP">Modifica l'immagine del profilo</label> <br> <br>
                    <input type="file" id="proPic" name="proPic" class="custom-file-input" style="width: 100%;" accept=".jpg,.jpeg,.png"><br>
                    <label for="proPic" id="errext" style="display:none" class="error1">L'immagine può essere solo png, jpg, jpeg</label>

                    <br> <br>
                    
                    <label for='defaultProPic' class="littleP boldP">Imposta l'immagine di default</label>
                    <label class="switch">
                        <input type='checkbox' id='defaultProPic' name='defaultProPic' value=''>
                        <span class="slider round"></span>
                    </label><br><br>
                    <label for="defaultProPic" id="errDefaultProPic" style="display:none" class="error1">Un'immagine di profilo è già stata caricata, sicuro di voler utilizzare l'immagine di default?</label>
                    <br>

                    <button type='submit' id='btnModifica' class="submit" disabled>Modifica</button>

                </form>
            </div>
        </div>
    </div>
    
    <div class="mainContainer">
        <div class="flexContainer">
            <div class="leftContainer">
                <h1>Altre funzionalità</h1>
                
                <!-- ELIMINA IL PROFILO -->
                <button class="elimina button-17">Elimina il tuo profilo</button>
                    
               <?php
                
                try
                {
                    $q = ("SELECT abbonato FROM utente WHERE IDutente = '$IDutente'");
                    $sth = $conn->query($q);
                    $result = $sth->fetch(PDO::FETCH_ASSOC);

                    if($result["abbonato"]==1){
                        echo "  <button id='abbonamentoBtn' class='disattivaAbbonamento button-17'>Disattiva abbonamento</button>
                        ";

                        //disattiva o attiva rinnovo automatico
                        $q = ("SELECT rinnovoAutomatico FROM utente WHERE IDutente = '$IDutente'");
                        $sth = $conn->query($q);
                        $result = $sth->fetch(PDO::FETCH_ASSOC);

                        if($result["rinnovoAutomatico"]==1){
                            echo "  <p id='rinnovoAutomaticoBtn' class='disattivaRA button-17'>Disattiva pagamento automatico dell'abbonamento</p>
                            ";
                        }
                        else{
                            echo "  <p id='rinnovoAutomaticoBtn' class='attivaRA button-17' style='padding:1%;'>Attiva pagamento automatico dell'abbonamento</p>
                            ";
                        }
                    }
                    else{
                        echo " 
                            <button class='button-17 attivaAbbonamento'>Attiva abbonamento</button>
                        ";
                    }
                }
                catch(PDOException $e)
                {
                    echo "Si è verificato un errore imprevisto. Impossibile terminare il caricamento della pagina. Torna alla <a href='index.php'>home</a><br><br>";
                    die("Codice errore: " . $e->getMessage());
                }
                ?>
            </div>
        </div>
    </div>
    
    <div id="messaggioElimina" style="display:none" class="popupElimina">
            <h2>Vuoi eliminare il tuo profilo?</h2>
            <button id="sE" value="sì" class="button-17" style="justify-content: center">Sì</button>
            <button id="nE" value="no" class="button-17" style="justify-content: center">No</button>
    </div>
    
    <div id="messaggioDisattivaAbbonamento" style="display:none" class="popupElimina">
        <h2>Vuoi disattivare l'abbonamento?</h2>
        <button id="sAbb" value="sì" class="button-17">Sì</button>
        <button id="nAbb" value="no" class="button-17">No</button>
    </div>
    
    <div>
        <div id="messaggioRA" style="display:none" class="popupElimina">
            <h2 id="testoMessaggioRA"></h2>
            <div id="messaggioSN" >
            <button id="sRA" value="sì" class="button-17">Sì</button>
            <button id="nRA" value="no" class="button-17">No</button>
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
        $('document').ready(function() {
            //modifica dati
            $("#username").on("keyup", mostraTasto);
            $("#email").on("keyup", mostraTasto);
            $("#pswVecchia").on("keyup", mostraTasto);
            $("#dataNascita").on("change", mostraTasto);
            $("#proPic").on("change", mostraTasto);
            $("#defaultProPic").on("change", mostraTasto);
            
            $("#pswNuova").on("change", mostraTasto);
            
            function mostraTasto(){
                if($("#pswVecchia").val() != ""){
                    $("#pswNuova").prop( "disabled", false );
                    $("#pswConferma").prop( "disabled", false );
                    if($("#pswNuova").val() != ""){
                        $("#btnModifica").prop( "disabled", false );
                    }
                    else{
                        $("#btnModifica").prop( "disabled", true );
                    }
                }
                else{
                    $("#btnModifica").prop( "disabled", false );
                    $("#pswNuova").prop( "disabled", true );
                    $("#pswConferma").prop( "disabled", true );
                }
            }
        
            
            $('#formModifica').validate({
                
                rules: {
                    username: {
                        required: true,
                        minlength: 3,
                        maxlength: 18
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    pswNuova: {
                        minlength: 6,
                        maxlength: 15,
                        pswCheck: true
                    },
                    pswConferma: {
                        equalTo: '#pswNuova',
                    },
                },
                messages: {
                    username: {
                        required: "Inserire un nome utente",
                        minlength: "Lo username deve essere lungo almeno 3 caratteri",
                        maxlength: "Lo username non deve essere più lungo di 18 caratteri"
                    },
                    email: {
                        required: "Inserire una email",
                        email: "Inserire un indirizzo email valido"
                    },
                    pswNuova: {
                        minlength: "La nuova password deve essere lunga almeno 6 caratteri",
                        maxlength: "La nuova password non deve essere più lunga di 15 caratteri",
                        pswCheck: "La nuova password deve contenere almeno una maiuscola, un numero e un carattere speciale"
                    },
                    pswConferma: {
                        equalTo: "La password di conferma non corrisponde alla nuova password inserita",
                    },   
                }                       
            });
            
            $.validator.addMethod("pswCheck", function(value) {
               return /^[A-Za-z0-9\d=!?\-@._*]*$/.test(value) // consists of only these
                   && /[A-Z]/.test(value) // has a uppercase letter
                   && /\d/.test(value) // has a digit
                   && /[=!?\-@._*]/.test(value) // has a special character
            });
            
            //function submitForm() {
                $("#formModifica").on('submit',(function(e) {
                e.preventDefault();
                if($("#formModifica").valid())
                {
                $.ajax({
                    url: "scriptModificaDatiUtente.php",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response) {
                        if(response == "1") //lo username esiste già
                            {
                                $("#errusername").css("display", "inline-block");
                                $("#erremail").css("display", "none");
                                $("#errpswVecchia").css("display", "none");
                                $("#errpswNuova").css("display", "none");
                            }
                        else if(response == "2") //l'email esiste già
                            {
                                $("#erremail").css("display", "inline-block");
                                $("#errusername").css("display", "none");
                                $("#errpswVecchia").css("display", "none");
                                $("#errpswNuova").css("display", "none");
                            }
                        else if(response == "3") //la vecchia password inserita non corrisponde
                            {
                                $("#errpswVecchia").css("display", "inline-block");
                                $("#errusername").css("display", "none");
                                $("#erremail").css("display", "none");
                                $("#errpswNuova").css("display", "none");
                            }
                        else if(response == "4") //la vecchia password e quella nuova coincidono
                            {
                                $("#errpswNuova").css("display", "inline-block");
                                $("#errusername").css("display", "none");
                                $("#erremail").css("display", "none");
                                $("#errpswVecchia").css("display", "none");
                            }
                        else if(response == "5")
                            {
                                alert("È stato rilevato un tentativo di SQL Injection.");
                                $("#username").val("");
                                $("#email").val("");
                                $("#pswVecchia").val("");
                                $("#pswNuova").val("");
                                $("#pswConferma").val("");
                            }
                        else if(response=="b")
                            {
                                $("#errext").text("L'immagine può essere solo jpg, png o jpeg");
                                $("#errext").css("display", "inline-block");
                                //L'immagine può essere solo jpg, png o jpeg
                            }
                        else if(response=="c")
                            {
                                $("#errext").text("L'immagine pesa troppo");
                                $("#errext").css("display", "inline-block");
                                //L'immagine può essere solo jpg, png o jpeg
                            }
                        else if(response=="errore")
                            {
                                alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                            }
                        else if(response == "ok")
                            {   
                                $("#errusername").css("display", "none");
                                $("#erremail").css("display", "none");
                                $("#errpswVecchia").css("display", "none");
                                $("#errpswNuova").css("display", "none");
                                $("#errext").css("display", "none");
                                $("#modificaok").css("display", "block");
                                $('html,body').scrollTop(0);
                            } 
                    }
                })
                };
            }));
            
            //funzioni per cancellare il messaggio di errore quando l'utente modifica l'input
            $("#username").keyup(function()
                {
                    if($("#errusername").css("display")=="inline-block")
                            $("#errusername").css("display", "none");
                });
            
            $("#email").keyup(function()
                {
                    if($("#erremail").css("display")=="inline-block")
                            $("#erremail").css("display", "none");
                });
            
            $("#pswVecchia").keyup(function()
                {
                    if($("#errpswVecchia").css("display")=="inline-block")
                            $("#errpswVecchia").css("display", "none");
                });
            
            $("#pswNuova").keyup(function()
                {
                    if($("#errpswNuova").css("display")=="inline-block")
                            $("#errpswNuova").css("display", "none");
                });
            
            //elimina profilo
            $(".elimina").click(function()
            {
                $("#messaggioElimina").css("display", "inline-block");
            });
            
            $("#sE").click(function(){ //passo senza dati mi serve solo l'ID utente che posso ricavare dalla sessione
                $.ajax({
                    type: "POST",
                    url: "scriptEliminaProfilo.php",
                    success: function(response) {
                        if(response == "ok")
                                window.location.href = "index.php";
                        else if(response == "errore")
                            alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                    }
                });
            });
            
            $("#nE").click(function(){
                $("#messaggioElimina").css("display", "none");
            });
            
            //disattiva e attiva rinnovo automatico
            var x;
            $(document).on("click", ".disattivaRA", function()
            {
                $("#messaggioRA").css("display", "inline-block");
                $("#testoMessaggioRA").text("Vuoi disattivare il rinnovo automatico del tuo abbonamento?");
                x = 0;
            });
            
            $(document).on("click", ".attivaRA", function()
            {
                $("#messaggioRA").css("display", "inline-block");
                $("#testoMessaggioRA").text("Vuoi attivare il rinnovo automatico del tuo abbonamento?");
                x = 1;
            });
            
            $("#sRA").click(function(){ //passo senza dati mi serve solo l'ID utente che lo prendo dalla sessione
                $.ajax({
                    type: "POST",
                    data: {
                        x: x,
                    },
                    url: "scriptRA.php",
                    success: function(response) {
                        if(response == "ok")
                            {
                                if(x==0)
                                    {
                                        $("#rinnovoAutomaticoBtn").html("Attiva pagamento automatico dell'abbonamento");
                                        $("#rinnovoAutomaticoBtn").removeClass("disattivaRA").addClass("attivaRA");
                                    }
                                else
                                    {
                                        $("#rinnovoAutomaticoBtn").html("Disattiva pagamento automatico dell'abbonamento");
                                        $("#rinnovoAutomaticoBtn").removeClass("attivaRA").addClass("disattivaRA");
                                    }
                                if(response=="errore")
                                    {
                                        alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                                    }
                                $("#messaggioRA").css("display", "none");
                            }
                    }
                });
            });
                
            $("#nRA").click(function(){
                $("#messaggioRA").css("display", "none");
            });
            
            //disattiva abbonamento
            $(document).on("click", ".disattivaAbbonamento", function()
            {
                $("#messaggioDisattivaAbbonamento").css("display", "inline-block");
              
            });
            
            $("#sAbb").click(function(){
                $.ajax({
                    type: "POST",
                    url: "scriptDisattivaAbbonamento.php",
                    success: function(response) {
                        if(response == "ok")
                            {
                                $("#abbonamentoBtn").html("Attiva abbonamento");
                                $("#messaggioDisattivaAbbonamento").css("display", "none");
                                $(".disattivaRA").css("display", "none");
                                $(".attivaRA").css("display", "none");
                                $("#abbonamentoBtn").removeClass("disattivaAbbonamento").addClass("attivaAbbonamento");
                            }
                        else if(response=="errore")
                            {
                                alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                            }
                    }
                });
            });
                
            $("#nAbb").click(function(){
                $("#messaggioDisattivaAbbonamento").css("display", "none");
            });
            
            //attiva abbonamento
            $(document).on("click", ".attivaAbbonamento", function(){
                window.location.href="abbonamento.php";
            });
            
            //on submit si cancellano i campi della password
            $("#formModifica").submit(function(){
                $("#pswVecchia").val("");
                $("#pswNuova").val("");
                $("#pswConferma").val("");
            });
            
            
            //se carica proPic disattivo la selezione della defaultPic, se elimina proPic caricata attivo selezione della defaultPic
            $("#proPic").change(function(){
                if ($('#proPic').get(0).files.length === 1 && $("#defaultProPic").is(":checked")) {
                    $("#defaultProPic").prop( "checked", false );
                }
                else if ($('#proPic').get(0).files.length === 0 && $("#defaultProPic").is(":unchecked")){
                    $("#defaultProPic").prop( "checked", true );
                }
                else{ //nascondo messaggio errore
                    $("#errDefaultProPic").css("display", "none");
                }
            });
            
            //se attivo defaultProPic quando proPic caricata lo notifico all'utente
            $("#defaultProPic").change(function(){
                if ($('#proPic').get(0).files.length === 1 && $("#defaultProPic").is(":checked")) {
                    $("#errDefaultProPic").css("display", "inline-block");
                }
                else{
                    $("#errDefaultProPic").css("display", "none");
                }
            });
            
            
        //un utente deve avere almeno 13 anni
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1;
            var yyyy = today.getFullYear() - 13;
            if(dd<10){
              dd='0'+dd
            } 
            if(mm<10){
              mm='0'+mm
            } 

            today = yyyy+'-'+mm+'-'+dd;
            $("#dataNascita").prop("max", today);
            
        });
    </script>
    
</body>
</html>