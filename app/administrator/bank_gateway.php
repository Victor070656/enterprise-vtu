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
        <li class="breadcrumb-item active">Charges </li>
      </ol>
      <div class="row">
        <div class="col-12">
         
           

          <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-money"></i> Service charges </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
           
           <form method="POST" action="javascript:void(0)" id="gateway">       
         <h4 align="center">Manage Bank Gateways</h4>  
         
          <div class="row justify-content-center">
       
     <div class="divcol2">
 <strong><li class="fa fa-server"></li> Gateway Provider</strong>
 
 <select name="gateway" class="form-control">
   <option  selected hidden disabled >Select Gateway </option>  
   <option value="monnify">Monnify</option>
   <option value="shago">Shago</option>
   <option value="vulte">Vulte</option>
   <option value="itex">ITEX</option>
    <option value="remita">REMITA</option>
     
 </select>
   
 </div>
 
 <div class="divcol">
       <button type="submit" class="btn btn-primary solid"><li class="fa fa-exchange"></li> Change</button> 
       <span id="sh"></span>
     </div>

  </div>
  

            
 </form>   
 
 <script>

    $('#gateway').submit(function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            type: "POST",
            url: 'set_bank.php',
            data: form,
            dataType: "json",
            success:function(resp){
                // Process with the response data
    if(resp.status === true){            
            const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

Toast.fire({
  icon: 'success',
  text: resp.msg
})
setTimeout(function(){
document.location.reload();    
},2000);

    }else{
        
            const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

Toast.fire({
  icon: 'error',
  text: resp.msg
})       
    }
            }
        });
    });

  

</script>


<div class="table-responsive"> 
     <strong class="w3-xxxlarge w3-text-yellow" align="center"><b>Current Gateway </b></strong>
   
     <?php 
		$Runqry = $conn->query("SELECT * FROM bank_gateway_settings");
		?> 
       
     <table class="table table" id="dataTable" width="100%" cellspacing="0">
           
             
              <tbody>
                <?php 
                $row = array();
              // $count = count($row);
               while($row = $Runqry->fetch_assoc()){ ?>
                <tr>
                  <td><?php echo strtoupper($row['gateway']); ?></td>
                  
                </tr>
               
              <?php } ?>
                </tbody>
            </table>
</div>
                  
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