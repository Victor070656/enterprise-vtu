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
          
     
     <h1 class="w3-xxxlarge w3-text-green" align="center"><b>Glo SME Data </b></h1>
       
<p align="center"><strong>Description:</strong> This is the amount that will be charged on every transaction. </p>
      <!-- Example Bar Chart Card-->
       
     <?php 
		   // define variables and set to empty values
 
		
		if(isset($_POST['sme'])){
		include('inc/gloSME.php');
		
						}
			
			
			$query_rec = mysqli_query($conn,"SELECT * FROM sme_data");
			
			$bil = mysqli_fetch_array($query_rec);
		?> 
       
  <form action="" method="post" autocomplete = 'off' > 
  
     <table class="table  margin-tp-10" id="transTable">
                     
                                                                        <tr>
                            <td width="30%">Glo SME Data - 2GB</td>
                            <td id="mainService"> <input type="text" id="a" name="a" value="<?php echo $bil['gloA'];?>"  class="form-control" required> </td>
                        </tr>
                                                <tr>
                            <td width="30%">Glo  SME Data - 4.5GB</td>
                            <td><input type="text" id="b" name="b"  class="form-control" value="<?php echo $bil['gloB'];?>" required>  </td>
                        </tr>                   
                                                            <tr>
                        <td width="30%">Glo SME Data - 7.2GB</td>
                        <td><input type="text" id="c" name="c"  class="form-control" value="<?php echo $bil['gloC'];?>" required></td>
                    </tr>
                                          
                    <tr>
                        <td width="30%">Glo SME Data - 8.75GB</td>
                        <td><input type="text" id="d" name="d"  class="form-control" value="<?php echo $bil['gloD'];?>" required></td>
                    </tr>                                       
                    <tr>
                        <td width="30%"><stro>
                        Glo SME Data - 12.5GB</h4></td>
                        <td id="transactionId"><input type="text" id="e" name="e"  class="form-control" value="<?php echo $bil['gloE'];?>" required></td>
                    </tr>                    
                    <tr>
                        <td width="30%">Glo SME Data - 15GB</td>
                        <td><input type="text" id="f" name="f"  class="form-control" value="<?php echo $bil['gloF'];?>" required></td>
                    </tr>       
                    
                     <tr>
                        <td width="30%">Glo SME Data - 25GB</td>
                        <td><input type="text" id="g" name="g"  class="form-control" value="<?php echo $bil['gloG'];?>" required></td>
                    </tr>  
                    
                     <tr>
                        <td width="30%">Glo SME Data - 52.5GB</td>
                        <td><input type="text" id="h" name="h"  class="form-control" value="<?php echo $bil['gloH'];?>" required></td>
                    </tr>  
                    
                     <tr>
                        <td width="30%">Glo SME Data - 62.5GB</td>
                        <td><input type="text" id="i" name="i"  class="form-control" value="<?php echo $bil['gloI'];?>" required></td>
                    </tr>  
                    
                    
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