<?php
//pagina di creazione blog
    session_start();
    if(!isset($_SESSION["sessioneUtente"]))
        header('Location: login.php');

    $IDutente = $_SESSION["sessioneUtente"];

    //controllo se l'utente è abbonato
    try
    {
        include("dbconnection.php");
        $q = ("SELECT abbonato FROM utente WHERE IDutente = '$IDutente'");
        $sth = $conn->query($q);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $abbonato = $result["abbonato"];
        $sessione = true;
        include("scriptBloccoEta.php");
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
	<title>Crea blog</title>
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
                <!-- UTENTE NON ABBONATO -->    
                <?php
                    try
                    {//controllo se l'utente sta creando più blog di quanto è possibile
                        $q = ("SELECT COUNT(*) FROM blog as b, autore as a WHERE a.IDutente = '$IDutente' and a.IDblog = b.IDblog");
                        $sth = $conn->query($q);
                        $result = $sth->fetch(PDO::FETCH_ASSOC);

                        if($result["COUNT(*)"] >=5 and $abbonato==0)
                        {
                            echo "<p id='limiteBlog' class='mediumP boldP'>Non puoi creare più di cinque blog!</p>
                            <p class='formP'>Se vuoi crearne un numero illimitato, <a href='abbonamento.php'>passa a premium</a>.</p>";
                            die();
                        }
                    }
                    catch(PDOException $e)
                    {
                        echo "Si è verificato un errore imprevisto. Impossibile terminare il caricamento della pagina. Torna alla <a href='index.php'>home</a><br><br>";
                        die("Codice errore: " . $e->getMessage());
                    }
                ?>
                
                <h1 class="title">Crea Blog</h1>
                
                <form id="formCreazioneBlog">
                    <!-- TITOLO -->
                    <div class="input-container ic1">
                        <input type="text" name="titolo" id="titolo" class="input" placeholder="">
                        <div class="cut"></div>
                        <label for="titolo" class="placeholder">Titolo Blog</label>
                        <label for="titolo" id="errtitolo" style="display:none" class="error1">Esiste già un blog con questo titolo</label>
                    </div>
                    
                    <!-- VIETATO AI MINORI -->
                    <label for='limiteEta' class="littleP boldP">Vietato ai minori</label>
                    <label class="switch">
                    <input type='checkbox' id='limiteEta' name='limiteEta' value='limiteEta' <?php if($blocco) echo "disabled" ?>>
                    <span class="slider round"></span>
                    </label>
                    <label for='limiteEta' id='errlimiteEta' style='display:none' class='error1'>Non sei ancora maggiorenne. Non puoi attivare questa opzione</label>
                    <br><br>
                    
                    <textarea id="presentazione" name="presentazione" rows="10" cols="70" placeholder="Scrivi la presentazione..."></textarea>
                    
                    <br><br>

                    <!--GESTIONE TEMI-->
                    <p class="littleP boldP">Scegli i sottotemi del tuo blog:</p>
                    <?php 
                        //stampo tutti i temi e sottotemi del blog
                        try
                        {
                            $q = ("SELECT IDtema, tema FROM tema");
                            $sth = $conn->query($q);

                            while($row = $sth->fetch(PDO::FETCH_ASSOC))
                            {
                                $IDtema = $row['IDtema'];
                                $tema = $row['tema'];
                                echo "<input class='checkboxTemi' type='checkbox' id='t" . $IDtema . "' name='" . $IDtema . "' value='" . $tema . "'>";
                                echo "<label for='t" . $IDtema . "'> " . $tema . "</label><br>";

                                echo "<div style='margin-left: 50px; display: none' class='sottotemi'>";
                                    $q2 = ("SELECT IDsottotema, sottotema FROM sottotema WHERE macrotema = '$IDtema'");
                                    $sth2 = $conn->query($q2);
                                    while($row2 = $sth2->fetch(PDO::FETCH_ASSOC))
                                    {
                                        $IDsottotema = $row2['IDsottotema'];
                                        $sottotema = $row2['sottotema'];
                                        echo "<input class='sottotema' type='checkbox' id='" . $IDsottotema . "' name='" . $IDsottotema . "' value='" . $sottotema . "'>";
                                        echo "<label for='" . $IDsottotema . "'> " . $sottotema . "</label><br>";
                                    }
                                echo "</div>";

                            }
                        }
                        catch(PDOException $e)
                        {
                            echo "Si è verificato un errore imprevisto. Impossibile terminare il caricamento della pagina. Torna alla <a href='index.php'>home</a><br><br>";
                            die("Codice errore: " . $e->getMessage());
                        }

                    ?>
                    <input type="text" id="arrayIdSottotemi" style="display:none">
                    
                    <br>

                    <p class="littleP boldP">Non trovi il sottotema di cui hai bisogno? Crealo tu! (sono ammessi solo caratteri)</p>
                    <div id="divTemi">
                        <input type="text" placeholder="sottotema" class="last sottotema" maxlength= "15">
                        <select name="macrotema" class="macrotema">
                            <?php
                            //stampo l'elenco di macrotemi disponibili
                                try
                                {
                                    $q = ("SELECT IDtema, tema FROM tema");
                                    $sth = $conn->query($q);

                                    while($row = $sth->fetch(PDO::FETCH_ASSOC))
                                    {
                                        echo "<option value='" . $row['IDtema'] . "'>" . $row['tema'] . "</option>";
                                    }
                                }
                                catch(PDOException $e)
                                {
                                    echo "Si è verificato un errore imprevisto. Impossibile terminare il caricamento della pagina. Torna alla <a href='index.php'>home</a><br><br>";
                                    die("Codice errore: " . $e->getMessage());
                                }
                            ?>
                        </select>
                        <br>
                    </div>
                    
                    <br>
                    
                    <p class="littleP boldP">Scegli uno stile per il tuo blog:</p>
                    
                    <input type="radio" id="stile1" name="stile" value="1" checked="checked">
                    <label for="stile1">Stile 1</label>
                    <input type="radio" id="stile2" name="stile" value="2">
                    <label for="stile2">Stile 2</label>
                    <input type="radio" id="stile3" name="stile" value="3">
                    <label for="stile3">Stile 3</label>
                    <?php
                        if($abbonato)
                        {
                        ?>
                            <input type="radio" id="stile4" name="stile" value="4">
                            <label for="stile4">Stile 4</label>
                            <input type="radio" id="stile5" name="stile" value="5">
                            <label for="stile5">Stile 5</label>
                            <input type="radio" id="stile6" name="stile" value="6">
                            <label for="stile6">Stile 6</label>
                    <?php
                        }
                    ?>
                    <div id="mostraStili" style="margin-top:1%; display: table; border: 1px solid skyblue; border-radius: 10px; padding: 2%;">
                        <p>Sfondo:</p>
                        <img id="sfondo" src="immagini/sfondiStile/sfondo1.png" width="150px" height="150px">
                        <p>Font:</p>
                        <p id="font">Times new Roman</p>
                    </div>
                    <br>
                    <br>

                    <label for="imgBlog" class="littleP boldP">Inserisci una immagine rappresentativa del blog</label>
                    <br><br>
                    <input type="file" id="imgBlog" name="imgBlog" class="custom-file-input" style="width: 100%;" accept=".jpg,.jpeg,.png">
                    <label for="imgBlog" id="errext" style="display:none" class="error1"></label><br>
                    
                    <button type="submit" class="submit">Crea Blog</button>
                </form>
                
            </div>
        </div>
    </div>
    
    <script>
        $('document').ready(function(){
            
            //gestione dei campi nuovi sottotemi
            $(document).on("keyup", "#divTemi .sottotema:last", function()
                {
                    $("#divTemi").append("<input type='text' placeholder='sottotema' class='last sottotema' maxlength= '15'>");
                    $(".macrotema").clone().appendTo("#divTemi");
                    $(".macrotema").first().removeClass("macrotema");
                    $("#divTemi").append("<br>");
            })


            $(document).on("keyup", "#divTemi .sottotema", function(e){
                this.value = this.value.replace(/[^a-zA-Z ]/, '');
                if($(this).val()=="")
                    {
                        $(this).next("select").remove();
                        $(this).next("br").remove();
                        $(this).remove();
                    }
            })
            
            $("#formCreazioneBlog").validate({
                rules: {
                    titolo: {
                        required: true,
                        minlength: 3,
                        maxlength: 40
                    },
                    presentazione: {
                        required: true,
                        minlength: 20,
                        maxlength: 512
                    },
                },
                messages: {
                    titolo: "Inserire un titolo corretto",
                    presentazione: "Inserire una presentazione adeguata"
                }
            });
            
            $("#formCreazioneBlog").on('submit',(function(e) {
                e.preventDefault();
                
                if($("#formCreazioneBlog").valid())
                    {   
                        //rimuovo i campi di testo vuoti
                        $('#divTemi input').each(function() {
                            if($.trim($(this).val()).length == 0)
                                {
                                    $(this).next("select").remove();
                                    $(this).next("br").remove();
                                    $(this).remove();
                                }
                        });
                        
                        var sottotemiSelezionati = $(".sottotema:checked");
                        for(var i = 0; i < sottotemiSelezionati.length; i++)
                            {
                                $("#arrayIdSottotemi").val($("#arrayIdSottotemi").val() + sottotemiSelezionati[i].id + ",");
                            }

                        var sottotemiNuovi = [];
                        var nodiTestoSottotemiNuovi = $("#divTemi").children("input");

                        var nodiSelectSottotemiNuovi = $("#divTemi").children("select");

                        for(var i = 0; i<nodiTestoSottotemiNuovi.length; i++)
                            {
                                var sottotemaMacrotema = [$.trim(nodiTestoSottotemiNuovi[i].value), nodiSelectSottotemiNuovi[i].value];

                                sottotemiNuovi.push(sottotemaMacrotema);
                            }
                        //la variabile sottotemiNuovi è un array di bigrammi che contengono il nuovo sottotema e il macrotema di cui sono sottotemi
                        sottotemiNuovi = sottotemiNuovi.filter(( t={}, a=> !(t[a]=a in t) )); //elimina i bigrammi duplicati

                        formData = new FormData(this);
                        formData.append("arrayIdSottotemi", $("#arrayIdSottotemi").val());
                        formData.append("arrayNuoviSottotemi", sottotemiNuovi);

                        $.ajax({
                            url: "scriptCreaBlog.php",
                            type: "POST",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData:false,
                            success: function(data) {
                                if(data == "a")
                                    {
                                        $("#errtitolo").css("display", "inline-block");
                                        $("#arrayIdSottotemi").val("");
                                        sottotemiNuovi = [];
                                    }
                                else if(data == "b")
                                    {
                                        $("#errext").text("L'immagine può essere solo png, jpg, jpeg");
                                        $("#errext").css("display", "inline-block");
                                        $("#arrayIdSottotemi").val("");
                                        sottotemiNuovi = [];
                                    }
                                else if(data == "c")
                                    {
                                        $("#errext").text("L'immagine non può occupare più di 1000KB");
                                        $("#errext").css("display", "inline-block");
                                        $("#arrayIdSottotemi").val("");
                                        sottotemiNuovi = [];
                                    }
                                else if(data == "5")
                                    {
                                        alert("È stato rilevato un tentativo di SQL Injection.");
                                        $("#titolo").val("");
                                        $("#presentazione").val("");
                                    }
                                else if(data == "errore")
                                    {
                                        alert("Si è verificato un errore nella gestione della tua richiesta. Ricaricare la pagina e riprovare.");
                                    }
                                else if(!isNaN(data))
                                    {
                                        var redirect = "blog.php?IDblog=" + data;
                                        window.location.href = redirect;
                                    }

                            }
                        });
                    }
            }));
            $("#titolo").keyup(function() //funzione per cancellare il messaggio di errore quando l'utente modifica l'input
                {
                    if($("#errtitolo").css("display")=="inline-block")
                            $("#errtitolo").css("display", "none");
                });
            
            $(".checkboxTemi").on("change", function()
                                 {
                var divSottotemi = $(this).next().next().next();
                if(this.checked)
                    divSottotemi.css("display", "block");
                else
                    {
                        divSottotemi.css("display", "none");
                        
                        var children=divSottotemi.children("input");
                        for(var i=0;i<children.length;i++)
                        {
                            children[i].checked = false;
                        }
                    }
            })
            
            $(".switch").on("click", function() {
                if($("#limiteEta").prop('disabled')){
                    $("#errlimiteEta").css("display", "inline");
                }
            })
            
            $("#presentazione").on("focus", function() {
                if($("#limiteEta").prop('disabled')){
                    $("#errlimiteEta").css("display", "none");
                }
            })
            
            
            $("input[name='stile']").on("change", function()
                                       {
                var stileSelezionato = $("input[name='stile']:checked").val();
                $("#sfondo").attr("src", "immagini/sfondiStile/sfondo" + stileSelezionato + ".png");
                
                if(stileSelezionato==1)
                    {
                        $("#font").text("Times new Roman");
                        $("#font").css("font-family", "'Times New Roman', Times, serif");
                    }
                else if(stileSelezionato==2)
                    {
                        $("#font").text("Helvetica");
                        $("#font").css("font-family", "Arial, Helvetica, sans-serif");
                    }
                else if(stileSelezionato==3)
                    {
                        $("#font").text("Comic Sans MS");
                        $("#font").css("font-family", "'Comic Sans MS', 'Comic Sans', cursive");
                    }
                else if(stileSelezionato==4)
                    {
                        $("#font").text("Arial Narrow");
                        $("#font").css("font-family", "Arial Narrow, sans-serif");
                    }
                else if(stileSelezionato==5)
                    {
                        $("#font").text("Optima");
                        $("#font").css("font-family", "Optima, sans-serif");
                    }
                else if(stileSelezionato==6)
                    {
                        $("#font").text("Verdana");
                        $("#font").css("font-family", "Verdana, sans-serif");
                    }
            })
            
        });
        
    </script>
</body>
</html>