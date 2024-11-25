<?php
include('../../db.php'); 

$payload = @file_get_contents('php://input');
$decod = json_decode($payload);

function monnifyKey($conn){
$query_mfy = $conn->query("SELECT * FROM providers_api_key WHERE provider='monnify'");
$mfykey = $query_mfy->fetch_assoc();
return json_encode($mfykey);
}    
$json_mfy = json_decode(monnifyKey($conn));
$mapk =  $json_mfy->privatekey;   //$monRx['monn_apikey'];
$msekp = $json_mfy->secretkey;  //$monRx['monn_secret'];
$mconc = $json_mfy->contractcode;  //$monRx['monn_contra'];
$seckey = $msekp;

$payref = $decod->eventData->paymentReference;
$amtPaid = $decod->eventData->amountPaid;
$datepay = $decod->eventData->paidOn;
$tranref = $decod->eventData->transactionReference;
$userEmail = $decod->eventData->customer->email;
$eventType = $decod->eventType;

$pnt = "Monnify Wallet Funding";
$stat = "Completed";
$encodeRef = urlencode($tranref);
// Get Transaction Status
$encokey  = base64_encode("$mapk:$msekp");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.monnify.com/api/v1/merchant/transactions/query?transactionReference=$encodeRef");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Authorization: Basic $encokey"
));

$response = curl_exec($ch);
curl_close($ch);

$transtatus = json_decode($response);

file_put_contents("event.txt","$payref | $userEmail | $amtPaid | $response");
if($transtatus->responseBody->paymentStatus == 'PAID' && $transtatus->responseBody->customerEmail == $userEmail && $transtatus->responseBody->amountPaid == $amtPaid  ){
$paymentDate = $transtatus->responseBody->completedOn;
$qryUser = mysqli_query($conn,"SELECT * FROM users WHERE email='$userEmail' ");

$isUSer = mysqli_fetch_array($qryUser);

$fname = $isUSer['firstname'];
$lname = $isUSer['lastname'];
$phone = $isUSer['phone'];

$charge = $amtPaid-50;

$chargeshow = number_format($charge,2,'.',',');

$qryTref = mysqli_query($conn,"SELECT * FROM transactions WHERE ref='$payref' ");
if(mysqli_num_rows($qryTref) > 0){
    
// dont honor    
}else{
  
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
$qsel = "INSERT INTO transactions(network,phone,ref,refer,amount,charge,email,status,token,customer,del,servicetype,channel)VALUES('$pnt','$phone','$payref','0','$amtPaid','$charge','$userEmail','$stat','0','$fname $lname','Delete','$pnt','Bank Transfer')";	
								
	$sav = $conn->query($qsel); 
								
$qryApi = mysqli_query($conn,"SELECT * FROM api_setting");
$apidata = mysqli_fetch_array($qryApi);

 $sender = "New Message"; 


$msg = "Your  account has been credited with N$chargeshow. Transaction ref:$payref. Thank you for choosing www.$siturl ";								

$data = array(
    'username' => $apidata['smsUserid'],
    'password' => $apidata['smsPass'],
	 'sender' => $sender,
	  'recipient' => $phone,
	   'message' => $msg
	    
);
# Create a connection
$url = $apidata['baseurl'];
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
    <td>Amount</td>
    <td>N$charge</td>
  </tr>
  <tr>
    <td>Transaction ID</td>
    <td> $payref</td>
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
}

http_response_code("HTTP 200 OK");



?>