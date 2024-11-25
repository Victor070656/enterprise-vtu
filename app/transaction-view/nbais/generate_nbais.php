<?php
session_start();
require_once('../../db.php'); 
$error = array();
$res = array();


$user = $_SESSION['user'];
$amount = intval($_POST['amount']);
$network = $_POST['network'];
$phone = $_POST['phone'];
$requestId = $_POST['requestId'];
$iuc = $_POST['iuc'];
$plan = $_POST['plan'];
$variation_code = $_POST['variation_code'];

										
if(empty($amount)){
    $error[] = "Amount required";
}
if(empty($phone)){
    $error[] = "Phone number required";
}
if(empty($iuc)){
    $error[] = "Quantity required";
}

if(count($error) > 0){
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();
}

$prevBal = json_decode(bal_val($conn, $user));
if(intval($amount) <= intval($prevBal->bal)){	

	$token = uniqid();
			$stat = "pending";
											
			$ret = mysqli_query($conn,"SELECT * FROM transactions WHERE ref='$requestId' ");
		
		$da = mysqli_fetch_array($ret);
		$tref = $da['ref'];
		
		if($da['refer'] === $da['token']){	

$apiMulti = json_decode(Apidefault($conn, $variation_code));

$current_balance = strval(floatval($prevBal->bal) - floatval(intval($amount)));

 if($apiMulti->gateway === 'epins'){
	
include('../../inc/nbaispay.php');
	
	}
	
if($responseCode == '101' ){
    
    walletDebit($conn,$current_balance, $user);
      updateTransactionsHistory($conn,$requestId,$pin);
include('../../inc/waec-alert.php');		
	
$resp['msg'] = "Your ".$plan.' is'. $pin;
$resp['status'] = true;
echo json_encode($resp);

}else{
 
$error[] = $plan." purchase failed. Please try again shortly"; 
$resp['msg'] = $error;
$resp['status'] = false;
echo json_encode($resp);
exit();	    
    
}   

		
										
		} else{  
		    
	$error[] = "Request not valid"; 
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();	    
		    
		}										
 
 ////////////////////////////////
 	}
 	else{
 	
	$error[] = "Insufficient Balance. please credit your wallet and try again.";
	$resp['msg'] = $error;
	$resp['status'] = false;
	echo json_encode($resp);
	exit();
 	    
 	}    
                                        
		
 function Apikeys($conn){
$qryApi = $conn->query("SELECT * FROM api_setting");
$Allapi = $qryApi->fetch_assoc();
return json_encode($Allapi);
}                               
                                
function Apidefault($conn, $variation_code){
$query_MapiS = $conn->query("SELECT * FROM exam_package WHERE plancode='$variation_code'");
$api_defualt = $query_MapiS->fetch_assoc();
return json_encode($api_defualt);
}  

function bal_val($conn, $user){
        $qrvalbal = $conn->prepare("SELECT * FROM users WHERE email=?");
        $qrvalbal->bind_param("s",$user);
        $qrvalbal->execute();
        $result = $qrvalbal->get_result();
        $fetchBal = $result->fetch_assoc();
        return json_encode($fetchBal);
    }	
	function walletDebit($conn,$current_balance, $user){  
	$Qdebit = $conn->prepare("UPDATE users SET bal=? WHERE email=?");
	$Qdebit->bind_param("ss",$current_balance,$user);
	$runexe = $Qdebit->execute();
	return $runexe;
	  }
	  
	  	  function updateTransactionsHistory($conn,$requestId,$pin){
	      $tranhis = $conn->query("UPDATE transactions SET status='Completed',token='0',channel='Wallet',meterno='$pin' WHERE ref='$requestId'");
	      return $tranhis;
	  }

?>