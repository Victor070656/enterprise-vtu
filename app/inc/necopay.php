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
}  else if ($apiMulti->gateway === 'mobileng'){
    
$resp_mobilng = json_decode(MobilNg($conn, $requestId, $iuc),true);

$responseCode = $resp_mobilng['code'];
$pin = $resp_mobilng['pin'];    
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
curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/neco/");
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
curl_setopt($ch, CURLOPT_URL, "https://markersapi.com.ng/api/neco/");
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


function MobilNg($conn, $requestId, $iuc){
     function fetchmobng($conn){
$query_mob = $conn->query("SELECT * FROM providers_api_key WHERE provider='mobileng'");
$mobkey = $query_mob->fetch_assoc();
return json_encode($mobkey);
}    
$json_mob = json_decode(fetchmobng($conn));
 $mobilekey = $json_mob->privatekey;
       $mobileID = $json_mob->secretkey;
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://mobileairtimeng.com/httpapi/neco?userid=$mobileID&pass=$mobilekey&pcs=$iuc&jsn=json&user_ref=$requestId");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$wdata = curl_exec($ch);
$result = json_decode($wdata);
//Close the cURL handle.
curl_close($ch);

return $wdata;
}

?>

