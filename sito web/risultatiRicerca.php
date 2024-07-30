<?php
//pagina che mostra i risultati della ricerca
    session_start();
    $sessione = false;
    if(isset($_SESSION["sessioneUtente"]))
        $sessione = true;
    
    if(isset($_GET["testoRicerca"]))
    {
        $testoRicercaEsterno = $_GET["testoRicerca"];
        $categoriaSelezionata = $_GET["selezione"];
        echo "<input style='display: none' type='text' id='testoRicercaEsterno' value='" . $testoRicercaEsterno . "'>";
        echo "<input style='display: none' type='text' id='categoriaSelezionata' value='" . $categoriaSelezionata . "'>";
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>Risultati Ricerca</title>
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
    
    <div class="mainContainer">
        <div class="postContainer">
            <h1>Risultati ricerca</h1>
            <div id="formRicerca">
                <input type="text" id="campoRicerca" placeholder="Cerca..." class="sottotema">
                <select id="selezione">
                    <option value="Blog">Blog</option>
                    <option value="Post">Post</option>
                    <option value="Utente">Utente</option>
                    <option value="Categoria">Categoria</option>
                </select>
            </div>
                <div id="risultati" class="post">
                    <!--I risultati vengono gestiti con jquery e ajax (v. scriptRicerca.php)-->
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
            
            var testoRicercaEsterno = $("#testoRicercaEsterno").val();
            var categoriaSelezionata = $("#categoriaSelezionata").val();
        
            if(testoRicercaEsterno != "" && categoriaSelezionata != "")
            {
                $("#campoRicerca").val(testoRicercaEsterno);
                $("#selezione").val(categoriaSelezionata);
                aggiornaRisultati();
            }
            
            $("#campoRicerca").on("keyup", aggiornaRisultati);
            $("#selezione").on("change", aggiornaRisultati);
            
            function aggiornaRisultati()
            {
                $.ajax({
                    type: "GET",
                    url: "scriptRicerca.php",
                    data: 
                    {
                        testo: $("#campoRicerca").val(),
                        filtro: $("#selezione").val(),
                    },
                    
                    success: function(data){
                        $("#risultati").show();
                        $("#risultati").html(data);
                    }
                })
            }
        });
        
 
        $(document).on("click", "#indicePagineContainer a", function(e){
            e.preventDefault();
            page = $(this).text();
            jQuery("#risultati").load("scriptRicerca.php?page=" + page + "&filtro=" +  $("#selezione").val() + "&testo=" + $("#campoRicerca").val());
            })
            
    </script>
</body>
</html>