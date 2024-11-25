<?php
//RavePay
$sitename = $_SERVER['HTTP_HOST'];
$request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);
$curl = curl_init();

$customer_email = $data['email'];
$amount = $xamount;  
$currency = "NGN";
$txref = $uid; // ensure you generate unique references per transaction.
$PBFPubKey = $apib['flutterpub']; // get your public key from the dashboard.
$redirect_url = "http://$request_dir/raveairtime.php";
$payment_plan = "pass the plan id"; // this is only required for recurring payments.
$custom_title = "Airtime Purchase";


curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount'=>$amount,
    'customer_email'=>$customer_email,
    'currency'=>$currency,
    'txref'=>$txref,
    'PBFPubKey'=>$PBFPubKey,
    'redirect_url'=>$redirect_url,
    'customer_firstname' => $fname,
    'customer_lastname' => $lname,
    'customer_phone' => $phon,
    'custom_title' => $custom_title
  
  ]),
  CURLOPT_HTTPHEADER => [
    "content-type: application/json",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  // there was an error contacting the rave API
  die('Curl returned error: ' . $err);
}

$transaction = json_decode($response);

if(!$transaction->data && !$transaction->data->link){
  // there was an error from the API
  print_r('API returned error: ' . $transaction->message);
}

// uncomment out this line if you want to redirect the user to the payment page
//print_r($transaction->data->message);


// redirect to page so User can pay
// uncomment this line to allow the user redirect to the payment page


echo '<script> 
window.location.href=" '.$transaction->data->link.' "; </script>';

 ?>