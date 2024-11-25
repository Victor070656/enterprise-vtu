  <?php 
 $chek = mysqli_query($conn,"SELECT * FROM users WHERE email='$user' ");
 
 $pdata = mysqli_fetch_array($chek); 
 if(isset($_POST['key'])){
			
$api_email = $_POST['api_email'];

$webs = $_POST['website'];

$xamount = 5000;

 if(!empty($api_email) && !empty($webs) ){
 
 if($pdata['level'] !== 'paid' ){
	 
echo "<div class='alert alert-danger'>You must have a reseller account to have access to our API, Upgrade your account now to get API access. </div>"; 

// payprocessor
 if($apib['activepay'] == 'paystack'){
include('inc/paystack_upgrade.php');
 }else{
	 
include('inc/flutterwave.php');	 
	 }
	 
	 
	 } else{     
	   
	   
$updat = mysqli_query($conn,"UPDATE users SET level='paid',apikey='$apikey' WHERE email ='$user' ") or die(mysqli_error()); 



$qrysit = mysqli_query($conn,"SELECT * FROM settings");
$sit = mysqli_fetch_array($qrysit);
$sitename = $sit['sitename'];
$serName = $_SERVER['HTTP_HOST'];

$from = "$sitename<support@$serName>"; //the email address from which this is sent
$to = "$user"; //the email address you're sending the message to
$subject = "Password Reset Notification"; //the subject of the message

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

New API key has being generated on your $serName account <br> 

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
             

	 }
   
 }else{
	 
	echo "<div class='alert alert-danger'>No Entry made </div>"; 
	 }
       
    } 

?> 
                                    
                                 
                                    
                     <p>Please note API key conditions below:</p>
  <ul class="w3-ul w3-card" style="">
    <li> Fill the form below correctly to request for an API key</li>
    <li> Service available on API are Direct DATA, SME Data, AIRTIME VTU,Electricity Payment and BILLS PAYMENT(Dstv, Gotv, Startimes, Smile Bundle, BulkSMS, WAEC PINs)</li>
    <li> You must upgrade to reseller account to have access to our API (Current account Type: <?php echo $acctype; ?>)</li>
    <li> You can generate new API key anytime free </li>
    <li> Keep your API key secured, don't share with anyone, <?php echo $sitename; ?> staffs will never request for it</li>
    <li> Enter valid email on API request, updates about API service will be sent to the email</li>
    <li> Enter the website address on which you want to use the API in this format e.g mywebsite.com</li>
    
    <li> For API service technical issue email support@<?php echo $servName; ?></li>
  </ul>                
                                    
                                    
               Fill the form below to request for an API key:                  
                                        
                                        
                                        
           <form method="post" action="" id="TransTable">
                                        <br>
                                        
                <label for="inputText3" class="col-form-label">Enter Valid Email Address(Update about API will be send to this email)</label>    
                                       <div class="input-group mb-3">
                                               
                      <input type="email" class="form-control" name="api_email" >
                                              
                                            </div>      
                                           
                                            
                           <div class="form-group">
          <label for="inputText3" class="col-form-label">Website Address (the website on which you want to use the API)</label>
    <input id="inputText3" type="url" class="form-control" name="website">
                                            </div>                   
                                         
                                     <div class="col-sm-6 pl-0">
                                         
                                                <p class="text-center">
                                                    <button type="submit" name="key" class="btn btn-rounded btn-primary" >Request API Key</button>