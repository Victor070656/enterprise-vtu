<?php
date_default_timezone_set('Africa/Lagos');
$dat = date("Y-m-d h:i:s");

$error = array();
$resp = array();

$token = sanitize_input(base64_decode($_REQUEST['token']));
$plan = sanitize_input($_REQUEST['plan']);
$refcode = sanitize_input($_REQUEST['refcode']);
if (empty($token)) {
  $error[] = "Transaction token is empty";
}

if (empty($plan)) {
  $error[] = " Please select plan";
}

if (count($error) > 0) {
  $resp['status'] = false;
  $resp['msg'] = $error;
  echo json_encode($resp);
  exit();
}

require_once('../db.php');

$uid = substr(str_shuffle("0123456789678901"), 0, 16);
$reference = uniqid();
$stat = "Completed";
$channel = "Wallet";
$ActivationStatus = "ACTIVE";
$serviceID = "epinsactivation";

$userDetails = json_decode(fetchUser($conn, $token), true);
$customNam = $userDetails[0]['firstname'] . ' ' . $userDetails[0]['lastname'];
$current_balance = floatval($userDetails[0]['bal']);
$userPhone = $userDetails[0]['phone'];
$UserIPAddress = $userDetails[0]['IPaddress'];
$varUserId = $userDetails[0]['email'];


$ftrow =  json_decode(fetchPackage($conn, $plan), true);
$duration_fetch = $ftrow[0]['duration'];
$plan_fetch = $ftrow[0]['plan'];
$userprice_fetch = floatval($ftrow[0]['amount']);
$commission_fetch = floatval($ftrow[0]['commission']);

$merchantDetails = json_decode(fetchMerchant($conn, $token), true);

$sql_logo = json_decode(settings($conn));
$siteName = $sql_logo->sitename;
$sitelogo = $sql_logo->sitelogo;
$officialEmail = $sql_logo->email;

$base  = basename(dirname(__DIR__));
$cur_url = 'https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);
$logoUrl = str_replace($base, "", $cur_url);

$logo = $logoUrl . "sitelogo/" . $sitelogo;

$valu = $plan_fetch;
$splitplan = preg_split("/\s+/", $plan_fetch);
$accountType = $splitplan[0];

if (checkMerchantExist($conn, $token, $plan_fetch) > 0) {

  $error[] = $plan_fetch . " already Activated";
  $resp['msg'] = $error;
  $resp['redirect'] = "../../airtime-pins.php";
  $resp['exist'] = true;
  $resp['status'] = false;
  echo json_encode($resp);
  exit();
} else {

  if (floatval($userprice_fetch) <= floatval($current_balance)) {

    $newBalc =  strval(floatval($current_balance) - floatval($userprice_fetch));


    if (UserdebitWallet($conn, $newBalc, $varUserId)) {


      if (checkMerchantRecord($conn, $token) > 0) {

        updateMerchantPackage($conn, $token, $plan_fetch);
        $resp['msg'] = $plan_fetch . " Activation is Successful";
        $resp['status'] = true;
        $resp['description'] = 'You have activated ' . $plan_fetch;
        $resp['redirect'] = "../../airtime-pins.php";
        echo json_encode($resp);
        exit();
      } else if (addMerchant($conn, $token, $plan_fetch, $userprice_fetch, $duration_fetch, $ActivationStatus, $accountType)) {

        StoreTransaction($conn, $valu, $userPhone, $uid, $reference, $userprice_fetch, $UserEmail, $stat, $customNam, $dat, $serviceID, $channel);

        sendEmailNotification($conn, $plan_fetch, $siteName, $UserEmail, $logo, $customNam);

        // fetch sponsor
        $sponsor = json_decode(fetchSponsor($conn, $refcode), true);
        $commision_balance = floatval($sponsor[0]['refwallet']);
        $sponsorEmail = $sponsor[0]['email'];
        $sponsorName = $sponsor[0]['firstname'] . ' ' . $sponsor[0]['lastname'];
        $Referal_commission = strval(floatval($commision_balance) + floatval($commission_fetch));
        if (PayCommission($conn, $Referal_commission, $refcode)) {
          EmailSponsor($conn, $plan_fetch, $siteName, $sponsorEmail, $logo, $customNam, $Referal_commission, $sponsorName);
        }

        $resp['msg'] = "Account Activation Successful";
        $resp['status'] = true;
        $resp['description'] = 'You have activated ' . $plan_fetch;
        $resp['redirect'] = "../../airtime-pins.php";
        echo json_encode($resp);
        exit();
      } else {
        $error[] = "Error processing your request";
        $resp['msg'] = $error;
        $resp['status'] = false;
        echo json_encode($resp);
        exit();
      }
    } else {


      $error[] = "Network Error: Please Try again shortly";
      $resp['msg'] = $error;
      $resp['status'] = false;
      echo json_encode($resp);
      exit();
    }
  } else {

    $error[] = "Insufficient balance";
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();
  }
}


function fetchSponsor($conn, $refcode)
{
  $querysp = $conn->query("SELECT * FROM users WHERE refid='$refcode'");
  while ($rowsp[] = $querysp->fetch_assoc()) {
  }
  return json_encode($rowsp);
}

function updateMerchantPackage($conn, $token, $plan_fetch)
{
  $qryMup = $conn->query("UPDATE pin_merchants SET package='$plan_fetch' WHERE merchantid='$token'");
  return $qryMup;
}

function addMerchant($conn, $token, $plan_fetch, $userprice_fetch, $duration_fetch, $ActivationStatus, $accountType)
{
  $insertMerchant = $conn->query("INSERT INTO pin_merchants(merchantid,package,amountpaid,duration,status,plan)VALUES('$token','$plan_fetch','$userprice_fetch','$duration_fetch','$ActivationStatus','$accountType')");
  return $insertMerchant;
}

function checkMerchantRecord($conn, $token)
{
  $merCheck = $conn->query("SELECT * FROM pin_merchants WHERE merchantid='$token'");
  $mrow = $merCheck->num_rows;
  return $mrow;
}

function fetchPackage($conn, $plan)
{
  $qryPlan = $conn->query("SELECT * FROM epin_package WHERE serial='$plan'");
  while ($prow[] = $qryPlan->fetch_assoc()) {
  }
  return json_encode($prow);
}


function fetchUser($conn, $token)
{
  $qryUser = $conn->query("SELECT * FROM users WHERE email='$token'");
  while ($row[] = $qryUser->fetch_assoc()) {
  }
  return json_encode($row);
}


function UserdebitWallet($conn, $newBalc, $varUserId)
{
  $stmtDeb = $conn->prepare("UPDATE users SET bal=? WHERE email=?");
  $stmtDeb->bind_Param("ss", $newBalc, $varUserId);
  $result =   $stmtDeb->execute();
  $stmtDeb->close();
  return $result;
}

function PayCommission($conn, $Referal_commission, $refcode)
{
  $stmtComm = $conn->prepare("UPDATE users SET refwallet=? WHERE refid=?");
  $stmtComm->bind_Param("ss", $Referal_commission, $refcode);
  $resultCom =   $stmtComm->execute();
  $stmtComm->close();
  return $resultCom;
}

function UpdateTransaction($conn, $stats, $reference, $channel, $userprice_fetch, $newBalc, $dat, $transId, $requestId)
{
  $stmtTrUpd = $conn->prepare("UPDATE transactions SET status=?,token=?,channel=?,charge=?,newBal=?,date=?,transID=? WHERE ref=?");
  $stmtTrUpd->bind_Param("ssssssss", $stats, $reference, $channel, $userprice_fetch, $newBalc, $dat, $transId, $requestId);
  $resTran = $stmtTrUpd->execute();
  return $resTran;
}


function StoreTransaction($conn, $valu, $serviceID, $userPhone, $uid, $reference, $userprice_fetch, $UserEmail, $stat, $customNam, $dat, $channel)
{
  $stmtSmE = $conn->prepare("INSERT INTO transactions(network,serviceid,phone,ref,refer,amount,email,status,token,customer,date,servicetype,channel,charge)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $stmtSmE->bind_Param("ssssssssssssss", $valu, $serviceID, $userPhone, $uid, $reference, $userprice_fetch, $UserEmail, $stat, $reference, $customNam, $dat, $serviceID, $channel, $userprice_fetch);
  $donqry = $stmtSmE->execute();

  return $donqry;
}



function fetchMerchant($conn, $token)
{
  $qryMerch = $conn->query("SELECT * FROM pin_merchants WHERE merchantid='$token'");
  while ($rowmach[] = $qryMerch->fetch_assoc()) {
  }
  return json_encode($rowmach);
}

function checkMerchantExist($conn, $token, $plan_fetch)
{
  $checkMerch = $conn->query("SELECT * FROM pin_merchants WHERE merchantid='$token' AND package='$plan_fetch'");
  $resMerch = $checkMerch->num_rows;
  return $resMerch;
}

function sanitize_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = strip_tags($data);
  $data = filter_var($data, FILTER_SANITIZE_STRING);
  $data = filter_var($data, FILTER_SANITIZE_SPECIAL_CHARS);
  return $data;
}

function settings($conn)
{
  $qrysite = $conn->query("SELECT * FROM settings");
  $fetchResult = $qrysite->fetch_assoc();
  return json_encode($fetchResult);
}


function sendEmailNotification($conn, $plan_fetch, $siteName, $UserEmail, $logo, $customNam)
{
  // send OTP to email
  $from = "" . $siteName . "<no-reply@" . $_SERVER['SERVER_NAME'] . ">"; //the email address from which this is sent
  $to = "$UserEmail"; //the email address you're sending the message to
  $subject = "Your $plan_fetch Notification"; //the subject of the message

  // To send HTML mail, the Content-type header must be set
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= "X-Priority: 3\r\n";
  $headers .= "Return-Path: " . $siteName . "<" . $siteName . ">\r\n";
  $headers .= "Organization: " . $siteName . "\r\n";

  // Create email headers
  $headers .= 'From: ' . $from . "\r\n" .
    'Reply-To: ' . $from . "\r\n" .
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

<img src='$logo'>

<h3>Hi $customNam,</h3>
You have successfully activated <strong>$plan_fetch</strong> on your account. 
You can now generate pins.
<p> 

<a href='https://app.epins.com.ng/epins'>Click here to login and print recharge cards</a> <p>

Warm Regards, <p>

<a href='https://epins.com.ng'><strong>" . $siteName . "</strong></a><p>

<strong>DISCLAIMER:</strong><br>
<p>
The message and its attachments are for the designated recipient(s) only and may contain privileged, proprietary and private information. If you have received it in error, kindly delete it and notify the sender immediately. ePINs Nigeria accepts no liability for any damage resulting directly or indirectly from the transmission of this email message.

</body><html>";

  //now mail
  $DoMail = mail($to, $subject, $message, $headers);

  return $DoMail;
}


function EmailSponsor($conn, $plan_fetch, $siteName, $sponsorEmail, $logo, $customNam, $Referal_commission, $sponsorName)
{
  // send OTP to email
  $from = "" . $siteName . "<no-reply@" . $_SERVER['SERVER_NAME'] . ">"; //the email address from which this is sent
  $to = "$sponsorEmail"; //the email address you're sending the message to
  $subject = "You have earn N$Referal_commission Commission"; //the subject of the message

  // To send HTML mail, the Content-type header must be set
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= "X-Priority: 3\r\n";
  $headers .= "Return-Path: " . $siteName . "<" . $siteName . ">\r\n";
  $headers .= "Organization: " . $siteName . "\r\n";

  // Create email headers
  $headers .= 'From: ' . $from . "\r\n" .
    'Reply-To: ' . $from . "\r\n" .
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

<img src='$logo'>

<h3>Hi $sponsorName,</h3>
You have have earned <strong>N$Referal_commission</strong> for your refering a customer to $siteName. <br>

<strong>Below are the transaction details:</strong> <p>

<table class='table' >
  
  <tr>
    <td>Service</td>
    <td>$plan_fetch ePIN Activation</td>
  </tr>
  <tr>
    <td>Commission Paid</td>
    <td> N$Referal_commission</td>
  </tr>
  
   <tr>
    <td>Your referal</td>
    <td> $customNam </td>
  </tr>
  
</table> <p>
<p> 

<a href='https://app.epins.com.ng/epins'>Click here to login and print recharge cards</a> <p>

Warm Regards, <p>

<a href='https://epins.com.ng'><strong>" . $siteName . "</strong></a><p>

<strong>DISCLAIMER:</strong><br>
<p>
The message and its attachments are for the designated recipient(s) only and may contain privileged, proprietary and private information. If you have received it in error, kindly delete it and notify the sender immediately. ePINs Nigeria accepts no liability for any damage resulting directly or indirectly from the transmission of this email message.

</body><html>";

  //now mail
  $DoMail_sponsor = mail($to, $subject, $message, $headers);

  return $DoMail_sponsor;
}
