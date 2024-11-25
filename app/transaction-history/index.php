<?php 
session_start();
require('../db.php'); 
include('../inc/func.php');
include('../inc/gravatar.php');
include('../inc/logo.php');
include('../inc/coinpayments.inc.php');
include('../inc/query_processor.php');
?> 
<?php include('../inc/header1.php');?> 
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
      
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php include('../inc/nav2.php'); ?>
         
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
                                <h2 class="pageheader-title">Transaction History </h2>
                        
                               
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
                                    
                                    <div class="card-body">
                                    
                               
                                   	<?php
									
									
									
						$GetHistory = "SELECT * FROM transactions WHERE email='$user' ";
	 
	 $qryHistory = $conn->query($GetHistory);
	 

									 ?>
                                
                                <div style="overflow-x:auto;">
                                      
                                 <table class="table table-striped table-bordered" id="example" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Ref</th>
                                                <th>Service Name</th>
                                                <th>Amount</th>
                                                <th>Amount Paid</th>
                                                <th>Channel</th>
                                                <th>Destination</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                 <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                <?php while($qryData = $qryHistory->fetch_assoc()){ ?>
                                            <tr>
                             
                                                <td><?php echo $qryData['ref'];?></td>
                                                <td><?php echo $qryData['network'];?> </td>
                                                <td><?php echo ' &#x20A6;'.$qryData['amount'];?></td>
                                                <td><?php echo ' &#x20A6;'.$qryData['charge'];?></td>
                                                <td><?php echo $qryData['channel'];?></td>
                                                <td><?php echo $qryData['phone'];?></td>
                                                <td><?php echo $qryData['status'];?></td>
                                                <td><?php echo $qryData['date'];?></td>
                                                
                                                 <td>
                                                 
                                        <div class="btn-group dropdown">
											<button  class="btn btn-outline-secondary dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-eye"></i> <span class="caret"></span> </button>
											<div class="dropdown-menu">
											   
									
										<?php if( $qryData['servicetype'] !== 'datacard'){?>	
												<a class="dropdown-item" href="../receipt?tid=<?php echo $qryData['ref'];?>"><button class="btn btn-outline-info" style="cursor:pointer;"><i class="fa fa-eye"></i> View Receipt </button></a>
										
										<?php } ?>
										
										
										<?php  if($qryData['servicetype'] === 'datacard'):?>
											<a class="dropdown-item" href="../datacard-printing?id=<?php echo base64_encode($qryData['ref']);?>">  <button class="btn btn-outline-primary" style="cursor:pointer;"><i class="fa fa-print" aria-hidden="true"></i> Print Datacard</button>  </a>
										<?php endif; ?>
										
										<?php if($qryData['servicetype'] === 'epin'):?>
											<a class="dropdown-item" href="../print-rechargecard?id=<?php echo base64_encode($qryData['ref']);?>">  <button class="btn btn-outline-success" style="cursor:pointer;"><i class="fa fa-print" aria-hidden="true"></i> Print Card</button>  </a>
										<?php endif; ?>
										
										
											</div>
										</div>              
                                                 </td>
                                                 
                                            </tr>
                                            
                                           <?php }?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                  <th>Ref</th>
                                                <th>Service Name</th>
                                                <th>Amount</th>
                                                <th>Channel</th>
                                                <th>Destination</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </tfoot>
                                    </table>     
                                      
                                 </div>      
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            <!-- 
                            ============================================================== -->
                            <!-- end recent orders  -->
                            
                            <script>
                                
                             
 function cont() {
    if (document.getElementById('phonebook').checked) {
        document.getElementById('ifYes').style.display = 'block';
    }
    else  document.getElementById('ifYes').style.display = 'none';
    
    
    
   
}    
                      
   $("#sendto").on("keyup", function() {
  $(this).val($(this).val().replace(/[\,\-\n]/g, ","));
});           
                                
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
                                        <h5 class="text-muted">Total Contacts</h5>
                                        <h2 class="mb-0"> 0</h2>
                                    </div>
                                    <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                        <i class="fa fa-user fa-fw fa-sm text-primary"></i>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end customer acquistion  -->
                            
                          
                            <!-- ============================================================== -->
                        </div>
                        <div class="row">
                            <!-- ============================================================== -->
              				                        <!-- product category  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- end product category  -->
                          
  	<script type="text/javascript">
		//datepicker plugin
		//link	
	


		function countMsgsText(val){

			val = val.split("\n").join('??').split('{').join('??').split('}').join('??');

			val = val.split('\\').join('??').split('[').join('??').split(']').join('??');

			val = val.split('~').join('??').split('|').join('??').split('^').join('??');

			val = val.split('€').join('??').split('"').join('??').split("'").join('??');

			len = val.length;

			if(len<=160){

				jQuery('#paget').html('Page: '+Math.ceil(len/160));
				jQuery('#count').html(', Characters left: ' + (1+((160 - 1) * Math.ceil(len/160))-len) + ', Total Typed Characters: '+len);

				jQuery('#hiddenCount').html(Math.ceil(len/160)+' page');

			} else {
				jQuery('#paget').html('Page: '+Math.ceil(len/151));
				jQuery('#count').html(', Characters left: ' + (1+((151 - 1) * Math.ceil(len/151))-len) + ', Total Typed Characters: '+len);	

				jQuery('#hiddenCount').html(Math.ceil(len/151)+' pages');

			}

			countDest();

		}

		
	

	</script>
                                   <!-- product sales  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- end product sales  -->
                            <!-- ============================================================== -->
                        </div>

                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- sales  -->
                            
                            <!-- ============================================================== -->
                            
                        </div>
                        <div class="row">
                            <!-- ============================================================== -->
                           
                            <!-- end category revenue  -->
                            <!-- ============================================================== -->
                        </div>
                        <div class="row">
                          <!-- ============================================================== -->
                            <!-- end sales traffice source  -->
                            <!-- ============================================================== -->
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
       <?php include('../inc/footer1.php');?>
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
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="../assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="../assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="../assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="../assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="../assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="../assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="../assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="../assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="../assets/libs/js/dashboard-ecommerce.js"></script>
    
<script src="../assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#example').DataTable( {
        "order": [[ 7, "desc" ]],
        
    } );
} );

</script>
    
    
</body>
 
</html>