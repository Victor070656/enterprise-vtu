<?php

$sev = $_POST['service'];
	$sno = $_POST['iuc'];
	$tp = $_POST['plan'];
								
$qryApi = mysqli_query($conn,"SELECT * FROM api_setting");
$apidata = mysqli_fetch_array($qryApi);

$apikey = $apidata['APIkey']; //email address()

$Bxaram = array(
    "apikey" => $apikey,
    "service" => $sev,
    "meterno" => $sno
    );

//Initialize cURL.
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/electric-verify?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Bxaram));

$veridata = curl_exec($ch);

curl_close($ch);

$result = json_decode($veridata);
?>