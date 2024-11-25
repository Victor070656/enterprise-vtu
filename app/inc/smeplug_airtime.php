<?php 
$secretSMEplx = $apiMulti->smeplugkey;
$resp = json_decode(SMEPlug($conn, $secretSMEplx,$smeplux,$phone, $xamount,$requestId),true);

$responseCode = $resp['status'];

function SMEPlug($conn, $secretSMEplx,$smeplux,$phone, $xamount,$requestId){
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://smeplug.ng/api/v1/airtime/purchase',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
	"network_id" => $smeplux,
	"phone" => $phone,
	"amount" => $xamount,
	"customer_reference" =>$requestId 
),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Bearer $secretSMEplx"
  ),
));

$responseSMPL = curl_exec($curl);
curl_close($curl);

return $responseSMPL;
}
?>