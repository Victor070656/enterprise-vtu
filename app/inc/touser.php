<?php 
date_default_timezone_set("Africa/Lagos");
require_once('../db.php');
///////////////////////////Update DATA ID////////////////////////////
$data = json_decode(file_get_contents('php://input'), true);
$resp = array();
file_put_contents('ch.txt',file_get_contents('php://input'));
$Pin = htmlspecialchars(stripslashes(trim(intval($data['pin']))));
$userid = htmlspecialchars(stripslashes(trim($data['user'])));
if(empty($Pin)){
 $resp = "Enter PIN"; 
 echo json_encode($resp);
 exit();
}

if(empty($userid)){
 $resp = "User Id is required"; 
 echo json_encode($resp);
 exit();
}

$hashedPin = password_hash($Pin, PASSWORD_DEFAULT);
//$result = json_decode(fetchUser($conn,$userid),true);

 
if(SetPin($conn,$hashedPin,$userid)){

$resp['msg'] = "PIN Enabled";
$resp['status']  = true;
echo json_encode($resp);
exit();  

}else{
    
    $error[] = "Unable to set PIN. Please try again";
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();   

}


function SetPin($conn,$hashedPin,$userid){
$qryUp = $conn->query("UPDATE users SET acc='$hashedPin' WHERE email='$userid'");
return $qryUp;
}

function fetchUser($conn,$userid){
$res = $conn->query("SELECT * FROM users WHERE email='$userid'");
while($resUser[] = $res->fetch_assoc()){
}
return json_encode($resUser);
}


?>