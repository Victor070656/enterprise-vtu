<?php
require_once('../db.php');
$data = json_decode(file_get_contents('php://input'),true);
$error = array();
$res = array();
file_put_contents('v.txt',file_get_contents('php://input'));

$email = $data['vmail'];

if(empty($email)){
$error[] = "Unauthorized";    
}

if(count($error) > 0){
$res['status'] =  false;
$res['msg'] = $error;
echo json_encode($res);
exit();
}

$fetchStatus = json_decode(checkStatus($conn,$email));

if(checkkyc($conn,$email)> 0 && $fetchStatus->status === 'Approved'){
  $res['status'] = true;
  $res['msg'] = "Approved";
  echo json_encode($res);
  exit();
    
}else {
  
  $error[] = "You are not authorized for this service."; 
  $res['status'] = false;
  $res['msg'] = $error;
  echo json_encode($res);
  exit();
  
    
}

function checkStatus($conn,$email){
$Stqrr = $conn->query("SELECT * FROM kyc_info WHERE email='$email'"); 
$strow = $Stqrr->fetch_assoc();
return json_encode($strow);
}

function checkkyc($conn,$email){
$qrr = $conn->query("SELECT * FROM kyc_info WHERE email='$email' AND status='Approved'"); 
$row = $qrr->num_rows;
return $row;
}

function fetchkyc($conn,$email){
$qrr = $conn->query("SELECT * FROM kyc_info WHERE email='$email'"); 
while($row[] = $qrr->fetch_assoc()){}
return json_encode($row);
}
?>