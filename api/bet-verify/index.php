<?php
date_default_timezone_set ( 'Africa/Lagos' ); 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");
include('../Connections/dbQuery.php');


	// API parameter
    
//	if(isset($_REQUEST['apikey']) && isset($_REQUEST['customerId'])){

	// API parameter
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	// get posted data
    $get_data = json_decode(file_get_contents("php://input"));
	if(isset($get_data)){
	$apikey = $conn->real_escape_string(test_input($get_data->apikey));
	$customerID = $conn->real_escape_string(test_input($get_data->customerId));
	}else{
	 $apikey = $conn->real_escape_string(test_input($_REQUEST['apikey']));
	$customerID = $conn->real_escape_string(test_input($_REQUEST['customerId']));   
	}
	
	$auth = "paid";
	
	
	// check if the account is valid

	
	$retr = mysqli_query($conn,"SELECT * FROM eP_customer WHERE apikey='$apikey' ");

	$rob = mysqli_fetch_array($retr);
	
	$user = $rob['apikey'];
	$aut = $rob['level'];
	
	$arr = array("$apikey","$auth");
	
	$pair = array("$user","$aut");		
	
	if($arr === $pair){
	    
$qryApi = mysqli_query($conn,"SELECT * FROM shago");
$apidata = mysqli_fetch_array($qryApi);



$username = $apidata['username']; 
$password = $apidata['password']; 

$hashkey = $apidata['hashkey'];

$servcode = "BEV";

$param = array(
'serviceCode' => $servcode,
'type'	=> 'Bet9ja',
'customerId'	=> $customerID


);


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",

"hashKey: $hashkey"
 
  
));

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response,true);

	
$product ="Bet9ja Payment";
	

$nam = $result['name'];	   

$reference = $result['reference'];

$metr = $result['accountNumber'];

$due = "100";



	response(200,array("Customer"=>$nam,"reference"=>$reference,"accountNumber"=>$metr,"charge"=>$due));
	

	
  } 
  
 else{  
    
    response(103,"INVALID ACCOUNT"); 


    }


} // close wrong parameter



	  else{ 
	   
	   response(400,"INVALID PARAMETER"); 
	       
	       
	   }
	    

function response($status,$status_message)
{
	
	
	$response['code']=$status;
	$response['description']=$status_message;
	
	
	$json_response = json_encode($response);
	echo $json_response;
}
    
    ?>
    
  
   	

