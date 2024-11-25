<?php 

$qryApi = mysqli_query($conn,"SELECT * FROM api_setting");
$apidata = mysqli_fetch_array($qryApi);


$DisKey = $apidata['smartkey'];

$callb = $_SERVER['SERVER_NAME'];



$host = "https://smartrecharge.ng/api/v2/tv/?api_key=$DisKey&product_code=$variation_code&smartcard_number=$iuc&callback=$callb";

//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $host);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$vdata = curl_exec($ch);
$result = json_decode($vdata,true);

//Close the cURL handle.
curl_close($ch);




if($result['data']['text_status'] !== 'FAILED'){
    
      $current_balance = strval(floatval(intval($bal)) - floatval(intval($chargeAmt)));
	    
		debitWallet($conn, $current_balance, $user);
			
		function debitWallet($conn, $current_balance, $user){	
		$qry_debit = "UPDATE users SET bal='$current_balance' WHERE email='$user'";
			$doDebit = $conn->query($qry_debit);
			return $doDebit;
		}
			
			$qsel = "UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet',amount='$xamount',charge='$debit',del='Delete' WHERE ref='$tref' ";	
$sav = $conn->query($qsel);
			
$rebalance = strval(intval($data['refwallet']) + intval($payko));						
$affilqry = "UPDATE users SET refwallet='$rebalance' WHERE email='$affto'"; 
$maffi = $conn->query($affilqry);

$allEarn = strval(intval($data['alltime']) + intval($payko));

$upen="UPDATE earnings SET alltime='$allEarn' WHERE user='$affto'";
$qaffi = $conn->query($upen);

$qrSv = mysqli_query($conn,"INSERT INTO earnlog(transaction,amount,status,refby) VALUES('$pnt','$payko','Completed','$affto');");

echo'<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Successful</strong> 
										
									</div>';
									
}else{
	
$qrfel = "UPDATE transactions SET status='Failed',action='Reverse',del='Delete' WHERE ref='$requestId'";
  			$Qrevs = $conn->query($qrfel);	
  			
  				echo'<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Failed</strong> 
										
									</div>';
	
}

?>