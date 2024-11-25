<?php 
session_start();
require('../db.php');
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
								
$user = $_SESSION['user'];
?> 
<?php
define("sitename","Vtoper");
define("footername","vtoper.com");
include('../inc/logo.php');
?>

<?php include('inc/header.php');?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">



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
          
     
     <h2 class="w3-xxxlarge w3-text-blue" align="center"><b>Reseller Setup/Upgrade</b></h2>
       
<p align="center"><strong>Description:</strong> This is the amount that will be charged for Portal Setup And Upgrade. </p>
      <!-- Example Bar Chart Card-->
       
     <?php 
		   // define variables and set to empty values
 
		
		if(isset($_POST['setup'])){
		include('inc/setup.php');
		
						}
			
			
			$query_rec = mysqli_query($conn,"SELECT * FROM billing");
			
			$bil = mysqli_fetch_array($query_rec);
			
			
		?> 
       
  <form action="" method="post" autocomplete = 'off' > 
  
     <table class="table  margin-tp-10" id="transTable">
                     
                                                                        <tr>
                            <td width="30%">Portal Setup Fee</td>
                            <td id="mainService"> <input type="text" id="a" name="a" value="<?php echo $bil['setup'];?>"  class="form-control" required> </td>
                        </tr>
                                                <tr>
                            <td width="30%">Reseller Upgrade Fee</td>
                            <td><input type="text" id="b" name="b"  class="form-control" value="<?php echo $bil['reseller'];?>" required>  </td>
                        </tr>               
                        
                        
                        <tr>
                            <td width="30%">Affiliate(Percentage)</td>
                            <td><input type="text" id="c" name="c"  class="form-control" value="<?php echo $bil['affiliate'];?>" required>  </td>
                        </tr>              
                                                            <tr>
                    
                    
                    
                                            <tr>
                            <td colspan="2">
                                                                                            <button type="submit" id="submit" name="setup" class="btn btn-info">Save Settings</button>
                                <div class="pay-button">
                                                                                                                                                                                                                                
                                </div>
                              							               </td>
                        </tr>
                                    </table> 
  
  </form>
  
        
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>