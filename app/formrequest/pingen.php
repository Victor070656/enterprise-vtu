<?php
session_start();
date_default_timezone_set('Africa/Lagos');
$dat = date("Y-m-d h:i:s");

$error = array();
$resp = array();

$token = sanitize_input($_REQUEST['_tok']);
$cardname = sanitize_input($_REQUEST['cardname']);
//////////////////////
if (empty($token)) {
  $error[] = "Transaction token is empty";
}

if (empty($cardname)) {
  $error[] = "Enter name on card";
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
$pinNo = $trans[0]['qty'];

if ($network == 'mtn') {
  $provider = "mtn";
  $img = 'Data-mtn.jpg';
  $networkcode = "01";
}
if ($network == 'glo') {
  $provider = "glo";
  $img = 'GLO-Data.jpg';
  $networkcode = "02";
}
if ($network == 'etisalat') {
  $provider = "9mobile";
  $img = '9mobile-Data.jpg';
  $networkcode = "04";
}
if ($network == 'airtel') {
  $provider = "airtel";
  $img = 'Airtel-Data.jpg';
  $networkcode = "03";
}


$reference = uniqid();
$stats = "Completed";
$channel = "Wallet";
$failstats = "Failed";
$servicetype = "epin";

$userDetails = json_decode(fetchUser($conn, $UserEmail), true);
$customNam = $userDetails[0]['firstname'] . ' ' . $userDetails[0]['lastname'];
$current_balance = floatval($userDetails[0]['bal']);
$userPhone = $userDetails[0]['phone'];
$UserIPAddress = $userDetails[0]['IPaddress'];
$varUserId = $userDetails[0]['email'];

$ftrow =  json_decode(fetchPackage($conn, $variation, $network), true);
$network_fetch = $ftrow[0]['network'];
$plan_fetch = $ftrow[0]['plan'];
$code_fetch = $ftrow[0]['code'];
$userprice_fetch = floatval($ftrow[0]['price_user']);
$apiprice_fetch = floatval($ftrow[0]['price_api']);


$merchantDetails =  json_decode(fetchmerchant($conn, $UserEmail), true);
$merchant_account_type = $merchantDetails[0]['plan'];
if ($merchant_account_type === 'Premium') {
  $totalDebit = strval(floatval($apiprice_fetch) * intval($pinNo));
} else if ($merchant_account_type === 'Classic') {
  $totalDebit = strval(floatval($userprice_fetch) * intval($pinNo));
}

$valu = strtoupper($provider) . ' ' . $plan_fetch;

if (strval($trans[0]['status']) !== 'Completed') {

  if (strval(floatval($totalDebit) <= floatval($current_balance))) {



    $newBalc =  strval(floatval($current_balance) - floatval($totalDebit));


    //$rp = json_decode(epins($conn,$codekey,$network,$variation,$pinNo,$requestId));

    // Generate PIN if  enough balance

    if (fetchPINs($conn, $network, $variation, $pinNo) < 1) {

      //try API

      $rp_gen = json_decode(epinsGen($conn, $provider, $variation, $pinNo, $requestId));
      //$responsecode = $rp->code;
      //$transId = $result->id;

      if ($rp_gen->code == '101') {

        $pins = $rp_gen->description->PIN;
        $xtrato = explode("\n", $pins);
        $counter = count($xtrato);

        UserdebitWallet($conn, $newBalc, $varUserId);
        StorePin($conn, $network, $variation, $pins, $UserEmail, $requestId, $cardname);
        UpdateTransaction($conn, $stats, $reference, $channel, $totalDebit, $newBalc, $dat, $requestId, $cardname, $servicetype);
        moveToPurchased($conn, $network, $variation, $pins, $UserEmail, $requestId);
        $printcardId = base64_encode($requestId);

        $_SESSION['net'] = $network;
        $_SESSION['var'] = $variation;
        $_SESSION['pin'] = $pins;
        $_SESSION['xtraEmail'] = $UserEmail;
        $_SESSION['cardname'] = $cardname;

        $resp['msg'] = "Transaction Successful";
        $resp['status'] = true;
        $resp['redirect'] = "../../airtime-pins.php";
        $resp['download'] = "p_xpo.php";
        $resp['print'] = "../../print-rechargecard?id=$printcardId";
        $resp['counter'] = $pinNo;
        $resp['network'] = $network;
        echo json_encode($resp);
        exit();
      } else {


        $error[] = strtoupper($provider) . ' ' . $plan_fetch . " currently unavailable";
        $resp['msg'] = $error;
        $resp['status'] = false;
        echo json_encode($resp);
        exit();
      }
    } else if (fetchPINs($conn, $network, $variation, $pinNo) >= $pinNo) {


      $qryPinstock = $conn->query("SELECT * FROM pinstock WHERE net='$provider' AND deno='$variation' LIMIT $pinNo");

      while ($row_pin = $qryPinstock->fetch_assoc()) {
        $mypin[] =  $row_pin['pins'];
        $spac = implode("\n", $mypin);
        $pins =   $spac;
      }
      $explo = explode("\n", $pins);
      $count = count($explo);
      UserdebitWallet($conn, $newBalc, $varUserId);
      StorePin($conn, $network, $variation, $pins, $UserEmail, $requestId, $cardname);
      UpdateTransaction($conn, $stats, $reference, $channel, $totalDebit, $newBalc, $dat, $requestId, $cardname, $servicetype);
      $printcardId = base64_encode($requestId);
      if (moveToPurchased($conn, $network, $variation, $pins, $UserEmail, $requestId)) {

        $_SESSION['net'] = $network;
        $_SESSION['var'] = $variation;
        $_SESSION['pin'] = $pins;
        $_SESSION['xtraEmail'] = $UserEmail;
        $_SESSION['cardname'] = $cardname;

        foreach ($explo as $cutpin) {
          $subtrPin = $conn->query("DELETE FROM pinstock WHERE pins='$cutpin'");
        }

        $resp['msg'] = "Transaction Successful";
        $resp['status'] = true;
        $resp['redirect'] = "../../airtime-pins.php";
        $resp['download'] = "p_xpo.php";
        $resp['print'] = "../../print-rechargecard?id=$printcardId";
        $resp['counter'] = $pinNo;
        $resp['network'] = $network;
        echo json_encode($resp);
        exit();
      } else {

        $error[] = strtoupper($provider) . ' ' . $plan_fetch . " PIN generation failed";
        $resp['msg'] = $error;
        $resp['status'] = false;
        echo json_encode($resp);
        exit();
      }
      ///////////////////////////////////////////////////////////////////////////
    } else {

      //try API    

      $rp_gen = json_decode(epinsGen($conn, $provider, $variation, $pinNo, $requestId));
      //$responsecode = $rp_gen->code;
      //$transId = $result->id;

      if ($rp_gen->code == '101') {

        $pins = $rp_gen->description->PIN;
        $xtrato = explode("\n", $pins);
        $counter = count($xtrato);

        UserdebitWallet($conn, $newBalc, $varUserId);
        StorePin($conn, $network, $variation, $pins, $UserEmail, $requestId, $cardname);
        UpdateTransaction($conn, $stats, $reference, $channel, $totalDebit, $newBalc, $dat, $requestId, $cardname, $servicetype);
        moveToPurchased($conn, $network, $variation, $pins, $UserEmail, $requestId);
        $printcardId = base64_encode($requestId);

        $_SESSION['net'] = $network;
        $_SESSION['var'] = $variation;
        $_SESSION['pin'] = $pins;
        $_SESSION['xtraEmail'] = $UserEmail;
        $_SESSION['cardname'] = $cardname;

        $resp['msg'] = "Transaction Successful";
        $resp['status'] = true;
        $resp['redirect'] = "../../airtime-pins.php";
        $resp['download'] = "p_xpo.php";
        $resp['print'] = "../../print-rechargecard?id=$printcardId";
        $resp['counter'] = $pinNo;
        $resp['network'] = $provider;
        echo json_encode($resp);
        exit();
      } else {


        UpdateFailedTransaction($conn, $reference, $channel, $userprice_fetch, $current_balance, $dat, $requestId, $failstats);

        $error[] = "Insufficient quantity";
        $resp['msg'] = $error;
        $resp['status'] = false;
        echo json_encode($resp);
        exit();
      }
    }


    //End requery


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


function fetchPINs($conn, $network, $variation, $pinNo)
{
  $qryPins = $conn->query("SELECT * FROM pinstock WHERE net='$network' AND deno='$variation' LIMIT $pinNo");
  $rowpin = $qryPins->num_rows;
  return $rowpin;
}

function fetchmerchant($conn, $UserEmail)
{
  $qryMercht =  $conn->query("SELECT * FROM pin_merchants WHERE merchantid='$UserEmail' AND status='ACTIVE'");
  while ($rowmach[] = $qryMercht->fetch_assoc()) {
  }
  return json_encode($rowmach);
}
function moveToPurchased($conn, $variation, $pins, $UserEmail, $requestId)
{
  $storePurchased = $conn->query("INSERT INTO purchased_pin(network,category,pins,email,ref) VALUES('$network','$variation','$pins','$UserEmail','$requestId')");
  return $storePurchased;
}

function fetchPackage($conn, $variation, $network)
{
  $qryPlan = $conn->query("SELECT * FROM pins_package WHERE code='$variation' AND network='$network'");
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
  $stmtDeb->bind_Param("ds", $newBalc, $varUserId);
  $result_debit =   $stmtDeb->execute();
  return $result_debit;
}

function UpdateTransaction($conn, $stats, $reference, $channel, $totalDebit, $newBalc, $dat, $requestId, $cardname, $servicetype)
{
  $stmtTrUpd = $conn->prepare("UPDATE transactions SET status=?,token=?,channel=?,charge=?,newBal=?,date=?,amount=?,cardname=?,servicetype=? WHERE ref=?");
  $stmtTrUpd->bind_Param("ssssssssss", $stats, $reference, $channel, $totalDebit, $newBalc, $dat, $totalDebit, $cardname, $servicetype, $requestId);
  $resTran = $stmtTrUpd->execute();
  return $resTran;
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


function StorePin($conn, $network, $variation, $pins, $UserEmail, $requestId, $cardname)
{
  $sto = $conn->query("INSERT INTO mypin (net,cat,pins,email,ref,cardname)VALUES('$network','$variation','$pins','$UserEmail','$requestId','$cardname')");
  return $sto;
}



function epinsGen($conn, $provider, $variation, $pinNo, $requestId)
{
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
  function fetchEpin($conn)
  {
    $query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
    $fetchepkey = $query_ep->fetch_assoc();
    return json_encode($fetchepkey);
  }
  $json_ep = json_decode(fetchEpin($conn));
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, urlbasemain() . "/" . "epin/");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    'apikey' => $json_ep->privatekey,
    'service' => 'epin',
    'network' => $provider,
    'pinDenomination' => $variation,
    'pinQuantity' => $pinNo,
    'ref'  => $requestId
  )));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
  ));
  $EPIN_response = curl_exec($ch);
  curl_close($ch);
  file_put_contents('res.txt', $EPIN_response);
  return $EPIN_response;
}
