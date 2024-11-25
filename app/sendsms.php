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
                                <h2 class="pageheader-title">Bulk Messaging </h2>
                        
                               
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
                                    <h5 class="card-header">Compose SMS</h5>
                                    <div class="card-body">
                                    
                               
<?php
									
function smscharges($conn){
	        $qryCharge = $conn->query("SELECT * FROM charges WHERE service='bulksms'");
	        $sms_com = $qryCharge->fetch_assoc();
	        return json_encode($sms_com);
	    }
	    
$unitCharge = json_decode(smscharges($conn))->api;	    
									
if(isset($_POST['send'])){
$from = $_POST['sender'];
$sendto = $_POST['sendto'];
$txt = $_POST['message'];
$schedule = $_POST['sendlater'];
										
$reff = mt_rand(200888544,748988444);
										
$Charlen = strlen($txt);
			
			 $sms_array = explode("," , $sendto);
			  
			  $no = count($sms_array);
			  
			  if($Charlen <='160'){
				  
				 $bi = $unitCharge; 
				  }elseif($Charlen <='320'){
					  
					$bi = strval(floatval($unitCharge) * 2);  
					  }elseif($Charlen <= '480'){
						  
						$bi = strval(floatval($unitCharge) * 3);  
						  }elseif($Charlen <= '640'){
							
							$bi = strval(floatval($unitCharge) * 4);  
							  
						  }else{
							  
							$bi = strval(floatval($unitCharge) * 10);  
							  }

				$debit = strval(floatval($bi) * floatval($no));
				
				
			if(!empty($from) &&!empty($sendto) && !empty($txt) ){
											
									
			if($bal >= intval($debit)){
										    
		// debit ACCOUNT
		
			
			  $current_balance = strval(floatval($bal) - floatval($debit));
	    
		
			
		function debitWallet($conn, $current_balance, $user){	
		$qry_debit = "UPDATE users SET bal='$current_balance' WHERE email='$user'";
			$doDebit = $conn->query($qry_debit);
			return $doDebit;
		}
			

    
$dest = $sendto;

$dlr = "";


function sendSMS($from,$sendto,$txt,$reff){
    global $conn;
 $smskey = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
$smk = $smskey->fetch_object();  
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.epins.com.ng/v2/autho/messaging/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode(array(
    "apikey" => $smk->privatekey,
    "sender" => $from,
    "recipient" => $sendto,
    "message" => $txt,
	"ref" => $reff
)),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
curl_close($curl);
return json_decode($response);
}


$MSResponse =  sendSMS($from,$sendto,$txt,$reff);

switch ($MSResponse->code){
    case '101':
   debitWallet($conn, $current_balance, $user); 
   echo $msg_stat = '<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Message Sent</strong> 
									</div>';
        break;
        
        default:
 
 echo $msg_stat = '<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Message sending failed</strong> 
									</div>';          
            
}

$settime = date('d-m-Y H:m:s');

$action = "View Report";

$stor = mysqli_query($conn, "INSERT INTO message_history(mobile,username, sender,message,refid,status,senttime,action,charge) VALUES('$dest','$user','$from','$txt','$reff','$dlr','$settime','$action','$debit') ");   
        
			
				 
                                        
                                  
											      
                               
			
											}else{
												
										echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Insufficient Balance</strong> 
									</div>';
											}	
											}else{
												echo'<div class="alert alert-danger">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Enter required field</strong>  
									</div>'; }
										
										$conn->close();
										
									}
									 ?>                   
                                     
                                     
                                     
                                        <form method="post" action="">
                                            <div class="form-group">
                                                <label for="inputText3" class="col-form-label">Sender ID</label>
                                                <input id="inputText3" type="text" class="form-control" name="sender">
                                            </div>
                       
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Receipient</label>
                                                <textarea class="form-control" id="sendto" rows="8" name="sendto"  ></textarea>
                                            </div>
                                            
                                            
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="method"  class="custom-control-input" value="card" onclick="javascript:cont();" id="phonebook"><span class="custom-control-label">Send to saved contact</span>
                                            </label>
                                            
                                            
                                             
                                                
                                               
                               
			            <div class="form-group">
			                <label class="col-lg-2 col-md-12 control-label"></label>
			                <div class="col-lg-8 col-md-12">
			                	<p><strong id="destcount"></strong> <strong id="grp_select_check"></strong></p>  
			                </div>
			            </div>
                                
                                
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Message</label>
                                                <textarea class="form-control" id="message" onchange="countMsgsText(this.value);" onkeyup="countMsgsText(this.value);" rows="7" name="message"></textarea>
                                            </div>
                                       
                                        <div class="form-group">
			                <label class="col-lg-2 col-md-12 control-label"></label>
			                <div class="col-lg-8 col-md-12">
			                <div>
			                	<b id="paget"></b>
			                	<b id="count"></b>
			                </div>                
							<div class="hidden" id="hiddenCount"></div>    
			                </div>
                               </div> 
                               
                                
       <label class="col-lg-2 col-md-12 control-label">Sending Route</label>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" checked="" name="route"  class="custom-control-input" value="3"><span class="custom-control-label">Normal</span>
                                            </label>
                                            
                                            
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="route" class="custom-control-input"value="4"  onClick="alert('You must register corporate ID to use this ')"><span class="custom-control-label" >Corporate</span>
                                            </label> 
                                            
       <label class="col-lg-2 col-md-12 control-label">Message Type</label>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" checked="" name="msgtype"  class="custom-control-input" value="0"><span class="custom-control-label">Inbox</span>
                                            </label>
                                            
                                            
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="msgtype" class="custom-control-input"value="1" ><span class="custom-control-label" >Flash</span>
                                            </label>
                               
                                  
         <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" name="schedule"  class="custom-control-input" value="card" onclick="javascript:cont();" id="schedule"><span class="custom-control-label">Schedule Message</span>
                                            </label>
                                            
                                            
                                             
                                                <input type="date" class="form-control" id="sendlater" style="display:none" name="sendlater" > 
                                                
                                          
												
                                                <p></p>                      
                               
                                     <div class="col-sm-6 pl-0">
                                                <p class="text-right">
                                                    <button type="submit" name="send" class="btn btn-space btn-primary">Send Message</button>
                                                    
                                                </p>
                                            </div> 
                                             
                                            <p></p>     
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->
                            
                            <script>
                                
                             
 function cont() {
    if (document.getElementById('phonebook').checked) {
        document.getElementById('ifYes').style.display = 'block';
    }
    else  document.getElementById('ifYes').style.display = 'none';
    
    
   if (document.getElementById('schedule').checked) {
        document.getElementById('sendlater').style.display = 'block';
    }
    else  document.getElementById('sendlater').style.display = 'none'; 
   
}    
                      
   $("#sendto").on("keyup", function() {
  $(this).val($(this).val().replace(/[\,\-\n]/g, ","));
});           
                                
                            </script>

    
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- customer acquistion  -->
                            <!-- ============================================================== -->
                             <?php include('inc/sidebar.php'); ?>
                            <!-- ============================================================== -->
                            
                            
                            
                            <!-- end customer acquistion  -->
                      
                        
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
           <?php include('inc/footer.php');?>