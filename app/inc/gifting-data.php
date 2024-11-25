<?php 
$apidata =  json_decode(Apikeys($conn));$secretSMEplx = $apidata->smeplugkey;$apikey = $apidata->APIkey; $UserID = $apidata->clubId;$husmokey = $apidata->husmodata;$DisKey = $apidata->clubkey;$gongokey = $apidata->gongoz;$alrahuzkey = $apidata->alrahuz;$smartKey = $apidata->smartkey;$mobilekey = $apidata->mobilekey;$mobileID = $apidata->mobileID;$callb = $_SERVER['SERVER_NAME'];
$apiMulti = json_decode(Apidefault($conn, $variation_code));
$simPIN = $apiMulti->simPin;
if($apiMulti->gateway === 'epins'){

$resultepin = json_decode(epinApi($conn,$apikey,$network,$phone,$variation_code,$requestId));
$apiRespone = $resultepin->code;
	}elseif($apiMulti->gateway === 'clubkonnect'){
	    
$resultclub = json_decode(clubAPi($conn,$UserID,$DisKey,$network,$variation_code,$phone,$requestId,$callb));	
			}
			elseif($apiMulti->gateway === 'mobileng'){
$resultmob = json_decode(mobilng($conn, $mobileID,$mobilekey,$mobNet,$phone,$variation_code,$requestId ));
$apiRespone = $resultmob->code;		
			}elseif($apiMulti->gateway === 'smeplug'){
smeplug($conn, $smeplugnet_id, $variation_code, $phone, $secretSMEplx);
			}elseif($apiMulti->gateway == 'husmodata'){
$resulthusm = json_decode(husmoApi($conn,$mobNet, $phone, $variation_code, $husmokey ));$apiRespone = $resulthusm->Status;		
			
		}elseif($apiMulti->gateway === 'gongoz'){
$resultgo = json_decode(gongoz($conn, $mobNet,$phone, $variation_code, $gongokey ));
$apiRespone = $resultgo->Status;		
			
			}elseif($apiMulti->gateway === 'alrahuz'){
$resultal = json_decode(Alrahuz($conn,$mobNet , $phone,$variation_code,$alrahuzkey)); $apiRespone = $resultal->Status;		
			
			}elseif($apiMulti->gateway === 'smartrecharge'){
			
$resultsmt = json_decode(smartRecharge($conn, $smartKey, $variation_code,$phone, $callb));
			
			}elseif($apiMulti->gateway === 'simhost'){
			
	
if($network == '01'){	
	

$ch = curl_init("https://simhostng.com/api/ussd?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
'apikey' => $apiMulti['simkey'],
'server' => $apiMulti['serverMTN'],
'sim' => '1',
'number' => '*605*2*1*'.$phone.'*'.$variation_code.'*'.$simPIN.'#',	
'ref' => $requestId,
'url' => $callb
	));
$response = curl_exec($ch);
curl_close($ch);
										

	
}
	
	
if($network == '04'){	
	
$ch = curl_init("https://simhostng.com/api/ussd?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
'apikey' => $apiMulti['simkey'],
'server' => $apiMulti['serverAirtel'],
'sim' => '1',	
'number' => '*141*6*2*1*7*1*'.$phone.'*1121#',	
'ref' => $requestId,
'url' => $callb
	));
$response = curl_exec($ch);
curl_close($ch);
}
	
if($network == '02'){	
	
$ch = curl_init("https://simhostng.com/api/ussd?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
'apikey' => $apiMulti['simkey'],
'server' => $apiMulti['serverGlo'],
'sim' => '1',	
'number' => '*229*2*36*'.$phone.'#',	
'ref' => $requestId,
'url' => $callb
	));
$response = curl_exec($ch);
curl_close($ch);
										
}	
	
	
if($network == '03'){	
	
$ch = curl_init("https://simhostng.com/api/ussd?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
'apikey' => $apiMulti['simkey'],
'server' => $apiMulti['serverEtisalat'],
'sim' => '1',	
'number' => '*229*2*36*'.$phone.'#',	
'ref' => $requestId,
'url' => $callb
));
$response = curl_exec($ch);
curl_close($ch);

}	}















function smartRecharge($conn, $smartKey,$variation_code,$phone, $callb){	
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://smartrecharge.ng/api/v2/datashare/?api_key=$smartKey&product_code=$variation_code&phone=$phone&callback=$callb");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$resdata = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);
return $resdata;
}

function Alrahuz($conn,$mobNet , $phone,$variation_code,$alrahuzkey ){			
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://alrahuzdata.com.ng/api/data/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
	"network" => $mobNet,
	"mobile_number" => $phone,
	"plan" => $variation_code,
	"Ported_number" => true
)),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Token $alrahuzkey"
  ),
));

$Alrahuzresponse = curl_exec($curl);
curl_close($curl);
return $Alrahuzresponse;
}

function gongoz($conn, $mobNet,$phone, $variation_code, $gongokey ){
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.gongozconcept.com/api/data/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
	"network" => $mobNet,
	"mobile_number" => $phone,
	"plan" => $variation_code,
	"Ported_number" => true)),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Token $gongokey"
  ),
));
$Gongresponse = curl_exec($curl);
curl_close($curl);
return $Gongresponse; 
}

function husmoApi($conn,$mobNet, $phone, $variation_code, $husmokey ){		
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://husmodataapi.com/api/data/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
	"network" => $mobNet,
	"mobile_number" => $phone,
	"plan" => $variation_code,
	"Ported_number" => true
)),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Token $husmokey"
  ),
));

$Husresponse = curl_exec($curl);
curl_close($curl);
return $Husresponse;
}

function smeplug($conn, $smeplugnet_id, $variation_code, $phone, $secretSMEplx ){
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://smeplug.ng/api/v1/data/purchase',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
	"network_id" => $smeplugnet_id,
	"plan_id" => $variation_code,
	"phone" => $phone
),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Bearer $secretSMEplx"
  ),
));

$response = curl_exec($curl);
curl_close($curl);
return $response; 
}

function Apidefault($conn, $variation_code){
$query_MapiS = $conn->query("SELECT * FROM data_package WHERE plancode='$variation_code'");
$api_defualt = $query_MapiS->fetch_assoc();
return json_encode($api_defualt);
}


function Apikeys($conn){
$qryApi = $conn->query("SELECT * FROM api_setting");
$Allapi = $qryApi->fetch_assoc();
return json_encode($Allapi);
}

function epinApi($conn,$apikey,$network,$phone,$variation_code,$requestId){	
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/gifting-data/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $apikey,
    "service" => $network,
    "MobileNumber" => $phone,
    "DataPlan" => $variation_code,
     "ref" => $requestId
    )));
$veridata = curl_exec($ch);
curl_close($ch);
file_put_contents('resp.txt',$veridata);
return $veridata;
}

function clubAPi($conn,$UserID,$DisKey,$network,$variation_code,$phone,$requestId,$callb){
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.nellobytesystems.com/APIDatabundleV1.asp?UserID=$UserID&APIKey=$DisKey&MobileNetwork=$network&DataPlan=$variation_code&MobileNumber=$phone&RequestID=$requestId&CallBackURL=$callb ");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$resdata = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);
return 	$resdata;
}

function mobilng($conn, $mobileID,$mobilekey,$mobNet,$phone,$variation_code,$requestId ){		
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://mobileairtimeng.com/httpapi/datashare?userid=$mobileID&pass=$mobilekey&network=$mobNet&phone=$phone&datasize=$variation_code&jsn=json&user_ref=$requestId");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$resdata = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);	
return $resdata;	
}
?>