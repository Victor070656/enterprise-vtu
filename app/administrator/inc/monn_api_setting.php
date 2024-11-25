<?php 

		$monnkey = test_input($_REQUEST['monn_key']);
		$monnsec = test_input($_REQUEST['monn_sec']);
        $monncont = test_input($_REQUEST['monn_cont']);
        $monnwalletId = test_input($_REQUEST['monn_walletid']);
		
	if(!empty($monnkey)&& !empty($monnsec) && !empty($monncont) ) {	
		
	$sql_monnf = $conn->query("UPDATE monnify_api SET monn_apikey='$monnkey',monn_secret='$monnsec',monn_contra='$monncont',monn_walletid='$monnwalletId'");	

echo "<div class='alert alert-info'>Settings saved</div>";

	}else{
		
echo "<div class='alert alert-danger'>Field cannot be empty</div>";		
		}
		
	

?>