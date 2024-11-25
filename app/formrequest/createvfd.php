<?php
$error = array();
$resp = array();

$validphone = $_REQUEST['phone'];
$ClientEmail = $_REQUEST['email'];
$fname = $_REQUEST['fname'];
$lname = $_REQUEST['lname'];


require_once('../db.php');

// create VFD
$jsvfd = json_decode(CreateVPayAccount($conn,$validphone,$ClientEmail,$fname,$lname));

if($jsvfd->status !== false){

foreach ($jsvfd->virtualaccounts as $vp){
 AddVpay($conn,$vp,$jsvfd,$ClientEmail);
}

$resp['status'] = true;
$resp['msg'] = "VFD account generated successfully";
echo json_encode($resp);
exit();
} else {

$error[] = "Unable to complete this request. Wait for a little while, then try again"; 
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();   
    
}


function CreateVPayAccount($conn,$validphone,$ClientEmail,$fname,$lname){
    function vpayKey($conn){
$query_vpay = $conn->query("SELECT * FROM providers_api_key WHERE provider='vpay'");
$vpaykey = $query_vpay->fetch_assoc();
return json_encode($vpaykey);
    }  
$vkey = json_decode(vpayKey($conn));
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://services2.vpay.africa/api/service/v1/query/merchant/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
   "username" => $vkey->username,
   "password" => $vkey->password
    )));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "publicKey:  ".$vkey->privatekey
));
$authlogvfd = curl_exec($ch);
curl_close($ch);										
$authorizVFD = json_decode($authlogvfd);	
$vfdToken =  $authorizVFD->token;

// create account
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://services2.vpay.africa/api/service/v1/query/customer/add");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
'email' => $ClientEmail,
'phone' => $validphone,
'contactfirstname' => $fname,
'contactlastname' => $lname
 )));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "publicKey: ".$vkey->privatekey,
  "b-access-token: $vfdToken"));
$responseAdd = curl_exec($ch);
curl_close($ch);

// fetch account
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://services2.vpay.africa/api/service/v1/query/customer/showByEmail?email=$ClientEmail");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "publicKey: ".$vkey->privatekey,
  "b-access-token: $vfdToken"));
$ResponseDetails = curl_exec($ch);
curl_close($ch);
file_put_contents('ch.txt',$ResponseDetails);
return $ResponseDetails;
}

function AddVpay($conn,$vp,$jsvfd,$ClientEmail){
$qrVp = $conn->query("INSERT INTO auto_funding(id,bankName,accountNumber,bankCode) 
VALUES('$ClientEmail','".$vp->bank."','".$vp->nuban."','$ClientEmail')");   return $qrVp; 
}
?>