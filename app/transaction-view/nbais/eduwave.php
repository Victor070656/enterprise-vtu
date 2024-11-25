<?php
require('../../db.php');
require('../../inc/codex.php');
								
		$query_rec = mysqli_query($conn,"SELECT * FROM api_setting");
			
			$apib = mysqli_fetch_array($query_rec); 
			
			$apikey =  $apib['APIkey'];	
			
		$pmt = mysqli_query($conn,"SELECT * FROM payment");						
		$pmkey = mysqli_fetch_array($pmt);
		
		$paykey = $pmkey['flutterSecret'];			

 // confirm  payment    
$curl = curl_init();
$reference = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : '';
if(!$reference){
  die('No reference supplied');
}

curl_setopt_array($curl, array(
   CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/$reference/verify",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "authorization: Bearer $paykey",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);


if($err){
	// there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response);

if(!$tranx->status){
  // there was an error from the API
  die('API returned error: ' . $tranx->message);
}

if($tranx->data->status === 'successful'){
    $tx_ref = $tranx->data->tx_ref;
    $ret = mysqli_query($conn,"SELECT * FROM transactions WHERE ref='$tx_ref' ");
		
		$da = mysqli_fetch_array($ret);
		$amount = $da['amount'];
		$tid = $da['ref'];	
		$iuc = $da['meterno'];
		$network = $da['serviceid'];
		$variation_code = $da['vcode'];
		
        if($da['status'] !== 'Completed'){
					$carier = $da['network'];
					$phon = $da['phone'];

//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, urlbasemain()."/"."nbais/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $codekey,
    "service" => $network,
    "vcode" => $variation_code,
    "amount" => $amount,
    "ref" => $tid
    )));
$veridata = curl_exec($ch);
$resp = json_decode($veridata);
curl_close($ch);

				
				$Product = $resp->ProductName;
			
				$pin_code = $resp->PIN;
				
                // update
                $tk = md5(uniqid());
				$statux = "Completed";
                $r = $tx_ref;
            
            if($resp->code == '101'){    
				
		$Qryup = $conn->query("UPDATE transactions SET token='$tk',refer='$r',status='$statux',metertoken='$pin_code' WHERE ref='$tx_ref' ");
			?>
<script>window.location="../../receipt?tid=<?php echo urlencode($tx_ref);?>";</script> <?php
            }else{
          
          $isError = "Failed";
          $Qryup = $conn->query("UPDATE transactions SET status='$isError',charge='$amount' WHERE ref='$tx_ref' ");      
               ?>
<script>
setTimeout(function(){
alert('Network Error: <?php echo $carier;?> could not be processed. Please contact support.'); 
window.location.replace('../../receipt?tid=<?php echo urlencode($tx_ref);?>');
},2000);
</script> <?php           
            }	
             
  // transaction was successful...
  // please check other things like whether you already gave value for this ref
  // if the email matches the customer who owns the product etc
  // Give value
                }

}
         

?>
