<?php 
session_start();
require('db.php'); 
include('inc/func.php');
include('inc/gravatar.php');
include('inc/logo.php');
include('inc/coinpayments.inc.php');
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
                                <h2 class="pageheader-title"><li class="fa fa-wifi"></li> Smile Internet Payment </h2>
                        
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
							
						
								if($_SERVER['REQUEST_METHOD'] === 'POST'){	
									if(isset($_POST['disco'])){
										
										$username = test_input($_SESSION['user']);
										$amount = test_input(intval($_POST['amount']));
										$serviceID = test_input($_POST['service']);
										$plan = test_input($_POST['plan']);
										$phone = test_input($_POST['tel']);
										$iuc = test_input($_POST['iuc']);
										$variation_code = test_input($_POST['variation_code']);
										$type = test_input($_POST['transType']);
										
										
						if(!empty($amount) && !empty($serviceID)&& !empty($phone) && !empty($iuc) ){
										$uid = substr(str_shuffle("0123456789678901"), 0, 16);
										
										// replace comma
		$str1 = intval($amount);
        $xamount = str_replace( ',', '', $str1);	
												
										
										
										$_SESSION['amt'] = floatval($xamount);
										$_SESSION['carier'] = $serviceID;
										$_SESSION['phone'] = $phone;
										$_SESSION['iuc'] = $iuc;
										$_SESSION['transid'] = $uid;
										$_SESSION['plan'] = $plan;
										$_SESSION['variation_code'] = $variation_code;
										$_SESSION['type'] = $type;
									
											$dat = date("d/m/Y");
											
											$token = uniqid();
											$stat = "pending";
											
										
										
										$pnt = " Smile ".$plan."";
										
						if($type === 'voice'){
						
						$_SESSION['customer'] = $result->description->Customer;	
							?>
                            <script>
           window.location="transaction-view/paytv?<?php echo $uid; ?>#transPreview";
                            </script>
                            <?php
							}else{				
										
										
include('inc/verify.php');


					
		if(is_null($result->description->Customer)){
			
			echo'<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Invalid Smile Account Number</strong>  
									</div>'; 
			
			}	else{		
					
									
								$qsel = "INSERT INTO transactions(network,serviceid,vcode,meterno,phone,ref,refer,amount,email,status,token,customer,del)VALUES('$pnt','$service','$variation','$iuc','$phone','$uid','$token','$amount','$username','$stat','$token','$fname $lname','Delete')";	
								
								$sav = $conn->query($qsel);
								
			?>
        <script>						
       window.location="transaction-view/paytv?<?php echo $uid; ?>#transPreview";
          </script>
         <?php 
											
 
			$_SESSION['customer'] = $result->description->Customer;
								
                                }	}
                                
						}
                                else{
										echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Enter required fields</strong>  
									</div>'; }
									}
								}
									 ?>
                      
           
                   
                                        <label for="inputText3" class="col-form-label">Please Select Smile Service</label><br>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier"  class="custom-control-input" value="SmileData" onclick="javascript:showTv();" id="smiledata" ><span class="custom-control-label"><img src="assets/images/smiledata.png" ></span>
                                            </label>
                                            
                                            
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier" class="custom-control-input"value="voice" onclick="javascript:showTv();" id="voice"><span class="custom-control-label" ><img src="assets/images/smilevoice.png" ></span>
                                            </label>
                                           
                                            
                                       
                                           
                                        <p></p>
                                        <div class="float-center">
                                        <img style="display:none;" id="bigpic" src="bigpic" />     
                                                   
                                    </div>
                                    
                                   
                                 
                                  <!-- Start SmileData hidden -->       
                              <div class="float-center" id="ifData" style="display:none;">                 
                                       <div class="form-group" >
                                          
		 
        <label>Smile Internet Bundles</label>
		
		<select class="form-control" id="IsData" required="required" ><option value = "" selected="selected" required="required">Select Data Bundle</option>
                
  <option data-plan="2GB MidNite for 7days - 1,020 Naira" data-variation_code="413" data-amount="1020" data-service="smile-direct" >2GB MidNite for 7days - &#x20A6;1020</option>
  
  <option data-plan="3GB MidNite for 7days - 1,530 Naira" data-variation_code="414" data-amount="1530" data-service="smile-direct" >3GB MidNite for 7days - &#x20A6;1,530 </option>
  
  
  <option data-plan="3GB Weekend ONLY for 3days - 1,530 Naira" data-variation_code="415" data-amount="1530" data-service="smile-direct" >3GB Weekend ONLY for 3days - &#x20A6;1,530 </option>
  
	
    <option data-plan="UnlimitedPlatinum for 30days - 24,000 Naira" data-variation_code="583" data-amount="24000" data-service="smile-direct" >UnlimitedPlatinum for 30days - &#x20A6;24,000 </option>			
                
             
         <option data-plan="1GB Flexi for 1days - 300 Naira" data-variation_code="624" data-amount="300" data-service="smile-direct" >1GB Flexi for 1days - &#x20A6;300</option>	
         
         
         
        <option data-plan="2.5GB Flexi for 2days - 500 Naira" data-variation_code="625" data-amount="500" data-service="smile-direct" >2.5GB Flexi for 2days - &#x20A6;500 </option> 
         
         <option data-plan="1GB Flexi-Weekly for 7days - 500 Naira" data-variation_code="626" data-amount="500" data-service="smile-direct" >1GB Flexi-Weekly for 7days - &#x20A6;500</option>
         
         
        <option data-plan="1.5GB Bigga for 30days - 1,000 Naira" data-variation_code="606" data-amount="1000" data-service="smile-direct" >1.5GB Bigga for 30days - &#x20A6;1,000 </option> 
        
        
        <option data-plan="2GB Flexi-Weekly  for 7days - 1,000 Naira" data-variation_code="627" data-amount="1000" data-service="smile-direct" >2GB Flexi-Weekly  for 7days - &#x20A6;1,000 </option>
        
        <option data-plan="2GB Bigga for 30days - 1,200 Naira" data-variation_code="607" data-amount="1200" data-service="smile-direct" >2GB Bigga for 30days - &#x20A6;1,200 </option> 
        
        <option data-plan="3GB Bigga for 30days - 1,500 Naira" data-variation_code="608" data-amount="1500" data-service="smile-direct" >3GB Bigga for 30days - &#x20A6;1,500</option>
        
         
         <option data-plan="6GB Flexi-Weekly  for 7days - 1,500 Naira" data-variation_code="628" data-amount="1500" data-service="smile-direct" >6GB Flexi-Weekly  for 7days - &#x20A6;1,500 </option>
         
     <option data-plan="5GB Bigga for 30days - 2,000 Naira" data-variation_code="620" data-amount="2000" data-service="smile-direct" >5GB Bigga for 30days - &#x20A6;2,000 </option>    
         
         <option data-plan="6.5GB Bigga for 30days - 2,500 Naira" data-variation_code="609" data-amount="2500" data-service="smile-direct" >6.5GB Bigga for 30days - &#x20A6;2,500 </option>  
         
          <option data-plan="8GB Bigga for 30days - 3,000 Naira" data-variation_code="610" data-amount="3000" data-service="smile-direct" >8GB Bigga for 30days - &#x20A6;3,000 </option>  
                
          <option data-plan="10GB Bigga for 30days - 3,500 Naira" data-variation_code="611" data-amount="3500" data-service="smile-direct" >10GB Bigga for 30days - &#x20A6;3,500 </option>         
                
                <option data-plan="12GB Bigga for 30days - 4,000 Naira" data-variation_code="612" data-amount="4000" data-service="smile-direct" >12GB Bigga for 30days - &#x20A6;4,000 </option>    
                
  <option data-plan="15GB Bigga for 30days - 5,000 Naira" data-variation_code="613" data-amount="5000" data-service="smile-direct" >15GB Bigga for 30days - &#x20A6;5,000 </option>
  
  
  <option data-plan="20GB Bigga for 30days - 6,000 Naira" data-variation_code="614" data-amount="6000" data-service="smile-direct" >20GB Bigga for 30days - &#x20A6;6,000 </option>
  
  
  <option data-plan="15GB-Anytime for 365days - 8,000 Naira" data-variation_code="601" data-amount="8000" data-service="smile-direct" >15GB-Anytime for 365days - &#x20A6;8,000</option>
  
  
  <option data-plan="30GB Bigga for 30days - 8,000 Naira" data-variation_code="615" data-amount="8000" data-service="smile-direct" >30GB Bigga for 30days - &#x20A6;8,000 </option>                  
  
   <option data-plan="40GB Bigga for 30days - 10,000 Naira" data-variation_code="616" data-amount="10000" data-service="smile-direct" >40GB Bigga for 30days - &#x20A6;10,000 </option>              
   
   <option data-plan="Unlimited-Lite for 30days - 10,000 Naira" data-variation_code="629" data-amount="10000" data-service="smile-direct" >Unlimited-Lite for 30days - &#x20A6;10,000 </option>
   
   
   
   
    <option data-plan="60GB Bigga for 30days - 13,500 Naira" data-variation_code="617" data-amount="13500" data-service="smile-direct" >60GB Bigga for 30days - &#x20A6;13,500 </option>
    
    
     <option data-plan="75GB Bigga for 30days - 15,000 Naira" data-variation_code="618" data-amount="15000" data-service="smile-direct" >75GB Bigga for 30days - &#x20A6;15,000 </option>
     
         <option data-plan="50GB Bumpa-Value  for 60days - 15,000 Naira" data-variation_code="621" data-amount="15000" data-service="smile-direct" >50GB Bumpa-Value  for 60days - &#x20A6;15,000 </option>
         
         
         <option data-plan="Unlimited-Essential for 30days - 15,000 

Naira" data-variation_code="630" data-amount="15000" data-service="smile-direct" >Unlimited-Essential for 30days - &#x20A6;15,000 </option>



<option data-plan="35GB-Anytime  for 365days - 16,000 Naira" data-variation_code="602" data-amount="16000" data-service="smile-direct" >35GB-Anytime  for 365days - &#x20A6;16,000 </option>


<option data-plan="100GB Bigga for 30days - 18,000 Naira" data-variation_code="619" data-amount="18000" data-service="smile-direct" >100GB Bigga for 30days - &#x20A6;18,000 </option>



<option data-plan="UnlimitedPremium for 30days - 20,000 Naira" data-variation_code="655" data-amount="20000" data-service="smile-direct" >UnlimitedPremium for 30days - &#x20A6;20,000 </option>



<option data-plan="80GB Bumpa-Value  for 90days - 30,000 Naira" data-variation_code="622" data-amount="30000" data-service="smile-direct" >80GB Bumpa-Value  for 90days - &#x20A6;30,000 </option>



<option data-plan="90GB-Anytime   for 365days - 36,000 Naira" data-variation_code="603" data-amount="36000" data-service="smile-direct" >90GB-Anytime   for 365days - &#x20A6;36,000 </option>


<option data-plan="100GB Bumpa-Value  for 120days - 40,000 Naira" data-variation_code="623" data-amount="40000" data-service="smile-direct" >100GB Bumpa-Value  for 120days - &#x20A6;40,000 </option>


<option data-plan="200GB-Anytime   for 365days - 70,000 Naira" data-variation_code="604" data-amount="70000" data-service="smile-direct" >200GB-Anytime   for 365days - &#x20A6;70,000 </option>


<option data-plan="400GB-Anytime  for 365days - 120,000 Naira" data-variation_code="605" data-amount="120000" data-service="smile-direct" >400GB-Anytime  for 365days - &#x20A6;120,000 </option>
                
                
                </select>
		
      </div>


      
      <div class="form-group">
          <label for="inputText3" class="col-form-label">Smile Account Number</label>
    <input id="accno" type="text" class="form-control" name="smartno" onKeyUp="javacript:document.getElementById('iuc').value = document.getElementById('accno').value;" onSelect="javacript:document.getElementById('iuc').value = document.getElementById('accno').value;">
                                            </div>
                                            
                                         
                                            
              <div class="form-group">
          <label for="inputText3" class="col-form-label">Phone Number</label>
    <input id="mobile" type="phone" class="form-control" name="phone" onKeyUp="javascript:document.getElementById('tele').value = document.getElementById('mobile').value;" onSelect="javascript:document.getElementById('tele').value = document.getElementById('mobile').value;">
                                            </div>             
                             
                                            
                </div>
                <!-- End SmileData hidden -->   
                
               
                <!-- Start SmileVoice hidden -->       
                              <div class="float-center" id="ifVoice" style="display:none;">                 
                                       <div class="form-group" >
                                                 
		 
        <label>Smile Voice Package</label>
		
		<select class="form-control" id="IsVoice" required="required" ><option value = "" selected="selected" required="required">Select Voice Package</option>
                 
                 <option data-plan="Smile Voice - 65mins" data-variation_code="516" data-amount="500" data-service="smile-direct" data-trans="voice" >Smile Voice - 65mins - &#x20A6;500 </option>
  
  
  <option data-plan="Voice 135mins" data-variation_code="517" data-amount="1020" data-service="smile-direct" data-trans="voice" >Voice 135mins for 30days - &#x20A6;1,020</option>                  
  
   <option data-plan="Voice 430mins" data-variation_code="518" data-amount="3070" data-service="smile-direct" data-trans="voice" >Voice 430mins - &#x20A6;3,070 - 30 days</option>              
   
   
                
                </select>
	
      </div>


                                            
                                          
                                            
              <div class="form-group">
          <label for="inputText3" class="col-form-label">Smile Voice Number</label>
    <input id="phone" type="phone" class="form-control" name="phone" onKeyUp="javascript:document.getElementById('tele').value = document.getElementById('phone').value; document.getElementById('iuc').value = document.getElementById('phone').value" onSelect="javascript:document.getElementById('tele').value = document.getElementById('phone').value; document.getElementById('iuc').value = document.getElementById('phone').value">
                                            </div>                
                                              
                                            
                </div>
                <!-- End SmileVoice hidden -->  
                
                 
                
                                                   
                 <form method="post" action="" >                            
          
                 <input type="hidden" value="" name="plan" id="plan">
		 <input type="hidden" value="" name="service" id="service">
         
         <input type="hidden" value="" name="amount" id="amount">
         
         <input type="hidden" value="" name="variation_code" id="variation_code">
         
         <input type="hidden" value="" name="tel" id="tele">
         
         <input type="hidden" value="" name="iuc" id="iuc">
         
         <input type="hidden" value="" name="transType" id="transType">
                                            
                     <div class="col-sm-6 pl-0">
                           <p class="text-center">
                                                    <button type="submit" name="disco" class="btn btn-rounded btn-primary" onClick="alert('We will validate your smile account ID to be sure everything looks good')" >Proceed </button>
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
		
		var sourceOfPicture = "assets/images/smile-data.jpg";
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
	
	
	if (document.getElementById('voice').checked) {
        document.getElementById('ifVoice').style.display = 'block';
		
		var sourceOfPicture = "assets/images/smile-voice.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
  
  $('#IsVoice').change(function(){
	  var selected = $(this).find('option:selected');
	  var amount = selected.data('amount');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	  var variation_code = selected.data('variation_code');
	  var trans = selected.data('trans');
	  
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  $('#variation_code').val(variation_code);
	  $('#transType').val(trans);
	  });
		
	
		
		}else document.getElementById('ifVoice').style.display = 'none';
	
	
	
	
	
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