<?php 
$callb = $_SERVER['SERVER_NAME'];

if($gateway_fetch === 'epins'){
$resultepin = json_decode(epinApi($conn,$serviceId,$phone,$code_fetch,$requestId,$userprice_fetch));
$apiRespone = $resultepin->code;
$token_generated = $resultepin->description->Token;
	}elseif($gateway_fetch === 'clubkonnect'){
	    
$resultclub = json_decode(clubAPi($conn,$network,$code_fetch,$phone,$requestId,$callb));
$apiRespone = $resultclub->statuscode;
$apiRespone = $resultclub->metertoken;
			}
			elseif($gateway_fetch === 'shago'){
$resultShago = json_decode(shagoPay($conn,$plan_fetch,$decoder_userName,$code_fetch, $phone, $userprice_fetch,$requestId,$userPhone,$decoder_address ));
$apiRespone = $resultShago->status;		
	$token_generated = $resultShago->token;		
			}elseif($gateway_fetch === 'vtpass'){
$resultvtpass = json_decode(vtpass($conn,$serviceId,$phone,$code_fetch,$requestId,$userprice_fetch));
$apiRespone = $resultvtpass->code;	
$token_generated = $resultvtpass->purchased_code;	
			}elseif($gateway_fetch == 'husmodata'){
$resulthusm = json_decode(husmoApi($conn,$plan_fetch, $phone, $userprice_fetch, $code_fetch ));$apiRespone = $resulthusm->Status;		
	$token_generated = $resulthusm->pin;		
		}elseif($gateway_fetch === 'gongoz'){
$resultgo = json_decode(gongoz($conn, $plan_fetch, $phone, $userprice_fetch, $code_fetch ));
$apiRespone = $resultgo->Status;		
	$token_generated = $resultgo->pin;		
			}elseif($gateway_fetch === 'alrahuz'){
$resultal = json_decode(Alrahuz($conn,$plan_fetch, $phone, $userprice_fetch, $code_fetch)); $apiRespone = $resultal->Status;		
		$token_generated = $resultal->pin;	
			}elseif($gateway_fetch === 'smartrecharge'){
			
$resultsmt = json_decode(smartRecharge($conn, $code_fetch,$phone));
		$apiRespone = $resultsmt->status;
		$token_generated = $resultsmt->data->pin;
			} else if ($gateway_fetch === 'markersapi'){
			    
		$resultMakers = json_decode(MarkersApi($conn,$serviceId,$phone,$code_fetch,$requestId,$userprice_fetch));
			    $apiRespone = $resultMakers->code;
            $token_generated = $resultMakers->description->Token;
			}
			

function shagoPay($conn,$plan_fetch,$decoder_userName,$code_fetch, $phone, $userprice_fetch,$requestId,$userPhone,$decoder_address ){
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
'serviceCode' => 'AOB',
'disco' => $plan_fetch,
'meterNo' => $phone,
'type' => strtoupper($code_fetch),
'amount'	=> $userprice_fetch,
'phonenumber' => $userPhone,
'name' => $decoder_userName,
'address'	=> $decoder_address,
'request_id' => $requestId	

)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "hashKey: $hashkey"
));

$isuccess = curl_exec($ch);
curl_close($ch);
//file_put_contents('res.txt',$isuccess.'/'.$userprice_fetch);
return $isuccess;
}

function vtpass($conn,$serviceId,$phone,$code_fetch,$requestId,$userprice_fetch ){
    
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
  	'serviceID'=> $serviceId, //integer e.g gotv,dstv,eko-electric,abuja-electric
  	'billersCode'=> $phone, // e.g smartcardNumber, meterNumber,
  	'variation_code'=> $code_fetch, // e.g dstv1, dstv2,prepaid,(optional for somes services)
  	'amount' =>  $userprice_fetch, // integer (optional for somes services)
  	'phone' => $phone //integer
),
));
$success_vtp = curl_exec($curl);
$curl_errno = curl_errno($curl);
curl_close($curl);  
//file_put_contents('res.txt',$success_vtp.'/'.$userprice_fetch);
return $success_vtp;
    
}			
			



function smartRecharge($conn,$code_fetch,$phone){
    function fetchsmart($conn){
$query_smart = $conn->query("SELECT * FROM providers_api_key WHERE provider='smartrecharge'");
$smart_rech = $query_smart->fetch_assoc();
return json_encode($smart_rech);
}    
$json_smart = json_decode(fetchsmart($conn));
$smartKey = $json_smart->privatekey;
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://smartrecharge.ng/api/v2/tv/?api_key=$smartKey&product_code=$code_fetch&smartcard_number=$phone");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$resdata = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);
return $resdata;
}

function Alrahuz($conn,$plan_fetch, $phone, $userprice_fetch, $code_fetch ){	
    function fetchalr($conn){
$query_alr = $conn->query("SELECT * FROM providers_api_key WHERE provider='alrahuz'");
$alrkey = $query_alr->fetch_assoc();
return json_encode($alrkey);
}    
$json_alr = json_decode(fetchalr($conn));
$alrahuzkey = $json_alr->privatekey;
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://alrahuzdata.com.ng/api/billpayment/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
		"disco_name" => $plan_fetch,
	"amount" => $userprice_fetch,
	"meter_number" => $phone,
	"MeterType" => $code_fetch
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

function gongoz($conn, $plan_fetch, $phone, $userprice_fetch, $code_fetch ){
    function fetchgoz($conn){
$query_goz = $conn->query("SELECT * FROM providers_api_key WHERE provider='gongoz'");
$gozkey = $query_goz->fetch_assoc();
return json_encode($gozkey);
}    
$json_goz = json_decode(fetchgoz($conn));
$gongokey = $json_goz->privatekey;
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.gongozconcept.com/api/billpayment/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
		"disco_name" => $plan_fetch,
	"amount" => $userprice_fetch,
	"meter_number" => $phone,
	"MeterType" => $code_fetch
	)),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Token $gongokey"
  ),
));
$Gongresponse = curl_exec($curl);
curl_close($curl);
return $Gongresponse; 
}

function husmoApi($conn,$plan_fetch, $phone, $userprice_fetch, $code_fetch ){
    
    function fetchhusm($conn){
$query_hus = $conn->query("SELECT * FROM providers_api_key WHERE provider='husmodata'");
$husmkey = $query_hus->fetch_assoc();
return json_encode($husmkey);
}    
$json_hus = json_decode(fetchhusm($conn));
$husmokey = $json_hus->privatekey;
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://husmodataapi.com/api/billpayment/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
	"disco_name" => $plan_fetch,
	"amount" => $userprice_fetch,
	"meter_number" => $phone,
	"MeterType" => $code_fetch
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


function epinApi($conn,$serviceId,$phone,$code_fetch,$requestId,$userprice_fetch){
    
    function urlbasemain(){
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/base?url=main");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$basedata = curl_exec($ch);
$result = json_decode($basedata,true);
//Close the cURL handle.
curl_close($ch);
return $result['description'][0]['main'];

	}
    
    function fetchEpin($conn){
$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
$fetchepkey = $query_ep->fetch_assoc();
return json_encode($fetchepkey);
}    
$json_ep = json_decode(fetchEpin($conn));
$apikey = $json_ep->privatekey;
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, urlbasemain()."/"."biller/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $apikey,
    "service" => $serviceId,
    "accountno" => $phone,
    "vcode" => $code_fetch,
    "amount" => $userprice_fetch,
     "ref" => $requestId
    )));
$veridata = curl_exec($ch);
curl_close($ch);
file_put_contents('resp.txt',$veridata);
return $veridata;
}

function clubAPi($conn,$network,$code_fetch,$phone,$requestId,$callb){
    function fetchclb($conn){
$query_cl = $conn->query("SELECT * FROM providers_api_key WHERE provider='clubkonnect'");
$clbkey = $query_cl->fetch_assoc();
return json_encode($clbkey);
}    
$json_clb = json_decode(fetchclb($conn));
 $DisKey = $json_clb->privatekey;
       $UserID = $json_clb->secretkey;
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.nellobytesystems.com/APICableTVV1.asp?UserID=$UserID&APIKey=$DisKey&CableTV=$network&Package=$code_fetch&SmartCardNo=$phone&PhoneNo=$phone&CallBackURL=$callb");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$resdata = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);
return 	$resdata;
}

function MarkersApi($conn,$serviceId,$phone,$code_fetch,$requestId,$userprice_fetch){	
    
    function fetchMarkers($conn){
$query_maks = $conn->query("SELECT * FROM providers_api_key WHERE provider='markersapi'");
$fetchmakey = $query_maks->fetch_assoc();
return json_encode($fetchmakey);
}    
$json_maks = json_decode(fetchMarkers($conn));
$apikey = $json_maks->privatekey;
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://markersapi.com.ng/api/electricity/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $apikey,
    "service" => $serviceId,
    "accountno" => $phone,
    "vcode" => $code_fetch,
    "amount" => $userprice_fetch,
     "ref" => $requestId
    )));
$veridata_maks = curl_exec($ch);
curl_close($ch);
//file_put_contents('resp.txt',$veridata_maks);
return $veridata_maks;
}


?>