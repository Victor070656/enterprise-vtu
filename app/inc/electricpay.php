<?php
$qryApi = mysqli_query($conn,"SELECT * FROM api_setting");
$apidata = mysqli_fetch_array($qryApi);

$apikey = $apidata['APIkey']; //email address()

$UserID = $apidata['clubId'];

$DisKey = $apidata['clubkey'];

$callb = $_SERVER['SERVER_NAME'];

if($apidata['active'] === 'epins'){

//Initialize cURL.
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/electric?");
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

$resp = json_decode($veridata);

if(!empty($resp->description->Token)){
    
     $current_balance = strval(floatval(intval($bal)) - floatval(intval($chargeAmt)));
	    
		debitWallet($conn, $current_balance, $user);
			
		function debitWallet($conn, $current_balance, $user){	
		$qry_debit = "UPDATE users SET bal='$current_balance' WHERE email='$user'";
			$doDebit = $conn->query($qry_debit);
			return $doDebit;
		}
	
	$qsel = "UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet',amount='$xamount',charge='$chargeAmt' WHERE ref='$tref' ";	
$sav = $conn->query($qsel);

echo'<div class="alert alert-info">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Successful</strong> - 
										
										Token:<strong>	'.$resp->description->Token.'</strong>, Units: <strong>'.$resp->description->Units.'</strong>, MeterNumber
										<strong>'.$resp->description->meterNumber.'</strong>, Products Name: <strong>'.$resp->description->product_name.'</strong>  
										
									</div>'; 
									
									
	/////////////////////////////////////////////////////////

?>
<script>
   
Swal.fire({
  title: 'Transaction Successful',
  html:
    'Your <?php echo $resp->description->product_name; ?> is successful <b>Token: <?php echo $resp->description->Token; ?>, Meter Number <?php echo $resp->description->meterNumber; ?></b>, ',
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
									
									
include('../../inc/notification.php');										

$rebalance = strval(intval($data['refwallet']) + intval($payko));						
$affilqry = "UPDATE users SET refwallet='$rebalance' WHERE email='$affto'"; 
$maffi = $conn->query($affilqry);

$allEarn = strval(intval($data['alltime']) + intval($payko));

$upen="UPDATE earnings SET alltime='$allEarn' WHERE user='$affto'";
$qaffi = $conn->query($upen);

$qrSv = mysqli_query($conn,"INSERT INTO earnlog(transaction,amount,status,refby) VALUES('$product','$payko','Completed','$affto');");
}else{ 

$qrfel = "UPDATE transactions SET status='Failed',action='Reverse',del='Delete' WHERE ref='$requestId'";
  			$Qrevs = $conn->query($qrfel);
  			
  			echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Failed</strong> 
										
									</div>'; 
									
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
      
    window.location.href="../../disco.php";
     
  } else if (result.isDenied) {
    Swal.fire('system busy', '', 'info')
  }
})
</script>
<?php									
									
									
 }	
	


}else{
	
if($plan == 'prepaid'){
	$meter_type = "01";
	}else{$meter_type = "02";}	

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



if($resp['statuscode'] ==='200'){
    
    $qry_debit = "UPDATE users SET bal=bal-$chargeAmt WHERE email='$user'";
			$doDebit = $conn->query($qry_debit);
	
	$qsel = "UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet',amount='$xamount',charge='$chargeAmt' WHERE ref='$tref' ";	
$sav = $conn->query($qsel);

echo'<div class="alert alert-info">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Successful</strong> - 
										
										<strong>	'.$resp['metertoken'].'</strong>,  MeterNumber: <strong>'.$resp['meterno'].'</strong>, Products Name: <strong>'.$resp['ordertype'].'</strong>  
										
									</div>'; 
									
		/////////////////////////////////////////////////////////

?>
<script>
   
Swal.fire({
  title: 'Transaction Successful',
  html:
    'Your <?php echo $resp['ordertype']; ?> is successful <b>Token: <?php echo $resp['metertoken']; ?>, Meter Number <?php echo $resp['meterno']; ?></b>, ',
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
									
									
	include('../../inc/notification.php');									

								
$affilqry = "UPDATE users SET refwallet=refwallet+$payko WHERE email='$affto'"; 
$maffi = $conn->query($affilqry);
$upen="UPDATE earnings SET alltime=alltime+$payko WHERE user='$affto'";
$qaffi = $conn->query($upen);

$qrSv = mysqli_query($conn,"INSERT INTO earnlog(transaction,amount,status,refby) VALUES('$product','$payko','Completed','$affto');");
}else{ 

$qrfel = "UPDATE transactions SET status='Failed',action='Reverse',del='Delete' WHERE ref='$requestId'";
  			$Qrevs = $conn->query($qrfel);
  			
  			
  			echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Failed</strong> 
										
									</div>'; 
									
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
      
    window.location.href="../../disco.php";
     
  } else if (result.isDenied) {
    Swal.fire('system busy', '', 'info')
  }
})
</script>
<?php
 }	
		
	
	
	}
?>