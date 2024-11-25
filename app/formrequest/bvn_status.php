<?php
header("Content-Type: application/json; charset=UTF-8");
$error = array();
$resp = array();
//file_put_contents('airtime.txt',file_get_contents('php://input'));
$jsData = json_decode(file_get_contents('php://input'));

$id = $jsData->id;

if(empty($id)){
$error[] = "Account Id is empty";    
}
require_once('../db.php');

if(CheckAccount($conn,$id) > 0) {
$resp['status'] = true;
$resp['msg'] = "success";
echo json_encode($resp);
exit(); 

} else if (ExistNotActive($conn,$id) > 0 ) { 
    
$error[] = "inactive"; 
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();    
} else if(ExistNotActive($conn,$id) == 0) {
  
$error[] = "none"; 
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();      
    
}

function CheckAccount($conn,$id){
$query = $conn->query("SELECT * FROM auto_funding WHERE id='$id' AND status='active'");
$row = $query->num_rows;
return $row;
}

function ExistNotActive($conn,$id){
$query = $conn->query("SELECT * FROM auto_funding WHERE id='$id'");
$row = $query->num_rows;
return $row;
}

?>