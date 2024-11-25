<?php
$apidata =  json_decode(Apikeys($conn));
$mobilekey = $apidata->mobilekey;
$mobileID = $apidata->mobileID;


function MobilNg($conn, $mobileID, $mobilekey, $requestId){
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://mobileairtimeng.com/httpapi/waecdirect?userid=$mobileID&pass=$mobilekey&jsn=json&user_ref=$requestId");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$wdata = curl_exec($ch);
$result = json_decode($wdata);
//Close the cURL handle.
curl_close($ch);

return $wdata;
}


$resp = json_decode(MobilNg($conn, $mobileID, $mobilekey, $requestId));

$responseCode = $resp->code;
$pin = 'SerialNo: '.$resp->serial.' '.'PIN: '.$resp->pin;

//responsecode = 100;


?>