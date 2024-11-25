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
          
     
     <h1 class="w3-xxxlarge w3-text-green" align="center"><b>SIM Configuration</b></h1>

       
     <?php 
		   // define variables and set to empty values

	$request_dir = $_SERVER['SERVER_NAME'];	
		
		
		if(isset($_POST['rate'])){
		include('inc/api_SIM.php');
		
						}
			
			include('inc/dycheck.php');
		?> 
       
  <form action="" method="post" autocomplete = 'off' > 
  
     <table class="table  margin-tp-10" id="transTable">
     
    
	  <td width="10%"><i class="fa fa-key"></i> API Key</td>
                            <td id="mainService"> <input type="text" name="simkey"  value="<?php echo $apib['simkey'];?>" class="form-control" placeholder="Enter SIM API Key"> </td>
	  
                        </tr> 


<td width="10%"><i class="fa fa-lock"></i> PIN</td>
                            
	  <td id="mainService"> <input type="text" name="simPin"  value="<?php echo $apib['simPin'];?>" class="form-control" placeholder="Enter SIM API PIN"> </td>
	  
	  
							
                        </tr> 

			<td width="10%"><i class="fa fa-server"></i> MTN Server ID</td>
                            
	  <td id="mainService"> <input type="text" name="serverMTN"  value="<?php echo $apib['serverMTN'];?>" class="form-control" placeholder="Enter MTN Server ID"> </td>
	  
	  
							
                        </tr>

	
		  <td width="10%"><i class="fa fa-server"></i> Airtel Server ID</td>
                            
	  <td id="mainService"> <input type="text" name="serverAirtel"  value="<?php echo $apib['serverAirtel'];?>" class="form-control" placeholder="Enter Airtel Server ID"> </td>
	  		
                        </tr>
	  
	  

<td width="10%"><i class="fa fa-server"></i> Glo Server ID</td>
                            
	  <td id="mainService"> <input type="text" name="serverGlo"  value="<?php echo $apib['serverGlo'];?>" class="form-control" placeholder="Enter Glo Server ID"> </td>
	  
	  
							
                        </tr>



	  <td width="10%"><i class="fa fa-server"></i> 9Mobile Server ID</td>
                            
	  <td id="mainService"> <input type="text" name="serverEtisalat"  value="<?php echo $apib['serverEtisalat'];?>" class="form-control" placeholder="Enter 9Mobile Server ID"> </td>
	  
	  
							
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