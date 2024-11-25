<?php 
require_once('../db.php');

///////////////////////////Update DATA ID////////////////////////////

$plan = $_POST['plan']; 
$code = $_POST['code']; 

///////////////////////

if(empty($plan)){
  $error = "Enter Bank name"; 
  echo json_encode($error);
  exit();
}

if(empty($code)){
  $error = "Enter bank Code"; 
  echo json_encode($error);
  exit();
}



//checking 
 $ExtId = $conn->query("SELECT * FROM bank_gateway WHERE bankcode='$code'"); 
 if($ExtId->num_rows > 0){
     $ftrow = $ExtId->fetch_assoc();
     $d2_fetch = $ftrow['bankname'];
     $d3_fetch = $ftrow['bankcode'];
    
       if(empty($plan)){ $d2 = $d2_fetch; }else{ $d2 = $plan; }
       if(empty($code)){ $d3 = $d3_fetch; }else{ $d3 = $code; }
   
         
     $var_epinsUp = $conn->query("
     UPDATE banke_gateway SET bankname='$d2',bankcode='$d3' WHERE bankcode='$code'");
    if($var_epinsUp){ 
        
$resp = "$plan Updated";
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error = " $plan update failed";
     echo json_encode($error);
exit(); 
            }
 }else{
 
 $Insert_epinsUp = $conn->query("INSERT INTO bank_gateway(bankname,bankcode)
  
  VALUES('$plan','$code')");

 //////////////////////
if($Insert_epinsUp){
    // response

$resp = " $plan Added";
echo json_encode($resp);
exit(); 

}else{
    $error = "Error processing your request";
    echo json_encode($resp);
    exit();   

} }



?>