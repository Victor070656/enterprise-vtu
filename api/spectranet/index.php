<?php
date_default_timezone_set ( 'Africa/Lagos' ); 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");
include('../Connections/dbQuery.php');
include('../function/build.php');

	// API parameter
    
//	if(isset($_REQUEST['apikey']) && isset($_REQUEST['service']) && isset($_REQUEST['pinNo']) && isset($_REQUEST['amount']) && isset($_REQUEST['ref'])){
	
// API parameter
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	// get posted data
    $get_data = json_decode(file_get_contents("php://input")); 
    if(isset( $get_data)){
	$apikey = $conn->real_escape_string(test_input($get_data->apikey));
	$serviceID = $conn->real_escape_string(test_input($get_data->service));
	$billersCode = $conn->real_escape_string(test_input($get_data->pinNo));
	$variation_code = "";
	$amountPayee = $conn->real_escape_string(test_input(floatval($get_data->amount)));
	$requestid = $conn->real_escape_string(test_input($get_data->ref));
    }else{
    $apikey = $conn->real_escape_string(test_input($_REQUEST['apikey']));
	$serviceID = $conn->real_escape_string(test_input($_REQUEST['service']));
	$billersCode = $conn->real_escape_string(test_input($_REQUEST['pinNo']));
	$variation_code = "";
	$amountPayee = $conn->real_escape_string(test_input(floatval($_REQUEST['amount'])));
	$requestid = $conn->real_escape_string(test_input($_REQUEST['ref']));    
        
    }
	$auth = "paid";
	$txtadmin = "08084121526";
	
	if(is_numeric($amountPayee)){
	   
	 $amount = max(0, $amountPayee);
	     
	 if($amount == 0){
	     
	  response(107,"BAD REQUEST");    
	 }else{   
	  
	  // process request
	
    $dateTime = date('Y-m-d h:i:A');
	
	
	$action = "Pay";
	
	$email = $user;
	$proc = '_pay-tv';
	$charge = '';
	
	$channel = "API";
	$view = "View";
	
	
	
	// check if the account is valid

	
	if($param){
	    
	    response(107,"BAD REQUEST");} else{
	
	$retr = "SELECT * FROM users WHERE apikey='$apikey' ";
	
	$exe = mysqli_query($conn,$retr);
	$rob = mysqli_fetch_array($exe);
	
	$user = $rob['apikey'];
	$aut = $rob['level'];
	
	$fname = $rob['firstname'];
	$lname = $rob['lastname'];
	
	$arr = array("$apikey","$auth");
	
	$pair = array("$user","$aut");
	
	
	if($arr === $pair){
	    
	    // check if the user have balance
	
		$gb = mysqli_query($conn,"SElECT * FROM users WHERE apikey='$apikey' ");	
	$reco = mysqli_fetch_array($gb);
	
	$blcurx = floatval($reco['xBasd']);
	$level = $reco['level'];
	$email = $reco['email'];
	$upp_cas_lx = $reco['accno'];
	//extract account info
$Wafi_user_pros = $conn->prepare("SELECT bal FROM users WHERE email=?");
$Wafi_user_pros->bind_Param("s",$upp_cas_lx);
$Wafi_user_pros->execute();
$Wafi_user_pros->store_result();
$Wafi_user_pros->bind_result($mid_wxpi);
$Wafi_user_pros->fetch();
$Wafi_user_pros->close();
	
					
	                    
	 $ftrow =  json_decode(fetchPackage($conn,$Dataplan,$serviceID),true);
     $network_fetch = $ftrow[0]['network'];
     $datatype_fetch = $ftrow[0]['datatype'];
     $plan_fetch = $ftrow[0]['plan'];
     $code_fetch = $ftrow[0]['plancode'];
     $userprice_fetch = floatval($ftrow[0]['price_user']);
     $apiprice_fetch = floatval($ftrow[0]['price_api']);
     $gateway_fetch = $ftrow[0]['gateway']; 
  $status_fetch = $ftrow[0]['status'];
  
  if($status_fetch !== 'disabled'){
 
$valu = strtoupper($provider).' '. $plan_fetch;
$servicetype = "data";

$total_Price = strval(floatval($apiprice_fetch) * floatval($billersCode));
$newBalc =  strval(floatval($current_balance) - floatval($total_Price));
 	
	 if(floatval($total_Price) <= floatval($current_balance)){
	    
	    // check if ref number exist
	    
	  $req = mysqli_query($conn,"SElECT * FROM transactions WHERE ref = '$requestid' ");	
	$nu = mysqli_num_rows($req);

	if($nu == 0){
	    
       
		  
function fetchshago($conn){
$query_sh = $conn->query("SELECT * FROM providers_api_key WHERE provider='shago'");
$shagokey = $query_sh->fetch_assoc();
return json_encode($shagokey);
}    
$json_shago = json_decode(fetchshago($conn));
$hashkey = $json_shago->privatekey; 

$servcode = "SPB";

$param = array(
'serviceCode' => $servcode,
'amount' => $amount,
'type'	=> 'SPECTRANET',
'pinNo'	=> $billersCode,
'request_id' => $requestid	

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

// Requery Transaction

$WAVparam = array(
'serviceCode' => 'QUB',
'reference' => $requestid
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($WAVparam));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "hashKey: $hashkey"
  
));

$resQuery = curl_exec($ch);
curl_close($ch);

$resp = json_decode($resQuery,true);

//End requery

$product_name ="Spectranet Topup";

   $tok =  $resp['pin'][0]['pin'];
   
   $units = $resp['pin'][0]['serial'];
   
   
if($resp['status'] == '200'){
    
$proces = "TRANSACTION SUCCESSFUL"; 

$stat = "Completed";

$action = "";

}elseif($resp['status'] == '300'){
 
 $proces = "NETWORK ERROR";    
  
 $stat = "Failed";
 
 $action = "Reverse";
}elseif($resp['status'] == '400'){
 
 $proces = "NETWORK ERROR";    
  
 $stat = "Processing";
 
 $action = "";
}else{
    
  $proces = "NETWORK ERROR";    
  
 $stat = "Failed";
 
 $action = "Reverse";   
}



if($resp['status'] == '200'){
    // debit account
       UserdebitWallet($conn,$newBalc,$upp_cas_lx);
response(101,array("Status"=>$proces,"PIN"=>$tok,"Serial"=>$units,"product_name"=>$product_name,"transaction_date"=>$dateTime));
}else{
  response(105,array("response_description"=>"Failed"));   
    
}

$add = mysqli_query($conn,"INSERT INTO transactions (network,serviceid,channel,phone,amount,charge,ref,status,date,email,customer,action,del,customerName,servicetype,meterno,metertoken,newBal) VALUES('$ServiceName <br>PIN: $tok | Serial: $units','$variation_code','$channel','$billersCode','$amount','$debit','$requestid','$stat','$dateTime','$email','$fname $lname','$action','Delete','$cusName','$serviceID','$billersCode','$tok','$newBalc')");


}else{ response(104,"TRANSACTION ID ALREADY EXIST");
    
    
}


}
// echo low balance
else{ 
    
    response(102,"LOW BALANCE"); 
} 
} else {
    
  response(112,"This service is currently unavailable");   
    
}
// close account not found
} else{  
    
    response(103,"INVALID ACCOUNT"); 


    }


} // close wrong parameter

}
//end process request
}else{
	 response(107,"BAD REQUEST");}
//check negative value;

	}   else{ 
	   
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
    
  
   	

