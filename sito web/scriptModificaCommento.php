<?php
    try
    {
        $IDcommento = $_POST["IDcommentoModifica"];
        $commentoModificato = $_POST["commentoModificato"];

        include("scriptPrevenzione.php");
        controlloTokenInput($commentoModificato);

        $commentoModificato = addslashes($commentoModificato);

        $dataModifica = date("Y-m-d H:i:s");

        include("dbconnection.php");
        $stmt = $conn -> prepare("UPDATE commento SET testoCommento = :testoCommento, dataModifica = :dataModifica WHERE IDcommento = '$IDcommento'");

        $stmt -> bindParam(":testoCommento", $commentoModificato);
        $stmt -> bindParam(":dataModifica", $dataModifica);

        $stmt->execute();

        $conn = null;
        die("ok");
    }
    catch(PDOException $e)
    {
        $conn = null;
        die("errore");
    }
?>