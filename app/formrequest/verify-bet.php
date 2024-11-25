<?php
$error = array();
$resp = array();

$id = sanitize_input($_REQUEST['id']);
$UserEmail = sanitize_input(base64_decode($_REQUEST['token']));
$meterno = sanitize_input($_REQUEST['meterno']);
$metertype = sanitize_input($_REQUEST['metertype']);
if(empty($id)){
$error[] = "Id is empty";    
}
require_once('../db.php');
$packInfo = json_decode(fetchPackage($conn,$id),true);

$price = $packInfo[0]['amount'];    
$network = $packInfo[0]['network'];


$result = json_decode(verify($conn,$network,$meterno));


//file_put_contents('resp.txt',$id.$UserEmail.$price.'/'.$meterno.'/'.$network.'/'.$metertype);
if(is_null($result->description->Customer)){ 

$error[] = "Unable to verify Account ID";
$resp['msg'] = $error;
$resp['status'] = false;
echo json_encode($resp);
exit();     

}else{
  
  session_start();
$_SESSION['customer'] = $result->description->Customer;  
$_SESSION['Address'] = $result->description->Address;  
$resp['status'] = true;
$resp['msg'] = '<font color="green">Success: </font> ';
$resp['name'] = $result->description->Customer;
$resp['address'] = $result->description->reference;
$resp['due'] = $result->description->Due_Date;
echo json_encode($resp);
exit();
    

}

function fetchPackage($conn,$id){
$query = $conn->query("SELECT * FROM betting_package WHERE serial='$id'");
while($row[] = $query->fetch_assoc()){}
return json_encode($row);
}


function verify($conn,$network,$meterno){
    function urlbasemain(){
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/base?url=main");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$basedata = curl_exec($ch);
$result = json_decode($basedata,true);
//Close the cURL handle.
curl_close($ch);
return $result['description'][0]['main'];

	}
	function fetchEpin($conn){
$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
$fetchepkey = $query_ep->fetch_assoc();
return json_encode($fetchepkey);
}    
$json_ep = json_decode(fetchEpin($conn));
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, urlbasemain()."/"."bet-verify/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $json_ep->privatekey,
    "customerId" => $meterno,
   
    )));
$veridata = curl_exec($ch);
curl_close($ch);
//file_put_contents('v.txt',$veridata);
return $veridata;
}



function sanitize_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = strip_tags($data);
   $data = filter_var($data, FILTER_SANITIZE_STRING);
   $data = filter_var($data, FILTER_SANITIZE_SPECIAL_CHARS);
   return $data;
}



?>