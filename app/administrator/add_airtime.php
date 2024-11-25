<?php 
require_once('../db.php');

$error = array();
$resp = array();

$network = $_REQUEST['network']; 
$gateway = $_REQUEST['gateway'];
$discount = floatval($_REQUEST['discount']);
$userdiscount = floatval($_REQUEST['userdiscount']);
 //////////////////////
if(empty($network)){
  $error[] = "Select Network"; 

}





if(count($error) > 0){
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();
}

//checking 
 $ExtId = $conn->query("SELECT * FROM airtime_package WHERE network='$network' "); 
 if($ExtId->num_rows > 0){
     $ftrow = $ExtId->fetch_assoc();
     $d1_fetch = $ftrow['network'];
      $d2_fetch = $ftrow['gateway'];
      $d3_fetch = $ftrow['discount'];
    $d4_fetch = $ftrow['user_discount'];    
   if(!empty($discount)){ $discount_fetch = $discount; } else{ $discount_fetch = $d3_fetch; }
   if(!empty($userdiscount)){ $userdiscount_fetch = $userdiscount; } else{ $userdiscount_fetch = $d4_fetch; }
    if(!empty($gateway)){ $gateway_fetch = $gateway; } else{ $gateway_fetch = $d2_fetch; } 
     
     $var_epinsUp = $conn->query("UPDATE airtime_package SET network='$d1_fetch',gateway='$gateway_fetch',discount='$discount_fetch',user_discount='$userdiscount_fetch' WHERE network='$network'");
    if($var_epinsUp){ 
        
$resp['msg'] = strtoupper($network)." - $plan Updated";
$resp['status'] = true;
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error = strtoupper($network)." - $plan  update failed";
     $resp['msg'] = $error;
    $resp['status'] = false;
     echo json_encode($error);
exit(); 
            }
            
            
 }else{
 
 $Insert_epinsUp = $conn->query("INSERT INTO airtime_package(network,gateway,discount)
  
  VALUES('$network','$gateway','$discount')");

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