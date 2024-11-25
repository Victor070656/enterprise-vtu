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
    </div>
  </nav>
  <div class="content-wrapper">
  
    <div class="container-fluid">
      <!-- Breadcrumbs-->
     
      <div class="row">
        <div class="col-12">
      <?php 
		$sn = $_GET['id'];
		function data($conn,$sn){
		 $Runqry = $conn->prepare("SELECT * FROM data_package WHERE serial=?");
		 $Runqry->bind_param("i",$sn);
		 $Runqry->execute();
		 $result = $Runqry->get_result();
		 $rdata = $result->fetch_assoc();
		 return json_encode($rdata);
		}
		$row = json_decode(data($conn,$sn));
		
		 $tco = $row->network;
               if($tco == '01'){$network = strtoupper("mtn");}
               if($tco == '02'){$network = strtoupper("glo");}
               if($tco == '03'){$network = strtoupper("9mobile");}
               if($tco == '04'){$network = strtoupper("airtel");}
             if($row->status === "enabled") { $msg_pop = "checked";} else {$msg_pop = "uncheck";}   
		?>   
           
     <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-wifi"></i> </div>
        <div class="card-body">
     <h4 class="w3-xxxlarge w3-text-red" align="center"><b><?php echo $network; ?> Data Pricing</b></h4>

      <!-- Example Bar Chart Card-->
 	<label class="switch ">
	<input class="switch-input" type="checkbox" <?php echo $msg_pop; ?>/>
	<span class="switch-label" data-on="On" data-off="Off"></span> 
	<span class="switch-handle"></span> 
</label>
  <form action="javascript:void(0)" method="post" autocomplete = 'off' id="MassupdateDataplan" > 

   
           <div class="row responsive">
              
              <div class="col-6" style="display:none;">           
                                                                       
                            <label>Network code</label>
                            <input type="text" id="b" name="network"  class="form-control" value="<?php echo $row->network;?>" required>
                            </div>
                          
                           
                        
                         <div class="col-6" style="display:none;"> 
                        <label>DataType</label>
                    <input type="text" id="c" name="datatype"  class="form-control" value="<?php echo $row->datatype;?>" required>
                    </div>
                    
                  
                    
                   <div class="col-6"> 
                        <label>Current User Price</h4></label>
                    <input type="text" id="e" name="userprice"  class="form-control" value="<?php echo $row->price_user;?>" required>
                    </div>  
                    
                    
                    
                   <div class="col-6"> 
                        <label>Current API Price</label>
                    <input type="text" id="f" name="apiprice"  class="form-control" value="<?php echo $row->price_api;?>" required>
                    </div> 
                    
                    <div class="col-6">   
                            <label>Plan</label>
                        <input type="text" id="plan" name="plan"  class="form-control" value="<?php echo $row->plan;?>" required> 
                        </div>
                   
                   <div class="col-6"> 
                        <label><strong>New User Price</strong></h4></label>
                    <input type="text" id="em" name="userprice_multiplier"  class="form-control"  required>
                    </div>
                   <div class="col-6"> 
                        <label><strong>New API Price </strong></label>
                    <input type="text" id="fm" name="apiprice_multiplier"  class="form-control"  required>
                    </div> 
                    
                    <input type="hidden" name="sn" value="<?php echo $sn?>" >
                    
                   <div class="col-6"> 
            
            <label></label>
            <button type="submit" id="allupd" class="form-control btn btn-danger">Update All </button>
                                              
                                </div>
                    
  </form>
  <script>
  $(document).ready(function(){
     $('#plan').prop('readonly',true); 
      $('#e').prop('readonly',true);
       $('#f').prop('readonly',true);
 $('#MassupdateDataplan').submit(function(e){
        e.preventDefault();
        var fdata = $(this).serialize();
        $.ajax({
            type: "GET",
            url: 'auto_data_pricing.php',
            data: fdata,
            dataType: "json",
            success:function(response){
                // Process with the response data
         if(response.status === true){        
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
  text: response.msg
})  
setTimeout(function(){
document.location.replace(response.redirect);    
},3000);
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
  text: response.msg
})  
    
}

            }
        });
    });
    
  });
  
  
  $('.switch-input').change(function(){
      var dtype = "<?php echo $row->datatype;?>";
      var Net = "<?php echo $row->network;?>";
   if(this.checked){
        var Status = "enabled";
    $.ajax({url:"network_status.php", type:'GET', data: {status:Status,datatype:dtype,network:Net}, dataType:'json', beforeSend:function(){$("#allupd").html('<i class="fa fa-edit"></i> Update All');},
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
      } else {
          
      }
     }
    });

   } else {
       
     var Status = "disabled";
    $.ajax({url:"network_status.php", type:'GET', data: {status:Status,datatype:dtype,network:Net}, dataType:'json',
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
      } else {
          
      }
     }
    });
   }
  });


</script>

</div>
 
 <p></p>          							               
  <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> This feature let you set price of all data bundle on a single click. To change all data plan pricing for the selected network, simply enter the unit price for 1GB at the <b>normal user</b> and <b>API User</b> box and click <b>Update All</b>. This will automatically update the price of other plans. <b>Please Note:</b> This only change price from 1GB and above. To set price below 1GB use <b>Single edit</b> button.</div>
 
            
         </div>
        <div class="card-footer small text-muted"></div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>