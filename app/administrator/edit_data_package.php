<?php 
require_once('../db.php');

$error = array();
$resp = array();

$network = $_POST['network']; 
$dataType = $_POST['datatype']; 
$plan = $_POST['plan']; 
$varcode = $_POST['code']; 
$clientcode = $_POST['clientcode']; 
$userPrice = floatval($_POST['userprice']);
$apiprice = floatval($_POST['apiprice']);
$gateway = $_POST['gateway'];
$sn = $_POST['sn'];
 //////////////////////
if(empty($network)){
  $error[] = "Select Network"; 
  
}
if(empty($dataType)){
  $error[] = "Select Data Type"; 
 
}

if(empty($plan)){
  $error[] = "Enter Data plan"; 
 
}

if(empty($varcode)){
  $error[] = "Enter Data plan code"; 
 
}

if(empty($userPrice)){
  $error[] = "Enter User Price"; 
 
}

if(empty($apiprice )){
  $error[] = "Enter API Price"; 
  
}

if(empty($gateway)){
  $error[] = "Select Gateway"; 
 
}

if(count($error) > 0){
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();
}


if($network == '01'){$provider = "mtn"; }
if($network == '02'){$provider = "glo"; }
if($network == '03'){$provider = "9mobile"; }
if($network == '04'){$provider = "airtel"; }
//checking 
    $var_epinsUp = $conn->query("UPDATE data_package SET network='$network',datatype='$dataType',plan='$plan',plancode='$varcode',clientcode='$clientcode',price_user='$userPrice',price_api='$apiprice',gateway='$gateway' WHERE serial='$sn'");
    if($var_epinsUp){ 
        
$resp['msg'] = strtoupper($provider)." DATA PACKAGE Updated";
$resp['status'] = true;
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error[] = strtoupper($provider)." Data PACKAGE update failed";
     $resp['status'] = false;
     $resp['msg'] = $error;
     echo json_encode($error);
exit(); 
            }
 

?>