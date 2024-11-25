<?php 
	
if($network == 'mtn'){	

$url = "https://simhostng.com/api/ussd?";
$uvalues = array(
"apikey" => $apidata['simkey'],
"server" => $apidata['serverMTN'],
"sim" => '1',	
"number" => '*456*1*2*'.$amount.'*'.$phone.'*1*'.$simPIN.'#',	
"ref" => $requestId,
	
"url" => $callb
	);										
										

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $uvalues);
$response = curl_exec($ch);
curl_close($ch);
										
$resp = json_decode($response,true);
	
}
	
	
if($network == 'airtel'){	

$url = "https://simhostng.com/api/ussd?";
$uvalues = array(
"apikey" => $apidata['simkey'],
"server" => $apidata['serverAirtel'],
"sim" => '1',	
"number" => '*605*2*1*'.$phone.'*'.$amount.'*'.$simPIN.'#',	
"ref" => $requestId,
	
"url" => $callb
	);									
									
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $uvalues);
$response = curl_exec($ch);
curl_close($ch);
										
$resp = json_decode($response,true);
	
}
	
if($network == 'glo'){	

$url = "https://simhostng.com/api/ussd?";
$uvalues = array(
"apikey" => $apidata['simkey'],
"server" => $apidata['serverGlo'],
"sim" => '1',	
"number" => '*202*2*'.$phone.'*'.$amount.'*'.$simPIN.'*1#',	
"ref" => $requestId,
	
"url" => $callb
	);										
										

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $uvalues);
$response = curl_exec($ch);
curl_close($ch);
										
$resp = json_decode($response,true);
	
}	
	
	
if($network == 'etisalat'){	

$url = "https://simhostng.com/api/ussd?";
$uvalues = array(
"apikey" => $apidata['simkey'],
"server" => $apidata['serverEtisalat'],
"sim" => '1',		
"number" => '*224*'.$amount.'*'.$phone.'*'.$simPIN.'#',	
"ref" => $requestId,
	
"url" => $callb
	);										
										

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $uvalues);
$response = curl_exec($ch);
curl_close($ch);

$resp = json_decode($response,true);
	
}		

$responseCode == $resp['data'][0]['response'];

?>