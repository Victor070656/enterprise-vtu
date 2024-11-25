<?php 
session_start();
require('db.php'); 
include('inc/func.php');
include('inc/gravatar.php');
include('inc/logo.php');
include('inc/coinpayments.inc.php');
function fetchFee($conn){
$QrFe = $conn->query("SELECT * FROM charges WHERE service='portalsetup'");
while($ch[] = $QrFe->fetch_assoc()){
}
return json_encode($ch);
}
?> 
<?php include('inc/header.php');?>

        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
      
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
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
                                <h2 class="pageheader-title"><li class="fa fa-hand-holding-usd"></li> <?php echo $_SERVER['SERVER_NAME'];?> Reseller Program </h2>
                        
                            
                        
                            </div>
                        </div>
                    </div>
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
                                    
                          <?php $fe = json_decode(fetchFee($conn),true);?>
                                 
                             <h3 class="card-header">Hey <?php echo $data[0]['lastname']?>, </h3>            
                              <p class="card-header">
                              
                              

<span class="float-right">
 </span>

Do you wish to make N200,000 to N500,000 monthly online on complete autopilot? 
<br>Do you have an existing business and need to add to the hustle for more income?  
<br>Do you own a website and want to earn extra income? 
<br>Join <?php echo $_SERVER['SERVER_NAME'];?> reseller program today and start earning big from a very lucrative VTU business in Nigeria. <br>

Getting Started is very simple;

<ul>
<li>Integrate our API to your website</li>
<li>Setup your own reseller platform like <?php echo $_SERVER['SERVER_NAME'];?> and start reselling highly demanded digital recharge products <br> to your customers and make earning daily.</li>
</ul>
 

<br>


<h3 class="card-header">Benefit of Becoming a Reseller</h3>

<ul>
<li>Zero Convenience fee on bill/services payments </li>
<li>Massive discount on airtime & data purchases</li>
<li>Access to exclusive API for all our services</li>
<li>API Integration support</li>

</ul>

<h3 class="card-header">How to Become a Reseller</h3>

<ul>
<li>Credit your wallet with a minimum of N<?php echo $fe[0]['user'];?></li>
<li>One time non refundable payment of N<?php echo $fe[0]['user'];?> is required for reseller account upgrade.</li>
<li>Reseller Setup is very easy and our team of professionals are always standby to assist.</li>
<li>Once you are fully ready and have funded your account with the required amount, </li>

</ul>


</p>
 
        
                                    <div class="card-body">
                                      
                                    <?php
							
								        
									if(isset($_POST['req'])){
										
										$username = test_input($_SESSION['user']);
										$amount = test_input(floatval(intval(abs($_POST['amount']))));
										$serviceID = test_input($_POST['service']);
										$fname = test_input($_POST['fname']);
										$phone = test_input($_POST['tel']);
										$lname = test_input($_POST['lname']);
										
						if(!empty($amount) && !empty($serviceID)&& !empty($phone) && !empty($lname) ){
										$uid = substr(str_shuffle("0123456789678901"), 0, 16);	
										$_SESSION['amt'] = floatval(intval(abs($amount)));
										$_SESSION['service'] = $serviceID;
										$_SESSION['phone'] = $phone;
										$_SESSION['lname'] = $lname;
										$_SESSION['transid'] = $uid;
										$_SESSION['fname'] = $fname;
										
							
									
											$dat = date("d/m/Y");
											
											$token = uniqid();
											$stat = "pending";
											
										// replace comma
		$str1 = $amount;
        $xamount = str_replace( ',', '', $str1);	
												
										
									
								$qsel = "INSERT INTO transactions(network,phone,ref,refer,amount,email,status,token,customer,del)VALUES('$serviceID','$phone','$uid','$token','$amount','$username','$stat','$token','$fname $lname','Delete')";	
								
								$sav = $conn->query($qsel);
								
			?>
        <script>						
       document.location="transaction-view/upgrade?<?php echo $uid; ?>#transPreview";
          </script>
         <?php 
											
 
			
								
                                	}
                                
                       
                                else{
										echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Please Select Package</strong>  
									</div>'; }
									}
									
									 ?>
                      
           
                   
                                        <label for="inputText3" class="col-form-label">Please Select Reseller Package</label><br>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier"  class="custom-control-input" value="Upgrade + Setup My Reseller Portal" onclick="javascript:showTicket(); vip_value() " id="VIP" ><span class="custom-control-label">Upgrade + Setup My Reseller Portal  </span>
                                            </label>
                                            
                                            
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier" class="custom-control-input"value="Upgrade to Reseller" onclick="javascript:showTicket(); regular_value()" id="Regular"><span class="custom-control-label" >Upgrade to Reseller </span>
                                            </label>
                                            
                                            
                                            
                                       
                                           
                                        <p></p>
                                        <div class="float-center">
                                        <img style="display:none;" id="bigpic" src="bigpic"  width="120" height="90"/>     
                                                   
                                    </div>
                                    
                                   
                                 
                                  <!-- Start VIP hidden -->       
                              <div class="float-center" id="ifVIP" style="display:none;">                 
                                       <div class="form-group" >
                                
		One-time setup fee:
		<h1 class="card-header">&#x20A6;<?php echo number_format($fe[0]['api'],2,'.',',');?></h1>
      </div>
                
                </div>
                <!-- End VIP hidden -->   
                
               
                <!-- Start Regular hidden -->       
                              <div class="float-center" id="ifRegular" style="display:none;">                 
                                       <div class="form-group" >
                                                 
		 One-time Upgrade fee: 
       <h1 class="card-header">&#x20A6;<?php echo number_format($fe[0]['user'],2,'.',',');?></h1>
		
      </div>

              
                                              
                                            
                </div>
                <!-- End Regular hidden -->  
                
                                             
                 <form method="post" action="" >                            
          
                 <input type="hidden" value="" name="fname" id="fname">
		 <input type="hidden" value="" name="service" id="service">
         
         <input type="hidden" value="" name="amount" id="amount">
         
         <input type="hidden" value="" name="lname" id="lname">
         
         <input type="hidden" value="" name="tel" id="tele">
         
                                            
                     <div class="col-sm-6 pl-0">
                           <p class="text-center">
                                                    <button type="submit" name="req" class="btn btn-rounded btn-primary" >Proceed </button>
                           <button class="btn btn-rounded btn-secondary">Cancel</button>                    
                                                </p>                                            
                                            </div>       
                                        </form>
                                        
                                 
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->
                            
                    
                            
<script>

function vip_value()
{
var hidden_field = document.getElementById('amount');
hidden_field.value = '<?php echo $fe[0]['api'];?>';

var hidden_field = document.getElementById('service');
hidden_field.value = 'Upgrade with Portal Setup ';

var hidden_field = document.getElementById('tele');
hidden_field.value = '<?php echo $data[0]['phone'];?>';

var hidden_field = document.getElementById('lname');
hidden_field.value = '<?php echo $data[0]['lastname']?>';

var hidden_field = document.getElementById('fname');
hidden_field.value = '<?php echo $data[0]['firstname']?>';
}

function regular_value()
{
var hidden_field = document.getElementById('amount');
hidden_field.value = '<?php echo $fe[0]['user'];?>';

var hidden_field = document.getElementById('service');
hidden_field.value = 'Reseller Account Upgrade ';

var hidden_field = document.getElementById('tele');
hidden_field.value = '<?php echo $data[0]['phone'];?>';

var hidden_field = document.getElementById('lname');
hidden_field.value = '<?php echo $data[0]['lastname']?>';

var hidden_field = document.getElementById('fname');
hidden_field.value = '<?php echo $data[0]['firstname']?>';
}

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
 
 
 
 function showTicket(){
    if (document.getElementById('VIP').checked) {
        document.getElementById('ifVIP').style.display = 'block';
		
		var sourceOfPicture = "assets/images/limited-time-special-offers.png";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
  
  
 

  
    }else document.getElementById('ifVIP').style.display = 'none';
	
	
	if (document.getElementById('Regular').checked) {
        document.getElementById('ifRegular').style.display = 'block';
		
		var sourceOfPicture = "assets/images/reseller-program.png";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
  
  $('#IsDstv').change(function(){
	  var selected = $(this).find('option:selected');
	  var amount = selected.data('amount');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  });
		
	
		
		}else document.getElementById('ifRegular').style.display = 'none';
	
	
	}



                            </script> 
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- customer acquistion  -->
                            <!-- ============================================================== -->
                             <?php include('inc/sidebar.php'); ?>
                            <!-- ============================================================== -->
                            
                            
                            
                            <!-- end customer acquistion  -->
                      
                        
                            <!-- ============================================================== -->
                            
                            
                            
                            <!-- ============================================================== -->
                        </div>
                        <div class="row">
                          
                        </div>

                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- sales  -->
                         
                            <!-- end new customer  -->
                           
                        </div>
                        <div class="row">
              
                        </div>
                        <div class="row">
                      
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
           <?php include('inc/footer.php');?>