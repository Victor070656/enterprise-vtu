<?php 
session_start();
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
require('../db.php');

$user = $_SESSION['user'];
								
$ins = mysqli_query($conn,"SELECT * FROM users WHERE email='$user' ");
$data = mysqli_fetch_array($ins);
								
$email = $data['email'];
$rowpas = $data['pass'];
$bal = $data['bal'];





if(isset($_GET['id']) && isset($_GET['i'])){
	
	$usid = $_GET['id'];
	
	$cid = $_GET['i'];
	
	
}


$qrins = mysqli_query($conn,"SELECT * FROM users WHERE email='$usid' ");
$wdata = mysqli_fetch_array($qrins);


$deps = mysqli_query($conn,"SELECT * FROM withdraw WHERE serial='$cid'  ");
$payment = mysqli_fetch_array($deps);




							
$bnkdes = mysqli_query($conn,"SELECT * FROM bankinfo WHERE email='$usid'  ");

	$userBnk = mysqli_fetch_array($bnkdes);


include('../inc/logo.php');
?>

<?php include('inc/header.php');?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <?php include('inc/nav.php');?>
        
  <!-- Navigation Ends-->  
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
      
       
            
        </li>
        <li class="nav-item">
         
        </li>
        <li class="nav-item">
        <a class="btn btn-secondary" href="logout.php">Logout</a>
          
        </li>
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
        <li class="breadcrumb-item active">Withdrawal > </li>
      </ol>
      <div class="row">
        <div class="col-12">
         
          
       
          <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-bank"></i><h4><?php echo $wdata['firstname']; echo $wdata['lastname'];?> Bank Details</h4>  </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                
                <th>Bank Name</td>
                <th>Account No</td>
                <th>Account Name</td>
                <th>Amount To Pay</th>
			  <th></th>
                
              </tr>
              </thead>
              <tfoot>
              <tr>
               
                <th>Bank Name</td>
                <th>Account No</td>
                <th>Account Name</td>
               <th>Amount To Pay</th>
			<th></th>
              </tr>
              </tfoot>
              <tbody>
           
			 
                <tr>
                  <td><?php echo $userBnk['bankname']; ?> </td>
                  <td><?php echo $userBnk['accno']; ?> </td>
                  <td><?php echo $userBnk['accname']; ?> </td>
				<td><?php echo 'N'.number_format($payment['amount'],2,'.',',').''; ?></td>	
                  <td><a href="remov.php?afid=<?php echo $cid; ?>"><?php if(!empty($payment['action'])){echo '<div class="btn btn-success">'.$payment['action'].'</div>';} ?></a></td>
                 
                 
                  
                </tr>
                
               
                </tbody>
            </table>
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