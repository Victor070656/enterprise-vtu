<?php
date_default_timezone_set ( 'Africa/Lagos' ); 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
include('../Connections/dbQuery.php');
include('../function/build.php');

    
//	if(isset($_REQUEST['apikey']) && isset($_REQUEST['service']) && isset($_REQUEST['accountno']) && isset($_REQUEST['vcode']) && isset($_REQUEST['amount']) && isset($_REQUEST['ref'])){
	
	// API parameter
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	// get posted data
    $get_data = json_decode(file_get_contents("php://input"));
    if(isset( $get_data)){
	$apikey = $conn->real_escape_string(test_input($get_data->apikey));
	$serviceID = $conn->real_escape_string(test_input($get_data->service));
	$billersCode = $conn->real_escape_string(test_input($get_data->accountno));
	$variation_code = $conn->real_escape_string(test_input($get_data->vcode));
	$amountPayee = $conn->real_escape_string(test_input($get_data->amount));
	$requestid = $conn->real_escape_string(test_input($get_data->ref));
    }else{
    $apikey = $conn->real_escape_string(test_input($_REQUEST['apikey']));
	$serviceID = $conn->real_escape_string(test_input($_REQUEST['service']));
	$billersCode = $conn->real_escape_string(test_input($_REQUEST['accountno']));
	$variation_code = $conn->real_escape_string(test_input($_REQUEST['vcode']));
	$amountPayee = $conn->real_escape_string(test_input($_REQUEST['amount']));
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
	
	$varr = array("413","414","415","583","624","625","626","606","627","607","608","628","620","609","610","611","612","613","614","601","615","616","629","617","618","621","630","602","619","655","622","603","623","604","605");
	
	if(in_array($variation_code,$varr)){
		
	$dateTime = date('Y-m-d h:i:A');	

	$action = "Pay";
	
	$email = $user;
	$proc = '_pay-tv';
	$charge = '';
	
	$channel = "API";
	$view = "View";
	
	//verify account no

$host = 'https://vtpass.com/api/merchant-verify';
$datav = array(
  	'serviceID'=> $serviceID, //integer e.g gotv,dstv,eko-electric,abuja-electric
  	'billersCode'=> $billersCode,// e.g smartcardNumber, meterNumber,
  	'type' => $variation_code
  	);

//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $host);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERPWD , $VTusername.":" .$VTpassword);
curl_setopt($ch, CURLOPT_POSTFIELDS, $datav);
$verifydata = curl_exec($ch);
$result = json_decode($verifydata);

//Close the cURL handle.
curl_close($ch);

$cusName = $result->content->Customer_Name;
	
	
	
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
	$upp_cas_lx = $reco['email'];
	//extract account info
$Wafi_user_pros = $conn->prepare("SELECT bal FROM users WHERE email=?");
$Wafi_user_pros->bind_Param("s",$upp_cas_lx);
$Wafi_user_pros->execute();
$Wafi_user_pros->store_result();
$Wafi_user_pros->bind_result($mid_wxpi,$book_balance);
$Wafi_user_pros->fetch();
$Wafi_user_pros->close();
	$query_com = mysqli_query($conn,"SELECT * FROM billing");
	$rate = mysqli_fetch_array($query_com);
	
	$access = 'free';
	$smile = $rate['smile'];
	
	if($serviceID === 'smile-direct' && $level !== $access ){
		
		$per = $smile;	
			
			}
	
	$comi = ($per/100)*$amount;
	$debit = bcsub($amount,$comi);
	
	 $newBalc = bcsub($mid_wxpi,$debit);
	$curBok_balance = bcsub($book_balance,$debit);
	if($debit < $mid_wxpi){ 
	    
	   if($mid_wxpi == $book_balance){  
	    
	    // check if ref number exist
	    
	  $req = mysqli_query($conn,"SElECT * FROM transactions WHERE ref = '$ref' ");	
	$nu = mysqli_num_rows($req);

	if($nu == 0){
	    
		   
		/********************************************************************************
	
**********************************************************************************/ 

$data = array(
  	'serviceID'=> $serviceID, //integer e.g gotv,dstv,eko-electric,abuja-electric
  	'billersCode'=> $billersCode, // e.g smartcardNumber, meterNumber,
  	'variation_code'=> $variation_code, // e.g dstv1, dstv2,prepaid,(optional for somes services)
  	'amount' =>  $amount, // integer (optional for somes services)
  	'phone' => $txtadmin, //integer
  	'request_id' => $requestid // unique for every transaction from your platform
);

$curl       = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => "https://vtpass.com/api/pay",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_USERPWD => $VTusername.":" .$VTpassword,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_SSL_VERIFYPEER => true,
	CURLOPT_POSTFIELDS => $data,
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

if($resp['code'] == '000'){
$stat = "Completed";
}else{$stat = "Failed"; }




if($respon['code'] == '000'){
 // debit account
       UserdebitWallet($conn,$newBalc,$curBok_balance,$upp_cas_lx);
response(101,array("Status"=>'TRANSACTION SUCCESSFUL',"ProductName"=>$serviceID,"TransactionRef"=>$requestid,"Date"=>$dateTime )); 
}else{response(105,array("response_description"=>"Failed")); }

$addQuery = mysqli_query($conn,"INSERT INTO transactions (network,serviceid,channel,phone,mobile,amount,charge,ref,date,status,email,customer,action,view,process,customerName,servicetype,newBal) VALUES('$network $serviceID','$variation_code','$channel','$billersCode','$phone','$amount','$debit','$requestid','$stat','$dateTime',$email','$xname','$action','$view','$proc','$cusName','$serviceID','$newBalc')");



}else{ response(104,"TRANSACTION ID ALREADY EXIST");
    
    
}


}else{
response(1007,"TRANSACTION BLOCKED");

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
    
  
   	

