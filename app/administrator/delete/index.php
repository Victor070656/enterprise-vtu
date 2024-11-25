<?php 
session_start();
require('../../db.php');
if(!isset($_SESSION["loggedin"])){
header("location: ../index.php");
  exit();
}else{
		
		
		if(isset($_GET['tv'])){
		   $tvsn = $_GET['tv']; 
		function tv($conn,$tvsn){
		 $Runqry = $conn->prepare("DELETE FROM tv_package WHERE serial=?");
		 $Runqry->bind_param("i",$tvsn);
		 $result_tv = $Runqry->execute();
		 return $result_tv;
		}
		if(tv($conn,$tvsn)){
	?><script>window.location.replace('../tv-pricing.php');</script> <?php	    
		} }
		
		
			if(isset($_GET['exam'])){
		   $exsn = $_GET['exam']; 
		function tv($conn,$exsn){
		 $ExRunqry = $conn->prepare("DELETE FROM exam_package WHERE serial=?");
		 $ExRunqry->bind_param("i",$exsn);
		 $result_ex = $ExRunqry->execute();
		 return $result_ex;
		}
		if(tv($conn,$exsn)){
	?><script>window.location.replace('../exam-pricing.php');</script> <?php	    
		} }
		
		
		
			if(isset($_GET['apk'])){
		   $apksn = $_GET['apk']; 
		function apk($conn,$apksn){
		 $Apk_qry = $conn->prepare("DELETE FROM providers_api_key WHERE serial=?");
		 $Apk_qry->bind_param("i",$apksn);
		 $result_apk = $Apk_qry->execute();
		 return $result_apk;
		}
		if(apk($conn,$apksn)){
	?><script>window.location.replace('../api_settings.php');</script> <?php	    
		} }
		
}
		
		?>