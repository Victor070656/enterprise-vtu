<?php 
require_once('../db.php');
$error = array();
$resp = array();
///////////////////////////Update DATA ID////////////////////////////

$network = $_REQUEST['network']; 
$plan = $_REQUEST['plan']; 
$varcode = $_REQUEST['code']; 
$userPrice = floatval($_REQUEST['userprice']);
$apiprice = floatval($_REQUEST['apiprice']);

 //////////////////////
if(empty($network)){
  $error[] = "Select Network"; 
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


//checking 
 $ExtId = $conn->query("SELECT * FROM pins_package WHERE code='$varcode' AND network='$network' AND plan='$plan'"); 
 if($ExtId->num_rows > 0){
     $ftrow = $ExtId->fetch_assoc();
     $d1_fetch = $ftrow['network'];
     $d3_fetch = $ftrow['plan'];
     $d4_fetch = $ftrow['code'];
     $d5_fetch = $ftrow['price_user'];
     $d6_fetch = $ftrow['price_api'];

  
     
     if(empty($network)){ $d1 = $d1_fetch; }else{ $d1 = $network; }
       if(empty($plan)){ $d3 = $d3_fetch; }else{ $d3 = $plan; }
       if(empty($varcode)){ $d4 = $d4_fetch; }else{ $d4 = $varcode; }
    if(empty($userPrice)){ $d5 = $d5_fetch; }else{ $d5 = $userPrice; } 
    if(empty($apiprice)){ $d6 = $d6_fetch; }else{ $d6 = $apiprice; } 
 
         
     $var_epinsUp = $conn->query("
     UPDATE pins_package SET 
     
     network='$d1',plan='$d3',code='$d4',price_user='$d5',price_api='$d6'
     
     WHERE code='$varcode' AND network='$network' AND plan='$plan'");
    if($var_epinsUp){ 
        
$resp['msg'] = strtoupper($network)." ePIN Package Updated";
$resp['status'] = true;
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error[] = strtoupper($network)." ePIns Package update failed";
     $resp['msg'] = $error;
    $resp['status'] = false;
     echo json_encode($error);
exit(); 
            }
 }else{
 
 $Insert_epinsUp = $conn->query("INSERT INTO pins_package(network,plan,code,price_user,price_api)
  
  VALUES('$network','$plan','$varcode','$userPrice','$apiprice')");

if($Insert_epinsUp){
    // response

$resp['msg'] = strtoupper($network)." ePins Package Added";
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