<?php 
session_start();
require_once('db.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$smtpMailRoot =  $_SERVER["DOCUMENT_ROOT"]. dirname($_SERVER['REQUEST_URI']);
require "$smtpMailRoot/PHPMailer/src/Exception.php";
require "$smtpMailRoot/PHPMailer/src/PHPMailer.php";
require "$smtpMailRoot/PHPMailer/src/SMTP.php";

$request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);	$qrysite = $conn->query("SELECT * FROM settings");
$sql_logo = $qrysite->fetch_assoc();
$siteName = $sql_logo['sitename'];
$qrySmtp = $conn->query("SELECT * FROM smtp_settings");
$rowsmtp = $qrySmtp->fetch_assoc();
$smtpHost = $rowsmtp['smtp_host']; 
$smtpPort = $rowsmtp['smtpport'];
$smtpUser = $rowsmtp['smtp_user'];
$smtpPass = $rowsmtp['smtp_pass'];
$support_email = $rowsmtp['adminEmail'];

$error = array();
$res = array();

$regVerify = sign_protect($_REQUEST["ot_cod"]);

if(empty($regVerify)){
$error[] = "Enter Verification code";
}

if(count($error) > 0){
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();
}

$fname = sign_protect($_SESSION['clientFName']);
$lname = sign_protect($_SESSION['clientLName']);
$validphone = sign_protect($_SESSION['clientPhone']);
$ClientEmail = sign_protect($_SESSION['clientEmail']);
$password = sign_protect($_SESSION['clientPass']);
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$country = sign_protect($_SESSION['clientCountry']);
$log = sign_protect($_SESSION['clientLog']);
$Votp = sign_protect($_SESSION['clientVcode']);

$refbyid = $_SESSION['refid']; 
$refby = $_SESSION['refby'];
$invite_count = $_SESSION['refcount'];

if(empty($_SESSION["clientVcode"]) OR $_SESSION["VCODESET"] !== true){

$error[] = "Access denied";
$resp['status'] = false;
$resp['msg'] = $error;
$resp['redirect'] = "signup.php";
echo json_encode($resp);
exit();
}


$level = "free";
$block = "Block";
$activate = "Activate";
$del = "Delete";
$bal = 0;
$cur = NULL;
$acctype = "normal";
$accno = mt_rand(1000,100000);
$ref = mt_rand(1003,100200);
$refwallet = 0;
$refid = "Admin";
$pincredit = 0;
$blockpro = '0';
$refcount = 0;
$reflink = 'https://'.$request_dir.'/signup.php?refid=';
$refunverified = 0;
$refverified = 0;

 function monnifyKey($conn){
$query_mfy = $conn->query("SELECT * FROM providers_api_key WHERE provider='monnify'");
$mfykey = $query_mfy->fetch_assoc();
return json_encode($mfykey);
}    
$json_mfy = json_decode(monnifyKey($conn));
$mapk =  $json_mfy->privatekey;   //$monRx['monn_apikey'];
$msekp = $json_mfy->secretkey;  //$monRx['monn_secret'];
$mconc = $json_mfy->contractcode;  //$monRx['monn_contra'];

if($regVerify == $Votp ){
    
    
    $smtchek = $conn->prepare("SELECT email,phone FROM users WHERE email=? OR phone=?");
    
    $smtchek->bind_Param("ss",$ClientEmail,$validphone);
    $smtchek->execute();
    $smtchek->store_result();
    
    if ($smtchek->num_rows > 0){ 
        
        $smtchek->fetch();
        //If there is already such username...
    
	$error[] = "Account already exist!  please login to continue";  
		$resp['status'] = false;
		$resp['msg'] = $error;
		echo json_encode($resp);
		exit();								
					
    }else{    
    
$json_m = json_decode(monnify($conn,$accno,$fname,$lname,$mconc,$ClientEmail,$mapk,$msekp));
$accName =  $json_m->responseBody->customerName;

foreach($json_m->responseBody->accounts as $ro ){
    
    for ($i = 0, $m = count($ro); $i < $m; $i++){
       createBank($conn,$json_m,$ro);
    }
}
// create VFD
$jsvfd = json_decode(CreateVPayAccount($conn,$validphone,$ClientEmail,$fname,$lname));
foreach ($jsvfd->virtualaccounts as $vp){
 AddVpay($conn,$vp,$jsvfd,$ClientEmail);
}

$isCre = NULL;
$sql = mysqli_query($conn,"INSERT into users(firstname,lastname,email,pass,phone,level,IPaddress,block,blockpro,activate,del,bal,pincredit,currency,acctype,country,accno,refid,refcount,refby,refwallet,reflink,refunverified,refverified,refbyid,credit,accountName,accountNumber,bankName,wema,moniepoint,sterling) VALUES('$fname','$lname','$ClientEmail','$hashed_password','$validphone','$level','$log','$block','$blockpro','$activate','$del','$bal','$pincredit','$cur','$acctype','$country','$accno','$ref','$refcount','$refby','$refwallet','$reflink','$refunverified','$refverified','$refbyid','$isCre','$accName','$bnkaccNo','$bnkName','$bnkaccNoWema','$moniePoint','$bnkaccNoSterling')") or die(mysqli_error());   

/*					
echo'<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Account created successfully. Please login to continue</strong> 
			</div>';
			*/

	$updaff = mysqli_query($conn,"UPDATE users SET refcount='$invite_count' WHERE refid='$refbyid' ");								
				
// send email
sendmailSMTP($conn,$smtpHost,$smtpPort,$smtpUser,$smtpPass,$support_email,$ClientEmail,$sql_logo,$siteName,$fname,$request_dir);

  $resp['msg'] = "Signup successful. Please login to your dashboard";
  $resp['status'] = true;
  $resp['redirect'] = "/";
  $resp['success'] = true;
  echo json_encode($resp); 
  exit();
  
    }

}else{ 

									
  $error[] = "Verification error";
  $resp['msg'] = $error;
  $resp['status'] = false;
  $resp['redirect'] = "../signup.php";
  echo json_encode($resp);
  exit();
    
}
    

function createBank($conn,$json_m,$ro){
    $Qreserve =  $conn->query("INSERT INTO auto_funding(id,bankName,accountNumber,bankCode) VALUES('".$json_m->responseBody->customerEmail."','".$ro->bankName."','".$ro->accountNumber."','".$ro->bankCode."')");
    return $Qreserve;
}

function sign_protect($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = filter_var($data, FILTER_SANITIZE_STRING);
   return $data;
}
function sendmailSMTP($conn,$smtpHost,$smtpPort,$smtpUser,$smtpPass,$support_email,$ClientEmail,$sql_logo,$siteName,$fname,$request_dir){
$from = "".$sql_logo['sitename']."<$support_email>"; //the email address from which this is sent
$to = "$ClientEmail"; //the email address you're sending the message to
$subject = "Welcome to ".$sql_logo['sitename']." "; //the subject of the message

// To send HTML mail, the Content-type header must be set
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "Return-Path: ".$sql_logo['sitename']."<".$sql_logo['sitename'].">\r\n";
$headers .= "Organization: ".$sql_logo['sitename']."\r\n";
 
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

<img src='https://".$request_dir."/sitelogo/".$sql_logo['sitelogo']."'>

<h3>Hey $fname,</h3>

We are glad to welcome you on Nigeria <br>
most trusted Instant & Automated digital recharge solution.<p> 

We have got lots of stuff to eliminate stress<br>
recharging your devices and in turn put some money <br>
in your wallet while doing so.<p>


<strong>Your login details are as follows:</strong> <p>

<table class='table' >
  
  <tr>
    <td>Login ID</td>
    <td>$ClientEmail</td>
  </tr>
  <tr>
    <td>Password</td>
    <td> *******</td>
  </tr>
  
   <tr>
    <td>Account Type</td>
    <td> Normal </td>
  </tr>
  
</table> <p>

".$sql_logo['sitename']." give you instant and automated recharge for Airtime, <br>
Internet Data, Gotv, Dstv, Startimes, Electric Token,Smile Internet.<p>

<a href='https://$siteName'><button class='button'>Try it Now!</button></a> <br>


<p>
Our support team is standby to assist you wherever you need help.<p>
 
 <strong>Email:</strong> ".$sql_logo['email']." 
<p>


Warm Regards, <p>


".$sql_logo['sitename']."

</body><html>";

//now mail
//$DoMail = mail($to,$subject,$message,$headers);
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtpHost;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtpUser;                  //SMTP username
    $mail->Password   = $smtpPass;               //SMTP password
    $mail->SMTPSecure = 'tls';     //Enable implicit TLS encryption
    $mail->Port       = $smtpPort;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom("$support_email", "$siteName");
    $mail->addAddress("$ClientEmail", "$fname");     //Add a recipient
   
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "$subject";
    $mail->Body    = "$message";
    
    $mail->send();
   // echo 'Message has been sent';
   
   
} catch (Exception $s) {
   
    ?>
    <div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Mailer Error: { could not connect to SMTP server } </strong> 
			</div>
    <?php
}
   
session_unset();    

session_destroy();           	
    

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
return $ResponseDetails;
}

function AddVpay($conn,$vp,$jsvfd,$ClientEmail){
$qrVp = $conn->query("INSERT INTO auto_funding(id,bankName,accountNumber,bankCode) 
VALUES('$ClientEmail','".$vp->bank."','".$vp->nuban."','$ClientEmail')");   return $qrVp; 
}



function monnify($conn,$accno,$fname,$lname,$mconc,$ClientEmail,$mapk,$msekp){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.monnify.com/api/v1/auth/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Basic ".base64_encode("$mapk:$msekp")
));
$authlog = curl_exec($ch);
curl_close($ch);										
$authoriz = json_decode($authlog,true);	
$accessToken =  $authoriz['responseBody']['accessToken'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.monnify.com/api/v2/bank-transfer/reserved-accounts");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
'accountReference' => $accno,
'accountName' =>  ''.$fname.' '.$lname.'',
'currencyCode'	=> 'NGN',
'contractCode'	=> $mconc,
'customerEmail' => $ClientEmail,
'customerName' => ''.$fname.' '.$lname.'',	
'getAllAvailableBanks' => true )));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Bearer $accessToken"));
$response = curl_exec($ch);
curl_close($ch);
file_put_contents("mo.txt",$response);
return $response;

}
?>