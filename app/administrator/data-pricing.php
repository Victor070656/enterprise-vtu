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
          
     
     <h1 class="w3-xxxlarge w3-text-yellow" align="center"><b>DATA PRICING </b></h1>

      <!-- Example Bar Chart Card-->
       
     <?php 
		$Runqry = $conn->query("SELECT * FROM data_package");
		?> 
     <div class="table-responsive">  
     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                  <th>Network</td>
                <th>Data Plan</td>
                <th>DataType</td>
                <th>Server Code</td>
                <th>Client Code</td>
                <th>User Price</td>
                <th>API Price</td>
                <th>Gateway</td>
                <th>Status</td>
                <th></th>
                
              </tr>
              </thead>
              <tfoot>
              <tr>
                   <th>Network</td>
                 <th>Data Plan</td>
                <th>DataType</td>
                <th>Server Code</td>
                <th>Client Code</td>
                <th>User Price</td>
                <th>API Price</td>
                <th>Gateway</td>
                 <th>Status</td>
              <th></th>
             
              </tr>
              </tfoot>
              <tbody>
                <?php 
                $row = array();
              // $count = count($row);
               while($row = $Runqry->fetch_assoc()){
                   $tco = $row['network'];
               if($tco == '01'){$network = strtoupper("mtn");}
               if($tco == '02'){$network = strtoupper("glo");}
               if($tco == '03'){$network = strtoupper("9mobile");}
               if($tco == '04'){$network = strtoupper("airtel");}
               
               if($row['status'] === 'enabled'){$color="success";} else {$color="danger";}
  
               ?>
                <tr>
                  <td><?php echo $network; ?></td>
                  <td><?php echo $row['plan']; ?></td>
                   <td><?php echo strtoupper($row['datatype']); ?></td>
                   <td><?php echo $row['plancode']; ?></td>
                   <td><?php echo $row['clientcode']; ?></td>
                    <td><?php echo '&#8358;'.$row['price_user']; ?></td>
                   <td><?php echo '&#8358;'.$row['price_api']; ?></td>
                   <td><?php echo $row['gateway']; ?></td>
                    <td><badge class="badge badge-<?php echo $color;?>"><?php echo $row['status']; ?> </badge> </td>
                    <td><div class="btn-group dropdown">
											<button type="button" class="btn btn-outline-info dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-gear"></i> Action <span class="caret"></span> </button>
											<div class="dropdown-menu">
											    
										<a class="dropdown-item" href="data_price_update.php?id=<?php echo $row['serial']; ?>"> <button class="btn btn-outline-info" style="cursor:pointer"><i class="fa fa-pencil"></i> Edit Single</button> </a>
									
										
										<a class="dropdown-item" href="auto_data_settings.php?id=<?php echo $row['serial']; ?>"> <button class="btn btn-outline-warning" style="cursor:pointer"><i class="fa fa-gear"></i> Auto Pricing</button> </a>
								
								
								<a class="dropdown-item" href="delete_dataplan.php?id=<?php echo $row['serial']; ?>"> <button class="btn btn-outline-danger" style="cursor:pointer"><i class="fa fa-trash"></i> Delete</button> </a>
										
											</div>
										</div>  
                        </td>
                    
                </tr>
               
              <?php } ?>
                </tbody>
            </table>
</div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>