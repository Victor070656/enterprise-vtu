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
          <p></p>
     
     <h1 class="w3-xxxlarge w3-text-green" align="center"><b>Load Recharge PINs </b></h1>
       

      <!-- Example Bar Chart Card-->
       
     <?php 
	
 
		if(isset($_POST['upload'])){
			
// insert numbers in db
		
		$store = trim($_POST["load"]);
		$network = trim($_POST['network']);
		$category = trim($_POST['category']);
			
			if($category == '1'){
				$val = "N100";
			}elseif($category == '2'){
				
				$val = "N200";
			}elseif($category == '4'){
				
				$val = "N400";
			}elseif($category == '5'){
				
				$val = "N500";
			}elseif($category == '7.5'){
				
				$val = "N750";
			}elseif($category == '10'){
				
				$val = "N1000";
			}elseif($category == '15'){
				
				$val = "N1500";
			}
			
	$brek = explode("\n",$store);
	
	 $no = count($brek);
	
	foreach($brek as $key => $enter){
	    
	    $checkk = "SELECT * FROM pinstock WHERE pins='$enter' ";
	    $seq = mysqli_query($conn,$checkk);
	    $roq  = mysqli_num_rows ($seq);
	
		if($roq == 0){
			
			$flag = 1;
			
	        $sto = "INSERT INTO pinstock(net,deno,pins)VALUES('$network','$category','$enter')";
	    $prox = mysqli_query($conn,$sto);
			
		}else{
			
			$flag = 0;
			
			
			
		}
	    
	}
		
			
if($flag == 1){
	
  echo '<div class="alert alert-success">'.$no.' '.$network.' PIN Loaded Successful</div> </p>';
}else{
	
	echo '<div class="alert alert-danger">'.$network.' PIN Already Exist</div> </p>';


}
unset($enter);
			
			
		}
		?> 
       
  <form action="" method="post" autocomplete = 'off' enctype="multipart/form-data"> 
  
  
  
  <div class="form-group">
	  
	  <label><strong>Select Network</strong></label>
	  
        <select name="network" class="form-control" required="required">
		     <option value="" selected="selected">Select Network</option>
		     <option value="MTN">MTN</option>
		     <option value="Airtel">Airtel</option>
		     <option value="9mobile">9Mobile</option>
		     <option value="Glo">Glo</option>
		     
		 </select>
		 
      </div> 
      
      
	 <div class="form-group">
        <label><strong>Select Category</strong></label>
		
		<select name="category" class="form-control" required="required">
		     <option value="" selected="selected">Select Category</option>
		     <option value="1">₦100</option>
		     <option value="2">₦200</option>
		     <option value="4">₦400</option>
		     <option value="5">₦500</option>
		     <option value="7.5">₦750</option>
		     <option value="10">₦1000</option>
		     <option value="15">₦1500</option>
		     
		 </select>
		
      </div>

	   <div class="form-group">
        <label><strong>Add PINs to Load</strong></label>
		
		
		 <textarea id="load" name="load" placeholder="Paste the PINs to Load" class="form-control" cols="150" rows="10"  required></textarea>
		
      </div>
	  
	  
      <button type="submit" id="submit" name="upload" class="btn btn-info">Load PINs</button>
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
    <?php include('inc/footer.php');?>