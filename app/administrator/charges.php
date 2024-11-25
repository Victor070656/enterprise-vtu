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
           
           <form method="POST" action="javascript:void(0)" id="fees">       
         <h4 align="center">Service Charges / Commissions Setup</h4>  
         
          <div class="row justify-content-center">
       
       <div class="col-6">
 <strong><li class="fa fa-server"></li> Service Type </strong>
 
 <select name="datatype" class="form-control">
   <option  selected hidden disabled >Select Service Type</option>  
   <option value="moneytransfer">Money Transfer fee (%)</option>
   <option value="accountupgrade">Account Upgrade Fee</option>
   <option value="portalsetup">Portal Setup</option>
   <option value="affiliate">Portal Setup Referal (%)</option>
   <option value="epinactivation">ePIN Upgrade Referal (%)</option>
   <option value="gotv">Gotv (%)</option>
   <option value="dstv">Dstv (%)</option>
   <option value="startimes">Startimes (%)</option>
   <option value="bulksms">BulkSMS</option>
   
 </select>
   
 </div>
 
  <div class="col-6">
 <strong><li class="fa fa-money"></li>  Normal Users</strong>
    <input type="number" name="user" min="0"  step="0.01" class="form-control" placeholder="e.g 1.4" >
 </div>

 <div class="col-6">
 <strong><li class="fa fa-money"></li> API Users</strong>
    <input type="number" name="api" min="0" step="0.01" class="form-control" placeholder="e.g 1.3" >
 </div>

<div class="col-6">
    <p></p>
       <button type="submit" class="btn btn-primary solid"><li class="fa fa-plus"></li> Add / Update</button> 
       <span id="sh"></span>
     </div>
     
 </div>
 
 
 <span style="color:red">  <i class="fa fa-exclamation-triangle"></i> Please note: Service types with (%) must have  percentage value in the price.</span>
  </div>
  



            
 </form>   
 
 <script>

    $('#fees').submit(function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            type: "GET",
            url: 'add_charges.php',
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
     <h1 class="w3-xxxlarge w3-text-yellow" align="center"><b>Service Charges </b></h1>
   
     <?php 
		$Runqry = $conn->query("SELECT * FROM charges");
		?> 
       
     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                 <th>Service</td>
                <th>Normal User Fee</td>
                <th>API User Fee</td>
                <th></th>
              </tr>
              </thead>
              <tfoot>
              <tr>
                 <th>Service</td>
                <th>Normal User Fee</td>
                <th>API User Fee</td>
                <th></th>
              </tr>
              </tfoot>
              <tbody>
                <?php 
                $row = array();
              // $count = count($row);
               while($row = $Runqry->fetch_assoc()){ ?>
                <tr>
                  <td><?php echo strtoupper($row['service']); ?></td>
                  
                    <td><?php echo $row['user']; ?></td>
                    <td><?php echo $row['api']; ?></td>
                  <td><?php echo $row['gateway']; ?></td>
                    
                    <td><a href="delete_fee.php?id=<?php echo $row['serial']; ?>" class="btn btn-danger" ><i class="fa fa-trash"></i> Delete</a></td>
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