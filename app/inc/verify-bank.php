<?php 
date_default_timezone_set("Africa/Lagos");
require_once('../db.php');
///////////////////////////Update DATA ID////////////////////////////

$resp = array();

$AccountNo = htmlspecialchars(stripslashes(trim($_REQUEST['accountNo']))); 
$amount = htmlspecialchars(stripslashes(trim(floatval($_REQUEST['amt']))));
$bank = htmlspecialchars(stripslashes(trim($_REQUEST['bankName'])));

if(empty($bank)){
 $resp['inputbank'] = "Select Bank Name"; 
 echo json_encode($resp);
 exit();
}

if(empty($AccountNo)){
 $resp['acn'] = "Enter account number"; 
 echo json_encode($resp);
 exit();
}

if(empty($amount)){
 $resp['inputamount'] = "Enter Amount"; 
 echo json_encode($resp);
 exit();
}
$fe = json_decode(fetchFee($conn),true);
$per = $fe[0]['user'];
$Processing_fee = ($per/100) * $amount;

if(ctype_digit($amount)){
$result = json_decode(fetchBank($conn,$bank),true);

$active_gateway = json_decode(fetchBankGateway($conn),true);
$gateway = $active_gateway[0]['gateway'];

//////////////////////////////////////////////////////////////////
//$proCode = uniqid();
$Desc_memo = "Transfer";
$bnkcode = $result[0]['bankcode'];
$bank_Name = $result[0]['bankname'];


$json_mfy = json_decode(monnifyKey($conn));
$mapk =  $json_mfy->privatekey;   //$monRx['monn_apikey'];
$msekp = $json_mfy->secretkey;  //$monRx['monn_secret'];
$mconc = $json_mfy->contractcode;  //$monRx['monn_contra'];

$encryptedkey  = base64_encode($mapk.':'.$msekp);


if($gateway === "monnify"){
$mfyresponseCode = ValidateMonnify($conn,$AccountNo,$bnkcode,$encryptedkey);
if(!empty($mfyresponseCode->responseBody->accountName)){$response_Account_Name = $mfyresponseCode->responseBody->accountName; }else{$response_Account_Name = NULL;}
}

if($gateway === "shago"){
$shagoResp = json_decode(shagoValidate($conn, $amount,$bnkcode, $AccountNo, $hashkey,$bank_Name));    
if(!empty($shagoResp->customerName)){ $response_Account_Name = $shagoResp->customerName; }else{$response_Account_Name = NULL;}
if(!empty($shagoResp->customerName)){ $transfer_reference = $shagoResp->reference; }else{$transfer_reference = NULL;}
}

if(!empty($response_Account_Name) or $shagoResp->status == '200'){
$resp['msg'] = $response_Account_Name;
$resp['status']  = true;
$resp['reference'] = $transfer_reference;
$resp['fee'] = $Processing_fee;
echo json_encode($resp);
exit();  

}else{
    
    $error[] = "Couldn't resolve account number. Please try again";
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();   

}

}else{
 
 $error[] = "Enter correct amount";
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();     
    
}



function monnifyKey($conn){
$query_mfy = $conn->query("SELECT * FROM providers_api_key WHERE provider='monnify'");
$mfykey = $query_mfy->fetch_assoc();
return json_encode($mfykey);
}    


function fetchBank($conn,$bank){
$res = $conn->query("SELECT * FROM bank_gateway WHERE serial='$bank'");
while($resBank[] = $res->fetch_assoc()){
}
return json_encode($resBank);
}

function fetchBankGateway($conn){
$gres = $conn->query("SELECT * FROM bank_gateway_settings");
while($resgate[] = $gres->fetch_assoc()){
}
return json_encode($resgate);
}

function fetchFee($conn){
$QrFe = $conn->query("SELECT * FROM charges WHERE service='moneytransfer'");
while($ch[] = $QrFe->fetch_assoc()){}
return json_encode($ch);
}



function ValidateMonnify($conn,$AccountNo,$bnkcode,$encryptedkey){

function MonnifyToken($conn,$encryptedkey){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.monnify.com/api/v1/auth/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Basic $encryptedkey"));
$authlog = curl_exec($ch);
curl_close($ch);		
$authoriz = json_decode($authlog,true);
$accessToken =  $authoriz['responseBody']['accessToken'];
return $accessToken;
}   

$valTok = MonnifyToken($conn,$encryptedkey);
///////////////////////////////////////////////////////////////////
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.monnify.com/api/v1/disbursements/account/validate/?accountNumber=$AccountNo&bankCode=$bnkcode");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
 "Authorization: Bearer $valTok"
));
$responseMnf = curl_exec($ch);
curl_close($ch);
$retnVal = json_decode($responseMnf);
return $retnVal;
}




function shagoValidate($conn, $amount,$bnkcode, $AccountNo, $hashkey,$bank_Name){    
    
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
'serviceCode' => "WBV",
'amount' => $amount,
'bin' => $bnkcode,
'bank_account' => $AccountNo, 
'bank_name' => strtolower($bank_Name)
)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "hashKey: $hashkey"
));
$response_shago = curl_exec($ch);
curl_close($ch);
return $response_shago;
}


/* 
$request_ref = uniqid();
$apiKey = "sAYhe83zczAZlLLTSj87_4eaf0a58f2b045aa8f7602268f8fa729";
$secret = "9VOPcdxPuSY4SyP5";
$signature = $request_ref.';'.$secret;
$hashSignature = md5($signature);

$encrypt_Account = EncryptV2($secret,$AccountNo);

function EncryptV2($secret,$AccountNo)
{
   $key = md5(utf8_encode($secret), true);
    $key .= substr($key, 0, 8);
     // a 128 bit (16 byte) key
     // append the first 8 bytes onto the end
    //Pad for PKCS7
    $block = mcrypt_get_block_size('tripledes', 'cbc');
    $len = strlen($AccountNo);
    $padding = $block - ($len % $block);
    $AccountNo .= str_repeat(chr($padding),$padding);
    $iv =  "\0\0\0\0\0\0\0\0";
    $encData = mcrypt_encrypt('tripledes', $key, $AccountNo, 'cbc',$iv);
    echo base64_encode($encData);
}
		

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.openbanking.vulte.ng/v2/transact");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "request_ref" => $request_ref,
    "request_type" => 'lookup_nuban',
    "auth" => [
        "type" => 'bank.account',
        "secure" => $encrypt_Account,
        "auth_provider" => 'Polaris',
        "route_mode" => NULL
        ]
     ]));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
 "Authorization: Bearer $apiKey",
 "Signature: $hashSignature"
));
$responseMnf = curl_exec($ch);
curl_close($ch);
*/

?>