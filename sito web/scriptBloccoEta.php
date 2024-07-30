<?php
    try
    {
        if($sessione == true)
        {
            $blocco = false;

            //CALCOLO ETA' UTENTE
            $q = ("SELECT dataNascita FROM utente WHERE IDutente = '$IDutente'");
            $sth = $conn->query($q);
            $resultData = $sth->fetch(PDO::FETCH_ASSOC);

            $dataNascita = $resultData["dataNascita"];
            $dataNascita = explode("-", $dataNascita);
            $eta = (date("md", date("U", mktime(0, 0, 0, $dataNascita[2], $dataNascita[1], $dataNascita[0]))) > date("md")
            ? ((date("Y") - $dataNascita[0]) - 1)
            : (date("Y") - $dataNascita[0]));

            if($eta < 18)
            {
                $blocco = true; 
            }
        }
        else
        {
            $blocco = true;
        }
    }
    catch(PDOException $e)
    {
        $blocco = false;
    }

?>