<?php 
require_once('../db.php');

///////////////////////////Update DATA ID////////////////////////////
$d500mRaw = $_POST['500m']; 
$d1Raw = $_POST['1g']; 
$d2Raw = $_POST['2g']; 
$d3Raw = $_POST['3g']; 
$d5Raw = $_POST['5g']; 
$d10Raw = $_POST['10g']; 
$d12Raw = $_POST['12g']; 
$d15Raw = $_POST['15g']; 
$d20Raw = $_POST['20g']; 
$d25Raw = $_POST['25g']; 
$d30Raw = $_POST['30g']; 
$d40Raw = $_POST['40g']; 
$d50Raw = $_POST['50g']; 
$d60Raw = $_POST['60g']; 
$d70Raw = $_POST['70g'];
$d75Raw = $_POST['75g'];
$d80Raw = $_POST['80g'];
$d90Raw = $_POST['90g'];
$d100Raw = $_POST['100g'];

$gateway = $_POST['gateway'];
$network = $_POST['network'];
$dataType = $_POST['datatype'];
 //////////////////////
if(empty($network)){
  $error = "Select Network"; 
  echo json_encode($error);
  exit();
}

if(empty($gateway)){
  $error = "Select API Provider"; 
  echo json_encode($error);
  exit();
}

if(empty($dataType)){
  $error = "Select Data Type"; 
  echo json_encode($error);
  exit();
}



 
//checking 
 $ExtId = $conn->query("SELECT * FROM epins_dataplan WHERE gateway='$gateway' AND network='$network' AND datatype='$dataType'"); 
 if($ExtId->num_rows > 0){
     $ftrow = $ExtId->fetch_assoc();
     $d500m_fetch = $ftrow['500m'];
     $d1_fetch = $ftrow['1g'];
     $d2_fetch = $ftrow['2g'];
     $d3_fetch = $ftrow['3g'];
     $d5_fetch = $ftrow['5g'];
     $d10_fetch = $ftrow['10g'];
     $d12_fetch = $ftrow['12g'];
     $d15_fetch = $ftrow['15g'];
     $d20_fetch = $ftrow['20g'];
     $d25_fetch = $ftrow['25g'];
     $d30_fetch = $ftrow['30g'];
     $d40_fetch = $ftrow['40g'];
     $d50_fetch = $ftrow['50g'];
     $d60_fetch = $ftrow['60g'];
     $d70_fetch = $ftrow['70g'];
     $d75_fetch = $ftrow['75g'];
     $d80_fetch = $ftrow['80g'];
     $d90_fetch = $ftrow['90g'];
     $d100_fetch = $ftrow['100g'];
     
     if(empty($d500mRaw)){ $d500m = $d500m_fetch; }else{ $d500m = $d500mRaw; }
     if(empty($d1Raw)){ $d1 = $d1_fetch; }else{ $d1 = $d1Raw; }
      if(empty($d2Raw)){ $d2 = $d2_fetch; }else{ $d2 = $d2Raw; }
       if(empty($d3Raw)){ $d3 = $d3_fetch; }else{ $d3 = $d3Raw; }
        if(empty($d5Raw)){ $d5 = $d5_fetch; }else{ $d5 = $d5Raw; }
         if(empty($d10Raw)){ $d10 = $d10_fetch; }else{ $d10 = $d10Raw; }
         
    if(empty($d12Raw)){ $d12 = $d12_fetch; }else{ $d12 = $d12Raw; }  
    if(empty($d15Raw)){ $d15 = $d15_fetch; }else{ $d15 = $d15Raw; }
    if(empty($d20Raw)){ $d20 = $d20_fetch; }else{ $d20 = $d20Raw; }
    if(empty($d25Raw)){ $d25 = $d25_fetch; }else{ $d25 = $d25Raw; }
    if(empty($d30Raw)){ $d30 = $d30_fetch; }else{ $d30 = $d30Raw; }
    if(empty($d40Raw)){ $d40 = $d40_fetch; }else{ $d40 = $d40Raw; }
    if(empty($d50Raw)){ $d50 = $d50_fetch; }else{ $d50 = $d50Raw; }
    if(empty($d60Raw)){ $d60 = $d60_fetch; }else{ $d60 = $d60Raw; }
    if(empty($d70Raw)){ $d70 = $d70_fetch; }else{ $d70 = $d70Raw; }
    if(empty($d75Raw)){ $d75 = $d75_fetch; }else{ $d75 = $d75Raw; }
    if(empty($d80Raw)){ $d80 = $d80_fetch; }else{ $d80 = $d80Raw; }
    if(empty($d90Raw)){ $d90 = $d90_fetch; }else{ $d90 = $d90Raw; }
    if(empty($d100Raw)){ $d100 = $d100_fetch; }else{ $d100 = $d100Raw; }
     
     $var_epinsUp = $conn->query("
     UPDATE epins_dataplan SET 
     
     500m='$d500m',1g='$d1',2g='$d2',3g='$d3',5g='$d5',10g='$d10',12g='$d12',15g='$d15',20g='$d20',25g='$d25',30g='$d30',40g='$d40',50g='$d50',60g='$d60',70g='$d70',75g='$d75',80g='$d80',90g='$d90',100g='$d100' 
     
     WHERE gateway='$gateway' AND network='$network' AND datatype='$dataType' ");
    if($var_epinsUp){ 
$resp = strtoupper($gateway)." DATA Variation Updated";
echo json_encode($resp);
exit; 
         
     }else{
     
     $error = strtoupper($gateway)." Data ID update failed";
     echo json_encode($error);
exit(); 
            }
 }else{
 
 $Insert_epinsUp = $conn->query("INSERT INTO epins_dataplan(
 500m,1g,2g,3g,5g,10g,12g,15g,20g,25g,30g,40g,50g,60g,70g,75g,80g,90g,100g,gateway,network,datatype)
  
  VALUES('$d500m','$d1','$d2','$d3','$d5','$d10','$d12','$d15','$d20','$d25','$d30','$d40','$d50','$d60','$d70','$d75','$d80','$d90','$d100','$gateway','$network','$dataType')");

 //////////////////////
if($Insert_epinsUp){
    // response

$resp = strtoupper($gateway)." DATA Variation Added";
echo json_encode($resp);
exit; 

}else{
    $error = "Error processing your request";
    echo json_encode($resp);
    exit;   

} }



?>