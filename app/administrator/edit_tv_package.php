<?php 
require_once('../db.php');

///////////////////////////Update DATA ID////////////////////////////
$network = $_POST['network']; 
$plan = $_POST['plan']; 
$varcode = $_POST['code']; 
$clientcode = $_POST['clientcode']; 
$userPrice = floatval($_POST['userprice']);
$sn = $_POST['sn'];
$gateway = $_POST['gateway'];
 //////////////////////
if(empty($network)){
  $error = "Select Provider"; 
  echo json_encode($error);
  exit();
}

if(empty($plan)){
  $error = "Enter TV plan"; 
  echo json_encode($error);
  exit();
}

if(empty($varcode)){
  $error = "Enter TV plan code"; 
  echo json_encode($error);
  exit();
}

if(empty($userPrice)){
  $error = "Enter Amount"; 
  echo json_encode($error);
  exit();
}

if(empty($gateway)){
  $error = "Select Gateway"; 
  echo json_encode($error);
  exit();
}

//checking 
    $var_epinsUp = $conn->query("UPDATE tv_package SET network='$network',plan='$plan',plancode='$varcode',clientcode='$clientcode',amount='$userPrice',gateway='$gateway' WHERE serial='$sn'");
    if($var_epinsUp){ 
        
$resp = strtoupper($network)." $plan PACKAGE Updated";
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error = strtoupper($network)." $plan PACKAGE update failed";
     echo json_encode($error);
exit(); 
            }
 

?>