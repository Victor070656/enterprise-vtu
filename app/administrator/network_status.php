<?php 
require_once('../db.php');

$error = array();
$resp = array();

$network = $_REQUEST['network']; 
$dataType = $_REQUEST['datatype']; 
$status = $_REQUEST['status'];
file_put_contents('pin.txt',$dataType.$status.$network);
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

 $jsonData = json_decode(fetchDataType($conn,$network,$dataType)); 
  
  foreach ($jsonData as $item){
           
for ( $i = 0, $m = count($item); $i < $m; $i++){

UpdateMultiple($conn,$status,$dataType,$network);
 
  }  }
       
$resp['msg'] = strtoupper($provider.' '.$dataType.' '.$status);
$resp['status'] = true;
$resp['redirect'] = "data-pricing.php"; 
echo json_encode($resp); 
exit(); 
        
        

         

function fetchDataType($conn,$network,$dataType){
$fetchRecord = $conn->query("SELECT * FROM data_package WHERE network='$network' AND datatype='$dataType'");
while($rowz[] = $fetchRecord->fetch_assoc()){}
return json_encode($rowz);
}  
function UpdateMultiple($conn,$status,$dataType,$network){    
$UpdateAll = $conn->query("UPDATE data_package SET status='$status' WHERE datatype='$dataType' AND network='$network'");
return $UpdateAll;
}
?>