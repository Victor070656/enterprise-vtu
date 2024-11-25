<?php

if ($gateway_fetch === 'epins') {

  $rp = json_decode(FetchDCepin($conn, $network, $qty, $variation_code, $requestId));
  $apiRespone = $rp->code;

  $pins = $rp->description->PIN;
  $xtrato = explode("\n", $pins);
  $counter = count($xtrato);

  //echo $EPINresponse;

} else if ($gateway_fetch === 'n3tdata') {

  $json_n3t = json_decode(n3t($conn, $network, $variation_code, $qty));

  $apiRespone = $json_n3t->status;
  $pins  = ltrim($json_n3t->pin);

  $transId = $json_n3t->transid;
  //$printcardId = base64_encode($transId); 

  $xtrato = explode("\n", $pins);
  $counter = count($xtrato);
} else if ($gateway_fetch === 'husmodata') {

  $json_husdc = json_decode(husmoApi($conn, $variation_code, $qty));
  $apiRespone = $json_husdc->Status;

  foreach ($json_husdc->data_pins as $j) {
    for ($i = 0, $p = count($j); $i < $p; $i++) {
      $genpin[] = rtrim($j->fields->pin);
      $pins = implode("\n", $genpin);
    }
  }

  $xtrato = explode("\n", $pins);
  $counter = count($xtrato);
}


//file_put_contents('pinresponse.txt',$pins);

$_SESSION['pin'] = $pins;
$_SESSION['var'] = $valu;
$_SESSION['qty'] = $qty;
$_SESSION['net'] = $network;
$_SESSION['cat'] = $variation_code;
$_SESSION['uemail'] = $email;




function FetchDCepin($conn, $network, $qty, $variation_code, $requestId)
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
  function fetchEpin($conn)
  {
    $query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
    $fetchepkey = $query_ep->fetch_assoc();
    return json_encode($fetchepkey);
  }
  $json_ep = json_decode(fetchEpin($conn));

  // Generate PIN if  enough balance
  //function epins(){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, urlbasemain() . "/" . "datacard/");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    'apikey' => $json_ep->privatekey,
    'service' => 'datacard',
    'network' => $network,
    'pinQuantity' => $qty,
    'DataPlan' => $variation_code,
    'ref'  => $requestId
  )));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",

  ));

  $EPINresponse = curl_exec($ch);
  curl_close($ch);

  return $EPINresponse;
}

// function n3t($conn, $network, $variation_code, $qty)
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
//   curl_setopt($ch, CURLOPT_URL, "https://n3tdata.com/api/data_card");
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//   curl_setopt($ch, CURLOPT_HEADER, FALSE);
//   curl_setopt($ch, CURLOPT_POST, TRUE);
//   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
//     array(
//       'network' => strval(intval($network)),
//       'plan_type' => $variation_code,
//       'quantity' => $qty,
//       'card_name' => 'markerapi',
//     )

//   ));
//   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//     "Content-Type: application/json",
//     "Authorization: Token $n3_accesscode "
//   ));
//   $n3tRes = curl_exec($ch);
//   curl_close($ch);
//   file_put_contents('datacard.txt', $n3tRes);
//   return  $n3tRes;
// }

function n3t($conn, $network, $variation_code, $qty)
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
  curl_setopt($ch, CURLOPT_URL, "https://n3tdata.com/api/data_card");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  curl_setopt($ch, CURLOPT_POST, TRUE);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
    array(
      'network' => strval(intval($network)),
      'plan_type' => $variation_code,
      'quantity' => $qty,
      'card_name' => 'Ateeku',
    )

  ));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Authorization: Token $n3_accesscode "
  ));
  $n3tRes = curl_exec($ch);
  curl_close($ch);
  file_put_contents('datacard.txt', $n3tRes);
  return  $n3tRes;
}


function husmoApi($conn, $variation_code, $qty)
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
    CURLOPT_URL => 'https://husmodataapi.com/api/datarechargepin/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "data_plan" => $variation_code,
      "quantity" => $qty,
      "name_on_card" => 'markersapi'
    )),
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Token " . $json_hus->privatekey
    ),
  ));

  $Husresponse = curl_exec($curl);
  curl_close($curl);

  file_put_contents('datacard.txt', $Husresponse);
  return $Husresponse;
}
