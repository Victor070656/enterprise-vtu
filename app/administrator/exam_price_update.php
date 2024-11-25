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
		 $Runqry = $conn->prepare("SELECT * FROM exam_package WHERE serial=?");
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
 
  <form action="javascript:void(0)" method="post" autocomplete = 'off' id="updateExamplan" > 
  
     <table class="table  margin-tp-10" id="transTable">
                     
                                                                        <tr>
                            <th width="30%">Network code</th>
                            <td id="mainService"> <input type="text" id="b" name="network"  class="form-control" value="<?php echo $row->network;?>" required></td>
                        </tr>
                                                <tr>
                            <th width="30%">Plan</th>
                            <td><input type="text" id="b" name="plan"  class="form-control" value="<?php echo $row->plan;?>" required>  </td>
                        </tr>                   
                                                           
                                          
                    <tr>
                        <th width="30%">Server Code</th>
                        <td><input type="text" id="d" name="code"  class="form-control" value="<?php echo $row->plancode;?>" required></td>
                    </tr> 
                    <tr>
                        <th width="30%">Client Code</th>
                        <td><input type="text" id="dk" name="clientcode"  class="form-control" value="<?php echo $row->clientcode;?>" required></td>
                    </tr>
                    <tr>
                        <th width="30%">
                        User Price</h4></th>
                        <td id="transactionId"><input type="text" id="e" name="userprice"  class="form-control" value="<?php echo $row->price_user;?>" required></td>
                    </tr>                    
                    <tr>
                        <th width="30%">API Price</th>
                        <td><input type="text" id="f" name="apiprice"  class="form-control" value="<?php echo $row->price_api;?>" required></td>
                    </tr> 
                    
                     
                    <tr>
                        <td width="30%">Current Gateway</td>
                        <td><h3><?php echo $row->gateway;?></h3></td>
                    </tr>
                    
                    <tr>
                        <th width="30%">Change Gateway</th>
                        <td><select name="gateway" class="form-control">
   <option  selected hidden disabled >Select API </option>  
   <option value="epins">ePINs</option>
   <option value="husmodata">HusmoData</option>
   <option value="gongoz">Gongoz Data</option>
   <option value="alrahuz">Alrahuz Data</option>
    <option value="shago">Shago</option>
     <option value="vtpass">VTPass</option>
      <option value="mobileng">Mobile Ng</option>
       <option value="smartrecharge">Smart Recharge</option>
        <option value="smeplug">SMEPLUG</option>
         <option value="clubkonnect">ClubKonnect</option>
       
     
 </select></h3></td>
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
  
 
    $('#updateExamplan').submit(function(e){
        e.preventDefault();
        var form = $(this).serialize();
        $.ajax({
            type: "POST",
            url: 'edit_exam_package.php',
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
document.location.replace('exam-pricing.php');    
},2000);

            }
        });
    });

  

</script>
            
        
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>