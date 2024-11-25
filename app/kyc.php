<?php 
require_once('db.php');
$dataky = json_decode(file_get_contents('php://input'),true);
$error  = array();
$resp = array();

$name = $dataky['fname'];
$phone = $dataky['phone'];
$bvn = $dataky['bvn'];
$email = $dataky['email'];

///////////////////////
if(empty($name)){
  $error[] = "Enter your full name"; 
}
if(empty($phone)){
  $error[] = "Enter your registered phone number"; 
}

if(empty($bvn)){
  $error[] = "Enter your BVN"; 
}

if(count($error) > 0){
$resp['msg'] = $error;
$resp['status'] = false;
echo json_encode($resp);
exit();
}

if(fetchkyc($conn,$email,$phone) > 0){
    
    $error[] = "Request under review.";
     $resp['status'] = false;
     $resp['msg'] = $error;
     echo json_encode($resp);
exit(); 
    
}else{
    

 if(submitkyc($conn,$name,$phone,$bvn,$email)){ 
        
$resp['msg'] = "Request received. You will be notified once approved. Thank you!";
$resp['status'] = true;
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error[] = "Unable to process your request at the moment.";
     $resp['status'] = false;
     $resp['msg'] = $error;
     echo json_encode($resp);
exit(); 
            }
}


function submitkyc($conn,$name,$phone,$bvn,$email){
$Qrinsert = $conn->query("INSERT INTO kyc_info(name,phone,bvn,email,status)
VALUES('$name','$phone','$bvn','$email','Pending')");    
return $Qrinsert;    
}

function fetchkyc($conn,$email,$phone){
$qrr = $conn->query("SELECT * FROM kyc_info WHERE email='$email' OR bvn='$bvn' AND status='Pending' AND phone='$phone'"); 
$row = $qrr->num_rows;
return $row;
}
?>