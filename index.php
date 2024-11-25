<?php
function urlbasemain(){
//Initialize cURL.
$baseurl = $_SERVER["SERVER_NAME"].'/api';
return $baseurl;

	}
include('inc/header1.php');?> 
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
      
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php include('inc/nav2.php'); ?>
         
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
                                    
                                    <h1 align="center"> <?php echo $_SERVER['SERVER_NAME'];?> API Documentation </h1>
                                  <p>&nbsp;</p>
                           Our API allows you to easily integrate bill payment services available on the <?php echo $_SERVER['SERVER_NAME'];?> platform on your mobile or web application.
                           
                          <p>&nbsp;</p>
                        <code><Strong>Base URL:</Strong> <?php echo 'https://'.urlbasemain();?> </code>   
                          <p></p> 
                                   	<!--collapse start-->
            <div class="panel-group m-bot20" id="accordion">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                             <i class="fa fa-phone"></i>             Airtime VTU API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                  <div class="panel-body">
                    
                    <h1>VTU Airtime API Integration</h1>
This section contains your RESTful API for Airtime VTU API integration.

<p>&nbsp;</p>
<h4>Authentication</h4>
<p>Our API uses API Key for Authentication.</p>

<p>Please use the following details for authentication</p>
<pre>Apikey = kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</pre>
<p><strong>API Key: </strong>Your Gateway API Key</p>
 Please create your API key here <a href="https://<?php echo $_SERVER['SERVER_NAME'];?>; ?>">Create API Key</a>
<p>&nbsp;</p>


<h3><strong>Purchase products</strong></h3>
Airtime VTU services can be purchased with the endpoint below:</p>
<p><strong>Endpoint URL:</strong> {{baseurl}}/airtime</p>
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


<p>&nbsp;</p>

<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>
<pre>{"code":101,<br>"description":{"response_description":"TRANSACTION SUCCESSFUL",<br>"ref":"884666332234","amount":"100",<br>"transaction_date":"2020-04-17 07:04:19"<br>}}

</pre>


                    
                  </div>
                </div>
              </div>
              
              
              
              
              
              	<!--collapse start-->
            <div class="panel-group m-bot20" id="accordion">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseEpin">
                             <i class="fa fa-phone"></i>           Recharge Card PINs Generator API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseEpin" class="panel-collapse collapse in">
                  <div class="panel-body">
                    
                    <h1>Recharge Card PINs API Integration</h1>
This section contains your RESTful API for Recharge card PIN Generator API integration.

<p>&nbsp;</p>
<h4>Authentication</h4>
<p>The ePINs API uses API Key for Authentication.</p>

<p>Please use the following details for authentication</p>
<pre>Apikey = kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</pre>
<p><strong>API Key: </strong>Your Gateway API Key</p>
 Please create your API key here <a href="https://<?php echo $_SERVER['SERVER_NAME'];?>">Create API Key</a>
<p>&nbsp;</p>


<h3><strong>Purchase products</strong></h3>
Recharge card PIN services can be purchased with the endpoint below:</p>
<p><strong>Endpoint URL:</strong> {{baseurl}}/epin</p>
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
<td width="150">service</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">service name as specified. This should be, <strong>epin</strong></td>
</tr>
<tr>
<td width="150">network</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Network as specified. These includes, <strong>mtn</strong>,  <strong>airtel</strong>, <strong>glo</strong>, <strong>etisalat</strong></td>
</tr>
<tr>
<td width="150">pinDenomination</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The denomination of pin to generate. These includes, 

<table width="65%" border="1" cellpadding="0" cellspacing="0" class="strip" style="border:thin #999999 solid" >
                      <tr>
                        <td width="319" valign="top"><p align="center"><strong>Denominations</strong></p></td>
                        <td width="319" valign="top"><p align="center"><strong>Service variation</strong></p></td>
                      </tr>
                       <tr>
                        <td width="319" valign="top"><p align="center">100</p></td>
                        <td width="319" valign="top"><p align="center">1</p></td>
                      </tr>
                      <tr>
                        <td width="319" valign="top"><p align="center">200</p></td>
                        <td width="319" valign="top"><p align="center">2</p></td>
                      </tr>
                      <tr>
                        <td width="319" valign="top"><p align="center">400</p></td>
                        <td width="319" valign="top"><p align="center">4</p></td>
                      </tr>
                     
                      <tr>
                        <td width="319" valign="top"><p align="center">500</p></td>
                        <td width="319" valign="top"><p align="center">5</p></td>
                      </tr>
                      
                      
                      <tr>
                        <td width="319" valign="top"><p align="center">750</p></td>
                        <td width="319" valign="top"><p align="center">7.5</p></td>
                      </tr>
                      <tr>
                        <td width="319" valign="top"><p align="center">1000</p></td>
                        <td width="319" valign="top"><p align="center">10</p></td>
                      </tr>
                      <tr>
                        <td width="319" valign="top"><p align="center">1500</p></td>
                        <td width="319" valign="top"><p align="center">15</p></td>
                      </tr>
                    </table>

</td>
</tr>
<tr>
<td width="150">pinQuantity</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The number of pins to generate</td>
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


<p>&nbsp;</p>

<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>
<pre>
    {
    "code":101,
    "description":{
    "status":"TRANSACTION SUCCESSFUL",
    "PIN":"02357485946496925482100BC\r",
    "network":"mtn",
    "pinDenomination":"100",
    "pinQuantity":1,
    "product_name":"MTN ePIN 100",
    "TransactionDate":"2023-03-20 05:58:AM"
     }
    }

</pre>


                    
                  </div>
                </div>
              </div>
              
  
  <!-- DATA CARD API -->
  
  <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseDatacard">
               <i class="fa fa-wifi"></i>          DATA CARD API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseDatacard" class="panel-collapse collapse">
                  <div class="panel-body">
<h3><strong>Purchase DATA CARD</strong></h3>
DATA CARD services can be purchased with the endpoint below:</p>
<p><strong>Endpoint URL:</strong> {{baseurl}}/datacard</p>
<p><strong>Request Method: </strong>POST</p>
<p><strong>Network: </strong>as specified in the parameters below;</p>

<table width="65%" border="1" cellpadding="0" cellspacing="0" class="strip" style="border:thin #999999 solid" >
                      <tr>
                        <td width="319" valign="top"><p align="center"><strong>Network</strong></p></td>
                        <td width="319" valign="top"><p align="center"><strong>Service variation</strong></p></td>
                      </tr>
                       <tr>
                        <td  width="319" height="40" valign="top"><div align="center">MTN</div></td>
                        <td  width="319" valign="top"><div align="center">01</div></td>
                      </tr>
                      <tr>
                        <td width="319" valign="top"><p align="center">Airtel</p></td>
                        <td width="319" valign="top"><p align="center">04</p></td>
                      </tr>
                      <tr>
                        <td width="319" valign="top"><p align="center">9Mobile</p></td>
                        <td width="319" valign="top"><p align="center">03</p></td>
                      </tr>
                     
                      <tr>
                        <td width="319" valign="top"><p align="center">Glo</p></td>
                        <td width="319" valign="top"><p align="center">02</p></td>
                      </tr>
                    </table>

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
<td width="150">Service id should be <strong>datacard</strong>. </td>
</tr>

<tr>
<td width="150">network</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Network as specified in the service variation above. </td>
</tr>
<tr>
<td width="150">pinQuantity</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The number of DATA CARD PINs to generate</td>
</tr>
<tr>
<td width="150">DataPlan</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The Data plan variation includes <strong>1500</strong>; for 1.5GB
                                
							 
							</td>
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


<p>&nbsp;</p>

<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>
<pre>
 {
    "code": 101,
    "description": {
        "status": "TRANSACTION SUCCESSFUL",
        "PIN": "808346012S\n541093716S\n",
        "network": "MTN",
        "pinDenomination": "1500",
        "pinQuantity": "2",
        "product_name": "MTN DATACARD 1.5 GB ",
        "TransactionDate": "2023-03-19 03:12:PM"
    }
}

</pre>

                  </div>
                </div>
              </div>
                   
  
 
  
  
  
              
              
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                <i class="fa fa-plug"></i>          Electricity Payment API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                  <div class="panel-body">
                        
                    <h1>Electricity Payment API Integration</h1>
This section contains your RESTful API for Electricity Payment API integration.

<p>&nbsp;</p>
<h4>Authentication</h4>
<p>The ePINs API uses API Key for Authentication.</p>

<p>Please see the following sample API key for authentication</p>
<pre>Apikey = kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</pre>
<p><strong>API Key: </strong>Your Gateway API Key</p>
 Please create your API key here <a href="https://<?php echo $_SERVER['SERVER_NAME'];?>">Create API Key</a>
<p>&nbsp;</p>

<h3><strong>VALIDATE METER NUMBER</strong></h3>
You can validate meter number with the following endpoint:</p>
<p><strong>Endpoint URL: </strong>{{baseurl}}/merchant-verify</p>
<p><strong>Endpoint URL: </strong>{{baseurl}}/electric-verify</p>
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
<td width="150">Service as specified. These includes, <strong>ikeja-electric</strong>, <strong>eko-electric</strong>, <strong>portharcourt-electric</strong>, <strong>jos-electric</strong>, <strong>kano-electric</strong>, <strong>ibadan-electric</strong>, <strong>enugu-electric</strong>, <strong>abuja-electric</strong>,<strong>benin-electric</strong></p>
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
<p><strong>Endpoint URL:</strong> {{baseurl}}/biller</p>
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
<td width="150">Service as specified. These includes, <strong>ikeja-electric</strong>, <strong>eko-electric</strong>, <strong>portharcourt-electric</strong>, <strong>jos-electric</strong>, <strong>kano-electric</strong>, <strong>ibadan-electric</strong>,<strong>benin-electric</strong></td>
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
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
               <i class="fa fa-tv"></i>          TV Payment API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                  <div class="panel-body">
                      <h1>TV Payment API Integration</h1>
This section contains your RESTful API for TV Payment API integration.

<p>&nbsp;</p>
<h4>Authentication</h4>
<p>The ePINs API uses API Key for Authentication.</p>

<p>Please see the following sample API key for authentication</p>
<pre>Apikey = kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</pre>
<p><strong>API Key: </strong>Your Gateway API Key</p>
 Please create your API key here <a href="https://<?php echo $_SERVER['SERVER_NAME'];?>">Create API Key</a>
<p>&nbsp;</p>

<h4>GET VARIATION CODES</h4>
Using a GET method, the ePINs variation codes for GOTV,DSTV, Startimes bouquets can be accessed with the endpoint below:
<p></p>

<strong>GOTV Variations:</strong> {{baseurl}}/variations?service=gotv <br>
<strong>DSTV Variations:</strong> {{baseurl}}/variations?service=dstv <br>
<strong>Startime Variations:</strong> {{baseurl}}/variations?service=startimes 
<p></p>
<a href="<?php echo urlbasemain();?>/variations/?service=gotv" class="btn btn-danger">View Gotv variation code</a>
<a href="<?php echo urlbasemain();?>/variations/?service=dstv" class="btn btn-primary">View Dstv variation code</a>

<a href="<?php echo urlbasemain();?>/variations/?service=startimes" class="btn btn-warning">View Startimes variation code</a>
<p>&nbsp;</p>

<h3><strong>VALIDATE SMARTCARD/IUC NUMBER</strong></h3>
You can validate smartcard/IUC number with the following endpoint:</p>
<p><strong>Endpoint URL: </strong>{{baseurl}}/merchant-verify</p>
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

<tr>
<td width="150">type</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">same as service parameter.  </td>
</tr>

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
<p><strong>Endpoint URL:</strong> {{baseurl}}/biller</p>
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
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
               <i class="fas fa-fw fa-football-ball"></i>          Bet9ja Payment API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseFive" class="panel-collapse collapse">
                  <div class="panel-body">
                      <h1>Bet9ja Payment API Integration</h1>
This section contains your RESTful API for Bet9ja Payment API integration.

<p>&nbsp;</p>
<h4>Authentication</h4>
<p>The ePINs API uses API Key for Authentication.</p>

<p>Please see the following sample API key for authentication</p>
<pre>Apikey = kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</pre>
<p><strong>API Key: </strong>Your Gateway API Key</p>
 Please create your API key here <a href="https://<?php echo $_SERVER['SERVER_NAME'];?>">Create API Key</a>
<p>&nbsp;</p>

<h3><strong>VALIDATE Bet9ja ACCOUNT NUMBER</strong></h3>
You can validate Bet9ja Account number with the following endpoint:</p>
<p><strong>Endpoint URL: </strong>{{baseurl}}/bet-verify</p>
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
<td width="150">customerId</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The Bet9ja customer number to make the subscription on</td>
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

<h3><strong>Recharge Bet9ja Account</strong></h3>
This endpoint allows you to recharge Bet9ja account using it’s Customer ID.</p>
<p><strong>Endpoint URL:</strong> {{baseurl}}/bet9ja</p>
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
<td width="150">customerId</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The Bet9ja customer Number to make the payment on</td>
</tr>
<tr>
<td width="150">reference</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">The reference number generated during bet9ja account validation</td>
</tr>
<tr>
<td width="150">amount</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The amount to credit on bet9ja account</td>
</tr>
<tr>
<td width="150">customerName</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Customer Name generated during Bet9ja account validation</td>
</tr>
<tr>
<tr>
<td width="150">request_id</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">This is a unique reference with which you can use to execute and query the transaction.</td>
</tr>
</tbody>
</table>
</div>
<p>&nbsp;</p>



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
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
               <i class="fa fa-wifi"></i>          SME Data Topup API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseSix" class="panel-collapse collapse">
                  <div class="panel-body">
<h3><strong>Purchase SME Data</strong></h3>
SME Data services can be purchased with the endpoint below:</p>
<p><strong>Endpoint URL:</strong> {{baseurl}}/data</p>
<p><strong>Request Method: </strong>POST</p>
<p><strong>Network: </strong>as specified in the parameters below;</p>

<table width="65%" border="1" cellpadding="0" cellspacing="0" class="strip" style="border:thin #999999 solid" >
                      <tr>
                        <td width="319" valign="top"><p align="center"><strong>Network</strong></p></td>
                        <td width="319" valign="top"><p align="center"><strong>Service variation</strong></p></td>
                      </tr>
                       <tr>
                        <td  width="319" height="40" valign="top"><div align="center">MTN</div></td>
                        <td  width="319" valign="top"><div align="center">01</div></td>
                      </tr>
                      <tr>
                        <td width="319" valign="top"><p align="center">Airtel</p></td>
                        <td width="319" valign="top"><p align="center">04</p></td>
                      </tr>
                      <tr>
                        <td width="319" valign="top"><p align="center">9Mobile</p></td>
                        <td width="319" valign="top"><p align="center">03</p></td>
                      </tr>
                     
                      <tr>
                        <td width="319" valign="top"><p align="center">Glo</p></td>
                        <td width="319" valign="top"><p align="center">02</p></td>
                      </tr>
                    </table>

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
<td width="150">Network as specified in the service variation above. </td>
</tr>
<tr>
<td width="150">MobileNumber</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The phone number to receive the SME Data</td>
</tr>
<tr>
<td width="150">DataPlan</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The SME Data plan Variation code. 
                                <br>
                           
                           
                          
   <table class="table-bordered table-striped">
<tbody>
<tr>
<td>Network</td>
<td>Plan</td>
<td>plancode</td>
<td>Amount</td>
</tr>


     <?php 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, urlbasemain()."/variations/?service=sme");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$data_sme = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);
$json_sme =  json_decode($data_sme);
   
    foreach ( $json_sme->description as $sm){ 
for ($s = 0, $m = count($sm); $s < $m; $s++){        
     ?>
     <tr>
<td><?php echo $sm->network; ?></td>
<td><?php echo $sm->plan; ?></td>
<td><?php echo $sm->clientcode; ?></td>
<td><?php echo '&#8358;'.$sm->price_api; ?></td>
</tr>
<?php } } ?>

    </tbody>
    </table>
                           
							 
							</td>
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
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseLite">
               <i class="fa fa-wifi"></i>          CG LITE Data Topup API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseLite" class="panel-collapse collapse">
                  <div class="panel-body">
<h3><strong>Purchase CGLITE Data</strong></h3>
CG LITE Data services can be purchased with the endpoint below:</p>
<p><strong>Endpoint URL:</strong> {{baseurl}}/data</p>
<p><strong>Request Method: </strong>POST</p>
<p><strong>Network: </strong>as specified in the parameters below;</p>

<table width="65%" border="1" cellpadding="0" cellspacing="0" class="strip" style="border:thin #999999 solid" >
                      <tr>
                        <td width="319" valign="top"><p align="center"><strong>Network</strong></p></td>
                        <td width="319" valign="top"><p align="center"><strong>Service variation</strong></p></td>
                      </tr>
                       <tr>
                        <td  width="319" height="40" valign="top"><div align="center">MTN</div></td>
                        <td  width="319" valign="top"><div align="center">01</div></td>
                      </tr>
                      <tr>
                        <td width="319" valign="top"><p align="center">Airtel</p></td>
                        <td width="319" valign="top"><p align="center">04</p></td>
                      </tr>
                      <tr>
                        <td width="319" valign="top"><p align="center">9Mobile</p></td>
                        <td width="319" valign="top"><p align="center">03</p></td>
                      </tr>
                     
                      <tr>
                        <td width="319" valign="top"><p align="center">Glo</p></td>
                        <td width="319" valign="top"><p align="center">02</p></td>
                      </tr>
                    </table>

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
<td width="150">Network as specified in the service variation above. </td>
</tr>
<tr>
<td width="150">MobileNumber</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The phone number to receive the Data</td>
</tr>
<tr>
<td width="150">DataPlan</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The CG LITE Data plan Variation code. 
                                <br>
                          
                           
                          
   <table class="table-bordered table-striped">
<tbody>
<tr>
<td>Network</td>
<td>Plan</td>
<td>plancode</td>
<td>Amount</td>
</tr>


     <?php 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, urlbasemain()."/variations/?service=cglite");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$data_ep = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);
$json =  json_decode($data_ep);
   
    foreach ( $json->description as $rd){ 
for ($i = 0, $d = count($rd); $i < $d; $i++){        
     ?>
     <tr>
<td><?php echo $rd->network; ?></td>
<td><?php echo $rd->plan; ?></td>
<td><?php echo $rd->clientcode; ?></td>
<td><?php echo '&#8358;'.$rd->price_api; ?></td>
</tr>
<?php } } ?>

    </tbody>
    </table>
                           
							 
							</td>
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


<p>&nbsp;</p>

<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>
<pre>

    {"code":101,
    "description": {"Status":"successful",
    "ProductName":"MTN 1GB (CG_LITE)","Network":null,
    "TransactionRef":"3807689167291450",
    "Date":"2023-06-28 12:32:PM"}} 


</pre>



                  </div>
                </div>
              </div>
   
   
   
   
   
   
   
 
 
 <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseEitheen">
               <i class="fa fa-wifi"></i>          GIFTING Data API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseEitheen" class="panel-collapse collapse">
                  <div class="panel-body">
<h3><strong>Purchase GIFTING Data</strong></h3>
GIFTING Data services can be purchased with the endpoint below:</p>
<p><strong>Endpoint URL:</strong> {{baseurl}}/data</p>
<p><strong>Request Method: </strong>POST</p>
<p><strong>Network: </strong>as specified in the parameters below;</p>

<table width="65%" border="1" cellpadding="0" cellspacing="0" class="strip" style="border:thin #999999 solid" >
                      <tr>
                        <td width="319" valign="top"><p align="center"><strong>Network</strong></p></td>
                        <td width="319" valign="top"><p align="center"><strong>Service variation</strong></p></td>
                      </tr>
                       <tr>
                        <td  width="319" height="40" valign="top"><div align="center">MTN</div></td>
                        <td  width="319" valign="top"><div align="center">01</div></td>
                      </tr>
                      <tr>
                        <td width="319" valign="top"><p align="center">Airtel</p></td>
                        <td width="319" valign="top"><p align="center">04</p></td>
                      </tr>
                      <tr>
                        <td width="319" valign="top"><p align="center">9Mobile</p></td>
                        <td width="319" valign="top"><p align="center">03</p></td>
                      </tr>
                     
                      <tr>
                        <td width="319" valign="top"><p align="center">Glo</p></td>
                        <td width="319" valign="top"><p align="center">02</p></td>
                      </tr>
                    </table>

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
<td width="150">Network as specified in the service variation above. </td>
</tr>
<tr>
<td width="150">MobileNumber</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The phone number to receive the GIFTING Data</td>
</tr>
<tr>
<td width="150">DataPlan</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The Gifting Data  Variation code. These includes; 
                                <br>
                            
                             
                             
                              <table class="table-bordered table-striped">
<tbody>
<tr>
<td>Network</td>
<td>Plan</td>
<td>plancode</td>
<td>Amount</td>
</tr>


     <?php 
     
     
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, urlbasemain()."/variations/?service=gifting");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$data_cg = curl_exec($ch);
//Close the cURL handle.
curl_close($ch);
$json_cg =  json_decode($data_cg);
   
    foreach ( $json_cg->description as $cg){ 
for ($c = 0, $g = count($cg); $c < $g; $c++){        
     ?>
     <tr>
<td><?php echo $cg->network; ?></td>
<td><?php echo $cg->plan; ?></td>
<td><?php echo $cg->clientcode; ?></td>
<td><?php echo '&#8358;'.$cg->price_api; ?></td>
</tr>
<?php } } ?>

    </tbody>
    </table>
							 
							</td>
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
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
               <i class="fa fa-graduation-cap"></i>          WAEC Result Checker API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseSeven" class="panel-collapse collapse">
                  <div class="panel-body">
<h3><strong>Purchase WAEC RESULT CHECKER PIN</strong></h3>
WAEC Result checker PIN can be purchased with the endpoint below:</p>
<p><strong>Endpoint URL:</strong> {{baseurl}}/waec</p>
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
<td width="150">The reseller gateway API key created at <?php echo $_SERVER['SERVER_NAME'];?>. Example <strong>kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</strong></td>
</tr>
<tr>
<td width="150">service</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Network as specified. These includes, <strong>waec</strong></td>
</tr>
<tr>
<td width="150">vcode</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">The code of the variation. That is <b>waecdirect</b></td>
</tr>
<tr>
<td width="150">amount</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The amount of the variation (as specified in the VARIATIONS endpoint )</td>
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


<p>&nbsp;</p>

<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>


<pre>{"code":101,"description":{"Content":"Serial No:WRN800312772, pin: 249714527294",<br>"product_name":"WAEC Result Checker PIN","TransactionDate":"2021-11-01 02:51:PM"}}

</pre>

                  </div>
                </div>
              </div> 
 
 
 
 <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
               <i class="fa fa-graduation-cap"></i>          NECO Result Checker API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseEight" class="panel-collapse collapse">
                  <div class="panel-body">
<h3><strong>Purchase NECO RESULT CHECKER PIN</strong></h3>
NECO result Checker PIN can be purchased with the endpoint below:</p>
<p><strong>Endpoint URL:</strong> {{baseurl}}/neco</p>
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
<td width="150">service</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Network as specified. These includes, <strong>neco</strong></td>
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

<p>&nbsp;</p>

<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>

<pre>{"code":101,"description":{"Status":"TRANSACTION SUCCESSFUL","PIN":"35609198364227070191",<br>"TransactionRef":"45060440786","product_name":"NECO Result Checker",<br>"Date":"2021-11-01 02:51:PM"}}
</pre>

                  </div>
                </div>
              </div> 
  
  
  
  <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseNine">
               <i class="fa fa-wifi"></i>          Spectranet PIN Purchase API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseNine" class="panel-collapse collapse">
                  <div class="panel-body">
<h3><strong>Purchase Spectranet PIN</strong></h3>
Spectranet PIN services can be purchased with the endpoint below:</p>
<p><strong>Endpoint URL:</strong> {{baseurl}}/spectranet</p>
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
<td width="150">The reseller gateway API key created at <?php echo $_SERVER['SERVER_NAME'];?>. Example <strong>kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</strong></td>
</tr>
<tr>
<td width="150">service</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Network as specified. These includes, <strong>spectranet</strong></td>
</tr>
<tr>
<td width="150">pinNo</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The number of Spectranet PINs to purchase</td>
</tr>
<tr>
<td width="150">amount</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The amount of the variation (as specified in the VARIATIONS endpoint )</td>
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


<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>
<pre>{"code":101,<br>"description":{"response_description":"TRANSACTION SUCCESSFUL",<br>"ref":"884666332234","amount":"100",<br>"transaction_date":"2020-04-17 07:04:19"<br>}}

</pre>

                  </div>
                </div>
              </div> 
  
  
  
  
  
  <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseTwleve">
               <i class="fa fa-car"></i>          Universal Motor Insurance API Integration
                                      </a>
                                  </h4>
                </div>
                <div id="collapseTwleve" class="panel-collapse collapse">
                  <div class="panel-body">
<h3><strong>Purchase Universal Motor Insurance</strong></h3>
Universal Motor Insurance can be purchased with the endpoint below:</p>
<p><strong>Endpoint URL:</strong> {{baseurl}}/ui-insurance</p>
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
<td width="150">service</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Network as specified. These includes, <strong>ui-insure</strong></td>
</tr>

<tr>
<td width="150">accountno</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">The plate Number of the vehicle you wish to make the insurance payment on. Example: KUJ480BH </td>
</tr>
<tr>
<td width="150">vcode</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">The code of the variation. That includes <b>Commercial</b>, <b>Private</b>, <b>Tricycles</b></td>
</tr>
<tr>
<td width="150">amount</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The amount of the variation (as specified in the VARIATIONS endpoint )</td>
</tr>

<tr>
<td width="150">Phone</td>
<td width="150">R</td>
<td width="150">Number</td>
<td width="150">The phone number of the customer or recipient of this service</td>
</tr>


<tr>
<td width="150">insuredName</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Name of the owner of the insured vehicle</td>
</tr>

<tr>
<td width="150">engineNo</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Engine Number of the insured vehicle</td>
</tr>

<tr>
<td width="150">chasisNo</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Chasis Number of the insured vehicle</td>
</tr>

<tr>
<td width="150">plateNo</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Same as the accountno above</td>
</tr>

<tr>
<td width="150">plateNo</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Same as the accountno above</td>
</tr>

<tr>
<td width="150">vehicleMake</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Make of the insured vehicle</td>
</tr>

<tr>
<td width="150">vehicleColor</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Color of the insured vehicle</td>
</tr>

<tr>
<td width="150">vehicleModel</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Model of the insured vehicle</td>
</tr>

<tr>
<td width="150">yearofMake</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">The year the insured vehicle was made.</td>
</tr>

<tr>
<td width="150">contactAddress</td>
<td width="150">R</td>
<td width="150">String</td>
<td width="150">Contact Address of the vehicle owner</td>
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

<p><strong>EXPECTED </strong><strong>RESPONSE</strong></p>
<pre>{"code":101,<br>"description":{"response_description":"TRANSACTION SUCCESSFUL",<br>"ref":"884666332234","Download Certificate":"https://3rdparty.universalinsuranceonline.com/PrintCertificate.aspx?Data=UPMSB001190319136038",<br>"transaction_date":"2020-04-17 07:04:19"<br>}}

</pre>

                  </div>
                </div>
              </div> 
              
              
              

              
              
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                                      <a class="btn btn-secondary btn-xs btn-block" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
               <i class="fas fa-fw fa-money-bill-alt"></i>          Wallet Balance API
                                      </a>
                                  </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse">
                  <div class="panel-body">
                      <h1>Wallet Balance API</h1>
This section contains your RESTful API to get wallet balance.

<p>&nbsp;</p>
<h4>Authentication</h4>
<p>The ePINs API uses API Key for Authentication.</p>

<p>Please see the following sample API key for authentication</p>
<pre>Apikey = kDe5dbBw3AeyxnxFCCJA9c9Agl2kxxt8pCB174AC472r38BCM</pre>
<p><strong>API Key: </strong>Your Gateway API Key</p>
 Please create your API key here <a href="https://<?php echo $_SERVER['SERVER_NAME'];?>">Create API Key</a>
<p>&nbsp;</p>

<p>&nbsp;</p>

<h3><strong>GET WALLET BALANCE</strong></h3>
This endpoint allows you to get <?php echo "epins.com.ng";?> wallet balance .</p>
<p><strong>Endpoint URL:</strong> {{baseurl}}/balance</p>
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
       <?php //include('inc/footer1.php');?>
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
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="assets/libs/js/dashboard-ecommerce.js"></script>
    

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
    $(function () {
        $('#tableId').DataTable();
    });
</script>
    
    
</body>
 
</html>