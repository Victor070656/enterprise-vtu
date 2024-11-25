<?php 
require_once('../db.php');


///////////////////////////Update DATA ID////////////////////////////
$network = $_REQUEST['network']; 
$plan = $_REQUEST['plan']; 
$code = $_REQUEST['code'];
$amount = floatval($_REQUEST['amount']);
$apiPrice = floatval($_REQUEST['apiamount']);
$sn = $_REQUEST['sn'];

 //////////////////////
if(empty($network)){
  $error = "Network is empty"; 
  echo json_encode($error);
  exit();
}

if(empty($plan)){
  $error = "Denomination is empty"; 
  echo json_encode($error);
  exit();
}

if(empty($amount)){
  $error = "Enter Amount"; 
  echo json_encode($error);
  exit();
}

if(empty($apiPrice )){
  $error = "Enter API Price"; 
  echo json_encode($error);
  exit();
}


//checking 
    $var_epinsUp = $conn->query("UPDATE pins_package SET network='$network',plan='$plan',code='$code',price_user='$amount',price_api='$apiPrice' WHERE serial='$sn'");
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