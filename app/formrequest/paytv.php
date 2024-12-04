<?php
date_default_timezone_set('Africa/Lagos');
$dat = date("Y-m-d h:i:s");
$per = 0;
$msg = "";

$error = array();
$resp = array();

$token = sanitize_input($_REQUEST['_tok']);
$cable_id = sanitize_input($_REQUEST['cable_id']);
$plan_id = sanitize_input($_REQUEST['plan_id']);
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
$smartNo = $trans[0]['phone'];

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
$phoneNumber = $userDetails[0]['phone'];
$user_account_type = $userDetails[0]['acctype'];

$ftrow =  json_decode(fetchPackage($conn, $plan_id), true);
$network_fetch = $ftrow[0]['cable'];
$network_id = $ftrow[0]['cable_id'];
$plan_fetch = $ftrow[0]['plan_name'];
$planid = $ftrow[0]['plan_id'];
$code_fetch = $ftrow[0]['plan_code'];
$userprice_fetch = floatval($ftrow[0]['amount']);
$gateway_fetch = $ftrow[0]['gateway'];

// fetch discount 
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
    $per = $s_charge[$provider][0];
    break;

  case 'paid':
    $per =  $s_charge[$provider][1];
    break;
}

$discount = ($per / 100) * $userprice_fetch;
$totalPayable = strval(floatval($userprice_fetch) - $discount);
// discount end  

$valu = strtoupper($provider) . ' ' . $plan_fetch;

if (strval($trans[0]['status'] !== 'Completed')) {

  if (floatval($totalPayable) <= floatval($current_balance)) {

    $newBalc =  strval(floatval($current_balance) - floatval($totalPayable));
    session_start();
    $decoder_userName = $_SESSION['customer'];
    $customer_number = $_SESSION['customer_number'];
    $invoice = $_SESSION['invoice'];

    $callb = $_SERVER['SERVER_NAME'];

    switch ($gateway_fetch) {

      case 'epins':
        $resultepin = json_decode(epinApi($conn, $network, $phone, $code_fetch, $requestId));
        $apiRespone = $resultepin->code;
        break;

      case 'clubkonnect':
        $resultclub = json_decode(clubAPi($conn, $network, $code_fetch, $phone, $requestId, $callb));
        $apiRespone = $resultclub->statuscode;

        break;

      case 'shago':

        $resultShago = json_decode(shagoPay($conn, $plan_fetch, $decoder_userName, $code_fetch, $phone, $userprice_fetch, $network, $requestId));
        $apiRespone = $resultShago->status;
        break;

      case 'vtpass':

        $resultvtpass = json_decode(vtpass($conn, $network, $phone, $code_fetch, $requestId, $userprice_fetch));
        $apiRespone = $resultvtpass->code;
        break;

      case 'husmodata':
        $resulthusm = json_decode(husmoApi($conn, $networkcode, $phone, $code_fetch));
        $apiRespone = $resulthusm->Status;
        break;

      case 'paytev':
        $paytev_code = Paytev($plan_fetch, $decoder_userName, $customer_number, $code_fetch, $phone, $userprice_fetch, $network, $requestId, $invoice);
        $apiRespone = $paytev_code->status;
        break;

      case 'n3t':
        $payn3t = json_decode(n3t($conn, $cable_id, $phone, $plan_id, $requestId));
        $apiRespone = $payn3t->status;
        $msg = $payn3t->message;
        break;

      default:
    }





    if ($apiRespone == '101' or $apiRespone == '201' or $apiRespone === '000' or $apiRespone == '200' or $apiRespone === 'true' or $apiRespone === 'successful' or $apiRespone === 'success') {

      UserdebitWallet($conn, $newBalc, $varUserId);

      if (UpdateTransaction($conn, $stats, $reference, $channel, $userprice_fetch, $newBalc, $requestId)) {

        $resp['msg'] = "Transaction Successful";
        $resp['status'] = true;
        $resp['description'] = $valu . ' sent to ' . $phone;
        $resp['redirect'] = "../../paytv.php";
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

function fetchPackage($conn, $variation)
{
  $qryPlan = $conn->query("SELECT * FROM tv_packages WHERE plan_id='$variation'");
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
  $result =   $stmtDeb->execute();
  $stmtDeb->close();
  return $result;
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


function Paytev($smartNo, $decoder_userName, $customer_number, $code_fetch, $phone, $userprice_fetch, $network, $requestId, $invoice)
{
  global $conn;
  $query_tev = $conn->query("SELECT * FROM providers_api_key WHERE provider='paytev'");
  $paytevkey = $query_tev->fetch_object();
  $API_TOKEN = $paytevkey->privatekey;
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://client.paytev.com/api/api/v1/cable?format=json&smart_no=$smartNo&service=$network&phone=$phone&customer_name=$decoder_userName&customer_number=$customer_number&invoice=$invoice&plan_code=$code_fetch",
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



function shagoPay($conn, $plan_fetch, $decoder_userName, $code_fetch, $phone, $userprice_fetch, $network, $requestId)
{
  function fetchshago($conn)
  {
    $query_sh = $conn->query("SELECT * FROM providers_api_key WHERE provider='shago'");
    $shagokey = $query_sh->fetch_assoc();
    return json_encode($shagokey);
  }
  $json_shago = json_decode(fetchshago($conn));
  $hashkey = $json_shago->privatekey;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    'serviceCode' => 'GDB',
    'smartCardNo' => $phone,
    'customerName' => $decoder_userName,
    'type' => strtoupper($network),
    'amount'  => $userprice_fetch,
    'packagename'  => $plan_fetch,
    'productsCode' => $code_fetch,
    'period' => 1,
    'hasAddon' => 0,
    'request_id' => $requestId

  )));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "hashKey: $hashkey"
  ));

  $isuccess = curl_exec($ch);
  curl_close($ch);
  //file_put_contents('res.txt',$isuccess.'/'.$userprice_fetch);
  return $isuccess;
}

function vtpass($conn, $network, $phone, $code_fetch, $requestId, $userprice_fetch)
{

  function fetchVtp($conn)
  {
    $query_vtp = $conn->query("SELECT * FROM providers_api_key WHERE provider='vtpass'");
    $vtpkey = $query_vtp->fetch_assoc();
    return json_encode($vtpkey);
  }
  $json_vt = json_decode(fetchVtp($conn));

  $curl       = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://vtpass.com/api/pay',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_USERPWD => $json_vt->privatekey . ":" . $json_vt->secretkey,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_POSTFIELDS => array(
      'request_id' => $requestId,
      'serviceID' => $network, //integer e.g gotv,dstv,eko-electric,abuja-electric
      'billersCode' => $phone, // e.g smartcardNumber, meterNumber,
      'variation_code' => $code_fetch, // e.g dstv1, dstv2,prepaid,(optional for somes services)
      'amount' =>  $userprice_fetch, // integer (optional for somes services)
      'phone' => $phone //integer
    ),
  ));
  $success_vtp = curl_exec($curl);
  $curl_errno = curl_errno($curl);
  curl_close($curl);
  return $success_vtp;
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

function smartRecharge($conn, $code_fetch, $phone)
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
  curl_setopt($ch, CURLOPT_URL, "https://smartrecharge.ng/api/v2/tv/?api_key=$smartKey&product_code=$code_fetch&smartcard_number=$phone");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  $resdata = curl_exec($ch);
  //Close the cURL handle.
  curl_close($ch);
  return $resdata;
}

function Alrahuz($conn, $networkcode, $phone, $code_fetch)
{
  function fetchalr($conn)
  {
    $query_alr = $conn->query("SELECT * FROM providers_api_key WHERE provider='alrahuz'");
    $alrkey = $query_alr->fetch_assoc();
    return json_encode($alrkey);
  }
  $json_alr = json_decode(fetchalr($conn));
  $alrahuzkey = $json_alr->privatekey;
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://alrahuzdata.com.ng/api/cablesub/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "cablename" => $networkcode,
      "cableplan" => $code_fetch,
      "cableplan" => $phone
    )),
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Token $alrahuzkey"
    ),
  ));

  $Alrahuzresponse = curl_exec($curl);
  curl_close($curl);
  return $Alrahuzresponse;
}

function gongoz($conn, $networkcode, $phone, $code_fetch)
{

  function fetchgoz($conn)
  {
    $query_goz = $conn->query("SELECT * FROM providers_api_key WHERE provider='gongoz'");
    $gozkey = $query_goz->fetch_assoc();
    return json_encode($gozkey);
  }
  $json_goz = json_decode(fetchgoz($conn));
  $gongokey = $json_goz->privatekey;
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://www.gongozconcept.com/api/cablesub/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "cablename" => $networkcode,
      "cableplan" => $code_fetch,
      "cableplan" => $phone
    )),
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Token $gongokey"
    ),
  ));
  $Gongresponse = curl_exec($curl);
  curl_close($curl);
  return $Gongresponse;
}

function husmoApi($conn, $networkcode, $phone, $code_fetch)
{
  function fetchhusm($conn)
  {
    $query_hus = $conn->query("SELECT * FROM providers_api_key WHERE provider='husmodata'");
    $husmkey = $query_hus->fetch_assoc();
    return json_encode($husmkey);
  }
  $json_hus = json_decode(fetchhusm($conn));
  $husmokey = $json_hus->privatekey;
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://husmodataapi.com/api/cablesub/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "cablename" => $networkcode,
      "cableplan" => $code_fetch,
      "cableplan" => $phone
    )),
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Token $husmokey"
    ),
  ));

  $Husresponse = curl_exec($curl);
  curl_close($curl);
  return $Husresponse;
}


function epinApi($conn, $network, $phone, $code_fetch, $requestId, $userprice_fetch)
{
  function fetchEpin($conn)
  {
    $query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
    $fetchepkey = $query_ep->fetch_assoc();
    return json_encode($fetchepkey);
  }
  $json_ep = json_decode(fetchEpin($conn));
  $apikey = $json_ep->privatekey;
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, urlbasemain() . "/" . "biller/?");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $apikey,
    "service" => $network,
    "accountno" => $phone,
    "vcode" => $code_fetch,
    "amount" => $userprice_fetch,
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
  curl_setopt($ch, CURLOPT_URL, "https://www.nellobytesystems.com/APICableTVV1.asp?UserID=$UserID&APIKey=$DisKey&CableTV=$network&Package=$code_fetch&SmartCardNo=$phone&PhoneNo=$phone&CallBackURL=$callb");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  $resdata = curl_exec($ch);
  //Close the cURL handle.
  curl_close($ch);
  return   $resdata;
}


function MarkersApi($conn, $network, $phone, $code_fetch, $requestId, $userprice_fetch)
{
  function fetchmarkers($conn)
  {
    $query_maks = $conn->query("SELECT * FROM providers_api_key WHERE provider='markersapi'");
    $fetchmakskey = $query_maks->fetch_assoc();
    return json_encode($fetchmakskey);
  }
  $json_maks = json_decode(fetchmarkers($conn));
  $apikey_maker = $json_maks->privatekey;
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://markersapi.com.ng/api/tv/?");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $apikey_maker,
    "service" => $network,
    "accountno" => $phone,
    "vcode" => $code_fetch,
    "amount" => $userprice_fetch,
    "ref" => $requestId
  )));
  $veridata_maker = curl_exec($ch);
  curl_close($ch);
  //file_put_contents('resp.txt',$veridata_maker);
  return $veridata_maker;
}
// to be editted for tv cable sub
function n3t($conn, $cable, $iuc, $cable_plan, $requestId)
{
  function fetchn3t($conn)
  {
    $query_n3t = $conn->query("SELECT * FROM providers_api_key WHERE provider='n3tdata'");
    $n3tkey = $query_n3t->fetch_assoc();
    return json_encode($n3tkey);
  }
  $json_n3t = json_decode(fetchn3t($conn));
  /////N3TDATA
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


  // cURL 2
  $paypload = array(
    'cable' => $cable, // 1,
    'iuc' => $iuc, // 08141279191,
    'cable_plan' => $cable_plan, // 1,
    'bypass' => false,
    'request-id' => $requestId
  );
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://n3tdata.com/api/cable');
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
  return  $response;
}
