<?php 
session_start();
require('db.php'); 
include('inc/func.php');
include('inc/gravatar.php');
include('inc/logo.php');

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
                    
                <?php $wryNews = mysqli_query($conn,"SELECT * FROM newsalert");
    
    $lert = mysqli_fetch_array($wryNews);
    
    ?>                   
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    

                    <script>

function myFunction(){
 
Swal.fire({
  title: '<strong><?php echo $lert['heading']; ?></strong>',
 
  imageUrl: '<?php if($lert['img_stat'] === 'show'){ echo $lert['img_link'];}else{ echo NULL; }?>',
  imageWidth: 400,
  imageHeight: 200,
  imageAlt: 'Custom image',
  html:
    '<?php echo $lert['content']; ?>',
  showCloseButton: false,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText:
    '<i class="fa fa-thumbs-up"></i> <?php print($lert['btn']); ?>',
    confirmButtonColor:'#d33',
  confirmButtonAriaLabel: 'Thumbs up, Exit',
  cancelButtonText:
    '<i class="fa fa-thumbs-down"></i>',
  cancelButtonAriaLabel: 'Thumbs down'
}).then((result)=>{
  
  if(result.isConfirmed){
   window.open('<?php print($lert['link']); ?>','_self');    
  }  
    
})
 
}
</script> 


                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="ecommerce-widget">

                        <div class="row"></div>
                        <div class="row">
                            
                            
                     <!-- ============================================================== -->
                        <!-- profile -->
                        <!-- ============================================================== -->
                        <div class="col-xl-3 col-lg-3 col-md-5 col-sm-12 col-12">
                            <!-- ============================================================== -->
                            <!-- card profile -->
                            <!-- ============================================================== -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="user-avatar text-center d-block">
                                        
                                        <img src="<?php echo $grav_url; ?>" alt="User Avatar" class="rounded-circle user-avatar-xl">
                                    </div>
                                    <div class="text-center">
                                        
                                       <script src="inc/greeting.js"></script>
                                        
                                        <h3 class="font-24 mb-0"><?php echo ucfirst($fname);  ?> <?php if($level =='paid'):?>
                                        <h3 class="badge badge-success"><?php echo strtoupper('Reseller')?></a>
                                        <?php else:?> <a class="badge badge-primary"><?php echo '<i class="fa fa-user"></i> '.strtoupper('User')?></a> <?php endif; ?></h3>
                                        <p>
                                        
                                        
                                        <?php if($level =='paid'):?>
                                          <a href="apikey.php" class="btn btn-warning rounded solid">Create API Key</a><?php endif;?>
                                        
                                        <div class='support float-right'>     
                                         <a class="call-support show-mobile" href="add-fund.php"> <li class="fa fa-credit-card"></li> Credit Wallet</a>     
                                               </div>
                                        
                                        <?php if($level =='free'): ?>
                                        
                                        
                                        <a href="reseller.php" class="btn btn-warning rounded solid">Upgrade to Reseller</a><?php  endif; ?></p>
                                    </div>
                                </div>
                                
                                
                                
                                
                                <div class="card-body border-top">
                                    <h3 class="font-16">Share & Earn Commission</h3>
                                    
                                    <div class="input-group mb-3">
                                                <div class="input-group-prepend"></div>
                                                <input type="text" class="form-control"value="<?php echo $refy_url;echo $refyid;?>" id="myInput" >
                                                <div class="input-group-append"><button class="btn btn-rounded btn-success" onclick="affcopy()">Copy</button></div>
                                         
                                          <div id="share-buttons">
<a href="whatsapp://send?text=Instantly recharge Gotv, Dstv,Bet9ja,Smile, Spectranet, Startimes, Electricity at a discount and earn money. Try it here <?php echo $refy_url;?><?php echo $refyid;?>" data-action="share/whatsapp/share"> <?php echo $whatsapp;?></a> 

<!-- Facebook -->
    <a href="http://www.facebook.com/sharer.php?u=<?php echo $refy_url;?><?php echo $refyid;?>" target="_blank">
        <?php echo $facebook; ?>
    </a>


  <!-- Twitter -->
    <a href="https://twitter.com/share?url=<?php echo $refy_url;?><?php echo $refyid;?>&amp;text=Instantly recharge Gotv, Dstv,Bet9ja,Smile, Spectranet, Startimes, Electricity at a discount and earn money. Try it here <?php echo $rlink;?><?php echo $refk;?>&amp;hashtags=epins" target="_blank">
       <?php echo $twitter; ?>
       
    </a>


    

</div>       
                                                
                                            </div>   
                                   
                              
                            
                                                
                                                
                                            </div> 
                               
                            </div>
                            
                            
                            <!-- ============================================================== -->
                            <!-- end card profile -->
                            <!-- ============================================================== -->
                        </div>
                        <!-- ============================================================== -->
                        <!-- end profile -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->           
                            
                            
             <!-- campaign data -->
                        <!-- ============================================================== -->
                        <div class="col-xl-9 col-lg-9 col-md-7 col-sm-12 col-12">
                            <!-- ============================================================== -->
                            <!-- campaign tab one -->
                            <!-- ============================================================== -->
                            <div class="influence-profile-content pills-regular">
                                <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-campaign-tab" data-toggle="pill" href="#pills-campaign" role="tab" aria-controls="pills-campaign" aria-selected="true"><i class="fas fa-chart-area"></i> Overview</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-airtime-tab" data-toggle="pill" href="#pills-airtime" role="tab" aria-controls="pills-airtime" aria-selected="false"> <i class="fa fa-phone"></i> Airtime </a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-data-tab" data-toggle="pill" href="#pills-data" role="tab" aria-controls="pills-data" aria-selected="false"> <i class="fa fa-wifi"></i> Data</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-review-tab" data-toggle="pill" href="#pills-review" role="tab" aria-controls="pills-review" aria-selected="false"><i class="fa fa-credit-card"></i> Bills</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-msg-tab" data-toggle="pill" href="#pills-msg" role="tab" aria-controls="pills-msg" aria-selected="false"><i class="fas fa-forward"></i> More </a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-campaign" role="tabpanel" aria-labelledby="pills-campaign-tab">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <div class="section-block">
                                                    <h3 class="section-title">Overview <span class="float-right"> 
                                               <?php 
										$qryCb = $conn->query("SELECT cwallet FROM users WHERE email='$email'");
										$mycwal = $qryCb->fetch_assoc();
																
										if($mycwal['cwallet'] <= 0){
										$btoff = "disabled";	
										}else{ $btoff = ""; }

										if(isset($_REQUEST['cbtn'])){
										$valAmt = test_input(floatval(abs($_REQUEST['amount'])));
										if($valAmt <= $mycwal['cwallet']){
										$comsum = strval(floatval($bal) + floatval(intval(abs($valAmt))));
										strval($commins = floatval($mycwal['cwallet']) - floatval(intval($valAmt)));
										if($proqry = $conn->query("UPDATE users SET bal='$comsum',cwallet='$commins' WHERE email='$user'")){
															
										echo '<div class="alert alert-success">Commission was successfully moved to primary wallet</div>';
																	}	
																	}else{

																	echo '<div class="alert alert-danger">Insufficient commission</div>';	
																	}	
																}
																?>     
                                                    Commission: <h3 class="badge badge-pill badge-info"> <?php echo ' &#x20A6;'.number_format($data['cwallet'],2,'.',',');?></h3>
      <a href="#" class="btn btn-primary rounded"  title="Move commission to main wallet" data-toggle="modal" data-target="#comWallet">Move</a> </span></h3>    
                                                </div>
                                            </div>
                                            <div class="col-l-3 col-md-3 col-md-3 col-sm-6 col-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h3 class="mb-1"><?php echo ' &#x20A6;'.number_format($bal,2,'.',',');?></h3>
                                                        <p>Wallet Balance</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-l-3 col-md-3 col-md-3 col-sm-6 col-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h3 class="mb-1"><?php echo '&#x20A6;'.number_format($NEWithdraw,2,'.',',');?></h3>
                                                        <p>Withdrawals</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-l-3 col-md-3 col-md-3 col-sm-6 col-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h3 class="mb-1"><?php echo '&#x20A6;'.number_format($com_w,2,'.',','); ?></h3>
                                                        <p>My Earnings </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-l-3 col-md-3 col-md-3 col-sm-6 col-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h3 class="mb-1"><?php echo $Refer_total; ?></h3>
                                                        <p>My Referrals</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        
                                      <!-- end customer acquistion  -->
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Transaction History</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <canvas id="graphCanvas" style="height:400px" class="table"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>      
                                      
                                    
                                       
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="tab-pane fade" id="pills-airtime" role="tabpanel" aria-labelledby="pills-airtime-tab">
                                        <div class="row">
                                            
                                                
                                    <?php include('inc/service_list_airtime.php');?>     
                                                
                                        
                                              
                                       </div>    
                                         
                                    </div>
                                    
                                     <div class="tab-pane fade" id="pills-data" role="tabpanel" aria-labelledby="pills-data-tab">
                                        <div class="row">
                                            
                                                
                                    <?php include('inc/service_list_data.php');?>     
                                                
                                        
                                              
                                       </div>    
                                         
                                    </div>
                                    
                                    
                                    <div class="tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
                                        <div class="row">
                                          <?php include('inc/service_list_bill.php');?> 
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="tab-pane fade" id="pills-msg" role="tabpanel" aria-labelledby="pills-msg-tab">
                                        <div class="row">
                                         
                                         <?php include('inc/service_list_others.php');?>               
                                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end campaign tab one -->
                            <!-- ============================================================== -->
                        </div>
                        <!-- ============================================================== -->
                        <!-- end campaign data -->
                        <!-- ============================================================== -->                
                            
                            <!-- ============================================================== -->
                      
                            <!-- ============================================================== -->
                        </div>
                        <div class="row">
                            <!-- ============================================================== -->
              				                        <!-- product category  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- end product category  -->
                            <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>
  	<script type="text/javascript">
		//datepicker plugin
		//link	
		$('#sendWithPhoneBook').click(function(e){
		    $('#pb_groups').css('display','block');
		    e.preventDefault();
		});

		$("input[type=checkbox].grp_select").change( function() {
		    if($(this).is(":checked")){
		    	var bin = chkK();
		    		$("#grp_select_check").html('+'+bin+' Selected Phonebook Group Recepient(s)');	       	
			}else{
				var bin = chkK();
				if (bin > 0) {
					$("#grp_select_check").html('+'+bin+' Selected Phonebook Group Recepient(s)');
				}else{
					$("#grp_select_check").html('');
				}
			}
	  	});

		function countDest(){
			destcount = jQuery("#recipient").val();
			destcount = destcount.split(' ').join(',').split("\n").join(',').split(',,').join(',');
			// console.log(countUnit());
			destcount = destcount.split(',').length;
			if(destcount < 2) jQuery("#destcount").html(destcount+" recipient typed");
			else jQuery("#destcount").html(destcount+" recipients typed");
			$('#hiddenCount').html(destcount);
			// return destcount;
		}

		function chkK() {
			var val = [];
			$(':checkbox:checked').each(function(i){
	          val[i] = $(this).val();
	        });
	        return (val.length);
		}



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

		
		$('#recipient').keyup(function(){
			if (this.value.length > 0) {
				$('#destcount').css('display','block');
				countDest();
			}else{
				$('#destcount').css('display','none');
			}
		});
		
		function showUsage(messagesCount) {
			var x = jQuery('#paget').html()+", "+jQuery('#destcount').html()+"\nSend Message? Duplicate Numbers will be removed";
			return confirm(x);
		}
		function showUsageFree(messagesCount) {
			var x = jQuery('#paget').html()+", "+jQuery('#destcount').html()+"\nSend Message. You are using Free SMS Units and it ll contain an Advert?";
			return confirm(x);
		}
		$('#myForm input').on('change', function() {
		   var oname = ($('input[name="mode"]:checked', '#myForm').val()); 
		   // alert(oname);
		   if (oname =='sms') {
		   		$('#emailbox').css("display","none");
		   		$('#smsbox').css("display","block");
		   }else if(oname =='email'){
		   		$('#smsbox').css("display","none");
		   		$('#emailbox').css("display","block");
		   }
		});
		$('#form-field-select-1').on('change',function () {
			var selectVal = $('#form-field-select-1').val();
			if (selectVal == '4') {
				$('#date-range').css("display","none");
				$('#wallet-range').css("display","block");
			}else{
				$('#date-range').css("display","block");
				$('#wallet-range').css("display","none");
			}
		});
		</script>
		<script type="text/javascript">
	$(function() {
	    var scntDiv = $('#more-xtra');
	    var i = $('#more-xtra div').length + 1;
	    $('#addScnt').on('click', function() {
	    	// alert('ooooo');
	    	console.log(i);
	    	$('#addScnt').html('Add More Date');
	        $('<div id="extr" class="form-group"><label class="col-md-4 control-label">Schedule Date</label><div class="col-md-8"><div class="input-group"><input type="datetime-local" value="2019-11-05T18:18" id="example-input2-group1" name="schedule_date[]" class="form-control" placeholder="Email"><span  id="remScnt"class="input-group-addon"><i class="fa fa-minus"></i></span></div></div></div>').appendTo(scntDiv);
	        i++;
	        return false;
	    });
	    
	    $('#more-xtra').on('click','#remScnt' ,function(e) { 
	    	// alert(i);
	        // if( i > 2 ) {
	        	$('#more-xtra #extr:last').remove();
	            i--;

	        // }
	        e.preventDefault();
	        return false;
	    });
	});

	</script>



                                   <!-- product sales  -->
   <!-- Modal -->
   <div class="modal fade" id="comBank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Corporate Account Details</h5>
                                                                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </a>
                                                            </div>
                                         <div class="modal-body">
                                                              
															
																
															
                                                            </div>
                                                            <div class="modal-footer">
                                                                <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                            <!-- ============================================================== -->
                         
                        </div>

                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- sales  -->
                            <!-- ============================================================== -->
                            
                      
                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- total revenue  -->
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
            <script src="js/graphchart.js"></script>
            <?php include('inc/footer.php');?>
            