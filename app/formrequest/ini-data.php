<?php
date_default_timezone_set('Africa/Lagos');
$dat = date("Y-m-d h:i:s");

$error = array();
$resp = array();
$discount = 0;

$network = sanitize_input($_REQUEST['network']);
$plan = sanitize_input($_REQUEST['plan']);
$phone = sanitize_input(preg_replace("/[^0-9]/", '', $_REQUEST['phone']));
$token = sanitize_input(base64_decode($_REQUEST['token']));
//////////////////////
if (empty($network)) {
  $error[] = "Select Network";
}

if (empty($plan)) {
  $error[] = "Select Data plan";
}

if (empty($phone)) {
  $error[] = "Enter Destination phone number";
}


if (count($error) > 0) {
  $resp['status'] = false;
  $resp['msg'] = $error;
  echo json_encode($resp);
  exit();
}

require_once('../db.php');

if ($network == '1') {
  $provider = "mtn";
  $img = 'Data-mtn.jpg';
}
if ($network == '3') {
  $provider = "glo";
  $img = 'GLO-Data.jpg';
}
if ($network == '4') {
  $provider = "9mobile";
  $img = '9mobile-Data.jpg';
}
if ($network == '2') {
  $provider = "airtel";
  $img = 'Airtel-Data.jpg';
}

$uid = substr(str_shuffle("0123456789678901"), 0, 16);
$reference = uniqid();
$stat = "pending";

$userDetails = json_decode(fetchUser($conn, $token), true);
$UserEmail = $userDetails[0]['email'];
$customNam = $userDetails[0]['firstname'] . ' ' . $userDetails[0]['lastname'];
$ftrow =  json_decode(fetchPackage($conn, $plan), true);
$network_fetch = $ftrow[0]['network_id'];
$datatype_fetch = $ftrow[0]['plan_type'];
$plan_fetch = $ftrow[0]['plan_name'];
$code_fetch = $ftrow[0]['plan_code'];
$amount_value = floatval($ftrow[0]['amount']);
// $userprice_fetch = floatval($ftrow[0]['price_user']);
// $apiprice_fetch = floatval($ftrow[0]['price_api']);
$gateway_fetch = $ftrow[0]['gateway'];
$status_fetch = $ftrow[0]['status'];
$user_level = $userDetails[0]['level'];
// if ($user_level !== 'paid') {
//   $amount_value = $userprice_fetch;
// } else {
//   $amount_value = $apiprice_fetch;
//   $discount = strval(floatval($userprice_fetch) - floatval($apiprice_fetch));
// }

if ($status_fetch !== 'disabled') {
  $valu = strtoupper($provider) . ' ' . $plan_fetch;

  $stmtSmE = $conn->prepare("INSERT INTO transactions(network,serviceid,vcode,phone,ref,refer,amount,email,status,token,customer,date)VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
  $stmtSmE->bind_Param("ssssssssssss", $valu, $network, $code_fetch, $phone, $uid, $reference, $amount_value, $UserEmail, $stat, $reference, $customNam, $dat);

  if ($stmtSmE->execute()) {

    session_start();
    strval($_SESSION['amt'] = floatval(abs($amount_value)));
    strval($_SESSION['carier'] = $network);
    strval($_SESSION['phone'] = $phone);
    strval($_SESSION['transid'] = $uid);
    strval($_SESSION['plan'] = $plan_fetch);
    strval($_SESSION['variation_code'] = $plan_fetch);
    strval($_SESSION['descr'] = $valu);
    strval($_SESSION['img'] = $img);
    strval($_SESSION['status'] = $stat);
    strval($_SESSION['discount'] = $discount);
    strval($_SESSION['unit'] = $amount_value);
    $resp['msg'] = "Redirecting... please wait";
    $resp['status'] = true;
    $resp['redirect'] = "transaction-view/data?" . $uid;
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
  $qryPlan = $conn->query("SELECT * FROM data_packages WHERE plan_id='$plan'");
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
