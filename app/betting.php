<?php 
session_start();
require_once('db.php'); 
include('inc/func.php');
include('inc/gravatar.php');
include('inc/logo.php');
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
                                <h2 class="pageheader-title"><li class="fa fa-football-ball"></li> Sport Betting  </h2>
                        
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
                                      
                   
                                        <label for="inputText3" class="col-form-label"></label><br>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <img src="assets/images/ixbet.png"width="35" height="30" class="rounded-corners"></span>
                                            </label>
                                            
                                            
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <img src="assets/images/bet9ja-small.png" width="35" height="30" class="rounded-corners"></span>
                                            </label>
                                            
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <img src="assets/images/naijabet.png" width="35" height="30" class="rounded-corners"></span>
                                            </label>
                                            
                       <label class="custom-control custom-radio custom-control-inline">
                                                <img src="assets/images/nairabet.png" width="35" height="30" class="rounded-corners"></span>
                                            </label>
                                            
                                            
    <label class="custom-control custom-radio custom-control-inline">
                                                <img src="assets/images/betking.png" width="35" height="30" class="rounded-corners"></span>
                                            </label>
                                            
                                            
                                  
                                   
                                  
                        <form action="javascript:void(0)" id="mtncglite" method="post">   
                        
                 <div class="form-group" id="disco" >
        <label for="inputText3" class="col-form-label"></label> 
              <select class="form-control rounded-right" name="network" id="network" style="border-radius: 0px; height: 50px;">
            <?php $mtncgl = $conn->query("SELECT * FROM betting_package  ORDER BY `plan` ASC"); ?>    
            <option  selected disabled hidden>Select Service</option>
		    
		    <?php while($mcgl = $mtncgl->fetch_assoc()){ ?> 
		        <option  value="<?php echo $mcgl['serial']; ?>" > <?php echo strtoupper($mcgl['network']);?> </option>
		        <?php } ?>
		   
		</select> 
		<input type="hidden" name="token" id="token" value="<?php echo base64_encode($email); ?>">
		<input type="hidden" id="unit">
		</div>
             
           
<div class="form-group">
          <label for="inputText3" class="col-form-label">Enter Amount</label>
    <input id="amount" type="number" step="0.01" class="form-control rounded-right" name="amount" style="border-radius: 0px; height: 50px;">
                                            </div>  
                
         <div class="form-group">
          <label for="inputText3" class="col-form-label">Enter CustomerID</label>
    <input id="meterno" type="number"   class="form-control rounded-right" name="meterno" style="border-radius: 0px; height: 50px;">
                                            </div>   
                                            
          
         <span id="amountpay"></span> 
         
             <div class="col-sm-6 pl-0">
                           <p class="text-center">
                                                    <button type="submit" id="btnelectric" class="btn btn-rounded btn-danger" ><i class="fa fa-arrow-right"></i> Proceed </button>
                                       
                                                </p>                                            
                                            </div>                                 
                             
             </form>  
             
  <script src="js/sb-bet.js"></script>    
             
                                 
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->
                                  

                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- customer acquistion  -->
                            <!-- ============================================================== -->
                           <?php include('inc/sidebar.php'); ?>
                            <!-- ============================================================== -->
                            
                            
                            
                            <!-- end customer acquistion  -->
                      
                         <?php include('inc/recent-transaction-widget.php'); ?>
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                        </div>
                     
                      
                        
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
           <?php include('inc/footer.php');  ?>