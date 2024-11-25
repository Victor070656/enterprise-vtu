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
<style>


/* Float four columns side by side */
.column-data {
  float: left;
  width: 50%;
  padding: 0 5px;
}

/* Remove extra left and right margins, due to padding */
.row-data {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column-data {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.card-data {
  box-shadow: 1px 1px 1px 1px rgba(0.2, 0.2, 0.2, 0.2);
  padding: 16px;
  text-align: left;
  background-color: #fff;
}
</style> 
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
                                <h2 class="pageheader-title">DATA CARD PRINTING </h2>
                        
                               
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
				  
				  if(isset($_GET['id'])){
					  
					$DcardRef = base64_decode($_GET['id']);
					  
				$GetRef = $conn->query("SELECT * FROM transactions WHERE ref='$DcardRef'");
	                
					$txr = $GetRef->fetch_assoc();
					
				
					  }
					 ?>             
                               
                          
                                <div class="card-body">
                                    <div class="row mb-4">
                 
                                        
                                    </div>
                                    <div class="table-responsive-sm">
                                   
                                     <?php $dataPins = ltrim($txr['metertoken']);
          
          $xtracto = explode("\n",$dataPins);
        $img = "../assets/images/mtn.jpg";  
          ?>
          <div class="row-data">
              <?php foreach($xtracto as $rowpin){ ?>
  <div class="column-data">
    <div class="card-data">
    <i style="text-align:center;"><?php echo $txr['vcode']; ?></i>   
    <table>
     <tr>
    <td style="font-size:12px;">Ref. No:</td> 
    <td style="font-size:12px;"><?php echo $txr['ref']; ?></td> 
    <td width="10%"><?php echo "1.5GB"; ?></td> 
    </tr>  
    <tr>
    <td style="font-size:14px;"><strong >PIN:</strong></td> 
    <td style="font-size:20px;"><strong ><?php echo $rowpin; ?></strong></td> 
    <td><img src="../<?php echo $img; ?>" width="70%"/></td> 
    </tr> 
    <tr>
    <td style="font-size:14px;">Dial:</td> 
    <td style="font-size:14px;" colspan="2"><strong>*460*6*1# </strong> then enter pin.</td> 
    </tr>
     <tr>
    <td style="font-size:14px;"  colspan="2">Check data balance: *312*5#</td> 
   
    </tr>
        
    </table>
    
 
    </div>
  </div>
  
  <?php } ?>
</div>


                                    
                                    </div>
                                </div>
                             
                            </div>           
                               
                           
                                </div>
                                
                                <div class="row float-right">
                               
                               <div class="col-3">
                               <button id="print" onclick="PrintElem('elem');"  class="btn btn-outline-primary" ><i class="fa fa-print"></i> Print DATACARD</button>
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