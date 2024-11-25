<?php
date_default_timezone_set ( 'Africa/Lagos' );
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../Connections/dbQuery.php");

$request_method=$_SERVER["REQUEST_METHOD"];

	// API parameter
    
// if(isset($_GET['apikey']) ){
	
	// API parameter
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
	
	// get posted data
   $data = json_decode(file_get_contents("php://input")); 
	if(!isset($data)){
	$apikey = $conn->real_escape_string(test_input($_GET['apikey']));
	}else{
	 $apikey = $conn->real_escape_string(test_input($data->apikey));   
	}
	$auth = "paid";
	
	$stat = "Completed";

	// check if the account is valid
	
	if($param){
	    
	    response(107,"BAD REQUEST");} else{
	
	$retr = mysqli_query($conn,"SELECT * FROM users WHERE apikey='$apikey' ");
	
	$rob = mysqli_fetch_array($retr);
	
	
	$userKey = $rob['apikey'];
	
	$aut = $rob['level'];
	
	$arr = array("$apikey","$auth");
	
	$pair = array("$userKey","$aut");	
	
	if($arr === $pair){
	    
	    // check if the user have balance
	
	$Qurygb = mysqli_query($conn,"SElECT * FROM users WHERE apikey = '$userKey' ");	
	$reco = mysqli_fetch_array($Qurygb);
	
	$upp_cas_lx = $reco['email'];
	//extract account info
$Wafi_user_pros = $conn->prepare("SELECT bal FROM users WHERE email=?");
$Wafi_user_pros->bind_Param("s",$upp_cas_lx);
$Wafi_user_pros->execute();
$Wafi_user_pros->store_result();
$Wafi_user_pros->bind_result($mid_wxpi);
$Wafi_user_pros->fetch();
$Wafi_user_pros->close();
	
	response(202, " $mid_wxpi" );
	
	
	
	
// close account not found
  } 
 else{  
    
    response(103,"INVALID ACCOUNT"); 


    }


} // close wrong parameter



	}   else{ 
	   
	   response(400,"INVALID PARAMETER"); 
	       
	       
	   }
	    

function response($status,$status_message)
{
	
	
	$response['status']=$status;
	$response['status_message']=$status_message;
	
	
	$json_response = json_encode($response);
	
	
	$deko = json_decode($json_response);
	
	echo $deko->status_message;
}

    ?>