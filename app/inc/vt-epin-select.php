<?php

//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, urlbasemain()."/"."tv-package/?apikey=$codekey");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$tvpackage = curl_exec($ch);
curl_close($ch);
$resp = json_decode($tvpackage);

echo $resp->data->gotv;
?>


