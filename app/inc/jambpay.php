<?php
//////// JAMB Pay

if($apiMulti->gateway === 'epins'){
$resp = json_decode(ePinsPay($conn, $network, $type, $requestId, $profilecode),true);
$responseCode = $resp->code;
$pin = $resp['PIN'];
}  else 
if($apiMulti->gateway === 'shago'){
    
 $resp_shago = json_decode(shagopay($conn, $amount,$variation_code, $requestId,$profilecode),true);

$responseCode = $resp_shago['status'];
$pin = $resp_shago['pin'];   
} else
if($apiMulti->gateway === 'vtpass') {
 $resp_vpas = json_decode(VTPas($conn,$requestId,$network, $phone,$variation_code,  $amount));

$responseCode = $resp_vpas->code;
$pin = $resp_vpas->purchased_code;   
    
}
//responsecode = 101;
						
function ePinsPay($conn, $network, $type, $requestId,$profilecode){
    function fetchEpin($conn){
$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
$fetchepkey = $query_ep->fetch_assoc();
return json_encode($fetchepkey);
}    
$json_ep = json_decode(fetchEpin($conn));
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/jambpay/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $json_ep->privatekey,
    "service" => $network,
    "profilecode" => $profilecode,
    "type" => $type,
    "ref" => $requestId
    )));

$veridata = curl_exec($ch);
curl_close($ch);

return $veridata;
}

function shagopay($conn, $amount,$variation_code, $requestId,$profilecode){ 
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
'serviceCode' => "JMB",
'type' => $variation_code,
'profileCode' => $profilecode,
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


function VTPas($conn, $requestId,$network, $phone,$variation_code,  $amount){
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
  	'variation_code'=> $variation_code, // e.g dstv1, dstv2,prepaid,(optional for somes services)
  	'billersCode'=> $iuc, // e.g smartcardNumber, meterNumber,
  	
  	'amount' =>  $amount, // integer (optional for somes services)
  	'phone' => $phone //integer
  	
),
));
$successVTp = curl_exec($curl);
$curl_errno = curl_errno($curl);
curl_close($curl);

return $successVTp;
}


?>