<?php
$error = array();
$resp = array();

$id = $_REQUEST['id'];
//file_put_contents('ch.txt',$id);
if(empty($id)){
$error[] = "Id is empty";    
}

if(count($error) > 0 ){
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();
}
require_once('../db.php');

$packInfo = json_decode(fetchPackage($conn,$id),true);

if($packInfo[0]['duration'] == 1){
 
 $msg = '<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> '.$packInfo[0]['plan'].' plan enable you to generate and print recharge card directly from your account <br>
 <strong>Features:</strong>
 <ul>
 <li><b>Instant Recharge card printing:</b> As a '.$packInfo[0]['plan'].' you can generate and  print recharge card without installing any software on computer or phone.</li>
 <li><b>Zero software activation key required:</b> Save money on software activation key which is usually stressful and expires often. Our recharge card PIN generator does not require any software activation key or code.</li>
 <li><b>Security:</b>  You no longer need to worry about losing your PINs as they are safely stored on the secured server. And you can print anytime.</li>
 <li><b>Universal recharge card printer:</b> You can print any network PINs and denominations. </li>
 </ul>
 </div>';   
    
}else if($packInfo[0]['duration'] == 12){
    
 $msg = '<div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> '.$packInfo[0]['plan'].' plan enable you to generate and print recharge card directly from your account and API.<br> 
 
 <strong>Features:</strong>
 <ul>
 <li><b>API Access:</b> As a '.$packInfo[0]['plan'].' you can easily integrate and generate direct and logical recharge card PINs from our API.</li>
 <li><b>Special Discount:</b> You enjoy discount on PINs purchase. </li>
 <li><b>Instant Recharge card printing:</b> '.$packInfo[0]['plan'].' let you  print recharge card without installing any software on computer or phone.</li>
 <li><b>Zero software activation key required:</b> Save money on software activation key which is usually stressful and expires often. Our recharge card PIN generator does not require any software activation key or code.</li>
 <li><b>Security:</b>  You no longer need to worry about losing your PINs as they are safely stored on the secured server. And you can print anytime.</li>
 <li><b>Universal recharge card printer:</b> You can print any network PINs and denominations. </li>
 </ul>
 </div>';   
}

$resp['status'] = true;
$resp['amount'] = $packInfo[0]['amount'];
$resp['plan'] = $packInfo[0]['plan'];
$resp['description'] = $msg;
echo json_encode($resp);
exit();

function fetchPackage($conn,$id){
$query = $conn->query("SELECT * FROM epin_package WHERE serial='$id'");
while($row[] = $query->fetch_assoc()){}
return json_encode($row);
}


?>