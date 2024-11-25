<?php 
require_once('../db.php');

///////////////////////////Update DATA ID////////////////////////////
$error  = array();
$resp = array();
$network = $_REQUEST['datatype']; 
$user = $_REQUEST['user']; 
$api = $_REQUEST['api']; 

///////////////////////
if(empty($network)){
  $error[] = "Select Service type"; 
}

if(empty($user)){
  $error[] = "Enter normal user fee"; 
}

if(empty($api)){
  $error[] = "Enter API user fee";
}

if(count($error) > 0){
$resp['msg'] = $error;
$resp['status'] = false;
echo json_encode($resp);
exit();
}


//checking 
 $ExtId = $conn->query("SELECT * FROM charges WHERE service='$network'"); 
 if($ExtId->num_rows > 0){
     $ftrow = $ExtId->fetch_assoc();
     $d1_fetch = $ftrow['service'];
     $d2_fetch = $ftrow['user'];
     $d3_fetch = $ftrow['api'];
    
 
     if(empty($network)){ $d1 = $d1_fetch; }else{ $d1 = $network; }
       if(empty($user)){ $d2 = $d2_fetch; }else{ $d2 = $user; }
       if(empty($api)){ $d3 = $d3_fetch; }else{ $d3 = $api; }
   
         
     $var_epinsUp = $conn->query("
     UPDATE charges SET 
     
     service='$d1',user='$d2',api='$d3' WHERE service='$network'");
    if($var_epinsUp){ 
        
$resp['msg'] = "$network Updated";
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
 }else{
 
 $Insert_epinsUp = $conn->query("INSERT INTO charges(service,user,api)
  
  VALUES('$network','$user','$api')");

 //////////////////////
if($Insert_epinsUp){
    // response

$resp['msg'] = "$network Fee Added";
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