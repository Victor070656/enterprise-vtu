<?php 
require_once('../db.php');

$error = array();
$resp = array();

$network = $_REQUEST['network']; 
$plan = strtoupper($network); 
$gateway = $_REQUEST['gateway'];
$discount = floatval($_REQUEST['discount']);
 //////////////////////
if(empty($network)){
  $error[] = "Select Service"; 

}






if(count($error) > 0){
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();
}

//checking 
 $ExtId = $conn->query("SELECT * FROM betting_package WHERE network='$network' "); 
 if($ExtId->num_rows > 0){
     $ftrow = $ExtId->fetch_assoc();
     $d1_fetch = $ftrow['network'];
     $d2_fetch = $ftrow['plan'];
      $d3_fetch = $ftrow['gateway'];
      $d4_fetch = $ftrow['discount'];

   if(!empty($discount)){$discount_fetch = $discount;} else{$discount_fetch = $d4_fetch; }   
     if(!empty($plan)){$plan_fetch = $plan;} else{ $plan_fetch = $d2_fetch; } 
     if(!empty($gateway)){$gateway_fetch = $gateway;} else{ $gateway_fetch = $d3_fetch; }
     
     $var_epinsUp = $conn->query("UPDATE betting_package SET network='$d1_fetch',plan='$plan_fetch',gateway='$gateway_fetch',discount='$discount_fetch' WHERE network='$network'");
    if($var_epinsUp){ 
        
$resp['msg'] = strtoupper($network)."  Updated";
$resp['status'] = true;
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error = strtoupper($network)." update failed";
     $resp['msg'] = $error;
    $resp['status'] = false;
     echo json_encode($error);
exit(); 
            }
            
            
 }else{
 $Defualt_status = "enabled";
 $Insert_epinsUp = $conn->query("INSERT INTO betting_package(network,plan,gateway,discount,status)
  
  VALUES('$network','$plan','$gateway','$discount','$Defualt_status')");

 //////////////////////
if($Insert_epinsUp){
    // response

$resp['msg'] = strtoupper($network)." PACKAGE Added";
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