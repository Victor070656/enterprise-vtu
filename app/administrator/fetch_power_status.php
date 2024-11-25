<?php 
require_once('../db.php');

$error = array();
$resp = array();

$network = $_REQUEST['nwk']; 


file_put_contents('f.txt',$network);
 //////////////////////
if(empty($network)){
  $error[] = "Select Disco"; 
  
} 


if(count($error) > 0){
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();
}

//checking 
$json_package = json_decode(fetchDataType($conn,$network));

$resp['msg'] = $json_package->status;
$resp['status'] = true;
echo json_encode($resp);
exit(); 
     

function fetchDataType($conn,$network){
$fetchRecord = $conn->query("SELECT * FROM electric_package WHERE network='$network'");
$rowz = $fetchRecord->fetch_assoc();
return json_encode($rowz);
}  

?>