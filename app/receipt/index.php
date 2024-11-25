<?php 
session_start();
require('../db.php'); 
include('../inc/func.php');
include('../inc/gravatar.php');
include('../inc/logo.php');
include('../inc/coinpayments.inc.php');
include('../inc/query_processor.php');
include('../inc/header1.php');?> 
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
                                <h2 class="pageheader-title">Receipt </h2>
                        
                               
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
                            <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12" >
                                <div class="card">
                                
                                    
                                    <div class="card-body" id="elem" >
                                    
                               
                  <?php
				  
				  if(isset($_GET['tid'])){
					  
					  $rei = $_GET['tid'];
					  
	$GetRef = "SELECT * FROM transactions WHERE ref='$rei' ";
	 $qryRef = $conn->query($GetRef);$trid = mysqli_fetch_array($qryRef);			  
					  }
									
		$otherbil = array("smile-direct","gotv","dstv","startimes","01","02","03","04");
	$airData = array("01","02","03","04","mtn","airtel","glo","etisalat","9mobile");		
						
	 $bilarray = array("prepaid","postpaid","ikeja-electric","eko-electric","portharcourt-electric","ibadan-electric","kano-electric","kaduna-electric","abuja-electric","enugu-electric","waec");
	 
	 if(in_array($trid['serviceid'] or $trid['servicetype'],$bilarray)){
		 
		 $showtk = ShowToken($conn,$trid); 
		
		$showMeter = ' <tr>
                             <td width="30%">Metertype</td>
                                    <td>'.$trid['serviceid'].'</td>
                                </tr>
                                                            <tr>
                                    <td width="30%">Meter Number</td>
                                    <td>'.$trid['meterno'].'</td>
                                </tr>   '; 
                                
                   
                                
	 }        
						
								
		if(in_array($trid['serviceid'],$otherbil)){
			
			$showTabb = '<tr>
                            <td width="30%">Customer Name</td>
                            <td>'.$trid['customerName'].'</td>
                                </tr>
                          ';
                          
                          $showMeter = NULL;
			$showTabb = NULL;
			} 
			
			if (in_array($trid['serviceid'],$airData))
			{						
	
                $showtk = NULL;
                     $showMeter = NULL;
			$showTabb = NULL;
									  
			}
								
		 
		 function ShowToken($conn,$trid){
		 $showTabb = '<tr>
                  <td width="30%">Customer Name</td>
                   <td>'.$trid['customerName'].'</td>
                   </tr>
                    <tr>
                   <td width="30%">Token</td>
                   <td>Token : '.$trid['metertoken'].'</td>
                    </tr>
                     ';    
		     
		 }

		 ?>             
                               
                               
                               
                               
                    <div class="card-header p-4"  >
                                     <a class="pt-2 d-inline-block" href="#"><img src="../sitelogo/<?php echo $settings['sitelogo']; ?>"></a>
                                   
                                    <div class="float-right"> <h3 class="mb-0"> </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
               <h2>Your Transaction Details are as Follows:</h2>   
                                        
                                    </div>
                                    <div class="table-responsive-sm">
                                   
                                    <table class="table  margin-tp-10">                            
                              <?php echo $showtk; ?>                          
                                                                                 
                                                                                        <tr>
                                    <td width="30%">Service Name</td>
                                    <td><?php echo $trid['network']; ?></td>
                                </tr>
                                                            
                                      <?php echo $showMeter;?>                      
                                                            <tr>
                                    <td width="30%">Amount</td>
                                    <td><?php echo '&#x20A6;'.$trid['amount'].''; ?></td>
                                </tr>
                                                           
                                                            <tr>
                                    <td width="30%">Total Amount Paid</td>
                                    <td><?php echo '&#x20A6;'.$trid['charge'].''; ?></td>
                                </tr>
                                                            
                                                            
                                  <?php echo $showTabb?>                          
                                                        <tr>                             
                                <td>
                                   Transaction ID
                                </td>
                                <td>
                                    <?php echo $trid['ref']; ?>
                                </td>
                            </tr>
                            <tr>                             
                                <td>
                                    Status
                                </td>
                                <td>
                                   <?php echo $trid['status']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">Date</td>
                                <td><?php echo $trid['date']; ?></td>
                            </tr>                                                     
                        </table>    
                                    
                                    </div>
                                </div>
                                <div class="card-footer bg-white">
                                    <p class="mb-0"> </p>
                                    
                                    
                                    <button id="print" onclick="PrintElem('elem');"  class="btn btn-outline-success" >Print Receipt</button>
                                </div>
                            </div>           
                               
                               
                               
                               
                          
                                </div>
                            </div>
                            
                            
<script>

function PrintElem(elem)
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h5>' + document.title  + '</h5>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
</script>        
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
    

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
    $(function () {
        $('#tableId').DataTable();
    });
</script>
    
    
</body>
 
</html>