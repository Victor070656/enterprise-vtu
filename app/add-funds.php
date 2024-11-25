<?php 
session_start();
require('db.php'); 
include('inc/func.php');
include('inc/gravatar.php');
include('inc/logo.php');
include('inc/coinpayments.inc.php');
include('inc/query_processor.php');

?> 

<?php include('inc/header.php');?>

<style>
    #vfno { display:none;}
</style>
         <?php include('inc/nav.php');?>
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
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title"><li class="fas fa-fw fa-money-bill-alt"></li> Credit Wallet </h2>
                        
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="ecommerce-widget">
<h3>INSTANT WALLET FUNDING</h3>              
                        <div class="alert alert-success"> 
                                 <button type="button" class="close" data-dismiss="alert">×</button>
                                 Make transfer into any of the account number below and your wallet will be credited instantly. <strong>PS:</strong> &#8358;50 bank charges applies. <br><font color="red" >Minimum (&#8358;500) and Maximum(&#8358;500,000). Payment above &#8358;500,000 should be made into our corporate bank account. </font></div>    
                
                    <div class="row">
                         <div class="col-l-3 col-md-3 col-md-3 col-sm-6 col-6">
                            <div class="card">
                                <h5 class="card-header"><img src="assets/minilogo/wema_logo.png" class="responsive"/> </h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h3 class="mb-1"><?php echo json_decode(wema($conn,$email))->accountNumber; ?></h3>
                                    </div>
                                    
                                </div>
                              
                            </div>
                        </div>
                         <div class="col-l-3 col-md-3 col-md-3 col-sm-6 col-6">
                            <div class="card">
                                <h5 class="card-header"><img src="assets/minilogo/sterling_logo.png" class="responsive"/> </h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h3 class="mb-1"><?php echo json_decode(sterling($conn,$email))->accountNumber; ?></h3>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                         <div class="col-l-3 col-md-3 col-md-3 col-sm-6 col-6">
                            <div class="card">
                                <h5 class="card-header"><img src="assets/minilogo/moniepoint_logo.png" class="responsive"/> </h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h3 class="mb-1"><?php echo json_decode(moniepoint($conn,$email))->accountNumber; ?></h3>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>
                        
                        
                        <div class="col-l-3 col-md-3 col-md-3 col-sm-6 col-6">
                            <div class="card">
                                <h5 class="card-header"><img src="assets/minilogo/vpay_logo.jpg" class="responsive"/> </h5>
                                <div class="card-body">
                                    <div class="metric-value d-inline-block">
                                        <h3 class="mb-1"><?php echo json_decode(vfd($conn,$email))->accountNumber; ?></h3>
                                    </div>
                                      
                                    <button id="vfno" class="btn btn-space btn-info">Generate Account</button>
                                    <i id="erro"></i>
                                    
                                </div>
                                
                            </div>
                        </div>
                      
                    </div>
                    
                        <div class="row">
                          
                            <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    
                                    <?php
                                    
                            
				    	$servName = $_SERVER['HTTP_HOST'];
								if($_SERVER['REQUEST_METHOD'] === 'POST'){	
									if(isset($_POST['topup'])){
										
										$username = $_SESSION['user'];
										
										$amount = test_input($_POST['amt']);
										$meth = test_input($_POST['method']);
										
										if(!empty($amount) && !empty($meth) ){
											
											$dat = date("d/m/Y");
									$uid = substr(str_shuffle("0123456789678901"), 0, 16);
											$token = uniqid();
											$stat = "Pending";
											$description = "Wallet Credit";
											$channel = '';
										// replace comma
		
        $filter_amount = str_replace( ',', '', $amount);
        
        $xamount  = floatval(abs($filter_amount));
        
        InsertRecord($conn,$description, $channel, $xamount, $uid,$stat, $username, $token, $custName);
	
		
							$request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);	
								$dola = $xamount/385;
											
if($meth === 'card'){
    
    	$_SESSION['ref'] = $uid;
    	
    	$comm = strval(floatval(1.5 / 100 )* floatval($xamount));
    	
    	$Payable = strval(floatval($xamount) + floatval($comm));

// payprocessor
 if($apib['activepay'] == 'paystack'){
include('inc/paystack.php');
 }else{
	 
include('inc/flutterwave.php');	 
	 }
					
}
if($meth ==='cash'){ 

echo '<div class="card-body border-top">
                                            
                                            <div class="alert alert-primary" role="alert">
                                                <h4 class="alert-heading">PAYMENT DETAILS</h4>
                                                To fund your wallet,
                                                <p>Kindly pay &#x20A6;'.$xamount.' into our bank account below through bank deposit/transfer, online transfer, mobile app transfer etc.</p>
                                                <hr>
                                                <p class="mb-0"><strong>Account Name:</strong> '.$bank['AccName'].' <br>
                                                
                                            <strong>Account Number:</strong> '.$bank['AccNo'].' <br>    
                                               
                                               <strong>Bank Name:</strong> '.$bank['BankName'].' <br> 
                                                </p>
                                                <hr>
                                                <p class="mb-0">After payment is made, send depositor name, amount paid, your  account email to '.$settings['mobile'].' or support@'.$servName.'. <br>
                                                Your wallet will be credited once payment is confirmed. Thank you!
                                            </p>
                                            </div>
                                        </div>';  }	
                                        
                                
                                 if($meth === 'bitcoin'){
                                    
                                    $cps = new CoinPaymentsAPI();
	$cps->Setup(''.$coinsec.'', ''.$coinpub.'');

	$req = array(
		'amount' => $dola,
		'currency1' => 'USD',
		'currency2' => 'BTC',
		'buyer_email' => $email,
		'item_name' => 'Wallet funding',
		'address' => '', // leave blank send to follow your settings on the Coin Settings page
		'ipn_url' => 'https://'.$request_dir.'/buy_credit.php?ref='.$meth.' ',
	);
	// See https://www.coinpayments.net/apidoc-create-transaction for all of the available fields
			
	$result = $cps->CreateTransaction($req);
	if ($result['error'] == 'ok') {
		
		?>
		
		<script>
		
	 window.location="<?php echo' '.$result['result']['status_url'].$le ?>";
	 
	 </script>
	 <?php
		
	} else {
		print 'Error: '.$result['error']."\n";
	}
                                    
                                    
                                }        
                                        
								
                                }	
                                
                       
                                else{
										echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Enter amount</strong>  
									</div>'; }
									} }
									
									
	function InsertRecord($conn,$description, $channel, $xamount, $uid,$stat, $username, $token, $custName){										
	$custName = $fname.' '.$lname;										
	$qsel = "INSERT INTO transactions (network,channel,amount,charge,ref,status,email,refer,token,customer) VALUES('$description','$channel','$xamount','$xamount','$uid','$stat','$username','$token','$token','$custName')";
$sav = $conn->query($qsel);
return $sav;
}


function wema($conn,$email){
    $Qwm = $conn->query("SELECT * FROM auto_funding 
    WHERE bankCode='035' AND id='$email'");
    $wm = $Qwm->fetch_assoc();
    return json_encode($wm);
}
function moniepoint($conn,$email){
    $Qmp = $conn->query("SELECT * FROM auto_funding 
    WHERE bankCode='50515' AND id='$email'");
    $mp = $Qmp->fetch_assoc();
    return json_encode($mp);
}
function sterling($conn,$email){
    $Qster = $conn->query("SELECT * FROM auto_funding 
    WHERE bankCode='232' AND id='$email'");
    $ster = $Qster->fetch_assoc();
    return json_encode($ster);
}

function vfd($conn,$email){
    $Qstervfd = $conn->query("SELECT * FROM auto_funding 
    WHERE bankCode='$email' AND id='$email'");
    $vfd = $Qstervfd->fetch_assoc();
    return json_encode($vfd);
}

function vfdcheck($conn,$email){
    $Checkvfd = $conn->query("SELECT * FROM auto_funding 
    WHERE bankCode='$email' AND id='$email'");
    $fdk = $Checkvfd->num_rows;
    return $fdk;
}

if(vfdcheck($conn,$email) > 0){ 
    ?><script>$("#vfno").css('display','none');</script> <?php
} else{ 
    ?><script>$("#vfno").css('display','block');</script> <?php
    
}
?>     

						
                                    
                                   
                                    <div class="card-body">
                                    
                                        <form method="post" action="">
                                           
                                      <h5>Enter Amount</h5>
                                  <div class="input-group mb-3">
                                                <div class="input-group-prepend"><span class="input-group-text">&#x20A6;</span></div>
                                                <input type="text" class="form-control"onKeyUp="javascript:this.value=Comma(this.value);" name="amt" >
                                                <div class="input-group-append"><span class="input-group-text">.00</span></div>
                                            </div>
                                        
                                        <h5>How do you want to pay?</h5>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" checked name="method"  class="custom-control-input" value="card" onclick="javascript:yesnoCheck();" id="yescard"><span class="custom-control-label">ATM Card</span>
                                            </label>
                                            
                                            
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="method" class="custom-control-input"value="cash" onclick="javascript:yesnoCheck();" id="yescash" ><span class="custom-control-label" >Cash Deposit/Transfer</span>
                                            </label>
                                            
                                         
                                     <div class="col-sm-6 pl-0">
                                         
                                                <p class="text-center">
                                                  
                                          <button type="submit" name="topup" class="btn btn-space btn-info">Proceed</button>
                                                 
                                                
                                                   
                                                </p>
                                                
                                                <p align="center">
                                                    
                                                    <img src="assets/images/paystack-secured.png" class="responsive">
                                                    
                                                     </p>
                                               
                                            </div>       
                                        </form>
                                        
                                       
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
                          
                             <?php include('inc/sidebar.php'); ?>
                           
                         <?php include('inc/recent-transaction-widget.php'); ?>
                            <!-- ============================================================== -->
                        </div>
                        <div class="row">
                          
  	<script type="text/javascript">
  	$("#vfno").click(function(){
var customerEmail = '<?php echo $email; ?>'; 
var customerPhone = '<?php echo $Phone; ?>';
var customerFname = '<?php echo $fname; ?>';
var customerLname = '<?php echo $lname; ?>';

var cusData = {
    email: customerEmail,
    phone:customerPhone,
    fname:customerFname,
    lname:customerLname
    };
        $.ajax({
            type: "GET",
            url: 'formrequest/createvfd.php',
            data: cusData,
            dataType: "json",
            beforeSend: (function(){
                $('#vfno').html('<i class="fa fa-spinner fa-spin"></i> Processing ...');
            }),
            success: function(res){
          if(res.status === true){
             $('#erro').text(res.msg).css('color','green'); 
             setTimeout(()=>{
            window.location.reload();     
             },2000);
          } else {
             $('#erro').text(res.msg).css('color','red');
             $('#vfno').html('Generate account');
              setTimeout(()=>{
            window.location.reload();     
             },5000);
          }     
             
            }
            
        });
  	});

	</script>
                        
                        </div>

                      
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include('inc/footer.php');?>