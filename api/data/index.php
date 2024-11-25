<?php
date_default_timezone_set('Africa/Lagos');
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
$request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);
// API parameter



// API parameter
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // get posted data
  $get_data = json_decode(file_get_contents("php://input"));
  if (isset($get_data)) {
    $apikey = test_input($get_data->apikey);
    $serviceID = test_input($get_data->service);
    $Destination_Number = test_input(preg_replace("/[^0-9]/", '', $get_data->MobileNumber));
    $MobileNumber = str_replace(' ', '', $Destination_Number);
    $amountPayee = test_input($get_data->DataPlan);
    $requestId = test_input($get_data->ref);
  } else {

    $apikey = test_input($_POST['apikey']);
    $serviceID = test_input($_POST['service']);
    $Destination_Number = test_input(preg_replace("/[^0-9]/", '', $_POST['MobileNumber']));
    $MobileNumber = str_replace(' ', '', $Destination_Number);

    $amountPayee = test_input($_POST['DataPlan']);
    $requestId = test_input($_POST['ref']);
  }

  $auth = "paid";


  $Dataplan = $amountPayee;



  $servName = $_SERVER['HTTP_HOST'];
  $convee = NULL;
  $customer = NULL;
  $xname = NULL;
  $action = "Pay";
  $dateTime = date('Y-m-d h:i:A');
  //$email = $user;
  $proc = '_pay-tv';
  $charge = '';

  $channel = "API";
  $view = "View";

  // check if the account is valid

  $retr = "SELECT * FROM users WHERE apikey='$apikey' ";

  $exe = mysqli_query($conn, $retr);
  $rob = mysqli_fetch_array($exe);

  $user = $conn->real_escape_string($rob['apikey']);
  $aut = $conn->real_escape_string($rob['level']);
  $fname = $conn->real_escape_string($rob['firstname']);
  $lname = $conn->real_escape_string($rob['lastname']);

  $arr = array("$apikey", "$auth");

  $pair = array("$user", "$aut");


  if ($arr === $pair) {

    // check if the user have balance

    $gb = mysqli_query($conn, "SElECT * FROM users WHERE apikey = '$user' ");
    $reco = mysqli_fetch_array($gb);

    $level = $conn->real_escape_string($reco['level']);
    $UserEmail = $conn->real_escape_string($reco['email']);

    //extract account info


    if ($serviceID == '01') {
      $provider = "mtn";
      $img = 'Data-mtn.jpg';
      $networkcode = "01";
    }
    if ($serviceID == '02') {
      $provider = "glo";
      $img = 'GLO-Data.jpg';
      $networkcode = "02";
    }
    if ($serviceID == '03') {
      $provider = "9mobile";
      $shagoNetwork = "etisalat";
      $img = '9mobile-Data.jpg';
      $networkcode = "04";
    }
    if ($serviceID == '04') {
      $provider = "airtel";
      $img = 'Airtel-Data.jpg';
      $networkcode = "03";
    }
    $network = $serviceID;
    $phone = $MobileNumber;

    $userDetails = json_decode(fetchUser($conn, $UserEmail), true);
    $customNam = $userDetails[0]['firstname'] . ' ' . $userDetails[0]['lastname'];
    $current_balance = floatval($userDetails[0]['bal']);
    $userPhone = $userDetails[0]['phone'];
    $UserIPAddress = $userDetails[0]['IPaddress'];
    $upp_cas_lx = $userDetails[0]['email'];

    $ftrow =  json_decode(fetchPackage($conn, $Dataplan, $serviceID), true);
    $network_fetch = $ftrow[0]['network'];
    $dataType = $ftrow[0]['datatype'];
    $plan_fetch = $ftrow[0]['plan'];
    $code_fetch = $ftrow[0]['plancode'];
    $userprice_fetch = floatval($ftrow[0]['price_user']);
    $apiprice_fetch = floatval($ftrow[0]['price_api']);
    $gateway_fetch = $ftrow[0]['gateway'];
    $status_fetch = $ftrow[0]['status'];

    if ($status_fetch !== 'disabled') {

      $valu = strtoupper($provider) . ' ' . $plan_fetch;
      $servicetype = "data";

      $newBalc =  strval(floatval($current_balance) - floatval($apiprice_fetch));

      if (floatval($apiprice_fetch) <= floatval($current_balance)) {


        $req = mysqli_query($conn, "SElECT * FROM transactions WHERE ref = '$requestId' ");
        $nu = mysqli_num_rows($req);

        if ($nu == 0) {


          $callb = $_SERVER['SERVER_NAME'];
          $apiMulti = json_decode(Apidefault($conn, $code_fetch));

          if ($apiMulti->gateway === 'epins') {

            $resultepin = json_decode(epinApi($conn, $network, $phone, $code_fetch, $requestId));
            $apiRespone = $resultepin->code;
          } elseif ($apiMulti->gateway === 'clubkonnect') {

            $resultclub = json_decode(clubAPi($conn, $network, $code_fetch, $phone, $requestId, $callb));
            $apiRespone = $resultclub->status;
          } elseif ($apiMulti->gateway === 'mobileng') {
            $resultmob = json_decode(mobilng($conn, $networkcode, $phone, $code_fetch, $requestId));
            $apiRespone = $resultmob->code;
          } elseif ($apiMulti->gateway === 'smeplug') {
            smeplug($conn, $smeplugnet_id, $code_fetch, $phone);
          } elseif ($apiMulti->gateway === 'husmodata') {
            $resulthusm = json_decode(husmoApi($conn, $serviceID, $phone, $code_fetch));
            $apiRespone = $resulthusm->Status;
          } elseif ($apiMulti->gateway === 'gongoz') {
            $resultgo = json_decode(gongoz($conn, $networkcode, $phone, $code_fetch));
            $apiRespone = $resultgo->Status;
          } elseif ($apiMulti->gateway === 'alrahuz') {
            $resultal = json_decode(Alrahuz($conn, $networkcode, $phone, $code_fetch));
            $apiRespone = $resultal->Status;
          } else if ($apiMulti->gateway === 'smartrecharge') {

            $resultsmt = json_decode(smartRecharge($conn, $code_fetch, $phone, $callb));
          } else if ($apiMulti->gateway === 'markersapi') {

            $resultmarkers = json_decode(MarkersApi($conn, $network, $phone, $code_fetch, $requestId));
            $apiRespone = $resultmarkers->code;
          } else if ($apiMulti === 'vtpass') {
            $resultVpass = json_decode(vtpass($conn, $provider, $phone, $code_fetch, $requestId, $Dataplan));
            $apiRespone = $resultVpass->code;
          } else if ($apiMulti === 'shago') {
            $resultShago = json_decode(shagoPay($conn, $plan_fetch, $Dataplan, $code_fetch, $phone, $requestId, $provider));
            $apiRespone = $resultShago->status;
          } else if ($apiMulti->gateway === 'zoedatahub') {
            $resultZoe =  json_decode(zoeDataHub($conn, $networkcode, $phone, $code_fetch));
            $apiRespone = $resultZoe->Status;
          } else if ($apiMulti->gateway === 'bigsub') {
            $json_bigsub =  json_decode(BigSub($conn, $phone, $code_fetch, $network, $dataType));
            $apiRespone = $json_bigsub->success;
          }

          $mobilNet = $provider;

          if ($apiRespone == '101' or $apiRespone === 'true' or $apiRespone === 'successful' or $apiRespone == '200' or $apiRespone == '000') {

            $stat = "Completed";


            // debit account
            UserdebitWallet($conn, $newBalc, $upp_cas_lx);

            response(101, array("Status" => 'successful', "ProductName" => $valu, "Network" => $mobilNet, "TransactionRef" => $requestId, "Date" => $dateTime));
          } else {

            response(105, array("response_description" => "Failed"));
            $stat = "Failed";
          }


          $addQuery = $conn->query("INSERT INTO transactions (network,serviceid,channel,phone,amount,charge,ref,status,date,email,customer,newBal,servicetype) VALUES('$valu','$Dataplan','$channel','$MobileNumber','$apiprice_fetch','$apiprice_fetch','$requestId','$stat','$dateTime','$UserEmail','$fname $lname','$newBalc',$servicetype')");
        } else {
          response(104, "TRANSACTION ID ALREADY EXIST");
        }
      }
      // echo low balance
      else {

        response(102, "LOW BALANCE");
      }
    } else {

      response(112, "This service is currently unavailable");
    }

    // close account not found
  } else {

    response(103, "INVALID ACCOUNT");
  }




  //check negative value;

} else {

  response(400, "INVALID REQUEST METHOD [Request Method must be POST]");
}


function response($status, $status_message)
{


  $response['code'] = $status;
  $response['description'] = $status_message;


  $json_response = json_encode($response);
  echo $json_response;
}

function fetchPackage($conn, $Dataplan, $serviceID)
{
  $qryPlan = $conn->query("SELECT * FROM data_package WHERE clientcode='$Dataplan' AND network='$serviceID'");
  while ($prow[] = $qryPlan->fetch_assoc()) {
  }
  return json_encode($prow);
}

function fetchUser($conn, $UserEmail)
{
  $qryUser = $conn->query("SELECT * FROM users WHERE email='$UserEmail'");
  while ($row[] = $qryUser->fetch_assoc()) {
  }
  return json_encode($row);
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
  file_put_contents('resp.txt', $response);
  return $response;
}


function shagoPay($conn, $plan_fetch, $Dataplan, $code_fetch, $phone, $requestId, $provider)
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
    'serviceCode' => "BDA",
    'phone' => $phone,
    'amount' => $Dataplan,
    'bundle' => $plan_fetch,
    'network' => strtoupper($provider),
    'package' => $code_fetch,
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

function vtpass($conn, $provider, $phone, $code_fetch, $requestId, $Dataplan)
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
      'serviceID' => $provider, //integer e.g gotv,dstv,eko-electric,abuja-electric
      'billersCode' => $phone, // e.g smartcardNumber, meterNumber,
      'variation_code' => $code_fetch, // e.g dstv1, dstv2,prepaid,(optional for somes services)
      'amount' =>  $Dataplan, // integer (optional for somes services)
      'phone' => $phone //integer
    ),
  ));
  $success_vtp = curl_exec($curl);
  $curl_errno = curl_errno($curl);
  curl_close($curl);
  //file_put_contents('res.txt',$success_vtp.'/'.$userprice_fetch);
  return $success_vtp;
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

function Alrahuz($conn, $networkcode, $phone, $code_fetch)
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
      "network" => strval(intval($networkcode)),
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

function gongoz($conn, $networkcode, $phone, $code_fetch)
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
      "network" => strval(intval($networkcode)),
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

function husmoApi($conn, $serviceID, $phone, $code_fetch)
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
      "network" => strval(intval($serviceID)),
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
  file_put_contents('res.txt', $Husresponse);
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
  $query_MapiS = $conn->query("SELECT * FROM data_package WHERE plancode='$code_fetch'");
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

function zoeDataHub($conn, $networkcode, $phone, $code_fetch)
{
  function zoekey($conn)
  {
    $query_zoe = $conn->query("SELECT * FROM providers_api_key WHERE provider='zoedatahub'");
    $zoekey = $query_zoe->fetch_assoc();
    // return json_encode($husmkey);
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
      "network" => strval(intval($networkcode)),
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
