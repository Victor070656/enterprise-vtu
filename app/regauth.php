<?php
session_start();
date_default_timezone_set('Africa/Lagos');
$dat = date("Y-m-d h:i:s");
require_once('db.php');
$fdata = json_decode(file_get_contents('php://input'));
file_put_contents('kyc.txt', file_get_contents('php://input'));
$password = sign_protect($fdata->password);
$ClientEmail = sign_protect($fdata->email);
$phone = sign_protect($fdata->phone);
$fname = sign_protect($fdata->fname);
$lname = sign_protect($fdata->lname);
$recaptchaForm = sign_protect($fdata->g_recaptcha_response);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$smtpMailRoot =  $_SERVER["DOCUMENT_ROOT"] . dirname($_SERVER['REQUEST_URI']);
require "$smtpMailRoot/PHPMailer/src/Exception.php";
require "$smtpMailRoot/PHPMailer/src/PHPMailer.php";
require "$smtpMailRoot/PHPMailer/src/SMTP.php";
$request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);

$error = array();
$res = array();

$qrysite = $conn->query("SELECT * FROM settings");
$sql_logo = $qrysite->fetch_assoc();
$siteName = $sql_logo['sitename'];
$request_dir = $_SERVER['SERVER_NAME'];
$qrySmtp = $conn->query("SELECT * FROM smtp_settings");
$rowsmtp = $qrySmtp->fetch_assoc();
$smtpHost = $rowsmtp['smtp_host'];
$smtpPort = $rowsmtp['smtpport'];
$smtpUser = $rowsmtp['smtp_user'];
$smtpPass = $rowsmtp['smtp_pass'];
$support_email = $rowsmtp['adminEmail'];


$aff = $fdata->referal;
$qryaff = $conn->query("SELECT * FROM users WHERE refid='$aff' ");
$getref = $qryaff->fetch_assoc();
if ($aff === $getref['refid']) {
  $refby = sign_protect(" " . $getref['firstname'] . " " . $getref['lastname'] . " ");
  $refbyid = sign_protect($getref['refid']);
  $invitecount = sign_protect($getref['refcount'] + 1);
} else {

  $refby = "System";
  $refbyid = "System";
  $refcount = 1;
  $invitecount = NULL;
}



$level = "free";
$block = "Block";
$activate = "Activate";
$cur = "₦";
$log = sign_protect($_SERVER['REMOTE_ADDR']);
$acctype = "normal";
$country = sign_protect($_REQUEST['country']);
$accno = mt_rand(1000, 100000);
$ref = mt_rand(1000, 100000);
$refid = "Admin";



if (empty($fname)) {
  $error[] = "First name is required";
}
if (empty($lname)) {
  $error[] = "Last name is required";
}
if (empty($phone)) {
  $error[] = "Phone number is required";
}
if (empty($ClientEmail)) {
  $error[] = "Enter Valid Email address";
}
if (empty($password)) {
  $error[] = "Password is required";
}

if (count($error) > 0) {

  $resp['status'] = false;
  $resp['msg'] = $error;
  echo json_encode($resp);
  exit();
}

$reflink = 'https://' . $request_dir . '/signup.php?refid=';

$blackOut = array("anonymountest@gmail.com");
$arrayFilterBadWords = array("Test", "text", "test", "Anonymous", "anonymous", "hack", "user", "users", "bank", "MTN", "mtn", "epins", "admin", "Admin", "Epins", "Hacker", "Test1", "test2", "test3", "Test2", "Test3", "Anonymous1", "Anonymous2", "Anonymous3", "Glo", "Airtel", "Etisalat", "9mobile", "anything", "php", "java", "laravel", "Mad", "crazy", "madman", "idiot", "fool", "guy", "bad", "badoo", "badguy", "Carzy", "kim1200120@gmail.com", "Kim", "09078001277", "sunnycuriosity@gmail.com");

$blistIP = array("102.89.3.253", "102.89.3.253", "105.112.59.157", "197.210.29.46", "197.210.45.177", "82.145.223.131");

// Validate reCAPTCHA box 
if (!empty($recaptchaForm)) {
  // Google reCAPTCHA API secret key 
  $secretKey = $sql_logo['secretkey'];

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array(
    'secret' => $secretKey,
    'response' => $recaptchaForm
  )));
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $verifyResponse = curl_exec($curl);

  // Decode json data 
  $responseData = json_decode($verifyResponse, true);

  // If reCAPTCHA response is valid 
  if ($responseData['success'] !== false) {

    $validphone = preg_replace("/[^0-9]/", '', $phone);


    if (strlen($validphone) == 11) {

      $smtchek = $conn->prepare("SELECT email,phone FROM users WHERE email=? OR phone=?");

      $smtchek->bind_Param("ss", $ClientEmail, $validphone);
      $smtchek->execute();
      $smtchek->store_result();

      if ($smtchek->num_rows > 0) {

        $smtchek->fetch();
        //If there is already such username...

        $error[] = "Account already exist!  please login to continue";
        $resp['status'] = false;
        $resp['msg'] = $error;
        echo json_encode($resp);
        exit();
      } else {

        if (in_array($fname, $arrayFilterBadWords) || in_array($lname, $arrayFilterBadWords)) {


          $error[] = "Signup restricted. contact admin";
          $resp['status'] = false;
          $resp['msg'] = $error;
          echo json_encode($resp);
          exit();

          // refuse
        } elseif (in_array($log, $blistIP)) {

          // do nothing
          $error[] = "Access denied";
          $resp['status'] = false;
          $resp['msg'] = $error;
          echo json_encode($resp);
          exit();
        } else {


          $VeriCode = mt_rand(32348, 79021);
          $_SESSION['clientFName'] = $fname;
          $_SESSION['clientLName'] = $lname;
          $_SESSION['clientPhone'] = $validphone;
          $_SESSION['clientEmail'] = $ClientEmail;
          $_SESSION['clientPass'] = $password;
          $_SESSION['clientCountry'] = $country;
          $_SESSION['clientLog'] = $log;
          $_SESSION['clientVcode'] = $VeriCode;
          $_SESSION['VCODESET'] = true;
          $_SESSION['refid'] = $refbyid;
          $_SESSION['refby'] = $refby;
          $_SESSION['refcount'] = $invitecount;

          // Send Verification Email
          sendmailSMTP($conn, $smtpHost, $smtpPort, $smtpUser, $smtpPass, $support_email, $ClientEmail, $VeriCode, $sql_logo, $siteName, $fname, $request_dir, $error, $resp);


          $resp['status'] = true;
          $resp['msg'] = "Verification code sent to your email";
          $resp['redirect'] = "authorization.php";
          $resp['ok'] = true;
          echo json_encode($resp);
          exit();
        }
      }
      // check if phone is valid

    } else {

      $error[] = "Enter a valid phone number";
      $resp['status'] = false;
      $resp['msg'] = $error;
      echo json_encode($resp);
      exit();
    }
  } else {

    $error[] = "Robot verification failed, please try again.";
    $resp['status'] = false;
    $resp['msg'] = $error;
    echo json_encode($resp);
    exit();
  }
} else {

  $error[] = "Please check on the reCAPTCHA box.";
  $resp['status'] = false;
  $resp['msg'] = $error;
  echo json_encode($resp);
  exit();
}







function sign_protect($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = filter_var($data, FILTER_SANITIZE_STRING);
  return $data;
}
function sendmailSMTP($conn, $smtpHost, $smtpPort, $smtpUser, $smtpPass, $support_email, $ClientEmail, $VeriCode, $sql_logo, $siteName, $fname, $request_dir, $error, $resp)
{
  $Mailfrom = "" . $sql_logo['sitename'] . "$support_email"; //the email address from which this is sent
  $Mailto = "$ClientEmail"; //the email address you're sending the message to
  $Mailsubject = "" . $sql_logo['sitename'] . " Account verification "; //the subject of the message

  // To send HTML mail, the Content-type header must be set
  $Mailheaders .= 'MIME-Version: 1.0' . "\r\n";
  $Mailheaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $Mailheaders .= "X-Priority: 3\r\n";
  $Mailheaders .= "Return-Path: " . $sql_logo['sitename'] . "<" . $sql_logo['sitename'] . ">\r\n";
  $Mailheaders .= "Organization: " . $sql_logo['sitename'] . "\r\n";

  // Create email headers
  $Mailheaders .= 'From: ' . $Mailfrom . "\r\n" .
    'Reply-To: ' . $Mailfrom . "\r\n" .
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

</style>
</head>

<body>

<img src='https://" . $request_dir . "/sitelogo/" . $sql_logo['sitelogo'] . "'>

<h3>Hello $fname,</h3>

To complete your signup on " . $sql_logo['sitename'] . ", <br>
use the verification code below;<p> 

<strong>Verification Code</strong> <p>

<h1>$VeriCode</h1> <p>



Warm Regards, <p>


" . $sql_logo['sitename'] . "

</body><html>";

  //now mail
  //$VerDoMail = mail($Mailto,$Mailsubject,$Mailmessage,$Mailheaders);

  $mail = new PHPMailer(true);

  try {
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
    $mail->addAddress("$ClientEmail", "$fname");     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "$Mailsubject";
    $mail->Body    = "$Mailmessage";

    $mail->send();
    // echo 'Message has been sent';


  } catch (Exception $s) {

    $error[] = "SMTP authentication error";
    $resp['status'] = false;
    $resp['msg'] = $error;
    echo json_encode($resp);
    exit();

?>
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>Mailer Error: { could not connect to SMTP server } </strong>
    </div>
<?php
  }
  // End send verification Email
}
?>