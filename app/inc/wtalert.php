<?php

function bankupdate($from,$to,$subject,$message,$headers,$fname,$serName,$bankname,$accno,$accname){
	 
$from = "$sitename<support@$serName>"; //the email address from which this is sent
$to = "$user"; //the email address you're sending the message to
$subject = "Payment Information Updated"; //the subject of the message

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

<h3>Hi $fname,</h3>

Your payment details has been updated on $serName  <br> 

<table class='table' >
  
  <tr>
    <td>Bank Name</td>
    <td>$bankname</td>
  </tr>
  
  <tr>
    <td>Account Number</td>
    <td>$accno</td>
  </tr>
  
  <tr>
    <td>Account Name</td>
    <td>$accname</td>
  </tr>
  
</table> <p>

If this action was not carried out by you, please contact 

the email support@$serName 
<p>


Thank You!. <p>

<strong>$serName</strong>

</body><html>";

//now mail
$DoMail = mail($to,$subject,$message,$headers);	 
	 
	 
	 
	 }
	 
	function ok(){
	echo '<div class="alert alert-info">Bank Details Saved</div> <script>setTimeout(function(){ window.location="earnings.php" }, 3000);</script>';	
		
		} 
		
function xt(){
	echo '<div class="alert alert-danger">No Bank Details Added. Add Bank Details</div> <script>setTimeout(function(){ window.location="earnings.php" }, 3000);</script>';	
		
		} 	
		
function xt2(){
	echo '<div class="alert alert-success">Earning Successful transferred to your wallet</div> <script>setTimeout(function(){ window.location="earnings.php" }, 3000);</script>';	
		
		} 	
		
function xt3(){
	echo '<div class="alert alert-success">Your withdrawal request has been successfuly submitted. Your Bank Account will be credited with 24 hours</div> <script>setTimeout(function(){ window.location="earnings.php" }, 5000);</script>';	
		
		}
		
function xt4(){
	echo '<div class="alert alert-danger">Insufficient Balance</div> <script>setTimeout(function(){ window.location="earnings.php" }, 3000);</script>';	
		
		} 		 				
	 
	 
?>