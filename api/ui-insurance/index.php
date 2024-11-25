<?php
date_default_timezone_set ( 'Africa/Lagos' ); 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE");
include('../Connections/dbQuery.php');
include('../function/build.php');


		// API parameter
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	// get posted data
    $get_data = json_decode(file_get_contents("php://input")); 
    if(isset($get_data)){
    $apikey = $conn->real_escape_string(test_input($get_data->apikey));
	$serviceID = $conn->real_escape_string(test_input($get_data->service));
	$billersCode = $conn->real_escape_string(test_input($get_data->accountno));
	$variation_code = $conn->real_escape_string(test_input($get_data->vcode));
	$amountPayee = $conn->real_escape_string(test_input(floatval($get_data->amount)));
	$phone = $conn->real_escape_string(test_input($get_data->phone));
	$insureName = $conn->real_escape_string(test_input($get_data->insuredName));
	$engineNO = $conn->real_escape_string(test_input($get_data->engineNo));
	$chasisNo = $conn->real_escape_string(test_input($get_data->chasisNo));
	$plateNo = $conn->real_escape_string(test_input($get_data->plateNo));
	$carMake = $conn->real_escape_string(test_input($get_data->vehicleMake));
	$carColor = $conn->real_escape_string(test_input($get_data->vehicleColor));
	$carModel = $conn->real_escape_string(test_input($get_data->vehicleModel));
	$carYear = $conn->real_escape_string(test_input($get_data->yearofMake));
	$regAddress = $conn->real_escape_string(test_input($get_data->contactAddress));
	$requestid = $conn->real_escape_string(test_input($get_data->ref));
	
    }else{
	$apikey = $conn->real_escape_string(test_input($_REQUEST['apikey']));
	$serviceID = $conn->real_escape_string(test_input($_REQUEST['service']));
	$billersCode = $conn->real_escape_string(test_input($_REQUEST['accountno']));
	$variation_code = $conn->real_escape_string(test_input($_REQUEST['vcode']));
	$amountPayee = $conn->real_escape_string(test_input(floatval($_REQUEST['amount'])));
	$phone = $conn->real_escape_string(test_input($_REQUEST['phone']));
	$insureName = $conn->real_escape_string(test_input($_REQUEST['insuredName']));
	$engineNO = $conn->real_escape_string(test_input($_REQUEST['engineNo']));
	$chasisNo = $conn->real_escape_string(test_input($_REQUEST['chasisNo']));
	$plateNo = $conn->real_escape_string(test_input($_REQUEST['plateNo']));
	$carMake = $conn->real_escape_string(test_input($_REQUEST['vehicleMake']));
	$carColor = $conn->real_escape_string(test_input($_REQUEST['vehicleColor']));
	$carModel = $conn->real_escape_string(test_input($_REQUEST['vehicleModel']));
	$carYear = $conn->real_escape_string(test_input($_REQUEST['yearofMake']));
	$regAddress = $conn->real_escape_string(test_input($_REQUEST['contactAddress']));
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

	$varr = array("ui-insure","414");
	
	if(in_array($serviceID,$varr)){
		
	$dateTime = date('Y-m-d h:i:A');	
	$convee = '';
	
	$customer = '';
	
	$xname = '';
	
	$action = " ";
	
	$stat = "Completed";
	$email = $user;
	$proc = '_pay-tv';
	$charge = '';
	
	$channel = "API";
	$view = "View";
	
$cusName = $insureName;

	// check if the account is valid
	
	if($param){
	    
	    response(107,"BAD REQUEST");} else{
	
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
	$query_com = mysqli_query($conn,"SELECT * FROM billing");
	$rate = mysqli_fetch_array($query_com);
	
	$access = 'free';
	$smile = $rate['smile'];
	
	if($serviceID === 'ui-insure' && $level !== $access ){
		
		$per = $smile;	
			
			}
	
	$comi = strval(floatval($per/100)* floatval($amount));
	$debit = strval(bcsub($amount,$comi));
	
	 $newBalc = bcsub($mid_wxpi,$debit);
	if($debit < $mid_wxpi){ 
	 
	    // check if ref number exist
	    
	  $req = mysqli_query($conn,"SElECT * FROM transactions WHERE ref = '$ref' ");	
	$nu = mysqli_num_rows($req);

	if($nu == 0){
	   
$uidata = array(
    'request_id' => $requestid,
  	'serviceID'=> $serviceID, //integer e.g gotv,dstv,eko-electric,abuja-electric
  	'billersCode'=> $billersCode, // e.g smartcardNumber, meterNumber,
  	'variation_code'=> $variation_code, // e.g dstv1, dstv2,prepaid,(optional for somes services)
  	'amount' =>  $amount, // integer (optional for somes services)
  	'phone' => $phone,
	'Insured_Name' => $insureName, //integer
	'Engine_Number' => $engineNO,
	'Chasis_Number' => $chasisNo,
	'Plate_Number' => $plateNo,
	'Vehicle_Make' => $carMake,
	'Vehicle_Color' => $carColor,
	'Vehicle_Model' => $carModel,
	'Year_of_Make' => $carYear,
	'Contact_Address' => $regAddress
  	
);
$curl       = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => $host,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_USERPWD => $VTusername.":" .$VTpassword,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_SSL_VERIFYPEER => true,
	CURLOPT_POSTFIELDS => $uidata,
));
$success = curl_exec($curl);
$curl_errno = curl_errno($curl);
curl_close($curl);


// Requery VTPass Transactions
$curl       = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => "https://vtpass.com/api/requery",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_USERPWD => $VTusername.":" .$VTpassword,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_SSL_VERIFYPEER => true,
	CURLOPT_POSTFIELDS => array('request_id' => $requestid),
));
$VTsuccess = curl_exec($curl);
$curl_errno = curl_errno($curl);
curl_close($curl);

$resp = json_decode($VTsuccess, true);

if($resp['content']['transactions']['status'] == 'delivered'){
	
	 // debit account
        UserdebitWallet($conn,$newBalc,$curBok_balance,$upp_cas_lx);
	$prodName = $resp['content']['transactions']['product_name'];
	$downloadLink = $resp['certUrl'];
	$comStatus = "Completed";
response(101,array("Status"=>"TRANSACTION SUCCESSFUL","Download Certificate"=>$downloadLink,"PlateNumber"=>$billersCode,"product_name"=>$prodName));

}elseif($resp['content']['transactions']['status'] == 'pending'){
    
  $prodName = $resp['content']['transactions']['product_name'];
	$downloadLink = $resp['certUrl'];
	$comStatus = "Processing";  
    
}else{
  
 $prodName = $resp['content']['transactions']['product_name'];
$downloadLink = $resp['certUrl'];
$comStatus = "Failed";
 
 response(107,array("Status"=>"Service Error"));
    
}

$Trans_add = mysqli_query($conn,"INSERT INTO transactions (network,serviceid,channel,phone,amount,charge,ref,status,date,email,customer,action,del,customerName,servicetype,meterno,metertoken,newBal) VALUES('$prodName','$variation_code','$channel','$phone','$amount','$debit','$requestid','$comStatus','$dateTime','$email','$fname $lname','$action','Delete','$cusName','$serviceID','$billersCode','$downloadLink','$newBalc')");

// End Transaction failed



}else{ response(104,"TRANSACTION ID ALREADY EXIST");
    
    
}

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
// close wrong variation code
	} else{
		
	response(407,"MISSING VARIATION CODE"); 
		
		}
// close wrong parameter
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
	$response['status_message']=$status_message;
	
	
	$json_response = json_encode($response);
	echo $json_response;
}
    
    ?>
    