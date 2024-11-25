<?php
$error = array();
$resp = array();

$id = sanitize_input($_REQUEST['id']);
$UserEmail = sanitize_input(base64_decode($_REQUEST['token']));
$iuc = sanitize_input($_REQUEST['iuc']);
if (empty($id)) {
  $error[] = "Id is empty";
}
require_once('../db.php');
$packInfo = json_decode(fetchPackage($conn, $id), true);

$price = floatval($packInfo[0]['amount']);
$network = $packInfo[0]['network'];
$gateway = $packInfo[0]['gateway'];

switch ($gateway) {
  case 'paytev':
    $result = paytev($network, $iuc);
    $customerName = $result->customer_name;
    $smart_no = $result->smart_no;
    $customer_number = $result->customer_number;
    $invoice = $result->invoice;
    $service = $result->service;
    break;

  case 'n3t':
    $result = n3tVerifyIUC($iuc, $network);
    $customerName = $result->name;
    $smart_no = $iuc;
    $customer_number = "";
    $invoice = "";
    $service = $network;
    break;

  case 'epins':
    $result = json_decode(verify($conn, $network, $iuc));
    $customerName = $result->description->Customer;
    $smart_no = $iuc;
    $customer_number = "";
    $invoice = "";
    $service = $network;

    break;

  default:
    $result = json_decode(verify($conn, $network, $iuc));
    $customerName = $result->description->Customer;
    $smart_no = $iuc;
    $customer_number = "";
    $invoice = "";
    $service = $network;
}


switch ($network) {
  case 'gotv':
    $decoderNo = "IUC";
    break;

  case 'dstv':
    $decoderNo = "Smartcard";
    break;

  case 'startimes':
    $decoderNo = "Smartcard";
    break;
  default:
}

//file_put_contents('resp.txt',$id.$UserEmail.$price.'/'.$iuc.'/'.$network);
if (is_null($customerName)) {

  $error[] = "Unable to verify $decoderNo Number";
  $resp['msg'] = $error;
  $resp['status'] = false;
  echo json_encode($resp);
  exit();
} else {

  session_start();
  //file_put_contents('v.txt',$id.$UserEmail.$price);
  $_SESSION['customer'] = $customerName;
  $_SESSION['customer_number'] = $customer_number;
  $_SESSION['invoice'] = $invoice;


  $resp['status'] = true;
  $resp['msg'] = '<font color="green">Success: </font> ';
  $resp['name'] = $customerName;
  $resp['banquet'] = $result->description->Current_Bouquet;
  $resp['due'] = $result->description->Due_Date;
  echo json_encode($resp);
  exit();
}

function fetchPackage($conn, $id)
{
  $query = $conn->query("SELECT * FROM tv_package WHERE serial='$id'");
  while ($row[] = $query->fetch_assoc()) {
  }
  return json_encode($row);
}


function paytev($network, $iuc)
{
  global $conn;
  // get Key
  $queryTev = $conn->query("SELECT * FROM providers_api_key WHERE provider='paytev'");
  $tevkey = $queryTev->fetch_object();
  $API_TOKEN = $tevkey->privatekey;
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://client.paytev.com/api/v1/check-cable-customer?format=json&smart_no=$iuc&service=$network");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

  $respTev = curl_exec($ch);
  $resultev = json_decode($respTev);

  //Close the cURL handle.
  curl_close($ch);
  return  $resultev;
}

function n3tVerifyIUC($iuc, $cable)
{
  global $conn;
  // get Key
  $queryTev = $conn->query("SELECT * FROM providers_api_key WHERE provider='n3tdata'");
  $tevkey = $queryTev->fetch_object();
  $API_TOKEN = $tevkey->privatekey;
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://n3tdata.com/api/cable/cable-validation?iuc=$iuc&cable=$cable");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

  $respTev = curl_exec($ch);
  $resn3t = json_decode($respTev);

  //Close the cURL handle.
  curl_close($ch);
  return  $resn3t;
}


function verify($conn, $network, $iuc)
{
  function urlbasemain()
  {
    //Initialize cURL.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/base?url=main");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $basedata = curl_exec($ch);
    $result = json_decode($basedata, true);
    //Close the cURL handle.
    curl_close($ch);
    return $result['description'][0]['main'];
  }
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, urlbasemain() . "/" . "merchantvalidate/?");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "service" => $network,
    "smartNo" => $iuc,
    "type" => $network
  )));
  $veridata = curl_exec($ch);
  curl_close($ch);
  file_put_contents('v.txt', $veridata);
  return $veridata;
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
