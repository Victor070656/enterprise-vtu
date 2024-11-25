<?php 
require_once('../../db.php');
//$data = json_decode(file_get_contents('php://input'));
$error = array();
$resp = array();
		$provider = $_POST['provider'];
		$private = $_POST['private'];
		$secret = $_POST['secret'];
		$contractcode = $_POST['contractcode'];
		$walletno = $_POST['walletno'];
	    $username = $_REQUEST['username'];
	    $password = $_REQUEST['password'];
		$baseurl = trim($_REQUEST['baseurl']);
  
//checking 
 $ExtId = $conn->query("SELECT * FROM providers_api_key WHERE provider='$provider' "); 
 if($ExtId->num_rows > 0){
     $ftrow = $ExtId->fetch_assoc();
     $d1_fetch = $ftrow['provider'];
     
    if(empty($provider)){
    $error[] = "Select provider";  
  } 
  
   
if(count($error) > 0){
$resp['status'] = false;
$resp['msg'] = $error;
echo json_encode($resp);
exit();
}

if(empty($private)){$new_private = $ftrow['privatekey']; } else { $new_private = $private; }

if(empty($secret)){$new_secret = $ftrow['secretkey']; } else { $new_secret = $secret; }

if(empty($contractcode)){$new_contractcode = $ftrow['contractcode']; } else { $new_contractcode = $contractcode; }

if(empty($walletno)){$new_walletno = $ftrow['wallet_no']; } else { $new_walletno = $walletno; }

if(empty($username)){$new_username = $ftrow['username']; } else { $new_username = $username; }

if(empty($password)){$new_password = $ftrow['password']; } else { $new_password = $password; }

if(empty($baseurl)){$new_baseurl = $ftrow['baseurl']; } else { $new_baseurl = $baseurl; }

    
     $Updateaction = updateOtherApi($conn,$new_private,$new_secret,$new_contractcode,$new_walletno,$new_username,$new_password,$new_baseurl,$provider);
    
    if($Updateaction){ 
        
$resp['msg'] = strtoupper($provider)." - Key Updated";
$resp['status'] = true;
echo json_encode($resp);
exit(); 
         
     }else{
     
     $error[] = strtoupper($provider)." -   update failed";
     $resp['msg'] = $error;
    $resp['status'] = false;
     echo json_encode($error);
exit(); 
            }
            
            
 }else{

$InsertAction =  InsertOtherApiKey($conn,$provider,$private,$secret,$contractcode,$walletno,$username,$password,$baseurl);  

if($InsertAction){
  
$resp['msg'] = strtoupper($provider)." Key Added";
$resp['status'] = true;
echo json_encode($resp);
exit(); 

}else{
    $error[] = "Error processing your request";
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();   

} }


function updateOtherApi($conn,$new_private,$new_secret,$new_contractcode,$new_walletno,$new_username,$new_password,$new_baseurl,$provider){
     $var_ApikeyUp = $conn->query("UPDATE providers_api_key SET privatekey='$new_private',secretkey='$new_secret',contractcode='$new_contractcode',wallet_no='$new_walletno',username='$new_username',password='$new_password',baseurl='$new_baseurl' WHERE provider='$provider'");
     return $var_ApikeyUp;
     }
     
function InsertOtherApiKey($conn,$provider,$private,$secret,$contractcode,$walletno,$username,$password,$baseurl){ 
 $Insert_apikey = $conn->query("INSERT INTO providers_api_key(provider,privatekey,secretkey,contractcode,wallet_no,username,password,baseurl) VALUES('$provider','$private','$secret','$contractcode','$walletno','$username','$password','$baseurl')");
 return $Insert_apikey;
}

?>