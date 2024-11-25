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
     <hr>
     <h4 align="center"><b>Bank Transfer Request </b></h4>
   
     <?php 
     function fetchKyc($conn){
		$Runqry = $conn->query("SELECT * FROM kyc_info");
		while($ky[] = $Runqry->fetch_assoc()){}
		return json_encode($ky);
     }
		?> 
       
     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Customer Name</td>
                <th>Phone</td>
                <th>Email</td>
                <th>BVN</td>
                <th>Status</td>
                <th>Request Date</td>
                <th></th>
                <th></th>
                <th></th>
              </tr>
              </thead>
              <tfoot>
              <tr>
                
                <th>Customer Name</td>
                <th>Phone</td>
                <th>Email</td>
                <th>BVN</td>
                <th>Status</td>
                <th>Request Date</td>
              <th></th>
              <th></th>
              <th></th>
              </tr>
              </tfoot>
              <tbody>
                <?php 
                $jsonKyc = json_decode(fetchKyc($conn));
             
               foreach($jsonKyc as $row){ 
               for ($i = 0, $k = count($row); $i < $k; $i++){
               ?>
                <tr>
                  <td><?php echo strtoupper($row->name); ?></td>
                  <td><?php echo $row->phone; ?></td>
                    <td><?php echo $row->email; ?></td>
                   <td><?php echo $row->bvn; ?></td>
                     <td><?php if($row->status === 'Approved'){ ?>
                    <badge class="badge badge-success" ><?php echo $row->status; ?></badge> 
                    <?php }else if($row->status === 'Banned'){ ?>
                    <badge class="badge badge-dark" ><?php echo $row->status; ?></badge> 
                    <?php } else { ?>
                    
                   <badge class="badge badge-primary" ><?php echo $row->status; ?></badge>
                   
                   <?php } ?>
                    
                     </td>
                   <td><?php echo $row->date_created; ?></td>
                    <td>
                        
                        <a href="k_ap.php?a=<?php echo $row->serial;?>" class="btn btn-success" id="apv"><i class="fa fa-check"></i> Approve</a>
                    
                        </td>
                        
                        <td>
                           
                        
                        <a href="b_k.php?b=<?php echo $row->serial;?>" class="btn btn-dark" id="btnban"><i class="fa fa-close"></i> Block</a>
                      
                        
                        </td>
                    <td>
                      
                        
                        <a href="re_kyc.php?r=<?php echo $row->serial;?>" class="btn btn-danger" id="rej"><i class="fa fa-close"></i> Reject</a>
                        </td>
                </tr>
               
              <?php } } ?>
                </tbody>
            </table>
            <span id="def"></span>
    
</div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>