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
          
     
     <h1 class="w3-xxxlarge w3-text-green" align="center"><b>Affiliate Commission</b></h1>
       
<p align="center"><strong>Description:</strong> Percentage to Pay Affiliates  </p>
      <!-- Example Bar Chart Card-->
       
     <?php 
		   // define variables and set to empty values
 
		
		if(isset($_POST['rate'])){
		include('inc/commission.php');
		
						}
			
			
			$query_rec = mysqli_query($conn,"SELECT * FROM commission");
			
			$bil = mysqli_fetch_array($query_rec);
		?> 
       
  <form action="" method="post" autocomplete = 'off' > 
  
     <table class="table  margin-tp-10" id="transTable">
                     
                     
                 
                                                                        <tr>
                            <td width="30%">Airtel Airtime VTU</td>
                            <td id="mainService"> <input type="text" id="airtelvtu" name="airtelvtu" value="<?php echo $bil['airtelvtu'];?>"  class="form-control" required> </td>
                        </tr>
                                                <tr>
                            <td width="30%">MTN Airtime VTU</td>
                            <td><input type="text" id="mtnvtu" name="mtnvtu"  class="form-control" value="<?php echo $bil['mtnvtu'];?>" required>  </td>
                        </tr>                   
                                                            <tr>
                        <td width="30%">GLO Airtime VTU</td>
                        <td><input type="text" id="glovtu" name="glovtu"  class="form-control" value="<?php echo $bil['glovtu'];?>" required></td>
                    </tr>
                                          
                    <tr>
                        <td width="30%">9mobile Airtime VTU</td>
                        <td><input type="text" id="etisalatvtu" name="etisalatvtu"  class="form-control" value="<?php echo $bil['9mobilevtu'];?>" required></td>
                    </tr>                                       
                    <tr>
                        <td width="30%"><stro>DSTV Subscription</h4></td>
                        <td id="transactionId"><input type="text" id="dstv" name="dstv"  class="form-control" value="<?php echo $bil['dstv'];?>" required></td>
                    </tr>                    
                    <tr>
                        <td width="30%">Airtel Data</td>
                        <td><input type="text" id="airtelData" name="airtelData"  class="form-control" value="<?php echo $bil['airtelData'];?>" required></td>
                    </tr>       
                    
                    <tr>
                        <td width="30%">MTN Data </td>
                        <td><input type="text" id="mtnData" name="mtnData"  class="form-control" value="<?php echo $bil['mtnData'];?>" required></td>
                    </tr>      
                    
                     <tr>
                        <td width="30%">GLO Data </td>
                        <td><input type="text" id="gloData" name="gloData"  class="form-control" value="<?php echo $bil['gloData'];?>" required></td>
                    </tr>
                    
                    
                     <tr>
                        <td width="30%">9mobile Data</td>
                        <td><input type="text" id="etisalatData" name="etisalatData"  class="form-control" value="<?php echo $bil['9mobileData'];?>" required></td>
                    </tr>
                    
                    
                     <tr>
                        <td width="30%">Gotv Payment </td>
                        <td><input type="text" id="gotv" name="gotv"  class="form-control" value="<?php echo $bil['gotv'];?>" required></td>
                    </tr>
                    
                     <tr>
                        <td width="30%">Startimes Subscription </td>
                        <td><input type="text" id="startimes" name="startimes"  class="form-control" value="<?php echo $bil['startimes'];?>" required></td>
                    </tr>
                    
                     <tr>
                        <td width="30%">Ikeja Electric Payment - PHCN </td>
                        <td><input type="text" id="ikeja-electric" name="ikeja-electric"  class="form-control" value="<?php echo $bil['IkejaElectric'];?>" required></td>
                    </tr>
                    
                    
                     <tr>
                        <td width="30%">Eko Electric Payment - EKEDC </td>
                        <td><input type="text" id="eko-electric" name="eko-electric"  class="form-control" value="<?php echo $bil['EkoElectric'];?>" required></td>
                    </tr>
                    
                    
                     <tr>
                        <td width="30%">WAEC Result Checker PIN</td>
                        <td><input type="text" id="waec" name="waec"  class="form-control" value="<?php echo $bil['waec'];?>" required></td>
                    </tr>
                    
                     <tr>
                        <td width="30%">KEDCO - Kano Electric </td>
                        <td><input type="text" id="kano-electric" name="kano-electric"  class="form-control" value="<?php echo $bil['Kedc'];?>" required></td>
                    </tr>
                    
                     <tr>
                        <td width="30%">PHED - Port Harcourt Electric </td>
                        <td><input type="text" id="phed" name="phed"  class="form-control" value="<?php echo $bil['Phed'];?>" required></td>
                    </tr>
                    
                     <tr>
                        <td width="30%">Smile Payment </td>
                        <td><input type="text" id="smile" name="smile"  class="form-control" value="<?php echo $bil['smile'];?>" required></td>
                    </tr>
                    
                     <tr>
                        <td width="30%">Jos Electric - JED </td>
                        <td><input type="text" id="jos-electric" name="jos-electric"  class="form-control" value="<?php echo $bil['JosElectric'];?>" required></td>
                    </tr>
                    
                     <tr>
                        <td width="30%">IBEDC - Ibadan Electric </td>
                        <td><input type="text" id="ibedc" name="ibedc"  class="form-control" value="<?php echo $bil['Ibedc'];?>" required></td>
                    </tr>
                    
                    <tr>
                        <td width="30%">AEDC - Abuja Electric </td>
                        <td><input type="text" id="aedc" name="aedc"  class="form-control" value="<?php echo $bil['aedc'];?>" required></td>
                    </tr>
                    
                                            <tr>
                            <td colspan="2">
                                                                                            <button type="submit" id="submit" name="rate" class="btn btn-info">Save Settings</button>
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