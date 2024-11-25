<?php 
ob_start();
session_start();
session_regenerate_id();
require('../../db.php'); 
include('../../inc/func1.php');
include('../../inc/gravatar.php');
include('../../inc/logo.php');
include('../../inc/coinpayments.inc.php');
include('../../inc/query_processor.php');
?> 
<?php include('../../inc/header2.php');?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
      
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php include('../../inc/nav3.php'); ?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                  
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="ecommerce-widget">

                        <div class="row"></div>
                        <div class="row">
                            <!-- ============================================================== -->
                      
                            <!-- ============================================================== -->

                                          <!-- recent orders  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                            
                                <div class="card">
                                          
                                    <h5 class="card-header"></h5>
                                    <div class="card-body">
                                    <?php
							if(ctype_digit($_SESSION['amt'])){
										$username = $_SESSION['user'];
										$amount = floatval(intval(abs($_SESSION['amt'])));
										$network = $_SESSION['carier'];
										$phone = $_SESSION['phone'];
										$requestId = $_SESSION['transid'];
								
									   $plan = $_SESSION['plan'];
										
										$variation_code = $_SESSION['variation_code'];
									
							             
							               
							               $trans = mysqli_query($conn,"SELECT * FROM transactions WHERE ref='$requestId' ");					
					$rowTrans = mysqli_fetch_array($trans);
										
								$txtadmin = "08084121526";		
										// replace comma
						$str1 = floatval(intval(abs($amount)));
						$xamount = str_replace( ',', '', $str1);
						
    	$access = 'free';
	    $airtelvtu = $bil['airtelData'];
		$mtnvtu = $bil['mtnData'];
		$glovtu = $bil['gloData'];
		$etisalatvtu = $bil['9mobileData'];
		
		if($network === 'mtn-data' && $level !== $access ){
		
		$per = $mtnvtu;	
		
			
			}elseif($network === 'airtel-data' && $level !== $access){
				
			$per = $airtelvtu;
				
				}elseif($network === 'etisalat-data' && $level !== $access){
					
				$per = $etisalatvtu;
				
					
					}elseif($network === 'glo-data' && $level !== $access){
						
					$per = $glovtu;	
					
				
						}else{ 
						
						$airtelvtuR = $Regubil['airtelData'];
		$mtnvtuR = $Regubil['mtnData'];
		$glovtuR = $Regubil['gloData'];
		$etisalatvtuR = $Regubil['9mobileData'];
		
		if($network === 'mtn-data' && $level == $access ){
		
		$per = $mtnvtuR;	
		
			
			}elseif($network === 'airtel-data' && $level == $access){
				
			$per = $airtelvtuR;
				
				}elseif($network === 'etisalat-data' && $level == $access){
					
				$per = $etisalatvtuR;
				
					
					}elseif($network === 'glo-data' && $level == $access){
						
					$per = $glovtuR;	
					
				
						}else{ $per = 0;} 
						
						
						}  
						
							if($network === 'mtn-data'){
							$decoder = "Data Bundle";
							$pnt = "MTN DATA($plan)";
							$img = 'Data-mtn.jpg';
								
							$ngnet = "15";	
							
							}elseif($network === 'airtel-data'){
								
								$pnt = "Airtel Data($plan)";
								$decoder = "Data Bundle";
								
								$img = 'Airtel-Data.jpg';
								
								$ngnet = "1";	
								
								
								}elseif($network === 'glo-data'){
									$pnt = "Glo Data($plan)";
									$decoder = "Data Bundle";
									
									$img = 'GLO-Data.jpg';
								
								$ngnet = "6";	
									
									
									
									}elseif($network === 'etisalat-data'){
										
									$pnt = "9Mobile Data($plan)";
									$decoder = "Data Bundle";
									
									$img = '9mobile-Data.jpg';
									
								$ngnet = "2";	
									  
										}
									
										
						$comi = ($per/100)* floatval(intval(abs($xamount)));
			$debit = strval(floatval(intval($xamount)) - floatval(intval($comi)));				
						
						$charge = 0;
			
							if ($_SERVER['REQUEST_METHOD'] === 'POST') {	
										
									if(isset($_POST['pay'])){
									
										if(floatval(intval(abs($debit))) <= $bal){	
											$dat = date("d/m/Y");
											
											$token = uniqid();
											$stat = "pending";
function Apikeys($conn){											
$qryApi = $conn->query("SELECT * FROM api_setting");
$Allkey = $qryApi->fetch_assoc();
return json_encode($Allkey);
}
$apidata = json_decode(Apikeys($conn));
$apikey = $apidata->APIkey;	$smartKey = $apidata->smartkey; 
$hashkey = $apidata->shago;$callb = $_SERVER['SERVER_NAME'];
$mobilekey = $apidata->mobilekey;$mobileID = $apidata->mobileID;
$username = $apidata->VTuser;$password = $apidata->VTpass;						
$simPIN = $apidata->simPin;											
										
$ret = mysqli_query($conn,"SELECT * FROM transactions WHERE ref='$requestId' ");
$da = mysqli_fetch_array($ret);
$tref = $da['ref'];
		
if($da['refer'] === $da['token']){								

$apicon = json_decode(gateway($conn, $variation_code));

if($apicon->gateway === 'epins'){
    
$result = json_decode(epinsPay($conn, $apikey, $network, $phone, $variation_code, $amount,$requestId ));
 $responseAPI = $result->code;

}else if($apicon->gateway === 'vtpass'){

$resp = json_decode(vtpassPay($conn,$username, $password, $requestId, $phone , $variation_code, $amount, $plan ));

$responseAPI = $resp->code;
								
}else if($apicon->gateway === 'shago'){

$respShago = json_decode(shagopay($conn, $phone, $amount, $variation_code, $network, $requestId, $hashkey, $plan));
$responseAPI = $respShago->status;

}
else if($apicon->gateway === 'smartrecharge'){

$resultSmat = json_decode(SmartRech($conn,$smartKey , $variation_code, $phone, $callb),true);

//Close the cURL handle.
curl_close($ch);
$responseAPI = $resultSmat['data']['text_status'];
	
}
else if($apicon->gateway === 'mobileng'){

$resultMng = json_decode(MobilNg($conn, $mobileID, $mobilekey, $ngnet, $phone,$amount ));

//Close the cURL handle.
curl_close($ch);					
$responseAPI = $resultMng->code;	
}	
			
else if($apicon->gateway === 'simhost'){
			
	
if($network == 'mtn-data'){	

$ch = curl_init("https://simhostng.com/api/ussd?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
'apikey' => $apidata['simkey'],
'server' => $apidata['serverMTN'],
'sim' => '1',	
'number' => '*456*1*2*'.$amount.'*'.$phone.'*1*'.$simPIN.'#',	
'ref' => $requestId,
	
'url' => $callb
	));
$response = curl_exec($ch);
curl_close($ch);
									
}
if($network == 'airtel-data'){	

$uid = substr(str_shuffle("0123456789678901"), 0, 16);
$ch = curl_init("https://simhostng.com/api/ussd?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
'apikey' => $apidata['simkey'],
'server' => $apidata['serverAirtel'],
'sim' => '1',	
'number' => '*141*6*2*1*7*1*'.$phone.'*'.$simPIN.'#',	
'ref' => $requestId,
	
'url' => $callb
	));
$response = curl_exec($ch);
curl_close($ch);

}
	
if($network == 'glo-data'){	

$ch = curl_init("https://simhostng.com/api/ussd?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
'apikey' => $apidata['simkey'],
'server' => $apidata['serverGlo'],
'sim' => '1',	
'number' => '*229*2*'.$amount.'*'.$phone.'#',	
'ref' => $requestId,
	
'url' => $callb
	));
$response = curl_exec($ch);
curl_close($ch);
										
}	

if($network == 'etisalat-data'){	
	
$ch = curl_init("https://simhostng.com/api/ussd?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, array(
'apikey' => $apidata['simkey'],
'server' => $apidata['serverEtisalat'],
'sim' => '1',	
'number' => '*229*2*36*'.$phone.'#',	
'ref' => $requestId,
	
'url' => $callb
	));
$response = curl_exec($ch);
curl_close($ch);


}					
}

if($responseAPI === '101' OR $responseAPI === '100' OR $responseAPI === 'successful' OR $responseAPI === '000' OR $responseAPI === '200'){
    
    	$prevBal = json_decode(bal_val($conn, $user));
	$current_balance = strval(floatval($prevBal->bal) - floatval($debit));
	 walletDebit($conn,$current_balance, $user);

$qsel = "UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet' WHERE ref='$tref' ";	
			$sav = $conn->query($qsel);
			
	?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>Transaction Successful</strong>  
				</div>
				
				<script>
   
Swal.fire({
  title: 'Transaction Successful',
  html:
    '<b><?php echo $plan; ?> Data has been sent to <?php echo $phone; ?></b>, ',
  icon: 'success',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Make Purchase'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href="../../data.php";
  }
})
    
</script>
		<?php
				
		
									
}else{
    
   	?>
   	<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Transaction Failed</strong>  
		</div> <?php  
}				
									
					} else{
					?>
					<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Error Occur: Please contact support@'.$_SERVER['SERVER_NAME'].'</strong>  
									</div> <?php  }										
 
										}
                                   else{
                                   
                                   ?>
                                   <div class="alert alert-warning">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>[ Insufficient Balance ]</strong>, please pay with ATM card or <a href="../../add-fund.php">Click here to credit wallet </a> 
									</div> <?php  }    
                                        
								
                                }	}
                            
if(isset($_POST['cardpay'])){
$uid = substr(str_shuffle("0123456789678901"), 0, 16);				   
					// payprocessor
 if($apib['activepay'] == 'paystack'){
include('../../inc/paystack-bill.php');
 }else{
	 
include('../../inc/flutterwave.php');	 
	 }
		
					
} 
						 
if($rowTrans['status'] !== 'Completed'){
										  
include('../../inc/confirm-transaction.php');  
										  
}else{
											  
include('../../inc/transaction-details.php');   
											  
}	


function gateway($conn, $variation_code){
$qrGate = $conn->query("SELECT * FROM data_package WHERE plancode='$variation_code'");
$gr = $qrGate->fetch_assoc();
return json_encode($gr);
}


function bal_val($conn, $user){
        $qrvalbal = $conn->prepare("SELECT * FROM users WHERE email=?");
        $qrvalbal->bind_param("s",$user);
        $qrvalbal->execute();
        $result = $qrvalbal->get_result();
        $fetchBal = $result->fetch_assoc();
        return json_encode($fetchBal);
    }	
			function walletDebit($conn,$current_balance, $user){  
	$Qdebit = $conn->prepare("UPDATE users SET bal=? WHERE email=?");
	$Qdebit->bind_param("ss",$current_balance,$user);
	$runexe = $Qdebit->execute();
	return $runexe;
	  }

function epinsPay($conn, $apikey, $network, $phone, $variation_code, $amount,$requestId ){
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/biller/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    "apikey" => $apikey,
    "service" => $network,
    "accountno" => $phone,
    "vcode" => $variation_code,
    "amount" => $amount,
    "ref" => $requestId
    )));
$veridataEpin = curl_exec($ch);
curl_close($ch);
return $veridataEpin;
}	  
	  
function shagopay($conn, $phone, $amount, $variation_code, $network, $requestId, $hashkey, $plan){    
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
'serviceCode' => "BDA",
'phone' => $phone,
'amount' => $amount,
'bundle' => $plan,
'network' => substr(strtoupper($network),0,-5),
'package' => $variation_code,
'request_id' => $requestId
)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "hashKey: $hashkey"
));
 
$response_shago = curl_exec($ch);
curl_close($ch);
return $response_shago;
}

function vtpassPay($conn,$username, $password, $requestId, $phone , $variation_code, $amount ){
$curl       = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => "https://vtpass.com/api/pay",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_USERPWD => $username.":" .$password,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_SSL_VERIFYPEER => true,
	CURLOPT_POSTFIELDS => array(
    'request_id' => $requestId,
  	'serviceID'=> $network, //integer e.g gotv,dstv,eko-electric,abuja-electric
  	'billersCode'=> $phone, // e.g smartcardNumber, meterNumber,
  	'variation_code'=> $variation_code, // e.g dstv1, dstv2,prepaid,(optional for somes services)
  	'amount' =>  $amount, // integer (optional for somes services)
  	'phone' => $phone //integer
  	
),
));
$successVtPass = curl_exec($curl);
$curl_errno = curl_errno($curl);
curl_close($curl);

return $successVtPass;
}

function SmartRech($conn,$smartKey , $variation_code, $phone, $callb){
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://smartrecharge.ng/api/v2/directdata/?api_key=$smartKey&product_code=$variation_code&phone=$phone&callback=$callb");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$resdataSmart = curl_exec($ch);
return $resdataSmart ;
}

function MobilNg($conn, $mobileID, $mobilekey, $ngnet, $phone,$amount ){		
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://mobileairtimeng.com/httpapi/datatopup.php?userid=$mobileID&pass=$mobilekey&network=$ngnet&phone=$phone&amt=$amount&jsn=json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$resdataMng = curl_exec($ch);
return $resdataMng;
}

}else{
    
    ?><script>window.location.replace('../../data.php');</script><?php
}
?>
                       
                                        
                                        
                                  <script>
                           
						   function show9mobile() {
  var sourceOfPicture = "assets/images/9mobile.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
} 
                   
function showMTN() {
  var sourceOfPicture = "assets/images/mtn.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
} 

function showAirtel() {
  var sourceOfPicture = "assets/images/airtel.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
} 

function showGlo() {
  var sourceOfPicture = "assets/images/glo.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
} 
                    
                                  </script>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->
<script>
							 
							 function Comma(Num)
 {
       Num += '';
       Num = Num.replace(/,/g, '');

       x = Num.split('.');
       x1 = x[0];

       x2 = x.length > 1 ? '.' + x[1] : '';

       
         var rgx = /(\d)((\d{3}?)+)$/;

       while (rgx.test(x1))

       x1 = x1.replace(rgx, '$1' + ',' + '$2');
     
       return x1 + x2;       
        
 }
 
 
 
 function yesnoCheck() {
    if (document.getElementById('yescard').checked) {
        document.getElementById('ifYes').style.visibility = 'visible';
    }
    
     if (document.getElementById('yescash').checked) {
        document.getElementById('ifYes').style.visibility = 'visible';
    }
    
     if (document.getElementById('yesbitcoin').checked) {
        document.getElementById('ifYes').style.visibility = 'visible';
    }
    
    

}



                            </script> 
                            <!-- ============================================================== -->
                            
                             <script>
// Set the date we're counting down to
var countDownDate = new Date("Jan 5, 2021 15:37:25").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 0));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 1)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 30)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("timing").innerHTML =  hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("timer").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
                            <!-- ============================================================== -->
                            <!-- customer acquistion  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Account Status</h5>
                                    <div class="card-body">
                                   <div class="d-inline-block">
                                        <h5 class="text-muted">Current Balance</h5>
                                        <h2 class="mb-0"> &#x20A6;<?php echo number_format($bal,2,'.',',');?></h2>
                                    </div>
                                    <div class="float-right icon-circle-medium  icon-box-lg  bg-brand-light mt-1">
                                        <i class="fa fa-money-bill-alt fa-fw fa-sm text-brand"></i>
                                    </div>
                                   
                                    </div>
                                </div>
                                
                                <div class="card">
                                <div class="card-body">
                                    <div class="d-inline-block">
                                        <h5 class="text-muted">Affiliate Link:</h5>
                                        <p class="mb-0"> <?php echo $data['reflink'];echo $data['refid'];?></p>
                                        
                                    </div>
                                    <div class="float-left"><p class="text-muted"><strong>Total Referred:</strong> <?php echo $data['refcount']; ?> <br> 
                                    
                                   <strong> Earning:</strong> &#x20A6;<?php echo number_format($data['refwallet'],2,'.',','); ?>
                                    </p> </div>
                                    
                                    
                                    <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                        
                                        <i class="fa fa-users fa-fw fa-sm text-primary"></i>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <!-- ============================================================== -->
                            
                            
                            
                            <!-- end customer acquistion  -->
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Recent Transactions</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th>Transaction ID</th>
                                                
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                         <?php 
							$sql_trans = "SELECT * FROM transactions WHERE email='$user' ORDER BY `serial` DESC LIMIT 3 ";
									
$Show_trans = $conn->query($sql_trans);
										
										while($trow = $Show_trans->fetch_assoc())
											
											{
										
											?>
                                            <tr>
                                           
                                                <td><?php echo $trow['ref']; ?></td>
                                                
                                                <td><?php echo '&#x20A6;'.$trow['amount'].' ';?></td>
                                                 <td><?php echo $trow['status'];?></td>
                                                <td><?php echo $trow['date'];?></td>
                                                
                                            </tr>
                                           
                                           <?php } ?>
                                          
                                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Transaction ID</th>
                                                
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>      
                          
                            <!-- ============================================================== -->
                        </div>
                        <div class="row">
                            <!-- ============================================================== -->
              				                        <!-- product category  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- end product category  -->
                          
  	<script type="text/javascript">
		//datepicker plugin
		//link	
		$('#sendWithPhoneBook').click(function(e){
		    $('#pb_groups').css('display','block');
		    e.preventDefault();
		});

		$("input[type=checkbox].grp_select").change( function() {
		    if($(this).is(":checked")){
		    	var bin = chkK();
		    		$("#grp_select_check").html('+'+bin+' Selected Phonebook Group Recepient(s)');	       	
			}else{
				var bin = chkK();
				if (bin > 0) {
					$("#grp_select_check").html('+'+bin+' Selected Phonebook Group Recepient(s)');
				}else{
					$("#grp_select_check").html('');
				}
			}
	  	});

		function countDest(){
			destcount = jQuery("#recipient").val();
			destcount = destcount.split(' ').join(',').split("\n").join(',').split(',,').join(',');
			// console.log(countUnit());
			destcount = destcount.split(',').length;
			if(destcount < 2) jQuery("#destcount").html(destcount+" recipient typed");
			else jQuery("#destcount").html(destcount+" recipients typed");
			$('#hiddenCount').html(destcount);
			// return destcount;
		}

		function chkK() {
			var val = [];
			$(':checkbox:checked').each(function(i){
	          val[i] = $(this).val();
	        });
	        return (val.length);
		}



		function countMsgsText(val){

			val = val.split("\n").join('??').split('{').join('??').split('}').join('??');

			val = val.split('\\').join('??').split('[').join('??').split(']').join('??');

			val = val.split('~').join('??').split('|').join('??').split('^').join('??');

			val = val.split('€').join('??').split('"').join('??').split("'").join('??');

			len = val.length;

			if(len<=160){

				jQuery('#paget').html('Page: '+Math.ceil(len/160));
				jQuery('#count').html(', Characters left: ' + (1+((160 - 1) * Math.ceil(len/160))-len) + ', Total Typed Characters: '+len);

				jQuery('#hiddenCount').html(Math.ceil(len/160)+' page');

			} else {
				jQuery('#paget').html('Page: '+Math.ceil(len/151));
				jQuery('#count').html(', Characters left: ' + (1+((151 - 1) * Math.ceil(len/151))-len) + ', Total Typed Characters: '+len);	

				jQuery('#hiddenCount').html(Math.ceil(len/151)+' pages');

			}

			countDest();

		}

		
		$('#recipient').keyup(function(){
			if (this.value.length > 0) {
				$('#destcount').css('display','block');
				countDest();
			}else{
				$('#destcount').css('display','none');
			}
		});
		
		function showUsage(messagesCount) {
			var x = jQuery('#paget').html()+", "+jQuery('#destcount').html()+"\nSend Message? Duplicate Numbers will be removed";
			return confirm(x);
		}
		function showUsageFree(messagesCount) {
			var x = jQuery('#paget').html()+", "+jQuery('#destcount').html()+"\nSend Message. You are using Free SMS Units and it ll contain an Advert?";
			return confirm(x);
		}
		$('#myForm input').on('change', function() {
		   var oname = ($('input[name="mode"]:checked', '#myForm').val()); 
		   // alert(oname);
		   if (oname =='sms') {
		   		$('#emailbox').css("display","none");
		   		$('#smsbox').css("display","block");
		   }else if(oname =='email'){
		   		$('#smsbox').css("display","none");
		   		$('#emailbox').css("display","block");
		   }
		});
		$('#form-field-select-1').on('change',function () {
			var selectVal = $('#form-field-select-1').val();
			if (selectVal == '4') {
				$('#date-range').css("display","none");
				$('#wallet-range').css("display","block");
			}else{
				$('#date-range').css("display","block");
				$('#wallet-range').css("display","none");
			}
		});
		</script>
		<script type="text/javascript">
	$(function() {
	    var scntDiv = $('#more-xtra');
	    var i = $('#more-xtra div').length + 1;
	    $('#addScnt').on('click', function() {
	    	// alert('ooooo');
	    	console.log(i);
	    	$('#addScnt').html('Add More Date');
	        $('<div id="extr" class="form-group"><label class="col-md-4 control-label">Schedule Date</label><div class="col-md-8"><div class="input-group"><input type="datetime-local" value="2019-11-05T18:18" id="example-input2-group1" name="schedule_date[]" class="form-control" placeholder="Email"><span  id="remScnt"class="input-group-addon"><i class="fa fa-minus"></i></span></div></div></div>').appendTo(scntDiv);
	        i++;
	        return false;
	    });
	    
	    $('#more-xtra').on('click','#remScnt' ,function(e) { 
	    	// alert(i);
	        // if( i > 2 ) {
	        	$('#more-xtra #extr:last').remove();
	            i--;

	        // }
	        e.preventDefault();
	        return false;
	    });
	});

	</script>
                                   <!-- product sales  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- end product sales  -->
                            <!-- ============================================================== -->
                        </div>

                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- sales  -->
                            <!-- ============================================================== -->
                           
                        </div>
                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- total revenue  -->
                   
                        </div>
                        <div class="row">
                          <!-- ============================================================== -->
                            <!-- end sales traffice source  -->
                      
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include('../../inc/footer1.php');?>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="../../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="../../assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="../../assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="../../assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="../../assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="../../assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="../../assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="../../assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="../../assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="../../assets/libs/js/dashboard-ecommerce.js"></script>
</body>
 
</html>