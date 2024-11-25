<?php 
session_start();
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
require('Connections/db.php');

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
        <li class="breadcrumb-item active">Unblock Account/ </li>
      </ol>
      <div class="row">
        <div class="col-12">
        
       
          <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> <?php echo $data['firstname']; ?> <?php echo $data; ?> </div>
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
				
				while ( $row_details = $details->fetch_assoc())
				
				{
				
				?>
              
                  <td><?php echo $row_details['firstname']; ?> <?php echo $row_details['lastname']; ?></td>
                  <td><?php echo $row_details['email']; ?></td>
                  <td><?php echo $row_details['phone']; ?></td>
                  <td><?php echo $row_details['level']; ?></td>
                  <td><?php echo $row_details['IPaddress']; ?></td>
                </tr>
                
                <?php } ?>
                </tbody>
            </table>
             <?php
			 
			 $mem = "SELECT * FROM users WHERE email='$res_user'  ";
			$rek_user = $conn->query($mem);
			
			 $user_data = mysqli_fetch_array($rek_user);
		  
		  if(isset($_POST['unblock'])){
			  
		  $fname = $_POST['fname'];
		  $email = $_POST['email'];
		  $level = 'paid';
		  $block = $_POST['blockinfo'];
		  $blocked = 'Block';
		  $unblock = '';
		  $blockstat = $_POST['blockstat'];
		  $blockpro = '0';
		  
		  $update = "UPDATE users set blockinfo='$block',blockstat='$blockstat',unblock='$unblock',block='$blocked', blockpro='$blockpro',level='$level' WHERE email='$email'";
		  mysqli_query($conn,$update);
		 
		  
             if($update){
				 
				echo "
				 <div class='btn btn-primary btn-block'>Redirecting....Please wait.</div>      
				<script> 
				setTimeout(function(){
				window.location.href='dashboard.php';},2000);</script>";
			 }
			 else {
			 echo "Activation Failed";
			 }}
			 

		  
		   ?>
          <form action="" method="post" id="active" >
          <input name="fname" type="hidden" value="<?php echo $user_data['firstname']; ?>">
          <input name="email" type="hidden" value="<?php echo $user_data['email']; ?>">
          <input name="level" type="hidden" value="free">
          <input name="blockstat" type="hidden" value="">
          <input name="blockinfo" type="hidden" value="">
         <input type="submit" value="Unblock <?php echo $user_data['firstname']; ?>'s Account." name="unblock" class="btn btn-success">
          
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