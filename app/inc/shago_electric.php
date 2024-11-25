<?php
$qryApi = mysqli_query($conn,"SELECT * FROM api_setting");
$apidata = mysqli_fetch_array($qryApi);


/////////////////////////////////////////////

if($serviceID == 'enugu-electric'){ $ServID = "eedc";}	
if($serviceID == 'abuja-electric'){ $ServID = "aedc";}
if($serviceID == 'ibadan-electric'){ $ServID = "ibedc";}
if($serviceID == 'ikeja-electric'){ $ServID = "ikedc";}
if($serviceID == 'eko-electric'){ $ServID = "ekedc";}

/////////////////////////////////////////////////

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
'serviceCode' => 'AOB',
'disco' => strtoupper($ServID),
'meterNo' => $iuc,
'type'	=> strtoupper($variation_code),
'amount' => $amount,
'phonenumber' => $phone,
'name' => $CustomerName,
'address' => $CustomerAddress,
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

$resp = json_decode($resQuery,true);

//////////////////////////////////////////////////////

$tokenAmount = $resp['tokenAmount'];

$numToken = $resp['token'];

//$product_name = $resp['content']['transactions']['product_name'];

	 if($resp['status'] =='200'){  
	     		
	$qry_debit = "UPDATE users SET bal=bal-$chargeAmt WHERE email='$user'";
			$doDebit = $conn->query($qry_debit);
	    $qsel = "UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet',del='Delete' WHERE ref='$tref' ";	
			$sav = $conn->query($qsel);
	
			
$affilqry = "UPDATE users SET refwallet=refwallet+$payko WHERE email='$affto'"; 
$maffi = $conn->query($affilqry);
$upen="UPDATE earnings SET alltime=alltime+$payko WHERE user='$affto'";
$qaffi = $conn->query($upen);

$qrSv = mysqli_query($conn,"INSERT INTO earnlog(transaction,amount,status,refby) VALUES('$product','$payko','Completed','$affto');");		
			
			
		
	echo'<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Successful</strong> -
								
				Token:<strong>	'.$numToken.'</strong>, Units: <strong>'.$units.'</strong> Product: '.$discoName.' 
									</div>'; 
									
/////////////////////////////////////////////////////////

?>
<script>
   
Swal.fire({
  title: 'Transaction Successful',
  html:
    'Your <?php echo $discoName; ?> is successful <b>Token: <?php echo $numToken; ?>, Meter Number <?php echo $iuc; ?></b>, ',
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
	     
	     ?>
<script>
Swal.fire({
icon: 'error',    
  title: '<?php echo $rp->description; ?>',
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
	     
	     $qrfel = "UPDATE transactions SET status='Failed',action='Reverse',del='Delete' WHERE ref='$requestId'";
  			$Qrevs = $conn->query($qrfel); 
	     
	 	echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Failed</strong>  
									</div>';     
	     
	 }
	    
	    
			



?>