<?
$apidata =  json_decode(Apikeys($conn));
$hashkey = $apidata->shago;

function shagopay($conn, $amount,$variation_code, $requestId,$profilecode, $hashkey){    
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


$resp = json_decode(shagopay($conn, $amount,$variation_code, $requestId,$profilecode, $hashkey),true);

$responseCode = $resp['status'];
$pin = $resp['pin'];
?>