<?php 
session_start();
require('../db.php');
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}else{
		$sn = $_GET['id'];
		function tv($conn,$sn){
		 $Runqry = $conn->prepare("DELETE FROM bank_gateway WHERE serial=?");
		 $Runqry->bind_param("i",$sn);
		 $result = $Runqry->execute();
		 return $result;
		}
		if(tv($conn,$sn)){
	?><script>window.location.replace('bank-list.php');</script> <?php	    
		} }
		
		?>