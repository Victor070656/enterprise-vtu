<?php
date_default_timezone_set('Africa/Lagos');
$dat = date("Y-m-d h:i:s");

$error = array();
$resp = array();

$network = sanitize_input($_REQUEST['carier']);
$amount = sanitize_input(floatval(abs($_REQUEST['amt'])));
$phone = sanitize_input(preg_replace("/[^0-9]/", '', $_REQUEST['phone']));
$token = sanitize_input(base64_decode($_REQUEST['token']));
//////////////////////
if (empty($network)) {
  $error[] = "Select Network";
}

if (empty($amount)) {
  $error[] = "Enter Amount";
}

if (empty($phone)) {
  $error[] = "Enter receiver's phone number";
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
  $img = 'mtn.jpg';
}
if ($network == 'glo') {
  $provider = "glo";
  $img = 'glo.jpg';
}
if ($network == 'etisalat') {
  $provider = "9mobile";
  $img = '9mobile.jpg';
}
if ($network == 'airtel') {
  $provider = "airtel";
  $img = 'airtel.jpg';
}
if ($network == 'ntel') {
  $provider = "ntel";
  $img = 'ntel.jpg';
}

$uid = substr(str_shuffle("0123456789678901"), 0, 16);
$reference = uniqid();
$stat = "pending";
$channel = "Wallet";
$userDetails = json_decode(fetchUser($conn, $token), true);
$UserEmail = $userDetails[0]['email'];
$customNam = $userDetails[0]['firstname'] . ' ' . $userDetails[0]['lastname'];
$bal = $userDetails[0]['bal'];

$ftrow =  json_decode(fetchPackage($conn, $network), true);
$network_fetch = $ftrow[0]['network'];
$discount_fetch = floatval($ftrow[0]['discount']);
$per = floatval($ftrow[0]['user_discount']);
$gateway_fetch = $ftrow[0]['gateway'];
$status_fetch = $ftrow[0]['status'];

$user_level = $userDetails[0]['level'];

$newBal = $bal - $amount;
$topay = null;

if ($status_fetch !== 'disabled') {
  $valu = strtoupper($provider) . ' ' . 'Airtime';
  if ($user_level !== 'paid') {

    $discount = strval(floatval(($per / 100)) * floatval($amount));
    $topay = $amount - $discount;
  } else {
    $discount = strval(floatval(($discount_fetch / 100)) * floatval($amount));
    $topay = $amount - $discount;
  }

  $stmtSmE = $conn->prepare("INSERT INTO transactions(network,serviceid,vcode,phone,ref,refer,amount,newbal,email,status,token,customer,date,servicetype,channel)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  $stmtSmE->bind_Param("sssssssssssssss", $valu, $network, $code_fetch, $phone, $uid, $reference, $amount, $newBal, $UserEmail, $stat, $reference, $customNam, $dat, $network, $channel);

  if ($stmtSmE->execute()) {


    session_start();
    strval($_SESSION['amt'] = floatval(abs($amount)));
    strval($_SESSION['carier'] = $network);
    strval($_SESSION['phone'] = $phone);
    strval($_SESSION['transid'] = $uid);
    strval($_SESSION['descr'] = $valu);
    strval($_SESSION['img'] = $img);
    strval($_SESSION['status'] = $stat);
    strval($_SESSION['discount'] = $discount);

    $resp['msg'] = "Redirecting... please wait";
    $resp['status'] = true;
    $resp['redirect'] = "transaction-view/airtime?" . $uid;
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

  $error[] = "This service is currently unavailable : Please Try again shortly";
  $resp['msg'] = $error;
  $resp['status'] = false;
  echo json_encode($resp);
  exit();
}

function fetchPackage($conn, $network)
{
  $qryPlan = $conn->query("SELECT * FROM airtime_package WHERE network='$network'");
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
