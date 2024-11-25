<?php
session_start();
require_once('../../db.php');
$variation = $_SESSION['var'];
$qty = $_SESSION['qty'];
$serviceID = $_SESSION['net'];
$variation_code = $_SESSION['cat'];
$Usermail = $_SESSION['uemail'];
if($serviceID == '01'){ 
	    
	    $Network = "mtn";  
	  }elseif($serviceID == '04'){
	      
	     $Network = "airtel"; 
	  }elseif($serviceID == '02'){
	      
	    $Network = "glo";  
	  }elseif($serviceID == '03'){
	   $Network = "9mobile";   
	      
	  }
$pinfilename = " ".$qty."_".$variation."_pins.txt";
$fp = fopen('php://output', 'w');

header('Content-type: application/txt');
header('Content-Disposition: attachment; filename='.$pinfilename);
header('Cache-Control: no-cache');

$fieldpin = $_SESSION['pin'];
	
fwrite($fp, "$fieldpin" ."");  fwrite($fp, "\n"); 
	
$delxp = $conn->query("INSERT INTO purchased_pin(network,category,pins,email)VALUES('$Network','$variation_code','$fieldpin','$Usermail')");	
	
if($delxp){
unset($_SESSION['pin']);
unset($_SESSION['var']);
unset($_SESSION['qty']); 
unset($_SESSION['cat']); 
unset($_SESSION['uemail']); 
}	

exit;



?>