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
							
										$network = trim($_SESSION['carier']);
										$sendto = trim($_SESSION['sendto']);
										$requestId = trim($_SESSION['transid']);
										$amount = floatval(abs($_SESSION['amt']));
								        $SenderPhone = trim($_SESSION['Userphone']);
	                       
						$token = uniqid();
						$stat = "Completed";
						$channel = "Wallet";				
						$senderName = $fname.' '.$lname;
									
					
					$clientName = $fname.' '.$lname;
					
					function FetchSender($conn,$email){
$qrSender = $conn->query("SELECT * FROM users WHERE email='$email'"); 
$se = $qrSender ->fetch_assoc();
return json_encode($se);
}
	
function FetchReceiver($conn,$sendto){
$qrRecev = $conn->query("SELECT * FROM users WHERE email='$sendto' OR phone='$sendto'"); 
$re = $qrRecev ->fetch_assoc();
return json_encode($re);
}				
			
					if($email === $sendto or $Phone === $sendto ){
				?> <script>
	
Swal.fire({
  icon: 'error',
  title: 'Declined',
  text: 'Transaction  Declined'
 
})

</script> 

<?php 	
					}else{	
							
				
					$json_sen = json_decode(FetchSender($conn,$email));
					$source_wallet = floatval($json_sen->bal);
					$json_to = json_decode(FetchReceiver($conn,$sendto));
					$toFName = $json_to->firstname;
					$toLName = $json_to->lastname;
					$receiverFullName = $toFName.' '.$toLName;
                    $toEmailAdd = $json_to->email;
                    $toPhone = $json_to->phone;
                    $dest_wallet = floatval($json_to->bal);
                
						$sc_fee = strval(floatval(1.5/100)* floatval($amount));
						$Xfee = $sc_fee;				
						$sendDate = date('d-m-Y H:m:s');
		
							$pnt = "Wallet Transfer";
							$img = "wallet-transfer.jpg";
						
					// Get Site name
				
			      $json_siteName  = json_decode(sitename($conn));
                $sitname = $json_siteName->sitename;
			        $amountKobo = number_format($amount,2,'.',',');	
					
                            $debit = strval(floatval($amount) + floatval($Xfee));					
							$newBalc = strval(floatval($source_wallet) - floatval($debit));
							
							$ReceiveBalc = strval(floatval($dest_wallet) + floatval($amount));
							
					}
					// close check validate
					
							if(isset($_POST['pay'])){
							if($debit <= floatval($source_wallet)){	
									
				// Debit Sender Account	
		    DebitSource($conn,$newBalc,$email);
			// Credit Receiver's account
			if(creditDest($conn,$ReceiveBalc,$toEmailAdd)){
			
				// Store Transaction History
		SenderTransaction($conn,$pnt,$SenderPhone,$requestId,$token,$amount,$debit,$email,$stat,$clientName,$network,$channel,$newBalc);		
       // Store for receiver History
    ReceiverTransaction($conn,$pnt,$SenderPhone,$requestId,$token,$amount,$toEmailAdd,$stat,$clientName,$network,$channel,$ReceiveBalc);
        
		
 								
			?>
<script>
Swal.fire("Transfer Successful", "<?php echo 'N';echo $amount;?> has been successfully credited to <?php echo $toFName ?> <?php echo $toLName ?>", "success",{
  buttons: ["Cancel", "Ok"],
}).then(okay => {
   if (okay) {
    window.open('../../transaction-history','_self');
  }
  
}); </script>  <?php 						
									
											
						
				// Send Notification
					
				$serName = $_SERVER['SERVER_NAME'];

MailRceiver($conn,$serName,$receiverFullName,$amount,$sitname,$senderName,$requestId,$sendDate,$email,$toEmailAdd);

									
			}								
					
				} else{  echo'
								
								<script>
							setTimeout(function(){ window.location.href="../../add-fund.php" }, 3000);</script>	
									
									'; 
									
   ?> <script>
			  
	Swal.fire({
  title: "Insufficient Balance",
  text: "Please credit your wallet and try again",
  icon: "error"
  
});  </script> <?php       
                                       
                                       
                                   }    
                                        
								
                                }	
                                
	function sitename($conn){
			        $qrysit = $conn->query("SELECT sitename FROM settings");
			        $gsite = $qrysit->fetch_assoc();
			        return json_encode($gsite);
					}                       

function creditDest($conn,$ReceiveBalc,$toEmailAdd){
			 $desCash = $conn->query("UPDATE users SET bal='$ReceiveBalc' WHERE email='$toEmailAdd'");   
			  return $desCash;  
			}
			
			function DebitSource($conn,$newBalc,$email){
			 $SourceCash = $conn->query("UPDATE users SET bal='$newBalc' WHERE email='$email'");   
			  return $SourceCash;  
			}
			
				function SenderTransaction($conn,$pnt,$SenderPhone,$requestId,$token,$amount,$debit,$email,$stat,$clientName,$network,$channel,$newBalc){		
        $stmtTrans = $conn->query("INSERT INTO transactions(network,phone,ref,refer,amount,charge,email,status,token,customer,servicetype,channel,newBal)VALUES('$pnt','$SenderPhone','$requestId','$token','$amount','$debit','$email','$stat','$token','$clientName','$network','$channel','$newBalc')");
         return $stmtTrans;
    
		}
	 
	 function ReceiverTransaction($conn,$pnt,$SenderPhone,$requestId,$token,$amount,$toEmailAdd,$stat,$clientName,$network,$channel,$ReceiveBalc){		
        $stmtTrans = $conn->query("INSERT INTO transactions(network,phone,ref,refer,amount,charge,email,status,token,customer,servicetype,channel,newBal)VALUES('$pnt','$SenderPhone','$requestId','$token','$amount','$amount','$toEmailAdd','$stat','$token','$clientName','$network','$channel','$ReceiveBalc')");
         return $stmtTrans;
    
		}


function MailRceiver($conn,$serName,$receiverFullName,$amount,$sitname,$senderName,$requestId,$sendDate,$email,$toEmailAdd){									
				// send email
$from = "$sitename<no-reply@$serName>"; 
//the email address from which this is sent
$to = "$toEmailAdd"; //the email address you're sending the message to
$subject = "You have Receive Money"; //the subject of the message

// To send HTML mail, the Content-type header must be set
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "Return-Path: $sitname<no-reply@$hosturl>\r\n";
$headers .= "Organization: $sitname\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$message = "

<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
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



<h3>Dear $receiverFullName,</h3>

You have received N$amount in your $sitname wallet from $senderName<br>

<strong>Below are the transaction details:</strong> <p>

<table class='table' >
  
   <tr>
    <td>Sender Name</td>
    <td>$senderName</td>
  </tr>
  <tr>
    <td>Amount</td>
    <td> N$amount</td>
  </tr>
  
  <tr>
    <td>Transaction ID</td>
    <td> $requestId</td>
  </tr>
  
  <tr>
    <td>Transaction Date</td>
    <td> $sendDate</td>
  </tr>
  
</table> <p>


If you have any question regarding this transaction please.<p>
 
 <strong>Email:</strong> $senderName : $email
<p>


Regards, <p>


$sitname

</body><html>";

//now mail
$DoMail = mail($to,$subject,$message,$headers);	
return $DoMail;
}	 
?>
                       
   
<?php $tranDetail = "Please Confirm Your Transaction Details";?>
 
 <form method="post" action="#" >
                               
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
							<img src="../../assets/images/icon_image.png" width="100" height="100" > 
							
							
							
							</td>
                        </tr>'; 
                         
                         
                      }
                      
                      
                      
                      ?>  
                        
                        <?php echo $lgo; ?>
                        
                        
                        <?php echo $prod; ?>
                        
                          <tr>
                        <td width="30%">Receiver's Name:</td>
                        <td><?php echo $toFName.' '.$toLName;?>  </td>
                    </tr>
                    
						<tr>
                        <td width="30%">Receiver's Phone Number:</td>
                        <td><?php echo $toPhone; ?>  </td>
                    </tr>
                    
					<tr>
                        <td width="30%">Receiver's Email Address:</td>
                        <td><?php echo $toEmailAdd; ?>  </td>
                    </tr>
                    
                    <tr>
                        <td width="30%">Amount:</td>
                        <td><?php echo ' &#x20A6;'.$amountKobo.' '?> +  ₦<?php echo $Xfee ?>.00 <i class="conv_fee">
                            
                                                                (charges)
                                                        
                        </i>  </td>
                    </tr>
                                          
                     <tr>
                        <td width="30%">Total Payable Amount:</td>
                        <td><?php echo ' &#x20A6;'.$debit.' '?>  </td>
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
var countDownDate = new Date("Jan 5, 2025 15:37:25").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 0));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 1)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 5)) / (1000 * 60));
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
                      
                          <?php include('../../inc/recent-transaction-widget.php'); ?>
                          
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
