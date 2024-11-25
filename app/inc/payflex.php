<?php 
//echo gateway($conn);
$apiMulti = json_decode(gateway($conn));
 $apikey = $apiMulti->APIkey; 
$UserID = $apiMulti->clubId;$DisKey = $apiMulti->clubkey;
$callb = $_SERVER['SERVER_NAME'];$smartKey = $apiMulti->smartkey;
$mobilekey = $apiMulti->mobilekey;$mobileID = $apiMulti->mobileID;
$hashkey = $apiMulti->shago;$username = $apiMulti->VTuser; 
$password = $apiMulti->VTpass;
if($apiMulti->active === 'epins'){

$result = json_decode(epinAirtime($conn, $apikey, $network,$phone,$xamount,$requestId));
$responseCode = $result->code;

	}else if($apiMulti->active === 'clubkonnect'){
			
$result = json_decode(ClubKonet($conn, $UserID, $DisKey, $ncode, $xamount, $phone, $requestId, $callb));	

 $responseCode = $result->statuscode;	
			}
			elseif($apiMulti->active === 'shago'){
			
$result = json_decode(shagoPay($conn, $phone, $xamount,$network,$requestId, $hashkey ));	
$responseCode = $result->status;
			}
			elseif($apiMulti->active === 'mobileng'){
		
				
include('mobileng-airtime.php');
			}
			
			elseif($apiMulti->active === 'smartrecharge'){
			
	include('smart-airtime.php');
			
			}

elseif($apiMulti->active === 'vtpass'){
			
	include('vtairtime.php');
			
			}

elseif($apiMulti->active === 'simhost'){
			
	include('simairtime.php');
			
			}
			elseif($apiMulti->active === 'smeplug'){
			
	include('smeplug_airtime.php');
			
			}

//////////////////////////

if($responseCode == '101' OR $responseCode == '200' OR $responseCode == '000' OR $responseCode == 'true'){

$prevBal = json_decode(bal_val($conn, $user));
	$current_balance = strval(floatval($prevBal->bal) - floatval(intval($debit)));
walletDebit($conn,$current_balance, $user);			

InsertTransaction($conn,$xamount,$debit, $tref );

$prevBonus =  json_decode(refbal($conn, $affto));
$bonus_balance = strval(floatval($prevBonus->refwallet) + floatval(intval($payko)));
addCommission($conn,$bonus_balance, $affto);

$prevEarning = json_decode(earnbal($conn, $affto));
$Add_alltime = strval(floatval($prevEarning->alltime) + floatval(intval($payko)));
Addearnlog($conn, $pnt, $payko, $affto );
echo '<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Successful</strong>  
									</div>'; 
									
?>
<script>
   
Swal.fire({
  title: 'Transaction Successful',
  html:
    'You have send <b><?php echo 'N'.$xamount.' '.$network; ?> airtime to <?php echo $phone; ?></b>, ',
  icon: 'success',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Buy Again'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href="../airtime.php";
  }
})
    
</script>
<?php									
	
}else if($result->code == '104'){
  
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
      
    window.location.href="../../airtime.php";
     
  } else if (result.isDenied) {
    Swal.fire('system busy', '', 'info')
  }
})
</script>
<?php
							
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
      
    window.location.href="../../airtime.php";
     
  } else if (result.isDenied) {
    Swal.fire('system busy', '', 'info')
  }
})
</script>

<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Failed</strong>  
									</div>
<?php
    
$qrfel = "UPDATE transactions SET status='Failed',action='Reverse',del='Delete' WHERE ref='$requestId'";
  			$Qrevs = $conn->query($qrfel);
  			
  			
 }


			
			
			function bal_val($conn, $user){
        $qrvalbal = $conn->prepare("SELECT * FROM users WHERE email=?");
        $qrvalbal->bind_param("s",$user);
        $qrvalbal->execute();
        $result = $qrvalbal->get_result();
        $fetchBal = $result->fetch_assoc();
        return json_encode($fetchBal);
        }	
			function walletDebit($conn,$current_balance, $user){  
	$Qdebit = $conn->prepare("UPDATE users SET bal=? WHERE email=?");
	$Qdebit->bind_param("ss",$current_balance,$user);
	$runexe = $Qdebit->execute();
	return $runexe;
	  }

	
			function refbal($conn, $affto){
        $qrvalbal = $conn->prepare("SELECT * FROM users WHERE email=?");
        $qrvalbal->bind_param("s",$affto);
        $qrvalbal->execute();
        $result = $qrvalbal->get_result();
        $fetchBonus = $result->fetch_assoc();
        return json_encode($fetchBonus);
        }
        
        function earnbal($conn, $affto){
        $qrvalbal = $conn->prepare("SELECT * FROM earnings WHERE user=?");
        $qrvalbal->bind_param("s",$affto);
        $qrvalbal->execute();
        $result = $qrvalbal->get_result();
        $fetchEn = $result->fetch_assoc();
        return json_encode($fetchEn);
        }
        
        function Addearnlog($conn, $pnt, $payko, $affto ){
$qrSv = mysqli_query($conn,"INSERT INTO earnlog(transaction,amount,status,refby) VALUES('$pnt','$payko','Completed','$affto');");
return $qrSv;
}
        
        	function addCommission($conn,$bonus_balance, $affto){  
	$Qcredt = $conn->prepare("UPDATE users SET refwallet=? WHERE email=?");
	$Qcredt->bind_param("ss",$bonus_balance,$affto);
	$runBnous = $Qcredt->execute();
	return $runBonus;
	  }

        
        function InsertTransaction($conn,$xamount,$debit, $tref ){			
$qsel = "UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet',amount='$xamount',charge='$debit',del='Delete' WHERE ref='$tref' ";	$sav = $conn->query($qsel);
return $sav;
}

function epinAirtime($conn, $apikey, $network,$phone,$xamount,$requestId){    
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, urlbasemain()."/"."airtime/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $apikey,
    "network" => $network,
    "phone" => $phone,
    "amount" =>  $xamount, 
    "ref" => $requestId
)));
$veridata = curl_exec($ch);
curl_close($ch);
return $veridata;
}

function ClubKonet($conn, $UserID, $DisKey, $ncode, $xamount, $phone, $requestId, $callb){
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.nellobytesystems.com/APIAirtimeV1.asp?UserID=$UserID&APIKey=$DisKey&MobileNetwork=$ncode&Amount=$xamount&MobileNumber=$phone&RequestID=$requestId&CallBackURL=$callb");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$Clubdata = curl_exec($ch);
curl_close($ch);
return $Clubdata;
	    
	}
	
	function shagoPay($conn, $phone, $xamount,$network,$requestId, $hashkey ){
$Shagoparam = array(
'serviceCode' => 'QAB',
'phone' => $phone,
'amount'	=> $xamount,
'vend_type'	=> 'VTU',
'network' => strtoupper($network),
'request_id' => $requestId	

);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Shagoparam));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "hashKey: $hashkey"
));

$isuccess = curl_exec($ch);
curl_close($ch);
file_put_contents('res.txt',$isuccess);
return $isuccess;
}

function gateway($conn){
$query_MapiS = mysqli_query($conn,"SELECT * FROM api_setting");
$apiMultiAT = mysqli_fetch_array($query_MapiS);
return json_encode($apiMultiAT);
}
?>

