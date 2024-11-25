<?php 
require_once('../../db.php');
$error = array();
$resp = array();
$data = json_decode(file_get_contents('php://input'));
$gateway =  $data->gateway;
if(empty($gateway)){
$error[] = "Select gateway";    
}

if(count($error) > 0){
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();
}

function switchpay($conn,$gateway){
$sql_upd = $conn->query("UPDATE payment SET activepay='$gateway'"); 
return $sql_upd;
}
	
if(switchpay($conn,$gateway)){
    $resp['status'] = true;
    $resp['msg'] = "Gateway changed to ".$gateway;
    echo json_encode($resp);
    exit();
} else {
    
    $error[] = "Unable to process request";
    $resp['msg'] =  $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();
    
}

?>