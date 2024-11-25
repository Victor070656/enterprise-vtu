<?php 
session_start();
require('../db.php');
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
				
if(isset($_REQUEST['email'])){
$res_user = $_REQUEST['email'];	
					
$memis = "DELETE FROM users WHERE email='$res_user'  ";
			
if($conn->query($memis)){	
header("Location: dashboard.php");						
exit;
} 
}



if(isset($_REQUEST['del'])){
$del_serv = $_REQUEST['del'];	
					
$serv = "DELETE FROM services WHERE serial='$del_serv'  ";
			
if($conn->query($serv)){	
header("Location: view_service.php");						
exit;
} 
}


if(isset($_REQUEST['pay'])){
	
	$pid = $_REQUEST['pay'];
	
$qrpay = mysqli_query($conn,"SELECT * FROM payalert WHERE serial='$pid'");

$paya = mysqli_fetch_array($qrpay);	

$payfrom = $paya['email'];
$amtpaid = $paya['amount'];
	
$adf = mysqli_query($conn,"SELECT * FROM users WHERE email='$payfrom'");
$isUser = mysqli_fetch_array($adf);

$userid =$isUser['email'];


$mak = "UPDATE payalert SET status='Completed',action='' WHERE serial='$pid'";	

	$makpaid = $conn->query($mak);

$crd = "UPDATE users SET bal=bal+$amtpaid WHERE email='$userid'";	

	if($conn->query($crd)){

	header("Location: depositreq.php");						
exit;}
	}
	
// reverse transaction	
	
if(isset($_REQUEST['reverse'])){
	
	$revtra = $_REQUEST['reverse'];
	
$qrRevs = mysqli_query($conn,"SELECT * FROM transactions WHERE serial='$revtra'");

$DoRevers = mysqli_fetch_array($qrRevs);	

$revTo = $DoRevers['email'];
$reverseValue = $DoRevers['charge'];
$trasref = 	$DoRevers['ref'];

$QryOwner = mysqli_query($conn,"SELECT * FROM users WHERE email='$revTo'");
$isOwner = mysqli_fetch_array($QryOwner);

$Rev_userid = $isOwner['email'];


$qy_Res = "UPDATE transactions SET status='Reversed',action='',credit='' WHERE serial='$revtra'";	

	$mark_reversed = $conn->query($qy_Res);

$Rev_crd = "UPDATE users SET bal=bal+$reverseValue WHERE email='$Rev_userid'";	

	if($conn->query($Rev_crd)){
		
//send message

$msg = "You have been credited N$reverseValue for failed transaction ref:$trasref. ePINs Nigeria.";

$sender = "ePINs";
								
$message = utf8_encode($msg);
$senderid = urlencode($sender);

$data = array(
    'username' => 'admin',
    'password' => 'control123',
	 'sender' => $senderid,
	  'recipient' => $isOwner['phone'],
	   'message' => $message
	    
);
# Create a connection
$url = 'http://www.epins.com.ng/sms/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch); 		
		

	header("Location: transactions.php");						
exit;}
	}	
	
	
// Credit transaction	
	
if(isset($_REQUEST['credit'])){
	
	$adtra = $_REQUEST['credit'];
	
$qrCredit = mysqli_query($conn,"SELECT * FROM transactions WHERE serial='$adtra'");

$DoCred = mysqli_fetch_array($qrCredit);	

$CreTo = $DoCred['email'];
$creditValue = $DoCred['charge'];
$Trasref = 	$DoCred['ref'];

$Get_Owner = mysqli_query($conn,"SELECT * FROM users WHERE email='$CreTo'");
$isAcc = mysqli_fetch_array($Get_Owner);

$Cred_userid = $isAcc['email'];


$qy_Cre = "UPDATE transactions SET status='Completed',credit='',action='',channel='Bank' WHERE serial='$adtra'";	

	$mark_credit = $conn->query($qy_Cre);

$Add_crd = "UPDATE users SET bal=bal+$creditValue WHERE email='$Cred_userid'";	

	if($conn->query($Add_crd)){
		
//send message

$msg = "You have been credited N$creditValue. Thank You ePINs Nigeria.";

$sender = "ePINs";
								
$message = utf8_encode($msg);
$senderid = urlencode($sender);

$data = array(
    'username' => 'admin',
    'password' => 'control123',
	 'sender' => $senderid,
	  'recipient' => $isAcc['phone'],
	   'message' => $message
	    
);
# Create a connection
$url = 'http://www.epins.com.ng/sms/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch); 		
		

	header("Location: transactions.php");						
exit;}
	}	
		
	
	
	
	


if(isset($_REQUEST['delpay'])){
	
$ddi = $_REQUEST['delpay'];
$delalert = "DELETE FROM payalert WHERE serial='$ddi'  ";
			
if($conn->query($delalert)){	
header("Location: depositreq.php");						
exit;
} }


if(isset($_REQUEST['delaff'])){
	
$delaf = $_REQUEST['delaff'];
$delaff = "DELETE FROM withdraw WHERE serial='$delaf'  ";
			
if($conn->query($delaff)){	
header("Location: paya.php");						
exit;
} }


if(isset($_REQUEST['deltra'])){
	
$deltra = $_REQUEST['deltra'];
$RunDelet = "DELETE FROM transactions WHERE serial='$deltra'  ";
			
if($conn->query($RunDelet)){	
header("Location: transactions.php");						
exit;
} }



if(isset($_REQUEST['afid'])){
	
	$afid = $_REQUEST['afid'];
	
$qrafl = mysqli_query($conn,"SELECT * FROM withdraw WHERE serial='$afid'");

$paff = mysqli_fetch_array($qrafl);	

$affrom = $paff['email'];
$amtwt = $paff['amount'];
	
$qraf = mysqli_query($conn,"SELECT * FROM users WHERE email='$affrom'");
$GetUser = mysqli_fetch_array($qraf);

$tobil =$GetUser['email'];

$userbal =$GetUser['refwallet'];
	
	if($userbal >= $amtwt){

$mark = "UPDATE withdraw SET status='Completed',action='' WHERE serial='$afid'";	

	$markpaid = $conn->query($mark);
	
$upwth = "UPDATE earnings SET withdrawal=withdrawal+$amtwt WHERE user='$affrom'";	
$upearn = $conn->query($upwth);

$Afcrd = "UPDATE users SET refwallet=refwallet-$amtwt WHERE email='$affrom'";	

	if($conn->query($Afcrd)){

	header("Location: paya.php");						
exit;}
		
	}else{
	
		echo '<div class="alert-alert-danger">Billing Error</div>' ;
		
	}
	}

$conn->close();
?> 

