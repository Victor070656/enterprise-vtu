<?php 
require_once('../db.php');
///////////////////////////Update DATA ID////////////////////////////
$plan = $_POST['plan']; 
$code = floatval($_POST['code']);
$sn = $_POST['sn'];

 //////////////////////

if(empty($plan)){
  $error = "Enter Bank Name"; 
  echo json_encode($error);
  exit();
}


if(empty($code)){
  $error = "Enter Bank Code"; 
  echo json_encode($error);
  exit();
}


//checking 
    $var_epinsUp = $conn->query("UPDATE bank_gateway SET bankname='$plan',bankcode='$code' WHERE serial='$sn'");
    if($var_epinsUp){ 
        
$resp = strtoupper($plan)." Updated";
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error = strtoupper($plan)." update failed";
     echo json_encode($error);
exit(); 
            }
 

?>