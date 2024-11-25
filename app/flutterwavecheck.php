<?php
require('db.php');
$query_rec = mysqli_query($conn,"SELECT * FROM payment");
$apib = mysqli_fetch_array($query_rec);

$json_ep = json_decode(fetchflutterwave($conn)); 			
$paykey = $json_ep->secretkey;
	
			
// confirm Rave payment 

if(isset($_GET['transaction_id'])){
        $transaction_id = $_GET['transaction_id'];
        
        //Flutterwave verify Payment
$url = "https://api.flutterwave.com/v3/transactions/$transaction_id/verify";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt(
  $ch, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json',
    'Authorization: Bearer '.$paykey.'']
);
$response = curl_exec($ch);
curl_close($ch);  
        

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        
        curl_close($ch);

        $tranx = json_decode($response);
    
        
      	$paymentStatus = $tranx->data->status;
        $tx_ref = $tranx->data->tx_ref;
       //$chargeAmount = $tranx['data']['amount'];
    	
        
     
if($paymentStatus === 'successful' ) {
    
   /////////////////////////////

$customerEmail = $tranx->data->customer->email;							

							
	$Qryins = $conn->query("SELECT * FROM users WHERE email='$customerEmail' ");
	$rowdata = $Qryins->fetch_assoc();
								
	$email = $rowdata['email'];
	$rowpas = $rowdata['pass'];
	$fname = $rowdata['firstname'];
    $acct_balance = $rowdata['bal'];
	$sitephone = $settings['mobile'];		
		$QryTret = $conn->query("SELECT * FROM transactions WHERE ref='$tx_ref' ");
		$da = $QryTret->fetch_assoc();
		
		$amount = $da['amount'];
		$tid = $da['ref'];
		$token = $da['token'];
		$refer = $da['refer'];
		$status = $da['status'];						
 
  
    
  // amount to credit minus fees

$paidamt =  $tranx->data->amount;

$charge = $tranx->data->app_fee;

$payamt = $paidamt;

$amtshow = number_format($payamt,2,'.',',');

 $dat = $tranx->data->created_at;
  
                if($status !== 'Completed'){
				$sumBalance = strval(floatval($acct_balance) + floatval($paidamt)); 
				$addfund = $conn->query("UPDATE users SET bal='$sumBalance' WHERE email='$customerEmail'");
               
                // update
                $tk = md5(uniqid());
				$statu = "Completed";
                $r = $tx_ref;
                $channel = $tranx->data->payment_type;
				$up = "UPDATE transactions SET token='$tk',refer='$r',status='$statu',channel='$channel' WHERE ref='$tid' ";
				$conn->query($up);
				
			
				// send email....

$from = " ".$settings['sitename']."<support@$serName>"; //the email address from which this is sent
$to = "$customerEmail"; //the email address you're sending the message to
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
    <td>Wallet Funding</td>
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
    <td> $channel</td>
  </tr>
  
  <tr>
    <td>Fee</td>
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
<script>
setTimeout(function(){
window.location="add-fund.php?stat=true ";   
},1000);
</script> <?php 
    
  
  // transaction was successful...
  			 // please check other things like whether you already gave value for this ref
          // if the email matches the customer who owns the product etc
          //Give Value and return to Success page
          
          // amount to credit minus fees


        }else { 
            
            // don't give value and return to failed page

?>
<script> 
window.location.href="add-fund.php"; </script>
<?php
               
            
        }
    
    
    
    }
		
    
    
}else {
      die('No reference supplied');
      
     
    }


 function fetchflutterwave($conn){
$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='flutterwave'");
$fetchepkey = $query_ep->fetch_assoc();
return json_encode($fetchepkey);
}  

         

?>