<?php
date_default_timezone_set('Africa/Lagos');
$dat = date("Y-m-d h:i:s");
$request_Format = date('YmdHis');
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
$userprice_fetch = floatval(abs($trans[0]['amount']));

if ($network == 'mtn') {
  $provider = "mtn";
  $img = 'mtn.jpg';
  $networkcode = "01";
  $n3code = 1;
}
if ($network == 'glo') {
  $provider = "glo";
  $img = 'glo.jpg';
  $networkcode = "02";
  $n3code = 3;
}
if ($network == 'etisalat') {
  $provider = "9mobile";
  $img = '9mobile.jpg';
  $networkcode = "04";
  $n3code = 4;
}
if ($network == 'airtel') {
  $provider = "airtel";
  $img = 'airtel.jpg';
  $networkcode = "03";
  $n3code = 2;
}


$reference = uniqid();
$stats = "Completed";
$channel = "Wallet";
$failstats = "Failed";
$callb = $_SERVER['SERVER_NAME'];

$userDetails = json_decode(fetchUser($conn, $UserEmail), true);
$customNam = $userDetails[0]['firstname'] . ' ' . $userDetails[0]['lastname'];
$current_balance = floatval($userDetails[0]['bal']);
$userPhone = $userDetails[0]['phone'];
$UserIPAddress = $userDetails[0]['IPaddress'];
$varUserId = $userDetails[0]['email'];
$userLevel = $userDetails[0]['level'];
$ftrow =  json_decode(fetchPackage($conn, $network), true);
$network_fetch = $ftrow[0]['network'];
$discount_fetch = floatval($ftrow[0]['discount']);
$gateway_fetch = $ftrow[0]['gateway'];

$valu = strtoupper($provider) . ' ' . 'Airtime';

if (strval($trans[0]['status'] !== 'Completed')) {

  if ($userLevel !== 'paid') {
    $per = floatval($ftrow[0]['user_discount']);
  } else {
    $per = floatval($ftrow[0]['discount']);
  }

  $discount = strval(floatval(($per / 100)) * floatval($userprice_fetch));

  $payable = strval(floatval($userprice_fetch) - floatval($discount));

  if (floatval($payable) <= floatval($current_balance)) {

    $newBalc =  strval(floatval($current_balance) - floatval($payable));


    switch ($gateway_fetch) {
      case 'vtpass':
        $vtpcode = json_decode(vtpay($conn, $request_Format, $network, $userprice_fetch, $phone));
        $responseCode = $vtpcode->code;
        break;

      case 'shago':
        $shagocode = json_decode(Shagopay($conn, $phone, $userprice_fetch, $network, $requestId));
        $responseCode = $shagocode->status;
        break;

      case 'epins':
        $epins_code = json_decode(epinAirtime($conn, $network, $phone, $userprice_fetch, $requestId));
        $responseCode = $epins_code->code;
        break;
      case 'paytev':
        $paytev_code = Paytev($network, $phone, $userprice_fetch, $requestId);
        $responseCode = $paytev_code->status;
        break;

      case 'clubkonnect':
        $clubcode = json_decode(ClubKonet($conn, $networkcode, $userprice_fetch, $phone, $requestId, $callb));
        $responseCode = $clubcode->statuscode;
        break;

      case 'n3tdata':
        $n3t_json = json_decode(n3t($conn, $phone, $userprice_fetch, $n3code, $requestId));
        $responseCode = $n3t_json->status;
        break;

      case 'husmodata':
        $husmo_json = json_decode(husmo($conn, $networkcode, $userprice_fetch, $phone));
        $responseCode = $husmo_json->Status;
        break;

      case 'zoedatahub':
        $zoe_json = json_decode(zoedata($conn, $networkcode, $userprice_fetch, $phone));
        $responseCode = $zoe_json->Status;
        break;

      case 'bigsub':
        $bigSub_js = json_decode(BigSub($conn, $phone, $userprice_fetch, $network));
        $responseCode = $bigSub_js->success;
        break;
      case 'n3t':
        $n3t_js = json_decode(n3t($conn, $phone, $userprice_fetch, $n3code, $requestId));
        $msg = $n3t_js->message;
        $responseCode = $n3t_js->status;
        break;

      case 'smeplug':

        $smplug =  json_decode(smeplug($network, $amount, $phone, $requestId));
        $responseCode = $smplug->status;

        break;

      default:
    }

    $successArray = ["101", "201", "000", "200", "100", "success", "successful", "true"];
    if (in_array($responseCode, $successArray)) {

      UserdebitWallet($conn, $newBalc, $varUserId);

      if (UpdateTransaction($conn, $stats, $reference, $channel, $payable, $newBalc, $dat, $requestId)) {

        $resp['msg'] = "Transaction Successful";
        $resp['status'] = true;
        $resp['descr'] = $valu . ' sent to ' . $phone;
        $resp['receipt'] = "../../receipt?tid=" . $requestId;
        $resp['redirect'] = "../../airtime.php";
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

      UpdateFailedTransaction($conn, $reference, $channel, $userprice_fetch, $current_balance, $dat, $requestId, $failstats);

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


function fetchPackage($conn, $network)
{
  $qryPlan = $conn->query("SELECT * FROM airtime_package WHERE network='$network'");
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

function UpdateTransaction($conn, $stats, $reference, $channel, $payable, $newBalc, $dat, $requestId)
{
  $stmtTrUpd = $conn->query("UPDATE transactions SET status='$stats',token='$reference',channel='$channel',charge='$payable',newBal='$newBalc',date='$dat' WHERE ref='$requestId'");
  return $stmtTrUpd;
}


function UpdateFailedTransaction($conn, $reference, $channel, $userprice_fetch, $current_balance, $dat, $requestId, $failstats)
{
  $stmtTrfl = $conn->prepare("UPDATE transactions SET status=?,token=?,channel=?,charge=?,newBal=?,date=? WHERE ref=?");
  $stmtTrfl->bind_Param("sssssss", $failstats, $reference, $channel, $userprice_fetch, $current_balance, $dat, $requestId);
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



function Paytev($network, $phone, $userprice_fetch, $requestId)
{
  global $conn;
  $query_tev = $conn->query("SELECT * FROM providers_api_key WHERE provider='paytev'");
  $paytevkey = $query_tev->fetch_object();
  $API_TOKEN = $paytevkey->privatekey;
  $varNetwork = $network . '_airtime';
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://client.paytev.com/api/v1/airtime?format=json&phone=$phone&amount=$userprice_fetch&network=$varNetwork",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
      "Authorization: $API_TOKEN",
      "source-domain: https://dashboard.spacepay.ng"
    ),
  ));

  $PayTevresponse = curl_exec($curl);
  curl_close($curl);
  //file_put_contents('ch.txt',$PayTevresponse);
  return json_decode($PayTevresponse);
}


function smeplug($network, $amount, $phone, $requestId)
{
  global $conn;
  $query_splug = $conn->query("SELECT * FROM providers_api_key WHERE provider='smeplug'");
  $json_splug = $query_splug->fetch_object();


  switch ($network) {
    case '01':
      $network_var = "1";
      break;

    case '02':
      $network_var = "4";
      break;

    case '03':
      $network_var = "3";
      break;

    case '04':
      $network_var = "2";
      break;

    default:
  }

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://smeplug.ng/api/v1/airtime/purchase',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
      "network_id" => $network_var,
      "phone" => $phone,
      "amount" => $amount,
      "customer_reference" => $requestId
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



function vtpay($conn, $request_Format, $network, $userprice_fetch, $phone)
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
    CURLOPT_URL => "https://vtpass.com/api/pay",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_USERPWD => $json_vt->privatekey . ":" . $json_vt->secretkey,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_POSTFIELDS => array(
      'request_id' => $request_Format,
      'serviceID' => $network, //integer e.g mtn,airtel
      'amount' =>  $userprice_fetch, // integer
      'phone' => $phone //integer
    ),
  ));
  $Vtsuccess = curl_exec($curl);
  $curl_errno = curl_errno($curl);
  curl_close($curl);

  return  $Vtsuccess;
}


function Shagopay($conn, $phone, $userprice_fetch, $network, $requestId)
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
    'serviceCode' => "QAB",
    'phone' => $phone,
    'amount'  => $userprice_fetch,
    'vend_type'  => 'VTU',
    'network' => strtoupper($network),
    'request_id' => $requestId
  )));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "hashKey: $hashkey"
  ));
  $ShagoRes = curl_exec($ch);
  curl_close($ch);
  //file_put_contents('airtime.txt',$ShagoRes);
  return  $ShagoRes;
}




function epinAirtime($conn, $network, $phone, $userprice_fetch, $requestId)
{

  function fetchEpin($conn)
  {
    $query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
    $fetchepkey = $query_ep->fetch_assoc();
    return json_encode($fetchepkey);
  }
  $json_ep = json_decode(fetchEpin($conn));

  function urlbasemain()
  {
    //Initialize cURL.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/base?url=main");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $basedata = curl_exec($ch);
    $result_bz = json_decode($basedata, true);
    //Close the cURL handle.
    curl_close($ch);
    return $result_bz['description'][0]['main'];
  }

  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, urlbasemain() . "/" . "airtime/");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $json_ep->privatekey,
    "network" => $network,
    "phone" => $phone,
    "amount" =>  $userprice_fetch,
    "ref" => $requestId
  )));
  $veridata = curl_exec($ch);
  curl_close($ch);
  //file_put_contents('v.txt',$veridata);
  return $veridata;
}


function ClubKonet($conn, $networkcode, $userprice_fetch, $phone, $requestId, $callb)
{
  function fetchclb($conn)
  {
    $query_cl = $conn->query("SELECT * FROM providers_api_key WHERE provider='clubkonnect'");
    $clbkey = $query_cl->fetch_assoc();
    return json_encode($clbkey);
  }
  $json_clb = json_decode(fetchclb($conn));
  $clbtoken = $json_clb->privatekey;
  $UserID = $json_clb->secretkey;
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://www.nellobytesystems.com/APIAirtimeV1.asp?UserID=$UserID&APIKey=$clbtoken&MobileNetwork=$networkcode&Amount=$userprice_fetch&MobileNumber=$phone&RequestID=$requestId&CallBackURL=$callb");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  $Clubdata = curl_exec($ch);
  curl_close($ch);
  return $Clubdata;
}


// function n3t($conn, $phone, $userprice_fetch, $n3code, $requestId)
// {
//   function fetchn3t($conn)
//   {
//     $query_n3t = $conn->query("SELECT * FROM providers_api_key WHERE provider='n3tdata'");
//     $n3tkey = $query_n3t->fetch_assoc();
//     return json_encode($n3tkey);
//   }
//   $json_n3t = json_decode(fetchn3t($conn));
//   /////N3TDATA
//   $curl = curl_init();
//   curl_setopt_array($curl, array(
//     CURLOPT_URL => 'https://n3tdata.com/api/user',
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => '',
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_HTTPHEADER => array(
//       "Content-Type: application/json",
//       "Authorization: Basic " . base64_encode($json_n3t->privatekey . ':' . $json_n3t->secretkey)
//     ),
//   ));
//   $N3Tresponse = curl_exec($curl);
//   $n3result = json_decode($N3Tresponse);
//   curl_close($curl);
//   $n3_accesscode = $n3result->AccessToken;
//   $ch = curl_init();
//   curl_setopt($ch, CURLOPT_URL, "https://n3tdata.com/api/topup");
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//   curl_setopt($ch, CURLOPT_HEADER, FALSE);
//   curl_setopt($ch, CURLOPT_POST, TRUE);
//   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
//     array(
//       'network' => $n3code,
//       'phone' => $phone,
//       'plan_type' => 'VTU',
//       'bypass' => false,
//       'amount' => $userprice_fetch,
//       'request-id' => $requestId
//     )

//   ));
//   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//     "Content-Type: application/json",
//     "Authorization: Token $n3_accesscode "
//   ));
//   $n3tRes = curl_exec($ch);
//   curl_close($ch);
//   file_put_contents('airtime.txt', $n3tRes);
//   return  $n3tRes;
// }

function n3t($conn, $phone, $userprice_fetch, $n3code, $requestId)
{
  function fetchn3t($conn)
  {
    $query_n3t = $conn->query("SELECT * FROM providers_api_key WHERE provider='n3tdata'");
    $n3tkey = $query_n3t->fetch_assoc();
    return json_encode($n3tkey);
  }
  $json_n3t = json_decode(fetchn3t($conn));
  /////N3TDATA
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://n3tdata.com/api/user',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Basic " . base64_encode($json_n3t->username . ':' . $json_n3t->password)
    ),
  ));
  $N3Tresponse = curl_exec($curl);
  $n3result = json_decode($N3Tresponse);
  curl_close($curl);
  $n3_accesscode = $n3result->AccessToken;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://n3tdata.com/api/topup");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
    array(
      'network' => $n3code,
      'phone' => $phone,
      'plan_type' => 'VTU',
      'bypass' => false,
      'amount' => $userprice_fetch,
      'request-id' => $requestId
    )

  ));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Authorization: Token $n3_accesscode "
  ));
  $n3tRes = curl_exec($ch);
  curl_close($ch);
  // file_put_contents('airtime.txt', $n3tRes);
  return  $n3tRes;
}

function husmo($conn, $networkcode, $userprice_fetch, $phone)
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
    CURLOPT_URL => 'https://husmodataapi.com/api/topup/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "network" => $networkcode,
      "amount" => $userprice_fetch,
      "mobile_number" => $phone,
      "Ported_number" => true,
      "airtime_type" => 'VTU'
    )),
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Token " . $json_hus->privatekey
    ),
  ));

  $Husresponse = curl_exec($curl);
  curl_close($curl);
  //file_put_contents('airtime.txt',$Husresponse);
  return $Husresponse;
}


function MarkerAirtime($conn, $network, $phone, $userprice_fetch, $requestId)
{
  function fetchMarkersApi($conn)
  {
    $query_marks = $conn->query("SELECT * FROM providers_api_key WHERE provider='markersapi'");
    $fetchmarkey = $query_marks->fetch_assoc();
    return json_encode($fetchmarkey);
  }
  $json_markers = json_decode(fetchMarkersApi($conn));

  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://markersapi.com.ng/api/airtime/');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $json_markers->privatekey,
    "network" => $network,
    "phone" => $phone,
    "amount" => $userprice_fetch,
    "ref" => $requestId
  )));
  $Markers_veridata = curl_exec($ch);
  curl_close($ch);
  //file_put_contents('ch.txt',$Markers_veridata);
  return $Markers_veridata;
}

function zoedata($conn, $networkcode, $userprice_fetch, $phone)
{
  function fetchzoe($conn)
  {
    $query_zoe = $conn->query("SELECT * FROM providers_api_key WHERE provider='zoedatahub'");
    $zoekey = $query_zoe->fetch_assoc();
    return json_encode($zoekey);
  }
  $json_zoehub = json_decode(fetchzoe($conn));
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://zoedatahub.com/api/topup/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "network" => strval(intval($networkcode)),
      "amount" => $userprice_fetch,
      "mobile_number" => $phone,
      "Ported_number" => true,
      "airtime_type" => 'VTU'
    )),
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Token " . $json_zoehub->privatekey
    ),
  ));

  $ZoeResponse = curl_exec($curl);
  curl_close($curl);
  //file_put_contents('airtime.txt',$Husresponse);
  return $ZoeResponse;
}


function BigSub($conn, $phone, $userprice_fetch, $network)
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
  if ($network == 'mtn') {
    $bgvar = 1;
  }
  if ($network == 'airtel') {
    $bgvar = 2;
  }
  if ($network == 'glo') {
    $bgvar = 3;
  }
  if ($network == 'etisalat') {
    $bgvar = 4;
  }
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://bigsub.com.ng/api/airtime.php?number=$phone&network=$bgvar&amount=$userprice_fetch");
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
