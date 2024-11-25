<?php 

$resp = json_decode(vtPass($conn, $username,$password,$requestId, $network,$xamount,$phone));
$responseCode = $resp->code;


function vtPass($conn, $username,$password,$requestId, $network,$xamount,$phone){
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
  	'serviceID'=> $network, //integer e.g mtn,airtel
  	'amount' =>  $xamount, // integer
  	'phone' => $phone //integer
),
));
$successVTP = curl_exec($curl);
$curl_errno = curl_errno($curl);
curl_close($curl);
return  $successVTP;
}

?>