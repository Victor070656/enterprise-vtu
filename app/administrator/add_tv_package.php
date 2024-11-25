<?php 
require_once('../db.php');

$error = array();
$resp = array();

$network = $_POST['network']; 
$plan = $_POST['plan']; 
$varcode = $_POST['code']; 
$clientcode = $_POST['clientcode']; 
$userPrice = floatval(intval($_POST['amount']));
$gateway = $_POST['gateway'];

 //////////////////////
if(empty($network)){
  $error[] = "Select Network"; 

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
  $error[] = "Enter Plan Amount"; 

}

if(count($error) > 0){
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();
}

//checking 
 $ExtId = $conn->query("SELECT * FROM tv_package WHERE plancode='$varcode' AND network='$network' AND plan='$plan' AND gateway='$gateway'"); 
 if($ExtId->num_rows > 0){
     $ftrow = $ExtId->fetch_assoc();
     $d1_fetch = $ftrow['network'];
     $d2_fetch = $ftrow['plan'];
     $d3_fetch = $ftrow['plancode'];
     $d4_fetch = $ftrow['amount'];
      $d5_fetch = $ftrow['gateway'];
      $d6_fetch = $ftrow['clientcode'];
 
     if(empty($network)){ $d1 = $d1_fetch; }else{ $d1 = $network; }
       if(empty($plan)){ $d2 = $d2_fetch; }else{ $d2 = $plan; }
       if(empty($varcode)){ $d3 = $d3_fetch; }else{ $d3 = $varcode; }
    if(empty($userPrice)){ $d4 = $d4_fetch; }else{ $d4 = $userPrice; } 
     if(empty($gateway)){ $d5 = $d5_fetch; }else{ $d5 = $gateway; } 
     if(empty($clientcode)){ $d6 = $d6_fetch; }else{ $d6 = $clientcode; }
   
         
     $var_epinsUp = $conn->query("
     UPDATE tv_package SET 
     
     network='$d1',plan='$d2',plancode='$d3',amount='$d4',gateway='$gateway'
     
     WHERE plancode='$varcode',clientcode='$d6' AND network='$network' AND plan='$plan' AND gateway='$gateway'");
    if($var_epinsUp){ 
        
$resp['msg'] = strtoupper($network)."$plan PACKAGE Updated";
$resp['status'] = true;
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error = strtoupper($network)." $plan PACKAGE update failed";
     $resp['msg'] = $error;
    $resp['status'] = false;
     echo json_encode($error);
exit(); 
            }
 }else{
 
 $Defualt_status = "enabled";
 $Insert_epinsUp = $conn->query("INSERT INTO tv_package(network,plan,plancode,amount,gateway,clientcode,status)
  
  VALUES('$network','$plan','$varcode','$userPrice','$gateway','$clientcode','$Defualt_status')");

 //////////////////////
if($Insert_epinsUp){
    // response

$resp['msg'] = strtoupper($network)." $plan PACKAGE Added";
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