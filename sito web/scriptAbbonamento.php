<?php
    try
    {
        session_start();
        $IDutente = $_SESSION["sessioneUtente"];

        $dataAbbonamento = date("Y-m-d");

        $intestatario = trim($_POST["intestatario"]);
        $numCarta = $_POST["numCarta"];
        $scadenzaCarta = $_POST["scadenzaCarta"];
        $rinnovoAutomatico = $_POST["rinnovoAutomatico"];

        include("scriptPrevenzione.php");
        controlloTokenInput($intestatario); //se la stringa $intestatario contiene un possibile attacco, lo script viene interrotto e viene ritornato l'errore 5.

        $intestatario = addslashes($intestatario);

        include("dbconnection.php");

        $stmt = $conn -> prepare("INSERT INTO pagamento(dataAbbonamento, intestatario, numeroCarta, scadenzaCarta, IDutente) VALUES (:dataAbbonamento, :intestatario, :numeroCarta, :scadenzaCarta, $IDutente)");

        $stmt -> bindParam(":dataAbbonamento", $dataAbbonamento);
        $stmt -> bindParam(":intestatario", $intestatario);
        $stmt -> bindParam(":numeroCarta", $numCarta);
        $stmt -> bindParam(":scadenzaCarta", $scadenzaCarta);
        $stmt->execute();

        //modifica abbonato da 0 a 1
        $stmt = ("UPDATE utente SET abbonato = 1 WHERE IDutente = '$IDutente'");
        $conn->exec($stmt);

        $stmt = ("UPDATE utente SET rinnovoAutomatico = '$rinnovoAutomatico' WHERE IDutente = '$IDutente'");
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