<?php
function payBet($conn,$pinNumber,$reference,$amount,$accountName,$requestId){
    function fetchMarkers($conn){
$query_maks = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
$fetchmakey = $query_maks->fetch_assoc();
return json_encode($fetchmakey);
}    
$json_maks = json_decode(fetchMarkers($conn));
$curl       = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => urlbasemain()."/"."bet9ja/?",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_SSL_VERIFYPEER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_POSTFIELDS => json_encode(array(
    'apikey' => $json_maks->privatekey,
    'customerId'=> $pinNumber,
    'reference' => $reference,
    'amount' =>  $amount, 
    'customerName' => $accountName,
    'request_id' => $requestId
 	
)),
));
$success_bet = curl_exec($curl);
$curl_errno = curl_errno($curl);
curl_close($curl);
return $success_bet;
}

$result_bet = json_decode(payBet($conn,$pinNumber,$reference,$amount,$accountName,$requestId),true);
//Close the cURL handle.

$product ="Bet9ja Payment";
if($result_bet['code'] == '101'){
    
    $current_balance = strval(floatval($bal) - floatval($debit));
    	$qry_debit = $conn->query("UPDATE users SET bal='$current_balance' WHERE email='$user'");
$qsel = "UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet',amount='$xamount',charge='$debit' WHERE ref='$tref' ";	
$sav = $conn->query($qsel);

//credit commission wallet    
$Comacc = "UPDATE users SET cwallet=$apComs WHERE email='$user'";
			$topCom = $conn->query($Comacc);
	
echo'<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Transaction Successful</strong> -
		Reference<strong>	'.$reference.'</strong>
		</div>'; 
			
			$rebalance = strval(floatval($data['refwallet']) + floatval($payko));						
$affilqry = "UPDATE users SET refwallet='$rebalance' WHERE email='$affto'"; 
$maffi = $conn->query($affilqry);

$allEarn = strval(floatval($data['alltime']) + floatval($payko));

$upen="UPDATE earnings SET alltime='$allEarn' WHERE user='$affto'";
$qaffi = $conn->query($upen);

$qrSv = mysqli_query($conn,"INSERT INTO earnlog(transaction,amount,status,refby) VALUES('$product','$payko','Completed','$affto');");
} else { 

$qrfel = "UPDATE transactions SET status='Failed',action='Reverse',del='Delete',charge='$debit' WHERE ref='$requestId'";
  			$Qrevs = $conn->query($qrfel);
	
	
	echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Failed</strong> 
										
									</div>'; 
									
 }
	
	
	
?>