<?php
//pagina per la modifica delle info di un post
    session_start();
    if(!isset($_SESSION["sessioneUtente"]) or !isset($_GET["IDpost"]))
        header('Location: login.php');

    $IDpost = $_GET["IDpost"];

    try
    {
        include("dbconnection.php");
        $q = ("SELECT titolo, sottotitolo, testoPost, IDblog FROM post WHERE IDpost = '$IDpost'");
        $sth = $conn->query($q);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $IDblog = $result["IDblog"];
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<title>Modifica post</title>
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
                <form id="formModificaPost">
                    <h1 class="title">Modifica Post</h1>
                    
                    <!-- TITOLO -->
                    <div class="input-container ic1">
                        <input type="text" name="titolo" id="titolo" placeholder="" value="<?php echo stripslashes($result['titolo'])?>" class="input">
                        <div class="cut"></div>
                        <label for="titolo" class="placeholder">Titolo Post</label>
                        <label for="titolo" id="errtitolo" style="display:none" class="error1">Esiste già un post con questo titolo nel tuo blog</label>
                    </div>
                    
                    <div class="input-container ic2">
                        <input type="text" name="sottotitolo" id="sottotitolo" placeholder="" class="input" value="<?php echo stripslashes($result['sottotitolo'])?>">
                        <div class="cut"></div>
                        <label for="sottotitolo" class="placeholder">Sottotitolo</label>
                    </div>
                    
                    <textarea id="contenuto" name="contenuto" rows="10" cols="70" placeholder="Scrivi il tuo post..."><?php echo stripslashes($result['testoPost'])?></textarea><br>
                    
                    <input id="IDpost" name="IDpost" type="text" style="display: none" value="<?php echo $IDpost?>">
                    <input id="IDblog" name="IDblog" type="text" style="display: none" value="<?php echo $IDblog?>">
                    
                    <br><br>
                    
                    <!--input di un'immagine-->
                    <label for="imgPost" class="littleP boldP">Inserisci una immagine rappresentativa del post</label>
                    <br><br>
                    <input type="file" id="imgPost" name="imgPost" class="custom-file-input" style="width: 100%;" accept=".jpg,.jpeg,.png">
                    <label for="imgPost" id="errtext" style="display:none"></label><br>
                    <br><br>
                    
                    <label for='defaultPostPic' class="littleP boldP">Imposta l'immagine di default</label>
                    <label class="switch">
                        <input type='checkbox' id='imgDefault' name='imgDefault' value=''>
                        <span class="slider round"></span>
                    </label>

                    <button type="submit" class="submit">Modifica Post</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        
        $('document').ready(function(){
            
            $("#formModificaPost").validate({
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
                    sottotitolo: "Inserire un sottotitolo adeguato",
                    contenuto: "Inserire un contenuto adeguato"
                },
                
            });
            
            $("#formModificaPost").on('submit',(function(e) {
                e.preventDefault();
                
                if($("#formModificaPost").valid())
                {
                    var nodoImgDefault = $("#imgDefault").is(":checked");

                    imgDefault = 0
                    if(nodoImgDefault)
                        imgDefault = 1

                    formData = new FormData(this);
                    formData.append("imgDefault", imgDefault);  
                
                    $.ajax({
                        url: "scriptModificaPost.php",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(data) {
                            if(data == "a") //esiste già un post con questo titolo in questo blog
                                {
                                     $("#errtitolo").css("display", "inline-block");
                                }
                            if(data == "b")
                                {
                                    $("#errtext").text("L'estensione può essere solo png, jpg o jpeg");
                                    $("#errtext").css("display", "block");
                                }
                            if(data == "c")
                                {
                                    $("#errtext").text("L'immagine è troppo pesante");
                                    $("#errtext").css("display", "block");
                                }
                            else if(data == "5")
                                {
                                    alert("È stato rilevato un tentativo di SQL Injection.");
                                    $("#titolo").val("");
                                    $("#sottotitolo").val("");
                                    $("#contenuto").val("");
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