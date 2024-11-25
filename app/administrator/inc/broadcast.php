<?php
//sms all members
			   $sm = "SELECT phone from users  ";
			  $acc =  mysqli_query($conn,$sm);
			
			
			if(mysqli_num_rows($acc)>0){
		   
		    $sms_array = array();
				
			while($rowsm = mysqli_fetch_assoc($acc)){
			
		   $sms_array[] = $rowsm["phone"];
			}}
			  $send = implode(",",$sms_array);
			  
			  $no = count($sms_array);
			  

function fetchbksms($conn){
$query_smsk = $conn->query("SELECT * FROM providers_api_key WHERE provider='sms'");
$smkey = $query_smsk->fetch_assoc();
return json_encode($smkey);
}    
$json_bksm = json_decode(fetchbksms($conn));

$sender = 'Admin';	  
		
		if(isset($_POST['btn'])){
				
		$sendto = $_REQUEST['sendto'];
		$txt = $_REQUEST['message'];

# Create a connection
$url = $json_bksm->baseurl;
$ch = curl_init($url);
# Form data string
$postString = http_build_query(array(
    'username' => $json_bksm->username,
    'password' => $json_bksm->password,
	 'sender' => $sender,
	  'recipient' => $sendto,
	   'message' => $txt
), '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch); 

$ResponseArr = ["-2913"]; 
if(in_array($response,$ResponseArr)){
    echo '<div class="alert alert-danger">Message Sending Failed</div>';
    
} else { 

echo '<div class="alert alert-success">Message Sent</div>';	
}

}
		
	
?>