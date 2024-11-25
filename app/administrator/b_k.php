<?php 
require_once('../db.php');
//$data = json_decode(file_get_contents('php://input'),true);
$error  = array();
$resp = array();

if(isset($_GET['b'])){
 $serial = $_GET['b'];  
}
///////////////////////
if(empty($serial)){
  $error[] = "Empty value"; 
}


if(count($error) > 0){
$resp['msg'] = $error;
$resp['status'] = false;
echo json_encode($resp);
exit();
}
include('mails/mailer_ban.php');

$userInfo = json_decode(fetchUser($conn,$serial),true);    
$token = $userInfo[0]['email']; 
$fname = $userInfo[0]['name'];


if(BanKyc($conn,$serial)){ 
    
SendEmail($conn, $sitname, $hosturl,$token, $fname ,$smtpHost , $smtpPort, $smtpUser, $smtpPass,$support_email,$logo,$logoUrl);       

$userInfo = json_decode(fetchUser($conn,$serial),true);    
        
$resp = "Account Blocked for bank transfer";
?>
<script>window.location.href='kyc.php'</script>
<?php 
         
     }else{
     
     $error[] = "Request failed";
     $resp['status'] = false;
     $resp['msg'] = $error;
     echo json_encode($resp);
exit(); 
            }


function BanKyc($conn,$serial){
$qry = $conn->query("UPDATE kyc_info SET status='Banned' WHERE serial='$serial'");
return $qry;
}



function fetchUser($conn,$serial){
  $ch = $conn->query("SELECT * FROM kyc_info WHERE serial='$serial'");
  while($row[] = $ch->fetch_assoc()){}
  return json_encode($row);
}




?>