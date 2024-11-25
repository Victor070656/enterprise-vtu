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
							
$trans = "SELECT * FROM services  ";
$service = $conn->query($trans);
					
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
        <li class="breadcrumb-item active">Services / </li>
      </ol>
      <div class="row">
        <div class="col-12">
         
           
       
          <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Active Services</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                
                <th>Service Description</td>
                <th></td>
                
                
                 <th></td>
                
              </tr>
              </thead>
              <tfoot>
              <tr>
                
                <th>Service Description</td>
                <th></td>
                
                <th></th>
                <th></td>
                
              </tr>
              </tfoot>
              <tbody>
              <?php while($row_service = $service->fetch_assoc())
			  
			   { ?>
                <tr>
                  
                  <td><strong><?php echo $row_service['name']; ?></strong> <br>
                  <?php echo $row_service['description']; ?>
                  </td>
                  
                  <td><img src="../uploads/<?php echo $row_service['filename']; ?>" width="150"> </td>
                  
                  
                   <td><a href="update_service.php?id=<?php echo $row_service['serial']; ?>"><?php echo $row_service['edit']; ?></a></td>
                   
                   <td><a href="remov.php?del=<?php echo $row_service['serial']; ?>" onclick="window.confirm('Delete <?php echo $row_service['name']; ?>? ');"><?php echo $row_service['del']; ?></a></td>
                  
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