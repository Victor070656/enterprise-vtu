<?php 
require_once('../db.php');

$error = array();
$resp = array();

$network = $_POST['duration']; 
$plan = $_POST['plan']; 
$amount = floatval($_POST['amount']); 
$commission = floatval($_POST['commission']);


 //////////////////////
if(empty($network)){
  $error[] = "Select Duration"; 
 
}

if(empty($plan)){
  $error[] = "Enter Package name"; 

}

if(empty($amount)){
  $error[] = "Enter Amount"; 

}

if(empty($commission)){
  $error[] = "Enter Commission"; 
 
}


if(count($error) > 0){
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();
}

//checking 
 $ExtId = $conn->query("SELECT * FROM epin_package WHERE duration='$network' AND plan='$plan' AND amount='$amount'"); 
 if($ExtId->num_rows > 0){
     $ftrow = $ExtId->fetch_assoc();
     $d1_fetch = $ftrow['duration'];
     $d2_fetch = $ftrow['plan'];
     $d3_fetch = $ftrow['amount'];
     $d4_fetch = $ftrow['commission'];
 
     if(empty($network)){ $d1 = $d1_fetch; }else{ $d1 = $network; }
       if(empty($plan)){ $d2 = $d2_fetch; }else{ $d2 = $plan; }
       if(empty($amount)){ $d3 = $d3_fetch; }else{ $d3 = $amount; }
    if(empty($commission)){ $d4 = $d4_fetch; }else{ $d4 = $commission; } 
     
   
         
     $var_epinsUp = $conn->query("
     UPDATE epin_package SET 
     
     duration='$d1',plan='$d2',amount='$d3',commission='$commission'
     
     WHERE duration='$network' AND plan='$plan' AND amount='$amount'");
    if($var_epinsUp){ 
        
$resp['msg'] = "$plan PACKAGE Updated";
$resp['status'] = true;
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error[] = "$plan PACKAGE update failed";
     $resp['status'] = false;
     echo json_encode($error);
exit(); 
            }
 }else{
 
 $Insert_epinsUp = $conn->query("INSERT INTO epin_package(duration,plan,amount,commission)
  
  VALUES('$network','$plan','$amount','$commission')");

 //////////////////////
if($Insert_epinsUp){
    // response

$resp['msg'] = " $plan PACKAGE Added";
$resp['status'] = true;
echo json_encode($resp);
exit(); 

}else{
    $error[] = "Error processing your request";
    $resp['status'] = false;
    echo json_encode($resp);
    exit();   

} }



?>