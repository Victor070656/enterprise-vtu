<?php 
require_once('../db.php');
$data = json_decode(file_get_contents('php://input'),true);
$error  = array();
$resp = array();
$newname = $data['newname']; 
///////////////////////
if(empty($newname)){
  $error[] = "Enter New name"; 
}

if(count($error) > 0){
$resp['msg'] = $error;
$resp['status'] = false;
echo json_encode($resp);
exit();
}

$base = $data['base'];
$oldpath = $data['opath'];
$newpath = str_replace($base, $newname, $oldpath);

    if(rename($oldpath,$newpath)){ 
        
$resp['msg'] = "Admin folder changed";
$resp['status'] = true;
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error[] = "Request failed";
     $resp['status'] = false;
     $resp['msg'] = $error;
     echo json_encode($resp);
exit(); 
            }




?>