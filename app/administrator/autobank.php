    <?php
require('../db.php');     
   
$fetchUser = $conn->query("SELECT * FROM users");
$n = $fetchUser->num_rows;

function monnifyKey($conn){
$query_mfy = $conn->query("SELECT * FROM providers_api_key WHERE provider='monnify'");
$mfykey = $query_mfy->fetch_assoc();
return json_encode($mfykey);
}    
$json_mfy = json_decode(monnifyKey($conn));
$mapk =  $json_mfy->privatekey;   //$monRx['monn_apikey'];
$msekp = $json_mfy->secretkey;  //$monRx['monn_secret'];
$mconc = $json_mfy->contractcode;  //$monRx['monn_contra'];
//resever an account  

function Auth0($conn,$mapk,$msekp){
$encokey  = base64_encode("$mapk:$msekp");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.monnify.com/api/v1/auth/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Basic $encokey"));
$authlog = curl_exec($ch);
curl_close($ch);	
return $authlog;
}

$authoriz = json_decode(Auth0($conn,$mapk,$msekp));
$accessToken =  $authoriz->responseBody->accessToken;



function deallocate($conn,$accessToken,$accountID){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.monnify.com/api/v1/bank-transfer/reserved-accounts/reference/$accountID");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Bearer $accessToken"));
$Deresponse = curl_exec($ch);
curl_close($ch);

return $Deresponse;
}

/////////////////////////////////////////////

  


/////////////////////////////////////////////////////

function FetchUserAccount($conn,$accountID,$accessToken){
$uid = substr(str_shuffle("0123456789678901"), 0, 16);						

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.monnify.com/api/v1/bank-transfer/reserved-accounts/$accountID");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Bearer $accessToken"));
$responseFetch = curl_exec($ch);
curl_close($ch);

return $responseFetch;
}

//echo $response; 
$accd = json_decode($response,true);


  function reserveAccount($conn, $accountID, $accountID, $lname,$mconc, $email){  
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.monnify.com/api/v2/bank-transfer/reserved-accounts");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
'accountReference' => $accountID,
'accountName' =>  ''.$fname.' '.$lname.'',
'currencyCode'	=> 'NGN',
'contractCode'	=> $mconc,
'customerEmail' => $email,
'customerName' => $fname.' '.$lname,	
'getAllAvailableBanks' => true )));

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Authorization: Bearer $accessToken"));
$responseRs = curl_exec($ch);
curl_close($ch);		
$accd = json_decode($response,true);
$accName =  $accd['responseBody']['customerName'];

// WEMA Bank
$bnkaccNoWema = $accd['responseBody']['accounts'][0]['accountNumber'];
$bnkNameWema = $accd['responseBody']['accounts'][0]['bankName'];
// Moniepoint Bank
$moniePoint = $accd['responseBody']['accounts'][2]['accountNumber'];
$bnkNameRolex = $accd['responseBody']['accounts'][2]['bankName'];
//Sterling Bank
$bnkaccNoSterling = $accd['responseBody']['accounts'][1]['accountNumber'];
$bnkNameSterling = $accd['responseBody']['accounts'][1]['bankName'];
    
//Update account num
//$stm = $conn->query("UPDATE users SET wema='$bnkaccNoWema',moniepoint='$moniePoint',sterling='$bnkaccNoSterling',reserve='1' WHERE accno='$accountID' "); 
return $responseRs;
}
    


 
  ?>