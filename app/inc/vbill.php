<?php
$qryApi = mysqli_query($conn,"SELECT * FROM api_setting");
$apidata = mysqli_fetch_array($qryApi);


$username = $apidata['VTuser']; //email address(sandbox@vtpass.com)
$password = $apidata['VTpass']; //password (sandbox)

$curl       = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://vtpass.com/api/pay',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_USERPWD => $username.":" .$password,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_SSL_VERIFYPEER => true,
	CURLOPT_POSTFIELDS => array(
    'request_id' => $requestId,
  	'serviceID'=> $network, //integer e.g gotv,dstv,eko-electric,abuja-electric
  	'billersCode'=> $iuc, // e.g smartcardNumber, meterNumber,
  	'variation_code'=> $variation_code, // e.g dstv1, dstv2,prepaid,(optional for somes services)
  	'amount' =>  $amount, // integer (optional for somes services)
  	'phone' => $iuc //integer
),
));
$success = curl_exec($curl);
$curl_errno = curl_errno($curl);
curl_close($curl);

$resp = json_decode($success, true);


$tokenAmount = $resp['tokenAmount'];

$product_name = $resp['content']['transactions']['product_name'];


if($network === 'ibadan-electric'){
 
 $tok =  $resp['purchased_code']; 
 $units = $resp['Units'];
 $meterNumber = $billersCode;
 
 $discoName = "IBEDC";
    
}elseif($network === 'ikeja-electric'){
    
  $tok =  $resp['token'];
  $units = $resp['units'];
  $meterNumber = $resp['content']['transactions']['unique_element'];
  
   $discoName = "IKEDC";
  
}elseif($network === 'portharcourt-electric'){
    
   $tok =  $resp['token'];
   $units = $resp['units'];
   $meterNumber = $resp['meterNumber'];
   $discoName = "PHED";
   
}elseif($network === 'jos-electric'){
    
   $tok =  $resp['Token'];
   $units = $resp['Units'];
   $meterNumber = $resp['content']['transactions']['unique_element'];
   
    $discoName = "JED";
   
}elseif($network === 'kano-electric'){
    
   $tok =  $resp['token'];
   $units = $resp['units'];
   $meterNumber = $resp['content']['transactions']['unique_element'];
   
    $discoName = "KEDCO";
   
}elseif($network === 'eko-electric'){
    
   $tok =  $resp['purchased_code'];
   $units = $resp['mainTokenUnits'];
   $meterNumber = $resp['content']['transactions']['unique_element'];
   
    $discoName = "EKEDC";
    
}elseif($network === 'kaduna-electric'){
    
   $tok =  $resp['purchased_code'];
   $units = $resp['mainTokenUnits'];
   $meterNumber = $resp['content']['transactions']['unique_element'];
   
    $discoName = "KAEDCO";
}

$split = str_split($tok, 4);
 $numToken = implode('-', $split);
 
 
 
 
 if ($resp['code'] !== '000'){
		
	echo'<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>NETWORK ERROR . Credit Reversed</strong> 
										
									</div>';		
}else{

if(is_null($tok)){
	
	
	if($resp['code'] =='000'){
	    
	      $current_balance = strval(floatval(intval($bal)) - floatval(intval($chargeAmt)));
	    
		debitWallet($conn, $current_balance, $user);
			
		function debitWallet($conn, $current_balance, $user){	
		$qry_debit = "UPDATE users SET bal='$current_balance' WHERE email='$user'";
			$doDebit = $conn->query($qry_debit);
			return $doDebit;
		}
			
			
	    $qsel = "UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet',del='Delete' WHERE ref='$tref' ";	
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
	    
	 if($resp['code'] =='000'){  
	     
	       $current_balance = strval(floatval(intval($bal)) - floatval(intval($chargeAmt)));
	    
		debitWallet($conn, $current_balance, $user);
			
		function debitWallet($conn, $current_balance, $user){	
		$qry_debit = "UPDATE users SET bal='$current_balance' WHERE email='$user'";
			$doDebit = $conn->query($qry_debit);
			return $doDebit;
		}
	    
	echo'<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Successful</strong> -
								
				Token:<strong>	'.$numToken.'</strong>, Units: <strong>'.$units.'</strong> Product: '.$discoName.' 
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