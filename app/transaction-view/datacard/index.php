<?php 
ob_start();
session_start();
session_regenerate_id();
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
                    <!-- ============================================================== -->
                    
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
						          
										$username = $_SESSION['user'];
										$amount = floatval(abs($_SESSION['amt']));
										$network = $_SESSION['carier'];
										$qty = $_SESSION['phone'];
										$requestId = $_SESSION['transid'];
										
										$plan = $_SESSION['plan'];
										$serviceType = "datacard";
										$variation_code = $_SESSION['variation_code'];
									$serName = $_SERVER['HTTP_HOST'];
								$valu = $_SESSION['label'];
								$img = $_SESSION['img'];		
								$txtadmin = $settings['mobile'];		
							
						
			
		$trans = mysqli_query($conn,"SELECT * FROM transactions WHERE ref='$requestId' ");					
        $rowTrans = mysqli_fetch_array($trans);	
        $ftrow =  json_decode(fetchPackage($conn,$variation_code,$network),true);
     $network_fetch = $ftrow[0]['network'];
     $datatype_fetch = $ftrow[0]['datatype'];
     $plan_fetch = $ftrow[0]['plan'];
     $code_fetch = $ftrow[0]['plancode'];
     $userprice_fetch = floatval($ftrow[0]['price_user']);
     $apiprice_fetch = floatval($ftrow[0]['price_api']);
     $gateway_fetch = $ftrow[0]['gateway']; 
     $networkcode = strval(intval($network_fetch));
		if($level !== 'paid'){
     $payable = floatval($userprice_fetch) * floatval($qty);
     $discount = 0;
     } else { 
      $payable = floatval($apiprice_fetch) * floatval($qty);
      $discount = strval(floatval($userprice_fetch) - floatval($apiprice_fetch));
     }
  
					if($_SERVER['REQUEST_METHOD'] === 'POST'){	
						if(isset($_POST['pay'])){
										
						$uid = mt_rand(784755,998937);
  	$prevBal = json_decode(bal_val($conn, $user));
			$debit = $payable;			
				if($debit <= floatval($prevBal->bal)){	
				$dat = date("d/m/Y");
				$token = uniqid();
				$stat = "pending";
											
		$ret = mysqli_query($conn,"SELECT * FROM transactions WHERE ref='$requestId' ");
		$da = mysqli_fetch_array($ret);
		$tref = $da['ref'];
		
		if($da['refer'] === $da['token']){	
		
include('../../inc/datacard.php');
	if($apiRespone == '101' or $apiRespone === 'success' or $apiRespone === 'successful'){
	    
	  
	$current_balance = strval(floatval($prevBal->bal) - floatval($debit)); 
	 walletDebit($conn,$current_balance, $user);   

	 
$qsel = $conn->query("UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet',metertoken='$pins',servicetype='$serviceType' WHERE ref='$tref' ");	
			
	?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<strong>Transaction Successful</strong>  
									</div>
		 							
<script>
   
Swal.fire({
  title: 'Transaction Successful',
  html:
    'Your <?php echo $valu; ?> purchase is successful <b><?php echo $pins; ?>.</b> How to Load: Dial *460*6*1#, then enter the PIN shown on your MTN sim.',
  icon: 'success',
 showCancelButton: false,
  showDenyButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#3085d6',
  denyButtonColor: '#3085d6',
  confirmButtonText: 'Download PIN',
  denyButtonText: 'Print DATACARD',
  
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href="datacard_extractor.php";
  } else if(result.isDenied){
   
   window.location.href="../../datacard-printing?id=<?php echo $requestId;?>";   
      
  }
})
    
</script>
<?php
		
									
	}else if($apiRespone == '104'){ 
	    
	    ?>
<script>
Swal.fire({
icon: 'error',    
  title: '<?php echo $rp->description; ?>',
  showDenyButton: false,
  showCancelButton: true,
  confirmButtonText: 'Restart',
  
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
      
    window.location.href="../../datacard.php";
     
  } else if (result.isDenied) {
    Swal.fire('system busy', '', 'info')
  }
})
</script>
<?php
}else{
    
    
	 $qsel = "UPDATE transactions SET status='Failed',token='0',refer='0',channel='Wallet' WHERE ref='$tref' ";	
			$sav = $conn->query($qsel);
			
			
			echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction Failed. Please try again shortly</strong>  
									</div>'; 
									
		 ?>
<script>
Swal.fire({
icon: 'error',    
  title: 'Transaction Failed. Please try again!',
  showDenyButton: false,
  showCancelButton: true,
  confirmButtonText: 'Restart',
  
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
      
    window.location.href="../../datacard.php";
     
  } else if (result.isDenied) {
    Swal.fire('system busy', '', 'info')
  }
})
</script>
<?php
	    							
									
	}						
	
	
									
					} else{echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Error Occur: Please contact support@$serName</strong>  
									</div>';  }										
 
										}
                                   else{echo'<div class="alert alert-warning">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>[ Insufficient Balance ]</strong>, please pay with ATM card or <a href="../../add-fund.php">Click here to credit wallet </a> 
									</div>';  }    
                                        
								
                                }	}
                                
                       
					   if(isset($_POST['cardpay'])){
						   
			$uid = substr(str_shuffle("0123456789678901"), 0, 16);	

// payprocessor
 if($apib['activepay'] == 'paystack'){
include('../../inc/paystacksme.php');
 }else{
	 
include('../../inc/wavesme.php');	 
	 }
					
} 


	
		 function bal_val($conn, $user){
        $qrvalbal = $conn->prepare("SELECT * FROM users WHERE email=?");
        $qrvalbal->bind_param("s",$user);
        $qrvalbal->execute();
        $resultx = $qrvalbal->get_result();
        $fetchBal = $resultx->fetch_assoc();
        return json_encode($fetchBal);
    }	
			function walletDebit($conn,$current_balance, $user){  
	$Qdebit = $conn->prepare("UPDATE users SET bal=? WHERE email=?");
	$Qdebit->bind_param("ss",$current_balance,$user);
	$runexe = $Qdebit->execute();
	return $runexe;
	  }	
	  
	  function fetchPackage($conn,$variation_code,$network){
$qryPlan = $conn->query("SELECT * FROM data_package WHERE plancode='$variation_code' AND network='$network' AND datatype='datacard'"); 
while($prow[] = $qryPlan->fetch_assoc()){ }
return json_encode($prow);
}

function epins($conn,$network,$qty,$variation_code,$requestId){
    
    function fetchEpin($conn){
$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
$fetchepkey = $query_ep->fetch_assoc();
return json_encode($fetchepkey);
}    
$json_ep = json_decode(fetchEpin($conn));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, urlbasemain()."/"."datacard/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
'apikey' => $json_ep->privatekey,
'service' => 'datacard',
'network' => $network,
'pinQuantity' => $qty,
'DataPlan' => $variation_code,
'ref'	=> $requestId
)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",    
  
));

$EPINresponse = curl_exec($ch);
curl_close($ch); 

return $EPINresponse;
}


  
?>

 
 <form method="post" autocomplete="off" >
                               
<h2 class='margin-tp-10'>Please Confirm your Transaction Details:</h2>     
                                      
                                        
        <table class="table  margin-tp-10" id="transTable">
                     
                     
                       <tr>
                            <td width="30%"> </td>
                            <td id="mainService"><img src="../../assets/images/<?php echo $img; ?>" width="120" height="100" class="rounded-corners" >  </td>
                        </tr>
                        
                       <tr>
                            <td width="30%">Product</td>
                            <td id="mainService"><?php echo strtoupper($valu); ?>  </td>
                        </tr>
                        
                                                <tr>
                            <td width="30%">Qauntity</td>
                            <td><?php echo $_SESSION['phone'];?></td>
                        </tr>                   
                                                            <tr>
                        <td width="30%">Unit Price</td>
                        <td>₦<?php echo $userprice_fetch;?></td>
                    </tr>
                    
                    <tr>
                        <td width="30%">Discount</td>
                        <td>₦<?php echo $discount;?></td>
                    </tr>
                    
                                          
                    <tr>
                        <td width="30%">Total Payable Amount</td>
                        <td>₦<d id="total_amount"><?php echo strval(floatval($payable));?></d></td>
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
                                                                                            <div style="margin-top: 20px;"><strong>Choose Payment Method:</strong></div>
                                <div class="pay-button">
                                                                                                                                                                                                                                
                                </div>
                              							               </td>
                        </tr>
                                    </table>              
                                         
                                        
                                     <div class="col-sm-6 pl-0">
                                         
                                                <p class="text-center float-right">
                                                    <button type="submit" id="submit" name="pay" class="btn btn-rounded btn-primary"><i class="fas fa-fw fa-code"></i> Generate Data PIN</button>
                   
                                                
                       
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
                            
                             <script>
// Set the date we're counting down to
var countDownDate = new Date("Jan 5, 2021 15:37:25").getTime();

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
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Recent Transactions</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th>Transaction ID</th>
                                                
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
                                                
                                                <td><?php echo '&#x20A6;'.$trow['amount'].' ';?></td>
                                                 <td><?php echo $trow['status'];?></td>
                                                <td><?php echo $trow['date'];?></td>
                                                
                                            </tr>
                                           
                                           <?php } ?>
                                          
                                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Transaction ID</th>
                                                
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
                            <!-- ============================================================== -->
                            <!-- end sales  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- new customer  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- end new customer  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- visitor  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- end visitor  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- total orders  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- end total orders  -->
                            <!-- ============================================================== -->
                        </div>
                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- total revenue  -->
                            <!-- ============================================================== -->
  
                            
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- category revenue  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- end category revenue  -->
                            <!-- ============================================================== -->
                        </div>
                        <div class="row">
                          <!-- ============================================================== -->
                            <!-- end sales traffice source  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- sales traffic country source  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- end sales traffice country source  -->
                            <!-- ============================================================== -->
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