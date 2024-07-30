<?php
//pagina per effettuare l'accesso al proprio account
    session_start();
    if(isset($_SESSION["sessioneUtente"]))
        header('Location: areaPersonale.php'); //se arriva alla pagina "login" mentre la sessione è attiva, viene rediretto alla sua area personale
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
	<title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header id="topNav">
        <a href="index.php">Home</a>;
        <a href='registrazione.php'>Registrati</a>
        <a href="index.php" class="logo"> <img src="immagini/stile/logoBlog.png"  alt="Logo Blog"> </a>
	</header>
   
    
    <div class="mainContainer">
        <div class="flexContainer">
            <div class="leftContainer">
                <?php
                    if(isset($_GET["registrazioneCompletata"])) //prende il get solo se viene mandato qui appena dopo essersi appena registrato
                        echo "<p class='formP'>Registrazione completata!</p>";
                ?>
                
                <form id="formLogin">
                    <h1 class="title">Area Login</h1>
                    
                    <div class="input-container ic1">
                        <input type="text" name="username" id="username" class="input" placeholder=""/>
                        <div class="cut"></div>
                        <label for="username" class="placeholder">Username</label>
                        <label for="username" id="errusername" style="display:none" class="error1">Il nome utente non esiste</label>
                    </div>
                    
                    <div class="input-container ic2">
                        <input type="password" name="psw" id="psw" class="input" placeholder=""/>
                        <div class="cut"></div>
                        <label for="psw" class="placeholder">Password</label>
                        <label for="psw" id="errpsw" style="display:none" class="error1">La password è errata</label>
                    </div>
                    
                    <button type="submit" class="submit">Invio</button>
                    <p class='littleP'>Non sei ancora registrato? <a href='registrazione.php'>Registrati ora</a></p>
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
            
            $('#formLogin').validate({
                
                rules: {
                    username: {
                        required: true,
                        minlength: 3,
                        maxlength: 18
                    },
                    
                    psw: {
                        required: true,
                        minlength: 6,
                        maxlength: 15
                    },
                },
                messages: {
                    username: "Nome utente non valido",
                    psw: "Password non valida",
                },
                
                submitHandler: submitForm                     
            });
            
            function submitForm() {
                var data = $("#formLogin").serialize();
                $.ajax({
                    type: "POST",
                    url: "scriptLogin.php",
                    data: data,
                    success: function(response) {
                        if(response == "1")
                            {
                                $("#errusername").css("display", "inline-block");
                                $("#errpsw").css("display", "none");
                            }
                        else if(response == "2")
                            {
                                $("#errpsw").css("display", "inline-block");
                                $("#errusername").css("display", "none");
                            }
                        else if(response == "5")
                            {
                                alert("È stato rilevato un tentativo di SQL Injection.");
                                $("#username").val("");
                                $("#psw").val("");
                            }
                        else if(response=="errore")
                            {
                                alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                            }
                        else if(response == "ok")
                            {
                                window.location.href = "areaPersonale.php";
                            }
                    }
                })
                 
            }
            
            $("#username").keyup(function()
                {
                    if($("#errusername").css("display")=="inline-block")
                        {
                            $("#errusername").css("display", "none");
                        }
                });
            
            $("#psw").keyup(function()
                {
                    if($("#errpsw").css("display")=="inline-block")
                        {
                            $("#errpsw").css("display", "none");
                        }
                });
                    
        });
    </script>
</body>
</html>