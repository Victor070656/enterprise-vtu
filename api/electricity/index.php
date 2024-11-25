<?php
date_default_timezone_set('Africa/Lagos');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
include('../Connections/dbQuery.php');
include('../function/build.php');

$qrysit = mysqli_query($conn, "SELECT * FROM settings");
$sit = mysqli_fetch_array($qrysit);
function Greetings($hours)
{
  if ($hours >= 0 && $hours <= 12) {
    return "Good Morning";
  } else {
    if ($hours > 12 && $hours <= 17) {
      return "Good Afternoon";
    } else {
      if ($hours > 17 && $hours <= 20) {
        return "Good Evening";
      } else {
        return "Good Night";
      }
    }
  }
}
$hours = date('H');
$sitname = $sit['sitename'];
$hosturl = $_SERVER['SERVER_NAME'];
$siteLogo = $sit['sitelogo'];

// API parameter
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // get posted data
  $get_data = json_decode(file_get_contents("php://input"));
  if (isset($get_data)) {
    $apikey = $conn->real_escape_string(filter_var(trim(test_input($get_data->apikey)), FILTER_SANITIZE_STRING));
    $serviceID = $conn->real_escape_string(test_input($get_data->service));
    $billersCode = $conn->real_escape_string(test_input($get_data->accountno));
    $variation_code = $conn->real_escape_string(filter_var(trim(test_input($get_data->vcode)), FILTER_SANITIZE_STRING));
    $amountPayee = $conn->real_escape_string(filter_var(trim(test_input(floatval(abs($get_data->amount)))), FILTER_SANITIZE_STRING));
    $requestId = $conn->real_escape_string(filter_var(trim(test_input($get_data->ref)), FILTER_SANITIZE_STRING));
  }

  $auth = "paid";
  $txtadmin = "08084121526";

  $dateTime = date('Y-m-d h:i:A');

  $network =  $serviceID;
  // process request

  $proc = '_pay-tv';
  $charge = '';

  $channel = "API";
  $view = "View";


  function verify($conn, $serviceID, $billersCode)
  {
    //Initialize cURL.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, urlbasemain() . "/" . "merchantvalidate/?");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
      "service" => $serviceID,
      "smartNo" => $billersCode,
      "type" => $serviceID
    )));
    $veridata = curl_exec($ch);
    curl_close($ch);
    file_put_contents('v.txt', $veridata);
    return $veridata;
  }


  $fetch_decoder_user = json_decode(verify($conn, $serviceID, $billersCode));

  $decoder_userName = $fetch_decoder_user->description->Customer;

  $stmtqr = $conn->prepare("SELECT apikey,level,firstname,lastname,phone,bal,email FROM users WHERE apikey=?");
  $stmtqr->bind_Param("s", $apikey);
  $stmtqr->execute();
  $stmtqr->store_result();
  $stmtqr->bind_result($user, $aut, $fname, $lname, $UserPhone, $prevBal, $XU_em);
  $stmtqr->fetch();
  $stmtqr->close();

  $arr = array("$apikey", "$auth");

  $pair = array("$user", "$aut");

  if ($arr === $pair) {


    // check if the user have balance

    $userDetails = json_decode(fetchUser($conn, $apikey), true);
    $customNam = $userDetails[0]['firstname'] . ' ' . $userDetails[0]['lastname'];
    $current_balance = floatval($userDetails[0]['bal']);
    $userPhone = $userDetails[0]['phone'];
    $UserIPAddress = $userDetails[0]['IPaddress'];
    $upp_cas_lx = $userDetails[0]['email'];


    $ftrow =  json_decode(fetchPackage($conn, $variation_code, $serviceID), true);
    $network_fetch = $ftrow[0]['network'];
    $plan_fetch = $ftrow[0]['plan'];
    $code_fetch = $ftrow[0]['plancode'];
    $userprice_fetch = floatval($ftrow[0]['amount']);
    $gateway_fetch = $ftrow[0]['gateway'];
    $phone =  $billersCode;
    $per =   $ftrow[0]['discount'];
    $comi = strval(floatval($per / 100) * floatval($userprice_fetch));
    $debit = strval(floatval($userprice_fetch) - floatval($comi));

    $newBalc = strval(floatval($current_balance) - floatval($debit));
    if ($debit <= $current_balance) {

      // check if ref number exist

      $stmtcheckRef = $conn->prepare("SElECT ref FROM transactions WHERE ref=?");
      $stmtcheckRef->bind_Param("s", $requestId);
      $stmtcheckRef->execute();
      $stmtcheckRef->store_result();

      if ($stmtcheckRef->num_rows > 0) {

        response(104, "TRANSACTION ID ALREADY EXIST");
      } else {

        $stmtcheckRef->fetch();
        $stmtcheckRef->close();

        $callb = $_SERVER['SERVER_NAME'];

        if ($gateway_fetch === 'epins') {
          $resultepin = json_decode(epinApi($conn, $serviceID, $phone, $code_fetch, $requestId, $userprice_fetch));
          $apiRespone = $resultepin->code;
          $token_generated = $resultepin->description->Token;
        } elseif ($gateway_fetch === 'clubkonnect') {

          $resultclub = json_decode(clubAPi($conn, $network, $code_fetch, $phone, $requestId, $callb));
          $apiRespone = $resultclub->statuscode;
          $apiRespone = $resultclub->metertoken;
        } elseif ($gateway_fetch === 'shago') {
          $resultShago = json_decode(shagoPay($conn, $plan_fetch, $decoder_userName, $code_fetch, $phone, $userprice_fetch, $requestId, $userPhone, $decoder_address));
          $apiRespone = $resultShago->status;
          $token_generated = $resultShago->token;
        } elseif ($gateway_fetch === 'vtpass') {
          $resultvtpass = json_decode(vtpass($conn, $serviceID, $phone, $code_fetch, $requestId, $userprice_fetch));
          $apiRespone = $resultvtpass->code;
          $token_generated = $resultvtpass->purchased_code;
        } elseif ($gateway_fetch === 'husmodata') {
          $resulthusm = json_decode(husmoApi($conn, $plan_fetch, $phone, $userprice_fetch, $code_fetch));
          $apiRespone = $resulthusm->Status;
          $token_generated = $resulthusm->pin;
        } elseif ($gateway_fetch === 'gongoz') {
          $resultgo = json_decode(gongoz($conn, $plan_fetch, $phone, $userprice_fetch, $code_fetch));
          $apiRespone = $resultgo->Status;
          $token_generated = $resultgo->pin;
        } elseif ($gateway_fetch === 'alrahuz') {
          $resultal = json_decode(Alrahuz($conn, $plan_fetch, $phone, $userprice_fetch, $code_fetch));
          $apiRespone = $resultal->Status;
          $token_generated = $resultal->pin;
        } elseif ($gateway_fetch === 'smartrecharge') {

          $resultsmt = json_decode(smartRecharge($conn, $code_fetch, $phone));
          $apiRespone = $resultsmt->status;
          $token_generated = $resultsmt->data->pin;
        } else if ($gateway_fetch === 'markersapi') {

          $resultMakers = json_decode(MarkersApi($conn, $serviceID, $phone, $code_fetch, $requestId, $userprice_fetch));
          $apiRespone = $resultMakers->code;
          $token_generated = $resultMakers->description->Token;
        }




        /////////////////TV PAYMENT BLOCK//////////////
        // response message

        if ($apiRespone == '101' or $apiRespone === '000' or $apiRespone == '200' or $apiRespone === 'true' or $apiRespone === 'successful') {
          $stat = "Completed";
          $proces = "TRANSACTION SUCCESSFUL";
          // debit account
          UserdebitWallet($conn, $newBalc, $upp_cas_lx);

          response(101, array("Status" => $proces, "MeterNo" => $billersCode, "Disco" => $plan_fetch, "Date" => $dateTime));
          $current_BALANCE = $newBalc;
        } else {
          $failed_message = "Failed";
          $stat = "Failed";
          response(105, array("response_description" => $failed_message));

          $current_BALANCE = $current_balance;
        }

        $conct_Name = $fname . ' ' . $lname;
        $Trans_add = $conn->query("INSERT INTO transactions(network,serviceid,channel,phone,amount,charge,ref,status,date,email,customer,customerName,servicetype,meterno,newBal,metertoken)
VALUES('$plan_fetch','$variation_code','$channel','$billersCode','$userprice_fetch','$debit','$requestId','$stat','$dateTime','$upp_cas_lx','$conct_Name','$decoder_userName','$serviceID','$billersCode','$current_BALANCE','$token_generated')");


        ////END TV PAYMENT BLOCK ///////

      }
      // End of Transaction Ref Duplicate  check


    }
    // echo low balance
    else {

      response(102, "LOW BALANCE");
    }

    // close account not found
  } else {

    response(103, "INVALID ACCOUNT");
  }
} else {

  response(400, "INVALID REUEST METHOD [ Request Method must be POST ]");
}


function response($status, $status_message)
{


  $response['code'] = $status;
  $response['description'] = $status_message;


  $json_response = json_encode($response);
  echo $json_response;
}




function fetchUser($conn, $apikey)
{
  $qryUser = $conn->query("SELECT * FROM users 
WHERE email='$apikey'");
  while ($row[] = $qryUser->fetch_assoc()) {
  }
  return json_encode($row);
}

function fetchPackage($conn, $variation_code, $serviceID)
{
  $qryPlan = $conn->query("SELECT * FROM tv_package WHERE plancode='$variation_code' AND network='$serviceID'");
  while ($prow[] = $qryPlan->fetch_assoc()) {
  }
  return json_encode($prow);
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

function vtpass($conn, $serviceID, $phone, $code_fetch, $requestId, $userprice_fetch)
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
      'serviceID' => $serviceID, //integer e.g gotv,dstv,eko-electric,abuja-electric
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


function epinApi($conn, $serviceID, $phone, $code_fetch, $requestId, $userprice_fetch)
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
    "service" => $serviceID,
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

function MarkersApi($conn, $serviceID, $phone, $code_fetch, $requestId, $userprice_fetch)
{

  function fetchMarkers($conn)
  {
    $query_maks = $conn->query("SELECT * FROM providers_api_key WHERE provider='markersapi'");
    $fetchmakey = $query_maks->fetch_assoc();
    return json_encode($fetchmakey);
  }
  $json_maks = json_decode(fetchMarkers($conn));
  $apikey = $json_maks->privatekey;
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://markersapi.com.ng/api/electricity/?");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $apikey,
    "service" => $serviceID,
    "accountno" => $phone,
    "vcode" => $code_fetch,
    "amount" => $userprice_fetch,
    "ref" => $requestId
  )));
  $veridata_maks = curl_exec($ch);
  curl_close($ch);
  //file_put_contents('resp.txt',$veridata_maks);
  return $veridata_maks;
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
  $n3_accesscode = $n3result->AccessToken;


  // cURL 2
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
    "Authorization: Token $n3_accesscode",
    'Content-Type: application/json'
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $n3tRes = curl_exec($ch);
  curl_close($ch);
  file_put_contents('airtime.txt', $n3tRes);
  return  $n3tRes;
}
