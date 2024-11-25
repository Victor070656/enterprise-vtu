<?php 
session_start();
require('../db.php');
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}	
$user = $_SESSION['user'];
include('../inc/logo.php');	
$qrysit = mysqli_query($conn,"SELECT * FROM settings");
$sitnam = mysqli_fetch_array($qrysit);
//auto settings
$monxt = $conn->query("SELECT * FROM monnify_api");
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
          
     
     <h1 class="w3-xxxlarge w3-text-green" align="center"><b>Auto Funding API Settings</b></h1>
      <!-- Example Bar Chart Card-->
     <?php 
	// define variables and set to empty values
	$request_dir = $_SERVER['SERVER_NAME'];	
		if(isset($_POST['monnfy'])){
		include('inc/monn_api_setting.php');
		    }
		$query_monn = $conn->query("SELECT * FROM monnify_api");
		$ufnk = $query_monn->fetch_assoc();
		?> 
       
  <form action="" method="post" autocomplete = 'off' > 
  
     <table class="table  margin-tp-10" id="transTable">
     
     
     <td width="30%"><i class="fa fa-user"></i> API Key</td>
                            <td id="mainService"> <input type="text" name="monn_key"  value="<?php echo $ufnk['monn_apikey'];?>" class="form-control" required> </td>
                        </tr>
                        
     <td width="30%"><i class="fa fa-lock"></i> Secret Key</td>
                            <td id="mainService"> <input type="text" name="monn_sec"  value="<?php echo $ufnk['monn_secret'];?>" class="form-control" required> </td>
                        </tr>
   
      <td width="30%"><i class="fa fa-lock"></i> Contract Code</td>
                            <td id="mainService"> <input type="text" name="monn_cont"  value="<?php echo $ufnk['monn_contra'];?>" class="form-control" required> </td>
                        </tr>   
                        
                        <td width="30%"><i class="fa fa-lock"></i> Wallet Account Number</td>
                            <td id="mainService"> <input type="text" name="monn_walletid"  value="<?php echo $ufnk['monn_walletid'];?>" class="form-control" required> </td>
                        </tr> 
                   
                   <td id="mainService"><strong>Webhook URL:</strong> </td>
                    <td id="mainService"><badge class="alert alert-warning" > <?php print('https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']). "/plugin/ibank.php" ) ?></badge></td>
                    </tr>
                    <td id="mainService"> </td>
                    <td id="mainService"> <?php maut(); ?></td>
                    </tr>

                    
                                            <tr>
                            <td colspan="2">
                            <button type="submit" id="submit" name="monnfy" class="btn btn-info">Save Settings</button>
                       </td>
                                                                       
                          <td valign="middle"></td>                                             
                        </tr>
                                    </table> 
  
  </form>
  
     
               
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
   <?php include('inc/footer.php');?>