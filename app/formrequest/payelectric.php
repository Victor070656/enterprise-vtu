<?php
date_default_timezone_set('Africa/Lagos');
$dat = date("Y-m-d h:i:s");
// session_start();

$error = array();
$resp = array();

// $token = sanitize_input($_REQUEST['_tok']) ?? $_SESSION["transid"];
$token = $_GET["trans"];
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
$serviceId = $trans[0]['serviceid'];
$phone = $trans[0]['phone'];
$requestId = $trans[0]['ref'];
$userprice_fetch = floatval($trans[0]['amount']);
$code_fetch = $trans[0]['vcode'];
$disco_split = preg_split("/[-\s:]/", $serviceId);
$network = $disco_split[0];

$disco = null;


if ($network === 'abuja') {
  $img = 'Abuja-Electric.jpg';
  $disco = 8;
}
if ($network === 'enugu') {
  $img = 'EEDC-Enugu-electricity-payment.jpg';
  $disco = 10;
}
if ($network === 'ikeja') {
  $img = 'ikeja.png';
  $disco = 1;
}
if ($network === 'eko') {
  $img = 'Eko-Electric-Payment-PHCN.jpg';
  $disco = 2;
}
if ($network === 'ibadan') {
  $img = 'IBEDC-Ibadan-Electricity-Distribution-Company.jpg';
  $disco = 6;
}
if ($network === 'benin') {
  $img = 'bedc.jpg';
  $disco = 9;
}
if ($network === 'jos') {
  $img = 'Jos-Electric-JED.jpg';
  $disco = 5;
}
if ($network === 'kano') {
  $img = 'Kano-Electricity-Distribution-Company-KEDCO-logo.png';
  $disco = 3;
}
if ($network === 'kaduna') {
  $img = 'kaduna.jpg';
  $disco = 7;
}
if ($network === 'yola') {
  $img = 'yola.jpg';
  $disco = null;
}
if ($network === 'portharcourt') {
  $img = 'phc.png';
  $disco = 4;
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
$user_account_type = $userDetails[0]['level'];

$ftrow =  json_decode(fetchPackage($conn, $network), true);
$network_fetch = $ftrow[0]['network'];
$plan_fetch = $ftrow[0]['plan'];
$gateway_fetch = $ftrow[0]['gateway'];
$plan_discount = $ftrow[0]['discount'];


switch ($user_account_type) {

  case 'free':
    $per = 0;
    break;

  case 'paid':
    $per =  $plan_discount;
    break;
}

$discount = ($per / 100) * $userprice_fetch;
$totalPayable = strval(floatval($userprice_fetch) - $discount);
// discount end   


$valu = strtoupper($network) . ' ' . $plan_fetch;

if (strval($trans[0]['status'] !== 'Completed')) {

  if (floatval($totalPayable) <= floatval($current_balance)) {

    $newBalc =  strval(floatval($current_balance) - floatval($totalPayable));
    session_start();
    $decoder_userName = $_SESSION['customer'];
    $decoder_address = $_SESSION['Address'];

    $callb = $_SERVER['SERVER_NAME'];

    switch ($gateway_fetch) {

      case 'epins':
        $resultepin = json_decode(epinApi($conn, $serviceId, $phone, $code_fetch, $requestId, $userprice_fetch));
        $apiRespone = $resultepin->code;
        $token_generated = $resultepin->description->Token;

        break;

      case 'clubkonnect':

        $resultclub = json_decode(clubAPi($conn, $network, $code_fetch, $phone, $requestId, $callb));
        $apiRespone = $resultclub->statuscode;
        $apiRespone = $resultclub->metertoken;

        break;

      case 'shago':

        $resultShago = json_decode(shagoPay($conn, $plan_fetch, $decoder_userName, $code_fetch, $phone, $userprice_fetch, $requestId, $userPhone, $decoder_address));
        $apiRespone = $resultShago->status;
        $token_generated = $resultShago->token;

        break;

      case 'vtpass':

        $resultvtpass = json_decode(vtpass($conn, $serviceId, $phone, $code_fetch, $requestId, $userprice_fetch));
        $apiRespone = $resultvtpass->code;
        $token_generated = $resultvtpass->purchased_code;

        break;

      case 'husmodata':

        $resulthusm = json_decode(husmoApi($conn, $plan_fetch, $phone, $userprice_fetch, $code_fetch));
        $apiRespone = $resulthusm->Status;
        $token_generated = $resulthusm->pin;

        break;

      case 'gongoz':

        $resultgo = json_decode(gongoz($conn, $plan_fetch, $phone, $userprice_fetch, $code_fetch));
        $apiRespone = $resultgo->Status;
        $token_generated = $resultgo->pin;

        break;

      case 'alrahuz':

        $resultal = json_decode(Alrahuz($conn, $plan_fetch, $phone, $userprice_fetch, $code_fetch));
        $apiRespone = $resultal->Status;
        $token_generated = $resultal->pin;

        break;

      case 'smartrecharge':

        $resultsmt = json_decode(smartRecharge($conn, $code_fetch, $phone));
        $apiRespone = $resultsmt->status;
        $token_generated = $resultsmt->data->pin;
        break;

      case 'paytev':
        $payTev = Paytev($phone, $userprice_fetch, $network, $code_fetch);
        $apiRespone = $payTev->status;
        $token_generated = $payTev->token;
        break;

      case 'n3t':
        $n3t = json_decode(n3t($conn, $disco, $plan_fetch, $code_fetch, $userprice_fetch, $requestId));
        $apiRespone = $n3t->status;
        $message = $n3t->message;
        if (!empty($n3t->token)) {
          $token_generated = $n3t->token;
        } else {
          $token_generated = null;
        }

      default:
    }

    if ($apiRespone == 101 or $apiRespone == 201 or $apiRespone === '000' or $apiRespone == '200' or $apiRespone === 'true' or $apiRespone === 'successful' or $apiRespone === 'success') {

      UserdebitWallet($conn, $newBalc, $varUserId);

      if (UpdateTransaction($conn, $stats, $reference, $channel, $totalPayable, $newBalc, $token_generated, $requestId)) {

        $resp['msg'] = "Transaction Successful";
        $resp['status'] = true;
        $resp['description'] = $valu . ' sent to ' . $phone;
        $resp['redirect'] = "../../electricity.php";
        $resp['token'] = $token_generated;
        $resp['disco'] = $plan_fetch;
        echo json_encode($resp);
        exit();
      } else {
        $error[] = "Error processing your request";
        $error[] = $message;
        $resp['msg'] = $error;
        $resp['status'] = false;
        echo json_encode($resp);
        exit();
      }
    } else {

      UpdateFailedTransaction($conn, $stats, $reference, $channel, $userprice_fetch, $current_balance, $requestId, $failstats);

      $error[] = "Network Error: Please Try again shortly";
      $error[] = $message;
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

function fetchPackage($conn, $network)
{
  $qryPlan = $conn->query("SELECT * FROM electric_package WHERE network='$network'");
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

function UpdateTransaction($conn, $stats, $reference, $channel, $totalPayable, $newBalc, $token_generated, $requestId)
{
  $stmtTrUpd = $conn->prepare("UPDATE transactions SET status=?,token=?,channel=?,charge=?,newBal=?,metertoken=? WHERE ref=?");
  $stmtTrUpd->bind_Param("sssssss", $stats, $reference, $channel, $totalPayable, $newBalc, $token_generated, $requestId);
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


function n3t($conn, $disco, $meter_type, $meter_number, $amount, $requestId)
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
  // $n3_accesscode = $n3result->AccessToken;
  $paypload = array(
    'disco' => $disco,
    'meter_type' => $meter_type,
    'meter_number' => $meter_number,
    'amount' => $amount,
    'bypass' => false,
    'request-id' => $requestId
  );
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://n3tdata.com/api/bill');
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paypload));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $headers = [
    "Authorization: Token " . $n3result->AccessToken,
    'Content-Type: application/json'
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $n3tRes = curl_exec($ch);
  curl_close($ch);
  // file_put_contents('airtime.txt', $n3tRes);
  return  $n3tRes;
}


function Paytev($phone, $userprice_fetch, $network, $code_fetch)
{
  global $conn;
  $query_tev = $conn->query("SELECT * FROM providers_api_key WHERE provider='paytev'");
  $paytevkey = $query_tev->fetch_object();
  $API_TOKEN = $paytevkey->privatekey;
  $disco_var_name = $network . '_' . $code_fetch . '_Electricity';
  $metertype_var = $network . '_' . $code_fetch;
  $meter_type = strtoupper($code_fetch);
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://client.paytev.com/api/v1/electricityPurchase?format=json&service=$disco_var_name&meterNo=$phone&code=$metertype_var&amount=$userprice_fetch&meterType=$meter_type",
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


function shagoPay($conn, $plan_fetch, $decoder_userName, $code_fetch, $phone, $userprice_fetch, $requestId, $userPhone, $decoder_address)
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
    'serviceCode' => 'AOB',
    'disco' => $plan_fetch,
    'meterNo' => $phone,
    'type' => strtoupper($code_fetch),
    'amount'  => $userprice_fetch,
    'phonenumber' => $userPhone,
    'name' => $decoder_userName,
    'address'  => $decoder_address,
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

function vtpass($conn, $serviceId, $phone, $code_fetch, $requestId, $userprice_fetch)
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
      'serviceID' => $serviceId, //integer e.g gotv,dstv,eko-electric,abuja-electric
      'billersCode' => $phone, // e.g smartcardNumber, meterNumber,
      'variation_code' => $code_fetch, // e.g dstv1, dstv2,prepaid,(optional for somes services)
      'amount' =>  $userprice_fetch, // integer (optional for somes services)
      'phone' => $phone //integer
    ),
  ));
  $success_vtp = curl_exec($curl);
  $curl_errno = curl_errno($curl);
  curl_close($curl);
  //file_put_contents('res.txt',$success_vtp.'/'.$userprice_fetch);
  return $success_vtp;
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

function Alrahuz($conn, $plan_fetch, $phone, $userprice_fetch, $code_fetch)
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
    CURLOPT_URL => 'https://alrahuzdata.com.ng/api/billpayment/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "disco_name" => $plan_fetch,
      "amount" => $userprice_fetch,
      "meter_number" => $phone,
      "MeterType" => $code_fetch
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

function gongoz($conn, $plan_fetch, $phone, $userprice_fetch, $code_fetch)
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
    CURLOPT_URL => 'https://www.gongozconcept.com/api/billpayment/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "disco_name" => $plan_fetch,
      "amount" => $userprice_fetch,
      "meter_number" => $phone,
      "MeterType" => $code_fetch
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

function husmoApi($conn, $plan_fetch, $phone, $userprice_fetch, $code_fetch)
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
    CURLOPT_URL => 'https://husmodataapi.com/api/billpayment/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "disco_name" => $plan_fetch,
      "amount" => $userprice_fetch,
      "meter_number" => $phone,
      "MeterType" => $code_fetch
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


function epinApi($conn, $serviceId, $phone, $code_fetch, $requestId, $userprice_fetch)
{

  $query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
  $json_ep = $query_ep->fetch_object();

  $apikey = $json_ep->privatekey;
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/biller/");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $apikey,
    "service" => $serviceId,
    "accountno" => $phone,
    "vcode" => $code_fetch,
    "amount" => $userprice_fetch,
    "ref" => $requestId
  )));
  $veridata = curl_exec($ch);
  curl_close($ch);
  //file_put_contents('resp.txt',$veridata);
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
