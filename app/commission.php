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
                                <h2 class="pageheader-title"><li class="fa fa-hand-holding-usd"></li> Product Commissions </h2>
                        
                            
                        
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
                                 
                             <h3 class="card-header">Commission Rates </h3>            
                              <p class="card-header">
                              
                              <?php 
                              
                              $query_rec = mysqli_query($conn,"SELECT * FROM commission");
			
			$com = mysqli_fetch_array($query_rec);
                              ?>

<span class="float-right">
 </span>

<div class="table-responsive">
                    <table class="table table-bordered" style="text-align: center;">
                        <thead>
                            <th>Service</th>
                            <th>Widget</th>
                            <th>Affilate</th>
                            <th>Refer a Friend</th>
                            <th>API</th>
                            <th>Special Rate</th>
                        </thead>
                        <tbody>
                                                      <tr>
                                <td style="text-align: left;">Airtel Airtime VTU</td>
                                <td>
                                                                       <?php echo $com['airtelvtu'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['airtelvtu'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['airtelvtu'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['airtelvtu'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">MTN Airtime VTU</td>
                                <td>
                                                                        <?php echo $com['mtnvtu'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['mtnvtu'];?>%
                                </td>
                                <td>
                                                                       <?php echo $com['mtnvtu'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['mtnvtu'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">GLO Airtime VTU</td>
                                <td>
                                                                        <?php echo $com['glovtu'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['glovtu'];?>%
                                </td>
                                <td>
                                                                       <?php echo $com['glovtu'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['glovtu'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">9mobile Airtime VTU</td>
                                <td>
                                                                       <?php echo $com['9mobilevtu'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['9mobilevtu'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['9mobilevtu'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['9mobilevtu'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">DSTV Subscription</td>
                                <td>
                                                                        <?php echo $com['dstv'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['dstv'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['dstv'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['dstv'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">Airtel Data</td>
                                <td>
                                                                        <?php echo $com['airtelData'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['airtelData'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['airtelData'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['airtelData'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">MTN Data</td>
                                <td>
                                                                        <?php echo $com['mtnData'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['mtnData'];?>%
                                </td>
                                <td>
                                                                       <?php echo $com['mtnData'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['mtnData'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">GLO Data</td>
                                <td>
                                                                        <?php echo $com['gloData'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['gloData'];?>%
                                </td>
                                <td>
                                                                       <?php echo $com['gloData'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['gloData'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">9mobile Data</td>
                                <td>
                                                                         <?php echo $com['9mobileData'];?>%
                                </td>
                                <td>
                                                                         <?php echo $com['9mobileData'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['9mobileData'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['9mobileData'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                            
                                                  <tr>
                                <td style="text-align: left;">SME Data</td>
                                <td>
                                                                        <?php echo $com['IkejaElectric'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['IkejaElectric'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['IkejaElectric'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['IkejaElectric'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                            
                                                      <tr>
                                <td style="text-align: left;">Gotv Payment</td>
                                <td>
                                                                        <?php echo $com['gotv'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['gotv'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['gotv'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['gotv'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">Startimes Subscription</td>
                                <td>
                                                                        <?php echo $com['startimes'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['startimes'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['startimes'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['startimes'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">Ikeja Electric Payment - PHCN</td>
                                <td>
                                                                       <?php echo $com['IkejaElectric'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['IkejaElectric'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['IkejaElectric'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['IkejaElectric'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">Eko Electric Payment - EKEDC</td>
                                <td>
                                                                       <?php echo $com['EkoElectric'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['EkoElectric'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['EkoElectric'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['EkoElectric'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">WAEC Result Checker PIN</td>
                                <td>
                                                                        ₦<?php echo $com['waec'];?>
                                </td>
                                <td>
                                                                        ₦<?php echo $com['waec'];?>
                                </td>
                                <td>
                                                                        ₦<?php echo $com['waec'];?>
                                </td>
                                <td>
                                                                        ₦<?php echo $bil['waec'];?>
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      
                                                      <tr>
                                <td style="text-align: left;">KEDCO - Kano Electric</td>
                                <td>
                                                                        <?php echo $com['Kedc'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['Kedc'];?>%
                                </td>
                                <td>
                                                                       <?php echo $com['Kedc'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['Kedc'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">PHED - Port Harcourt Electric</td>
                                <td>
                                                                        <?php echo $com['Phed'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['Phed'];?>%
                                </td>
                                <td>
                                                                         <?php echo $com['Phed'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['Phed'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                     
                                                      <tr>
                                <td style="text-align: left;">Smile Payment</td>
                                <td>
                                                                       <?php echo $com['smile'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['smile'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['smile'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['smile'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                     
                                                      <tr>
                                <td style="text-align: left;">Jos Electric - JED</td>
                                <td>
                                                                        <?php echo $com['JosElectric'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['JosElectric'];?>%
                                </td>
                                <td>
                                                                        <?php echo $com['JosElectric'];?>%
                                </td>
                                <td>
                                                                        <?php echo $bil['JosElectric'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">BulkSMS</td>
                                <td>
                                                                        0.00
                                </td>
                                <td>
                                                                        0.00
                                </td>
                                <td>
                                                                        0.00
                                </td>
                                <td>
                                                                        <?php echo $bil['sms'];?>%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">Lagos Forex Master Class</td>
                                <td>
                                                                        ₦200.00
                                </td>
                                <td>
                                                                        ₦200.00
                                </td>
                                <td>
                                                                        ₦200.00
                                </td>
                                <td>
                                                                        ₦600.00
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">Smile Network Payment</td>
                                <td>
                                                                        1.00%
                                </td>
                                <td>
                                                                        1.00%
                                </td>
                                <td>
                                                                        1.00%
                                </td>
                                <td>
                                                                        <?php echo $bil['smile'];?>.00%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                                                      <tr>
                                <td style="text-align: left;">IBEDC - Ibadan Electricity Distribution Company</td>
                                <td>
                                                                        0.50%
                                </td>
                                <td>
                                                                        0.50%
                                </td>
                                <td>
                                                                        0.50%
                                </td>
                                <td>
                                                                        <?php echo $bil['Ibedc'];?>.00%
                                </td>
                                <td>
                                                                                                                -    
                                     
                                </td>
                            </tr>
                            
                            
                                                  </tbody>                            	
                    </table>
                </div>


</p>
 
        
                                    
                                 
                                   
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->
                            
                    
                            
<script>

function vip_value()
{
var hidden_field = document.getElementById('amount');
hidden_field.value = '<?php echo $bil['setup'];?>';

var hidden_field = document.getElementById('service');
hidden_field.value = 'Upgrade + Reseller Portal Setup ';

var hidden_field = document.getElementById('tele');
hidden_field.value = '<?php echo $data['phone'];?>';

var hidden_field = document.getElementById('lname');
hidden_field.value = '<?php echo $data['lastname']?>';

var hidden_field = document.getElementById('fname');
hidden_field.value = '<?php echo $data['firstname']?>';
}

function regular_value()
{
var hidden_field = document.getElementById('amount');
hidden_field.value = '<?php echo $bil['reseller'];?>';

var hidden_field = document.getElementById('service');
hidden_field.value = 'Reseller Account Upgrade ';

var hidden_field = document.getElementById('tele');
hidden_field.value = '<?php echo $data['phone'];?>';

var hidden_field = document.getElementById('lname');
hidden_field.value = '<?php echo $data['lastname']?>';

var hidden_field = document.getElementById('fname');
hidden_field.value = '<?php echo $data['firstname']?>';
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
 
 
 
 function showTicket(){
    if (document.getElementById('VIP').checked) {
        document.getElementById('ifVIP').style.display = 'block';
		
		var sourceOfPicture = "assets/images/limited-time-special-offers.png";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
  
  
 

  
    }else document.getElementById('ifVIP').style.display = 'none';
	
	
	if (document.getElementById('Regular').checked) {
        document.getElementById('ifRegular').style.display = 'block';
		
		var sourceOfPicture = "assets/images/reseller-program.png";
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
		
	
		
		}else document.getElementById('ifRegular').style.display = 'none';
	
	
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