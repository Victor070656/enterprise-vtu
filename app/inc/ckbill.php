<?php
$qryApi = mysqli_query($conn,"SELECT * FROM api_setting");
$apidata = mysqli_fetch_array($qryApi);

$UserID = $apidata['clubId'];

$DisKey = $apidata['clubkey'];

$callb = $_SERVER['SERVER_NAME'];

if($plan === 'prepaid'){
	
	$meter_type = "01";
	
	}else{
		
		$meter_type = "02";
		
		}

$arrayTV = array("gotv","dstv","startimes");

$arrayElectric = array("ibadan-electric","ikeja-electric","eko-electric","jos-electric","kano-electric","kaduna-electric","portharcourt-electric");

if(in_array($arrayTV,$network)){
	
$hostTv = "https://www.nellobytesystems.com/APICableTVV1.asp?UserID=$UserID&APIKey=$DisKey&CableTV=$ckcode&Package=$variation_code&SmartCardNo=$iuc&RequestID=$requestId&CallBackURL=$callb";

//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $hostTv);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$Tvdata = curl_exec($ch);
$TVresult = json_decode($Tvdata,true);

//Close the cURL handle.
curl_close($ch);	
	
	
	}else{

$hostBill ="https://www.nellobytesystems.com/APIElectricityV1.asp?UserID=$UserID&APIKey=$DisKey&ElectricCompany=$ckcode&MeterType=$meter_type&MeterNo=$iuc&Amount=$amount&RequestID=$requestId&CallBackURL=$callb";

//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $hostBill);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$Disdata = curl_exec($ch);
$result = json_decode($Disdata,true);

//Close the cURL handle.
curl_close($ch);

$orderid = $result['transactionid'];



//Query Token

$Qryhost = "https://www.nellobytesystems.com/APIQueryV1.asp?UserID=$UserID&APIKey=$DisKey&OrderID=$orderid";

//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $Qryhost);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$DisResult = curl_exec($ch);
$resp = json_decode($DisResult,true);

//Close the cURL handle.
curl_close($ch);



$tokenAmount = $resp['tokenAmount'];

$product_name = $resp['content']['transactions']['product_name'];


if($network === 'ibadan-electric'){
 
 $tok =  $resp['metertoken']; 
 $units = $resp['Units'];
 $meterNumber = $resp['meterno'];
 
 $discoName = $resp['ordertype'];
    
}elseif($network === 'ikeja-electric'){
    
  $tok =  $resp['metertoken'];
  $units = $resp['units'];
  $meterNumber = $resp['meterno'];
  
   $discoName = $resp['ordertype'];
  
}elseif($network === 'portharcourt-electric'){
    
   $tok =  $resp['metertoken'];
   $units = $resp['units'];
   $meterNumber = $resp['meterno'];
   $discoName = $resp['ordertype'];
   
}elseif($network === 'jos-electric'){
    
   $tok =  $resp['metertoken'];
   $units = $resp['Units'];
   $meterNumber = $resp['meterno'];
   
    $discoName = $resp['ordertype'];
   
}elseif($network === 'kano-electric'){
    
   $tok =  $resp['metertoken'];
   $units = $resp['units'];
   $meterNumber = $resp['meterno'];
   
    $discoName = $resp['ordertype'];
   
}elseif($network === 'eko-electric'){
    
   $tok =  $resp['metertoken'];
   $units = $resp['mainTokenUnits'];
   $meterNumber = $resp['meterno'];
   
    $discoName = $resp['ordertype'];
    
}elseif($network === 'kaduna-electric'){
    
   $tok =  $resp['metertoken'];
   $units = $resp['mainTokenUnits'];
   $meterNumber = $resp['meterno'];
   
    $discoName = $resp['ordertype'];
}

$split = str_split($tok, 4);
 $numToken = implode('-', $split);
 
	}
 
 
 if ($resp['statuscode'] !== '100'){

			
	echo'<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>NETWORK ERROR . Credit Reversed</strong> 
										
									</div>';		
}else{

if(empty($tok)){

	if($TVresult['statuscode'] =='100'){
	    
	
		$current_balance = strval(floatval(intval($bal)) - floatval(intval($chargeAmt)));
	    
		debitWallet($conn, $current_balance, $user);
			
		function debitWallet($conn, $current_balance, $user){	
		$qry_debit = "UPDATE users SET bal='$current_balance' WHERE email='$user'";
			$doDebit = $conn->query($qry_debit);
			return $doDebit;
		}	
			
	    	
	$qsel = "UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet' WHERE ref='$tref' ";	
			$sav = $conn->query($qsel);
	
$rebalance = strval(intval($data['refwallet']) + intval($payko));						
$affilqry = "UPDATE users SET refwallet='$rebalance' WHERE email='$affto'"; 
$maffi = $conn->query($affilqry);

$allEarn = strval(intval($data['alltime']) + intval($payko));

$upen="UPDATE earnings SET alltime='$allEarn' WHERE user='$affto'";
$qaffi = $conn->query($upen);



$qrSv = mysqli_query($conn,"INSERT INTO earnlog(transaction,amount,status,refby) VALUES('$product','$payko','Completed','$affto');");

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
											
	
	}else{
	    
	 if($resp['statuscode'] =='200'){   
	    
$qry_debit = "UPDATE users SET bal=bal-$chargeAmt WHERE email='$user'";
			$doDebit = $conn->query($qry_debit);
	$qsel = "UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet' WHERE ref='$tref' ";	
			$sav = $conn->query($qsel);
	    
	    
	echo'<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Successful</strong> -
								
				Token:<strong>	'.$tok.'</strong>, Units: <strong>'.$units.'</strong> Product: '.$discoName.' 
									</div>'; 
									
	 }else{
	     
	     $qrfel = "UPDATE transactions SET status='Failed',action='Reverse',del='Delete' WHERE ref='$requestId'";
  			$Qrevs = $conn->query($qrfel);
  			
	   echo'<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Failed</strong> 
										
									</div>';  
	     
	 }
	    
	    
	}	}	



?>