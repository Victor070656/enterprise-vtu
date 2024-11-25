<?php
date_default_timezone_set('Africa/Lagos');
require_once('../Connections/dbQuery.php');
include('../function/build.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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
  $Rawdata = json_decode(file_get_contents('php://input'));

  if (!isset($Rawdata)) {
    $apikey = test_input($conn->real_escape_string($_REQUEST['apikey']));
    $network = test_input($conn->real_escape_string(strtolower($_REQUEST['network'])));
    $Destination_Number = test_input($conn->real_escape_string($_REQUEST['phone']));
    $phone = str_replace(' ', '', $Destination_Number);
    $amountPayee = test_input($conn->real_escape_string(floatval($_REQUEST['amount'])));
    $ref = test_input($conn->real_escape_string($_REQUEST['ref']));
  } else {

    $apikey = test_input($conn->real_escape_string($Rawdata->apikey));
    $network = test_input($conn->real_escape_string(strtolower($Rawdata->network)));
    $Destination_Number = test_input($conn->real_escape_string($Rawdata->phone));
    $phone = str_replace(' ', '', $Destination_Number);
    $amountPayee = test_input($conn->real_escape_string(floatval($Rawdata->amount)));
    $ref = test_input($conn->real_escape_string($Rawdata->ref));
  }

  $requestId = $ref;
  $auth = "paid";

  $validphone = preg_replace("/[^0-9]/", '', $phone);
  if (strlen($validphone) == 11) {

    if (is_numeric($amountPayee) == true) {

      $amount = max(0, $amountPayee);

      if ($amount == 0) {

        response(107, "BAD REQUEST");
      } else {

        // process request

        $convee = NULL;

        $customer = NULL;

        $xname = NULL;

        $action = "Pay";

        $email = $conn->real_escape_string($user);
        $proc = '_pay-tv';
        $charge = '';
        $billersCode = $validphone;
        $serviceID = 'Airtime';
        $channel = "API";
        $view = "View";

        // check if the account is valid

        if ($param) {

          response(107, "BAD REQUEST");
        } else {

          $retr = mysqli_query($conn, "SELECT * FROM users WHERE apikey='$apikey' ");

          $rob = mysqli_fetch_array($retr);

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

            $userDetails = json_decode(fetchUser($conn, $UserEmail), true);
            $customNam = $userDetails[0]['firstname'] . ' ' . $userDetails[0]['lastname'];
            $current_balance = floatval($userDetails[0]['bal']);
            $userPhone = $userDetails[0]['phone'];
            $UserIPAddress = $userDetails[0]['IPaddress'];
            $upp_cas_lx = $userDetails[0]['email'];

            //////////////////Low balance Notification ////////////////

            if ($current_balance < 2000):

              // print Greetings($hours);   

              $user_balance_fomat = number_format(floatval($current_balance), 2);

              $from = "$sitname<no-reply@$hosturl>"; //the email address from which this is sent
              $to = "$UserEmail"; //the email address you're sending the message to
              $subject = "Reseller Low Balance"; //the subject of the message

              // To send HTML mail, the Content-type header must be set
              $headers_mal = "";
              $headers_mal .= 'MIME-Version: 1.0' . "\r\n";
              $headers_mal .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
              $headers_mal .= "X-Priority: 3\r\n";
              $headers_mal .= "Return-Path: $sitname<support@$hosturl>\r\n";
              $headers_mal .= "Organization: $sitname\r\n";

              // Create email headers
              $headers_mal .= 'From: ' . $from . "\r\n" .
                'Reply-To: ' . $from . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

              $message = "

<html>
<head>
<style>
.table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 50%;
}

td {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}


.button {
  background-color: #008CBA; /* Blue */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  border-radius: 8px;
  cursor: pointer;
  
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
}

.button:hover {
  background-color: #4CAF50; /* Green */
  color: white;
}

</style>
</head>

<body>

<img src='https://$request_dir/sitelogo/$siteLogo'>

<h3>" . Greetings($hours) . " $fname,</h3>

Your $sitname wallet balance is low <br>
Fund your account to continue your transactions.

<hr>
<strong>Current Balance: ₦$user_balance_fomat</strong> <p>
<hr>

<p>


Regards, <p>

<a href='https://$request_dir'><strong>$sitname</strong></a> <p>

<strong>DISCLAIMER:</strong>
<p>
The message and its attachments are for the designated recipient(s) only and may contain privileged, proprietary and private information. If you have received it in error, kindly delete it and notify the sender immediately. $sitname accepts no liability for any damage resulting directly or indirectly from the transmission of this email message.
</body><html>";

              //now mail
              $DoMail_notify = mail($to, $subject, $message, $headers_mal);

            endif;

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

            $ftrow =  json_decode(fetchPackage($conn, $network), true);
            $network_fetch = $ftrow[0]['network'];
            $apiprice_fetch = floatval($ftrow[0]['discount']);
            $gateway_fetch = $ftrow[0]['gateway'];
            $userprice_fetch = $amount;

            $productName = strtoupper($network) . ' ' . 'Airtime VTU';
            $comi = strval(floatval($apiprice_fetch / 100) * floatval($amount));
            $todebit = strval(floatval($amount) - floatval($comi));
            $newBalc =  strval(floatval($current_balance) - floatval($todebit));

            $dateTime = date('Y-m-d h:i:A');

            $maxLimit = '10000';

            if (floatval($todebit) <= $current_balance) {

              // check if ref number exist

              $req = mysqli_query($conn, "SElECT * FROM transactions WHERE ref='$ref' ");
              $nu = mysqli_num_rows($req);

              if ($nu == 0) {


                // check transaction limit

                if ($todebit <= $maxLimit) {


                  if ($gateway_fetch === 'vtpass') {
                    $vtpcode = json_decode(vtpay($conn, $request_Format, $network, $userprice_fetch, $phone));
                  } else if ($gateway_fetch === 'shago') {
                    $shagocode = json_decode(Shagopay($conn, $phone, $userprice_fetch, $network, $requestId));
                  } else if ($gateway_fetch === 'epins') {

                    $epins_code = json_decode(epinAirtime($conn, $network, $phone, $userprice_fetch, $requestId));
                  } else if ($gateway_fetch === 'clubkonnect') {

                    $clubcode = json_decode(ClubKonet($conn, $networkcode, $userprice_fetch, $phone, $requestId, $callb));
                  } else if ($gateway_fetch === 'n3tdata') {
                    $n3t_json = json_decode(n3t($conn, $phone, $userprice_fetch, $n3code, $requestId));
                  } else if ($gateway_fetch === 'husmodata') {
                    $husmo_json = json_decode(husmo($conn, $networkcode, $userprice_fetch, $phone));
                  } else if ($gateway_fetch === 'zoedatahub') {

                    $zoe_json = json_decode(zoedata($conn, $networkcode, $userprice_fetch, $phone));
                  } else if ($gateway_fetch === 'bigsub') {
                    $bigSub_js = json_decode(BigSub($conn, $phone, $userprice_fetch, $network));
                  }
                }

                // close number rejected

                //if($resp->status === '200' or $resp->code === '000'){

                if ($epins_code->code == '101' or $vtpcode->code === '000' or $shagocode->status == '200' or $clubcode->statuscode == '100' or $n3t_json->status === 'success' or $husmo_json->Status === 'successful' or $zoe_json->Status === 'successful' or $bigSub_js->success === 'true') {

                  $stat = "Completed";
                  // debit account
                  UserdebitWallet($conn, $newBalc, $upp_cas_lx);
                  response(101, array("response_description" => "TRANSACTION SUCCESSFUL", "ref" => $ref, "amount" => $amount, "transaction_date" => $dateTime));
                } else {

                  response(105, array("response_description" => "Failed"));
                  $stat = "Failed";
                }
                // end response failed

                $add_query = $conn->query("INSERT INTO transactions(network,serviceid,channel,phone,amount,charge,ref,date,status,email,customer,newBal) VALUES('$productName','$serviceID','$channel','$billersCode','$amount','$todebit','$ref','$dateTime','$stat','$UserEmail','$fname $lname','$newBalc')");
              } else {
                response(104, "TRANSACTION ID ALREADY EXIST");
              }
            }
            // echo low balance
            else {

              response(102, "LOW BALANCE");
            }

            // close account not found
          } else {

            response(103, "INVALID ACCOUNT");
          }
        }
        // close wrong parameter

      }
      //end process request
    } else {
      response(107, "BAD REQUEST");
    }
  } else {

    response(403, "INVALID ENTRY  ");
  }
} else {

  response(400, "INVALID REUEST METHOD");
}


function response($status, $status_message)
{

  $response['code'] = $status;
  $response['description'] = $status_message;


  $json_response = json_encode($response);
  echo $json_response;
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
  file_put_contents('airtime.txt', $ShagoRes);
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
  file_put_contents('test.txt', $veridata);
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
  file_put_contents('airtime.txt', $n3tRes);
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
      "network" => strval(intval($networkcode)),
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
  file_put_contents('airtime.txt', $Husresponse);
  return $Husresponse;
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
  file_put_contents('airtime.txt', $ZoeResponse);
  // file_put_contents('airtime.txt', $Husresponse);
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
  file_put_contents('airtime.txt', $BigSubResponse);
  return  $BigSubResponse;
}
