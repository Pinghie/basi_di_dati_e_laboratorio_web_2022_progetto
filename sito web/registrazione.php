<?php
//pagina per effettuare la registrazione al sito
    session_start();
    if(isset($_SESSION["sessioneUtente"]))
        header('Location: index.php');
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
	<title>Registrazione</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header id="topNav">
        <a href="index.php">Home</a>;
        <a href="index.php" class="logo"> <img src="immagini/stile/logoBlog.png"  alt="Logo Blog"> </a>
	</header>
    
    <div class="mainContainer">
        <div class="flexContainer">
            <div class="leftContainer">
                <form id="formRegistrazione" enctype= "multipart/form-data" >
                    <h1 class="title">Area Registrazione</h1>
                    <div class="input-container ic1">
                        <input type="text" name="username" id="username" class="input" placeholder=""/>
                        <div class="cut"></div>
                        <label for="username" class="placeholder">Username</label>
                        <label for="username" id="errusername" style="display:none" class="error1">Il nome utente esiste già</label>
                    </div>
                    
                    <div class="input-container ic2">
                        <input type="email" name="email" id="email" class="input" placeholder=""/>
                        <div class="cut"></div>
                        <label for="email" class="placeholder">Email</label>
                        <label for="email" id="erremail" style="display:none" class="error1">Questa email è già registrata</label>
                    </div>
                    
                    <div class="input-container ic2">
                        <input type="password" name="psw" id="psw" class="input" placeholder=""/>
                        <div class="cut"></div>
                        <label for="psw" class="placeholder">Password</label>
                    </div>
                    
                    <div class="input-container ic2">
                        <input type="password" name="pswConferma" id="pswConferma" class="input" placeholder=""/>
                        <div class="cut"></div>
                        <label for="pswConferma" class="placeholder">Conferma Password</label>
                    </div>
                    
                    <div class="input-container ic2">
                        <input type="date" name="dataNascita" id="dataNascita" class="input" min="1900-01-01">
                        <div class="cut"></div>
                        <label for="dataNascita" class="placeholder">Data di nascita</label>
                    </div>
                    
                    <label for="proPic" class="formP">Inserisci un'immagine del profilo (opzionale)</label>
                    <input type="file" id="proPic" class="custom-file-input" name="proPic" style="width: 100%;" accept=".jpg,.jpeg,.png">
                    <label for="proPic" id="errext" style="display:none" class="error1">L'immagine può essere solo png, jpg, jpeg</label>
                    
                    <button type="submit" class="submit">Invio</button>
                </form>
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
            
            $('#formRegistrazione').validate({
                
                rules: {
                    username: {
                        required: true,
                        minlength: 3,
                        maxlength: 18,
                        soloLettere: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    psw: {
                        required: true,
                        minlength: 6,
                        maxlength: 15,
                        pswCheck: true
                    },
                    pswConferma: {
                        required: true,
                        equalTo: '#psw',
                    },
                    dataNascita: {
                        required: true,
                    }
                },
                messages: {
                    username: {
                        required: "È obbligatorio inserire uno username",
                        minlength: "Lo username deve essere lungo almeno 3 caratteri",
                        maxlength: "Lo username non deve essere più lungo di 18 caratteri",
                        soloLettere: "Lo username può contenere solo lettere"
                    },
                    email: {
                        required: "È obbligatorio inserire l'email",
                        email: "Inserire un indirizzo email valido"
                    },
                    psw: {
                        required: "È obbligatorio inserire la password",
                        minlength: "La password deve essere lunga almeno 6 caratteri",
                        maxlength: "La password non deve essere più lunga di 15 caratteri",
                        pswCheck: "La password deve contenere almeno una maiuscola, un numero e un carattere speciale"
                    },
                    pswConferma: {
                        required: "È obbligatorio inserire la password di conferma",
                        equalTo: "La password di conferma non corrisponde alla password inserita",
                    },
                    dataNascita: {
                        required: "È obbligatorio inserire la data di nascita",
                    }
                }                    
            });
            
            $.validator.addMethod("pswCheck", function(value) {
               return /^[A-Za-z0-9\d=!?\-@"'\\/._*]*$/.test(value)
                   && /[A-Z]/.test(value)
                   && /\d/.test(value)
                   && /[=!?\-@._*]/.test(value) //deve avere un carattere speciale
            });
            
            $.validator.addMethod("soloLettere", function(value, element) {
                    return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
                }, "Lo username può contenere solo lettere");
            
             $("#formRegistrazione").on('submit',(function(e) {
                 e.preventDefault();
                 if($("#formRegistrazione").valid())
                    {
                $.ajax({
                    url: "scriptRegistrazione.php",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data) {
                        if(data == "1")
                            {
                                $("#errusername").css("display", "inline-block");
                            }
                        else if(data == "2")
                            {
                                $("#errusername").css("display", "none");
                                $("#erremail").css("display", "inline-block");
                            }
                        else if(data=="3")
                            {
                                $("#errext").text("L'immagine può essere solo jpg, png o jpeg");
                                $("#errext").css("display", "inline-block");
                            }
                        else if(data=="4")
                            {
                                $("#errext").text("L'immagine pesa troppo");
                                $("#errext").css("display", "inline-block");
                            }
                        else if(data=="5")
                            {
                                alert("È stato rilevato un tentativo di SQL Injection.");
                                $("#username").val("");
                                $("#email").val("");
                                $("#psw").val("");
                                $("#pswConferma").val("");
                            }
                        else if(data=="errore")
                            {
                                alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                            }
                        else if(data == "ok")
                            {
                                $("#errusername").css("display", "none");
                                $("#erremail").css("display", "none");
                                window.location.href = "login.php?registrazioneCompletata=1";
                            }
                            
                    },
                });
                    };
                 
            }));
            
            //funzioni per cancellare il messaggio di errore quando l'utente modifica l'input
            $("#username").keyup(function()
                {
                    if($("#errusername").css("display")=="inline-block")
                        {
                            $("#errusername").css("display", "none");
                        }
                });
            
            $("#email").keyup(function()
                {
                    if($("#erremail").css("display")=="inline-block")
                        {
                            $("#erremail").css("display", "none");
                        }
                });
            
            //un utente deve avere almeno 13 anni per iscriversi
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
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