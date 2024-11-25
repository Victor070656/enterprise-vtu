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
                    <!-- ============================================================== --><p></p>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title"><li class="fa fa-book"></li> JAMB ePIN </h2>
                        
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
										$phone = test_input($_POST['telNumber']);
										$iuc = test_input($_POST['iuc']);
										$variation_code = test_input($_POST['variation_code']);
										$type = test_input($_POST['transType']);
										
										
						if(!empty($amount) && !empty($serviceID)&& !empty($phone) && !empty($iuc) ){
						    
						    if(is_numeric($amount)){
								    
								// replace comma
		                    $str1 = floatval($amount);
                            $Filtamount = str_replace( ',', '', $str1);
								    
	                        $xamount = max(0, $Filtamount);
	     
	                        if($xamount == 0){
	                        
	                        echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Invalid Request</strong>  
									</div>'; 
	                               
	                        }else{   
	  
//////// JAMB Verify
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, urlbasemain()."/"."jamb-verify/?");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
    ["apikey" => "$codekey",
    "service" => $serviceID,
    "profilecode" => $phone,
    "vcode" => $variation_code ])); 
 $vry_success = curl_exec($ch);
curl_close($ch);
$resp = json_decode($vry_success);

if($resp->code == 101){
	$uid = substr(str_shuffle("0123456789678901"), 0, 16);
	$_SESSION['amt'] = floatval($xamount);
	$_SESSION['carier'] = $serviceID;
	$_SESSION['phone'] = $phone;
	$_SESSION['iuc'] = $iuc;
	$_SESSION['transid'] = $uid;
	$_SESSION['plan'] = $plan;
	$_SESSION['variation_code'] = $variation_code;
	$_SESSION['type'] = $resp->description->type;
	$_SESSION['surname'] = $resp->description->surname;
	$_SESSION['firstname'] = $resp->description->firstname;
	$_SESSION['middleName'] = $resp->description->middleName;
	$_SESSION['fullName'] = $resp->description->fullName;
	$_SESSION['phoneNumber'] = $resp->description->phoneNumber;
	$_SESSION['profileCode'] = $resp->description->profileCode;
	$dat = date("d/m/Y");
	$token = uniqid();
	$stat = "pending";
	$pnt = $plan;
						
			$qsel = $conn->query("INSERT INTO transactions(network,serviceid,vcode,phone,ref,refer,amount,email,status,token,customer,del)VALUES('$pnt','$serviceID','$variation_code','$phone','$uid','$token','$xamount','$user','$stat','$token','$fname $lname','Delete')");		?>
        <script>						
       window.location="transaction-view/jamb?<?php echo $uid; ?>#transPreview";
          </script>
         <?php 
         
}else{
    
  ?> <div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert">×</button>
										<strong><?php echo $resp->description->message;?></strong>  
									</div><?php  
}
				 }}
                                
						}
                                else{
										echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Enter required fields</strong>  
									</div>'; }
									} }
							
				$jamb = $conn->query("SELECT * FROM exam_package WHERE network='jamb' "); ?>
                      
                                        <label for="inputText3" class="col-form-label">Please Select Service</label><br>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier"  class="custom-control-input" value="JAMB ePIN" onclick="javascript:showTv();" id="smiledata" ><span class="custom-control-label"><img src="assets/images/jamb-small.jpg" ></span>
                                            </label>
                                            
                                        <p></p>
                                        <div class="float-center">
                                        <img style="display:none;" id="bigpic" src="bigpic" width="250" />     
                                                   
                                    </div>
                                    
                                  <!-- Start SmileData hidden -->       
                              <div class="float-center" id="ifData" style="display:none;">                 
                                       <div class="form-group" >
                                          
        <label></label>
		
		<select class="form-control" id="IsData" required="required" >
		  <option  selected hidden disabled >Select ExamType</option>
  
  <?php while($w = $jamb->fetch_assoc()){ ?>        
  <option data-plan="<?php echo $w['plan']; ?>" data-variation_code="<?php echo $w['plancode']; ?>" data-amount="<?php echo $w['price_user']; ?>" data-service="<?php echo $w['network']; ?>" ><?php echo $w['plan']; ?> - <?php echo '&#8358;'.$w['price_user']; ?> </option>
            <?php } ?>
 
                </select>
		
      </div>
                     
              <div class="form-group">
          <label for="inputText3" class="col-form-label">Profile Code</label>
    <input id="pcode" type="number" class="form-control">
                                            </div>             
                                              
                </div>
                <!-- End SmileData hidden -->   
                                    
                 <form method="post" action="" >                            
          
        <input type="hidden" value="" name="plan" id="plan">
		 <input type="hidden" value="" name="service" id="service">
         <input type="number" hidden min="0" oninput="this.value = Math.abs(this.value)" value="" name="amount" id="amount">
         <input type="hidden" value="" name="variation_code" id="variation_code">
         <input type="number" hidden value="" min="0" oninput="this.value = Math.abs(this.value)" name="telNumber" id="tele">
         <input type="hidden" value="1" name="iuc" id="iuc">
         <input type="hidden" value="" name="transType" id="transType">
                                            
                     <div class="col-sm-6 pl-0">
                           <p class="text-center">
                                                    <button type="submit" name="disco" class="btn btn-rounded btn-primary" >Proceed </button>
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
		
		var sourceOfPicture = "assets/images/jamb-epins-nigeria.jpg";
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
	  
	  $('#pcode').on('keyup keydown change', function(){
	      
	   var profilecode = $('#pcode').val().replace(/[^\d]+/g,'');
	  $('#tele').val(profilecode);   
	      
	  });
	  
  
    }else document.getElementById('ifData').style.display = 'none';
	
	
	if (document.getElementById('voice').checked) {
        document.getElementById('ifVoice').style.display = 'block';
		
		var sourceOfPicture = "assets/images/WAEC-Registration.jpg";
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