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
        <li class="breadcrumb-item active">TV Package / </li>
      </ol>
      <div class="row">
        <div class="col-12">
         
          <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-wifi"></i> </div>
        <div class="card-body">
        
           
           <form method="POST" action="javascript:void(0)" id="examPackage">       
         <h4 align="center">Add EXAM Package</h4>   
          <div class="row ">
          <input type="hidden" id="net">       
              <div class="col-6">
 <label><li class="fa fa-server"></li> Provider </label>
 
 <select name="network" id="network" class="form-control">
   <option  selected hidden disabled >Select Exam Type</option>  
   <option value="waec">WAEC</option>
   <option value="neco">NECO</option>
   <option value="jamb">JAMB</option>
   <option value="nabteb">NABTEB</option>
   <option value="nbais">NBAIS</option>
 </select>
   
 </div>
 
 <div class="col-6">
 <label><li class="fa fa-server"></li> Gateway Provider</label>
 
 <select name="gateway" class="form-control">
   <option  selected hidden disabled >Select API </option>  
   <option value="epins">ePINs</option>
   <option value="husmodata">HusmoData</option>
   <option value="gongoz">Gongoz Data</option>
   <option value="alrahuz">Alrahuz Data</option>
    <option value="shago">Shago</option>
     <option value="vtpass">VTPass</option>
     <option value="n3tdata">N3tData</option>
      <option value="mobileng">Mobile Ng</option>
       <option value="smartrecharge">Smart Recharge</option>
        <option value="smeplug">SMEPLUG</option>
         <option value="clubkonnect">ClubKonnect</option>
          
 </select>
   
 </div>

  <div class="col-6">
 <label><li class="fa fa-server"></li> Plan</label>
    <input type="text" name="plan"  class="form-control" placeholder="e.g WAEC Result Checker PIN" >
 </div>

  
  
 <div class="col-6">
 <label><li class="fa fa-server"></li> Server Code</label>
    <input type="text" name="code"  class="form-control" placeholder="e.g waecdirect" >
 </div>
 
 <div class="col-6">
 <label><li class="fa fa-server"></li> Client Code</label>
    <input type="text" name="clientcode"  class="form-control" placeholder="e.g waecdirect" >
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
      <label class="switch ">
	<input class="switch-input" type="checkbox" />
	<span class="switch-label" data-on="On" data-off="Off"></span> 
	<span class="switch-handle"></span> 
</label>

</div>
 
</div>
 <div class="col-6">
    <label></label>
       <button type="submit" class="form-control btn btn-primary solid"><li class="fa fa-plus"></li> Add</button> 
       <span id="sh"></span>
     </div>
 
 </div>
 
 
            
 </form>   
 
 <p></p>
 <?php
 function fetchgo($conn){
$qryGo = $conn->query("SELECT * FROM exam_package WHERE network='waec'");
$t = $qryGo->fetch_assoc();
return json_encode($t);
 }
 function fetchds($conn){
$qryds = $conn->query("SELECT * FROM exam_package WHERE network='jamb'");
$ds = $qryds->fetch_assoc();
return json_encode($ds);
 }
 function fetchst($conn){
$qryst = $conn->query("SELECT * FROM exam_package WHERE network='nabteb'");
$st = $qryst->fetch_assoc();
return json_encode($st);
 }
 
 function fetchnc($conn){
$qrync = $conn->query("SELECT * FROM exam_package WHERE network='neco'");
$nc = $qrync->fetch_assoc();
return json_encode($nc);
 }
 function fetchns($conn){
$qryns = $conn->query("SELECT * FROM exam_package WHERE network='neco'");
$ns = $qryns->fetch_assoc();
return json_encode($ns);
 }
 $t = json_decode(fetchgo($conn));
 $d = json_decode(fetchds($conn));
  $s = json_decode(fetchst($conn));
   $n = json_decode(fetchnc($conn));
    $i = json_decode(fetchns($conn));
  if($t->status === 'enabled'){$tcolor="success";} else {$tcolor="danger";}
  if($d->status === 'enabled'){$dcolor="success";} else {$dcolor="danger";}
  if($s->status === 'enabled'){$scolor="success";} else {$scolor="danger";}
  if($n->status === 'enabled'){$ncolor="success";} else {$ncolor="danger";}
  if($i->status === 'enabled'){$icolor="success";} else {$icolor="danger";}
    ?>
  <div> <strong>WAEC:</strong> <badge class="badge badge-<?php echo $tcolor;?>"><?php echo $t->status;?> </badge>   
  <strong>JAMB:</strong> <badge class="badge badge-<?php echo $dcolor;?>"><?php echo $d->status;?> </badge>   
   <strong>NABTEB:</strong> <badge class="badge badge-<?php echo $scolor;?>"><?php echo $s->status;?> </badge> 
     <strong>NECO:</strong> <badge class="badge badge-<?php echo $ncolor;?>"><?php echo $n->status;?> </badge>
     
     <strong>NBAIS:</strong> <badge class="badge badge-<?php echo $icolor;?>"><?php echo $i->status;?> </badge>
   </div>
 
 <script>

    $('#examPackage').submit(function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            type: "POST",
            url: 'add_exam_package.php',
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


        $('#network').change(function(){
        var Net = $(this).val(); 
         $('#net').val(Net);
         $.ajax({url:"fetch_exam_status.php", type:'GET', data: {nwk:Net}, dataType:'json',
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
  text: 'Select Provider'
})   
      
       
      } else {
   if(this.checked){
        var Status = "enabled";
        var Network = $('#net').val();
       // $('#sam').text(Network);
    $.ajax({url:"exam_status.php", type:'GET', data: {status:Status,network:Network}, dataType:'json',
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
    $.ajax({url:"exam_status.php", type:'GET', data: {status:Status,network:Network}, dataType:'json',
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