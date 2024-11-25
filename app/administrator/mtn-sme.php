<?php 
session_start();
require('../db.php');
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
								
$user = $_SESSION['user'];

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
          
     
     <h1 class="w3-xxxlarge w3-text-yellow" align="center"><b>MTN SME </b></h1>
       
<p align="center"><strong>Description:</strong> This is the amount that will be charged on every transaction. </p>
      <!-- Example Bar Chart Card-->
       
     <?php 
		   // define variables and set to empty values
 
		
		if(isset($_POST['sme'])){
		include('inc/mtnSME.php');
		
			}
			
			$query_rec = mysqli_query($conn,"SELECT * FROM sme_data");
			
			$bil = mysqli_fetch_array($query_rec);
			$sme1GB = $bil['mtnA'];
			$cg1GB = $bil['mg1'];
		?> 
       
  <form action="" method="post" autocomplete = 'off' > 
  
     <table class="table  margin-tp-10" id="transTable">
                     
                                                                        <tr>
                            <td width="30%">MTN SME Data - 1GB</td>
                            <td id="mainService"> <input type="text" id="a" name="a" value="<?php echo $sme1GB;?>"  class="form-control" required> </td>
                        </tr>
                        
                        
                                                <tr>
                            <td width="30%">MTN CG Data - 1GB</td>
                            <td><input type="text" id="b" name="b"  class="form-control" value="<?php echo $cg1GB;?>" required>  </td>
                        </tr> 
                        
                       <!-- 
                          <tr>
                        <td width="30%">MTN CG Data - 15GB</td>
                        <td><input type="text" id="c" name="c"  class="form-control" value="<?php //echo $cg1GB*15;?>" required></td>
                    </tr>
                
                                   
                    <tr>
                        <td width="30%">MTN CG Data - 20GB</td>
                        <td><input type="text" id="d" name="d"  class="form-control" value="<?php //echo $cg1GB*20;?>" required></td>
                    </tr>                                       
                    <tr>
                        <td width="30%"><stro>MTN CG Data - 40GB</h4></td>
                        <td id="transactionId"><input type="text" id="e" name="e"  class="form-control" value="<?php // echo $cg1GB*40;?>" required></td>
                    </tr>                    
                    <tr>
                        <td width="30%">MTN SME Data - 75GB</td>
                        <td><input type="text" id="f" name="f"  class="form-control" value="<?php //echo $cg1GB*75;?>" required></td>
                    </tr>       
                    <tr>
                        <td width="30%">MTN SME Data - 100GB</td>
                        <td><input type="text" id="g" name="g"  class="form-control" value="<?php //echo $cg1GB*100;?>" required></td>
                    </tr>   
                    
                    -->
                                            <tr>
                            <td colspan="2">
                                                                                            <button type="submit" id="submit" name="sme" class="btn btn-info">Save Settings</button>
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