<?php
session_start();
require_once('../db.php'); 
$error = array();
$res = array();

$username = test_input($_SESSION['user']);
$amount = test_input(floatval($_POST['amount']));
$serviceID = test_input($_POST['service']);
$plan = test_input($_POST['plan']);
$phone = test_input($_POST['telNumber']);
$iuc = test_input($_POST['iuc']);
$variation_code = test_input($_POST['variation_code']);
$type = test_input($_POST['transType']);

if(empty($amount)){
    $error[] = "Amount is empty";
}
if(empty($serviceID)){
    $error[] = "Service type is empty";
}
if(empty($plan)){
    $error[] = "Plan is empty";
}
if(empty($phone)){
    $error[] = "Phone number is empty";
}
if(empty($iuc)){
    $error[] = "quantity is empty";
}

if(count($error) > 0){
    
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();
}

$ftrow =  json_decode(fetchPackage($conn,$variation_code),true);
     $network = $ftrow[0]['network'];
     $plan_fetch = $ftrow[0]['plan'];
     $gateway_fetch = $ftrow[0]['gateway'];
 $status_fetch = $ftrow[0]['status'];
 if($status_fetch !== 'disabled'){
			
										$uid = substr(str_shuffle("0123456789678901"), 0, 16);
			
										$_SESSION['amt'] = floatval($amount);
										$_SESSION['carier'] = $serviceID;
										$_SESSION['phone'] = $phone;
										$_SESSION['iuc'] = $iuc;
										$_SESSION['transid'] = $uid;
										$_SESSION['plan'] = $plan;
										$_SESSION['variation_code'] = $variation_code;
										$_SESSION['type'] = $type;
									
											$dat = date("d/m/Y");
											
											$token = uniqid();
											$stat = "pending";
											
										$pnt = $plan;
							$customerFullName = $fname.' '.$lname;			
				if(!empty($amount)){						
					
					$QryInsert = $conn->query("INSERT INTO transactions(network,serviceid,vcode,phone,ref,refer,amount,email,status,token,customer)VALUES('$pnt','$serviceID','$variation_code','$phone','$uid','$token','$amount','$username','$stat','$token','$customerFullName')");	
			if($QryInsert){				
			$resp['msg'] = "redirecting please wait";
			$resp['status'] = true;
			$resp['redirect'] = "transaction-view/nbais?$uid#transPreview";
		
			echo json_encode($resp);
			exit();
			}else{
			
			$error[] = "Unable to process request";
		$resp['msg'] = $error;
		$resp['status'] =  false;
		exit();    
			    
			}
		
		
         
				}else{
		
		$error[] = "Error processing request";
		$resp['msg'] = $error;
		$resp['status'] =  false;
		
		exit();
				    
				}
											
 	   
 	   } else {
           
    $error[] = "This service is currently unavailable : Please Try again shortly";
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();        
           
       }    
          
function fetchPackage($conn,$variation_code){
$qryPlan = $conn->query("SELECT * FROM exam_package WHERE plancode='$variation_code'"); 
while($prow[] = $qryPlan->fetch_assoc()){ }
return json_encode($prow);
}				           
					
								
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = filter_var($data, FILTER_SANITIZE_STRING);
   return $data;
}									
?>