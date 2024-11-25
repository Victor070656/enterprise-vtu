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
                    <!-- ============================================================== -->
                    
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title"><li class="fa fa-exchange-alt"></li> Wallet to Wallet Transfer </h2>
                        
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
								
			
									if(isset($_POST['sendfund'])){
									
										$amount = test_input($_POST['amt']);
										$network = trim("wallet-transfer");
										$sendto = test_input($_POST['toemail']);
										if(!empty($amount) && !empty($sendto) ){
										
										$uid = substr(str_shuffle("0123456789678901"), 0, 16);	
									
									
									$str1 = $amount;
									$xamount = str_replace( ',', '', floatval($str1));
											
										if($xamount >= 100){	
										
											$token = uniqid();
											$stat = "pending";
											
				// replace comma
		
			if($sendto === $email or $sendto === $Phone){
											
		?> <script>
	
Swal.fire({
  icon: 'error',
  title: 'Declined',
  text: 'You can not transfer money to yourself'
 
})

</script> 

<?php 								
  				} else if(checkAccount($conn,$sendto) > 0 ){		
					

$destination = json_decode(FetchReceiver($conn,$sendto));								
	// Store value to transfer
	strval($_SESSION['ServiceName'] = "Wallet Transfer");
	strval($_SESSION['Userphone'] = $destination->phone);
        $_SESSION['amt'] = floatval($xamount);
		$_SESSION['carier'] = $network;
		$_SESSION['sendto'] = $sendto;
		$_SESSION['transid'] = $uid;

								?>
                                <script>
								
                                window.location="transaction-view/wallet-transfer?<?php echo $uid; ?>#transPreview";
                                </script>
                                <?php
									
					
								}else{		
										
	?> 
	
	<script>

Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Receiver account not found'
 
})
</script> 

<?php			
			}
								
								
 
							}else{ 
                                   
                                 
									
     ?> <script>
	 
Swal.fire({
  icon: 'error',
  title: 'Declined',
  text: 'Minimum amount you can transfer is N100'
 
})

</script>
<?php       
                                       
                                   }    
                                        
								
                                }	else{
									?>	
									<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Enter required fields</strong>  
									</div>';
									<?php 
								
									}
								}
						
						
function FetchReceiver($conn,$sendto){
$qrSend = $conn->query("SELECT * FROM users WHERE email='$sendto' OR phone='$sendto'"); 
$se = $qrSend ->fetch_assoc();
return json_encode($se);
}

function checkAccount($conn,$sendto){
$qrch = $conn->query("SELECT * FROM users WHERE email='$sendto' OR phone='$sendto'"); 
$usrcheck = $qrch->num_rows;
return $usrcheck;
}


									 ?>
										

                        	<!-- Interswitch Test-->									
										
                                    <form method="post" id="TransTable">
                                        
                                        <p></p>
                                        <div class="float-center">
                                        <img style="display:none;" id="bigpic" src="bigpic" width="120"  height="90"/>     
                                                   
                                    </div>
                                        
                                  <div class="form-group">
          <label for="inputText3" class="col-form-label">Enter Receiver's Email or Phone Number</label>
    <input id="inputText3" type="text" class="form-control" name="toemail" required>
                                            </div>    
										
										
                                        <label for="inputText3" class="col-form-label">Enter Amount</label>    
                                       <div class="input-group mb-3">
                                                <div class="input-group-prepend"><span class="input-group-text">&#x20A6;</span></div>
                                                <input type="number" class="form-control" name="amt" required min="0" oninput="this.value = Math.abs(this.value)">
                                                <div class="input-group-append"><span class="input-group-text">.00</span></div>
                                                
                                                
                                            </div>      
                                           
                                           
                                     <div class="col-sm-6 pl-0">
                                         
                                                <p class="text-center">
                                                    <button type="submit" name="sendfund" class="btn btn-rounded btn-primary">Proceed</button>
                           <button class="btn btn-rounded btn-secondary">Cancel</button>                    
                                                
                                                   
                                                </p>
                                                
                                                <p align="center">
                                                    
                                                
                                                     </p>
                                               
                                            </div>   
										
                                        </form>
                                       
                                  <script>
                           
						   function show9mobile() {
  var sourceOfPicture = "assets/images/9mobile.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
  
} 
                   
function showMTN() {
  var sourceOfPicture = "assets/images/mtn.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
} 

function showAirtel() {
  var sourceOfPicture = "assets/images/airtel.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
} 

function showGlo() {
  var sourceOfPicture = "assets/images/glo.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
} 
									  
function showntel() {
  var sourceOfPicture = "assets/images/ntel-airtime.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
} 
                    
                                  </script>
                                        
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
 
 
 
 function yesnoCheck() {
    if (document.getElementById('yescard').checked) {
        document.getElementById('ifYes').style.visibility = 'visible';
    }
    
     if (document.getElementById('yescash').checked) {
        document.getElementById('ifYes').style.visibility = 'visible';
    }
    
     if (document.getElementById('yesbitcoin').checked) {
        document.getElementById('ifYes').style.visibility = 'visible';
    }
    
    

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
                            <!-- ============================================================== -->
              				                        <!-- product category  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- end product category  -->
                          
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
            <?php include('inc/footer.php');  ?>