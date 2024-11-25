<?php
include('../../db.php'); 

$payload = @file_get_contents('php://input');
$decod = json_decode($payload);
file_put_contents('vpay.txt',file_get_contents('php://input'));
function VPayKey($conn){
$query_vf = $conn->query("SELECT * FROM providers_api_key WHERE provider='vpay'");
$vfykey = $query_vf->fetch_assoc();
return json_encode($vfykey);
}    
$json_vfy = json_decode(VPayKey($conn));
$mapk =  $json_vfy->privatekey;   //$monRx['monn_apikey'];


$payref = $decod->reference;
$amtPaid = $decod->amount;
$datepay = $decod->timestamp;
$tranref = $decod->session_id;
$account_number = $decod->account_number;

function UserAccountNo($conn,$account_number){
$qryUserDt = $conn->query("SELECT * FROM auto_funding WHERE accountNumber='$account_number'");  
$fch_dt = $qryUserDt->fetch_assoc();
return json_encode($fch_dt);
}
$UserInfo = json_decode(UserAccountNo($conn,$account_number)); 
$userEmail = $UserInfo->id;

$pnt = "VFD Wallet Funding";
$stat = "Completed";

// Get Transaction Status

$qryTref = mysqli_query($conn,"SELECT * FROM transactions WHERE ref='$tranref'");
if(mysqli_num_rows($qryTref) > 0){
   die('Not transaction found'); 
// dont honor    
}else{
    
    $paymentDate = $decod->timestamp;
$qryUser = mysqli_query($conn,"SELECT * FROM users WHERE email='$userEmail' ");

$isUSer = mysqli_fetch_array($qryUser);

$fname = $isUSer['firstname'];
$lname = $isUSer['lastname'];
$phone = $isUSer['phone'];

$charge = strval(floatval($amtPaid) - floatval(45));

$chargeshow = number_format($charge,2,'.',',');
  
  $qrySt = mysqli_query($conn,"SELECT * FROM settings");
 $Getsit = mysqli_fetch_array($qrySt);
 
 $sitname = $Getsit['sitename'];
 $siturl = $_SERVER['SERVER_NAME'];
 $adminTel = $Getsit['mobile'];
 $sitlogo = $Getsit['sitelogo'];

$bonus = (0/100)*$charge;

$procBon = array($charge,$bonus);
$xbonus = array_sum($procBon);
$pulpreBal = $isUSer['bal'];
$refilWallet = array($pulpreBal,$xbonus);
$NwAdBalac = array_sum($refilWallet);

$stmtadmoney =  $conn->prepare("UPDATE users SET bal=? WHERE email=?");
$stmtadmoney->bind_Param("ss",$NwAdBalac,$userEmail);
if($stmtadmoney->execute()){
$qsel = "INSERT INTO transactions(network,phone,ref,refer,amount,charge,email,status,token,customer,del,servicetype,channel)VALUES('$pnt','$phone','$tranref','0','$amtPaid','$charge','$userEmail','$stat','0','$fname $lname','Delete','$pnt','Bank Transfer')";	
								
	$sav = $conn->query($qsel); 
								
function fetchbksms($conn){
$query_smsk = $conn->query("SELECT * FROM providers_api_key WHERE provider='sms'");
$smkey = $query_smsk->fetch_assoc();
return json_encode($smkey);
}    
$json_bksm = json_decode(fetchbksms($conn));

 $sender = "Wallet Credit"; 


$msg = "Your  account has been credited with N$chargeshow. Transaction ref:$payref. Thank you for choosing www.$siturl ";								

$data = array(
    'username' => $json_bksm->username,
    'password' => $json_bksm->password,
	 'sender' => $sender,
	  'recipient' => $phone,
	   'message' => $msg
	    
);
# Create a connection
$url = $json_bksm->baseurl;
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch); 
  
  
  //send email notification
  // Send Email Alert

$from = "$sitname<support@$siturl>"; //the email address from which this is sent
$to = "$userEmail"; //the email address you're sending the message to
$subject = "Wallet Credit Transaction "; //the subject of the message

// To send HTML mail, the Content-type header must be set
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "Return-Path: $sitname<support@$siturl>\r\n";
$headers .= "Organization: $sitname\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$message = "

<html>
<head>
<style>
.table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 50%;
}

td {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}


.button {
  background-color: #008CBA; /* Blue */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  border-radius: 8px;
  cursor: pointer;
  
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
}

.button:hover {
  background-color: #4CAF50; /* Green */
  color: white;
}

</style>
</head>

<body>

<img src='https://$siturl/user/sitelogo/$sitlogo'>

<h3>Hello $fname,</h3>

Your wallet has been credit with N$charge <br>

<strong>Your transaction details are as follows:</strong> <p>

<table class='table' >
  
  <tr>
    <td>Amount Credited</td>
    <td>N$charge</td>
  </tr>
  <tr>
    <td>Session ID</td>
    <td>$tranref</td>
  </tr>
  
   <tr>
    <td>Date</td>
    <td>$paymentDate</td>
  </tr>
  
   <tr>
    <td>New Balance</td>
    <td> N$NwAdBalac</td>
  </tr>
  
</table> <p>


Thank you for choosing www.$siturl.<p>
 
<p>



</body><html>";

//now mail
$DoMail = mail($to,$subject,$message,$headers);
  
  
  
}
$stmtadmoney->close();								
}


function ReQueryTransaction($conn,$payref,$json_vfy){
   
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://services2.vpay.africa/api/service/v1/query/merchant/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
   "username" => $json_vfy->username,
   "password" => $json_vfy->password
    )));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "publicKey:  ".$json_vfy->privatekey
));
$authlog = curl_exec($ch);
curl_close($ch);										
$authoriz = json_decode($authlog);	
$accessToken =  $authoriz->token;
file_put_contents("f.txt",$authlog);

// create account
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://services2.vpay.africa/api/api/service/v1/query/merchant/wallet/requery/transaction/$payref");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "publicKey: ".$json_vfy->privatekey,
  "b-access-token: $accessToken"));
$Response = curl_exec($ch);
curl_close($ch);
file_put_contents("event.txt",$Response);
return $Response;
}

http_response_code("HTTP 200 OK");



?>