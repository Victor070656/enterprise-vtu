<?php 
session_start();
require('db.php'); 
include('inc/func.php');
include('inc/gravatar.php');
include('inc/logo.php');
include('inc/coinpayments.inc.php');
include('inc/query_processor.php');
include('inc/header.php');
?>

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
                   
                <h3>INSTANT WALLET FUNDING</h3>              
                      
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
                            
                            <div class="pills-regular">
                                <ul class="nav nav-pills mb-1" id="pills-tab" role="tablist">
                                    
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-9psb-tab" data-toggle="pill" href="#pills-9psb" role="tab" aria-controls="9psb" aria-selected="true">9PSB</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-vpay-tab" data-toggle="pill" href="#pills-vpay" role="tab" aria-controls="vpay" aria-selected="true">VFD MFB</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-moniepoint-tab" data-toggle="pill" href="#pills-moniepoint" role="tab" aria-controls="moniepoint" aria-selected="false" >Moniepoint</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-wema-tab" data-toggle="pill" href="#pills-wema" role="tab" aria-controls="wema" aria-selected="false">WEMA</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-sterling-tab" data-toggle="pill" href="#pills-sterling" role="tab" aria-controls="sterling" aria-selected="false" >Sterling Bank</a>
                                    </li>
                                    
                                </ul>
                                
                                <div class="tab-content " id="pills-tabContent">
                                    
                                    
                                    
                                    <div class="tab-pane fade show active" id="pills-9psb" role="tabpanel" aria-labelledby="pills-home-tab">
                                        
                                        
                                            <img src="assets/minilogo/9PSB-logo.png" height="60"/> 
                                <h2 class="py-4 mb-0">
                                    Account Number: <?php echo json_decode(psb($email))->accountNumber; ?> <a href="#" id="psbtn" class="btn btn-rounded btn-brand col-sm-3 pl-0 psbtn">Generate Account No</a>
                                </h2>
            
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        
                                        <h3 class="fw-bold mb-1">Bank Name: <?php echo json_decode(psb($email))->bankName; ?></h3>
                                          
                                     <i id="erro-msg" style="color:red;"></i>
                                        <br>
                                        <div class="text-small text-uppercase fw-bold op-8">Automated Bank Transfer</div>
                                        <p class="text-small ">Make transfer to this account to credit your wallet instantly </p>
                                    </div>
                                    <div class="col-4 pl-0 text-right">   
                                        <h3 class="fw-bold mb-1">&#8358;45</h3> 
                                        <div class="text-small text-uppercase fw-bold op-8">Charge</div>
                                        
                                    </div>
                                </div>   
                                        
                                        
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                    <div class="tab-pane fade " id="pills-vpay" role="tabpanel" aria-labelledby="pills-home-tab">
                                        
                                        
                                            <img src="assets/minilogo/vpay_logo.jpg" height="60"/> 
                                <h2 class="py-4 mb-0">
                                    Account Number: <?php echo json_decode(vfd($conn,$email))->accountNumber; ?> <a href="#" id="vpaybtn" class="btn btn-rounded btn-brand col-sm-3 pl-0">Generate Account No</a>
                                </h2>
            
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        
                                        <h3 class="fw-bold mb-1">Bank Name: <?php echo json_decode(vfd($conn,$email))->bankName; ?></h3>
                                          
                                     <i id="erro"></i>
                                        <br>
                                        <div class="text-small text-uppercase fw-bold op-8">Automated Bank Transfer</div>
                                        <p class="text-small ">Make transfer to this account to credit your wallet instantly </p>
                                    </div>
                                    <div class="col-4 pl-0 text-right">   
                                        <h3 class="fw-bold mb-1">&#8358;45</h3> 
                                        <div class="text-small text-uppercase fw-bold op-8">Charge</div>
                                        
                                    </div>
                                </div>   
                                        
                                        
                                    </div>
                                    
                                    
                                    <div class="tab-pane fade" id="pills-moniepoint" role="tabpanel" aria-labelledby="pills-profile-tab">
                                       
                                            
                                           <img src="assets/minilogo/moniepoint_logo.png" height="60"/> 
                                <h2 class="py-4 mb-0">
                                    Account Number: <?php echo json_decode(moniepoint($conn,$email))->accountNumber; ?>
                                </h2>
            
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        
                                        <h3 class="fw-bold mb-1">Bank Name: Moniepoint Microfinance Bank</h3>
                                        <br>
                                        <div class="text-small text-uppercase fw-bold op-8">Automated Bank Transfer</div>
                                        <p class="text-small ">Make transfer to this account to credit your wallet instantly </p>
                                    </div>
                                    <div class="col-4 pl-0 text-right">
                                        <h3 class="fw-bold mb-1">&#8358;50</h3>
                                        <div class="text-small text-uppercase fw-bold op-8">Charge</div>
                                    </div>
                                </div>       
                                            
                                            
                                    </div>
                                    
                                    <div class="tab-pane fade" id="pills-wema" role="tabpanel" aria-labelledby="pills-contact-tab">
                                        
                                       <img src="assets/minilogo/wema_logo.png" height="60"/> 
                                <h2 class="py-4 mb-0">
                                    Account Number: <?php echo json_decode(wema($conn,$email))->accountNumber; ?>
                                </h2>
            
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        
                                        <h3 class="fw-bold mb-1">Bank Name: WEMA Bank</h3>
                                        <br>
                                        <div class="text-small text-uppercase fw-bold op-8">Automated Bank Transfer</div>
                                        <p class="text-small ">Make transfer to this account to credit your wallet instantly </p>
                                    </div>
                                    <div class="col-4 pl-0 text-right">
                                        <h3 class="fw-bold mb-1">&#8358;50</h3>
                                        <div class="text-small text-uppercase fw-bold op-8">Charge</div>
                                    </div>
                                </div>            
                                            
                                            
                                            
                                    </div>
                                    
                                    <div class="tab-pane fade " id="pills-sterling" role="tabpanel" aria-labelledby="sterling-tab">
                                       
                                            <img src="assets/minilogo/sterling_logo.png" height="60"/> 
                                <h2 class="py-4 mb-0">
                                    Account Number: <?php echo json_decode(sterling($conn,$email))->accountNumber; ?>
                                </h2>
            
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        
                                        <h3 class="fw-bold mb-1">Bank Name: Sterling Bank</h3>
                                        <br>
                                        <div class="text-small text-uppercase fw-bold op-8">Automated Bank Transfer</div>
                                        <p class="text-small ">Make transfer to this account to credit your wallet instantly </p>
                                    </div>
                                    <div class="col-4 pl-0 text-right">
                                        <h3 class="fw-bold mb-1">&#8358;50</h3>
                                        <div class="text-small text-uppercase fw-bold op-8">Charge</div>
                                    </div>
                                </div>          
                                
                                    </div>
                                    
                                    <div class="tab-pane fade " id="pills-gtb" role="tabpanel" aria-labelledby="gtb-tab">
                                       <img src="assets/minilogo/gtbank_logo.png" height="60"/> 
                                <h2 class="py-4 mb-0">
                                    Account Number:  <a href="#" id="gtbtn" class="btn btn-rounded btn-brand col-sm-3 pl-0">Generate Account No</a>
                                </h2>
                                <i id="erro-g"></i>
                                <div class="row">
                                    <div class="col-8 pr-0">
                                        
                                        <h3 class="fw-bold mb-1">Bank Name: GTBank</h3>
                                          
                                     <i id="erro-g"></i>
                                        <br>
                                        <div class="text-small text-uppercase fw-bold op-8">Automated Bank Transfer</div>
                                        <p class="text-small ">Make transfer to this account to credit your wallet instantly </p>
                                    </div>
                                    <div class="col-4 pl-0 text-right">
                                        <h3 class="fw-bold mb-1">&#8358;50</h3>
                                        <div class="text-small text-uppercase fw-bold op-8">Charge</div>
                                    </div>
                                </div>
                                        
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


function psbcheck($email){
    global $conn;
    $Checkpsb = $conn->query("SELECT * FROM auto_funding 
    WHERE bankCode='120001' AND id='$email'");
    $respsb = $Checkpsb->num_rows;
    return $respsb;
}

function psb($email){
    global $conn;
    $Qsterpsb = $conn->query("SELECT * FROM auto_funding 
    WHERE bankCode='120001' AND id='$email'");
    $psb = $Qsterpsb->fetch_assoc();
    return json_encode($psb);
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
  	
  	
  
  
  
   var accountCheck = "<?php echo vfdcheck($conn,$email); ?>";
   if(accountCheck == 0){
      $("#vpaybtn").css('display','block'); 
   } else {
    $("#vpaybtn").css('display','none');    
   }
$("#vpaybtn").click(function(){
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
            type: "POST",
            url: 'formrequest/createvfd.php',
            data: cusData,
            dataType: "json",
            beforeSend: (function(){
                $('#vpaybtn').html('<i class="fa fa-spinner fa-spin"></i> Processing ...');
            }),
            success: function(cred){
          if(cred.status === true){
             $('#erro').text(cred.msg).css('color','green'); 
             $('#vpaybtn').html(cred.msg);
             setTimeout(()=>{
            window.location.reload();     
             },2000);
          } else {
             $('#erro').text(cred.msg).css('color','red');
             $('#vpaybtn').html('Generate account No');
              setTimeout(()=>{
            window.location.reload();     
             },3000);
          }     
             
            }
            
        });
  	});	
  	
  	
  	
  	
  	
 ///Generate PSB Account

var PsbCheck = '<?php echo psbcheck($email); ?>';
   if(PsbCheck === "" || PsbCheck == 0 ){
      $(".psbtn").css("display","inline"); 
   } else {
    $(".psbtn").css('display','none');    
   }
   
$(".psbtn").click(function(){
var psEmail = '<?php echo $email; ?>';
var psName = '<?php echo $fname; ?>';
var psPhone = '<?php echo $Phone; ?>';
var PSBData = {email:psEmail,name:psName,phoneNumber:psPhone};

        $.ajax({
            url: 'formrequest/createpsb.php',
            type: 'POST',
            data: JSON.stringify(PSBData),
            dataType: "json",
           beforeSend: function(){
                $('.psbtn').html('<i class="fa fa-spinner fa-spin"></i> Processing ...');
            },
            success: function(psresponse){
                
          if(psresponse.status === true){
             $('.psbtn').html(''+psresponse.msg+'');
             setTimeout(()=>{
            window.location.reload();     
             },3000);
          } else {
             $('#erro-msg').html(''+psresponse.msg+'');
             $('.psbtn').html('Generate account');
          
          }     
             
            }
            
        });
  	});


// Generator PSB end 	
  	 	
  	
  	
  	

	</script>
                        
                        </div>

                      
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== 
            -->
            
            
             <!-- Modal -->
   <div class="modal fade" id="accountUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                     <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Customer KYC Update</h5>
                                                                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </a>
                                                            </div>
                                         <div class="modal-body">
                                             
                                     <form method="POST" action="javascript:void(0)" id="frmbvn">
                                   
                               <div class="alert alert-info alert-dismissible fade show" role="alert">
           Dear <strong> <?php echo $fname.' '.$lname;?></strong>, <p> The Central Bank of Nigeria released a circular recently mandating every <strong>virtual accounts</strong> to be linked with either a Bank Verification Number (BVN) or National Identification Number (NIN) of the beneficiary. All accounts not updated accordingly by <strong>January 31st, 2024 </strong> would be deactivated and payments to such accounts would be rejected.
           </p>
           <p>Kindly update your BVN below for hitch free transaction on your dedicated accounts.</p>
           
           <p>
          <code>     
               <font color="red" > <strong>Disclaimer:</strong>  This is for verification purpose only as required by Central Bank of Nigeria (CBN) for the issuance and management of virtual accounts. We will never store your BVN in any means.  </font> 
               </code>
           </p>
           
           <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></a>
            </div>     
                                         
        <div class="row justify-content-center">
                                        
                
  <div class="col-12">
 <label><li class="fa fa-money"></li>  </label>
    <input type="number" id="idno"  class="form-control" placeholder="Enter Your Bank Verification Number (BVN)" >
 </div>

<div class="col-4">
    <p></p>
       <button type="submit" id="btnvfy" class="btn btn-primary solid rounded"><li class="fa fa-user"></li> Update </button> 
       <span id="sh"></span>
     </div>
     
 </div>   
                                        
         </div>     
                                         
         </form>                         


															
	<script type="text/javascript">
	
	$(document).ready(function(){

$(window).on('load', function() {

$.ajax({ 
type: 'POST',
	   url: 'formrequest/bvn_status.php',
	   data: JSON.stringify({id:'<?php echo $email; ?>'}),
	   datatype: 'json',
	   cache: false,
	   success: function(vfy) { 
	      //console.log(vfy);
	        
	 if(vfy.status !== true || vfy.msg[0] === 'inactive' || vfy.msg[0] === 'none'){
	$('#accountUpdate').modal('show');     
	 } 
	 
	   }    
    
});

});	    
	    
	$('#frmbvn').submit(function(e){
	 e.preventDefault();
	 var idNumber = $('#idno').val();
	 if(idNumber == ''){
	   $('#idno').notify('Enter your BVN ',{position: 'top left'},'error');
	   $('#idno').focus();
	   return false;
	 }
	 $.ajax({
	   type: 'POST',
	   url: 'formrequest/link_bvn.php',
	   data: JSON.stringify({tok:'<?php echo $accountID; ?>',IdNumber:idNumber,eid:'<?php echo $email; ?>'}),
	   datatype: 'json',
	   cache: false,
	   beforeSend: function(){
	    $('#btnvfy').html('Please wait...');   
	   },
	   success: function(response) {
	      
	   if(response.status === true){
	       
	    $('#idno').notify(''+response.msg+'',"success"); 
	    
	   $('#btnvfy').html('<div><i class="fa fa-check-alt"></i> Verified </div>'); 
	   setTimeout(()=>{
	   $('#accountUpdate').modal('hide');    
	   },5000);
	   
	   } else {
	    
	   
	   $('#idno').notify(''+response.msg+'',{position: 'top left'},'error'); 
	    
	   $('#btnvfy').html('<div><i class="fa fa-exchange-alt"></i> Proceed </div>');      
	   }
	   }
	 });
	});
	});
	     
	</script>															
															
                                                            </div>
                                                            <div class="modal-footer">
                                                                
                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                            <!-- ============================================================== -->      
            
            
            
            <?php include('inc/footer.php');?>