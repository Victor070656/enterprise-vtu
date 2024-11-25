<?php
ob_start();
session_start();
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
require_once('../db.php');
include('../inc/logo.php');
include('inc/header.php');?>

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
        <li class="nav-item dropdown">
          
        </li>
        <li class="nav-item dropdown">
         
          
            
           
        </li>
        <li class="nav-item">
         
        </li>
        <li class="nav-item">
        <a class="btn btn-secondary" href="logout.php">Logout</a>
          
        </li>
      </ul>
    </div>
  </nav>
    <?php 
		$user = $_SESSION['user'];
	?> 
  
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="dashboard.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Administrator/</li>
      </ol>
      <div class="row">
        <div class="col-12">
          
          <div class="card mb-3">
        <div class="card-header">
        
        <?php if(alert($conn) > 0){ ?>
        <div class=" alert alert-warning"><a href="kyc.php"> You have <?php echo alert($conn); ?> Pending KYC request</a></div>    
      <?php  } ?>
        
          <?php include('inc/balance.php');	?>  
        
          </div>
         
          
        <div class="card-body">
          <div class="table-responsive">
            <canvas id="graphCanvas" style="height:400px" class="table"></canvas> 
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
      <script src="js/graphchart.js"></script>
    <?php function alert($conn){
         $alt = $conn->query("SELECT * FROM kyc_info WHERE status='Pending'");
         $ar = $alt->num_rows;
         return $ar;
        } include('inc/footer.php');?>

