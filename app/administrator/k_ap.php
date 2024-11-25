<?php 
require_once('../db.php');
$error  = array();
$resp = array();

if(isset($_GET['a'])){
 $serial = $_GET['a'];  
}

if(empty($serial)){
  $error[] = "Empty value"; 
}

if(count($error) > 0){
$resp['msg'] = $error;
$resp['status'] = false;
echo json_encode($resp);
exit();
}
include('mails/mailer_approve.php');

$userInfo = json_decode(fetchUser($conn,$serial),true);    
$token = $userInfo[0]['email']; 
$fname = $userInfo[0]['name'];

if(approveKyc($conn,$serial)){ 

SendEmail($conn, $sitname, $hosturl,$token, $fname ,$smtpHost , $smtpPort, $smtpUser, $smtpPass,$support_email,$logo,$logoUrl);    
    
$resp = "Account Approved For Money Transfer";
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




function approveKyc($conn,$serial){
$qry = $conn->query("UPDATE kyc_info SET status='Approved' WHERE serial='$serial'");
return $qry;
}

function fetchUser($conn,$serial){
  $ch = $conn->query("SELECT * FROM kyc_info WHERE serial='$serial'");
  while($row[] = $ch->fetch_assoc()){}
  return json_encode($row);
}



?>