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
							
$deps = "SELECT * FROM payalert ";
$payment = $conn->query($deps);
							
	
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
        <li class="breadcrumb-item active">Deposit > </li>
      </ol>
      <div class="row">
        <div class="col-12">
         
           
       
          <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-money"></i> Bank Deposit Notification</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                
                <th>Customer</td>
                <th>Amount</td>
                <th>Paid To Bank</td>
                <th>Teller/Reference</td>
                <th>Status</td>
                
                <th>Date</td>
                 <th></td>
                 <th></td>
                
              </tr>
              </thead>
              <tfoot>
              <tr>
                
                <th>Customer</td>
                <th>Amount</td>
                <th>Paid To Bank</td>
                <th>Teller/Reference</td>
                <th>Status</td>
                
                <th>Date</td>
                <th></td>
                <th></td>
                
              </tr>
              </tfoot>
              <tbody>
              <?php while($row_payment = $payment->fetch_assoc())
			  
			   { ?>
                <tr>
                  
                  <td><?php echo $row_payment['name']; ?></td>
                  <td><?php echo $data['currency']; ?><?php  $num = $row_payment['amount']; echo number_format($num, 2, '.', ',');?> </td>
                  <td><?php echo $row_payment['bank']; ?> </td>
                  <td><?php echo $row_payment['teller']; ?> </td>
                  <td><?php echo $row_payment['status']; ?> </td>
                  
                  
                   <td><?php echo $row_payment['date']; ?></a></td>
                   
                   <td><a href="remov.php?pay=<?php echo $row_payment['serial']; ?>"><?php if(!empty($row_payment['action'])){echo '<div class="btn btn-success">'.$row_payment['action'].'</div>';} ?></a></td>
                   
                   <td><a href="remov.php?delpay=<?php echo $row_payment['serial']; ?>"><?php if(!empty($row_payment['del'])){echo '<div class="btn btn-danger">'.$row_payment['del'].'</div>';} ?></a></td>
                  
                </tr>
                
                <?php } ?>
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