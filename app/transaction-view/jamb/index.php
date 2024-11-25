<?php 
session_start();
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
                  
                    <div class="ecommerce-widget">

                        <div class="row"></div>
                        <div class="row">
                            <!-- ============================================================== -->
                      
                         
                            <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                            
                                <div class="card">
                                          
                                    <h5 class="card-header"></h5>
                                    <div class="card-body">
                                    <?php
							
					$username = $_SESSION['user'];
										$amount = intval($_SESSION['amt']);
										$network = $_SESSION['carier'];
										$phone = $_SESSION['phone'];
										$requestId = $_SESSION['transid'];
										$iuc = $_SESSION['iuc'];
										$plan = $_SESSION['plan'];
										$type = $_SESSION['type'];
										$variation_code = $_SESSION['variation_code'];
										
										$surname = $_SESSION['surname'];
	                                       $firstname = $_SESSION['firstname'];
	                                    $middleName = $_SESSION['middleName'];
	                                    $jb_fullName = $_SESSION['fullName'];
	                                   $phoneNumber = $_SESSION['phoneNumber'];
	                                $profilecode = $_SESSION['profileCode'];

					$trans = mysqli_query($conn,"SELECT * FROM transactions WHERE ref='$requestId' ");					
					$rowTrans = mysqli_fetch_array($trans);	
					
					$comi = intval(0);				
				  $sumAmount = strval(floatval(intval($amount)) * floatval(intval($iuc)));
				  $AmountPlusFee = strval(floatval(intval($sumAmount)) + floatval(intval($conv)));
					$chargeAmt = intval($AmountPlusFee);
 

?>

 
                               
<h2 class='margin-tp-10'>Please Confirm your Transaction Details: </h2>     
                                      
                                        
                    <table class="table  margin-tp-10">
                     
                       <tr>
                            <td width="30%"> </td>
                            <td id="mainService"><img src="../../assets/images/jamb-epins-nigeria.jpg" width="120" height="110" >  </td>
                        </tr>
                        
                        
                        <tr>
                            <td width="30%">Product</td>
                            <td id="mainService"><?php echo $plan; ?> </td>
                        </tr>
                         <tr>
                            <td width='30%'>Full Name</td>
                            <td id='mainService'><?php echo $jb_fullName; ?> </td>
                        </tr>
                          
                        <tr>
                            <td width='30%'>Phone Number</td>
                            <td id='mainService'><?php echo $phoneNumber;?></td>
                        </tr>
                        
                            <tr>
                            <td width="30%">Profile Code</td>
                            <td><?php echo $profilecode;?></td>
                        </tr>  
                        
                                         
                                                            <tr>
                        <td width="30%">Amount</td>
                        <td>₦<?php echo $_SESSION['amt'];?>.00 +  ₦<?php echo $charge ?>.00 <i class="conv_fee">
                            
                                                                (Convenience fee)
                                                        
                        </i></td>
                    </tr>
                    
                    <tr>
                        <td width="30%">Discount</td>
                        <td>₦<d id="total_amount"><?php echo $comi;?></d></td>
                    </tr>
                    
                                          
                    <tr>
                        <td width="30%">Total Payable Amount</td>
                        <td>₦<d id="total_amount"><?php echo $chargeAmt;?></d></td>
                    </tr>                                       
                    <tr>
                        <td width="30%"><stro>Transaction ID</h4></td>
                        <td id="transactionId"><?php echo $rowTrans['ref'];?></td>
                    </tr>                    
                    <tr>
                        <td width="30%">Status</td>
                        <td><?php echo $rowTrans['status']; ?></td>
                    </tr>       
                    
                    <tr>
                        <td width="30%">Time Left to Complete Transaction</td>
                        <td><?php echo '<strong id="timing">' ?></td>
                    </tr>             
                                            <tr>
                            <td colspan="2">
                        
                                <div class="pay-button">
                                    
                       <form method="post" action="javascript:void(0)" id="jambPros">                                                    
                    <input type="hidden" name="amount" value="<?php echo $chargeAmt; ?>">    
                    
                    <input type="hidden" name="network" value="<?php echo $network; ?>">
                    <input type="hidden" name="phone" value="<?php echo $phone; ?>">
                     
                      <input type="hidden" name="plan" value="<?php echo $plan; ?>">
                      
                      <input type="hidden" name="profilecode" value="<?php echo $profilecode; ?>">
                      
                       <input type="hidden" name="type" value="<?php echo $type; ?>">
                      
                       <input type="hidden" name="variation_code" value="<?php echo $variation_code; ?>">
                        <input type="hidden" name="requestId" value="<?php echo $requestId; ?>">  
                        
                        
                                        <div id="h"></div> 
                                                <p class="text-center">
                                <button type="submit" id="gen"  class="btn btn-rounded btn-primary"><i class="fas fa-fw fa-money-bill-alt"></i> Pay & Generate PIN</button>
                                    </form> </p>
                                </div>
                              </td>
                              <td></td>
                        </tr>
                                    </table>              
                                  
                                 
                                                             
                               
   
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->

                            <!-- ============================================================== -->
    <script>
    
   $('#jambPros').submit(function(e){
                e.preventDefault();  
                var data = $(this).serialize();
               
                $.ajax({
                   url: 'generate_jamb.php',
                   type: 'POST',
                   data: data,
                 beforeSend: function(){
                    $('#gen').html('Processing...'); 
                 },  
                }).done(function(res){
                res = JSON.parse(res);
              let redirUrl = res['redirect'];
              let Message = res['msg'];
                if(res['status']){
                    
             
             Swal.fire({
  title: 'Transaction Successful',
  html:
    '<b>'+ Message +'</b> ',
  icon: 'success',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Make New Purchase'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href="../../jamb.php";
  }
})       
       $('#gen').html('Completed');
       
                }else{
                    
         Swal.fire({
  position: 'top-middle',
  icon: 'error',
  text: Message,
  showConfirmButton: false,
  timer: 5000
})   

setTimeout(function(){
  window.location.reload();  
},2000);
                }
            
            });  
            
   });    
 
//////////////////////////////////////////////////
// Set the date we're counting down to
var countDownDate = new Date("Jan 5, 2030 15:37:25").getTime();

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
 
 <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>                            <!-- ============================================================== -->
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
                                                <th>Description</th>
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
                                            <td><?php echo $trow['network']; ?></td>     
                                                <td><?php echo '&#x20A6;'.$trow['amount'].' ';?></td>
                                                 <td><?php echo $trow['status'];?></td>
                                                <td><?php echo $trow['date'];?></td>
                                                
                                            </tr>
                                           
                                           <?php } ?>
                                          
                                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Transaction ID</th>
                                                <th>Description</th>
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