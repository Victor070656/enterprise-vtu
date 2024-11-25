<?php
date_default_timezone_set ('Africa/Lagos'); 
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
	$billersCode = $conn->real_escape_string(test_input($jdata->profilecode));
	$variation_code = $conn->real_escape_string(test_input($jdata->type));
	$requestId = $conn->real_escape_string(test_input($jdata->ref));
	}else{
	$apikey = $conn->real_escape_string(test_input($_REQUEST['apikey']));
	$serviceID = $conn->real_escape_string(test_input($_REQUEST['service']));
	$billersCode = $conn->real_escape_string(test_input($_REQUEST['profilecode']));
	$variation_code = $conn->real_escape_string(test_input($_REQUEST['type']));
	$requestId = $conn->real_escape_string(test_input($_REQUEST['ref']));    
	    
	}
	$auth = "paid";
	$txtadmin = "08084121526";
	
    $dateTime = date('Y-m-d h:i:A');
    
   
	
	$JAMB_array = array("UTME","UTME_MOCK");
	
	if(in_array($variation_code,$JAMB_array)){
	    
/////////////////////////////////////////	

function fetchPackage($conn,$variation_code,$serviceID){
$qryPlan = $conn->query("SELECT * FROM exam_package WHERE network='$serviceID' AND plancode='$variation_code'"); 
while($prow[] = $qryPlan->fetch_assoc()){ }
return json_encode($prow);
} 	

$json_exam = json_decode(fetchPackage($conn,$variation_code,$serviceID));	

	  // process request
	
	$convee = '';
	
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
	
	$fname = $rob['firstname'];
	$lname = $rob['lastname'];
	
	$arr = array("$apikey","$auth");
	
	$pair = array("$user","$aut");		
	
	if($arr === $pair){
	    
	    // check if the user have balance
	
		$gb = mysqli_query($conn,"SElECT * FROM users WHERE apikey='$apikey' ");	
	$reco = mysqli_fetch_array($gb);
	$level = $reco['level'];
	$email = $reco['email'];
	$prevBal = $reco['bal'];
	$UserPhone = $reco['phone'];
	
	$upp_cas_lx = $reco['email'];
	//extract account info
$Wafi_user_pros = $conn->prepare("SELECT bal FROM users WHERE email=?");
$Wafi_user_pros->bind_Param("s",$upp_cas_lx);
$Wafi_user_pros->execute();
$Wafi_user_pros->store_result();
$Wafi_user_pros->bind_result($mid_wxpi);
$Wafi_user_pros->fetch();
$Wafi_user_pros->close();
	
			
		if(strtolower($serviceID) === 'jamb'){
		   //$amount = $jambrate; 
		    //if($amount < $amountPayee ){
		
		$per = 0;
		
		$pnt = "JAMB ePIN -".strtoupper($variation_code);
		
	// procceed to purchase
	
	$comi = floatval($per);
	$debit = floatval($amount);
	$chargeAmt = floatval($debit);
	
	if($chargeAmt <= $mid_wxpi ){ 
	    
	    $newBalc = bcsub($mid_wxpi,$chargeAmt);

	    // check if ref number exist
	    
	  $Qry_req = mysqli_query($conn,"SElECT * FROM transactions WHERE ref = '$requestId' ");	
	$check_num_row = mysqli_num_rows($Qry_req);

	if($check_num_row == 0){

// JAMB shago Purchase  
function fetchshago($conn){
$query_sh = $conn->query("SELECT * FROM providers_api_key WHERE provider='shago'");
$shagokey = $query_sh->fetch_assoc();
return json_encode($shagokey);
}    
$json_shago = json_decode(fetchshago($conn));
$hashkey = $json_shago->privatekey; 
$billamount = $json_exam->price_api;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "serviceCode" => "JMB",
    "type" => strtoupper($variation_code),
    "profileCode" => $billersCode,
    "amount" => $billamount,
    "request_id" => $requestId
    )));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
 "hashKey: $hashkey"
));
$response = curl_exec($ch);
curl_close($ch);

try{
// Requery Transaction

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
'serviceCode' => 'QUB',
'reference' => $requestId
)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "hashKey: $hashkey"
  
));

$resQuery = curl_exec($ch);
curl_close($ch);

$resp = json_decode($resQuery);

file_put_contents('jambresponse.txt',$resQuery);

//End requery
}
//catch exception
catch(Exception $ch) {
  echo 'Message: ' .$ch->getMessage();
}


//JAMB Purchase End  
$JAMB_PIN = $resp->pin;
$customerName = $resp->fullName;
if($resp->status == '200'){
    
$proces = "TRANSACTION SUCCESSFUL"; 

$stat = "Completed";


}else if($resp->status == '400'){ 
    
 $proces = $resp->message; 

$stat = $resp->message;   
    
}else{
 
 $proces = "NETWORK ERROR";    
  
 $stat = "Failed";

}

if($resp->status == '200' OR $resp->status == '400'){
 // debit account
    UserdebitWallet($conn,$newBalc,$upp_cas_lx);

response(101,array("status"=>$proces,"PIN"=>$resp->pin,"profileCode"=>$resp->profileCode,"Candidate_Name"=>$resp->fullName,"phone"=>$resp->phone,"product_name"=>$resp->product,"TransactionDate"=>$dateTime));
}else{
    
  response(206,"Transaction Failed");  
}
$fcusName = $fname.' '.$lname;
$Trans_add = mysqli_query($conn,"INSERT INTO transactions (network,serviceid,channel,phone,amount,charge,ref,status,date,email,customer,del,customerName,servicetype,meterno,metertoken,newBal) VALUES('$pnt [$JAMB_PIN]','$variation_code','$channel','$billersCode','$amount','$chargeAmt','$requestId','$stat','$dateTime','$email','$fcusName','Delete','$customerName','$serviceID','$billersCode','$JAMB_PIN','$newBalc')");


}else{ response(104,"TRANSACTION ID ALREADY EXIST");
    
    
}

}
// echo low balance
else{ 
    
    response(102,"LOW BALANCE"); 

} 

// close account not found
//}else{ response(304,"Amount too low. Minimum is N$amountPayee ");   }
////Close validate Service ID

}else{ response(303,"Invalid Service ID [serviceID must be jamb]");   }
////Close validate Service ID
			    
} else{  
    
    response(103,"Invalid or missing APIKEY"); 


    }



}else{   
    
 response(108,"WRONG SERVICE TYPE [Service type must be UTME or UTME_MOCK ]");   
}
// close JAMB variation Check
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
    