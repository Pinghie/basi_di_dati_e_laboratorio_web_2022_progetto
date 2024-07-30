<?php
    try
    {
        session_start();
        $IDutente = $_SESSION["sessioneUtente"];

        $commento = trim($_POST["commento"]);
        $IDpost = $_POST["IDpost"];
        $data = date("Y-m-d H:i:s");

        include("scriptPrevenzione.php");
        controlloTokenInput($commento);

        $commento = addslashes($commento);

        include("dbconnection.php");
        $stmt = $conn -> prepare("INSERT INTO commento(testoCommento, data, numLike, IDpost, IDutente) VALUES (:testoCommento, :data, '0', '$IDpost', '$IDutente')");

        $stmt -> bindParam(":testoCommento", $commento);
        $stmt -> bindParam(":data", $data);
        $stmt->execute();

        //aggiorno il numero di commenti del post
        $stmt = ("UPDATE post SET numCommenti = numCommenti + 1 WHERE IDpost = '$IDpost'");
        $conn->exec($stmt);

        $conn = null;
        die("ok");
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }
?>