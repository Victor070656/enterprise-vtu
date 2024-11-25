<?php
session_start();
require('db.php');
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
header("location: index.php");
  exit();
		}
	include('inc/func.php');							
	$user = $_SESSION['user'];
								
	$ins = mysqli_query($conn,"SELECT * FROM users WHERE email='$user' ");
	$data = mysqli_fetch_array($ins);
								
	$email = $data['email'];
	$rowpas = $data['pass'];
	$fname = $data['firstname'];
    $previous_balance = $data['bal'];    
	
	
	$ref = $_SESSION['ref'];
	$sitephone = $settings['mobile'];		
		$ret = mysqli_query($conn,"SELECT * FROM deposit WHERE ref='$ref' ");
		
		$da = mysqli_fetch_array($ret);
		
		$amount = $da['amount'];
		//$tid = $da['ref'];
		$token = $da['token'];
		$refer = $da['refer'];
		$status = $da['status'];						

$serName = $_SERVER['HTTP_HOST'];	
$json_ep = json_decode(fetchPaystack($conn)); 			
$paykey = $json_ep->secretkey;

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
    
    
  // amount to credit minus fees

$paidamt =  substr($tranx->data->amount,0,-2);

$charge = substr($tranx->data->fees,0,-2);

$payamt = $paidamt-$charge;

$amtshow = number_format($payamt,2,'.',',');

    
                if($token === $refer && $status !== 'Completed'){
				$Current_balance = strval(floatval($previous_balance) + floatval($payamt));
				$addfund = mysqli_query($conn, "UPDATE users SET bal='$Current_balance' WHERE email='$email'");
               
                
                // update
                $tk = md5(uniqid());
				$statu = "Completed";
                $r = $_GET['reference'];
                
				$up = "UPDATE transactions SET token='$tk',refer='$r',status='$statu',channel='Paystack' WHERE ref='$reference' ";
				$conn->query($up);
				
$dat = date("d/m/Y");			
				// send email....

$from = " ".$settings['sitename']."<support@$serName>"; //the email address from which this is sent
$to = "$user"; //the email address you're sending the message to
$subject = "Transaction Notification"; //the subject of the message

// To send HTML mail, the Content-type header must be set
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "Return-Path: ".$settings['sitename']."<support@$serName>\r\n";
$headers .= "Organization: ".$settings['sitename']."\r\n";
 
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

<img src='https://".$_SERVER['SERVER_NAME']."/portal/assets/images/logo.png'>

<h3>Dear $fname,</h3>

Your account has been credited <br> 

<h2 style='color:#06AF3E'>N$amtshow</h2> <p>

<strong>Transaction Summary</strong> <p>

<table class='table' >
  
  <tr>
    <td>Description</td>
    <td>Wallet Credit</td>
  </tr>
  <tr>
    <td>Transaction Date</td>
    <td> $dat </td>
  </tr>
  
  <tr>
    <td>Transaction Ref</td>
    <td> $ref </td>
  </tr>
  
   <tr>
    <td>Payment Method</td>
    <td> ATM Card</td>
  </tr>
  
  <tr>
    <td>Card Fee</td>
    <td> $charge</td>
  </tr>
  
   <tr>
    <td>Transaction Status</td>
    <td> $statu </td>
  </tr>
  
</table> <p>


<a href='https://$serName'>Click here</a> to login and confirm <p>

If you have questions/complaints as regards this transaction, please reply 

the email support@$serName or <strong>Call:</strong> $sitephone
<p>


Thanks for your Patronage. <p>

<strong>$serName</strong>

</body><html>";

//now mail
$DoMail = mail($to,$subject,$message,$headers);
             
               
 ?>
<script>window.location="add-fund.php?ref='<?php echo $_GET['reference']?>' ";</script> <?php 
    
  // transaction was successful...
  // please check other things like whether you already gave value for this ref
  // if the email matches the customer who owns the product etc
  // Give value
                }

}
 
 
 function fetchPaystack($conn){
$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='paystack'");
$fetchepkey = $query_ep->fetch_assoc();
return json_encode($fetchepkey);
}    
       

?>