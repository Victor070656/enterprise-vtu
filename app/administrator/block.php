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
								
if(isset($_GET['email'])){
					
$res_user = $_GET['email'];	
		}				
							
$mems = "SELECT * FROM users WHERE email='$res_user'  ";
$details = $conn->query($mems);
							
							
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
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Deactivate Account / </li>
      </ol>
      <div class="row">
        <div class="col-12">
          
       
          <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> <?php echo $data['firstname']; ?> <?php echo $data['lastname']; ?> </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Name</td>
                <th>Email Address</td>
                <th>Phone</td>
                <th>Status</td>
                <th>IP Address</td>
              
              </tr>
              </thead>
             
              <tbody>      
                <tr>
                <?php 
				
				while( $row_details = $details->fetch_assoc())
				
				{
				
				?>
                  <td><?php echo $row_details['firstname']; ?> <?php echo $row_details['lastname']; ?></td>
                  <td><?php echo $row_details['email']; ?></td>
                  <td><?php echo $row_details['phone']; ?></td>
                  <td><?php echo $row_details['level']; ?></td>
                  <td><?php echo $row_details['IPaddress']; ?></td>
                  
                  <?php } ?>
                </tr>
                </tbody>
            </table>
             <?php
			 
			 $mem = "SELECT * FROM users WHERE email='$res_user'  ";
			$rek_user = $conn->query($mem);
			
			 $user_data = mysqli_fetch_array($rek_user);
		  
		  if(isset($_POST['submit'])){
			  
		  $fname = $_POST['fname'];
		  $email = $_POST['email'];
		  $level = $_POST['level'];
		  $block = $_POST['blockinfo'];
		  $blocked = '';
		  $unblock = 'Unblock';
		  $blockstat = $_POST['blockstat'];
		  $blockpro = '1';
		  
		  $update = "UPDATE users set level='$level',blockinfo='$block',block='$blocked',blockstat='$blockstat',unblock='$unblock',blockpro='$blockpro' WHERE email='$email'";
		  mysqli_query($conn,$update);
		 
		  
             if($update){
				 
				echo "<img src='image/AccessGranted.png'> <br>
				Account Blocked.<br>
				 <div class='btn btn-primary btn-block'>Redirecting....Please wait.</div>      
				<script> 
				setTimeout(function(){
				window.location.href='dashboard.php';},3000);</script>";
			 }
			 else {
			 echo "Activation Failed";
			 }}
			 

		  
		   ?>
          <form action="" method="post" id="active" >
          <input name="fname" type="hidden" value="<?php echo $user_data['firstname']; ?>">
          <input name="email" type="hidden" value="<?php echo $user_data['email']; ?>">
          <input name="level" type="hidden" value="free">
          <input name="blockstat" type="hidden" value="<font color=red>Blocked</font>">
          <input name="blockinfo" type="hidden" value="<font color=red>Your Account is blocked. Contact Support</font>">
         <input type="submit" value="Block <?php echo $user_data['firstname']; ?>'s Account." name="submit" class="btn btn-secondary btn-block">
          
          </form>
          </div>
        </div>
        <div class="card-footer small text-muted"></div>
      </div>
    </div>
    <!-- /.container-fluid-->
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>