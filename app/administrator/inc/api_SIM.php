<?php 
$simkey = $_REQUEST['simkey'];

$simPin = $_REQUEST['simPin'];

$serverMTN = $_REQUEST['serverMTN'];
$serverAirtel = $_REQUEST['serverAirtel'];
$serverGlo = $_REQUEST['serverGlo'];
$serverEtisalat = $_REQUEST['serverEtisalat'];
		
		
	if(!empty($simkey) || !empty($simPin) || !empty($serverMTN) || !empty($serverAirtel) || !empty($serverGlo) || !empty($serverEtisalat)  ) {	
		
		
	$sql_store = mysqli_query($conn,
	
	"UPDATE api_setting SET simkey='$simkey',simPin='$simPin',serverMTN='$serverMTN',serverAirtel='$serverAirtel',serverGlo='$serverGlo',serverEtisalat='$serverEtisalat' ");	

echo "<div class='alert alert-info'>Settings saved</div>";

?> <script>
setTimeout(function(){ window.location.href='simHostConfig.php' }, 1000);</script>
   <?php
	}else{
		
echo "<div class='alert alert-danger'>Field cannot be empty</div>";		
		}
	
		
	
?>