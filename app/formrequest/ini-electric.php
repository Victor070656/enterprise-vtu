<?php
date_default_timezone_set('Africa/Lagos');
header('Content-Type: application/json');

$dat = date("Y-m-d h:i:s");

$error = array();
$resp = array();

$id = sanitize_input($_REQUEST['id']);
$plan = sanitize_input($_REQUEST['metertype']);
$meterno = sanitize_input(preg_replace("/[^0-9]/", '', $_REQUEST['meterno']));
$token = sanitize_input(base64_decode($_REQUEST['token']));
$amount = sanitize_input(preg_replace("/[^0-9]/", '', floatval($_REQUEST['amount'])));
////////////////////// 
if (empty($id)) {
  $error[] = "Select Disco type";
}

if (empty($plan)) {
  $error[] = "Select meter type";
}

if (empty($meterno)) {
  $error[] = "Enter meter number";
}


if (count($error) > 0) {
  $resp['status'] = false;
  $resp['msg'] = $error;
  echo json_encode($resp);
  exit();
}

require_once('../db.php');
session_start();
$userDetails = json_decode(fetchUser($conn, $token), true);
$UserEmail = $userDetails[0]['email'];
$UserBal = $userDetails[0]['bal'];
$customNam = $userDetails[0]['firstname'] . ' ' . $userDetails[0]['lastname'];
$user_account_type = $userDetails[0]['level'];

$ftrow =  json_decode(fetchPackage($conn, $id), true);
$network = $ftrow[0]['network'];
$plan_fetch = $ftrow[0]['plan'];
$gateway_fetch = $ftrow[0]['gateway'];
$status_fetch = $ftrow[0]['status'];
$plan_discount = $ftrow[0]['discount'];

if ($status_fetch !== 'disabled') {

  if ($network === 'abuja') {
    $img = 'Abuja-Electric.jpg';
  }
  if ($network === 'enugu') {
    $img = 'EEDC-Enugu-electricity-payment.jpg';
  }
  if ($network === 'ikeja') {
    $img = 'ikeja.png';
  }
  if ($network === 'eko') {
    $img = 'Eko-Electric-Payment-PHCN.jpg';
  }
  if ($network === 'ibadan') {
    $img = 'IBEDC-Ibadan-Electricity-Distribution-Company.jpg';
  }
  if ($network === 'benin') {
    $img = 'bedc.jpg';
  }
  if ($network === 'jos') {
    $img = 'Jos-Electric-JED.jpg';
  }
  if ($network === 'kano') {
    $img = 'Kano-Electricity-Distribution-Company-KEDCO-logo.png';
  }
  if ($network === 'kaduna') {
    $img = 'kaduna.jpg';
  }
  if ($network === 'yola') {
    $img = 'yola.jpg';
  }
  if ($network === 'portharcourt') {
    $img = 'phc.png';
  }

  $serviceID = $network . '-electric';
  $uid = substr(str_shuffle("0123456789678901"), 0, 16);
  $reference = uniqid();
  $stat = "pending";

  $valu = $plan_fetch . ' (' . $plan . ')';


  switch ($user_account_type) {

    case 'free':
      $per = 0;
      break;

    case 'paid':
      $per =  $plan_discount;
      break;
  }


  $discount = ($per / 100) * $amount;
  $totalPayable = strval(floatval($amount) - $discount);
  $target_customer = strval($_SESSION['customer']);
  $newbal = $UserBal - $totalPayable;

  if ($newbal < 0) {
    $error[] = "Insufficient Balance : Please Topup your balance and Try again";
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();
  } else {
    $stmtSmE = $conn->prepare("INSERT INTO transactions(network,serviceid,vcode,phone,ref,refer,amount,charge,newBal,email,status,token,customer,date,customer_name,meterno)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmtSmE->bind_Param("ssssssdddsssssss", $valu, $serviceID, $plan, $meterno, $uid, $reference, $amount, $totalPayable, $newbal, $UserEmail, $stat, $reference, $customNam, $dat, $target_customer, $meterno);

    if ($stmtSmE->execute()) {

      $_SESSION['amt'] = floatval(abs($amount));
      $_SESSION['carier'] = $serviceID;
      $_SESSION['phone'] = $meterno;
      $_SESSION['transid'] = $uid;
      $_SESSION['plan'] = $plan;
      $_SESSION['variation_code'] = $plan;
      $_SESSION['descr'] = $valu;
      $_SESSION['img'] = $img;
      $_SESSION['status'] = $stat;
      $_SESSION['discount'] = $discount;
      $_SESSION['topay'] = $totalPayable;

      $resp['msg'] = "Redirecting... please wait";
      $resp['status'] = true;
      $resp['redirect'] = "transaction-view/electric?trans=" . $uid;
      echo json_encode($resp);
      exit();
    } else {
      $error[] = "Error processing your request";
      $resp['msg'] = $error;
      $resp['status'] = false;
      echo json_encode($resp);
      exit();
    }
  }
} else {

  $error[] = "This service is currently unavailable : Please Try again shortly";
  $resp['msg'] = $error;
  $resp['status'] = false;
  echo json_encode($resp);
  exit();
}



function fetchPackage($conn, $id)
{
  $qryPlan = $conn->query("SELECT * FROM electric_package WHERE serial='$id'");
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
