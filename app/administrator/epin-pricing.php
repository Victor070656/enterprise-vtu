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
     <h1 class="w3-xxxlarge w3-text-yellow" align="center"><b>EPIN ACTIVATION </b></h1>
   
     <?php 
		$Runqry = $conn->query("SELECT * FROM epin_package");
		?> 
       
     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                 <th>Duration</td>
                <th>Package Name</td>
                
                <th>Amount</td>
                <th>Commission</td>
                
                <th></th>
                <th></th>
              </tr>
              </thead>
              <tfoot>
              <tr>
                    <th>Duration</td>
                <th>Package Name</td>
                
                <th>Amount</td>
                <th>Commission</td>
              <th></th>
              <th></th>
              </tr>
              </tfoot>
              <tbody>
                <?php 
                $row = array();
              // $count = count($row);
               while($row = $Runqry->fetch_assoc()){ ?>
                <tr>
                  <td><?php echo strtoupper($row['duration']).' Month'; ?></td>
                  <td><?php echo $row['plan']; ?></td>
                   
                  
                    <td><?php echo '&#8358;'.number_format($row['amount'],2); ?></td>
                    <td><?php echo '&#8358;'.number_format($row['commission'],2); ?></td>
                  
                    <td><a href="epin_price_update.php?id=<?php echo $row['serial']; ?>" class="btn btn-info" ><i class="fa fa-pencil"></i> Modify</a></td>
                    <td><a href="delete_epinplan.php?id=<?php echo $row['serial']; ?>" class="btn btn-danger" ><i class="fa fa-trash"></i> Delete</a></td>
                </tr>
               
              <?php } ?>
                </tbody>
            </table>
</div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>