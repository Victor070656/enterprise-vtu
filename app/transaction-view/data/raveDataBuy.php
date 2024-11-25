<?php
session_start();
require('../../db.php');
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
header("location: index.php");
  exit;
		}
								
	$user = $_SESSION['user'];
								
	$ins = mysqli_query($conn,"SELECT * FROM users WHERE email='$user' ");
	$data = mysqli_fetch_array($ins);
								
	$email = $data['email'];
	$rowpas = $data['pass'];
	$fname = $data['firstname'];
	$lname = $data['lastname'];

	$requestId = $_GET['txref'];
	
	$ref = $_SESSION['ref'];
			
		$ret = mysqli_query($conn,"SELECT * FROM transactions WHERE ref='$requestId' ");
		
		$da = mysqli_fetch_array($ret);
		
		$amount = $da['amount'];
		$tid = $da['ref'];
		$token = $da['token'];
		$refer = $da['refer'];
		$status = $da['status'];							
	    $destin = $da['phone'];
	
$query_rec = mysqli_query($conn,"SELECT * FROM payment");
			
			$apib = mysqli_fetch_array($query_rec);
			
$paykey = $apib['flutterSecret'];	
			
// confirm Rave payment 

if (isset($_GET['txref'])) {
        $cref = $_GET['txref'];
        $amount = ""; //Correct Amount from Server
        $currency = ""; //Correct Currency from Server

        $query = array(
            "SECKEY" => $paykey,
            "txref" => $cref
        );

        $data_string = json_encode($query);
                
        $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);
        
        

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        
        
        curl_close($ch);

        $resp = json_decode($response, true);
        
        
      	$paymentStatus = $resp['data']['status'];
        $chargeResponsecode = $resp['data']['chargecode'];
        $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = $resp['data']['currency'];
        $vbMessage = $resp['data']['vbvmessage'];
        
        $card = $resp['data']['card']['brand'];
        
        $digit4 =   $resp['data']['card']['last4digits'];
        
     
if($chargeResponsecode === '00' && $paymentStatus === 'successful' ) {
    
    
    $payamt = $chargeAmount;

    
                if($token === $refer && $status !== 'Completed'){
	
	
$qryApi = mysqli_query($conn,"SELECT * FROM api_setting");
$apidata = mysqli_fetch_array($qryApi);

$apikey = $apidata['APIkey']; //email address()	
$smartKey = $apidata['smartkey'];	

$callb = $_SERVER['SERVER_NAME'];											

$mobilekey = $apidata['mobilekey'];
$mobileID = $apidata['mobileID'];
   



if($apidata['dataactive'] == 'epins'){

$Bxaram = array(
    "apikey" => $apikey,
    "service" => $network,
    "accountno" => $phone,
    "vcode" => $variation_code,
    "amount" => $amount,
    "ref" => $requestId
    );

//Initialize cURL.
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://epins.com.ng/api/biller/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $Bxaram);

$veridata = curl_exec($ch);
$result = json_decode($veridata);
curl_close($ch);


}elseif($apidata['dataactive'] == 'vtpass'){

$username = $apidata['VTuser'];
$password = $apidata['VTpass'];
$host = "https://vtpass.com/api/pay";
$data = array(
    'request_id' => $requestId,
  	'serviceID'=> $network, //integer e.g gotv,dstv,eko-electric,abuja-electric
  	'billersCode'=> $phone, // e.g smartcardNumber, meterNumber,
  	'variation_code'=> $variation_code, // e.g dstv1, dstv2,prepaid,(optional for somes services)
  	'amount' =>  $amount, // integer (optional for somes services)
  	'phone' => $phone //integer
  	
);

$curl       = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => $host,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_USERPWD => $username.":" .$password,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_SSL_VERIFYPEER => true,
	CURLOPT_POSTFIELDS => $data,
));
$success = curl_exec($curl);
$curl_errno = curl_errno($curl);
curl_close($curl);

$resp = json_decode($success, true);
								
}

elseif($apidata['dataactive'] == 'smartrecharge'){

$host = "https://smartrecharge.ng/api/v2/directdata/?api_key=$smartKey&product_code=$variation_code&phone=$phone&callback=$callb";
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $host);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$resdata = curl_exec($ch);
$result = json_decode($resdata);

//Close the cURL handle.
curl_close($ch);				
	
}
			
elseif($apidata['dataactive'] == 'mobileng'){

$host = "https://mobileairtimeng.com/httpapi/datatopup.php?userid=$mobileID&pass=$mobilekey&network=$ngnet&phone=$phone&amt=$amount&jsn=json";
				
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $host);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$resdata = curl_exec($ch);
$result = json_decode($resdata);

//Close the cURL handle.
curl_close($ch);					
	
}	
			
elseif($apidata['dataactive'] == 'simhost'){
			
	
if($network == 'mtn-data'){	
	
		
$uid = substr(str_shuffle("0123456789678901"), 0, 16);

$url = "https://simhostng.com/api/ussd?";

										
$uvalues = array(
'apikey' => $apidata['simkey'],
'server' => $apidata['serverMTN'],
'sim' => '1',	
'number' => '*456*1*2*'.$amount.'*'.$phone.'*1*'.$simPIN.'#',	
'ref' => $uid,
	
'url' => $callb
	);										
										

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $uvalues);
$response = curl_exec($ch);
curl_close($ch);
										

	
}
	
	
if($network == 'airtel-data'){	
	
		
$uid = substr(str_shuffle("0123456789678901"), 0, 16);

$url = "https://simhostng.com/api/ussd?";

										
$uvalues = array(
'apikey' => $apidata['simkey'],
'server' => $apidata['serverAirtel'],
'sim' => '1',	
'number' => '*141*6*2*1*7*1*'.$phone.'*'.$simPIN.'#',	
'ref' => $uid,
	
'url' => $callb
	);									
										

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $uvalues);
$response = curl_exec($ch);
curl_close($ch);
										

	
}
	
if($network == 'glo-data'){	
	
		
$uid = substr(str_shuffle("0123456789678901"), 0, 16);

$url = "https://simhostng.com/api/ussd?";

										
$uvalues = array(
'apikey' => $apidata['simkey'],
'server' => $apidata['serverGlo'],
'sim' => '1',	
'number' => '*229*2*'.$amount.'*'.$phone.'#',	
'ref' => $uid,
	
'url' => $callb
	);										
										

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $uvalues);
$response = curl_exec($ch);
curl_close($ch);
										

	
}	
	
	
if($network == 'etisalat-data'){	
	
		
$uid = substr(str_shuffle("0123456789678901"), 0, 16);

$url = "https://simhostng.com/api/ussd?";

										
$uvalues = array(
'apikey' => $apidata['simkey'],
'server' => $apidata['serverEtisalat'],
'sim' => '1',	
'number' => '*229*2*36*'.$phone.'#',	
'ref' => $uid,
	
'url' => $callb
	);										
										

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $uvalues);
$response = curl_exec($ch);
curl_close($ch);


}	}		


		
                // update
                $tk = md5(uniqid());
				$statu = "Completed";
                $r = $_GET['flwref'];
                
				
			$upX = "UPDATE transactions SET token='$tk',refer='$r',status='$statu',channel='Rave' WHERE ref='$requestId' ";
				$conn->query($upX);	
			
			
          ?>
<script>window.location="transaction-history?ref='<?php echo $_GET['flwref']?>' ";</script> <?php    
               
                }
    
          // transaction was successful...
  			 // please check other things like whether you already gave value for this ref
          // if the email matches the customer who owns the product etc
          //Give Value and return to Success page
          
          // amount to credit minus fees


        }else { 
            
            // don't give value and return to failed page
      ?>
<script>window.location="index.php";</script> <?php         
            
        }
    
    
    
    }
		else {
      die('No reference supplied');
      
     
    }


?>