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
							
							if(isset($_GET['ref'])){
								       echo'<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transaction successful</strong>  
									</div>'; 
									
									echo '<script>
									setTimeout(function(){ window.location.href="../../dashboard.php" }, 3000);</script>';
									      
								        }
										
									
								        
										$usern = $_SESSION['user'];
										
										$network = $_SESSION['carier'];
										$sendto = $_SESSION['sendto'];
										$requestId = $_SESSION['transid'];
										$amount = floatval($_SESSION['amt']);
										
						$clientName = $data['email'];
										
							$senderfName = $data['firstname'];
							$senderlName = $data['lastname'];			
										
						$QryWal = mysqli_query($conn,"SELECT * FROM users WHERE email='$sendto'");
							$wTo = mysqli_fetch_array($QryWal);			
							
						$toFName = $wTo['firstname'];
						$toLName = $wTo['lastname'];
						$toPhone = $wTo['phone'];
										
						
						$trans = mysqli_query($conn,"SELECT * FROM transactions WHERE ref='$requestId' ");					
					$rowTrans = mysqli_fetch_array($trans);	
					
										$sendDate = date('d-m-Y H:m:s');
		
							$pnt = "Bank Transfer";
							$img = "wallet-transfer.jpg";
							
						
									$amountKobo = number_format($amount,2,'.',',');	
										
							if($_SERVER['REQUEST_METHOD'] === 'POST'){
									if(isset($_POST['pay'])){
										
										
										$debit = floatval($amount);	
										
										$uid = substr(str_shuffle("0123456789678901"), 0, 16);		
											
										if(floatval($debit) <= floatval($bal)){	
											$dat = date("d/m/Y");
											
											$token = uniqid();
											$stat = "pending";
											
						$current_balance = strval(floatval(intval($bal)) - floatval(intval($debit)));					
			$qry_debit = "UPDATE users SET bal='$current_balance' WHERE email='$user'";
			$doDebit = $conn->query($qry_debit);	
											
					
					$current_recipient = strval(floatval(floatval($bal)) + floatval(floatval($amount)));
					$adsub = mysqli_query($conn,"UPDATE users SET bal='$current_recipient' WHERE email='$sendto' ");
						
											
					$qsel = "UPDATE transactions SET status='Completed',token='0',refer='0',channel='Wallet',amount='$amount',charge='$debit' WHERE ref='$requestId' ";	
$sav = $conn->query($qsel);						
 				
					echo'<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Transfer Successful</strong> 
									</div>
									
							<p align="center"> <img src="../../assets/images/npe-redirecting.gif"></p>		
							<script>
							setTimeout(function(){ window.location.href="../../dashboard.php" }, 3000);</script>		
									
									';						
											
						
				// Send Notification
											
											
				$sitname = $sit['sitename'];
				$hosturl = $_SERVER['HTTP_HOST'];
									
				// send email

$from = "$sitname<no-reply@$hosturl>"; //the email address from which this is sent
$to = "$sendto"; //the email address you're sending the message to
$subject = "Wallet Credit Notification"; //the subject of the message

// To send HTML mail, the Content-type header must be set
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "Return-Path: $sitname<support@$hosturl>\r\n";
$headers .= "Organization: $sitname\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$message = "

<html>
<head>
<style>
.table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 50%;
}

td {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}


.button {
  background-color: #008CBA; /* Blue */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  border-radius: 8px;
  cursor: pointer;
  
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
}

.button:hover {
  background-color: #4CAF50; /* Green */
  color: white;
}

</style>
</head>

<body>



<h3>Dear $toFName,</h3>

You have receive N$amount in your $sitname wallet from $senderfName $senderlName <br>

<strong>Below are the transaction details:</strong> <p>

<table class='table' >
  
   <tr>
    <td>Sender Name</td>
    <td>$senderfName $senderlName</td>
  </tr>
  <tr>
    <td>Amount</td>
    <td> N$amount</td>
  </tr>
  
  <tr>
    <td>Transaction ID</td>
    <td> N$requestId</td>
  </tr>
  
  <tr>
    <td>Transaction Date</td>
    <td> N$sendDate</td>
  </tr>
  
</table> <p>


If you have any question regarding this transaction please.<p>
 
 <strong>Email:</strong> $clientName 
<p>


Regards, <p>


$hosturl

</body><html>";

//now mail
$DoMail = mail($to,$subject,$message,$headers);					
											
												
										}
                                   else{echo'<div class="alert alert-warning">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>[ Insufficient Balance ]</strong>, <a href="../../add-fund.php">Click here to credit wallet </a> 
									</div>';  }    
                                        
								
                                }	}
                                
                       


	 
?>
                       
   
<?php $tranDetail = "Please Confirm Your Transaction Details";?>
 
 <form method="post" autocomplete="off">
                               
<h2 class='margin-tp-10' align="center"><li class="fa fa-money-bill-alt"></li> <?php echo $tranDetail; ?> </h2>     
                                      
                                        
                              <table class="table  margin-tp-10" id="transTable">
                     
                      <?php 
                      $Netary =  array("wallet-transfer","airtel","9mobile","glo");
                      
                      
                      
                      if(in_array($network,$Netary)){
                          
                         $prod = '<tr>
                            <td width="30%">Product</td>
                            <td id="mainService">'.$pnt.'  </td>
                        </tr>'; 
                        
                       $lgo = '<tr>
                            <td width="30%"> </td>
                            <td id="mainService">
							<img src="../../assets/images/wallet-transfer.jpg" width="250" height="150" > 
							
							
							
							</td>
                        </tr>'; 
                         
                         
                      }
                      
                      
                      
                      ?>  
                        
                        <?php echo $lgo; ?>
                        
                        
                        <?php echo $prod; ?>
                        
                          <tr>
                        <td width="30%">Receiver's Name:</td>
                        <td><?php echo $toFName;  echo $toLName;?>  </td>
                    </tr>
                    
						<tr>
                        <td width="30%">Receiver's Phone Number:</td>
                        <td><?php echo $toPhone; ?>  </td>
                    </tr>
                    
					<tr>
                        <td width="30%">Receiver's Email Address:</td>
                        <td><?php echo $sendto; ?>  </td>
                    </tr>			  
                                          
                     <tr>
                        <td width="30%">Total Payable Amount:</td>
                        <td><?php echo ' &#x20A6;'.$amountKobo.' '?>  </td>
                    </tr>
                    
                        <tr>
                        <td width="30%">Transaction ID:</td>
                        <td><?php echo $requestId; ?>  </td>
                    </tr>
						
								  
								  <tr>
                        <td width="30%">Time Left to Complete Transaction</td>
                        <td><?php echo '<strong id="timing">' ?></td>
                    </tr>    
								  
                                            <tr>
                            <td colspan="2">
								
								
								
                                                                                            
                                <div class="pay-button">
                                                                                                                                                                                                                                
                                </div>
                              							               </td>
                        </tr>
                                    </table>              
                                         
                                        
                                     <div class="col-sm-6 pl-0">
                                         
                                                <p class="text-center">
                                                    <button type="submit" name="pay" class="btn btn-rounded btn-primary"><i class="fas fa-fw fa-money-bill-alt"></i> Transfer</button>
                    
                                              
                       
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
        
									  

									  
		
	function  func(){
      	
	$('#IsMtn').change(function(){
	  var selected = $(this).find('option:selected');
	  var amount = selected.data('amount');
	  var exp = selected.data('duration');
	  
	  $('#amount').val(amount);
	  $('#exp').val(exp);
	  
	  }); 
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
                            <?php include('../../inc/sidebar.php'); ?>
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