<?php
date_default_timezone_set ( 'Africa/Lagos' ); 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");
include('../Connections/dbQuery.php');

	// API parameter
    
	// if(isset($_REQUEST['apikey']) && isset($_REQUEST['service']) && isset($_REQUEST['smartNo']) && $_REQUEST['type'] ){
	// API parameter
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	// get posted data
    $get_data = json_decode(file_get_contents("php://input")); 
    if(isset( $get_data)){
	$apikey = $conn->real_escape_string(test_input($get_data->apikey));
	$serviceID = $conn->real_escape_string(test_input($get_data->service));
	$smartNo = $conn->real_escape_string(test_input($get_data->smartNo));
	$type = $conn->real_escape_string(test_input($get_data->type));
    }else{
        
    $apikey = $conn->real_escape_string(test_input($_REQUEST['apikey']));
	$serviceID = $conn->real_escape_string(test_input($_REQUEST['service']));
	$smartNo = $conn->real_escape_string(test_input($_REQUEST['smartNo']));
	$type = $conn->real_escape_string(test_input($_REQUEST['type']));    
    }
	$auth = "paid";
	
	
	// check if the account is valid
if($serviceID ==='gotv'){
    $decoderNo = "IUC";
} else {
    
   $decoderNo = "Smartcard"; 
}
	
	$retr = mysqli_query($conn,"SELECT * FROM users WHERE apikey='$apikey' ");

	$rob = mysqli_fetch_array($retr);
	
	$userKey = $rob['apikey'];
	$aut = $rob['level'];
	
	$arr = array("$apikey","$auth");
	
	$pair = array("$userKey","$aut");		
	
	if($arr === $pair){
	    
$result = json_decode(verify($conn,$serviceID,$smartNo,$type));

if(is_null($result->description->Customer)){ 
    
  response(120,["Unable to verify $decoderNo Number"]);  
} else {


$nam = $result->description->Customer; 

$addr = $result->description->Address;

$metr = $result->description->MeterNumber;

$due = $result->description->Due_Date;

$sub_status = $result->description->Status;
$Current_Bouquet = $result->description->Current_Bouquet;
$Customer_Number = $result->description->Customer_Number;
$Renewal_Amount = $result->description->Renewal_Amount;

}

$array_chek = array("gotv","dstv","startimes");

if(in_array($serviceID,$array_chek)){
   
   response(119,array("Customer"=>$nam,"Renewal_Amount"=>$Renewal_Amount,"Customer_Number"=>$Customer_Number,"Due_Date"=>$due,"Status"=>$sub_status,"Current_Bouquet"=>$Current_Bouquet )); 
}else {
	response(119,array("Customer"=>$nam,"Address"=>$addr,"MeterNumber"=>$smartNo,"Due_Date"=>$due,"Status"=>$sub_status));
}
	
  } 
  
 else{  
    
    response(103,"INVALID ACCOUNT"); 


    }


} // close wrong parameter



	  else{ 
	   
	   response(400,"INVALID REQUEST METHOD"); 
	       
	       
	   }
	    

function response($status,$status_message)
{
	
	
	$response['code']=$status;
	$response['description']=$status_message;
	
	
	$json_response = json_encode($response);
	echo $json_response;
}


function verify($conn,$serviceID,$smartNo,$type){
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, urlbasemain()."/"."merchantvalidate/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "service" => $serviceID,
    "smartNo" => $smartNo,
    "type" => $type
    )));
$veridata = curl_exec($ch);
curl_close($ch);
file_put_contents('v.txt',$veridata);
return $veridata;
}

function urlbasemain(){
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/base?url=main");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$basedata = curl_exec($ch);
$result = json_decode($basedata,true);
//Close the cURL handle.
curl_close($ch);
return $result['description'][0]['main'];

	}


    ?>
    
  
   	

