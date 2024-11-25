<?php
if($apiMulti->gateway === 'epins'){
$resp = json_decode(ePinsPay($conn, $network, $iuc, $requestId),true);
$responseCode = $resp['code'];
$pin = $resp['PIN'];
}  else 

if($apiMulti->gateway === 'markersapi'){ 
    
 $resp_markersapi = json_decode(MarkerPay($conn, $network, $iuc, $requestId),true);
$responseCode = $resp_markersapi['code'];
$pin = $resp_markersapi['PIN'];   
}  
//responsecode = 101;
						
function ePinsPay($conn, $network, $iuc, $requestId){
    function fetchEpin($conn){
$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
$fetchepkey = $query_ep->fetch_assoc();
return json_encode($fetchepkey);
}    
$json_ep = json_decode(fetchEpin($conn));
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/nabteb/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $json_ep->privatekey,
    "service" => $network,
    "vcode" => $iuc,
    "ref" => $requestId
    )));

$veridata = curl_exec($ch);
curl_close($ch);

return $veridata;
}


function MarkerPay($conn, $network, $iuc, $requestId){
    function fetchMarkers($conn){
$query_maks = $conn->query("SELECT * FROM providers_api_key WHERE provider='markersapi'");
$fetchmakey = $query_maks->fetch_assoc();
return json_encode($fetchmakey);
}    
$json_maks = json_decode(fetchMarkers($conn));
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://markersapi.com.ng/api/nabteb/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $json_maks->privatekey,
    "service" => $network,
    "vcode" => $iuc,
    "ref" => $requestId
    )));

$veridata_mak = curl_exec($ch);
curl_close($ch);

return $veridata_mak;
}

?>

