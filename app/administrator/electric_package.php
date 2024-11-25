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
        <li class="breadcrumb-item active">Elecricity Package / </li>
      </ol>
      <div class="row">
        <div class="col-12">
         
           

          <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-wifi"></i> </div>
        <div class="card-body">
     
           
           <form method="POST" action="javascript:void(0)" id="electricPackage">       
         <h4 align="center">Add Electricity Package</h4>   
          <div class="row ">
          <input type="hidden" id="net">    
              <div class="col-6">
 <label><li class="fa fa-server"></li> Distribution Company </label>
 
 <select name="network" id="network" class="form-control">
   <option  selected hidden disabled >Select Disco</option>  
   <option value="abuja">Abuja Electric</option>
   <option value="enugu">Enugu Electric</option>
   <option value="eko">Eko Electric</option>
   <option value="ikeja">Ikeja Electric</option>
   <option value="ibadan">Ibadan Electric</option>
   <option value="benin">Benin Electric</option>
   <option value="portharcourt">Portharcourt Electric</option>
   <option value="jos">Jos Electric</option>
   <option value="kano">Kano Electric</option>
   <option value="kaduna">Kaduna Electric</option>
   <option value="yola">Yola Electric</option>
 </select>
   
 </div>
 
 <div class="col-6">
 <label><li class="fa fa-server"></li> Gateway Provider</label>
 
 <select name="gateway" class="form-control">
   <option  selected hidden disabled >Select API </option> 
  
   <option value="epins">ePINs</option>
    <option value="shago">Shago</option>
     <option value="vtpass">VTPass</option>
   <option value="husmodata">HusmoData</option>
   <option value="gongoz">Gongoz Data</option>
   <option value="alrahuz">Alrahuz Data</option>
    <option value="paytev">Paytev</option>
       <option value="smartrecharge">Smart Recharge</option>
       <option value="n3tdata">N3tData</option>
         <option value="clubkonnect">ClubKonnect</option>
          
     
 </select>
   
 </div>

  <div class="col-6">
 <label><li class="fa fa-briefcase"></li> Label</label>
    <input type="text" name="plan"  class="form-control" placeholder="e.g EEDC" >
 </div>
<div class="col-6">
 <label><li class="fa fa-briefcase"></li> Discount(%)</label>
    <input type="text" name="discount"  class="form-control" placeholder="e.g 0.8" >
 </div>

 <div class="col-6">
     <label></label>
       <button type="submit" id="btn-add" class="form-control btn btn-info solid"><li class="fa fa-plus"></li> Add/Update</button> 
       <span id="sh"></span>
     </div>
     
     <div class="col-3">
          <label></label>
      <label class="switch ">
	<input class="switch-input" type="checkbox" />
	<span class="switch-label" data-on="On" data-off="Off"></span> 
	<span class="switch-handle"></span> 
</label> 
     </div>
 
 </div>
 </div>
            
 </form>   
 
 <script>

    $('#electricPackage').submit(function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            type: "GET",
            url: 'add_electric.php',
            data: form,
            dataType: "json",
            beforeSend: function(){
                $('#btn-add').html('<i class="fa fa-spinner"></i> Processing...');
            },
            success:function(data){
                // Process with the response data
         if(data.status === true){        
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
  text: data.msg
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
function fetchdisco($conn){
		$Runqry = $conn->query("SELECT * FROM electric_package");
	while($disc[] = $Runqry->fetch_assoc()){}
	return json_encode($disc);
}
		?> 
       
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
            <th>Discos</td>
               <th>Discount(%)</th>
              <th>Gateway</td>
             
                <th>Status</th>
                <th></th>
              </tr>
              </thead>
              <tfoot>
              <tr>
                 <th>Discos</td>
              <th>Discount(%)</th>
                <th>Gateway</td>
              <th>Status</th>
              <th></th>
              </tr>
              </tfoot>
              <tbody>
                <?php 
              $json_disco = json_decode(fetchdisco($conn));
               foreach($json_disco as $pr){ 
               for ($w = 0, $c = count($pr); $w < $c; $w++){
                   
                 if($pr->status === 'enabled'){$color="success";} else {$color="danger";}
               ?>
                <tr>
                  <td><?php echo strtoupper($pr->network.' ('.$pr->plan.')'); ?></td>
                  <td><?php echo $pr->discount.'%'; ?></td>
                  <td><?php echo $pr->gateway; ?></td>
                   <td> <badge class="badge badge-<?php echo $color;?>"><?php echo $pr->status;?> </badge> </td>
                    <td><a href="delete_tvplan.php?id=<?php echo $pr->serial; ?>" class="btn btn-danger" ><i class="fa fa-trash"></i> Delete</a></td>
                </tr>
               
              <?php } } ?>
                </tbody>
            </table>                
        <script>
        
        $('#network').change(function(){
        var Net = $(this).val(); 
         $('#net').val(Net);
         $.ajax({url:"fetch_power_status.php", type:'GET', data: {nwk:Net}, dataType:'json',
      success:function(re){ 
        
        if (re.msg === 'enabled'){  
          $('.switch-input').prop('checked',true);
        } else  {
             $('.switch-input').prop('checked',false);
            
        }
          
      }
             
         });
        });       
              $('.switch-input').change(function(){
                  
      if(this.checked && $('#net').val() === ''){ 
        $(this).prop("checked", false);
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
  text: 'Select Disco'
})   
      
       
      } else {
   if(this.checked){
        var Status = "enabled";
        var Network = $('#net').val();
       // $('#sam').text(Network);
    $.ajax({url:"power_status.php", type:'GET', data: {status:Status,network:Network}, dataType:'json',
      success:function(data){ 
      if(data.status === true){
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
  text: data.msg
})  

setTimeout(()=>{
 window.location.reload();   
},3000);
      } else {
          
      }
     }
    });

   } else {
       
     var Status = "disabled";
     var Network = $('#net').val();
    $.ajax({url:"power_status.php", type:'GET', data: {status:Status,network:Network}, dataType:'json',
      success:function(data){ 
      if(data.status === true){
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
setTimeout(()=>{
 window.location.reload();   
},3000);
      } else {
          
      }
     }
    });
   } }
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