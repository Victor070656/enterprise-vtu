<?php
session_start();
require('db.php');
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
header("location: index.php");
  exit;
		}
								
	$user = $_SESSION['user'];
								
	$ins = mysqli_query($conn,"SELECT * FROM users WHERE email='$user' ");
	$data = mysqli_fetch_array($ins);
								
	$email = $data['email'];
	$rowpas = $data['pass'];

	$succ = $_GET['reference'];
	
	$requestId = $_SESSION['transid'];
			
		$ret = "SELECT * FROM transactions WHERE ref='$requestId' ";
		$resut = $conn->query($ret);
		$da = $resut->fetch_row();
		$amount = $da[5];
		$tid = $da[7];							
					
					
		$query_rec = mysqli_query($conn,"SELECT * FROM api_setting");
			
			$apib = mysqli_fetch_array($query_rec); 
			
			$apikey =  $apib['APIkey'];			

 // confirm  payment    
$curl = curl_init();
$reference = isset($_GET['reference']) ? $_GET['reference'] : '';
if(!$reference){
  die('No reference supplied');
}

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "authorization: Bearer sk_live_3fef1bd27792b18c16219a2de30019602eca10ce",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);


if($err){
	// there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response);

if(!$tranx->status){
  // there was an error from the API
  die('API returned error: ' . $tranx->message);
}

if($tranx->data->status === 'success'){
    
                if($da[11] === $da[12] && $da[8] !== 'Paid'){
					$carier = $da[2];
					$phon = $da[4];
					
				$ch = curl_init();
                $url = "https://epins.com.ng/ap/api/airtime/?apikey=$apikey&network=$carier&phone=$phon&amount=$amount&ref=$tid";
                curl_setopt($ch, CURLOPT_URL, $url); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, '3');
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
                $content = trim(curl_exec($ch));
                                    
                curl_close($ch);
				
                // update
                $tk = md5(uniqid());
				$statu = "Completed";
                $r = $_GET['reference'];
                
				$up = "UPDATE transactions SET token='$tk',refer='$r',status='$statu' WHERE ref='$tid' ";
				$conn->query($up);
             
			 	$_SESSION['stat'] = "Completed";
				$_SESSION['amount'] = $amount;
				$_SESSION['carier'] = $carier;
				$_SESSION['transid'] = $tid;
				$_SESSION['product'] = $da[1];
				$_SESSION['phone'] = $da[4];
			 
                ?>
<script>window.location="transaction-details?ref='<?php echo $_GET['reference']?>' ";</script> <?php
 
    
  // transaction was successful...
  // please check other things like whether you already gave value for this ref
  // if the email matches the customer who owns the product etc
  // Give value
                }

}
         

?>