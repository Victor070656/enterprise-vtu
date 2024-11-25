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
                                <h2 class="pageheader-title"> API Documentation </h2>
                        
                               
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
                                    <p>&nbsp;</p>
                                    
                                    <h1 align="center"> <?php echo $settings['sitename']; $sitnam = $settings;?> API Documentation </h1>
                                  <p>&nbsp;</p>
                           <?php echo $settings['sitename'];?> API allows you to easily integrate bills payment services available on the <?php echo $settings['sitename'];?> platform on your mobile or web application.
                           
                           <p>&nbsp;</p>
                                   	<!--collapse start-->
            <div class="panel-group m-bot20" id="accordion">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                                      <a class="btn btn-info btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                             <i class="fa fa-link"></i>             Airtime VTU API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                  <div class="panel-body">
                    
                    <h1>VTU Airtime API Integration</h1>
This section contains your RESTful API for Airtime VTU API integration.

<p>&nbsp;</p>
<h4>Authentication</h4>
<p>The <?php echo $sitnam['sitename'];?> API uses API Key for Authentication.</p>

<p>Please use the following details for authentication</p>
<pre>Apikey = kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</pre>
<p><strong>API Key: </strong>Your Gateway API Key</p>
 Please create your API key here <a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>">Create API Key</a>
<p>&nbsp;</p>


<h3><strong>Purchase products</strong></h3>
Airtime VTU services can be purchased with the endpoint below:</p>
<p><strong>Base URL:</strong> https://<?php echo $request_dir; ?>/api/airtime</p>
<p><strong>Network: </strong>as specified in the parameters below;</p>
<p>&nbsp;</p>
<div class="table-responsive">
<table class="table table-bordered table-striped">
<tbody>
<tr>
<td width="150"><strong>PARAMETERS</strong></td>
<td width="150"><strong>Required/Optional</strong></td>
<td width="150"><strong>TYPE</strong></td>
<td width="150"><strong>DESCRIPTION</strong></td>
</tr>
<tr>
<td width="150">apikey</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">The reseller gateway API key created at <?php echo $_SERVER['SERVER_NAME'];?> . Example <strong>kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</strong></td>
</tr>
<tr>
<td width="150">network</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Network as specified. These includes, <strong>mtn</strong>,  <strong>airtel</strong>, <strong>glo</strong>, <strong>etisalat</strong></td>
</tr>
<tr>
<td width="150">phone</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The phone number to receive the airtime</td>
</tr>
<tr>
<td width="150">amount</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The amount you wish to recharge</td>
</tr>
<tr>
<td width="150">ref</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">This is a unique reference with which you can use to execute and query the transaction.</td>
</tr>
</tbody>
</table>
</div>
<p>&nbsp;</p>
<p><strong>SAMPLE </strong><strong>CODE</strong></p>

<pre>
$host="https://<?php echo $_SERVER['SERVER_NAME'];?>/api/airtime?apikey=1234&network=mtn&phone=0803992222&amount=100&ref=8284666332234 ";
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $host);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$data = curl_exec($ch);

//Close the cURL handle.
curl_close($ch);

$response = json_decode($data);

</pre>

<p>&nbsp;</p>

<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>
<pre>{"code":101,<br>"description":{"response_description":"TRANSACTION SUCCESSFUL",<br>"ref":"884666332234","amount":"100",<br>"transaction_date":"2020-04-17 07:04:19"<br>}}

</pre>


                    
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                                      <a class="btn btn-info btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                <i class="fa fa-link"></i>          Electricity Payment API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                  <div class="panel-body">
                        
                    <h1>Electricity Payment API Integration</h1>
This section contains your RESTful API for Electricity Payment API integration.

<p>&nbsp;</p>
<h4>Authentication</h4>
<p>The <?php echo $sitnam['sitename'];?> API uses API Key for Authentication.</p>

<p>Please see the following sample API key for authentication</p>
<pre>Apikey = kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</pre>
<p><strong>API Key: </strong>Your Gateway API Key</p>
 Please create your API key here <a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>">Create API Key</a>
<p>&nbsp;</p>

<h3><strong>VALIDATE METER NUMBER</strong></h3>
You can validate meter number with the following endpoint:</p>
<p><strong>Base URL: </strong>https://<?php echo $_SERVER['SERVER_NAME']; ?>/api/merchant-verify</p>
<p>&nbsp;</p>

<div class="table-responsive">
<table class="table table-bordered table-striped">
<tbody>
<tr>
<td width="150"><strong>PARAMETERS</strong></td>
<td width="150"><strong>Required/Optional</strong></td>
<td width="150"><strong>TYPE</strong></td>
<td width="150"><strong>DESCRIPTION</strong></td>
</tr>
<tr>
<td width="150">apikey</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">The reseller gateway API key created at <?php echo $_SERVER['SERVER_NAME'];?> . Example <strong>kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</strong></td>
</tr>
<tr>
<td width="150">service</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Service as specified. These includes, <strong>ikeja-electric</strong>, <strong>eko-electric</strong>, <strong>portharcourt-electric</strong>, <strong>jos-electric</strong>, <strong>kano-electric</strong>, <strong>ibadan-electric</strong></p>
</tr>
<tr>
<td width="150">smartNo</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The meter number to load the electricity token</td>
</tr>
<tr>
<td width="150">type</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">This is the meter type. Example: <strong>prepaid</strong> or <strong>postpaid</strong></td>
</tr>
</tbody>
</table>
</div>
<p><strong> </strong></p>
<p>&nbsp;</p>
<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>
<pre>{
    "code": 119,
    "description": {
        "Customer": "PAUL BECKY",
        "Address": "ELEME - PORTHARCOURT",
        "MeterNumber": "1022101199113"
    }
}

</pre>
<p>&nbsp;</p>

<h3><strong>Generate Token</strong></h3>
This endpoint allows you to generate electricity token using meter number.</p>
<p><strong>Base URL:</strong> https://<?php echo $request_dir; ?>/api/biller</p>
<p><strong>Service: </strong>as specified in the fields below;</p>
<p>&nbsp;</p>
<div class="table-responsive">
<table class="table table-bordered table-striped">
<tbody>
<tr>
<td width="150"><strong>PARAMETERS</strong></td>
<td width="150"><strong>Required/Optional</strong></td>
<td width="150"><strong>TYPE</strong></td>
<td width="150"><strong>DESCRIPTION</strong></td>
</tr>
<tr>
<td width="150">apikey</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">The reseller gateway API key created at <?php echo $_SERVER['SERVER_NAME'];?> . Example <strong>kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</strong></td>
</tr>
<tr>
<td width="150">service</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Service as specified. These includes, <strong>ikeja-electric</strong>, <strong>eko-electric</strong>, <strong>portharcourt-electric</strong>, <strong>jos-electric</strong>, <strong>kano-electric</strong>, <strong>ibadan-electric</strong></td>
</tr>
<tr>
<td width="150">accountno</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The meter number to load the electricity token</td>
</tr>
<tr>
<td width="150">vcode</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">This is the meter type. Example: <strong>prepaid</strong> or <strong>postpaid</strong></td>
</tr>
<tr>
<td width="150">amount</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The amount of electricity token you want to buy</td>
</tr>
<tr>
<tr>
<td width="150">ref</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">This is a unique reference with which you can use to execute and query the transaction.</td>
</tr>
</tbody>
</table>
</div>
<p>&nbsp;</p>

<p><strong>SAMPLE </strong><strong>CODE</strong></p>

<pre>

$host ="https://<?php echo $_SERVER['SERVER_NAME'];?>/api/biller?apikey=1234&service=ikeja-electric&accountno=100221233&vcode=prepaid&amount=1000&ref=8284666332234 ";
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $host);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$data = curl_exec($ch);

//Close the cURL handle.
curl_close($ch);

$response = json_decode($data);

</pre>

<p>&nbsp;</p>

<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>
<pre>
{"code":101,
"description":{"Status":"TRANSACTION SUCCESSFUL",
"Token":"40364652026905256691",
"Units":"500 kWh",
"meterNumber":"100221233",
"product_name":"Ikeja Electric Payment - PHCN"
	
    }
}

</pre>

                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                                      <a class="btn btn-info btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
               <i class="fa fa-link"></i>          TV Payment API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                  <div class="panel-body">
                      <h1>TV Payment API Integration</h1>
This section contains your RESTful API for TV Payment API integration.

<p>&nbsp;</p>
<h4>Authentication</h4>
<p>The <?php echo $sitnam['sitename'];?> API uses API Key for Authentication.</p>

<p>Please see the following sample API key for authentication</p>
<pre>Apikey = kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</pre>
<p><strong>API Key: </strong>Your Gateway API Key</p>
 Please create your API key here <a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>">Create API Key</a>
<p>&nbsp;</p>

<h3><strong>VALIDATE SMARTCARD/IUC NUMBER</strong></h3>
You can validate smartcard/IUC number with the following endpoint:</p>
<p><strong>Base URL: </strong>https://<?php echo $_SERVER['SERVER_NAME']; ?>/api/merchant-verify</p>
<p>&nbsp;</p>

<div class="table-responsive">
<table class="table table-bordered table-striped">
<tbody>
<tr>
<td width="150"><strong>PARAMETERS</strong></td>
<td width="150"><strong>Required/Optional</strong></td>
<td width="150"><strong>TYPE</strong></td>
<td width="150"><strong>DESCRIPTION</strong></td>
</tr>
<tr>
<td width="150">apikey</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">The reseller gateway API key created at <?php echo $_SERVER['SERVER_NAME'];?> . Example <strong>kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</strong></td>
</tr>
<tr>
<td width="150">service</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Service as specified. These includes, <strong>dstv</strong>, <strong>gotv</strong>, <strong>startimes</strong>
</tr>
<tr>
<td width="150">smartNo</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The smartcard or IUC number to make the subscription on</td>
</tr>
<tr>

</tbody>
</table>
</div>
<p><strong> </strong></p>
<p>&nbsp;</p>
<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>
<pre>
{"code":119,
"description":{"Customer":"PAUL BECKY",
"Due_Date":"2019-07-23T00:00:00",
"Status":"Open"
	}
}

</pre>
<p>&nbsp;</p>

<h3><strong>Recharge Decoder</strong></h3>
This endpoint allows you to recharge GOTV/DSTV/Startimes decoder using it’s smartcard/IUC number.</p>
<p><strong>Base URL:</strong> https://<?php echo $request_dir; ?>/api/biller</p>
<p><strong>Service: </strong>as specified in the fields below;</p>
<p>&nbsp;</p>
<div class="table-responsive">
<table class="table table-bordered table-striped">
<tbody>
<tr>
<td width="150"><strong>PARAMETERS</strong></td>
<td width="150"><strong>Required/Optional</strong></td>
<td width="150"><strong>TYPE</strong></td>
<td width="150"><strong>DESCRIPTION</strong></td>
</tr>
<tr>
<td width="150">apikey</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">The reseller gateway API key created at <?php echo $_SERVER['SERVER_NAME'];?> . Example <strong>kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</strong></td>
</tr>
<tr>
<td width="150">service</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Service as specified. These includes, <strong>dstv</strong>, <strong>gotv</strong>, <strong>startimes</strong></td>
</tr>
<tr>
<td width="150">accountno</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The smartcard or IUC number to make the subscription on</td>
</tr>
<tr>
<td width="150">vcode</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">This is the meter type. Example: <strong>prepaid</strong> or <strong>postpaid</strong></td>
</tr>
<tr>
<td width="150">amount</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The amount of electricity token you want to buy</td>
</tr>
<tr>
<tr>
<td width="150">ref</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">This is a unique reference with which you can use to execute and query the transaction.</td>
</tr>
</tbody>
</table>
</div>
<p>&nbsp;</p>

<p><strong>SAMPLE </strong><strong>CODE</strong></p>

<pre>

$host ="https://<?php echo $_SERVER['SERVER_NAME'];?>/api/biller?apikey=1234&service=gotv&accountno=100221233&vcode=gotv-plus&amount=1900&ref=8284666332234 ";
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $host);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$data = curl_exec($ch);

//Close the cURL handle.
curl_close($ch);

$response = json_decode($data);

</pre>

<p>&nbsp;</p>

<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>
<pre>{"code":101,<br>"description":{"response_description":"TRANSACTION SUCCESSFUL",<br>"ref":"884666332234","amount":"100",<br>"transaction_date":"2020-04-17 07:04:19"<br>}}

</pre>

                  </div>
                </div>
              </div>
              
              
              
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                                      <a class="btn btn-info btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
               <i class="fa fa-link"></i>          Wallet Balance API
                                      </a>
                                  </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse">
                  <div class="panel-body">
                      <h1>Wallet Balance API</h1>
This section contains your RESTful API to get wallet balance.

<p>&nbsp;</p>
<h4>Authentication</h4>
<p>The <?php echo $sitnam['sitename'];?> API uses API Key for Authentication.</p>

<p>Please see the following sample API key for authentication</p>
<pre>Apikey = kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</pre>
<p><strong>API Key: </strong>Your Gateway API Key</p>
 Please create your API key here <a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>">Create API Key</a>
<p>&nbsp;</p>

<p>&nbsp;</p>

<h3><strong>GET WALLET BALANCE</strong></h3>
This endpoint allows you to get <?php echo $sitnam['sitename'];?> wallet balance .</p>
<p><strong>Base URL:</strong> https://<?php echo $request_dir; ?>/api/balance</p>
<p><strong>Service: </strong>as specified in the fields below;</p>
<p>&nbsp;</p>
<div class="table-responsive">
<table class="table table-bordered table-striped">
<tbody>
<tr>
<td width="150"><strong>PARAMETER</strong></td>
<td width="150"><strong>Required/Optional</strong></td>
<td width="150"><strong>TYPE</strong></td>
<td width="150"><strong>DESCRIPTION</strong></td>
</tr>
<tr>
<td width="150">apikey</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">The reseller gateway API key created at <?php echo $_SERVER['SERVER_NAME'];?> . Example <strong>kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</strong></td>
</tr>
<tr>

</tbody>
</table>
</div>
<p>&nbsp;</p>

<p><strong>SAMPLE </strong><strong>CODE</strong></p>

<pre>

$host ="https://<?php echo $_SERVER['SERVER_NAME'];?>/api/balance?apikey=1234 ";
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $host);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$data = curl_exec($ch);

//Close the cURL handle.
curl_close($ch);

$response = json_decode($data);

</pre>

<p>&nbsp;</p>

<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>
<pre>

{"code":101,

"description":{"BALANCE":"45000.00",
	}

}

</pre>

                  </div>
                </div>
              </div>
              
            </div>
            <!--collapse end-->    
                                      
                                      
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
    

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
    $(function () {
        $('#tableId').DataTable();
    });
</script>
    
    
</body>
 
</html>