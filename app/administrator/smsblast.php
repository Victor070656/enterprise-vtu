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

							
$deps = "SELECT * FROM deposit ";
$payment = $conn->query($deps);
include('../inc/logo.php');							
?> 
				

<?php include('inc/header.php');?>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">

  <!-- Navigation-->
 <?php include('inc/nav.php');?>
  <!-- Navigation Ends--> 
          </ul>
        </li>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item"> 
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"> </i>
          
           
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
      <li>
        
        </li>
        <li class="nav-item">
          
        </li>
        <li class="nav-item">
        <a class="btn btn-secondary" href="../logout.php">Sign Out</a>
         
        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
  
    <div class="container-fluid">
      <!-- Breadcrumbs-->
     
      <div class="row">
        <div class="col-12">
          
     
     <h2 class="w3-xxxlarge w3-text-green" align="center"><b>SMS Broadcast</b></h2>
 
<?php include('inc/broadcast.php'); ?>
  <form action="" method="post" autocomplete = 'off'> 
	 <div class="form-group">
        <label><font color="#FF0000"><?php echo $no;?></font> Recipients.</label>
		
		 <textarea id="recepient" name="sendto" style="display:block;" class="form-control" ><?php echo $send; ?></textarea>
		
      </div>

	   <div class="w3-group">
        <label><strong>Compose Message</strong></label>
		 <textarea id="message" name="msg" rows="8" placeholder="Compose Message" required class="form-control"></textarea>
		<div class="form-group">
        <label></label><p>
      <button type="submit" name="btn" class="btn btn-info">Send Broadcast</button>
      </div>
    </form>  
 
             
            </div>
            
          </div>
          <!-- Card Columns Example Social Feed-->    
         </p>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
   <?php include('inc/footer.php');?>