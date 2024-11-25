 <?php
date_default_timezone_set ( 'Africa/Lagos' ); 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
include('../Connections/dbQuery.php');
include('../function/build.php');
$dateTime = date('Y-m-d H:m:s');

	// API parameter
    
	//if(isset($_REQUEST['apikey']) && isset($_REQUEST['customerId']) && isset($_REQUEST['reference']) && isset($_REQUEST['amount']) && isset($_REQUEST['customerName']) && isset($_REQUEST['request_id'])){
	
	// API parameter
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	// get posted data
    $get_data = json_decode(file_get_contents("php://input"));
	if(isset($get_data)){
	$apikey = $conn->real_escape_string(test_input($get_data->apikey));
	$customerID = $conn->real_escape_string(test_input($get_data->customerId));
	$reference = $conn->real_escape_string(test_input($get_data->reference));
	$amount = $conn->real_escape_string(test_input(floatval($get_data->amount)));
	$customerName = $conn->real_escape_string(test_input($get_data->customerName));
	$requestId = $conn->real_escape_string(test_input($get_data->request_id));
	}else{
	    
	 $apikey = $conn->real_escape_string(test_input($_REQUEST['apikey']));
	$customerID = $conn->real_escape_string(test_input($_REQUEST['customerId']));
	$reference = $conn->real_escape_string(test_input($_REQUEST['reference']));
	$amount = $conn->real_escape_string(test_input(floatval($_REQUEST['amount'])));
	$customerName = $conn->real_escape_string(test_input($_REQUEST['customerName']));
	$requestId = $conn->real_escape_string(test_input($_REQUEST['request_id']));   
	}
	
	$auth = "paid";

	// check if the account is valid

	
	$retr = mysqli_query($conn,"SELECT * FROM users WHERE apikey='$apikey' ");

	$rob = mysqli_fetch_array($retr);
	
	$user = $rob['apikey'];
	$aut = $rob['level'];
	
	$arr = array("$apikey","$auth");
	
	$pair = array("$user","$aut");
	$loginIdUser = $conn->real_escape_string($rob['email']);
	$IpAddress = filter_var($_SERVER['REMOTE_ADDR'],FILTER_VALIDATE_IP);
	$logphoneUser = $conn->real_escape_string($rob['phone']);
	
	
	if($arr === $pair){
	
 // check if the user have balance
	
	$gb = mysqli_query($conn,"SElECT * FROM users WHERE apikey = '$user' ");	
	$reco = mysqli_fetch_array($gb);
	$level = $reco['level'];
	$Useremail = $reco['email'];
	$fname = $reco['firstname'];
    $lname = $reco['lastname'];
    $prevBal = floatval($reco['bal']);
	$billersCode = $customerID;
	$userFullName = $fname.' '.$lname;
	$channel = "API";
	$view = "View";
	
	$upp_cas_lx = $reco['accno'];
	//extract account info

$userDetails = json_decode(fetchUser($conn,$apikey),true);
$customNam = $userDetails[0]['firstname'] .' '.$userDetails[0]['lastname'];
$current_balance = floatval($userDetails[0]['bal']);
$userPhone = $userDetails[0]['phone'];
$UserIPAddress = $userDetails[0]['IPaddress'];
$upp_cas_lx = $userDetails[0]['email'];
	                      
	 
	 $ftrow =  json_decode(fetchPackage($conn,$variation_code,$serviceID),true);
     $network_fetch = $ftrow[0]['network'];
     $plan_fetch = $ftrow[0]['plan'];
     $code_fetch = $ftrow[0]['plancode'];
     $userprice_fetch = floatval($ftrow[0]['amount']);
     $gateway_fetch = $ftrow[0]['gateway'];                     
	  

	$json_rate = json_decode(charges($conn));
	
    $commi = $json_rate->bet9ja;	

	$todebit = strval(floatval($amount) - floatval($commi));
	
	$newBalc = strval(floatval($mid_wxpi) - floatval($todebit));
	
	if($todebit < $mid_wxpi  ){ 
	 
	    // check if ref number exist
	    
    $SqLreq = mysqli_query($conn,"SElECT * FROM transactions WHERE ref = '$requestId' "); $nuRow = mysqli_num_rows($SqLreq);

	if($nuRow == 0){
	    
$resp = json_decode(Shagopay($conn,$customerID,$reference,$amount,$customerName,$requestId));

if($resp->status == '400' or $resp->status == '200'){
 
 $Stat = "Completed";   
    
}else{ $Stat = "Failed";   }
	
$serviceID = "Betting";	
$nam = 'Transaction Successful';	   


if($resp->status == '400' or $resp->status == '200'){
$productName ="Bet9ja";
$nam = 'Transaction Successful';
 // debit account
UserdebitWallet($conn,$newBalc,$upp_cas_lx);

response(200,array("status"=>$nam,"reference"=>$reference));
$SQL_add = mysqli_query($conn,"INSERT INTO transactions (network,serviceid,channel,phone,amount,charge,ref,date,status,email,customer,newBal) VALUES('$productName','$serviceID','$channel','$billersCode','$amount','$todebit','$requestId','$dateTime','$Stat','$Useremail','$userFullName','$newBalc')");
	
}else {
    
    response(105,array("response_description"=>"Failed")); 
    
}
  }else{ response(104,"TRANSACTION ID ALREADY EXIST");}
	
	   
	    
	} else{ response(102,"LOW BALANCE");  }


	
  } 
  
 else{  
    
    response(103,"INVALID ACCOUNT"); 


    }



//check negative value;
} 

// close wrong parameter


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
 
 function charges($conn){
	        $qryCharge = $conn->query("SELECT * FROM charges WHERE service='bet9ja'");
	        $b9ja_com = $qryCharge->fetch_assoc();
	        return json_encode($b9ja_com);
	    }
 
 function Shagopay($conn,$customerID,$reference,$amount,$customerName,$requestId){
    function fetchshago($conn){
$query_sh = $conn->query("SELECT * FROM providers_api_key WHERE provider='shago'");
$shagokey = $query_sh->fetch_assoc();
return json_encode($shagokey);
}    
$json_shago = json_decode(fetchshago($conn));
$hashkey = $json_shago->privatekey; 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
'serviceCode' => "BEP",
'type'	=> 'Bet9ja',
'customerId'	=> $customerID,
'reference'	 => $reference,
'amount' => $amount,
'name' => $customerName,
'request_id' => $requestId	

)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "hashKey: $hashkey"
));
$ShagoRes = curl_exec($ch);
curl_close($ch);   
//file_put_contents('airtime.txt',$ShagoRes);
return  $ShagoRes;   
}
   
    ?>
    
  
   	

