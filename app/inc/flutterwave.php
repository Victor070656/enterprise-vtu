<?php
//RavePay
$sitename = $_SERVER['HTTP_HOST'];
$sitset = $conn->query("SELECT * FROM settings");
$rowsit = $sitset->fetch_assoc();
$request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);
$siteLogo = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/sitelogo/'.$rowsit['sitelogo'];
$curl = curl_init();
$amount = $xamount;  
$currency = "NGN";
$email = $data[0]['email'];
function flw($conn){
$query_flw = $conn->query("SELECT * FROM providers_api_key WHERE provider='flutterwave'");
$flwkey = $query_flw->fetch_assoc();
return json_encode($flwkey);
}    
$json_flw = json_decode(flw($conn));
$txref = $uid; // ensure you generate unique references per transaction.
// get your public key from the dashboard.
$redirect_url = "https://$request_dir/flutterwavecheck.php";
$payment_plan = "pass the plan id"; // this is only required for recurring payments.
$custom_title = "Wallet Funding";


$customerName = $fname ." ". $lname;

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.flutterwave.com/v3/payments",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode(
  [
   "tx_ref" => $txref,
   "amount" => $amount,
   "currency" => $currency,
   "redirect_url" =>$redirect_url,
   "customer" => ["email" => $email,
                "phonenumber" =>$phon,
                "name" => $customerName],
                
    "customizations" => [
       "title" =>  $custom_title,
       "logo" => $siteLogo
        ]            
   
      ]
  
  ),
  CURLOPT_HTTPHEADER => [
    "content-type: application/json",
    "Authorization: Bearer ".$json_flw->secretkey
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








 ?>