<?php 
require_once('../db.php');

$error = array();
$resp = array();

$network = $_REQUEST['network']; 
$status = $_REQUEST['status'];

file_put_contents('k.txt',$network);
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
$json_package = json_decode(fetchDataType($conn,$network));
if(UpdateSingle($conn,$status,$network)){
 
$resp['msg'] = strtoupper($provider.' '.$json_package->network .' '.$status);
$resp['status'] = true;
$resp['redirect'] = "airtime_package.php";
echo json_encode($resp);
exit(); 
} else {
 $error[] = "unable to process request";
 $resp['msg'] = $error;
$resp['status'] = false;
$resp['redirect'] = "airtime_package.php"; 
echo json_encode($resp);
exit();    
    
}        

function fetchDataType($conn,$network){
$fetchRecord = $conn->query("SELECT * FROM airtime_package WHERE network='$network'");
$rowz = $fetchRecord->fetch_assoc();
return json_encode($rowz);
}  
function UpdateSingle($conn,$status,$network){    
$Update_single = $conn->query("UPDATE airtime_package SET status='$status' WHERE  network='$network'");
return $Update_single;
}
?>