<?php 
if($network === 'mtn'){
	$ncode = "mtn_custom";
	
	}elseif($network === 'glo'){
		
		$ncode = "glo_custom";
		}elseif($network === 'etisalat'){
		
		$ncode = "9mobile_custom";	
			
			}elseif($network === 'airtel'){
				
				$ncode = "airtel_custom";
				}


$result = json_decode(smartAir($conn, $smartKey,$ncode, $phone, $xamount, $callb ));
$responseCode = $result->data->text_status;


function smartAir($conn, $smartKey,$ncode, $phone, $xamount, $callb ){		
$host = "https://smartrecharge.ng/api/v2/airtime/?api_key=$smartKey&product_code=$ncode&phone=$phone&amount=$xamount&callback=$callb";

//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $host);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$vdataSm = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);
return $vdataSm;
}

?>