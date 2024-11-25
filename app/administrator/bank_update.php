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
		 $Runqry = $conn->prepare("SELECT * FROM bank_gateway WHERE serial=?");
		 $Runqry->bind_param("i",$sn);
		 $Runqry->execute();
		 $result = $Runqry->get_result();
		 $rdata = $result->fetch_assoc();
		 return json_encode($rdata);
		}
		$row = json_decode(tv($conn,$sn));
		?>   
  

      <!-- Example Bar Chart Card-->
 
  <form action="javascript:void(0)" method="post" autocomplete = 'off' id="updateBank" > 
  
     <table class="table  margin-tp-10" id="transTable">
                     
                            
                                                <tr>
                            <th width="30%">Bank Name</th>
                            <td><input type="text" id="b" name="plan"  class="form-control" value="<?php echo $row->bankname;?>" required>  </td>
                        </tr>                   
                                                           
                                          
                    <tr>
                        <th width="30%">Bank Code</th>
                        <td><input type="text" id="d" name="code"  class="form-control" value="<?php echo $row->bankcode;?>" required></td>
                    </tr>                                       
                    
                    
                    
                    <input type="hidden" name="sn" value="<?php echo $sn?>" >
                    
                  
                                            <tr>
                            <td colspan="2">
                                                                                            <button type="submit" id="submit" class="btn btn-primary">Update Settings</button>
                                <div class="pay-button">
                                                                                                                                                                                                                                
                                </div>
                              							               </td>
                        </tr>
                                    </table> 
  
  </form>
  <script>
  
 
    $('#updateBank').submit(function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            type: "POST",
            url: 'edit_bank.php',
            data: form,
            dataType: "json",
            success:function(data){
                // Process with the response data
            // alert(data);
             Swal.fire({
  position: 'top-end',
  title: data,
  showConfirmButton: false,
  timer: 3500
})
setTimeout(function(){
document.location.replace('bank-list.php');    
},2000);

            }
        });
    });

  

</script>
            
        
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>