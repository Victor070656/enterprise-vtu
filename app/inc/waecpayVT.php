<?php
$apidata =  json_decode(Apikeys($conn));
$username = $apidata->VTuser;
$password = $apidata->VTpass;

function VTPas($conn, $username, $password ,$requestId,$network, $iuc,$variation_code,  $amount){
$curl       = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://vtpass.com/api/pay',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_USERPWD => $username.":" .$password,
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

$resp = json_decode(VTPas($conn, $username, $password ,$requestId,$network, $iuc,$variation_code,  $amount));

$responseCode = $resp->code;
$pin = $resp->purchased_code;

//responsecode = 000;
?>