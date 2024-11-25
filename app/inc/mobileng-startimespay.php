<?php 

$qryApi = mysqli_query($conn,"SELECT * FROM api_setting");
$apidata = mysqli_fetch_array($qryApi);


$DisKey = $apidata['smartkey'];

$callb = $_SERVER['SERVER_NAME'];

$mobilekey = $apidata['mobilekey'];
$mobileID = $apidata['mobileID'];




$host = "https://mobileairtimeng.com/httpapi/startimes?userid=$mobileID&pass=$mobilekey&phone=$phone&amt=$amount&smartno=$iuc&jsn=json&user_ref=$requestId";

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
	
$qsel = "UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet',amount='$xamount',charge='$debit',del='Delete' WHERE ref='$tref' ";	
$sav = $conn->query($qsel);	
	
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
	
}

?>