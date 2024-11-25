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
                                <h2 class="pageheader-title"><li class="fa fa-wifi"></li>  DATA CARD </h2>
                        
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
							
									if(isset($_POST['DataCheck'])){
										
									$username = test_input($_SESSION['user']);
									$amount = test_input(floatval($_POST['amount']));
									$network = test_input($_POST['service']);
										$Dataplan = test_input($_POST['plan']);
										$phone = test_input($_POST['tel']);
										$variation = test_input($_POST['variation_code']);
										$CardName = test_input($_POST['cname']);
										
						if(!empty($amount) && !empty($network)&& !empty($phone) ){
										$uid = substr(str_shuffle("0123456789678901"), 0, 16);
										
					if($network = '01'){$telc = "mtn"; $img = "Data-mtn.jpg"; }else
					if($network = '02'){$telc = "glo"; $img = "GLO-Data.jpg"; }else
			if($network = '03'){$telc = "9mobile"; $img = "9mobile-Data.jpg"; }else
			if($network = '04'){$telc = "airtel"; $img = "Airtel-Data.jpg"; }
			
				$valu = strtoupper($telc).' DATA CARD '. $Dataplan;
				
									
										$_SESSION['amt'] = floatval(abs($amount));
										$_SESSION['carier'] = $network;
										$_SESSION['phone'] = $phone;
										$_SESSION['label'] = $valu;
										$_SESSION['transid'] = $uid;
										$_SESSION['plan'] = $Dataplan;
										$_SESSION['variation_code'] = $variation;
										$_SESSION['img'] = $img;
									
											$dat = date("d/m/Y");
											
											$token = uniqid();
											$stat = "pending";
											
										
		
		
		insertRecord($conn,$valu,$network,$CardName,$phone,$uid,$token,$amount,$username,$stat,$fname,$lname);
									
			?>
        <script>						
       window.location="transaction-view/datacard?<?php echo $uid; ?>#transPreview";
          </script>
         <?php 
											
 
                                }	
                                
                       
                                else{
										echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Enter required fields</strong>  
									</div>'; }
									}
									
									
						$query_rec = mysqli_query($conn,"SELECT * FROM sme_data"); $sme = mysqli_fetch_array($query_rec);
						
						$sme1g = $sme['mtndatacard'];
						$cg1g = $sme['mg1'];
				$query_MapiS = mysqli_query($conn,"SELECT * FROM api_setting");
			
                $apiMulti = mysqli_fetch_array($query_MapiS);
                
                $mtn = $conn->query("SELECT * FROM data_package WHERE network='01' AND datatype='datacard'");
                $airtel = $conn->query("SELECT * FROM data_package WHERE network='04' AND datatype='datacard'");
                $glo = $conn->query("SELECT * FROM data_package WHERE network='02' AND datatype='datacard'");
                $etisalat = $conn->query("SELECT * FROM data_package WHERE network='03' AND datatype='datacard'");
                
                
                function insertRecord($conn,$valu,$network,$CardName,$phone,$uid,$token,$xamount,$username,$stat,$fname,$lname){	
								$qsel = $conn->query("INSERT INTO transactions(network,serviceid,vcode,phone,ref,refer,amount,email,status,token,customer)VALUES('$valu','$network','$CardName','$phone','$uid','$token','$xamount','$username','$stat','$token','$fname $lname')");
								    return $qsel;
						            }
									 ?>
                      
           
                   
                                        <label for="inputText3" class="col-form-label">Please Network To Recharge</label><br>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier"  class="custom-control-input" value="mtn-data" onclick="javascript:showTv();" id="gotv" ><span class="custom-control-label"><img src="assets/images/mtn.jpg" width="35" height="30"></span>
                                            </label>
                                            
                                            
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier" class="custom-control-input"value="airtel-data" onclick="javascript:showTv();" id="dstv"><span class="custom-control-label" ><img src="assets/images/airtel.jpg" width="35" height="30"></span>
                                            </label>
                                            
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier" class="custom-control-input"value="glo-data" onclick="javascript:showTv();" id="startimes"><span class="custom-control-label" ><img src="assets/images/glo.jpg" width="35" height="30"></span>
                                            </label>
                                            
                                            
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="carier" class="custom-control-input"value="etisalat-data" onclick="javascript:showTv();" id="9mobile"><span class="custom-control-label" ><img src="assets/images/9mobile.jpg" width="35" height="30"></span>
                                            </label>
                                            
                                            
                                            
                                       
                                           
                                        <p></p>
                                        <div class="float-center">
                                        <img style="display:none;" id="bigpic" src="bigpic"  width="120" height="90"/>     
                                                   
                                    </div>
                                    
                                   
                                 
                                  <!-- Start GOTV hidden -->       
                              <div class="float-center" id="ifGotv" style="display:none;">                 
                                       <div class="form-group" >
                                          
		 
        <label>Select Bundle:</label>
		
		<select class="form-control" id="IsGotv" required="required" >
		   <option  disabled selected hidden>Select Data Plan</option>
		
			<?php while($m = $mtn->fetch_assoc()){ ?>
		        <option data-plan="<?php echo $m['plan']; ?>" data-variation_code="<?php echo $m['plancode']; ?>" data-amount="<?php echo $m['price_user'];?>" data-service="<?php echo $m['network']; ?>" ><?php echo $m['plan'].' - '.'30 days'.' - '.'&#x20A6;'.$m['price_user'];?> </option>
		        
		        <?php } ?>
                
                </select>
		
      </div>

                
              <div class="form-group">
          <label for="inputText3" class="col-form-label">Quantity</label>
    <input id="mobile" type="phone" class="form-control" name="phone" onKeyUp="javascript:document.getElementById('tele').value = document.getElementById('mobile').value;" onChange="javascript:document.getElementById('tele').value = document.getElementById('mobile').value;">
                                            </div>             
                             
          <div class="form-group">
          <label for="inputText3" class="col-form-label">Name On Card</label>
    <input id="cardName" type="text" class="form-control" name="cardname" onKeyUp="javascript:document.getElementById('cname').value = document.getElementById('cardName').value;" onChange="javascript:document.getElementById('cname').value = document.getElementById('cardName').value;">
                                            </div>                                   
                </div>
                <!-- End GOTV hidden -->   
                
               
                <!-- Start DSTV hidden -->       
                              <div class="float-center" id="ifDstv" style="display:none;">                 
                                       <div class="form-group" >
                                                 
		 
        <label>Select Bundle:</label>
		
		<select class="form-control" id="IsDstv" required="required" >
		    <option  disabled selected hidden>Select Data Plan</option>
		    
		 ion selected disabled hidden >Select Data Bundle</option>
                <?php while($a = $airtel->fetch_assoc()){ ?>
		        <option data-plan="<?php echo $a['plancode']; ?>" data-amount="<?php echo $a['price_user'];?>" data-service="<?php echo $a['network']; ?>" ><?php echo $a['plan'].' - '.'30 days'.' - '.'&#x20A6;'.$a['price_user'];?> </option>
		        
		        <?php } ?>
                
                </select>
	
      </div>
                       
              <div class="form-group">
          <label for="inputText3" class="col-form-label">Phone Number</label>
    <input id="phone" type="tel" class="form-control" name="phone" onKeyUp="javascript:document.getElementById('tele').value = document.getElementById('phone').value;" onChange="javascript:document.getElementById('tele').value = document.getElementById('phone').value;">
                                            </div>                
                                              
                                            
                </div>
                <!-- End DSTV hidden -->  
                
          <!-- Start STARTTIMES hidden -->       
                              <div class="float-center" id="ifStar" style="display:none;">                 
                                       <div class="form-group" >
                                                 
		 
        <label>Select Bundle:</label>
		
		<select class="form-control" id="IsStar" required="required" >
		    <option  disabled selected hidden>Select Data Plan</option>
                
             <?php while($g = $glo->fetch_assoc()){ ?>
		        <option data-plan="<?php echo $g['plancode']; ?>" data-amount="<?php echo $g['price_user'];?>" data-service="<?php echo $g['network']; ?>" ><?php echo $g['plan'].' - '.'30 days'.' - '.'&#x20A6;'.$g['price_user'];?> </option>
		        
		        <?php } ?>
                
            
                
                </select>
	
      </div>


   
                                            
              <div class="form-group">
          <label for="inputText3" class="col-form-label">Phone Number</label>
    <input id="mobil" type="tel" class="form-control" name="phone" onKeyUp="javascript:document.getElementById('tele').value = document.getElementById('mobil').value;" onChange="javascript:document.getElementById('tele').value = document.getElementById('mobil').value;">
                                            </div>                   
                                            
                </div>
                <!-- End STARTIMES hidden --> 
                
           <!-- Start 9Mobile hidden -->       
                              <div class="float-center" id="if9mob" style="display:none;">                 
                                       <div class="form-group" >
                                                 
		 
        <label>Select Bundle:</label>
		
		<select class="form-control" id="Is9mob" required="required" >
		    <option  disabled selected hidden>Select Data Plan</option>
                
             <?php while($e = $etisalat->fetch_assoc()){ ?>
		        <option data-plan="<?php echo $e['plancode']; ?>" data-amount="<?php echo $e['price_user'];?>" data-service="<?php echo $e['network']; ?>" ><?php echo $e['plan'].' - '.'30 days'.' - '.'&#x20A6;'.$e['price_user'];?> </option>
		        
		        <?php } ?>
                
                </select>
	
      </div>
               
              <div class="form-group">
          <label for="inputText3" class="col-form-label">Phone Number</label>
    <input id="9mobil" type="tel" required class="form-control" name="phone" onKeyUp="javascript:document.getElementById('tele').value = document.getElementById('9mobil').value;" onChange="javascript:document.getElementById('tele').value = document.getElementById('9mobil').value;">
                                            </div>                   
                                            
                </div>
                <!-- End 9Mobile hidden -->       
                
                
                 <form method="post" autocomplete="off">                        
                 <input type="text" hidden  name="plan" id="plan">
		 <input type="text" hidden name="service" id="service">
         <input type="text" hidden  name="amount" id="amount">
         <input type="text" hidden name="tel" id="tele">
         <input type="text" hidden name="cname" id="cname">                     <input type="text" hidden name="variation_code" id="variation_code">               
                     <div class="col-sm-6 pl-0">
                           <p class="text-center">
                                                    <button type="submit" name="DataCheck" class="btn btn-rounded btn-primary" >Proceed </button>
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
    if (document.getElementById('gotv').checked) {
        document.getElementById('ifGotv').style.display = 'block';
		
		var sourceOfPicture = "assets/images/Data-mtn.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
	
  $('#IsGotv').change(function(){
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
  
    }else document.getElementById('ifGotv').style.display = 'none';
	
	
	if (document.getElementById('dstv').checked) {
        document.getElementById('ifDstv').style.display = 'block';
		
		var sourceOfPicture = "assets/images/Airtel-Data.jpg";
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
		
	
		
		}else document.getElementById('ifDstv').style.display = 'none';
	
	if (document.getElementById('startimes').checked) {
        document.getElementById('ifStar').style.display = 'block';
		
		var sourceOfPicture = "assets/images/GLO-Data.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
		
		
		$('#IsStar').change(function(){
	  var selected = $(this).find('option:selected');
	  var amount = selected.data('amount');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  });
		
	}
    
	else document.getElementById('ifStar').style.display = 'none';
	


if (document.getElementById('9mobile').checked) {
        document.getElementById('if9mob').style.display = 'block';
		
		var sourceOfPicture = "assets/images/9mobile-Data.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
		
		
		$('#Is9mob').change(function(){
	  var selected = $(this).find('option:selected');
	  var amount = selected.data('amount');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  });
		
	}
    
	else document.getElementById('if9mob').style.display = 'none';
	}

                            </script> 
                            <!-- ============================================================== -->
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
                                        <h5 class="text-muted">Check Data Balance</h5>
                                        <p class="mb-0"> 
                                        
                                        <img src="assets/images/mtn.jpg" width="35" height="30"></span>  => *461*4# (SME)<hr>
                                            
                                       <img src="assets/images/mtn.jpg" width="35" height="30"></span> => *131*4# (Normal)<hr>
                                           
                                        <img src="assets/images/9mobile.jpg" width="35" height="30"></span> => *228#<hr>
                                            
                                        <img src="assets/images/glo.jpg" width="35" height="30"></span> => *127*0#
                                        <hr>
                                            
                                        <img src="assets/images/airtel.jpg" width="35" height="30"></span> => *140#
                                        
                                        
                                        </p>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                                
                                <div class="card">
                                <div class="card-body">
                                    <div class="d-inline-block">
                                        <h5 class="text-muted">Affiliate Link:</h5>
                                        <p class="mb-0"> <?php echo $data[0]['reflink'];echo $data[0]['refid'];?></p>
                                        
                                    </div>
                                    <div class="float-left"><p class="text-muted"><strong>Total Referred:</strong> <?php echo $data[0]['refcount']; ?> <br> 
                                    
                                   <strong> Earning:</strong> &#x20A6;<?php echo number_format($data[0]['refwallet'],2,'.',','); ?>
                                    </p> </div>
                                    
                                    
                                    <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                        
                                        <i class="fa fa-users fa-fw fa-sm text-primary"></i>
                                    </div>
                                </div>
                            </div>
                            </div>
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