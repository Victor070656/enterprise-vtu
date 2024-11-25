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
		function tv($conn,$sn){
		 $Runqry = $conn->prepare("SELECT * FROM pins_package WHERE serial=?");
		 $Runqry->bind_param("i",$sn);
		 $Runqry->execute();
		 $result = $Runqry->get_result();
		 $rdata = $result->fetch_assoc();
		 return json_encode($rdata);
		}
		$row = json_decode(tv($conn,$sn));
		?>   
           
     
     <h1 class="w3-xxxlarge w3-text-red" align="center"><b><?php echo strtoupper($row->network); ?> Pricing</b></h1>

      <!-- Example Bar Chart Card-->
 
  <form action="javascript:void(0)" method="post" autocomplete = 'off' id="updateEpinplan" > 
  
     <table class="table  margin-tp-10" id="transTable">
                     
                                                                        <tr>
                            <th width="30%">Network</th>
                            <td id="mainService"> <input type="text" id="b" name="network"  class="form-control" value="<?php echo $row->network;?>" required></td>
                        </tr>
                                                <tr>
                            <th width="30%">Plan</th>
                            <td><input type="text" id="b" name="plan"  class="form-control" value="<?php echo $row->plan;?>" required>  </td>
                        </tr>          
                        
                          <tr>
                            <th width="30%">Code</th>
                            <td><input type="text" id="cd" name="code"  class="form-control" value="<?php echo $row->code;?>" required>  </td>
                        </tr>                   
                                                           
                                                           
                    <tr>
                        <th width="30%">
                        User Price</h4></th>
                        <td id="transactionId"><input type="text" id="e" name="amount"  class="form-control" value="<?php echo $row->price_user;?>" required></td>
                    </tr>                    
                    <tr>
                        <th width="30%">API Price</th>
                        <td><input type="text" id="f" name="apiamount"  class="form-control" value="<?php echo $row->price_api;?>" required></td>
                    </tr> 
                    
                     
                 
                          
                    
                    <input type="hidden" name="sn" value="<?php echo $sn?>" >
                    
                  
                                            <tr>
                            <td colspan="2">
                                                                                            <button type="submit" id="submit" class="btn btn-info">Save Settings</button>
                                <div class="pay-button">
                                                                                                                                                                                                                                
                                </div>
                              							               </td>
                        </tr>
                                    </table> 
  
  </form>
  <script>
  
 
    $('#updateEpinplan').submit(function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            type: "GET",
            url: 'edit_pin_price.php',
            data: form,
            dataType: "json",
            success:function(data){
                // Process with the response data
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
  text: data
})  
setTimeout(function(){
document.location.replace('pin_pricing.php');    
},2000);

            }
        });
    });

  

</script>
            
        
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>