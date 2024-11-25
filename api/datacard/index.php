<?php
date_default_timezone_set('Africa/Lagos');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, HEAD");
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // get posted data
  $get_data = json_decode(file_get_contents("php://input"));
  if (isset($get_data)) {
    $apikey = $conn->real_escape_string(test_input($get_data->apikey));
    $serviceID = $conn->real_escape_string(test_input($get_data->service));
    $networkID = $conn->real_escape_string(test_input($get_data->network));
    $qty = $conn->real_escape_string(test_input(floatval($get_data->pinQuantity)));
    $variation_code = $conn->real_escape_string(test_input($get_data->DataPlan));
    $requestId = $conn->real_escape_string(test_input($get_data->ref));
  } else {

    $apikey = $conn->real_escape_string(test_input($_REQUEST['apikey']));
    $serviceID = $conn->real_escape_string(test_input($_REQUEST['service']));
    $networkID = $conn->real_escape_string(test_input($_REQUEST['network']));
    $qty = $conn->real_escape_string(test_input(floatval($_REQUEST['pinQuantity'])));
    $variation_code = $conn->real_escape_string(test_input($_REQUEST['DataPlan']));
    $requestId = $conn->real_escape_string(test_input($_REQUEST['ref']));
  }
  $network = $networkID;
  $auth = "paid";

  // process request	
  if ($serviceID === 'datacard') {
    $servName = $_SERVER['HTTP_HOST'];

    $convee = '';

    $customer = '';

    $xname = '';

    $action = "Pay";

    $dateTime = date('Y-m-d h:i:A');
    $email = $user;
    $proc = '_pay-tv';
    $charge = '';

    $channel = "API";
    $view = "View";

    // check if the account is valid

    if ($param) {

      response(107, "BAD REQUEST");
    } else {

      $retr = "SELECT * FROM users WHERE apikey='$apikey' ";

      $exe = mysqli_query($conn, $retr);
      $rob = mysqli_fetch_array($exe);

      $user = $conn->real_escape_string($rob['apikey']);
      $aut = $conn->real_escape_string($rob['level']);
      $fname = $conn->real_escape_string($rob['firstname']);
      $lname = $conn->real_escape_string($rob['lastname']);
      $MobileNumber = $conn->real_escape_string($rob['phone']);
      $customer_fulname = $fname . ' ' . $lname;
      $arr = array("$apikey", "$auth");

      $pair = array("$user", "$aut");


      if ($arr === $pair) {

        // check if the user have balance

        $gb = mysqli_query($conn, "SElECT * FROM users WHERE apikey = '$user' ");
        $reco = mysqli_fetch_array($gb);

        $level = $conn->real_escape_string($reco['level']);
        $UserEmail = $conn->real_escape_string($reco['email']);
        //$upp_cas_lx = $reco['accno'];
        //extract account info
        $userDetails = json_decode(fetchUser($conn, $UserEmail), true);
        $customNam = $userDetails[0]['firstname'] . ' ' . $userDetails[0]['lastname'];
        $current_balance = floatval($userDetails[0]['bal']);
        $userPhone = $userDetails[0]['phone'];
        $UserIPAddress = $userDetails[0]['IPaddress'];
        $upp_cas_lx = $userDetails[0]['email'];


        if ($current_balance < 2000):

          // print Greetings($hours);   

          $user_balance_fomat = number_format($mid_wxpi, 2);

          function mailLowBalance($conn, $to, $subject, $message, $headers_mal, $sitname = null, $request_dir = null)
          {
            global $hosturl;
            global $UserEmail;
            global $hours;
            global $fname;
            global $user_balance_fomat;
            global $siteLogo;

            $from = "$sitname<no-reply@$hosturl>"; //the email address from which this is sent
            $to = $UserEmail; //the email address you're sending the message to
            $subject = "LOW WALLET BALANCE"; //the subject of the message

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

<a href='https://$hosturl'><strong>$sitname</strong></a> <p>

<strong>DISCLAIMER:</strong>
<p>
The message and its attachments are for the designated recipient(s) only and may contain privileged, proprietary and private information. If you have received it in error, kindly delete it and notify the sender immediately. $sitname accepts no liability for any damage resulting directly or indirectly from the transmission of this email message.
</body><html>";

            //now mail
            $DoMail_notify = mail($to, $subject, $message, $headers_mal);
          }
        //mailLowBalance($conn,$to,$subject,$message,$headers_mal,$sitname,$request_dir);
        endif;


        $ftrow =  json_decode(fetchPackage($conn, $variation_code, $serviceID, $network), true);
        $network_fetch = $ftrow[0]['network'];
        $datatype_fetch = $ftrow[0]['datatype'];
        $plan_fetch = $ftrow[0]['plan'];
        $code_fetch = $ftrow[0]['plancode'];
        $userprice_fetch = floatval($ftrow[0]['price_user']);
        $apiprice_fetch = floatval($ftrow[0]['price_api']);
        $gateway_fetch = $ftrow[0]['gateway'];
        $status_fetch = $ftrow[0]['status'];

        if ($status_fetch !== 'disabled') {

          $valu = strtoupper($serviceID) . ' ' . $plan_fetch;
          $servicetype = "datacard";

          $totalDebit = strval(floatval($apiprice_fetch) * intval($qty));
          $newBalc =  strval(floatval($current_balance) - floatval($totalDebit));

          if (floatval($totalDebit) <= floatval($current_balance)) {

            // maximum PIn generator allowed at once

            if ($qty <= 5) {

              $req = mysqli_query($conn, "SElECT * FROM transactions WHERE ref = '$requestid' ");
              $nu = mysqli_num_rows($req);

              if ($nu == 0) {

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

                if ($apiRespone == '101' or $apiRespone === 'success' or $apiRespone === 'successful') {
                  $proces = "TRANSACTION SUCCESSFUL";
                  $stat = "Completed";
                  // debit account
                  UserdebitWallet($conn, $newBalc, $upp_cas_lx);

                  response(101, array("status" => $proces, "PIN" => $pins, "network" => $Telcos, "pinDenomination" => $variation_code, "pinQuantity" => $qty, "product_name" => $valu, "TransactionDate" => $dateTime));
                } else {

                  response(105, array("response_description" => "Failed"));
                  $stat = "Failed";
                }

                $Record_Qry = $conn->query("INSERT INTO transactions(network,serviceid,channel,phone,amount,charge,ref,status,date,email,customer,newBal,transID,metertoken,servicetype) VALUES('$valu','$variation_code','$channel','$MobileNumber','$debit','$debit','$requestId','$stat','$dateTime','$email','$customer_fulname','$newBalc','$transId','$pins','$serviceID')");
              } else {
                response(104, "TRANSACTION ID ALREADY EXIST");
              }

              // end maximum pins to generate
            } else {
              response(109, "Maximum PINs to generate per transaction is 5");
            }
          }
          // echo low balance
          else {

            response(102, "LOW BALANCE");

            mailLowBalance($conn, $to, $subject, $message, $headers_mal);
          }
        } else {

          response(112, "This service is currently unavailable");
        }
        // close account not found
      } else {

        response(103, "Invalid or missing APIKEY");
      }
    } // close wrong parameter

  } else {

    response(108, "WRONG SERVICE TYPE [Service type must be datacard ]");
  }
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


function fetchPackage($conn, $variation_code, $serviceID, $network)
{
  $qryPlan = $conn->query("SELECT * FROM data_package WHERE clientcode='$variation_code' AND datatype='$serviceID' AND network='$network'");
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
  file_put_contents('res.txt', $EPINresponse);
  return $EPINresponse;
}

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
  file_put_contents('res.txt', $n3tRes);
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

  file_put_contents('res.txt', $Husresponse);
  return $Husresponse;
}
