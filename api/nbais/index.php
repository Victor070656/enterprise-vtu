<?php
date_default_timezone_set ( 'Africa/Lagos' ); 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
include('../Connections/dbQuery.php');
include('../function/build.php');
	// API parameter
    
//	if(isset($_REQUEST['apikey']) && isset($_REQUEST['service']) && isset($_REQUEST['ref'])){

// API parameter
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	// get posted data
    $get_data = json_decode(file_get_contents("php://input"));
    if(isset( $get_data)){
	$apikey = $conn->real_escape_string(test_input($get_data->apikey));
	$serviceID = $conn->real_escape_string(test_input($get_data->service));
	$requestid = $conn->real_escape_string(test_input($get_data->ref));
    }else{
        
     $apikey = $conn->real_escape_string(test_input($_REQUEST['apikey']));
	$serviceID = $conn->real_escape_string(test_input($_REQUEST['service']));
	$requestid = $conn->real_escape_string(test_input($_REQUEST['ref']));   
    }
    $amountPayee = "950";
	$auth = "paid";
	$txtadmin = "08084121526";
	$dateTime = date('Y-m-d h:i:A');
	$convee = '';
	
	if(is_numeric($amountPayee)){
	   
	 $amount = max(0, $amountPayee);
	     
	 if($amount == 0){
	     
	  response(107,"BAD REQUEST");    
	 }else{   
	  
	  // process request
	
	$customer = '';
	
	$xname = '';
	
	$action = "Pay";
	
	$email = $user;
	$proc = '_pay-tv';
	$charge = '';
	
	$channel = "API";
	$view = "View";
	
	// check if the account is valid

	
	$retr = "SELECT * FROM users WHERE apikey='$apikey' ";
	
	$exe = mysqli_query($conn,$retr);
	$rob = mysqli_fetch_array($exe);
	
	$user = $rob['apikey'];
	$aut = $rob['level'];
	
	$arr = array("$apikey","$auth");
	
	$pair = array("$user","$aut");
	
	
	if($arr === $pair){
	    
	    // check if the user have balance
	
		$gb = mysqli_query($conn,"SElECT * FROM users WHERE apikey = '$user' ");	
	$reco = mysqli_fetch_array($gb);
	$fname = $reco['firstname'];
	$lname = $reco['lastname'];
	$level = $reco['level'];
	$email = $reco['email'];
	$upp_cas_lx = $reco['email'];
	$customNam = "$fname &nbsp; $lname";
$CustomerPhone = $reco['phone'];
	//extract account info
$Wafi_user_pros = $conn->prepare("SELECT bal FROM users WHERE email=?");
$Wafi_user_pros->bind_Param("s",$upp_cas_lx);
$Wafi_user_pros->execute();
$Wafi_user_pros->store_result();
$Wafi_user_pros->bind_result($mid_wxpi);
$Wafi_user_pros->fetch();
$Wafi_user_pros->close();


		
function fetchPackage($conn,$serviceID){
$qryPlan = $conn->query("SELECT * FROM exam_package WHERE network='$serviceID'"); 
while($prow[] = $qryPlan->fetch_assoc()){ }
return json_encode($prow);
} 	

$json_exam = json_decode(fetchPackage($conn,$serviceID));
		

	$debit = floatval($json_exam->price_api);
	$newBalc = strval(floatval($mid_wxpi) - floatval($debit));
	if($debit < $mid_wxpi){ 
	    
	    
	    // check if ref number exist
    $req = mysqli_query($conn,"SElECT * FROM transactions WHERE ref = '$requestid' ");	
	$nu = mysqli_num_rows($req);
	if($nu == 0){ 
      

function ePinsPay($conn, $serviceID, $requestid){
    function fetchEpin($conn){
$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
$fetchepkey = $query_ep->fetch_assoc();
return json_encode($fetchepkey);
}    
$json_ep = json_decode(fetchEpin($conn));
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/nbais/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $json_ep->privatekey,
    "service" => $serviceID,
    "ref" => $requestid
    )));

$veridata = curl_exec($ch);
curl_close($ch);

return $veridata;
}

$resp = json_decode(ePinsPay($conn, $serviceID, $requestid),true);
$responseCode = $resp['code'];
$pin = $resp['PIN'];
$tok = $pin;

if($resp->code == '101' && !empty($pin) or $pin !== NULL){
    $stat = "Completed";
     // debit account
      UserdebitWallet($conn,$newBalc,$upp_cas_lx); 
response(101,array("Status"=>'TRANSACTION SUCCESSFUL',"ProductName"=>$product_name,"PIN"=>$tok,"TransactionRef"=>$requestid,"Date"=>$dateTime ));
}else{
 response(105,array("response_description"=>"Failed"));    
 $stat = "Failed";  
}

$addQuery = $conn->query("INSERT INTO transactions (network,serviceid,channel,phone,amount,charge,ref,status,date,email,newBal,metertoken,customer) VALUES('$product_name <br> PIN:$tok','$variation_code','$channel','$CustomerPhone','$amount','$debit','$requestid','$stat','$dateTime','$email','$newBalc','$tok','$customNam')");



}else{ response(104,"TRANSACTION ID ALREADY EXIST");}

}
// echo low balance
else{ 
    
    response(102,"LOW BALANCE"); 


    
} 

// close account not found
} else{  
    
    response(103,"INVALID ACCOUNT"); 


    }



}
//end process request
}else{
	 response(107,"BAD REQUEST");}
//check negative value;

	}   else{ 
	   
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
    
  
   	

