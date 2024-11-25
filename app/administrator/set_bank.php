<?php 
require_once('../db.php');

///////////////////////////Update DATA ID////////////////////////////
$error  = array();
$resp = array();
$network = $_POST['gateway']; 


///////////////////////
if(empty($network)){
  $error[] = "Select Gateway"; 
}


if(count($error) > 0){
$resp['msg'] = $error;
$resp['status'] = false;
echo json_encode($resp);
exit();
}


//checking 
 $ExtId = $conn->query("SELECT * FROM bank_gateway_settings WHERE gateway='$network'"); 

     $ftrow = $ExtId->fetch_assoc();
     $d1_fetch = $ftrow['gateway'];
    
     if(empty($network)){ $d1 = $d1_fetch; }else{ $d1 = $network; }
       
   
         
     $var_epinsUp = $conn->query("
     UPDATE bank_gateway_settings SET gateway='$d1'");
    if($var_epinsUp){ 
        
$resp['msg'] = "Gateway changed to $network";
$resp['status'] = true;
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error[] = " $network update failed";
     $resp['status'] = false;
     $resp['msg'] = $error;
     echo json_encode($resp);
exit(); 
            }




?>