<?php 
require_once('../db.php');

$error = array();
$resp = array();

$network = $_REQUEST['network']; 
$dataType = $_REQUEST['datatype']; 
$status = $_REQUEST['status'];
$serial = $_REQUEST['serial'];
file_put_contents('pin.txt',$dataType.$status.$network.$serial);
 //////////////////////
if(empty($network)){
  $error[] = "Select Network"; 
  
} 
if(empty($dataType)){
  $error[] = "Select Data Type"; 
}

if(count($error) > 0){
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();
}


if($network == '01'){$provider = "mtn"; }
if($network == '02'){$provider = "glo"; }
if($network == '03'){$provider = "9mobile"; }
if($network == '04'){$provider = "airtel"; }
//checking 
$json_package = json_decode(fetchDataType($conn,$network,$dataType,$serial));
if(UpdateSingle($conn,$status,$dataType,$network,$serial)){
 
$resp['msg'] = strtoupper($provider.' '.$json_package->plan .' '.$status);
$resp['status'] = true;
$resp['redirect'] = "data-pricing.php";
echo json_encode($resp);
exit(); 
} else {
 $error[] = "unable to process request";
 $resp['msg'] = $error;
$resp['status'] = false;
$resp['redirect'] = "data-pricing.php";
echo json_encode($resp);
exit();    
    
}        

function fetchDataType($conn,$network,$dataType,$serial){
$fetchRecord = $conn->query("SELECT * FROM data_package WHERE serial='$serial' AND network='$network' AND datatype='$dataType'");
$rowz = $fetchRecord->fetch_assoc();
return json_encode($rowz);
}  
function UpdateSingle($conn,$status,$dataType,$network,$serial){    
$Update_single = $conn->query("UPDATE data_package SET status='$status' WHERE serial='$serial' AND datatype='$dataType' AND network='$network'");
return $Update_single;
}
?>