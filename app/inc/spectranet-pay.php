<?php

$query_MapiS = mysqli_query($conn,"SELECT * FROM api_setting");
			
$apiMulti = mysqli_fetch_array($query_MapiS);
			
								
if($apiMulti['active'] == 'epins'){
////////////////////////////////////////////

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
'serviceCode' => "SPB",
'amount' => $amount,
'type'	=> 'SPECTRANET',
'pinNo'	=> $pinNumber,
'request_id' => $requestId	
)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "hashKey: $hashkey"
));

$response = curl_exec($ch);
curl_close($ch);

// Requery Transaction

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
'serviceCode' => 'QUB',
'reference' => $requestId
)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "hashKey: $hashkey"
));
$resQuery = curl_exec($ch);
curl_close($ch);

$result = json_decode($resQuery,true);
}

//////////////////////////////////////////


///////////////////////////////////////////
if($apiMulti['active'] == 'epins'){
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, urlbasemain()."/"."spectranet/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
    "apikey" => $codekey,
    "service" => $network,
    "pinNo" => $pinNumber,
    "amount" => $amount,
    "ref" => $requestId
    )));
$veridata = curl_exec($ch);
$resp = json_decode($veridata,true);
curl_close($ch);
}
//////////////////////////////////////////////////
$product ="Spectranet Topup";

if($resp['code'] == '101'  OR $result['status']=='200'){
    

  $current_balance = strval(floatval(intval($bal)) - floatval(intval($debit)));
	    
		debitWallet($conn, $current_balance, $user);
			
		function debitWallet($conn, $current_balance, $user){	
		$qry_debit = "UPDATE users SET bal='$current_balance' WHERE email='$user'";
			$doDebit = $conn->query($qry_debit);
			return $doDebit;
		}			
			
	$qsel = $conn->query("UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet',amount='$xamount',charge='$debit' WHERE ref='$tref' ");	
	
echo'<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<strong>Transaction Successful</strong> - PIN:<strong>	'.$resp['PIN'].'</strong>, Serial: <strong>'.$resp['Serial'].'</strong>  
		</div>'; 
		
/////////////////////////////////////////////////////////

?>
<script>
   
Swal.fire({
  title: 'Transaction Successful',
  html:
    ' <b> PIN: <?php echo $resp['PIN']; ?>-SerialNo: <?php echo $resp['Serial'];?> </b>, ',
  icon: 'success',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Make new purchase'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href="../../spectranet.php";
  }
})
    
</script>
<?php
									
///////////////////////////////////////////////////			
		
		
$rebalance = strval(intval($data['refwallet']) + intval($payko));						
$affilqry = "UPDATE users SET refwallet='$rebalance' WHERE email='$affto'"; 
$maffi = $conn->query($affilqry);

$allEarn = strval(intval($data['alltime']) + intval($payko));

$upen="UPDATE earnings SET alltime='$allEarn' WHERE user='$affto'";
$qaffi = $conn->query($upen);

$qrSv = mysqli_query($conn,"INSERT INTO earnlog(transaction,amount,status,refby) VALUES('$product','$payko','Completed','$affto');");

//credit commission wallet    
$Comacc = $conn->query("UPDATE users SET cwallet=$apComs WHERE email='$user'");

}else{ 

$qrfel = "UPDATE transactions SET status='Failed',charge='$debit',action='Reverse',del='Delete' WHERE ref='$requestId'";
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
      
    window.location.href="../../spectranet.php";
     
  } else if (result.isDenied) {
    Swal.fire('system busy', '', 'info')
  }
})
</script>
<?php									
									
 }
	
	
	
?>