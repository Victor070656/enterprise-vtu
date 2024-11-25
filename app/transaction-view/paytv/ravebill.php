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
			
		$ret = mysqli_query($conn,"SELECT * FROM deposit WHERE ref='$ref' ");
		
		$da = mysqli_fetch_array($ret);
		
		$amount = $da['amount'];
		$tid = $da['ref'];
		$token = $da['token'];
		$refer = $da['refer'];
		$status = $da['status'];							
	
	
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
					
					
		$ch = curl_init();
                $url = "https://epins.com.ng/api/biller?apikey=$apikey&service=$network&accountno=$iuc&vcode=$variation_code&amount=$amount&ref=$tid";
                curl_setopt($ch, CURLOPT_URL, $url); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, '3');
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
                $content = trim(curl_exec($ch));
                $resp = json_decode($content);                    
                curl_close($ch);
				
				$_SESSION['stat'] = "Completed";
				$_SESSION['amount'] = $amount;
				$_SESSION['carier'] = $carier;
				$_SESSION['transid'] = $tid;
				$_SESSION['product'] = $resp->description->product_name;
				$_SESSION['phone'] = $da['phone'];
				$_SESSION['pin'] = $resp->description->Token;
				
			
                // update
                $tk = md5(uniqid());
				$statu = "Completed";
                $r = $_GET['flwref'];
                
				$up = "UPDATE deposit SET token='$tk',refer='$r',status='$statu' WHERE ref='$tid' ";
				$conn->query($up);
				
	


$_SESSION['card'] = $card;
$_SESSION['lastdigit'] = $digit4;
$_SESSION['stat'] = $statu;
$_SESSION['flwref'] = $r;
$_SESSION['amtshow'] = $payamt;
			
          ?>
<script>window.location="transaction-details?ref='<?php echo $_GET['flwref']?>' ";</script> <?php    
               
                }
    
    
    
    
          // transaction was successful...
  			 // please check other things like whether you already gave value for this ref
          // if the email matches the customer who owns the product etc
          //Give Value and return to Success page
          
          // amount to credit minus fees


        }else { 
            
            // don't give value and return to failed page
      ?>
<script>window.location="buy_credit.php ";</script> <?php         
            
        }
    
    
    
    }
		else {
      die('No reference supplied');
      
     
    }


  

         

?>