<?php 
require_once('../db.php');

if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
} else {
		$sn = $_GET['id'];
		function data($conn,$sn){
		 $Runqry = $conn->prepare("DELETE FROM pins_package WHERE serial=?");
		 $Runqry->bind_param("i",$sn);
		 $result = $Runqry->execute();
		 return $result;
		}
		if(data($conn,$sn)){
	?><script>window.location.replace('pin_pricing.php');</script> <?php	    
		} }
		
		?>