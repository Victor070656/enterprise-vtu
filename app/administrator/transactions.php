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
							
$trans = "SELECT * FROM transactions  ";
$payment = $conn->query($trans);
			
include('../inc/logo.php');	

						?>  

<?php include('inc/header.php');?>
<body class="fixed-nav sticky-footer bg-light" id="page-top">
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
        <li class="breadcrumb-item active">Transactions /  </li>
      </ol>
      <div class="row">
        <div class="col-12">
         
           
       
          <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Transactions History</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Ref</td>
                <th>Description</td>
                <th>Amount</td>
                <th>Amount Paid</td>
                <th>Customer</td>
                <th>Customer</td>
                <th>Status</td>
                <th>Method</td>
                <th>Date</td>
                <th></th>
               <th></th>
               <th></th>
                
                
              </tr>
              </thead>
              <tfoot>
              <tr>
                <th>Ref</td>
                <th>Description</td>
                <th>Amount</td>
                <th>Amount Paid</td>
                <th>Customer</td>
                <th>Customer</td>
                <th>Status</td>
                <th>Method</td>
                <th>Date</td>
               <th></th>
               <th></th>
               <th></th>
                
              </tr>
              </tfoot>
              <tbody>
              <?php while($row_payment = $payment->fetch_assoc())
			  
			   { 
			   if($row_payment['status'] == 'Completed'){
							    
							    $tranStat = '<badge class="badge badge-pill badge-success">'.$row_payment['status'].'</badge>';
							}elseif($row_payment['status'] == 'Failed'){
							    
							    $tranStat = '<badge class="badge badge-pill badge-danger">'.$row_payment['status'].'</badge>';
							}elseif($row_payment['status'] == 'pending'){
								
							$tranStat = '<badge class="badge badge-pill badge-warning">'.$row_payment['status'].'</badge>';	
								}else{
								
								$tranStat = '<badge class="badge badge-pill badge-info">'.$row_payment['status'].'</badge>';		
									
									}	
			   ?>
                <tr>
                  <td><?php echo $row_payment['ref']; ?> </td>
                  <td><?php echo $row_payment['network']; ?> <br><?php echo $row_payment['phone']; ?></td>
                  <td><?php  echo '&#x20A6;'.number_format($row_payment['amount'], 2, '.', ','). '';?> <br> </td>
                  <td><?php  echo '&#x20A6;'.number_format($row_payment['charge'],2, '.', ','). '';?> <br> </td>
                  
                  <td><?php  echo $row_payment['customer']; ?> </td>
                  <td><?php  echo $row_payment['email'];; ?> </td>
                  
                  <td><?php echo $tranStat; ?> </td>
                  <td><?php echo $row_payment['channel']; ?> </td>
                  
                   <td><?php echo $row_payment['date']; ?></td>
                   
                    <td><a href="remov.php?reverse=<?php echo $row_payment['serial']; ?>"><?php if(!empty($row_payment['action'])){echo '<div class="btn btn-info">'.$row_payment['action'].'</div>';} ?></a></td>
                    
                    <td><a href="remov.php?credit=<?php echo $row_payment['serial']; ?>"><?php if(!empty($row_payment['credit'])){echo '<div class="btn btn-success">'.$row_payment['credit'].'</div>';} ?></a></td>
                   
                   <td><a href="remov.php?deltra=<?php echo $row_payment['serial']; ?>"><?php if(!empty($row_payment['del'])){echo '<div class="btn btn-danger">'.$row_payment['del'].'</div>';} ?></a></td>
                   
                  
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