<?php
$error = array();
$resp = array();
$customerName = null;

$id = sanitize_input($_REQUEST['id']);
$UserEmail = sanitize_input(base64_decode($_REQUEST['token']));
$meterno = sanitize_input($_REQUEST['meterno']);
$metertype = sanitize_input($_REQUEST['metertype']);
if (empty($id)) {
  $error[] = "Id is empty";
}
require_once('../db.php');
$packInfo = json_decode(fetchPackage($conn, $id), true);

// $price = $packInfo[0]['amount'];
$network = $packInfo[0]['network'];
$gateway = $packInfo[0]['gateway'];

switch ($gateway) {
  case 'paytev':
    $result = paytev($network, $meterno, $metertype);
    $customerName = $result->customer_name;
    break;
  case 'epins':
    $result = json_decode(verify($conn, $apikey, $network, $meterno, $metertype));
    $customerName = $result->description->Customer;
    break;
  case 'n3t':
    if ($network === 'abuja') {
      $disco = 8;
    }
    if ($network === 'enugu') {
      $disco = 10;
    }
    if ($network === 'ikeja') {
      $disco = 1;
    }
    if ($network === 'eko') {
      $disco = 2;
    }
    if ($network === 'ibadan') {
      $disco = 6;
    }
    if ($network === 'benin') {
      $disco = 9;
    }
    if ($network === 'jos') {
      $disco = 5;
    }
    if ($network === 'kano') {
      $disco = 3;
    }
    if ($network === 'kaduna') {
      $disco = 7;
    }
    if ($network === 'yola') {
      $disco = null;
    }
    if ($network === 'portharcourt') {
      $disco = 4;
    }

    $result = n3tverifymeter($disco, $meterno, $metertype);
    if (!empty($result->name)) {

      $customerName = $result->name;
    }
    break;

  default:
    $result = json_decode(verify($conn, $apikey, $network, $meterno, $metertype));
    $customerName = $result->description->Customer;
}



//file_put_contents('resp.txt',$id.$UserEmail.$price.'/'.$meterno.'/'.$network.'/'.$metertype);
if (is_null($customerName)) {

  $error[] = "Unable to verify Meter Number";
  $resp['msg'] = $error;
  $resp['status'] = false;
  echo json_encode($resp);
  exit();
} else {

  session_start();
  // $_SESSION['customer'] = $customerName;
  // $_SESSION['Address'] = $result->description->Address;
  $resp['status'] = true;
  $resp['msg'] = '<font color="green">Success: </font> ';
  $resp['name'] = $result->name;
  // $resp['address'] = $result->description->Address;
  // $resp['due'] = $result->description->Due_Date;
  echo json_encode($resp);
  exit();
}

function fetchPackage($conn, $id)
{
  $query = $conn->query("SELECT * FROM electric_package WHERE serial='$id'");
  while ($row[] = $query->fetch_assoc()) {
  }
  return json_encode($row);
}


function paytev($network, $meterno, $metertype)
{
  global $conn;
  // get Key
  $queryTev = $conn->query("SELECT * FROM providers_api_key WHERE provider='paytev'");
  $tevkey = $queryTev->fetch_object();
  $API_TOKEN = $tevkey->privatekey;
  $disco_var_name = $network . '_' . $metertype . '_Electricity';
  $meter_type_var = $network . '_' . $metertype;
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://client.paytev.com/api/v1/electricityCheck?format=json&service=$disco_var_name&meterNo=$meterno&code=$meter_type_var");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

  $respTev = curl_exec($ch);
  $resultev = json_decode($respTev);

  //Close the cURL handle.
  curl_close($ch);
  return  $resultev;
}

function n3tverifymeter($network, $meterno, $metertype)
{
  // global $conn;
  // // get Key
  // $queryTev = $conn->query("SELECT * FROM providers_api_key WHERE provider='n3tdata'");
  // $tevkey = $queryTev->fetch_object();
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://n3tdata.com/api/bill/bill-validation?meter_number=$meterno&disco=$network&meter_type=$metertype");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

  $respTev = curl_exec($ch);
  $resultev = json_decode($respTev);

  //Close the cURL handle.
  curl_close($ch);
  return  $resultev;
}

function verify($conn, $apikey, $network, $meterno, $metertype)
{
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, urlbasemain() . "/" . "merchantvalidate/?");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "service" => $network . '-' . 'electric',
    "smartNo" => $meterno,
    "type" => $metertype
  )));
  $veridata = curl_exec($ch);
  curl_close($ch);
  //file_put_contents('v.txt',$veridata);
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
