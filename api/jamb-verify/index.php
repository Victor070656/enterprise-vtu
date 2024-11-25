<?php
date_default_timezone_set ( 'Africa/Lagos' ); 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include('../Connections/dbQuery.php');
include('../function/build.php');

	// API parameter
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	    
	    // get posted data
    $jdata = json_decode(file_get_contents("php://input")); 
	if(isset($jdata)){
	$apikey = $conn->real_escape_string(test_input($jdata->apikey));
	$serviceID = $conn->real_escape_string(test_input($jdata->service));
	$profile_code = $conn->real_escape_string(test_input($jdata->profilecode));
	$variation_code = $conn->real_escape_string(test_input($jdata->vcode));
	}else{
	    
	$apikey = $conn->real_escape_string(test_input($_REQUEST['apikey']));
	$serviceID = $conn->real_escape_string(test_input($_REQUEST['service']));
	$profile_code = $conn->real_escape_string(test_input($_REQUEST['profilecode']));
	$variation_code = $conn->real_escape_string(test_input($_REQUEST['vcode']));    
	}

	$auth = "paid";

	// check if the account is valid

	
	$retr = mysqli_query($conn,"SELECT * FROM users WHERE apikey='$apikey' ");

	$rob = mysqli_fetch_array($retr);
	
	$user = $rob['apikey'];
	$aut = $rob['level'];
	
	$arr = array("$apikey","$auth");
	
	$pair = array("$user","$aut");		
	
	if($arr === $pair){
	    
	    if($serviceID ==='jamb'){

function fetchshago($conn){
$query_sh = $conn->query("SELECT * FROM providers_api_key WHERE provider='shago'");
$shagokey = $query_sh->fetch_assoc();
return json_encode($shagokey);
}    
$json_shago = json_decode(fetchshago($conn));
$hashkey = $json_shago->privatekey; 

//////Query Profile Code///////										
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://shagopayments.com/api/live/b2b',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
    "serviceCode" => "JMV",
    "type" => $variation_code,
    "profileCode" => $profile_code
)),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
      "Content-Type: application/json",
    "hashKey: $hashkey"
  ),
));

$response = curl_exec($curl);
curl_close($curl);
////END query Profile Code///////
$resp = json_decode($response);	 
if($resp->status =='200'){
    
	response(101,array("surname"=>$resp->surname,"firstname"=>$resp->firstname,"middleName"=>$resp->middleName,"fullName"=>$resp->fullName,"phoneNumber"=>$resp->phoneNumber,"profileCode"=>$resp->profileCode,"type"=>$variation_code));
}
else{
    $errorStatus = "error";
  response(301,["status"=>$errorStatus, "message"=>"unable to verify profilecode"]);  
}

}else{ response(303,"Invalid Service ID");   }
////Close validate Service ID

  } 
  else{  
    
    response(103,"INVALID APIKEY"); 
    }

} 
// close wrong parameter

	  else{ 
	   
	   response(400,"INVALID REQUEST METHOD [Request Method must be POST]"); 
	       
	       
	   }
	    
function response($status,$status_message)
{
	
	
	$response['code']=$status;
	$response['description']=$status_message;
	
	
	$json_response = json_encode($response);
	echo $json_response;
}
    
    ?>