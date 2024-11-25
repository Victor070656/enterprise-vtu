<?php 
require_once('../db.php');
//file_put_contents('pin.txt',file_get_contents('php://input'));
$error = array();
$resp = array();

$network = $_REQUEST['network']; 
$dataType = $_REQUEST['datatype']; 
$plan = $_REQUEST['plan']; 
$userPrice = floatval($_REQUEST['userprice']);
$apiprice = floatval($_REQUEST['apiprice']);

$multiplier_user = floatval($_REQUEST['userprice_multiplier']);
$multiplier_api = floatval($_REQUEST['apiprice_multiplier']);
$sn = $_REQUEST['sn'];
 //////////////////////
if(empty($network)){
  $error[] = "Select Network"; 
  
}
if(empty($dataType)){
  $error[] = "Select Data Type"; 
 
}


if(empty($userPrice)){
  $error[] = "Enter User Price"; 
 
}

if(empty($apiprice )){
  $error[] = "Enter API Price"; 
  
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

 $jsonData = json_decode(fetchallprice($conn,$network,$dataType)); 
  
  foreach ($jsonData as $item){
           
for ( $i = 0, $m = count($item); $i < $m; $i++){
  $dataPlan = $item->plan;   
  $split =  preg_split('/[-\s:]/',$dataPlan);
 $dataValue = substr($split[0],0,-2);
   $xtrvalue = substr($dataValue,0,-2);
   
$u_price = strval(floatval($multiplier_user) * floatval($dataValue)); 
$ap_price = strval(floatval($multiplier_api) * floatval($dataValue));

 if( strpos($split[0],"GB") ) {

UpdateMultiple($conn,$u_price,$ap_price,$dataType,$network,$dataPlan);
}   
  }  }
        
$resp['msg'] = strtoupper($provider)." DATA PACKAGE Updated";
$resp['status'] = true;
$resp['redirect'] = "data-pricing.php";
echo json_encode($resp);
exit(); 
        
        

         

function fetchallprice($conn,$network,$dataType){
$fetchRecord = $conn->query("SELECT * FROM data_package WHERE network='$network' AND datatype='$dataType'");
while($rowz[] = $fetchRecord->fetch_assoc()){}
return json_encode($rowz);
}  
function UpdateMultiple($conn,$u_price,$ap_price,$dataType,$network,$dataPlan){    
$UpdateAll = $conn->query("UPDATE data_package SET price_user='$u_price',price_api='$ap_price' WHERE datatype='$dataType' AND network='$network' AND plan='$dataPlan'");
return $UpdateAll;
}
?>