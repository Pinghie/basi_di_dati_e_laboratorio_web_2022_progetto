<?php
    function controlloTokenInput($stringaInput)
    {
        $stringaInput = strtolower($stringaInput);
        $arrayTokenInput = explode(" ", $stringaInput);
        $vietate = ["select", "insert", "update", "delete", "drop", "alter", "--"];
        
        $intersezione = array_intersect($arrayTokenInput, $vietate);
        
        if(count($intersezione)>0)
            die("5");//è stato rilevato un tentativo di injection
    }
?>