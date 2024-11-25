<?php 
require_once('../db.php');
$error = array();
$resp = array();
///////////////////////////Update DATA ID////////////////////////////

$network = $_POST['network']; 
$dataType = $_POST['datatype']; 
$plan = $_POST['plan']; 
$varcode = $_POST['code']; 
$clientcode = $_POST['clientcode'];
$userPrice = floatval($_POST['userprice']);
$apiprice = floatval($_POST['apiprice']);
$gateway = $_POST['gateway'];

 //////////////////////
if(empty($network)){
  $error[] = "Select Network"; 
}
if(empty($dataType)){
  $error[] = "Select Data Type"; 
}

if(empty($gateway)){
  $error[] = "Select Gateway Provider"; 

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
 $ExtId = $conn->query("SELECT * FROM data_package WHERE plancode='$varcode' AND network='$network' AND datatype='$dataType' AND plan='$plan' AND gateway='$gateway'"); 
 if($ExtId->num_rows > 0){
     $ftrow = $ExtId->fetch_assoc();
     $d1_fetch = $ftrow['network'];
     $d2_fetch = $ftrow['datatype'];
     $d3_fetch = $ftrow['plan'];
     $d4_fetch = $ftrow['code'];
     $d5_fetch = $ftrow['price_user'];
     $d6_fetch = $ftrow['price_api'];
     $d7_fetch = $ftrow['gateway'];
     $d8_fetch = $ftrow['clientcode'];
  
     
     if(empty($network)){ $d1 = $d1_fetch; }else{ $d1 = $network; }
      if(empty($dataType)){ $d2 = $d2_fetch; }else{ $d2 = $dataType; }
       if(empty($plan)){ $d3 = $d3_fetch; }else{ $d3 = $plan; }
       if(empty($varcode)){ $d4 = $d4_fetch; }else{ $d4 = $varcode; }
    if(empty($userPrice)){ $d5 = $d5_fetch; }else{ $d5 = $userPrice; } 
    if(empty($apiprice)){ $d6 = $d6_fetch; }else{ $d6 = $apiprice; } 
    if(empty($gateway)){ $d7 = $d7_fetch; }else{ $d7 = $gateway; } 
    if(empty($clientcode)){ $d8 = $d8_fetch; }else{ $d8 = $clientcode; }
         
     $var_epinsUp = $conn->query("
     UPDATE data_package SET 
     
     network='$d1',datatype='$d2',plan='$d3',plancode='$d4',price_user='$d5',price_api='$d6',gateway='$d7',clientcode='$d8'
     
     WHERE plancode='$varcode' AND network='$network' AND datatype='$dataType' AND plan='$plan' AND gateway='$gateway'");
    if($var_epinsUp){ 
        
$resp['msg'] = strtoupper($provider)." DATA PACKAGE Updated";
$resp['status'] = true;
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error[] = strtoupper($provider)." Data PACKAGE update failed";
     $resp['msg'] = $error;
    $resp['status'] = false;
     echo json_encode($error);
exit(); 
            }
 }else{
 $Defualt_status = "enabled";
 $Insert_epinsUp = $conn->query("INSERT INTO data_package(network,datatype,plan,plancode,price_user,price_api,gateway,clientcode,status)
  
  VALUES('$network','$dataType','$plan','$varcode','$userPrice','$apiprice','$gateway','$clientcode','$Defualt_status')");

if($Insert_epinsUp){
    // response

$resp['msg'] = strtoupper($provider)." DATA PACKAGE Added";
$resp['status'] = true;
echo json_encode($resp);
exit(); 

}else{
    $error[] = "Error processing your request";
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();   

} }



?>