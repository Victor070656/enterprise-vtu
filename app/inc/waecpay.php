<?php

if($apiMulti->gateway === 'epins'){
$resp = json_decode(ePinsPay($conn, $network, $variation_code, $amount, $requestId));
$responseCode = $resp->code;
$pin = $resp->description->Content;
}  else 

if($apiMulti->gateway === 'markersapi'){ 
    
 $resp_marker = json_decode(ePinsPay($conn, $network, $variation_code, $amount, $requestId));
$responseCode = $resp_marker->code;
$pin = $resp_marker->description->Content;
} else if($apiMulti->gateway === 'shago'){
    
$resp_shag = json_decode(shagopay($conn, $amount,$iuc, $requestId),true);

$responseCode = $resp_shag['status'];
$pin = 'PIN: '.$resp_shag['pin'][0]['pin'].''.'serial:'.$resp_shag['pin'][0]['serial'];    
} else if ($apiMulti->gateway === 'vtpass') {
    
  $resp_vpas = json_decode(VTPas($conn ,$requestId,$network, $iuc,$variation_code,  $amount));

$responseCode = $resp_vpas->code;
$pin = $resp_vpas->purchased_code;  
} else if ($apiMulti->gateway === 'mobileng') {
 $resp_mobng = json_decode(MobilNg($conn, $requestId));

$responseCode = $resp_mobng->code;
$pin = 'SerialNo: '.$resp_mobng->serial.' '.'PIN: '.$resp_mobng->pin;   
}
						
function ePinsPay($conn, $network, $variation_code, $amount, $requestId){
    function fetchEpin($conn){
$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
$fetchepkey = $query_ep->fetch_assoc();
return json_encode($fetchepkey);
}    
$json_ep = json_decode(fetchEpin($conn));
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/waec/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $json_ep->privatekey,
    "service" => $network,
    "vcode" => $variation_code,
    "amount" => $amount,
    "ref" => $requestId
    )));

$veridata = curl_exec($ch);
curl_close($ch);

return $veridata;
}

function MarkerPay($conn, $network, $variation_code, $amount, $requestId){
    function fetchMarkers($conn){
$query_maks = $conn->query("SELECT * FROM providers_api_key WHERE provider='markersapi'");
$fetchmakey = $query_maks->fetch_assoc();
return json_encode($fetchmakey);
}    
$json_maks = json_decode(fetchMarkers($conn));
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://markersapi.com.ng/api/waec/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $json_maks->privatekey,
    "service" => $network,
    "vcode" => $variation_code,
    "amount" => $amount,
    "ref" => $requestId
    )));

$veridata = curl_exec($ch);
curl_close($ch);

return $veridata;
}

function shagopay($conn, $amount,$iuc, $requestId){
    function fetchshago($conn){
$query_sh = $conn->query("SELECT * FROM providers_api_key WHERE provider='shago'");
$shagokey = $query_sh->fetch_assoc();
return json_encode($shagokey);
}    
$json_shago = json_decode(fetchshago($conn));
$hashkey = $json_shago->privatekey;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
'serviceCode' => "WAP",
'numberOfPin' => $iuc,
'amount' => $amount,
'request_id' => $requestId
)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "hashKey: $hashkey"
));
 
$response_shago = curl_exec($ch);
curl_close($ch);
return $response_shago;
}


function VTPas($conn,$requestId,$network, $iuc,$variation_code,  $amount){
    function fetchVtp($conn){
$query_vtp = $conn->query("SELECT * FROM providers_api_key WHERE provider='vtpass'");
$vtpkey = $query_vtp->fetch_assoc();
return json_encode($vtpkey);
}    
$json_vt = json_decode(fetchVtp($conn));
$curl       = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://vtpass.com/api/pay',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_USERPWD => $json_vt->privatekey.":" .$json_vt->secretkey,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_SSL_VERIFYPEER => true,
	CURLOPT_POSTFIELDS => array(
    'request_id' => $requestId,
  	'serviceID'=> $network, //integer e.g gotv,dstv,eko-electric,abuja-electric
  	'billersCode'=> $iuc, // e.g smartcardNumber, meterNumber,
  	'variation_code'=> $variation_code, // e.g dstv1, dstv2,prepaid,(optional for somes services)
  	'amount' =>  $amount, // integer (optional for somes services)
  	'phone' => $iuc //integer
  	
),
));
$successVTp = curl_exec($curl);
$curl_errno = curl_errno($curl);
curl_close($curl);

return $successVTp;
}

function MobilNg($conn, $requestId){
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
curl_setopt($ch, CURLOPT_URL, "https://mobileairtimeng.com/httpapi/waecdirect?userid=$mobileID&pass=$mobilekey&jsn=json&user_ref=$requestId");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$wdata_ng = curl_exec($ch);
$result_ng = json_decode($wdata_ng);
//Close the cURL handle.
curl_close($ch);

return $wdata_ng;
}
?>