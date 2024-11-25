<?php

$username = $apidata['VTuser']; //email address(sandbox@vtpass.com)
$password = $apidata['VTpass']; //password (sandbox)
$host = 'https://vtpass.com/api/merchant-verify';
$data = array(
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
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$verifydata = curl_exec($ch);
$result = json_decode($verifydata);

//Close the cURL handle.
curl_close($ch);


if(is_null($result->content->Customer_Name)){
			
			echo'<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Invalid Meter Number. Please Check your Meter Number and Try Again</strong>  
									</div>'; 
			
			}	else{		
					
									
	$qsel = "INSERT INTO transactions(network,serviceid,vcode,meterno,phone,ref,refer,amount,email,status,token,customer,del)VALUES('$pnt','$serviceID','$plan','$iuc','$phone','$uid','$token','$amount','$user','$stat','$token','$fname $lname','Delete')";		
								
								$sav = $conn->query($qsel);
								
		
			?>
        <script>						
       window.location="transaction-view/paytv?<?php echo $uid; ?>#transPreview";
          </script>
         <?php 								
 
			$_SESSION['customer'] = $result->content->Customer_Name;
								
                                }

?>