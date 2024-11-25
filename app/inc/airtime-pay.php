<?php
$apidata =  json_decode(Apikeys($conn));
$secretSMEplx = $apidata->smeplugkey;
$apikey = $apidata->APIkey;
$UserID = $apidata->clubId;
$husmokey = $apidata->husmodata;
$DisKey = $apidata->clubkey;
$gongokey = $apidata->gongoz;
$alrahuzkey = $apidata->alrahuz;
$smartKey = $apidata->smartkey;
$mobilekey = $apidata->mobilekey;
$mobileID = $apidata->mobileID;
$callb = $_SERVER['SERVER_NAME'];
$apiMulti = json_decode(Apidefault($conn, $code_fetch));
$simPIN = $apiMulti->simPin;
if ($apiMulti->gateway === 'epins') {

  $resultepin = json_decode(epinApi($conn, $apikey, $network, $phone, $code_fetch, $requestId));
  $apiRespone = $resultepin->code;
} elseif ($apiMulti->gateway === 'clubkonnect') {

  $resultclub = json_decode(clubAPi($conn, $UserID, $DisKey, $network, $code_fetch, $phone, $requestId, $callb));
} elseif ($apiMulti->gateway === 'mobileng') {
  $resultmob = json_decode(mobilng($conn, $mobileID, $mobilekey, $networkcode, $phone, $code_fetch, $requestId));
  $apiRespone = $resultmob->code;
} elseif ($apiMulti->gateway === 'smeplug') {
  smeplug($conn, $smeplugnet_id, $code_fetch, $phone, $secretSMEplx);
} elseif ($apiMulti->gateway == 'husmodata') {
  $resulthusm = json_decode(husmoApi($conn, $networkcode, $phone, $code_fetch, $husmokey));
  $apiRespone = $resulthusm->Status;
} elseif ($apiMulti->gateway === 'gongoz') {
  $resultgo = json_decode(gongoz($conn, $networkcode, $phone, $code_fetch, $gongokey));
  $apiRespone = $resultgo->Status;
} elseif ($apiMulti->gateway === 'alrahuz') {
  $resultal = json_decode(Alrahuz($conn, $networkcode, $phone, $code_fetch, $alrahuzkey));
  $apiRespone = $resultal->Status;
} elseif ($apiMulti->gateway === 'smartrecharge') {

  $resultsmt = json_decode(smartRecharge($conn, $smartKey, $code_fetch, $phone, $callb));
} elseif ($apiMulti->gateway === 'n3t') {
  $resultn3t = json_decode(n3t($conn, $phone, $userprice_fetch, $n3code, $requestId));
  $apiRespone = $resultn3t->status;
} elseif ($apiMulti->gateway === 'simhost') {


  if ($network == '01') {


    $ch = curl_init("https://simhostng.com/api/ussd?");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
      'apikey' => $apiMulti['simkey'],
      'server' => $apiMulti['serverMTN'],
      'sim' => '1',
      'number' => '*605*2*1*' . $phone . '*' . $variation_code . '*' . $simPIN . '#',
      'ref' => $requestId,
      'url' => $callb
    ));
    $response = curl_exec($ch);
    curl_close($ch);
  }


  if ($network == '04') {

    $ch = curl_init("https://simhostng.com/api/ussd?");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
      'apikey' => $apiMulti['simkey'],
      'server' => $apiMulti['serverAirtel'],
      'sim' => '1',
      'number' => '*141*6*2*1*7*1*' . $phone . '*1121#',
      'ref' => $requestId,
      'url' => $callb
    ));
    $response = curl_exec($ch);
    curl_close($ch);
  }

  if ($network == '02') {

    $ch = curl_init("https://simhostng.com/api/ussd?");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
      'apikey' => $apiMulti['simkey'],
      'server' => $apiMulti['serverGlo'],
      'sim' => '1',
      'number' => '*229*2*36*' . $phone . '#',
      'ref' => $requestId,
      'url' => $callb
    ));
    $response = curl_exec($ch);
    curl_close($ch);
  }


  if ($network == '03') {

    $ch = curl_init("https://simhostng.com/api/ussd?");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
      'apikey' => $apiMulti['simkey'],
      'server' => $apiMulti['serverEtisalat'],
      'sim' => '1',
      'number' => '*229*2*36*' . $phone . '#',
      'ref' => $requestId,
      'url' => $callb
    ));
    $response = curl_exec($ch);
    curl_close($ch);
  }
}















function smartRecharge($conn, $smartKey, $code_fetch, $phone, $callb)
{
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

function Alrahuz($conn, $networkcode, $phone, $code_fetch, $alrahuzkey)
{
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
      "network" => $mobNet,
      "mobile_number" => $phone,
      "plan" => $code_fetch,
      "Ported_number" => true
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

function gongoz($conn, $networkcode, $phone, $code_fetch, $gongokey)
{
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
      "network" => $networkcode,
      "mobile_number" => $phone,
      "plan" => $code_fetch,
      "Ported_number" => true
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

function husmoApi($conn, $networkcode, $phone, $code_fetch, $husmokey)
{
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
      "network" => $networkcode,
      "mobile_number" => $phone,
      "plan" => $code_fetch,
      "Ported_number" => true
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

function smeplug($conn, $smeplugnet_id, $code_fetch, $phone, $secretSMEplx)
{
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
      "Authorization: Bearer $secretSMEplx"
    ),
  ));

  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}

function Apidefault($conn, $code_fetch)
{
  $query_MapiS = $conn->query("SELECT * FROM airtime_package WHERE network='$code_fetch'");
  $api_defualt = $query_MapiS->fetch_assoc();
  return json_encode($api_defualt);
}


function Apikeys($conn)
{
  $qryApi = $conn->query("SELECT * FROM api_setting");
  $Allapi = $qryApi->fetch_assoc();
  return json_encode($Allapi);
}

function epinApi($conn, $apikey, $network, $phone, $code_fetch, $requestId)
{
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/sme-data/?");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $apikey,
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

function clubAPi($conn, $UserID, $DisKey, $network, $code_fetch, $phone, $requestId, $callb)
{
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://www.nellobytesystems.com/APIDatabundleV1.asp?UserID=$UserID&APIKey=$DisKey&MobileNetwork=$network&DataPlan=$code_fetch&MobileNumber=$phone&RequestID=$requestId&CallBackURL=$callb ");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  $resdata = curl_exec($ch);
  //Close the cURL handle.
  curl_close($ch);
  return   $resdata;
}

function mobilng($conn, $mobileID, $mobilekey, $mobNet, $phone, $code_fetch, $requestId)
{
  //Initialize cURL.
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://mobileairtimeng.com/httpapi/datashare?userid=$mobileID&pass=$mobilekey&network=$mobNet&phone=$phone&datasize=$code_fetch&jsn=json&user_ref=$requestId");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  $resdata = curl_exec($ch);
  //Close the cURL handle.
  curl_close($ch);
  return $resdata;
}

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
  return  $n3tRes;
}
