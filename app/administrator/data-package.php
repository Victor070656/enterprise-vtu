<?php 
session_start();
require_once('../db.php');
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
        <li class="breadcrumb-item active">Data Package / </li>
      </ol>
      <div class="row">
        <div class="col-12">
         
           

          <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-wifi"></i> </div>
        <div class="card-body">
         
           <form method="POST" action="javascript:void(0)" id="DataPackage">       
         <h4 align="center">ADD DATA Package</h4>   
          <div class="row ">
              
              <div class="col-6">
 <label><li class="fa fa-server"></li> Network</label>
 
 <select name="network" class="form-control">
   <option  selected hidden disabled >Select Network</option>  
   <option value="01">MTN</option>
   <option value="04">Airtel</option>
   <option value="02">Glo</option>
   <option value="03">9Mobile</option>
   <option value="smile">Smile</option>
   <option value="spectranet">Spectranet</option>
     
 </select>
   
 </div>

  <div class="col-6">
 <label><li class="fa fa-server"></li> DataType</label>
 
 <select name="datatype" class="form-control">
   <option  selected hidden disabled >Select Datatype</option>  
   <option value="sme">SME</option>
    <option value="gifting">Gifting (CG)</option>
      <option value="cglite">CG LITE</option>
   <option value="datacard">Datacard</option>
   <option value="directdata">Direct Data</option>
  
     
 </select>
   
 </div>
 
<div class="col-6">
 <label><li class="fa fa-server"></li> Gateway Provider</label>
 
 <select name="gateway" class="form-control">
   <option  selected hidden disabled >Select API </option>  
   <option value="epins">ePINs</option>
   <option value="bigsub">BigSub</option>
   <option value="zoedatahub">ZoeDataHub</option>
   <option value="markersapi">MarkersAPI</option>
   <option value="gongoz">Gongoz Data</option>
   <option value="alrahuz">Alrahuz Data</option>
    <option value="shago">Shago</option>
     <option value="vtpass">VTPass</option>
      <option value="mobileng">Mobile Ng</option>
       <option value="smartrecharge">Smart Recharge</option>
        <option value="smeplug">SMEPLUG</option>
           <option value="paytev">Paytev</option>
         <option value="clubkonnect">ClubKonnect</option>
          <option value="n3tdata">N3tData</option>
          <option value="simhost">SIM HOST</option>
     
 </select>
   
 </div>
              
  <div class="col-6">
 <label><li class="fa fa-server"></li>  Data Plan</label>
    <input type="text" name="plan"  class="form-control" placeholder="e.g 1GB" >
 </div>
 </div>
  
   <div class="row">
    
 <div class="col-6">
 <label><li class="fa fa-server"></li> Server Code</label>
    <input type="text" name="code"  class="form-control" placeholder="e.g 1000" >
 </div>
 
 <div class="col-6">
 <label><li class="fa fa-server"></li> Client Code</label>
    <input type="text" name="clientcode"  class="form-control" placeholder="e.g 100" >
 </div>
              
  <div class="col-6">
 <label><li class="fa fa-server"></li>  User Price</label>
    <input type="text" name="userprice"  class="form-control" placeholder="User price" >
 </div>
    
 <div class="col-6">
 <label><li class="fa fa-server"></li> API Price</label>
    <input type="text" name="apiprice"  class="form-control" placeholder="API Price" >
 </div>
 
 <div class="col-6">
    <label></label>
       <button type="submit" class="form-control btn btn-success solid"><li class="fa fa-plus"></li> Add Package</button> 
       <span id="sh"></span>
           </div>
    
 
 </div>
 
 </div>
            
 </form>   
 
 <script>

    $('#DataPackage').submit(function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            type: "POST",
            url: 'add_data_package.php',
            data: form,
            dataType: "json",
            success:function(data){
                // Process with the response data
            // alert(data);
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