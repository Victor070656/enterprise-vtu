<?php
session_start();
require('db.php');
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
header("location: index.php");
  exit;
		}
	include('inc/func.php');
								
	$user = $_SESSION['user'];
								
	$ins = mysqli_query($conn,"SELECT * FROM users WHERE email='$user' ");
	$data = mysqli_fetch_array($ins);
								
	$email = $data['email'];

	$fname = $data['firstname'];


 // confirm  payment    
$curl = curl_init();
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
if(!$reference){
  die('No reference supplied');
}

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "authorization: Bearer $paykey",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);


if($err){
	// there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response);

if(!$tranx->status){
  // there was an error from the API
  die('API returned error: ' . $tranx->message);
}



if($tranx->data->status === 'success'){

$updat = mysqli_query($conn,"UPDATE users SET level='paid',apikey='$apikey' WHERE email ='$user' ") or die(mysqli_error());
			   
				
$dat = date("d/m/Y");			
				// send email....

$qrysit = mysqli_query($conn,"SELECT * FROM settings");
$sit = mysqli_fetch_array($qrysit);
$sitename = $sit['sitename'];
$serName = $_SERVER['HTTP_HOST'];

$from = "$sitename<support@$serName>"; //the email address from which this is sent
$to = "$user"; //the email address you're sending the message to
$subject = "Account Upgrade Notification"; //the subject of the message

// To send HTML mail, the Content-type header must be set
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "Return-Path: $sitename<support@$serName>\r\n";
$headers .= "Organization: $sitename\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$message = "

<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<style>
table {
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
</style>
</head>

<body>


<h3>Dear $fname,</h3>

Your account has being upgraded and API key generated <br> 

<table class='table' >
  
  <tr>
    <td>New API Key</td>
    <td>$apikey</td>
  </tr>
  
</table> <p>

If this action was not carried out by you, please contact 
 support@$serName 
<p>


Thank You!. <p>

<strong>$serName</strong>

</body><html>";

//now mail
$DoMail = mail($to,$subject,$message,$headers);
               
 ?>
<script>window.location="buy_credit.php?ref='<?php echo $_GET['reference']?>' ";</script> <?php 
    
  // transaction was successful...
  // please check other things like whether you already gave value for this ref
  // if the email matches the customer who owns the product etc
  // Give value
                
}
         

?>