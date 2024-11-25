<?php 
if($network === 'mtn'){
	$ncode = "15";
	
	}elseif($network === 'glo'){
		
		$ncode = "6";
		}elseif($network === 'etisalat'){
		
		$ncode = "2";	
			
			}elseif($network === 'airtel'){
				
				$ncode = "1";
				}
		
$result = json_decode(MobileNG($conn, $UserID,$DisKey, $ncode,$phone,$xamount,$requestId ));
$responseCode =  $result->code;


function MobileNG($conn, $UserID,$DisKey, $ncode,$phone,$xamount,$requestId ){
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://mobileairtimeng.com/httpapi/?userid=$UserID&pass=$DisKey&network=$ncode&phone=$phone&amt=$xamount&user_ref=$requestId&jsn=json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$vdataMg = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);
return $vdataMg;
}

?>