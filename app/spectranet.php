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
                                <h2 class="pageheader-title"><li class="fa fa-wifi"></li> Spectranet Internet Payment </h2>
                        
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
							if ($_SERVER['REQUEST_METHOD'] === 'POST') {
									if(isset($_POST['disco'])){
										
										$username = test_input($_SESSION['user']);
										$amount = test_input(intval($_POST['amount']));
										$serviceID = test_input($_POST['service']);
										$plan = test_input($_POST['plan']);
										$phone = test_input($_POST['tel']);
										$iuc = test_input($_POST['iuc']);
										
										$type = test_input($_POST['transType']);
										
										
						if(!empty($amount) && !empty($serviceID)&& !empty($iuc) ){
								
								if(is_numeric($amount)){
								    
								// replace comma
		                    $str1 = $amount;
                            $Filtamount = str_replace( ',', '', $str1);
								    
	                        $xamount = max(0, $Filtamount);
	     
	                        if($xamount == 0){
	                        
	                        echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Invalid Request</strong>  
									</div>'; 
	                               
	                        }else{   
	  
	  // process request    		
							
							$uid = substr(str_shuffle("0123456789678901"), 0, 16);
										
										// replace comma
		$str1 = intal($amount);
        $xamount = str_replace( ',', '', $str1);	
												
										
										
										$_SESSION['amt'] = intval($xamount);
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
											
										
										
										$pnt = " Spectranet ".$plan."";
										
										
										
					
				            $cusName = "Spectranet";
									
								$qsel = $conn->query("INSERT INTO transactions(network,serviceid,vcode,meterno,phone,ref,refer,amount,email,status,token,customer,del,customerName,servicetype)VALUES('$pnt','$serviceID','$variation','$iuc','$phone','$uid','$token','$xamount','$user','$stat','$token','$fname $lname','Delete','$cusName','$serviceID')");	
							
			
							?>
                                <script>
								
                                window.location="transaction-view/spectranet?<?php echo $uid; ?>#transPreview";
                                </script>
                                <?php 				
 	                    
						} }}
                                else{
										echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Enter required fields</strong>  
									</div>'; }
									} }
									
									 ?>
                      
           
                   
                                        <label for="inputText3" class="col-form-label">Please Select Service</label><br>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier"  class="custom-control-input" value="Spectranet" onclick="javascript:showTv();" id="smiledata" ><span class="custom-control-label"><img src="assets/images/spectra-small.jpg" ></span>
                                            </label>
                                            
                                            
                                            
                                            
                                       
                                           
                                        <p></p>
                                        <div class="float-center">
                                        <img style="display:none;" id="bigpic" src="bigpic" />     
                                                   
                                    </div>
                                    
                                   
                                 
                                  <!-- Start SmileData hidden -->       
                              <div class="float-center" id="ifData" style="display:none;">                 
                                       <div class="form-group" >
                                          
		 
        <label>Spectranet Internet Bundles</label>
		
		<select class="form-control" id="IsData" required="required" ><option value = "" selected="selected" required="required">Select Data Bundle</option>
                
  <option data-plan="Spectranet - 500 Naira"  data-amount="500" data-service="spectranet" >&#x20A6;500</option>
  
  <option data-plan="Spectranet - 1,000 Naira"  data-amount="1000" data-service="spectranet" >&#x20A6;1,000 </option>
  
  
  <option data-plan="Spectranet - 7,000 Naira"  data-amount="7000" data-service="spectranet" >&#x20A6;7,000 </option>
  

        
  
                
                
                </select>
		
      </div>


      
      <div class="form-group">
          <label for="inputText3" class="col-form-label">Number of Pin</label>
    <input id="qty" type="text" class="form-control">
                                            </div>
                                            
                                              
                </div>
                <!-- End SmileData hidden -->   
                
               
             
                
                 
                
                                                   
                 <form method="post" autocomplete="off" >                            
          
                 <input type="hidden" value="" name="plan" id="plan">
		 <input type="hidden" value="" name="service" id="service">
         
         <input type="number" hidden min="0" oninput="this.value = Math.abs(this.value)" value="" name="amount" id="amount">
         
         <input type="hidden" value="" name="iuc" id="iuc">
         
       
                                            
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
                            
        <script src="js/spec.js"></script>
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