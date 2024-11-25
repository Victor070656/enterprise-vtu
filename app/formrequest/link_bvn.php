<?php
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos');
$dateTime = date("d-M-Y h:i:A");
$error = array();
$resp = array();

$jsData = json_decode(file_get_contents('php://input'));

$ClientEmail = $jsData->eid;
$reference = $jsData->tok;

require_once('../db.php');

$json = json_decode(settings($conn));
$siteName = $json->sitename;
$siteUrl = $json->domain;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$smtpMailRoot =  $_SERVER["DOCUMENT_ROOT"]. dirname($_SERVER['REQUEST_URI']);
//file_put_contents('k.txt',$smtpMailRoot);
require "$smtpMailRoot/../PHPMailer/src/Exception.php";
require "$smtpMailRoot/../PHPMailer/src/PHPMailer.php";
require "$smtpMailRoot/../PHPMailer/src/SMTP.php";
$request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);


$qrySmtp = $conn->query("SELECT * FROM smtp_settings");
$rowsmtp = $qrySmtp->fetch_assoc();
$smtpHost = $rowsmtp['smtp_host']; 
$smtpPort = $rowsmtp['smtpport'];
$smtpUser = $rowsmtp['smtp_user'];
$smtpPass = $rowsmtp['smtp_pass'];
$support_email = $rowsmtp['adminEmail'];

function monnifyKey($conn){
$query_monfy = $conn->query("SELECT * FROM providers_api_key WHERE provider='monnify'");
$mnykey = $query_monfy->fetch_assoc();
return json_encode($mnykey);
    }  
$monikey = json_decode(monnifyKey($conn)); 
// create VFD
$jsvfd = json_decode(UpdateBVN($conn, $reference, $jsData ,$monikey));


if($jsvfd->responseMessage === 'success'){
$customerName = $jsvfd->responseBody->customerName;
linky($conn,$ClientEmail);


$AdminEmail = $json->email;
$fname = $json->sitename;
$support_phone = $json->mobile;
// send Login Notification to email
loginNotification($conn, $siteName, $dateTime, $fname,$smtpHost,$smtpPort,$smtpUser,$smtpPass,$AdminEmail,$sql_logo,$request_dir,$support_phone,$support_email,$siteUrl,$customerName); 
 
$resp['status'] = true;
$resp['msg'] = $jsvfd->responseMessage;
echo json_encode($resp);
exit();
} else {

$error[] = $jsvfd->responseMessage; 
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();   
    
}



function UpdateBVN($conn, $reference, $jsData , $monikey){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.monnify.com/api/v1/auth/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Basic ".base64_encode($monikey->privatekey.':'.$monikey->secretkey)));
$authlog = curl_exec($ch);
curl_close($ch);		 
$authoriz = json_decode($authlog);
$accessToken =  $authoriz->responseBody->accessToken;

// Update account
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.monnify.com/api/v1/bank-transfer/reserved-accounts/$reference/kyc-info");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
'bvn' => $jsData->IdNumber,
'accountReference' => $reference
)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Bearer $accessToken"));
$MonnifyUpdateresponse = curl_exec($ch);
curl_close($ch);

//file_put_contents('monify.txt',$MonnifyUpdateresponse);
return $MonnifyUpdateresponse;
}




function linky($conn,$ClientEmail){
$qrVp = $conn->query("UPDATE auto_funding SET status='active' WHERE id='$ClientEmail'");
 return $qrVp; 
}



function settings($conn){
$qrysite = $conn->query("SELECT * FROM settings");
$sql_logo = $qrysite->fetch_assoc();
return  json_encode($sql_logo);
}


function ExactBrowserName()
{
$ExactBrowserNameUA=$_SERVER['HTTP_USER_AGENT'];

if (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")) {
    // OPERA
    $ExactBrowserNameBR="Opera";
} elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "chrome/")) {
    // CHROME
    $ExactBrowserNameBR="Chrome";
} elseIf (strpos(strtolower($ExactBrowserNameUA), "msie")) {
    // INTERNET EXPLORER
    $ExactBrowserNameBR="Internet Explorer";
} elseIf (strpos(strtolower($ExactBrowserNameUA), "firefox/")) {
    // FIREFOX
    $ExactBrowserNameBR="Firefox";
} elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")==false and strpos(strtolower($ExactBrowserNameUA), "chrome/")==false) {
    // SAFARI
    $ExactBrowserNameBR="Safari";
} else {
    // OUT OF DATA
    $ExactBrowserNameBR="OUT OF DATA";
};

return $ExactBrowserNameBR;
}

function loginNotification($conn, $siteName, $dateTime, $fname,$smtpHost,$smtpPort,$smtpUser,$smtpPass,$AdminEmail,$sql_logo,$request_dir,$support_phone,$support_email,$siteUrl,$customerName){
$Mailfrom = "$siteName <$support_email>"; //the email address from which this is sent
$Mailto = "$AdminEmail"; //the email address you're sending the message to
$Mailsubject = "BVN Update Notification "; //the subject of the message

// To send HTML mail, the Content-type header must be set
$Mailheaders  = 'MIME-Version: 1.0' . "\r\n";
$Mailheaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$Mailheaders .= "X-Priority: 3\r\n";
$Mailheaders .= "Return-Path: $siteName < $siteName>\r\n";
$Mailheaders .= "Organization: $siteName\r\n";
 
// Create email headers
$Mailheaders .= 'From: '.$Mailfrom."\r\n".
    'Reply-To: '.$Mailfrom."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$Mailmessage = "

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

 .bottom-three {
     margin-bottom: 1cm;
  }

</style>
</head>

<body>



Dear $fname,

<h3>$customerName KYC UPDATED</h3>
<p>
Please be informed that $customerName has updated BVN on <strong> $dateTime </strong>. Browser ".ExactBrowserName()." <br>


</p>
<a href='$siteUrl'><strong>$siteName</strong></a><p>
<hr>


<p class='bottom-three'>
<strong>DISCLAIMER:</strong>
<p></p>
The message and its attachments are for the designated recipient(s) only and may contain privileged, proprietary and private information. <br> 
If you have received it in error, kindly delete it and notify the sender immediately. $siteName accepts no liability for any damage resulting directly <br> or indirectly from the transmission of this email message.
<p>
</body><html>";

//now mail
//$DoSendMail = mail($Mailto,$Mailsubject,$Mailsubject,$Mailheaders);

$mail = new PHPMailer(true);
 //Server settings
    $mail->SMTPDebug = 0;       //Enable verbose debug output
    $mail->isSMTP();             //Send using SMTP
    $mail->Host       = $smtpHost;  //Set the SMTP server to send through
    $mail->SMTPAuth   = true;       //Enable SMTP authentication
    $mail->Username   = $smtpUser;  //SMTP username
    $mail->Password   = $smtpPass;  //SMTP password
    $mail->SMTPSecure = 'tls';     //Enable implicit TLS encryption
    $mail->Port       = $smtpPort;  //TCP portto connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom("$support_email", "$siteName");
    $mail->addAddress("$AdminEmail", "$fname");     //Add a recipient
   
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "$Mailsubject";
    $mail->Body    = "$Mailmessage";
    
    $mail->send();
   // echo 'Message has been sent';
return $mail;
}

?>