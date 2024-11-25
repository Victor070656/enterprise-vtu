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
  <form action="javascript:void(0)" method="post" autocomplete = 'off' id="updateDataplan" > 
  
    
           <div class="row ">
              
              <div class="col-6">           
                                                                       
                            <label>Network code</label>
                            <input type="text" id="b" name="network"  class="form-control" value="<?php echo $row->network;?>" required>
                            </div>
                          
                           <div class="col-6">   
                            <label>Plan</label>
                        <input type="text" id="b" name="plan"  class="form-control" value="<?php echo $row->plan;?>" required> 
                        </div>
                        
                         <div class="col-6"> 
                        <label>DataType</label>
                    <input type="text" id="c" name="datatype"  class="form-control" value="<?php echo $row->datatype;?>" required>
                    </div>
                    
                    
                                          
                    <div class="col-6"> 
                        <label>Plan Code</label>
                        <input type="text" id="d" name="code"  class="form-control" value="<?php echo $row->plancode;?>" required>
                    </div>   
                    
                    <div class="col-6"> 
                        <label>Client Code</label>
                        <input type="text" id="dk" name="clientcode"  class="form-control" value="<?php echo $row->clientcode;?>" required>
                    </div>  
                    
                    
                   <div class="col-6"> 
                        <label>User Price</h4></label>
                    <input type="text" id="e" name="userprice"  class="form-control" value="<?php echo $row->price_user;?>" required>
                    </div>  
                    
                    
                   <div class="col-6"> 
                        <label>API Price</label>
                    <input type="text" id="f" name="apiprice"  class="form-control" value="<?php echo $row->price_api;?>" required>
                    </div> 
                    
                     <div class="col-6"> 
                        <label>Current Gateway</label>
                    <h4><?php echo $row->gateway;?></h4>
                    </div>
                    
                    <div class="col-6"> 
                        <label>Change Gateway</label>
                <select name="gateway" class="form-control">
   <option  selected hidden disabled >Select API </option> 
  
   <option value="epins">ePINs</option>
   <option value="husmodata">HusmoData</option>
   <option value="markersapi">MarkersApi</option>
   <option value="gongoz">Gongoz Data</option>
   <option value="alrahuz">Alrahuz Data</option>
   <option value="bigsub">BigSub</option>
   <option value="zoedatahub">ZoeDataHub</option>
    <option value="shago">Shago</option>
     <option value="vtpass">VTPass</option>
      <option value="paytev">Paytev</option>
      <option value="mobileng">Mobile Ng</option>
       <option value="smartrecharge">Smart Recharge</option>
        <option value="smeplug">SMEPLUG</option>
         <option value="clubkonnect">ClubKonnect</option>
        
     
 </select>
                    </div>
                    
                    <input type="hidden" name="sn" value="<?php echo $sn;?>" >
                    
                   <div class="col-6"> 
            <label></label>
            <button type="submit" id="submit" name="sme" class="form-control btn btn-info">Save Settings</button>
                                              
                                </div>
                              							               
  
  </form>
  <script>
  
 
    $('#updateDataplan').submit(function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            type: "POST",
            url: 'edit_data_package.php',
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
 

$('.switch-input').change(function(){
      var dtype = "<?php echo $row->datatype;?>";
      var Net = "<?php echo $row->network;?>";
       var sn = "<?php echo $sn;?>";
   if(this.checked){
        var Status = "enabled";
    $.ajax({url:"single_status.php", type:'GET', data: {status:Status,datatype:dtype,network:Net,serial:sn}, dataType:'json',
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
    $.ajax({url:"single_status.php", type:'GET', data: {status:Status,datatype:dtype,network:Net,serial:sn}, dataType:'json',
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
            
         </div>
        <div class="card-footer small text-muted"></div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>