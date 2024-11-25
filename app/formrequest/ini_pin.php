<?php
date_default_timezone_set('Africa/Lagos');
$dat = date("Y-m-d h:i:s");

$error = array();
$resp = array();

$network = sanitize_input($_REQUEST['network']);
$plan = sanitize_input($_REQUEST['plan']);
$qty = sanitize_input(preg_replace("/[^0-9]/", '', $_REQUEST['qty']));
$token = sanitize_input(base64_decode($_REQUEST['token']));
//////////////////////
if (empty($network)) {
  $error[] = "Select Network";
}

if (empty($plan)) {
  $error[] = "Select Denomination";
}

if (empty($qty)) {
  $error[] = "Enter PIN qauntity";
}


if (count($error) > 0) {
  $resp['status'] = false;
  $resp['msg'] = $error;
  echo json_encode($resp);
  exit();
}

require_once('../db.php');

if ($network == 'mtn') {
  $provider = "mtn";
  $img = 'Data-mtn.jpg';
}
if ($network == 'glo') {
  $provider = "glo";
  $img = 'GLO-Data.jpg';
}
if ($network == 'etisalat') {
  $provider = "9mobile";
  $img = '9mobile-Data.jpg';
}
if ($network == 'airtel') {
  $provider = "airtel";
  $img = 'Airtel-Data.jpg';
}

$uid = substr(str_shuffle("0123456789678901"), 0, 16);
$reference = uniqid();
$stat = "pending";
$channel = "Wallet";

$userDetails = json_decode(fetchUser($conn, $token), true);
$UserEmail = $userDetails[0]['email'];
$customNam = $userDetails[0]['firstname'] . ' ' . $userDetails[0]['lastname'];
$userPhone = $userDetails[0]['phone'];
$user_level = $userDetails[0]['level'];

if (checkMerchantRecord($conn, $UserEmail) > 0) {

  $ftrow =  json_decode(fetchPackage($conn, $plan), true);
  $network_fetch = $ftrow[0]['network'];
  $plan_fetch = $ftrow[0]['plan'];
  $code_fetch = $ftrow[0]['code'];
  $userprice_fetch = floatval($ftrow[0]['price_user']);
  $apiprice_fetch = floatval($ftrow[0]['price_api']);

  if ($user_level !== 'paid') {

    $totalAmount = strval(floatval($userprice_fetch) * intval($qty));
  } else {
    $totalAmount = strval(floatval($apiprice_fetch) * intval($qty));
  }



  $valu = strtoupper($provider) . ' ' . $plan_fetch . "($qty)";

  $stmtSmE = $conn->prepare("INSERT INTO transactions(network,serviceid,vcode,qty,ref,refer,amount,charge,email,status,token,customer,date,phone,channel)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $stmtSmE->bind_Param("sssssssssssssss", $valu, $network, $code_fetch, $qty, $uid, $reference, $totalAmount, $totalAmount, $UserEmail, $stat, $reference, $customNam, $dat, $userPhone, $channel);

  if ($stmtSmE->execute()) {
    session_start();
    strval($_SESSION['amt'] = floatval(abs($userprice_fetch)));
    strval($_SESSION['carier'] = $network);
    strval($_SESSION['qty'] = $qty);
    strval($_SESSION['transid'] = $uid);
    strval($_SESSION['plan'] = $plan_fetch);
    strval($_SESSION['variation_code'] = $plan_fetch);
    strval($_SESSION['descr'] = $valu);
    strval($_SESSION['img'] = $img);
    strval($_SESSION['status'] = $stat);
    $resp['msg'] = "Redirecting... please wait";
    $resp['status'] = true;
    $resp['redirect'] = "transaction-view/pingenerator?" . $uid;
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

  $error[] = "Access denied. Activate Pin Generator ";
  $resp['msg'] = $error;
  $resp['redirect'] = "transaction-view/subscribe";
  $resp['activation'] = 0;
  $resp['status'] = false;
  echo json_encode($resp);
  exit();
}

function checkMerchantRecord($conn, $UserEmail)
{
  $merCheck = $conn->query("SELECT * FROM pin_merchants WHERE merchantid='$UserEmail'");
  $mrow = $merCheck->num_rows;
  return $mrow;
}

function fetchPackage($conn, $plan)
{
  $qryPlan = $conn->query("SELECT * FROM pins_package WHERE serial='$plan'");
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
