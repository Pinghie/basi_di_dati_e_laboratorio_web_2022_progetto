<?php
//homepage del sito
    $sessione = false;
    session_start();
    if(isset($_SESSION["sessioneUtente"]))
    {
        $sessione = true;
        $IDutente = $_SESSION["sessioneUtente"];
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
    <link rel="stylesheet" type="text/css" href="style.css">
	<title>Homepage</title>
</head>
<body>
    <div class="topHeader">
		<h1>SentencePress</h1>
		<h2>scrivi quello che hai da dire</h2>
	</div>

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

        <a href="index.php" class="logo"> <img src="immagini/stile/logoBlog.png"  alt="Logo Blog"> </a>
	</header>
    
    <div class="mainContainer">
        <div class="banner flexContainer">
            <div class="flexContainer contentContainer">
                <div>
                <?php
                    if($sessione){
                        echo "
                        <h1>Bentornato, " . $_SESSION["nomeUtente"] . "</h1>
                        <p>Controlla le novità su SentencePress</p>
                        ";
                    }
                    else{
                        echo "
                        <h1>Benvenuto su SentencePress</h1>
                        <p>Qui troverai blog su qualsiasi tema</p>
                        ";
                    }
                ?>
                </div>
            
            </div>
        </div>
        
		<div class="flexContainer">
            <div class="leftCointaner">
            
                <form id="formRicerca" action="risultatiRicerca.php" method="get">
                    <input type="text" id="testoRicerca" name = "testoRicerca" placeholder=" Cerca">
                    <select id="selezione" name="selezione" form="formRicerca">
                        <option value="Blog">Blog</option>
                        <option value="Post">Post</option>
                        <option value="Utente">Utente</option>
                        <option value="Categoria">Categoria</option>
                    </select>
                    <button type="submit" class="button-17" style="position: absolute; padding:1%; ">Cerca</button>
                </form>
            
            </div>
        </div>
        
        
        <div class="postContainer">
            <h1>Blog nati da poco</h1>
            <div class="post">
            
            <?php
                try
                {
                    include("dbconnection.php");
                    
                    $q = ("SELECT b.IDblog, b.titolo, b.data, b.immagine, a.IDutente, u.username FROM blog b, autore a, utente u WHERE b.IDblog = a.IDblog and a.IDutente = u.IDutente and b.archiviato = 0 ORDER BY b.IDblog DESC LIMIT 4");
                    $sth = $conn->query($q);

                     if($row = $sth->fetch(PDO::FETCH_ASSOC)){
                        do{
                            ?>

                            <div class='cardBlog'> 
                                <div class='blogImg'>
                                    <img src='immagini/blogPics/<?php echo $row["immagine"] ?>'> 
                                </div>
                                <p class='blogAutore'><a href='paginaUtente.php?username=<?php echo $row["username"]?>'><?php echo $row["username"]?></a></p> 
                                <p class='blogTitle'><?php echo stripslashes($row["titolo"])?></p> 
                                <p class='blogData'><?php echo $row["data"] ?></p>

                                <button class="button-17" onclick="window.location.href='blog.php?IDblog=<?php echo $row["IDblog"] ?>';">Vai al Blog</button><br>
                            </div>

                    <?php
                        }while($row = $sth->fetch(PDO::FETCH_ASSOC));
                     }
                }
                catch(PDOException $e)
                {
                    echo "Si è verificato un errore nel caricamento dei blog recenti.";
                }
            ?>
            </div>
        </div>
    
        <div class="postContainer">
            <?php
                if(!$sessione){
            ?>
                    <h1>Iscriviti per goderti al massimo SentencePress</h1>
                    <div class='post'>
                        <div class='flexContainer'>
                            <div class='leftContainer'>
                                <h2>Registrati</h2>
                                <p>Senza costi potrai scrivere blog, iscriverti ai blog degli altri utenti ed esprimere la tua opinione all'intera community. <a href='registrazione.php'>Registrati subito</a></p>

                            </div>
                            <div class='rightContainer' style='text-align:end;'>
                                <img src='immagini/stile/iconPeople.png' style='max-width:200px;'>
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>    
        </div>
        
        <div class="postContainer">
            <h1>Blog più seguiti</h1>
            <div class='post'>
            <?php
                try
                {
                    $q = ("SELECT b.IDblog, b.immagine, b.titolo, b.data, u.username FROM blog b, autore a, utente u WHERE b.IDblog = a.IDblog and a.IDutente = u.IDutente and b.archiviato = 0 ORDER BY numIscritti DESC LIMIT 4");
                    $sth = $conn->query($q);

                     if($row = $sth->fetch(PDO::FETCH_ASSOC)){
                        do{
                        ?>
                            <div class='cardBlog'> 
                                <div class='blogImg'>
                                    <img src='immagini/blogPics/<?php echo $row["immagine"] ?>'> 
                                </div>
                                <p class='blogAutore'><a href='paginaUtente.php?username=<?php echo $row["username"]?>'><?php echo $row["username"]?></a></p> 
                                <p class='blogTitle'><?php echo stripslashes($row["titolo"])?></p> 
                                <p class='blogData'><?php echo $row["data"] ?></p>

                                <button class="button-17" onclick="window.location.href='blog.php?IDblog=<?php echo $row["IDblog"] ?>';">Vai al Blog</button><br>
                            </div>

                    <?php
                        }while($row = $sth->fetch(PDO::FETCH_ASSOC));
                     }
                }
                catch(PDOException $e)
                {
                    echo "Si è verificato un errore nel caricamento dei blog più seguiti.";
                }
            ?>
            </div>
        </div>
    
        <div class="postContainer">
            
            <h1>Post più apprezzati</h1>
                <div class='post'>
                    
            <?php
                try
                {
                    $q = ("SELECT p.titolo as titoloPost, p.immagine, p.data, p.IDpost, b.IDblog, b.titolo as titoloBlog FROM post p, blog b WHERE p.IDblog = b.IDblog and b.archiviato = 0 ORDER BY mediaGiudizio DESC LIMIT 4");
                    $sth = $conn->query($q);
                    
                    if($row = $sth->fetch(PDO::FETCH_ASSOC))
                    {
                        do
                        {
                        ?>
                            <div class='cardBlog'> 
                                <div class='blogImg'>
                                    <img src='immagini/postPics/<?php echo $row["immagine"] ?>'> 
                                </div>
                                <p class='blogAutore'><a href='blog.php?IDblog=<?php echo $row["IDblog"]?>'><?php echo stripslashes($row["titoloBlog"])?></a></p> 
                                <p class='blogTitle'><?php echo stripslashes($row["titoloPost"])?></p> 
                                <p class='blogData'><?php echo $row["data"] ?></p>

                                <button class="button-17" onclick="window.location.href='post.php?IDpost=<?php echo $row["IDpost"] ?>';">Vai al Post</button> 
                            </div>

                    <?php
                        }while($row = $sth->fetch(PDO::FETCH_ASSOC));
                     }
                }
                catch(PDOException $e)
                {
                    echo "Si è verificato un errore nel caricamento dei post più apprezzati.";
                }
                    
            $conn = null; //chiudo la connessione perché non mi serve più
            ?>
            </div>
        </div>
    
    </div> <!--chiude MAIN CONTAINER-->
    
    
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
             $("#formRicerca").validate({
                rules: {
                    testoRicerca: {
                        required: true,
                        minlength: 1,
                        maxlength: 25
                    },
                },
                messages: {
                    testoRicerca: "Inserisci una stringa valida",
                },
                
                submitHandler: submitForm                     
            });
             
             function submitForm(){
                 $("#formRicerca").submit();
             }
         });
    </script>
</body>
</html>