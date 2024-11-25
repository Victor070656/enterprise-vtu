<?php 
require_once('../db.php');

///////////////////////////Update DATA ID////////////////////////////
$network = $_POST['network']; 
$plan = $_POST['plan']; 
$amount = intval($_POST['amount']);
$commission = intval($_POST['commission']);
$sn = $_POST['sn'];

 //////////////////////
if(empty($network)){
  $error = "Select Duration"; 
  echo json_encode($error);
  exit();
}

if(empty($plan)){
  $error = "Enter Package name"; 
  echo json_encode($error);
  exit();
}



if(empty($amount)){
  $error = "Enter Amount"; 
  echo json_encode($error);
  exit();
}

if(empty($commission )){
  $error = "Enter commission value"; 
  echo json_encode($error);
  exit();
}


//checking 
    $var_epinsUp = $conn->query("UPDATE epin_package SET duration='$network',plan='$plan',amount='$amount',commission='$commission' WHERE serial='$sn'");
    if($var_epinsUp){ 
        
$resp = strtoupper($plan)." PACKAGE Updated";
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error = strtoupper($plan)." PACKAGE update failed";
     echo json_encode($error);
exit(); 
            }
 

?>