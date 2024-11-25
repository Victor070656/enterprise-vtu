<?php 
session_start();
require('../db.php');
						
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
								$user = $_SESSION['user'];
								
			$deps = "SELECT * FROM deposit  ";
			$payment = $conn->query($deps);
							
include('../inc/logo.php');							
								
?> 
<?php include('inc/header.php');?>
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
          
     
     <h2  align="center"><b>Payment Gateway</b></h2>
       

      <!-- Example Bar Chart Card-->
       
     <?php 
		  
			function payswitch($conn){
			$query_rec = mysqli_query($conn,"SELECT * FROM payment");
			$fetchswth = mysqli_fetch_array($query_rec);
			return json_encode($fetchswth);
			}
			$apib = json_decode(payswitch($conn));
			if($apib->activepay === 'paystack'){
				$pstat = "checked";
				$fstat = "unchecked";
				} else {
				$pstat = "unchecked";
				$fstat = "checked";	
					
					}
						
		?> 
       
  <form action="" method="post" autocomplete = 'off' id="payswitch" > 
  

     <table class="table  margin-tp-10" id="transTable">
         
         <tr>
        <td></td> 
        <td><label class="custom-control custom-radio custom-control-inline">
         <input type="radio" id=" payactive" name="payactive"  class="form-control-input" value="paystack"  <?php echo $pstat; ?> ><span class="custom-control"> Paystack</span>
                                            </label>    
                                            
                <label class="custom-control custom-radio custom-control-inline">
          <input type="radio" id=" payactive" name="payactive"  class="form-control-input" value="flutterwave" <?php echo $fstat; ?> > <span class="custom-control"> Flutterwave</span>
                                            </label> </td>
             
         </tr>
         
                  
		 
		 
                    
                    <tr>
                        <td width="30%"> </td>
                        <td>
                        
                        <p></p>
                            
                        <button type="submit" id="switch" name="rate" class="btn btn-warning"><li class="fa fa-gear"></li> Save Settings</button>   
                        
                        </td>
                        
                    </tr>
                            
                            <td colspan="2"></td>
                            <td></td>
                        </tr>
                                    </table> 
  
  </form>
  
  <script>

    $('#payswitch').submit(function(e){
        e.preventDefault();
        //var formData = $('#airPay').serialize();
        var opt = document.querySelector('input[name="payactive"]:checked').value;
        var fdata = {gateway : opt };
        $.ajax({
            url: "inc/payprocess.php",
            type: "POST",
            data: JSON.stringify(fdata),
            dataType: "json",
            contentType: 'application/json; charset=utf-8',
            async : false,
            beforeSend: function(){
                $('#switch').html('<i class="fa fa-spinner"></i> Processing...');
            },
            success:function(data){
                // Process with the response data
            // alert(data);
    if(data.status === true){        
  var description = data.msg; 

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
}

            }
        });
    });

  
</script>
              
  
                              
        
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
   <?php include('inc/footer.php');?>