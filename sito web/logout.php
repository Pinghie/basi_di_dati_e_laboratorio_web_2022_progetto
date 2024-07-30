<?php
    session_start();
    unset($_SESSION["sessioneUtente"]);
    unset($_SESSION["nomeUtente"]);
    if (session_destroy())
        header('Location: login.php');   
    else
        echo "Si è verificato un errore. Torna alla <a href='index.php'> Home </a>";
    die();
?>