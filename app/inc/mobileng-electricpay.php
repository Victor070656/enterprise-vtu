<?php 

$qryApi = mysqli_query($conn,"SELECT * FROM api_setting");
$apidata = mysqli_fetch_array($qryApi);


$DisKey = $apidata['smartkey'];

$callb = $_SERVER['SERVER_NAME'];

$mobilekey = $apidata['mobilekey'];
$mobileID = $apidata['mobileID'];


if($plan == 'prepaid'){

	$mtype = "1";
	
}else{$mtype = "0";  }

$host = "http://mobileairtimeng.com/httpapi/power-pay?userid=$mobileID&pass=$mobilekey&user_ref=$requestId&service=$mobCode&meterno=$iuc&mtype=$mtype&amt=$amount&jsn=json";

//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $host);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$vdata = curl_exec($ch);
$result = json_decode($vdata,true);

//Close the cURL handle.
curl_close($ch);



if($result['code'] == '100'){
	
$meterToken = $result['pincode'];
	
$qsel = "UPDATE transactions SET network ='$pnt <br> Token $meterToken',status='Completed',token='0',refer='0',channel='Wallet',amount='$xamount',charge='$debit',del='Delete' WHERE ref='$tref' ";	
$sav = $conn->query($qsel);	
	
	
	
	echo'<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Successful</strong> -
								
				Token:<strong>	'.$result['pincode'].'</strong>,  <strong>'.$result['pinmessage'].'</strong>  
									</div>'; 
	
	
	
			
$rebalance = strval(intval($data['refwallet']) + intval($payko));						
$affilqry = "UPDATE users SET refwallet='$rebalance' WHERE email='$affto'"; 
$maffi = $conn->query($affilqry);

$allEarn = strval(intval($data['alltime']) + intval($payko));

$upen="UPDATE earnings SET alltime='$allEarn' WHERE user='$affto'";
$qaffi = $conn->query($upen);

$qrSv = mysqli_query($conn,"INSERT INTO earnlog(transaction,amount,status,refby) VALUES('$pnt','$payko','Completed','$affto');");
}else{
	
$qrfel = "UPDATE transactions SET status='Failed',action='Reverse',del='Delete' WHERE ref='$requestId'";
  			$Qrevs = $conn->query($qrfel);	
	
	echo'<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Network Error</strong>  
									</div>'; 
	
	
}

?>