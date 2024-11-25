<?php 
require_once('../../db.php');
$smtpServer = $_POST['smtpserver'];
$smtpPort = $_POST['smtpport'];
$smtpUsername = $_POST['smtpuser'];
$smtppass = $_POST['smtppass'];
$Support_Email = $_POST['supemail'];
if(empty($smtpServer)){
$resp = "Enter SMTP Server address";    
echo json_encode($resp); 
exit();
}

if(empty($smtpPort)){
$resp = "Enter SMTP port";    
echo json_encode($resp); 
exit();
}

if(empty($smtpUsername)){
$resp = "Enter SMTP username";    
echo json_encode($resp); 
exit();
}

if(empty($smtppass)){
$resp = "Enter SMTP Password";    
echo json_encode($resp); 
exit();
}

if(empty($Support_Email)){
$resp = "Enter Support Email";    
echo json_encode($resp); 
exit();
}


$RunQuery = $conn->query("UPDATE smtp_settings SET smtp_host='$smtpServer',smtpport='$smtpPort',smtp_user='$smtpUsername',smtp_pass='$smtppass',adminEmail='$Support_Email' ");

if($RunQuery){
$resp = "SMTP Settings Updated";
echo json_encode($resp);
exit();
    
}else{
 
 $resp = "Error occur: Please try again";
echo json_encode($resp);
exit();   
    
}

?>