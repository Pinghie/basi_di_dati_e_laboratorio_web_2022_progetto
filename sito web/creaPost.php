<?php
//pagina di creazione post
    session_start();
    if(!isset($_SESSION["sessioneUtente"]))
        header('Location: login.php');

    if(!isset($_GET["IDblog"]))
        header('Location: areaPersonale.php');
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
	<title>Crea post</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header id="topNav">
        <a href="index.php">Home</a>;
        <a href="areaPersonale.php">Area Personale</a>;
        <a href="index.php" class="logo"> <img src="immagini/stile/logoBlog.png"  alt="Logo Blog"> </a>
	</header>
    
    <div class="mainContainer">
        <div class="flexContainer">
            <div class="leftContainer">
                <form id="formCreazionePost">
                    <h1>Crea Post</h1>
                    
                    <!-- TITOLO POST -->
                    <div class="input-container ic1">
                        <input type="text" name="titolo" id="titolo" class="input" placeholder="">
                        <div class="cut"></div>
                        <label for="titolo" class="placeholder">Titolo Post</label>
                        <label for="titolo" id="errtitolo" style="display:none" class="error1">Esiste già un post con questo titolo nel tuo blog</label>
                    </div>
                    
                    <!-- SOTTOTITOLO POST -->
                    <div class="input-container ic2">
                        <input type="text" name="sottotitolo" id="sottotitolo" placeholder="" class="input">
                        <div class="cut"></div>
                        <label for="sottotitolo" class="placeholder">Sottotitolo</label>
                    </div>
                    
                    <!-- CONTENUTO POST -->
                    <textarea id="contenuto" name="contenuto" rows="10" cols="70" placeholder="Scrivi il tuo post..."></textarea>
                    <br>
                
                    <input id="IDblog" name="IDblog" type="text" style="display: none" value="<?php echo $_GET["IDblog"]?>">
                    <br><br>
                    
                    <!--input di un'immagine-->
                    <label for="imgPost" class="littleP boldP">Inserisci una immagine rappresentativa del post</label>
                    <br><br>
                    <input type="file" id="imgPost" name="imgPost" class="custom-file-input" style="width: 100%;" accept=".jpg,.jpeg,.png">
                    <label for="imgPost" id="errext" style="display:none"></label><br>
                    <br><br>

                    <button type="submit" class="submit">Crea Post</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        
        $('document').ready(function(){
            
            $("#formCreazionePost").validate({
                rules: {
                    titolo: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    sottotitolo: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    contenuto: {
                        required: true,
                        minlength: 20,
                        maxlength: 512
                    },
                },
                messages: {
                    titolo: "Inserire un titolo corretto",
                    sottotitolo: "Inserire un sottotitolo corretto",
                    contenuto: "Inserire un contenuto adeguato",
                }
            });
            
            $("#formCreazionePost").on('submit',(function(e) {
                e.preventDefault();
                if($("#formCreazionePost").valid())
                {
                    $.ajax({
                        url: "scriptCreaPost.php",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(data) {
                            if(data == "a")
                                {
                                     $("#errtitolo").css("display", "inline-block");
                                }
                            else if(data == "b")
                                {
                                    $("#errext").text("L'immagine può essere solo png, jpg, jpeg");
                                    $("#errext").css("display", "inline-block");
                                }
                            else if(data == "c")
                                {
                                    $("#errext").text("L'immagine è troppo pesante");
                                    $("#errext").css("display", "inline-block");
                                }
                            else if(data == "5")
                            {
                                alert("È stato rilevato un tentativo di SQL Injection.");
                                $("#titolo").val("");
                                $("#sottotitolo").val("");
                                $("#contenuto").val("");
                            }
                            else if(data == "errore")
                            {
                                alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                            }
                            else if(!isNaN(data))
                                {
                                    var redirect = "post.php?IDpost=" + data;
                                    window.location.href = redirect;
                                }
                        }
                    });
                };
            }));
            
            $("#titolo").keyup(function() //funzione per cancellare il messaggio di errore quando l'utente modifica l'input
                {
                    if($("#errtitolo").css("display")=="inline-block")
                        {
                            $("#errtitolo").css("display", "none");
                        }
                });
            
        });
        
    </script>
</body>
</html>