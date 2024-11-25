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

	$succ = $_GET['txref'];
	
	$ref = $_SESSION['ref'];
			
		$ret = mysqli_query($conn,"SELECT * FROM transactions WHERE ref='$ref' ");
		
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
				
           
$host = 'https://rovahost.com.ng/api/airtime/?';

$Param = array(
    'apikey' => $apikeys,
    'network'=> $network,
    'phone' => $phone,
    'amount' =>  $amount, 
    'ref' => $succ
 	
);

$curl       = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => $host,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_POSTFIELDS => $Param,
));
$success = curl_exec($curl);
$curl_errno = curl_errno($curl);
curl_close($curl);
     
		
                // update
                $tk = md5(uniqid());
				$statu = "Completed";
                $r = $_GET['flwref'];
                
				
			$upX = "UPDATE transactions SET token='$tk',refer='$r',status='$statu',channel='Rave' WHERE ref='$tid' ";
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