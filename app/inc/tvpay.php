<?php 
$callb = $_SERVER['SERVER_NAME'];

if($gateway_fetch === 'epins'){
$resultepin = json_decode(epinApi($conn,$network,$phone,$code_fetch,$requestId));
$apiRespone = $resultepin->code;
	}elseif($gateway_fetch === 'clubkonnect'){
	    
$resultclub = json_decode(clubAPi($conn,$network,$code_fetch,$phone,$requestId,$callb));
$apiRespone = $resultclub->statuscode;
			}
			elseif($gateway_fetch === 'shago'){
$resultShago = json_decode(shagoPay($conn,$plan_fetch,$decoder_userName,$code_fetch, $phone, $userprice_fetch,$network,$requestId ));
$apiRespone = $resultShago->status;		
			
			} elseif($gateway_fetch === 'vtpass'){
$resultvtpass = json_decode(vtpass($conn,$network,$phone,$code_fetch,$requestId,$userprice_fetch));
$apiRespone = $resultvtpass->code;	

			}elseif($gateway_fetch == 'husmodata'){
$resulthusm = json_decode(husmoApi($conn,$networkcode, $phone, $code_fetch ));$apiRespone = $resulthusm->Status;		
			
		}elseif($gateway_fetch === 'gongoz'){
$resultgo = json_decode(gongoz($conn, $networkcode,$phone, $code_fetch));
$apiRespone = $resultgo->Status;		
			
			}elseif($gateway_fetch === 'alrahuz'){
$resultal = json_decode(Alrahuz($conn,$networkcode , $phone,$code_fetch)); $apiRespone = $resultal->Status;		
			
			} elseif($gateway_fetch === 'smartrecharge'){
			
$resultsmt = json_decode(smartRecharge($conn, $code_fetch,$phone));
		$apiRespone = $resultsmt->status;	
			} else if ($gateway_fetch === 'markersapi') {
			    
	$resultMaker = json_decode(MarkersApi($conn,$network,$phone,$code_fetch,$requestId,$userprice_fetch));	
	$apiRespone = $resultMaker->code;
			}
			

function shagoPay($conn,$plan_fetch,$decoder_userName,$code_fetch, $phone, $userprice_fetch,$network,$requestId ){
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
'serviceCode' => 'GDB',
'smartCardNo' => $phone,
'customerName' => $decoder_userName,
'type' => strtoupper($network),
'amount'	=> $userprice_fetch,
'packagename'	=> $plan_fetch,
'productsCode' => $code_fetch,
'period' => 1,
'hasAddon' => 0,
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

function vtpass($conn,$network,$phone,$code_fetch,$requestId,$userprice_fetch ){
    
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
  	'billersCode'=> $phone, // e.g smartcardNumber, meterNumber,
  	'variation_code'=> $code_fetch, // e.g dstv1, dstv2,prepaid,(optional for somes services)
  	'amount' =>  $userprice_fetch, // integer (optional for somes services)
  	'phone' => $phone //integer
),
));
$success_vtp = curl_exec($curl);
$curl_errno = curl_errno($curl);
curl_close($curl);  
return $success_vtp;
    
}			
			

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

function smartRecharge($conn, $code_fetch,$phone){	
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

function Alrahuz($conn,$networkcode, $phone,$code_fetch ){
    function fetchalr($conn){
$query_alr = $conn->query("SELECT * FROM providers_api_key WHERE provider='alrahuz'");
$alrkey = $query_alr->fetch_assoc();
return json_encode($alrkey);
}    
$json_alr = json_decode(fetchalr($conn));
$alrahuzkey = $json_alr->privatekey;
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://alrahuzdata.com.ng/api/cablesub/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
	"cablename" => $networkcode,
	"cableplan" => $code_fetch,
	"cableplan" => $phone
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

function gongoz($conn, $networkcode,$phone, $code_fetch ){
    
     function fetchgoz($conn){
$query_goz = $conn->query("SELECT * FROM providers_api_key WHERE provider='gongoz'");
$gozkey = $query_goz->fetch_assoc();
return json_encode($gozkey);
}    
$json_goz = json_decode(fetchgoz($conn));
$gongokey = $json_goz->privatekey;
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.gongozconcept.com/api/cablesub/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
	"cablename" => $networkcode,
	"cableplan" => $code_fetch,
	"cableplan" => $phone
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

function husmoApi($conn,$networkcode, $phone, $code_fetch ){	
    function fetchhusm($conn){
$query_hus = $conn->query("SELECT * FROM providers_api_key WHERE provider='husmodata'");
$husmkey = $query_hus->fetch_assoc();
return json_encode($husmkey);
}    
$json_hus = json_decode(fetchhusm($conn));
$husmokey = $json_hus->privatekey;
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://husmodataapi.com/api/cablesub/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
	"cablename" => $networkcode,
	"cableplan" => $code_fetch,
	"cableplan" => $phone
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


function epinApi($conn,$network,$phone,$code_fetch,$requestId,$userprice_fetch){	
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
    "service" => $network,
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


function MarkersApi($conn,$network,$phone,$code_fetch,$requestId,$userprice_fetch){	
    function fetchmarkers($conn){
$query_maks = $conn->query("SELECT * FROM providers_api_key WHERE provider='markersapi'");
$fetchmakskey = $query_maks->fetch_assoc();
return json_encode($fetchmakskey);
}    
$json_maks = json_decode(fetchmarkers($conn));
$apikey_maker = $json_maks->privatekey;
//Initialize cURL.
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, "https://markersapi.com.ng/api/tv/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $apikey_maker,
    "service" => $network,
    "accountno" => $phone,
    "vcode" => $code_fetch,
    "amount" => $userprice_fetch,
     "ref" => $requestId
    )));
$veridata_maker = curl_exec($ch);
curl_close($ch);
//file_put_contents('resp.txt',$veridata_maker);
return $veridata_maker;
}

?>