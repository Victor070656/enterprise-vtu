<?php
date_default_timezone_set('Africa/Lagos');
$dat = date("Y-m-d h:i:s");

$error = array();
$resp = array();

$network = sanitize_input($_REQUEST['network']);
$plan = sanitize_input($_REQUEST['plan']);
$phone = sanitize_input(preg_replace("/[^0-9]/", '', $_REQUEST['iuc']));
$token = sanitize_input(base64_decode($_REQUEST['token']));
//////////////////////
if (empty($network)) {
  $error[] = "Select Decoder type";
}

if (empty($plan)) {
  $error[] = "Select $network plan";
}

if (empty($phone)) {
  $error[] = "Enter IUC/Smartcard number";
}


if (count($error) > 0) {
  $resp['status'] = false;
  $resp['msg'] = $error;
  echo json_encode($resp);
  exit();
}

require_once('../db.php');

if ($network == 'gotv') {
  $provider = "gotv";
  $img = 'Gotv-Payment.jpg';
}
if ($network == 'dstv') {
  $provider = "dstv";
  $img = 'Pay-DSTV-Subscription.jpg';
}
if ($network == 'startimes') {
  $provider = "startimes";
  $img = 'Startimes-Subscription.jpg';
}


$uid = substr(str_shuffle("0123456789678901"), 0, 16);
$reference = uniqid();
$stat = "pending";

$userDetails = json_decode(fetchUser($conn, $token), true);
$UserEmail = $userDetails[0]['email'];
$customNam = $userDetails[0]['firstname'] . ' ' . $userDetails[0]['lastname'];
$user_account_type = $userDetails[0]['level'];
$ftrow =  json_decode(fetchPackage($conn, $plan), true);
$network_fetch = $ftrow[0]['network'];
$plan_fetch = $ftrow[0]['plan'];
$code_fetch = $ftrow[0]['plancode'];
$userprice_fetch = floatval($ftrow[0]['amount']);
$gateway_fetch = $ftrow[0]['gateway'];
$status_fetch = $ftrow[0]['status'];

if ($status_fetch !== 'disabled') {
  $valu = $plan_fetch;

  $chl = $conn->query("SELECT * FROM charges");
  while ($sc = $chl->fetch_assoc()) {
    $ch_name = $sc['service'];
    $arry[$ch_name] = array(
      $ch_name[0] => $sc['user'],
      $ch_name[1] => $sc['api']
    );
  }
  foreach ($arry as $ai => $jz) {
    foreach ($jz as $wz) {
      $s_charge[$ai][] = $wz;
    }
  }

  switch ($user_account_type) {

    case 'free':
      $per = $s_charge['gotv'][0];
      break;

    case 'paid':
      $per =  $s_charge['gotv'][1];
      break;
  }

  $discount = ($per / 100) * $userprice_fetch;
  $totalPayable = strval(floatval($userprice_fetch) - $discount);
  $stmtSmE = $conn->prepare("INSERT INTO transactions(network,serviceid,vcode,phone,ref,refer,amount,email,status,token,customer,date)VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
  $stmtSmE->bind_Param("ssssssdsssss", $valu, $network, $code_fetch, $phone, $uid, $reference, $userprice_fetch, $UserEmail, $stat, $reference, $customNam, $dat);

  if ($stmtSmE->execute()) {
    session_start();
    strval($_SESSION['amt'] = floatval(abs($userprice_fetch)));
    strval($_SESSION['carier'] = $network);
    strval($_SESSION['phone'] = $phone);
    strval($_SESSION['transid'] = $uid);
    strval($_SESSION['plan'] = $plan_fetch);
    strval($_SESSION['variation_code'] = $plan_fetch);
    strval($_SESSION['descr'] = $valu);
    strval($_SESSION['img'] = $img);
    strval($_SESSION['status'] = $stat);
    strval($_SESSION['discount'] = $discount);
    strval($_SESSION['topay'] = $totalPayable);
    $resp['msg'] = "Redirecting... please wait";
    $resp['status'] = true;
    $resp['redirect'] = "transaction-view/tv?" . $uid;

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

function fetchPackage($conn, $plan)
{
  $qryPlan = $conn->query("SELECT * FROM tv_package WHERE serial='$plan'");
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
