<?php 
require_once('../db.php');
//$data = json_decode(file_get_contents('php://input'),true);
$error  = array();
$resp = array();

if(isset($_GET['r'])){
 $serial = $_GET['r'];  
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

if(!empty($serial)){
DeleteRequest($conn,$serial);
}


function DeleteRequest($conn,$serial){

if(DeleteKyc($conn,$serial)){ 

$userInfo = json_decode(fetchUser($conn,$serial),true);    
        
$resp = "KYC Rejected and Delete";
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
}

function DeleteKyc($conn,$serial){
$qry = $conn->query("DELETE FROM kyc_info WHERE serial='$serial'");
return $qry;
}



function fetchUser($conn,$serial){
  $ch = $conn->query("SELECT * FROM kyc_info WHERE serial='$serial'");
  while($row[] = $ch->fetch_assoc()){}
  return json_encode($row);
}




?>