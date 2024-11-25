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
        <li class="breadcrumb-item active">EPIN ACTIVATION Package / </li>
      </ol>
      <div class="row">
        <div class="col-12">
         
        

          <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-wifi"></i> </div>
        <div class="card-body">
         
           
           <form method="POST" action="javascript:void(0)" id="DataPackage">       
         <h4 align="center">EPIN ACTIVATION Package</h4>   
          <div class="row ">
              
              <div class="col-6">
 <label><li class="fa fa-calendar"></li> Package Duration</label>
 
 <select name="duration" class="form-control">
   <option  selected hidden disabled >Select Duration</option>  
   <option value="1">1 Month</option>
   <option value="3">3 Months</option>
   <option value="6">6 Month</option>
   <option value="12">1 Year</option>
  
 </select>
   
 </div>

 
              
  <div class="col-6">
 <label><li class="fa fa-briefcase"></li> Package Name</label>
    <input type="text" name="plan"  class="form-control" placeholder="e.g Dealer" >
 </div>
 
  
 
 
 
              
  <div class="col-6">
 <label><li class="fa fa-money"></li>  Amount</label>
    <input type="text" name="amount"  class="form-control" placeholder="User price" >
 </div>
    
 <div class="col-6">
 <label><li class="fa fa-money"></li> Commision</label>
    <input type="text" name="commission"  class="form-control" placeholder="commission" >
 </div>
 
 </div>
 

 <div class="col-6">
     <label></label>
       <button type="submit" class="form-control btn btn-primary"><li class="fa fa-plus"></li> Add Package</button> 
       <span id="sh"></span>
     </div>
 
 </div>
            
 </form>   
 
 <script>

    $('#DataPackage').submit(function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            type: "POST",
            url: 'add_epin_package.php',
            data: form,
            dataType: "json",
            success:function(data){
                // Process with the response data
            if(data.status === true){        
             Swal.fire({
  position: 'top-end',
  title: data.msg,
  showConfirmButton: false,
  timer: 3500
})
setTimeout(function(){
document.location.reload();    
},2000);
}else { 
  
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
  text: data.msg
})  
    
}
            }
        });
    });

  

</script>

 <?php 
function merchantList($conn){
$merchqry = $conn->query("SELECT * FROM pin_merchants 
INNER JOIN users
ON pin_merchants.merchantid = users.email");
while($mch[] = $merchqry->fetch_assoc()){ }
return json_encode($mch);
}

?>   
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                  <th>Merchant Name</td>
                  <th>Email</th>
               <th>Package</th>
                <th>Amount</th>
              <th>Duration</th>
              <th>Status</th>
              <th>Date</th>
             <th></th>
               
              </tr>
              </thead>
              <tfoot>
              <tr>
                 <th>Merchant Name</td>
                 <th>Email</th>
               <th>Package</th>
                <th>Amount</th>
              <th>Duration</th>
              <th>Status</th>
              <th>Date</th>
              <th></th>
             
              </tr>
              </tfoot>
              <tbody>
                <?php 
               $json_mc = json_decode(merchantList($conn));
               foreach($json_mc  as $row){
               for ($i = 0, $m = count($row); $i < $m; $i++){
               ?>
                <tr>
                  <td><?php echo strtoupper($row->firstname.' '.$row->lastname); ?></td>
                  <td><?php echo $row->merchantid; ?></td>
                  <td><?php echo $row->package; ?></td>
                  <td><?php echo '&#8358;',number_format($row->amountpaid,2,'.',','); ?></td>
                  <td><?php echo $row->duration; ?></td>
                  <td><?php echo $row->status; ?></td>
                  <td><?php echo $row->created_date; ?></td> 
                   
                    <td><a href="delete?e_merchant=<?php echo $row->serial; ?>" class="btn btn-danger" ><i class="fa fa-trash"></i> Delete</a></td>
                </tr>
               
              <?php } } ?>
                </tbody>
            </table>        
             
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