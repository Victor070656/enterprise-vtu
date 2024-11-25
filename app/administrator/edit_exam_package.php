<?php 
require_once('../db.php');

///////////////////////////Update DATA ID////////////////////////////
$network = $_POST['network']; 
$plan = $_POST['plan']; 
$varcode = $_POST['code']; 
$clientcode = $_POST['clientcode']; 
$userPrice = intval($_POST['userprice']);
$apiprice = intval($_POST['apiprice']);
$sn = $_POST['sn'];
$gateway = $_POST['gateway'];
 //////////////////////
if(empty($network)){
  $error = "Select Provider"; 
  echo json_encode($error);
  exit();
}

if(empty($plan)){
  $error = "Enter Exam plan"; 
  echo json_encode($error);
  exit();
}

if(empty($varcode)){
  $error = "Enter Exam plan code"; 
  echo json_encode($error);
  exit();
}

if(empty($userPrice)){
  $error = "Enter User Price"; 
  echo json_encode($error);
  exit();
}

if(empty($apiprice )){
  $error = "Enter API Price"; 
  echo json_encode($error);
  exit();
}

if(empty($gateway)){
  $error = "Select Gateway"; 
  echo json_encode($error);
  exit();
}

//checking 
    $var_epinsUp = $conn->query("UPDATE exam_package SET network='$network',plan='$plan',plancode='$varcode',price_user='$userPrice',gateway='$gateway',price_api='$apiprice',clientcode='$clientcode' WHERE serial='$sn'");
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