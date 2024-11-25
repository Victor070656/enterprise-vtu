<?php require('../Connections/db.php'); ?>
<?php

define("sitename","Vtoper");
define("footername","vtoper.com");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo sitename ?></title>
  <!-- Bootstrap core CSS-->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="../css/sb-admin.css" rel="stylesheet">
  <link rel="shortcut icon" href="../../image/favicon.ico" type="image/x-icon">
  <link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>

<style>
.danger {
    background-color: #ffdddd;
    border-left: 20px solid #f44336;
}
/* Style inputs, select elements and textareas */
input[type=text], select, textarea{
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  resize: vertical;
}

/* Style the label to display next to the inputs */
label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

/* Style the submit button */
input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

/* Style the container */
.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

/* Floating column for labels: 25% width */
.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

/* Floating column for inputs: 75% width */
.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }

</style>
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script src="//code.jquery.com/jquery-2.1.4.min.js"></script> 
<script type="text/javascript">
$(function() {
  $('.tabs nav a').on('click', function() {
    show_content($(this).index());
  });
  
  show_content(0);

  function show_content(index) {
    // Make the content visible
    $('.tabs .content.visible').removeClass('visible');
    $('.tabs .content:nth-of-type(' + (index + 1) + ')').addClass('visible');

    // Set the tab to selected
    $('.tabs nav a.selected').removeClass('selected');
    $('.tabs nav a:nth-of-type(' + (index + 1) + ')').addClass('selected');
  }
});</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<script type="text/javascript">
//paste this code under the head tag or in a separate js file.
	// Wait for window load
	setTimeout(function(){ $(".se-pre-con").fadeOut("slow");
	$(window).load(function() {
		// Animate loader off screen
		
	});},1000);  </script>
    
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>    
<link rel="stylesheet" href="../menustyle/styles.css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="../menustyle/script.js"></script> 
 <script>

  $( function() {
    $("#content" ).accordion({icons:{"header": "ui-icon-plus", "activeHeader": "ui-icon-minus"},
    	collapsible:true, active: false
    });
  } );
</script>

 
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

<?php 
						session_start();
			if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    						header("location: index.php");
   							 exit;
								}
						
								
								$user = $_SESSION['user'];
								
								$ins = mysqli_query($conn,"SELECT * FROM users WHERE email='$user' ");
								$data = mysqli_fetch_array($ins);
								
								$email = $data['email'];
								$rowpas = $data['pass'];
								$bal = $data['bal'];
							
			$deps = "SELECT * FROM deposit  ";
			$payment = $conn->query($deps);
							
							
								
						?> 

  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="dashboard.php"><?php echo sitename ?></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="dashboard.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        
        <div id='cssmenu'>
<ul>
   <li class='active'><a href='../dashboard.php'><span>Home</span></a></li>
   <li class='has-sub'><a href='#'><span>Data Bundles</span></a>
      <ul>
         <li><a href='../mtn-data.php'><span>MTN Data</span></a></li>
         <li><a href='../9mobile-data.php'><span>9mobile Data</span></a></li>
         <li class='last'><a href='../glo-data.php'><span>Glo Data</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='../vtu.php'><span>Airtime VTU</span></a>
     
   </li>
   
   <li class='has-sub'><a href='#'><span>Pay TV Subscription</span></a>
      <ul>
         <li><a href='../dstv.php'><span>DStv</span></a></li>
         <li class='last'><a href='../gotv.php'><span>Gotv</span></a></li>
         <li class='last'><a href='../startimes.php'><span>Startimes</span></a></li>
      </ul>
   </li>
   
   <li class='has-sub'><a href='#'><span>Pay Electricity Bills</span></a>
      <ul>
         <li><a href='../abuja-electric.php'><span>Abuja Electricity</span></a></li>
         <li class='last'><a href='../ikeja-electric.php'><span>Ikeja Electricity</span></a></li>
         <li class='last'><a href='../portharcourt-electric.php'><span>Port Harcourt Electricity</span></a></li>
         <li class='last'><a href='../kano-electric.php'><span>Kano Electricity</span></a></li>
         <li class='last'><a href='../jos-electric.php'><span>Jos Electricity</span></a></li>
      </ul>
   </li>
    <li class='has-sub'><a href='#'><span>Recharge Card PINs</span></a>
      <ul>
         <li><a href='#'><span>Buy PINs</span></a></li>
         <li class='last'><a href='#'><span>PIN Prices</span></a></li>
      </ul>
   </li>
   
   <li class='has-sub'><a href='#'><span>BulkSMS</span></a>
      <ul>
         <li><a href='http://smsforth.com' target="_blank"><span>Send BulkSMS</span></a></li>
         <li class='last'><a href='smsblast.php'><span>Send SMS Broadcast</span></a></li>
      </ul>
   </li>
   
   <li class='has-sub'><a href='#'><span>GSM Database</span></a>
      <ul>
         <li><a href='#'><span>LGA Database</span></a></li>
         <li class='last'><a href='#'><span>State Database</span></a></li>
         <li class='last'><a href='#'><span>Entire Country Database</span></a></li>
      </ul>
   </li>
   
   <li class='has-sub'><a href='#'><span>My Account</span></a>
      <ul>
         <li><a href='#'><span>Update Profile</span></a></li>
         <li class='last'><a href='../withdraw.php'><span>Withdraw Commission</span></a></li>
         <li class='last'><a href='../fund.php'><span>Fund Account</span></a></li>
         <li class='last'><a href='../transfer.php'><span>Transfer Fund</span></a></li>
      </ul>
   </li>
   <li class='last'><a href='../logout.php'><span>Logout</span></a></li>
</ul>
</div>
        
      
      
      
              </ul>
            </li>
          </ul>
        </li>
        
      </ul>
     
      
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item"> 
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"> </i>
           
           
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
      <li>
        
        </li>
        <li class="nav-item">
          
        </li>
        <li class="nav-item">
        <a class="btn btn-secondary" href="../logout.php">Sign Out</a>
         
        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
  
    <div class="container-fluid">
      <!-- Breadcrumbs-->
     
      <div class="row">
        <div class="col-12">
            
          </b>
     
     <h1 class="w3-xxxlarge w3-text-green" align="center"><b>LOAD PINs</b></h1>
       

    
     <ul class='w3-ul w3-border'>
  <li><b>Load Recharge Card PINs</b></li>
   <li class='w3-container'>
    <div></div>
    
  </li>
  </ul>   
	
     <?php 
		   // define variables and set to empty values
      require("../function/functions.php");
		

		
		if(isset($_POST['btn'])){
				
			
		// insert numbers in db
		
		$store = $_POST["load"];
		$network = $_POST['network'];
		$category = $_POST['category'];

	$brek = explode("\n",$store);
	
	 $no = count($brek);
	
	 echo '<html>
	<body>
	
	<div class="alert alert-success">
    <strong>'.$no.'</strong> '.$network.' PINs Loaded Successfully</a>
  </div>

	</body>
	 </html> ';
	 
	foreach($brek as $key => $enter){
	    
	    $checkk = "SELECT * FROM history  ";
	    $seq = mysqli_query($conn,$checkk);
	    $roq  = mysqli_num_rows ($seq);

	        $sto = "INSERT INTO history(network,recipient,category)VALUES('$network','$enter','$category')";
	    $prox = mysqli_query($conn,$sto);
	    
	    
	}
		
		}
			
			 
			 
			    ?>
	
    


  <form action="" method="post" autocomplete = 'off'> 
  
  
  
  	   <div class="w3-group">
        <label>Select Network</label>
		 <select name="network" required="required">
		     <option value="" selected="selected">Select Network</option>
		     <option value="MTN">MTN</option>
		     <option value="Airtel">Airtel</option>
		     <option value="9Mobile">9Mobile</option>
		     <option value="Glo">Glo</option>
		     
		 </select>
		 
		 <div class="w3-group">
        <label>Select Category</label>
		 <select name="category" required="required">
		     <option value="" selected="selected">Select Category</option>
		     <option value="1">₦100</option>
		     <option value="2">₦200</option>
		     <option value="4">₦400</option>
		     <option value="5">₦500</option>
		     <option value="7.5">₦750</option>
		     <option value="10">₦1000</option>
		     <option value="15">₦1500</option>
		     
		 </select>
		 
		 
		 <div id="charNum"></div>
		  <label>Add PINs to Load</label>
		 <textarea id="load" name="load" placeholder="Paste the PINs to Load" class="w3-input w3-border" cols="150" rows="10"  required></textarea>
      </div> 

  
	
	  
	  
	 
      <button type="submit" name="btn" class="w3-btn-block w3-padding-large w3-green w3-margin-bottom">Load PINs</button>
    </form>  
 
             
            </div>
            
          </div>
          <!-- Card Columns Example Social Feed-->    
         </p>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © <?php echo footername ?> | <b>Total Referred:</b> <?php echo $data['refcount']; ?>  | <b>Verified:</b> <?php echo $data['refverified']; ?> | <b>Unverified:</b> <?php echo $data['refunverified']; ?> | <b>You were referred by:</b> <?php echo $data['refby']; ?></small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Alert Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="exampleModalLabel">Verify Account</h2>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Hello <?php echo $data['firstname']; ?>,  Kindly verify your account to get access to recharge card printing resources and PINs</div>
          <div class="modal-footer">
          <a  href="../active.php?<?php echo md5(rand(65452,90876)); ?>" class="btn btn-primary">Verify Now</a>
            
          </div>
        </div>
      </div>
    </div>
    
    
          
          </div>
        </div>
      </div>
    </div>
    
    
    
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="../vendor/datatables/jquery.dataTables.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="../js/sb-admin-datatables.min.js"></script>
  </div>
  <!--Start of Tawk.to Script-->
  



</body>

</html>

