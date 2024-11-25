<?php
date_default_timezone_set ( 'Africa/Lagos' ); 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");
include('../Connections/dbQuery.php');

if(isset($_GET['service'])){
 
$SevNam = test_input($_GET['service']);
 if($SevNam =='gotv'){
     
function fetchGotv($conn){
    $qrGotv = $conn->query("SELECT network,plan,plancode,amount FROM tv_package WHERE network='gotv'");
    while($gotRow[] = $qrGotv->fetch_assoc()){}
    return $gotRow;
}     
     
 response(302,fetchGotv($conn));
	   
}

if($SevNam == 'dstv'){ 
    
function fetchDstv($conn){
    $qrDstv = $conn->query("SELECT network,plan,plancode,amount FROM tv_package WHERE network='dstv'");
    while($dstvRow[] = $qrDstv->fetch_assoc()){}
    return $dstvRow;
}  
 response(302,fetchDstv($conn));
	  
}

if($SevNam == 'startimes'){ 
    
function fetchStartimes($conn){
    $qrStartimes = $conn->query("SELECT network,plan,plancode,amount FROM tv_package WHERE network='startimes'");
    while($starRow[] = $qrStartimes->fetch_assoc()){}
    return $starRow;
}  
  response(302,fetchStartimes($conn));   
    
}

}

	
function response($status,$status_message)
{
	
	
	$response['code']=$status;
	$response['description']=$status_message;
	
	
	$json_response = json_encode($response);
	echo $json_response;
}
    
    ?>
    
  
   	

