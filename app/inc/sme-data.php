<?php 
$callb = $_SERVER['SERVER_NAME'];
$apiMulti = json_decode(Apidefault($conn, $code_fetch));

if($apiMulti->gateway === 'epins'){

$resultepin = json_decode(epinApi($conn,$network,$phone,$code_fetch,$requestId));
$apiRespone = $resultepin->code;
	}elseif($apiMulti->gateway === 'clubkonnect'){
	    
$resultclub = json_decode(clubAPi($conn,$network,$code_fetch,$phone,$requestId,$callb));
$apiRespone = $resultclub->status;
			}
			elseif($apiMulti->gateway === 'mobileng'){
$resultmob = json_decode(mobilng($conn, $networkcode,$phone,$code_fetch,$requestId ));
$apiRespone = $resultmob->code;		
			}elseif($apiMulti->gateway === 'smeplug'){
smeplug($conn, $smeplugnet_id, $code_fetch, $phone);
			}elseif($apiMulti->gateway == 'husmodata'){
$resulthusm = json_decode(husmoApi($conn,$networkcode2, $phone, $code_fetch ));$apiRespone = $resulthusm->Status;		
			
		}elseif($apiMulti->gateway === 'gongoz'){
$resultgo = json_decode(gongoz($conn, $networkcode2,$phone, $code_fetch));
$apiRespone = $resultgo->Status;		
			
			}elseif($apiMulti->gateway === 'alrahuz'){
$resultal = json_decode(Alrahuz($conn,$networkcode2 , $phone,$code_fetch)); $apiRespone = $resultal->Status;		
			
			} else if($apiMulti->gateway === 'smartrecharge') {
			
$resultsmt = json_decode(smartRecharge($conn, $code_fetch,$phone, $callb));
			
			} else if($apiMulti->gateway === 'markersapi') {

   $resultmarkers = json_decode(MarkersApi($conn,$network,$phone,$code_fetch,$requestId));
   $apiRespone = $resultmarkers->code;
} 
 else if ($apiMulti->gateway === 'zoedatahub'){
     $resultZoe =  json_decode(zoeDataHub($conn,$networkcode2, $phone, $code_fetch));
     $apiRespone = $resultZoe->Status;
 } else if ($apiMulti->gateway === 'bigsub') {
     $json_bigsub =  json_decode(BigSub($conn,$phone,$code_fetch,$network,$dataType));
     $apiRespone = $json_bigsub->success;
 }


function smartRecharge($conn,$code_fetch,$phone, $callb){
    function fetchsmart($conn){
$query_smart = $conn->query("SELECT * FROM providers_api_key WHERE provider='smartrecharge'");
$smart_rech = $query_smart->fetch_assoc();
return json_encode($smart_rech);
}    
$json_smart = json_decode(fetchsmart($conn));
$smartKey = $json_smart->privatekey;
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://smartrecharge.ng/api/v2/datashare/?api_key=$smartKey&product_code=$code_fetch&phone=$phone&callback=$callb");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$resdata = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);
return $resdata;
}

function Alrahuz($conn,$networkcode2, $phone,$code_fetch){
    function fetchalr($conn){
$query_alr = $conn->query("SELECT * FROM providers_api_key WHERE provider='alrahuz'");
$alrkey = $query_alr->fetch_assoc();
return json_encode($alrkey);
}    
$json_alr = json_decode(fetchalr($conn));
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
	"network" => $networkcode2,
	"mobile_number" => $phone,
	"plan" => $code_fetch,
	"Ported_number" => true
)),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Token ".$json_alr->privatekey
  ),
));

$Alrahuzresponse = curl_exec($curl);
curl_close($curl);
return $Alrahuzresponse;
}

function gongoz($conn, $networkcode2,$phone, $code_fetch){
    
     function fetchgoz($conn){
$query_goz = $conn->query("SELECT * FROM providers_api_key WHERE provider='gongoz'");
$gozkey = $query_goz->fetch_assoc();
return json_encode($gozkey);
}    
$json_goz = json_decode(fetchgoz($conn));

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
	"network" => $networkcode2,
	"mobile_number" => $phone,
	"plan" => $code_fetch,
	"Ported_number" => true)),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
     "Authorization: Token ".$json_goz->privatekey
  ),
));
$Gongresponse = curl_exec($curl);
curl_close($curl);
return $Gongresponse; 
}

function husmoApi($conn,$networkcode2, $phone, $code_fetch){	
    function fetchhusm($conn){
$query_hus = $conn->query("SELECT * FROM providers_api_key WHERE provider='husmodata'");
$husmkey = $query_hus->fetch_assoc();
return json_encode($husmkey);
}    
$json_hus = json_decode(fetchhusm($conn));
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
	"network" => $networkcode2,
	"mobile_number" => $phone,
	"plan" => $code_fetch,
	"Ported_number" => true
)),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
     "Authorization: Token ".$json_hus->privatekey
  ),
));

$Husresponse = curl_exec($curl);
curl_close($curl);
return $Husresponse;
}

function smeplug($conn, $smeplugnet_id, $code_fetch, $phone ){
    function fetchsplug($conn){
$query_splug = $conn->query("SELECT * FROM providers_api_key WHERE provider='smeplug'");
$splugkey = $query_splug->fetch_assoc();
return json_encode($splugkey);
}    
$json_splug = json_decode(fetchsplug($conn));
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
	"plan_id" => $code_fetch,
	"phone" => $phone
),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Bearer ".$json_splug->secretkey
  ),
));

$responsePlg = curl_exec($curl);
curl_close($curl);
return $responsePlg; 
}

function Apidefault($conn, $code_fetch){
$query_MapiS = $conn->query("SELECT * FROM data_package WHERE plancode='$code_fetch'");
$api_defualt = $query_MapiS->fetch_assoc();
return json_encode($api_defualt);
}


function epinApi($conn,$network,$phone,$code_fetch,$requestId){
    function fetchEpin($conn){
$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
$fetchepkey = $query_ep->fetch_assoc();
return json_encode($fetchepkey);
}    
$json_ep = json_decode(fetchEpin($conn));
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/data/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $json_ep->privatekey,
    "service" => $network,
    "MobileNumber" => $phone,
    "DataPlan" => $code_fetch,
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
curl_setopt($ch, CURLOPT_URL, "https://www.nellobytesystems.com/APIDatabundleV1.asp?UserID=$UserID&APIKey=$DisKey&MobileNetwork=$network&DataPlan=$code_fetch&MobileNumber=$phone&RequestID=$requestId&CallBackURL=$callb ");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$resdataClub = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);
return 	$resdataClub;
}

function mobilng($conn,$mobNet,$phone,$code_fetch,$requestId ){
    function fetchmobng($conn){
$query_mob = $conn->query("SELECT * FROM providers_api_key WHERE provider='mobileng'");
$mobkey = $query_mob->fetch_assoc();
return json_encode($mobkey);
}    
$json_mob = json_decode(fetchmobng($conn));
 $mobilekey = $json_mob->privatekey;
       $mobileID = $json_mob->secretkey;
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://mobileairtimeng.com/httpapi/datashare?userid=$mobileID&pass=$mobilekey&network=$mobNet&phone=$phone&datasize=$code_fetch&jsn=json&user_ref=$requestId");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$resdataMobN = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);	
return $resdataMobN;	
}

function MarkersApi($conn,$network,$phone,$code_fetch,$requestId){
    function fetchMarkers($conn){
$query_maks = $conn->query("SELECT * FROM providers_api_key WHERE provider='markersapi'");
$fetchmakey = $query_maks->fetch_assoc();
return json_encode($fetchmakey);
}    
$json_maks = json_decode(fetchMarkers($conn));
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://markersapi.com.ng/api/data/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $json_maks->privatekey,
    "service" => $network,
    "MobileNumber" => $phone,
    "DataPlan" => $code_fetch,
     "ref" => $requestId
    )));
$veridata_maks = curl_exec($ch);
curl_close($ch);
//file_put_contents('resp.txt',$veridata_maks);
return $veridata_maks;
}


function zoeDataHub($conn,$networkcode2, $phone, $code_fetch){	
    function zoekey($conn){
$query_zoe = $conn->query("SELECT * FROM providers_api_key WHERE provider='zoedatahub'");
$zoekey = $query_zoe->fetch_assoc();
return json_encode($husmkey);
}    
$json_zoe = json_decode(zoekey($conn));
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://zoedatahub.com/api/data/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
	"network" => strval(intval($networkcode2)),
	"mobile_number" => $phone,
	"plan" => $code_fetch,
	"Ported_number" => true
)),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
     "Authorization: Token ".$json_zoe->privatekey
  ),
));

$Zoeresponse = curl_exec($curl);
curl_close($curl);
return $Zoeresponse;
}

function BigSub($conn,$phone,$code_fetch,$network,$dataType){
    function fetchbigSubkey($conn){
$query_bsub = $conn->query("SELECT * FROM providers_api_key WHERE provider='bigsub'");
$bgsubkey = $query_bsub->fetch_assoc();
return json_encode($bgsubkey);
}    
$json_bsub = json_decode(fetchbigSubkey($conn));
$basic_key = base64_encode($json_bsub->privatekey.''.$json_bsub->secretkey); 
//Network Variations
if($network == '01' && $dataType == 'sme'){$bgvar = 1;}
if($network == '01' && $dataType == 'gifting'){$bgvar = 2;}
if($network == '02' && $dataType == 'gifting'){$bgvar = 4;}
if($network == '03' && $dataType == 'gifting'){$bgvar = 5;}
if($network == '03' && $dataType == 'sme'){$bgvar = 6;}
if($network == '04' && $dataType == 'sme'){$bgvar = 3;}
if($network == '04' && $dataType == 'gifting'){$bgvar = 9;}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://bigsub.com.ng/api/data.php?number=$phone&network=$bgvar&id=$code_fetch");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Basic $basic_key"
));
$BigSubResponse = curl_exec($ch);
curl_close($ch);   
//file_put_contents('airtime.txt',$BigSubResponse);
return  $BigSubResponse;   
}
?>