<?php
$sev = $_POST['service'];
	$sno = $_POST['iuc'];
	$tp = $_POST['plan'];
								
$qryApi = mysqli_query($conn,"SELECT * FROM api_setting");
$apidata = mysqli_fetch_array($qryApi);

$apikey = $apidata['APIkey']; //email address()

$mobilekey = $apidata['mobilekey'];
$mobileID = $apidata['mobileID'];

$provi = array("epins","vtpass","clubkonnect","smartrecharge");
			
			if(in_array($apidata['tvactive']||$apidata['active']|| $apidata['poweractive']||$apidata['smileactive'],$provi) ){


// VTpass verify

$username = $apidata['VTuser']; //email address(sandbox@vtpass.com)
$password = $apidata['VTpass']; //password (sandbox)
$host = 'https://vtpass.com/api/merchant-verify';
$VTdata = array(
  	'serviceID'=> $_POST['service'], //integer e.g gotv,dstv,eko-electric,abuja-electric
  	'billersCode'=> $_POST['iuc'],// e.g smartcardNumber, meterNumber,
  	'type' => $_POST['plan']
  	
);

//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $host);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERPWD , $username.":" .$password);
curl_setopt($ch, CURLOPT_POSTFIELDS, $VTdata);
$verifydata = curl_exec($ch);
$result = json_decode($verifydata);

//Close the cURL handle.
curl_close($ch);



$customerName = $result->content->Customer_Name;				
				
$customerNumber = "";
				
$_SESSION['customerNumber']	= $customerNumber;
	
$invoiceNo = "";
				
$_SESSION['invoiceNo'] = $invoiceNo;				
				
			}else{


$host = "https://mobileairtimeng.com/httpapi/customercheck?userid=$mobileID&pass=$mobilekey&bill=$sev&smartno=$sno";
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $host);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$success = curl_exec($ch);
$result = json_decode($success,true);

//Close the cURL handle.
curl_close($ch);
		
$customerName = $result['customerName'];			

$customerNumber = $result['customerNumber'];
				
$_SESSION['customerNumber']	= $customerNumber;
				
$invoiceNo = $result['invoicePeriod'];
				
$_SESSION['invoiceNo'] = $invoiceNo;			
				
			}

?>