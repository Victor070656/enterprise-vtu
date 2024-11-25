<?php

$product ="Bet9ja Payment";

$Bxaram = array(
    "apikey" => $codekey,
    "customerId" => $iuc
    
    );

//Initialize cURL.
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, urlbasemain()."/"."bet-verify/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($Bxaram));
$veridata = curl_exec($ch);
$result = json_decode($veridata,true);
curl_close($ch);

?>