<?php

$sev = $_POST['service'];
	$sno = $_POST['iuc'];
	$tp = $_POST['plan'];
								
$qryApi = mysqli_query($conn,"SELECT * FROM api_setting");
$apidata = mysqli_fetch_array($qryApi);

$apikey = $apidata['APIkey']; //email address()

$mobilekey = $apidata['mobilekey'];
$mobileID = $apidata['mobileID'];

$provi = array("epins","vtpass","clubkonnect","smartrecharge","mobileng");
			
			if(in_array($apidata['tvactive']||$apidata['active']|| $apidata['poweractive']||$apidata['smileactive'],$provi) ){
	
// VTpass verify

$username = $apidata['VTuser']; //email address(sandbox@vtpass.com)
$password = $apidata['VTpass']; //password (sandbox)
$host = 'https://vtpass.com/api/merchant-verify';
$VTdata = array(
  	'serviceID'=> $_POST['service'], //integer e.g gotv,dstv,eko-electric,abuja-electric
  	'billersCode'=> $_POST['iuc'],// e.g smartcardNumber, meterNumber,
  	'type' => $_POST['plan']
  	
);

//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $host);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERPWD , $username.":" .$password);
curl_setopt($ch, CURLOPT_POSTFIELDS, $VTdata);
$verifydata = curl_exec($ch);


//Close the cURL handle.
curl_close($ch);



$result = json_decode($verifydata);




$customerName = $result->content->Customer_Name;				
				

if(is_null($customerName)){
			
			echo'<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Invalid Meter Number. Please Check your Meter Number and Try Again</strong>  
									</div>'; 
			
			}else{
				

$qsel = "INSERT INTO transactions(network,serviceid,vcode,meterno,phone,ref,refer,amount,email,status,token,customer,del)VALUES('$pnt','$serviceID','$plan','$iuc','$phone','$uid','$token','$amount','$user','$stat','$token','$fname $lname','Delete')";	
								
								$sav = $conn->query($qsel);
						
			$_SESSION['customer'] = $customerName;	
							?>
                            <script>
           window.location="transaction-view/disco?<?php echo $uid; ?>#transPreview";
                            </script>
                            <?php				
				
	}
				
			}

?>