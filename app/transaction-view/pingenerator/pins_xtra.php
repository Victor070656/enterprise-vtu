<?php
session_start();
require('../../db.php');
if(!isset($_SESSION["loggedin"]) ){
header("location: index.php");
   exit;
	}
$userEm = $_SESSION['passId'];
$netPurch = $_SESSION['netw'];
$pinNos = $_SESSION['pin'];
$varPins = $_SESSION['vars'];

if($varPins == '1'){ $dn = '100'; }
if($varPins == '2'){ $dn = '200'; }
if($varPins == '4'){ $dn = '400'; }
if($varPins == '5'){ $dn = '500'; }
if($varPins == '7.5'){ $dn = '750'; }
if($varPins == '10'){ $dn = '1000'; }
if($varPins == '15'){ $dn = '1500'; }

$filename = " ".$netPurch."_".$dn."_pins.txt";
$fp = fopen('php://output', 'w');

header('Content-type: application/txt');
header('Content-Disposition: attachment; filename='.$filename);
header('Cache-Control: no-cache');


$PINquery = $conn->query("SELECT * FROM mypin WHERE email='$userEm' AND cat='$varPins' AND net='$netPurch' ");
while($row = mysqli_fetch_assoc($PINquery)) {
	
	$field = $row['pins'];
	
fwrite($fp, "$field" ."");  fwrite($fp, "\n"); 
	
$delxp = $conn->query("DELETE FROM mypin WHERE pins='$field'");	
	
if($delxp){
unset($_SESSION['netw']);
unset($_SESSION['pin']);
unset($_SESSION['vars']);
}	
}
mysqli_free_result($query); 
mysqli_close($conn);
exit;


?>