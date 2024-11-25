<?php 
 //paystack
$request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);

$curl = curl_init();

$email = $username;
$amount = "$chargeAmt"."00";  //the amount in kobo. This value is actually NGN 300
$callback_url = "https://$request_dir/edustack.php";

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount'=>$amount,
    'email'=>$email,
    'callback_url' => $callback_url,
  ]),
  CURLOPT_HTTPHEADER => [
    "authorization: Bearer $pstak", //replace this with your own test key
    "content-type: application/json",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response, true);

if(!$tranx->status){
  // there was an error from the API
  
}

$_SESSION['transid'] = $requestId;
// redirect to page so User can pay
// uncomment this line to allow the user redirect to the payment page
//header('Location: ' . $tranx['data']['authorization_url']);

echo '<script> 
window.location=" '.$tranx['data']['authorization_url'].' "; </script>';

?>