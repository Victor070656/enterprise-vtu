<?php 
date_default_timezone_set("Africa/Lagos");
require_once('../db.php');
include('mailer_transfer.php');
///////////////////////////Update DATA ID////////////////////////////

$resp = array();
$error = array();
$AccountNo = htmlspecialchars(stripslashes(trim($_REQUEST['accountNo']))); 
$amount = htmlspecialchars(stripslashes(trim(floatval($_REQUEST['amt']))));
$bank = htmlspecialchars(stripslashes(trim($_REQUEST['bankName'])));
$Pin = htmlspecialchars(stripslashes(trim(intval($_REQUEST['acntpass']))));
$Actname = htmlspecialchars(stripslashes(trim($_REQUEST['acntname'])));
$token = htmlspecialchars(stripslashes(trim($_REQUEST['token'])));
$proCode = htmlspecialchars(stripslashes(trim($_REQUEST['uniq'])));
$reference = htmlspecialchars(stripslashes(trim($_REQUEST['reference'])));
if(empty($bank)){
 $error[] = "Select Bank Name"; 
}

if(empty($AccountNo)){
 $error[] = "Enter account number"; 
}

if(empty($amount)){
 $error[] = "Enter Amount"; 
}

if(checkRefExist($conn,$proCode) > 0){ 
 
 $error[] = "Duplicate Transaction";   
 $resp['msg'] = $error;
 $resp['status'] = false;
 echo json_encode($resp);
 exit();
}else{
$fe = json_decode(fetchFee($conn),true);
$per = $fe[0]['user'];
$Processing_fee = ($per/100) * $amount;
$result = json_decode(fetchBank($conn,$bank),true);

$json_mfy = json_decode(monnifyKey($conn));
$mapk =  $json_mfy->privatekey;   //$monRx['monn_apikey'];
$msekp = $json_mfy->secretkey;  //$monRx['monn_secret'];
$mconc = $json_mfy->contractcode;  //$monRx['monn_contra'];
$monWalletid = $json_mfy->wallet_no;;

$userData = json_decode(UserInfo($conn,$token),true);
$active_gateway = json_decode(fetchBankGateway($conn),true);

$current_pin = $userData[0]['acc'];
$prev_balance = floatval($userData[0]['bal']);
$phone = $userData[0]['phone'];
$fname = $userData[0]['firstname'].' '.$userData[0]['lastname'];;
$current_bal = strval(floatval($prev_balance) - floatval($amount));
$new_current_bal = strval(floatval($current_bal) - floatval($Processing_fee)); 
$bankCode = $result[0]['bankcode'];

if(fetchkyc($conn,$token) > 0){
if(password_verify($Pin, $current_pin)){
 $amountcharge = strval(floatval($amount) + floatval($Processing_fee));
 if($amountcharge <= $prev_balance){   
///*******************************************************//

$Desc_memo = "Transfer";
$bank_Name = $result[0]['bankname'];

$encryptedkey  = base64_encode($mapk.':'.$msekp);

$gateway = $active_gateway[0]['gateway'];


if($gateway === "monnify"){
$mfyresponseCode = MonnifyTransfer($conn,$AccountNo,$bankCode,$encryptedkey,$proCode,$monWalletid,$Desc_memo,$amount);
}

if($gateway === "shago"){
$shagoResp = json_decode(shagoTransfer($conn, $reference, $hashkey,$proCode)); 

}

StoreResponseMessage($conn,$gateway,$mfyresponseCode,$amount,$Processing_fee);
if($mfyresponseCode->responseBody->status === 'SUCCESS' or $shagoResp->status == '200'){
DebitWallet($conn,$token,$new_current_bal);
SendEmail($conn, $sitname, $hosturl,$token, $fname ,$smtpHost , $smtpPort, $smtpUser, $smtpPass,$support_email,$logo,$amount,$Actname,$new_current_bal,$logoUrl);
InsertHistory($conn,$bankCode,$phone,$proCode,$amount,$token,$fname);
$resp['msg'] = "Transfer Successful";
$resp['status']  = true;
$resp['destination'] = $Actname;
$resp['amount'] = $amount;
echo json_encode($resp);
exit();  

}else{
    
    $error[] = "Transfer failed. Please try again";
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();   

}  
    
 }else{

$error[] = "Insufficient Balance";
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();     
    
}

}else{
 
 
 $error[] = "Incorrect PIN";
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();    
    
} 
    
}else{
    
  $error[] = "Account not enabled for bank transfer. contact admin";
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();   
}    
    
}

function DebitWallet($conn,$token,$new_current_bal){
$Rundbt = $conn->query("UPDATE users SET bal='$new_current_bal' WHERE email='$token'");
return $Rundbt;
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

function UserInfo($conn,$token){
$fqry = $conn->query("SELECT * FROM users WHERE email='$token'");
while($row[] = $fqry->fetch_assoc()){}
return json_encode($row);
}


function InsertHistory($conn,$bankCode,$phone,$proCode,$amount,$token,$fname){
$QryInsert = $conn->query("INSERT INTO transactions(network,serviceid,vcode,phone,ref,refer,amount,email,status,token,customer,servicetype,channel)VALUES('Bank Transfer','transfer','$bankCode','$phone','$proCode','$proCode','$amount','$token','Completed','na','$fname','banktransfer','Wallet')");    
 return $QryInsert;   
}

function checkRefExist($conn,$proCode){
$qTrf = $conn->query("SELECT * FROM transactions WHERE ref='$proCode'"); 
$tfrow = $qTrf->num_rows;
return $tfrow;
}

function fetchFee($conn){
$QrFe = $conn->query("SELECT * FROM charges WHERE service='moneytransfer'");
while($ch[] = $QrFe->fetch_assoc()){}
return json_encode($ch);
}

function fetchkyc($conn,$token){
$qrr = $conn->query("SELECT * FROM kyc_info WHERE email='$token' AND status='Approved'"); 
$row = $qrr->num_rows;
return $row;
}


function StoreResponseMessage($conn,$gateway,$mfyresponseCode,$amount,$Processing_fee){
$InsCode = $conn->query("INSERT INTO transfer_response(gateway,responseMessage,responseCode,amount,fee) VALUES('$gateway','".$mfyresponseCode->responseMessage."','".$mfyresponseCode->responseCode."','$amount','$Processing_fee')"); 
return $InsCode;
}


function MonnifyTransfer($conn,$AccountNo,$bankCode,$encryptedkey,$proCode,$monWalletid,$Desc_memo,$amount){

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
curl_setopt($ch, CURLOPT_URL, "https://api.monnify.com/api/v2/disbursements/single");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "amount" => $amount,
    "reference" => $proCode,
    "narration" => $Desc_memo,
    "destinationBankCode" => $bankCode,
    "destinationAccountNumber" => $AccountNo,
    "currency" => "NGN",
    "sourceAccountNumber" => $monWalletid,
    "destinationAccountName" => $Actname
    ]));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
 "Authorization: Bearer $valTok"
));
$responseMnf = curl_exec($ch);
curl_close($ch);
file_put_contents('res.txt',$responseMnf);
$retnVal = json_decode($responseMnf);
return $retnVal;
}


function shagoTransfer($conn, $reference, $hashkey,$proCode){ 
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
'serviceCode' => "WBB",
'reference' => $reference,
'request_id' => $proCode
)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "hashKey: $hashkey"
));
$response_shago = curl_exec($ch);
curl_close($ch);
return $response_shago;
}


?>