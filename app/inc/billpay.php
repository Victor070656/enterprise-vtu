<?php
$qryApi = mysqli_query($conn,"SELECT * FROM api_setting");
$apidata = mysqli_fetch_array($qryApi);

$apikey = $apidata['APIkey']; //email address()

//$Bxaram = ;

//Initialize cURL.
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/biller/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $apikey,
    "service" => $network,
    "accountno" => $iuc,
    "vcode" => $variation_code,
    "amount" => $amount,
    "ref" => $requestId
    )));

$veridata = curl_exec($ch);

curl_close($ch);

$resp = json_decode($veridata,true);
$numToken = $resp['description']['Token'];

if ($resp['description']['Status'] == 'NETWORK ERROR'){
    
	echo'<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>NETWORK ERROR . Credit Reversed</strong> 
										
									</div>';		
}else{

if(is_null($resp['description']['Token'])){
	
	
	if($resp['code'] =='101'){
	    
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

echo'<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Successful</strong> 
										
									</div>';
/////////////////////////////////////////////////////////

?>
<script>
   
Swal.fire({
  title: 'Transaction Successful',
  html:
    'Your <?php echo $network; ?> subsscription is successul. <b> Smart Card/IUC Number <?php echo $iuc; ?></b>, ',
  icon: 'success',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Make new purchase'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href="../../paytv.php";
  }
})
    
</script>
<?php
									
									
///////////////////////////////////////////////////										
									
}else{ 
    
     ?>
<script>
Swal.fire({
icon: 'error',    
  title: 'Transaction Failed',
  showDenyButton: false,
  showCancelButton: true,
  confirmButtonText: 'Restart',
  
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
      
    window.location.href="../../paytv.php";
     
  } else if (result.isDenied) {
    Swal.fire('system busy', '', 'info')
  }
})
</script>
<?php

$qrfel = "UPDATE transactions SET status='Failed',action='Reverse',del='Delete' WHERE ref='$requestId'";
  			$Qrevs = $conn->query($qrfel);
  			
  			echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Failed</strong> -
								 
									</div>'; 
 }	
											
	
	}else{
	    
	 if($resp['code'] =='101'){   
	     
	     $qry_debit = "UPDATE users SET bal=bal-$chargeAmt WHERE email='$user'";
			$doDebit = $conn->query($qry_debit);
	    
	echo'<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Successful</strong> -
								
				Token:<strong>	'.$resp['description']['Token'].'</strong>, Units: <strong>'.$units.'</strong>  
									</div>'; 
									
	/////////////////////////////////////////////////////////

?>
<script>
   
Swal.fire({
  title: 'Transaction Successful',
  html:
    'Your <?php echo $network; ?> is successful <b>Token: <?php echo $numToken; ?>, Meter Number <?php echo $iuc; ?></b>, ',
  icon: 'success',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Make new purchase'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href="../../disco.php";
  }
})
    
</script>
<?php								
									
///////////////////////////////////////////////////									
									
									
	 }else{
	     
	     $qrfel = "UPDATE transactions SET status='Failed',action='Reverse',del='Delete' WHERE ref='$requestId'";
  			$Qrevs = $conn->query($qrfel);
  			
	     	echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Failed</strong> -
								 
									</div>'; 
	     
	 }
	    
	    
	}	}		

?>