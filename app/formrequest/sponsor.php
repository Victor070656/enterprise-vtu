<?php
$error = array();
$resp = array();

$sid = $_REQUEST['sid'];
$planid = $_REQUEST['pid'];
$token = base64_decode($_REQUEST['tok']);
file_put_contents('ch.txt',$sid.'/'.$planid.'/'.$token);
if(empty($sid)){
$error[] = "Id is empty";    
}

if(count($error) > 0 ){
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();
}
require_once('../db.php');

$sponsor = json_decode(fetchSponsor($conn,$sid),true);
$packInfo = json_decode(fetchPackage($conn,$planid),true);
$userInfo = json_decode(checkUserCode($conn,$token),true);

if($userInfo[0]['refid'] == $sid){ 

$error[] = "Oops! You can not invite yourself.";
 $resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);   
exit();     
    
} else {

if(checkSponsor($conn,$sid) > 0){

 $msg = ' 
 
 You were invited by <strong>'.$sponsor[0]['firstname'].' '.$sponsor[0]['lastname'] .'</strong>.  Your referal will be paid <strong>'.'&#8358;'.$packInfo[0]['commission'].'</strong> for this transaction. <br>
 
 Invite your friends to generate recharge card PINs on eLoaded and earn 20% commission once they activate account. You can transfer your commission to your bank account anytime.
 ';
 

$resp['status'] = true;
$resp['amount'] = $packInfo[0]['amount'];
$resp['plan'] = $packInfo[0]['plan'];
$resp['msg'] = $msg;
echo json_encode($resp);
exit();
}else {
 
 $error[] = "Referal code you entered is invalid";
 $resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);   
exit();    
}

}

function checkSponsor($conn,$sid){
$querych = $conn->query("SELECT * FROM users WHERE refid='$sid'");
 $rowch = $querych->num_rows;
return json_encode($rowch);
}

function checkUserCode($conn,$token){
$queryUserCode = $conn->query("SELECT * FROM users WHERE email='$token'");
 while($chExt[] = $queryUserCode->fetch_assoc()){}
return json_encode($chExt);
}

function fetchSponsor($conn,$sid){
$querysp = $conn->query("SELECT * FROM users WHERE refid='$sid'");
while($rowsp[] = $querysp->fetch_assoc()){}
return json_encode($rowsp);
}


function fetchPackage($conn,$planid){
$query = $conn->query("SELECT * FROM epin_package WHERE serial='$planid'");
while($row[] = $query->fetch_assoc()){}
return json_encode($row);
}

?>