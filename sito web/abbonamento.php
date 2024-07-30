<?php
//pagina per l'abbonamento dell'utente
    session_start();

    if(!isset($_SESSION["sessioneUtente"]))
        header('Location: login.php');

    $IDutente = $_SESSION["sessioneUtente"];

    //verifico se l'utente è già abbonato
    try
    {
        include("dbconnection.php");
        $q = ("SELECT abbonato FROM utente WHERE IDutente = '$IDutente'");
        $sth = $conn->query($q);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
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
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<title>Abbonamento</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header id="topNav">
        <a href="index.php">Home</a>;
        <a href="index.php" class="logo"> <img src="immagini/stile/logoBlog.png"  alt="Logo Blog"> </a>
	</header>
    
    <?php
        //se l'utente è già abbonato, stampo un messaggio di errore e interrompo il caricamento della pagina.
       if($abbonato==1){
            echo"<p class='mediumP boldP'>Sei già abbonato al nostro servizio premium. Torna alla tua <a href='areaPersonale.php'>area personale </a></p>";
            die();
       }
    ?>
    
    <div class="mainContainer">
        <div class="flexContainer">
            <div class="leftContainer">
                <form id="formAbbonamento">
                    <h1 class="title">Abbonati</h1>
                    
                    <div class="input-container ic1">
                        <input type="text" name="intestatario" id="intestatario" placeholder="" class="input">
                        <div class="cut"></div>
                        <label for="intestatario" class="placeholder" >Nome e Cognome</label>
                    </div>
                    
                    <div class="input-container ic2">
                        <input type="text" name="numCarta" id="numCarta" placeholder="" class="input">
                        <div class="cut"></div>
                        <label for="numCarta" class="placeholder" >Numero carta</label>
                    </div>
                    
                    <div class="input-container ic2">
                        <input type="month" id="scadenzaCarta" name="scadenzaCarta" min="1900-01" class="input">
                        <div class="cut"></div>
                        <label for="scadenzaCarta" class="placeholder">Scadenza carta</label>
                    </div>
                    
                    <label for="rinnovoAutomatico" class="littleP boldP">Rinnovo Automatico</label>
                    <label class="switch">
                        <input type="checkbox" id="rinnovoAutomatico" name="rinnovoAutomatico" value="Rinnovo Automatico"> 
                        <span class="slider round"></span>
                    </label>
                    
                    <br> <br>

                    <button type="submit" class="submit">Abbonati</button>
                </form>
            </div>
        </div>
        
        <div id="messaggioOk" style="display: none">
            <h2 class="mediumP boldP" style="display: contents;"> L'operazione è andata a buon fine</h2>
            <p class="formP">Torna nella tua <a href="areaPersonale.php">area personale</a></p>
        </div>
    </div>
    
    <script>
        
        $('document').ready(function(){
            $("#formAbbonamento").validate({
                rules: {
                    intestatario: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    numCarta: {
                        required: true,
                        minlength: 16,
                        maxlength: 16,
                        digits: true,
                    },
                    scadenzaCarta: {
                        required: true,
                    },
                },
                messages: {
                    intestatario: {
                        required: "È obbligatorio inserire nome e cognome dell'intestatario",
                        minlength: "Il nome e il cognome dell'intestatario devono essere lunghi almeno 3 caratteri",
                        maxlength: "Il nome e il cognome dell'intestatario devono essere lunghi al massimo 50 caratteri"
                    },
                    numCarta: {
                        required: "È obbligatorio inserire un numero di carta",
                        minlength: "Inserire un numero di carta valido",
                        maxlength: "Inserire un numero di carta valido",
                        digits: "Inserire un numero di carta valido",
                    },
                    scadenzaCarta: {
                        required: "Inserire mese e anno di scadenza validi per la carta",
                    },
                },
                
                submitHandler: submitForm
            });
            
            function submitForm(){
                var intestatario = $("#intestatario").val();
                var numCarta = $("#numCarta").val();
                var scadenzaCarta = $("#scadenzaCarta").val();
                var checkRA = $("#rinnovoAutomatico").is(":checked");
                var rinnovoAutomatico = 0;
                if(checkRA)
                    rinnovoAutomatico = 1;
                
                $.ajax({
                    type: "POST",
                    url: "scriptAbbonamento.php",
                    data: {
                        intestatario: intestatario,
                        numCarta: numCarta,
                        scadenzaCarta: scadenzaCarta,
                        rinnovoAutomatico: rinnovoAutomatico,
                    },
                    success: function(response) {
                        if(response == "ok")
                            {
                                $("#messaggioOk").css("display", "inline-block");
                                $("#formAbbonamento").css("display", "none");
                            }
                        else if(response == "5")
                            {
                                alert("È stato rilevato un tentativo di SQL Injection.");
                                $("#intestatario").val("");
                                $("#numCarta").val("");
                            }
                        else if(response == "errore")
                            {
                                alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                            }
                    }
                })
            }
            
            //la data di scadenza della carta deve essere almeno il mese prossimo
            var today = new Date();
            var mm = today.getMonth()+2;
            var yyyy = today.getFullYear();

            if(mm<10){
              mm='0'+mm
            } 

            today = yyyy+'-'+mm;
            $("#scadenzaCarta").prop("min", today);
            
        });
        
    </script>
    
</body>
</html>