<?php
session_start();
require('../../db.php');
if(!isset($_SESSION["loggedin"]) ){
header("location: index.php");
   exit;
	}

$netwok = $_SESSION['net'];
$variation = $_SESSION['var'];

if($variation == '1'){ $dno = '100'; }
if($variation == '2'){ $dno = '200'; }
if($variation == '4'){ $dno = '400'; }
if($variation == '5'){ $dno = '500'; }
if($variation == '7.5'){ $dno = '750'; }
if($variation == '10'){ $dno = '1000'; }
if($variation == '15'){ $dno = '1500'; }

$pinfilename = " ".$netwok."_".$dno."_pins.txt";
$fp = fopen('php://output', 'w');

header('Content-type: application/txt');
header('Content-Disposition: attachment; filename='.$pinfilename);
header('Cache-Control: no-cache');

$fieldpin = $_SESSION['pin'];
	
fwrite($fp, "$fieldpin" ."");  fwrite($fp, "\n"); 
	
$delxp = $conn->query("DELETE FROM mypin WHERE pins='$fieldpin'");	
	
if($delxp){
unset($_SESSION['net']);
unset($_SESSION['var']);
//unset($_SESSION['pin']); 
}	

exit;



?>