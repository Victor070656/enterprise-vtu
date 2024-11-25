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
          
     <div class="table-responsive"> 
     <p></p>
     <h3 class="w3-xxxlarge w3-text-yellow" align="center"><b>Bank Transfer Responses </b></h3>
   
     <?php 
     function gatewayResponse($conn){
		$Runqry = $conn->query("SELECT * FROM transfer_response ORDER BY `datetime` DESC");
		while($tres[] = $Runqry->fetch_assoc()){}
		return json_encode($tres);
     }
		?> 
       
     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                
                <th>Gateway</td>
                <th>Amount</td>
                <th>Fee</td>
                <th>ResponseMessage</td>

                <th>ResponseCode</th>
                <th>Date</th>
              </tr>
              </thead>
              <tfoot>
              <tr>
               <th>Gateway</td>
                <th>Amount</td>
                <th>Fee</td>
                <th>ResponseMessage</td>
                
                
                <th>ResponseCode</th>
                <th>Date</th>
              </tr>
              </tfoot>
              <tbody>
                <?php 
                $jsonRes = json_decode(gatewayResponse($conn));
               foreach($jsonRes as $row){  
               for( $i = 0, $t = count($row); $i < $t; $i++){
               ?>
                <tr>
                  
                  <td><?php echo $row->gateway; ?></td>
                   <td><?php echo '&#8358;'.$row->amount; ?></td>
                  <td><?php echo '&#8358;'.$row->fee; ?></td>
                    <td><?php echo $row->responseMessage; ?></td>
                   
                  <td><?php echo $row->responseCode; ?></td>
                  <td><?php echo $row->datetime; ?></td>
                    
                </tr>
               
              <?php } } ?>
                </tbody>
            </table>
</div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>