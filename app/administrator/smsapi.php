<?php 
session_start();
require('../db.php');
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
						
$user = $_SESSION['user'];
								
$ins = mysqli_query($conn,"SELECT * FROM users WHERE email='$user' ");
$data = mysqli_fetch_array($ins);
								
$email = $data['email'];
$rowpas = $data['pass'];
$bal = $data['bal'];
							
$deps = "SELECT * FROM deposit  ";
$payment = $conn->query($deps);

include('../inc/logo.php');	

$qrysit = mysqli_query($conn,"SELECT * FROM settings");
$sitnam = mysqli_fetch_array($qrysit);						
								
?> 
<?php include('inc/header.php');?>
<body class="fixed-nav sticky-footer bg-light" id="page-top">



  <!-- Navigation-->
 <?php include('inc/nav.php');?>
        
  <!-- Navigation Ends--> 
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
  
    <div class="container-fluid">
      <!-- Breadcrumbs-->
     
      <div class="row">
        <div class="col-12">
          
     
     <h1 class="w3-xxxlarge w3-text-green" align="center"><b>SMS API Settings</b></h1>
       
<p align="center"><strong>Description:</strong> Configure BulkSMS API credentials  </p>
      <!-- Example Bar Chart Card-->
       
     <?php 
		   // define variables and set to empty values

	$request_dir = $_SERVER['SERVER_NAME'];	
		
		
		if(isset($_POST['rate'])){
		include('inc/smsapi_set.php');
		
						}
			
			
			$query_rec = mysqli_query($conn,"SELECT * FROM providers_api_key");
			
			$apib = mysqli_fetch_array($query_rec);
		?> 
       
  <form action="" method="post" autocomplete = 'off' > 
  
     <table class="table  margin-tp-10" id="transTable">
     
     
     <td width="30%"><i class="fa fa-user"></i> Username</td>
                            <td id="mainService"> <input type="text" name="smUser"  value="<?php echo $apib['smsUserid'];?>" class="form-control" required> </td>
                        </tr>
                        
     
     <td width="30%"><i class="fa fa-lock"></i> Password</td>
                            <td id="mainService"> <input type="text" name="smPass"  value="<?php echo $apib['smsPass'];?>" class="form-control" required> </td>
                        </tr>
   
     <td width="30%"><i class="fa fa-link"></i> Base URL</td>
                            <td id="mainService"> <input type="text" name="smBase"  value="<?php echo $apib['baseurl'];?>" class="form-control" required> </td>
                        </tr>
                        
                   
                    <td id="mainService"> </td>
                    <td id="mainService"> <?php sm(); ?></td>
                    </tr>
                                            <tr>
                            <td colspan="2">
                            <button type="submit" id="submit" name="rate" class="btn btn-info">Save Settings</button>
                       </td>
                                                                       
                          <td valign="middle"></td>                                             
                        </tr>
                                    </table> 
  
  </form>
  
     
               
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
   <?php include('inc/footer.php');?>