<?php 
session_start();
require('db.php'); 
include('inc/func.php');
include('inc/gravatar.php');
include('inc/logo.php');
include('inc/coinpayments.inc.php');
 include('inc/header.php');?> 

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
                                <h2 class="pageheader-title"><li class="fa fa-football-ball"></li> Sports Betting Payment </h2>
                        
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
                                          
                                    <h5 class="card-header"></h5>
                                    <div class="card-body">
                                      
                                    <?php
							
							if(isset($_GET['ref'])){
								       echo'<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction successful</strong>  
									</div>'; 
									
									echo '<script>
									setTimeout(function(){ window.location.href="dashboard.php" }, 3000);</script>';
									      
								        }
								        
								
									
									if(isset($_POST['disco'])){
										
										$amount = $conn->real_escape_string(test_input(floatval(intval(abs(floatval($_POST['amount']))))));
										$serviceID = $conn->real_escape_string(test_input($_POST['service']));
										$plan = $conn->real_escape_string(test_input($_POST['plan']));
										$phone = $conn->real_escape_string(test_input($data['phone']));
										$iuc = $conn->real_escape_string(test_input($_POST['iuc']));
										
										$type = $conn->real_escape_string(test_input($_POST['service']));
										
										
						if( !empty($amount) && !empty($serviceID)&& !empty($iuc) ){
										
							
							$uid = substr(str_shuffle("0123456789678901"), 0, 16);
										
										// replace comma
		$str1 = intval($amount);
        $xamount = str_replace( ',', '', $str1);	
												
						if(is_numeric($amount)){				
										
										$_SESSION['amt'] = floatval(abs($xamount));
										$_SESSION['carier'] = $serviceID;
										$_SESSION['phone'] = $phone;
										$_SESSION['iuc'] = $iuc;
										$_SESSION['transid'] = $uid;
										$_SESSION['plan'] = $plan;
										$_SESSION['variation_code'] = $iuc;
										$_SESSION['type'] = $type;
									
											$dat = date("d/m/Y");
											
											$token = uniqid();
											$stat = "pending";
											
										
										
										$pnt = " $serviceID ".$plan."";
										
										
							$cusName = $serviceID;
										
							include('inc/bet9ja-verify.php');			
								
									
					
							if(is_null($result['description']['Customer'])){
								
								echo'<div class="alert alert-warning">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Incorrect Customer ID</strong>
										
									</div>'; 
								
							}else{
								
								
								
							$_SESSION['reference'] = $result['description']['reference'];
							
					$_SESSION['name'] = $result['description']['Customer'];
							
					$_SESSION['accountNumber'] = $result['description']['accountNumber'];
							
							$_SESSION['charge'] = $result['description']['charge'];	
							$Dele = "Delete";
									
							$qsel = $conn->query("INSERT INTO transactions(network,serviceid,vcode,meterno,phone,ref,refer,amount,email,status,token,customer,del,customerName,servicetype)VALUES('$pnt','$serviceID','$variation','$iuc','$phone','$uid','$token','$amount','$user','$stat','$token','$fname $lname','Delete','$cusName','$serviceID')");
								
			
							?>
                              <script>
								
                               window.location="transaction-view/betcollection?<?php echo $uid; ?>#transPreview"; 
                                </script> 
                                <?php 
								
							}
 	                    
						}else{ echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Fraud Alert</strong>  
									</div>';}
 	                    
						}
                                else{
										echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Enter required fields</strong>  
									</div>'; }
									}
									
									 ?>
                      
           
                    <label for="inputText3" class="col-form-label">Please Select Service</label><br>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier"  class="custom-control-input" value="Spectranet" onclick="javascript:showTv(); bet9ja_value();" id="smiledata" ><span class="custom-control-label"><img src="assets/images/bet9ja-small.png" class="rounded-corners" ></span>
                                          </label>
                                          
                                          <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier"  class="custom-control-input" value="1xBet" onclick="javascript:showTv(); xbet_value();" id="ixbet" ><span class="custom-control-label"><img src="assets/images/ixbet.png"class="rounded-corners" ></span>
                                          </label>
                                            
                                       <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier"  class="custom-control-input" value="nairabet" onclick="javascript:showTv(); nairabet_value();" id="nairabet" ><span class="custom-control-label"><img src="assets/images/nairabet.png" class="rounded-corners" ></span>
                                          </label>
                                          
                                        <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier"  class="custom-control-input" value="Betking" onclick="javascript:showTv(); betking_value();" id="betking" ><span class="custom-control-label"><img src="assets/images/betking.png" class="rounded-corners"></span>
                                          </label>  
                                        
                                        <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier"  class="custom-control-input" value="NaijaBet" onclick="javascript:showTv(); naijabet_value();" id="naijabet" ><span class="custom-control-label"><img src="assets/images/naijabet.png" class="rounded-corners"></span>
                                          </label>     
                                            
                                       
                                           
                                        <p></p>
                                        <div class="float-center">
                                        <img style="display:none;" id="bigpic" src="bigpic" class="rounded-corners" />     
                                                   
                                    </div>
                                    
                                   
                                 
                                  <!-- Start Bet9ja hidden -->       
                              <div class="float-center" id="ifData" style="display:none;">                 
                                       <div class="form-group" >
                                          
	
		
      </div>


      
      <div class="form-group">
          <label for="inputText3" class="col-form-label">Customer ID</label>
    <input id="accno" type="text" class="form-control" name="smartno" onKeyUp="javacript:document.getElementById('iuc').value = document.getElementById('accno').value;" onSelect="javacript:document.getElementById('iuc').value = document.getElementById('accno').value;">
                                            </div>
                                            
                                         
                                            
           <div class="form-group">
          <label for="inputText3" class="col-form-label">Amount to pay</label>
    <input id="amtpay" type="number" class="form-control" name="amtpay" onKeyUp="javacript:document.getElementById('amount').value = document.getElementById('amtpay').value;" onSelect="javacript:document.getElementById('amount').value = document.getElementById('amtpay').value;">
                                            </div>          
                             
                                            
                </div>
                <!-- End 1xBet hidden -->   
                
               
     <!-- Start 1xbet hidden -->       
                              <div class="float-center" id="ifixbet" style="display:none;">                 
                                       <div class="form-group" >
                                          
	
		
      </div>


      
      <div class="form-group">
          <label for="inputText3" class="col-form-label">Customer ID</label>
    <input id="xaccno" type="text" class="form-control" name="xsmartno" onKeyUp="javacript:document.getElementById('iuc').value = document.getElementById('xaccno').value;" onSelect="javacript:document.getElementById('iuc').value = document.getElementById('xaccno').value;">
                                            </div>
                                            
                                         
                                            
           <div class="form-group">
          <label for="inputText3" class="col-form-label">Amount to pay</label>
    <input id="xamtpay" type="number" class="form-control" name="xamtpay" onKeyUp="javacript:document.getElementById('amount').value = document.getElementById('xamtpay').value;" onSelect="javacript:document.getElementById('amount').value = document.getElementById('xamtpay').value;">
                                            </div>          
                             
                                            
                </div>
                <!-- End 1xbet hidden -->           
                
       
                   
     <!-- Start Nairabet hidden -->       
                              <div class="float-center" id="ifnairabet" style="display:none;">                 
                                       <div class="form-group" >
                                          
	
		
      </div>


      
      <div class="form-group">
          <label for="inputText3" class="col-form-label">Customer ID</label>
    <input id="naccno" type="text" class="form-control" name="nsmartno" onKeyUp="javacript:document.getElementById('iuc').value = document.getElementById('naccno').value;" onSelect="javacript:document.getElementById('iuc').value = document.getElementById('naccno').value;">
                                            </div>
                                            
                                         
                                            
           <div class="form-group">
          <label for="inputText3" class="col-form-label">Amount to pay</label>
    <input id="namtpay" type="number" class="form-control" name="namtpay" onKeyUp="javacript:document.getElementById('amount').value = document.getElementById('namtpay').value;" onSelect="javacript:document.getElementById('amount').value = document.getElementById('namtpay').value;">
                                            </div>          
                             
                                            
                </div>
                <!-- End Nairabet hidden -->  
                
                   <!-- Start Betking hidden -->       
                              <div class="float-center" id="ifbetking" style="display:none;">                 
                                       <div class="form-group" >
                                
      </div>

      <div class="form-group">
          <label for="inputText3" class="col-form-label">Customer ID</label>
    <input id="kaccno" type="text" class="form-control" name="ksmartno" onKeyUp="javacript:document.getElementById('iuc').value = document.getElementById('kaccno').value;" onSelect="javacript:document.getElementById('iuc').value = document.getElementById('kaccno').value;">
                                            </div>
            <div class="form-group">
          <label for="inputText3" class="col-form-label">Amount to pay</label>
    <input id="kamtpay" type="number" class="form-control" name="kamtpay" onKeyUp="javacript:document.getElementById('amount').value = document.getElementById('kamtpay').value;" onSelect="javacript:document.getElementById('amount').value = document.getElementById('kamtpay').value;">
                                            </div>          
                             
                                            
                </div>
                <!-- End Betking hidden -->
                
           <!-- Start NaijaBet hidden -->       
                              <div class="float-center" id="ifnaijabet" style="display:none;">                 
                                       <div class="form-group" >
                         
      </div>

      <div class="form-group">
          <label for="inputText3" class="col-form-label">Customer ID</label>
    <input id="njaccno" type="text" class="form-control" name="njsmartno" onKeyUp="javacript:document.getElementById('iuc').value = document.getElementById('njaccno').value;" onSelect="javacript:document.getElementById('iuc').value = document.getElementById('njaccno').value;">
        </div>
            <div class="form-group">
          <label for="inputText3" class="col-form-label">Amount to pay</label>
    <input id="njamtpay" type="number" class="form-control" name="njamtpay" onKeyUp="javacript:document.getElementById('amount').value = document.getElementById('njamtpay').value;" onSelect="javacript:document.getElementById('amount').value = document.getElementById('njamtpay').value;">
         </div>          
                             
                                            
                </div>
                <!-- End NaijaBet hidden -->                
                
          <form method="post" action="#" >                            
         <input type="hidden" value="" name="plan" id="plan">
		 <input type="hidden" value="" name="service" id="service">
         
         <input type="number" hidden min="0" oninput="this.value = Math.abs(this.value)" value="" name="amount" id="amount">
         
         <input type="hidden" value="" name="iuc" id="iuc">
         <div class="col-sm-6 pl-0">
          <p class="text-center">
          <button type="submit" name="betmx" class="btn btn-rounded btn-primary"  >Proceed </button>
                           <button class="btn btn-rounded btn-secondary">Cancel</button>                    
                                                </p>                                            
                                            </div>       
                                        </form>
                                        
                                 
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->
                            
                    
                            
<script type="text/javascript">


function bet9ja_value()
{
var hidden_field = document.getElementById('service');
hidden_field.value = 'Bet9ja';

}

function xbet_value()
{
var hidden_field = document.getElementById('service');
hidden_field.value = '1xBet';

}

function nairabet_value()
{
var hidden_field = document.getElementById('service');
hidden_field.value = 'NairaBet';

}

function betking_value()
{
var hidden_field = document.getElementById('service');
hidden_field.value = 'BetKing';

}

function naijabet_value()
{
var hidden_field = document.getElementById('service');
hidden_field.value = 'NaijaBet';

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
 
 
 
 function showTv(){
    if (document.getElementById('smiledata').checked) {
        document.getElementById('ifData').style.display = 'block';
		
		var sourceOfPicture = "assets/images/bet9ja-small.png";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
	
  $('#IsData').change(function(){
	  var selected = $(this).find('option:selected');
	 var amount = selected.data('amount');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	  var variation_code = selected.data('variation_code');
	  
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  $('#variation_code').val(variation_code);
	  
	  }); 
  
    }else document.getElementById('ifData').style.display = 'none';
	
	
	if (document.getElementById('ixbet').checked) {
        document.getElementById('ifixbet').style.display = 'block';
		
		var sourceOfPicture = "assets/images/ixbet.png";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
  
  $('#Isixbet').change(function(){
	  var selected = $(this).find('option:selected');
	  var amount = selected.data('amount');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	  
	 
	  
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  
	  
	  });
		
	
		
		}else document.getElementById('ifixbet').style.display = 'none';
	
	
	
		if (document.getElementById('nairabet').checked) {
        document.getElementById('ifnairabet').style.display = 'block';
		
		var sourceOfPicture = "assets/images/nairabet.png";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
  
  $('#Isnairabet').change(function(){
	  var selected = $(this).find('option:selected');
	  var amount = selected.data('amount');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	  
	 
	  
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  
	  
	  });
		
	
		
		}else document.getElementById('ifnairabet').style.display = 'none';
	
	
	
	if (document.getElementById('betking').checked) {
        document.getElementById('ifbetking').style.display = 'block';
		
		var sourceOfPicture = "assets/images/betking.png";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
  
  $('#Isbetking').change(function(){
	  var selected = $(this).find('option:selected');
	  var amount = selected.data('amount');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	  
	 
	  
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  
	  
	  });
		
	
		
		}else document.getElementById('ifbetking').style.display = 'none';
		
		
		if (document.getElementById('naijabet').checked) {
        document.getElementById('ifnaijabet').style.display = 'block';
		
		var sourceOfPicture = "assets/images/naijabet.png";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
  
  $('#Isnaijabet').change(function(){
	  var selected = $(this).find('option:selected');
	  var amount = selected.data('amount');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	  
	 
	  
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  
	  
	  });
		
	
		
		}else document.getElementById('ifnaijabet').style.display = 'none';
	
	}

                            </script> 
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- customer acquistion  -->
                            <!-- ============================================================== -->
                            <?php include('inc/sidebar.php'); ?>
                            <!-- ============================================================== -->
                            
                            
                            
                            <!-- end customer acquistion  -->
                      <?php include('inc/recent-transaction-widget.php'); ?>
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