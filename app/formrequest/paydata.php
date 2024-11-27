<?php
date_default_timezone_set('Africa/Lagos');
$dat = date("Y-m-d h:i:s");

$error = array();
$resp = array();
$msg = null;

$token = sanitize_input($_REQUEST['_tok']);
//////////////////////
if (empty($token)) {
  $error[] = "Transaction token is empty";
}


if (count($error) > 0) {
  $resp['status'] = false;
  $resp['msg'] = $error;
  echo json_encode($resp);
  exit();
}

require_once('../db.php');

$trans = json_decode(fetchTrans($conn, $token), true);
$UserEmail = $trans[0]['email'];
$variation = $trans[0]['vcode'];
$network = $trans[0]['serviceid'];
$phone = $trans[0]['phone'];
$requestId = $trans[0]['ref'];

if ($network == '1') {
  $provider = "mtn";
  $img = 'Data-mtn.jpg';
  $networkcode = "1";
  $networkcode2 = "1";
}
if ($network == '3') {
  $provider = "glo";
  $img = 'GLO-Data.jpg';
  $networkcode = "3";
  $networkcode2 = "3";
}
if ($network == '4') {
  $provider = "9mobile";
  $img = '9mobile-Data.jpg';
  $networkcode = "4";
  $networkcode2 = "4";
}
if ($network == '2') {
  $provider = "airtel";
  $img = 'Airtel-Data.jpg';
  $networkcode = "2";
  $networkcode2 = "2";
}


$reference = uniqid();
$stats = "Completed";
$channel = "Wallet";
$failstats = "Failed";

$userDetails = json_decode(fetchUser($conn, $UserEmail), true);
$customNam = $userDetails[0]['firstname'] . ' ' . $userDetails[0]['lastname'];
$current_balance = floatval($userDetails[0]['bal']);
$userPhone = $userDetails[0]['phone'];
$UserIPAddress = $userDetails[0]['IPaddress'];
$varUserId = $userDetails[0]['email'];

$ftrow =  json_decode(fetchPackage($conn, $variation, $network), true);
$network_fetch = $ftrow[0]['network_id'];
$datatype_fetch = $ftrow[0]['plan_type'];
$plan_id = $ftrow[0]['plan_id'];
$plan_fetch = $ftrow[0]['plan_name'];
$code_fetch = $ftrow[0]['plan_code'];
$userprice_fetch = floatval($ftrow[0]['amount']);
// $apiprice_fetch = floatval($ftrow[0]['price_api']);
$gateway_fetch = $ftrow[0]['gateway'];
$user_level = $userDetails[0]['level'];
// if ($user_level !== 'paid') {
//   $amount_value = $userprice_fetch;
// } else {
//   $amount_value = $apiprice_fetch;
// }


switch ($network) {
  case '1':
    $network_code = 1;
    break;

  case '2':
    $network_code = 2;
    break;

  case '3':
    $network_code = 3;
    break;

  case '4':
    $network_code = 4;
    break;

  default:
}


$valu = strtoupper($provider) . ' ' . $plan_fetch;

if (strval($trans[0]['status'] !== 'Completed')) {

  if (floatval($userprice_fetch) <= floatval($current_balance)) {

    $newBalc =  strval(floatval($current_balance) - floatval($userprice_fetch));

    $callb = $_SERVER['SERVER_NAME'];
    $apiMulti = json_decode(Apidefault($conn, $code_fetch));


    switch ($apiMulti->gateway) {
      case 'epins':
        $resultepin = json_decode(epinApi($conn, $network, $phone, $code_fetch, $requestId));
        $apiRespone = $resultepin->code;
        break;

      case 'mobileng':
        $resultmob = json_decode(mobilng($conn, $networkcode, $phone, $code_fetch, $requestId));
        $apiRespone = $resultmob->code;
        break;

      case 'smeplug':
        smeplug($conn, $smeplugnet_id, $code_fetch, $phone);
        break;
      case 'husmodata':
        $resulthusm = json_decode(husmoApi($conn, $networkcode2, $phone, $code_fetch));
        $apiRespone = $resulthusm->Status;
        break;
      case 'gongoz':
        $resultal = json_decode(Alrahuz($conn, $networkcode2, $phone, $code_fetch));
        $apiRespone = $resultal->Status;
        break;

      case 'alrahuz':
        $resultal = json_decode(Alrahuz($conn, $networkcode2, $phone, $code_fetch));
        $apiRespone = $resultal->Status;
        break;

      case 'smartrecharge':
        $resultsmt = json_decode(smartRecharge($conn, $code_fetch, $phone, $callb));
        break;

      case 'zoedatahub':
        $resultZoe =  json_decode(zoeDataHub($conn, $networkcode2, $phone, $code_fetch));
        $apiRespone = $resultZoe->Status;
        break;

      case 'bigsub':
        $json_bigsub =  json_decode(BigSub($conn, $phone, $code_fetch, $network, $dataType));
        $apiRespone = $json_bigsub->success;
        break;

      case 'clubkonnect':
        $resultclub = json_decode(clubAPi($conn, $network, $code_fetch, $phone, $requestId, $callb));
        $apiRespone = $resultclub->status;
        break;

      case 'paytev':
        $paytev_code = Paytev($network, $phone, $code_fetch, $requestId, $datatype_fetch);
        $apiRespone = $paytev_code->status;
        break;
      case 'n3t':
        $resn3t = json_decode(n3t($conn, $network_code, $phone, $plan_id, $requestId));
        $msg = $resn3t->message;
        $apiRespone = $resn3t->status;
        break;

      default:
    }


    if ($apiRespone == '101' or $apiRespone == '201' or $apiRespone === 'true' or $apiRespone === 'successful' or $apiRespone === 'success') {

      UserdebitWallet($conn, $newBalc, $varUserId);

      if (UpdateTransaction($conn, $stats, $reference, $channel, $userprice_fetch, $newBalc, $requestId)) {

        $resp['msg'] = "Transaction Successful";
        $resp['status'] = true;
        $resp['description'] = $valu . ' sent to ' . $phone;
        $resp['redirect'] = "../../data.php";
        echo json_encode($resp);
        exit();
      } else {
        $error[] = "Error processing your request";
        $error[] = $msg;
        $resp['msg'] = $error;
        $resp['status'] = false;
        echo json_encode($resp);
        exit();
      }
    } else {

      UpdateFailedTransaction($conn, $stats, $reference, $channel, $userprice_fetch, $current_balance, $requestId, $failstats);

      $error[] = "Network Error: Please Try again shortly";
      $error[] = $msg;
      $resp['msg'] = $error;
      $resp['status'] = false;
      echo json_encode($resp);
      exit();
    }
  } else {

    $error[] = "Insufficient balance";
    $error[] = $msg;
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();
  }
} else {

  $error[] = "Duplicate Transaction";
  $resp['msg'] = $error;
  $resp['status'] = false;
  echo json_encode($resp);
  exit();
}

function fetchPackage($conn, $variation, $network)
{
  $qryPlan = $conn->query("SELECT * FROM data_packages WHERE plan_code='$variation' AND network_id='$network'");
  while ($prow[] = $qryPlan->fetch_assoc()) {
  }
  return json_encode($prow);
}


function fetchUser($conn, $UserEmail)
{
  $qryUser = $conn->query("SELECT * FROM users 
WHERE email='$UserEmail'");
  while ($row[] = $qryUser->fetch_assoc()) {
  }
  return json_encode($row);
}

function fetchTrans($conn, $token)
{
  $qrytrz = $conn->query("SELECT * FROM transactions WHERE ref='$token'");
  while ($trow[] = $qrytrz->fetch_assoc()) {
  }
  return json_encode($trow);
}

function UserdebitWallet($conn, $newBalc, $varUserId)
{
  $stmtDeb = $conn->prepare("UPDATE users SET bal=? WHERE email=?");
  $stmtDeb->bind_Param("ss", $newBalc, $varUserId);
  $result_debt =   $stmtDeb->execute();
  $stmtDeb->close();
  return $result_debt;
}

function UpdateTransaction($conn, $stats, $reference, $channel, $userprice_fetch, $newBalc, $requestId)
{
  $stmtTrUpd = $conn->prepare("UPDATE transactions SET status=?,token=?,channel=?,charge=?,newBal=? WHERE ref=?");
  $stmtTrUpd->bind_Param("ssssss", $stats, $reference, $channel, $userprice_fetch, $newBalc, $requestId);
  $resTran = $stmtTrUpd->execute();
  return $resTran;
}


function UpdateFailedTransaction($conn, $stats, $reference, $channel, $userprice_fetch, $current_balance, $requestId, $failstats)
{
  $stmtTrfl = $conn->prepare("UPDATE transactions SET status=?,token=?,channel=?,charge=?,newBal=? WHERE ref=?");
  $stmtTrfl->bind_Param("ssssss", $failstats, $reference, $channel, $userprice_fetch, $current_balance, $requestId);
  $FailedresTran = $stmtTrfl->execute();
  return $FailedresTran;
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



function Paytev($network, $phone, $code_fetch, $requestId, $datatype_fetch)
{
  global $conn;
  $query_tev = $conn->query("SELECT * FROM providers_api_key WHERE provider='paytev'");
  $paytevkey = $query_tev->fetch_object();
  $API_TOKEN = $paytevkey->privatekey;

  switch ($network) {
    case '01':
      $network_var = "mtn";
      break;

    case '02':
      $network_var = "glo";
      break;

    case '03':
      $network_var = "9mobile";
      break;

    case '04':
      $network_var = "airtel";
      break;

    default:
  }

  switch ($datatype_fetch) {

    case 'sme':
      $variation_network = $network_var . '_sme_data';
      break;

    case 'gifting':
      $variation_network = $network_var . '_gifting_data';
      break;

    case 'directdata':
      $variation_network = $network_var . '_data';
      break;

    default:
  }

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://client.paytev.com/api/v1/data?format=json&api-token=$API_TOKEN&network=$variation_network&phone=$phone&amount=$code_fetch",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: $API_TOKEN",
      "source-domain: https://dashboard.spacepay.ng"
    ),
  ));

  $PayTevresponse = curl_exec($curl);
  curl_close($curl);
  //file_put_contents('v.txt',$PayTevresponse);
  return json_decode($PayTevresponse);
}



function smartRecharge($conn, $code_fetch, $phone, $callb)
{
  function fetchsmart($conn)
  {
    $query_smart = $conn->query("SELECT * FROM providers_api_key WHERE provider='smartrecharge'");
    $smart_rech = $query_smart->fetch_assoc();
    return json_encode($smart_rech);
  }
  $json_smart = json_decode(fetchsmart($conn));
  $smartKey = $json_smart->privatekey;
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://smartrecharge.ng/api/v2/datashare/?api_key=$smartKey&product_code=$code_fetch&phone=$phone&callback=$callb");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  $resdata = curl_exec($ch);
  //Close the cURL handle.
  curl_close($ch);
  return $resdata;
}

function Alrahuz($conn, $networkcode2, $phone, $code_fetch)
{
  function fetchalr($conn)
  {
    $query_alr = $conn->query("SELECT * FROM providers_api_key WHERE provider='alrahuz'");
    $alrkey = $query_alr->fetch_assoc();
    return json_encode($alrkey);
  }
  $json_alr = json_decode(fetchalr($conn));
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://alrahuzdata.com.ng/api/data/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "network" => $networkcode2,
      "mobile_number" => $phone,
      "plan" => $code_fetch,
      "Ported_number" => true
    )),
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Token " . $json_alr->privatekey
    ),
  ));

  $Alrahuzresponse = curl_exec($curl);
  curl_close($curl);
  return $Alrahuzresponse;
}

function gongoz($conn, $networkcode2, $phone, $code_fetch)
{

  function fetchgoz($conn)
  {
    $query_goz = $conn->query("SELECT * FROM providers_api_key WHERE provider='gongoz'");
    $gozkey = $query_goz->fetch_assoc();
    return json_encode($gozkey);
  }
  $json_goz = json_decode(fetchgoz($conn));

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://www.gongozconcept.com/api/data/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "network" => $networkcode2,
      "mobile_number" => $phone,
      "plan" => $code_fetch,
      "Ported_number" => true
    )),
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Token " . $json_goz->privatekey
    ),
  ));
  $Gongresponse = curl_exec($curl);
  curl_close($curl);
  return $Gongresponse;
}

function husmoApi($conn, $networkcode2, $phone, $code_fetch)
{
  function fetchhusm($conn)
  {
    $query_hus = $conn->query("SELECT * FROM providers_api_key WHERE provider='husmodata'");
    $husmkey = $query_hus->fetch_assoc();
    return json_encode($husmkey);
  }
  $json_hus = json_decode(fetchhusm($conn));
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://husmodataapi.com/api/data/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "network" => $networkcode2,
      "mobile_number" => $phone,
      "plan" => $code_fetch,
      "Ported_number" => true
    )),
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Token " . $json_hus->privatekey
    ),
  ));

  $Husresponse = curl_exec($curl);
  curl_close($curl);
  return $Husresponse;
}

function smeplug($conn, $smeplugnet_id, $code_fetch, $phone)
{
  function fetchsplug($conn)
  {
    $query_splug = $conn->query("SELECT * FROM providers_api_key WHERE provider='smeplug'");
    $splugkey = $query_splug->fetch_assoc();
    return json_encode($splugkey);
  }
  $json_splug = json_decode(fetchsplug($conn));
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://smeplug.ng/api/v1/data/purchase',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
      "network_id" => $smeplugnet_id,
      "plan_id" => $code_fetch,
      "phone" => $phone
    ),
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Bearer " . $json_splug->secretkey
    ),
  ));

  $responsePlg = curl_exec($curl);
  curl_close($curl);
  return $responsePlg;
}

function Apidefault($conn, $code_fetch)
{
  $query_MapiS = $conn->query("SELECT * FROM data_packages WHERE plan_code='$code_fetch'");
  $api_defualt = $query_MapiS->fetch_assoc();
  return json_encode($api_defualt);
}


function epinApi($conn, $network, $phone, $code_fetch, $requestId)
{
  function fetchEpin($conn)
  {
    $query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
    $fetchepkey = $query_ep->fetch_assoc();
    return json_encode($fetchepkey);
  }
  $json_ep = json_decode(fetchEpin($conn));
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/data/?");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $json_ep->privatekey,
    "service" => $network,
    "MobileNumber" => $phone,
    "DataPlan" => $code_fetch,
    "ref" => $requestId
  )));
  $veridata = curl_exec($ch);
  curl_close($ch);
  file_put_contents('resp.txt', $veridata);
  return $veridata;
}

function clubAPi($conn, $network, $code_fetch, $phone, $requestId, $callb)
{

  function fetchclb($conn)
  {
    $query_cl = $conn->query("SELECT * FROM providers_api_key WHERE provider='clubkonnect'");
    $clbkey = $query_cl->fetch_assoc();
    return json_encode($clbkey);
  }
  $json_clb = json_decode(fetchclb($conn));
  $DisKey = $json_clb->privatekey;
  $UserID = $json_clb->secretkey;
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://www.nellobytesystems.com/APIDatabundleV1.asp?UserID=$UserID&APIKey=$DisKey&MobileNetwork=$network&DataPlan=$code_fetch&MobileNumber=$phone&RequestID=$requestId&CallBackURL=$callb ");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  $resdataClub = curl_exec($ch);
  //Close the cURL handle.
  curl_close($ch);
  return   $resdataClub;
}

function mobilng($conn, $mobNet, $phone, $code_fetch, $requestId)
{
  function fetchmobng($conn)
  {
    $query_mob = $conn->query("SELECT * FROM providers_api_key WHERE provider='mobileng'");
    $mobkey = $query_mob->fetch_assoc();
    return json_encode($mobkey);
  }
  $json_mob = json_decode(fetchmobng($conn));
  $mobilekey = $json_mob->privatekey;
  $mobileID = $json_mob->secretkey;
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://mobileairtimeng.com/httpapi/datashare?userid=$mobileID&pass=$mobilekey&network=$mobNet&phone=$phone&datasize=$code_fetch&jsn=json&user_ref=$requestId");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  $resdataMobN = curl_exec($ch);
  //Close the cURL handle.
  curl_close($ch);
  return $resdataMobN;
}

function MarkersApi($conn, $network, $phone, $code_fetch, $requestId)
{
  function fetchMarkers($conn)
  {
    $query_maks = $conn->query("SELECT * FROM providers_api_key WHERE provider='markersapi'");
    $fetchmakey = $query_maks->fetch_assoc();
    return json_encode($fetchmakey);
  }
  $json_maks = json_decode(fetchMarkers($conn));
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://markersapi.com.ng/api/data/?");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $json_maks->privatekey,
    "service" => $network,
    "MobileNumber" => $phone,
    "DataPlan" => $code_fetch,
    "ref" => $requestId
  )));
  $veridata_maks = curl_exec($ch);
  curl_close($ch);
  //file_put_contents('resp.txt',$veridata_maks);
  return $veridata_maks;
}


function zoeDataHub($conn, $networkcode2, $phone, $code_fetch)
{
  function zoekey($conn)
  {
    $query_zoe = $conn->query("SELECT * FROM providers_api_key WHERE provider='zoedatahub'");
    $zoekey = $query_zoe->fetch_assoc();
    return json_encode($zoekey);
  }
  $json_zoe = json_decode(zoekey($conn));
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://zoedatahub.com/api/data/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "network" => strval(intval($networkcode2)),
      "mobile_number" => $phone,
      "plan" => $code_fetch,
      "Ported_number" => true
    )),
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Token " . $json_zoe->privatekey
    ),
  ));

  $Zoeresponse = curl_exec($curl);
  curl_close($curl);
  return $Zoeresponse;
}

function BigSub($conn, $phone, $code_fetch, $network, $dataType)
{
  function fetchbigSubkey($conn)
  {
    $query_bsub = $conn->query("SELECT * FROM providers_api_key WHERE provider='bigsub'");
    $bgsubkey = $query_bsub->fetch_assoc();
    return json_encode($bgsubkey);
  }
  $json_bsub = json_decode(fetchbigSubkey($conn));
  $basic_key = base64_encode($json_bsub->privatekey . '' . $json_bsub->secretkey);
  //Network Variations
  if ($network == '01' && $dataType == 'sme') {
    $bgvar = 1;
  }
  if ($network == '01' && $dataType == 'gifting') {
    $bgvar = 2;
  }
  if ($network == '02' && $dataType == 'gifting') {
    $bgvar = 4;
  }
  if ($network == '03' && $dataType == 'gifting') {
    $bgvar = 5;
  }
  if ($network == '03' && $dataType == 'sme') {
    $bgvar = 6;
  }
  if ($network == '04' && $dataType == 'sme') {
    $bgvar = 3;
  }
  if ($network == '04' && $dataType == 'gifting') {
    $bgvar = 9;
  }
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://bigsub.com.ng/api/data.php?number=$phone&network=$bgvar&id=$code_fetch");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Authorization: Basic $basic_key"
  ));
  $BigSubResponse = curl_exec($ch);
  curl_close($ch);
  //file_put_contents('airtime.txt',$BigSubResponse);
  return  $BigSubResponse;
}

function n3t($conn, $network, $phone, $data_plan, $requestId)
{
  function fetchn3t($conn)
  {
    $query_n3t = $conn->query("SELECT * FROM providers_api_key WHERE provider='n3tdata'");
    $n3tkey = $query_n3t->fetch_assoc();
    return json_encode($n3tkey);
  }
  $json_n3t = json_decode(fetchn3t($conn));
  $basic = base64_encode($json_n3t->username . ':' . $json_n3t->password);
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, "https://n3tdata.com/api/user");
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt(
    $curl,
    CURLOPT_HTTPHEADER,
    [
      "Authorization: Basic " . $basic,
    ]
  );
  $N3Tresponse = curl_exec($curl);
  $n3result = json_decode($N3Tresponse);
  curl_close($curl);
  $n3_accesscode = $n3result->AccessToken;

  //Initialize cURL.
  $paypload = array(
    'network' => $network,
    'phone' => $phone,
    'data_plan' => $data_plan,
    'bypass' => false,
    'request-id' => $requestId
  );
  $basic = base64_encode($json_n3t->username . ":" . $json_n3t->password);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://n3tdata.com/api/data');
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paypload));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $headers = [
    "Authorization: Token $n3_accesscode",
    'Content-Type: application/json'
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $response = curl_exec($ch);
  curl_close($ch);
  // file_put_contents('resp.txt', $response);
  return $response;
}
