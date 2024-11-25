<?php 
session_start();
require('../db.php');
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
$user = $_SESSION['user'];
include('../inc/logo.php');	
include('inc/header.php');
?>

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
        <li class="breadcrumb-item active">Money Transfer Gateway </li>
      </ol>
      <div class="row">
        <div class="col-12">
         
           

          <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-wifi"></i> </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           
           <form method="POST" action="javascript:void(0)" id="gatewayPackage">       
         <h4 align="center">ADD Money Transfer Gateway</h4>   
          <div class="row justify-content-center ">
             
        
  <div class="divcol2">
 <strong><li class="fa fa-server"></li>  Bank Name</strong>
    <input type="text" name="plan"  class="form-control" placeholder="e.g FIRST BANK PLC" >
 </div>

  
  
    
 <div class="divcol2">
 <strong><li class="fa fa-server"></li> Bank Code</strong>
    <input type="text" name="code"  class="form-control" placeholder="e.g 011" >
 </div>
 
 
 <div class="divcol">
       <button type="submit" class="btn btn-primary solid"><li class="fa fa-bank"></li> Add Bank</button> 
       <span id="sh"></span>
     </div>
 
 </div>
  </div>
  
 

            
 </form>   
 
 <script>

    $('#gatewayPackage').submit(function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            type: "POST",
            url: 'add_bank_gateway.php',
            data: form,
            dataType: "json",
            success:function(data){
                // Process with the response data
            // alert(data);
             Swal.fire({
  position: 'top-end',
  title: data,
  showConfirmButton: false,
  timer: 3500
})
setTimeout(function(){
document.location.reload();    
},2000);

            }
        });
    });

  

</script>
                  
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