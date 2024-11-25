<?php 
session_start();
require('../db.php');
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
						
								
$user = $_SESSION['user'];
								
$ins = mysqli_query($conn,"SELECT * FROM users WHERE email='$user' ");
$data = mysqli_fetch_array($ins);
								
$email = $data['email'];
$rowpas = $data['pass'];
$bal = $data['bal'];
							
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
          
     
     <h1 class="w3-xxxlarge w3-text-green" align="center"><b>Add New Service</b></h1>
       

      <!-- Example Bar Chart Card-->
       
     <?php 
		   // define variables and set to empty values
 
		
		if(isset($_POST['upload'])){
			
			
$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);

$newfilename= date('dmYHis').str_replace(" ", "", basename($_FILES["file"]["name"]));

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check file size
if ($_FILES["file"]["size"] > 800000) {
    echo "<div class='alert alert-danger'> file is too large!</div>";
    $uploadOk = 0;
}

// Check if file already exists
if (file_exists($target_file)) {
    
    echo "<div class='alert alert-warning'>Sorry, file already exists. </div>";
    $uploadOk = 0;
    
    
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "  ";
// if everything is ok, try to upload file
} else {
    
    
    if (move_uploaded_file($_FILES["file"]["tmp_name"], "$target_dir" . $newfilename
        
        
       )) {
    
    echo "
	
	<div class='alert alert-success'>
    <strong>'". basename( 
$_FILES["file"]["name"]). "' </strong> has been uploaded successfully!
  </div>
   ";
    
 
 
  $fileurl = ' '.$_SERVER['SERVER_NAME'].'/ap/admin/uploads/'.$newfilename.' ';

$servname = $_POST['servname'];

$link = htmlspecialchars(trim($_POST['link']));
$category = htmlspecialchars(trim($_POST["category"]));
$desc = htmlspecialchars(trim($_POST["desc"]));
$action = htmlspecialchars(trim($_POST['action']));
$delButton = '<button class="btn btn-danger" style="cursor:pointer">Delete</button>';
$editButton = '<button class="btn btn-info" style="cursor:pointer">Edit</button>';
       
$store = mysqli_query($conn,"INSERT INTO services(filename,fileurl,name,link,action,del,edit,category,description) VALUES('$newfilename','$fileurl','$servname','$link','$action','$delButton','$editButton','$category','$desc');") or die(mysqli_error()); 


       
    } else {
        echo "<div class='alert alert-danger'>Sorry, there was an error uploading your 
file. </div>";
    }
}



}
			

	 
		?> 
       
  <form action="" method="post" autocomplete = 'off' enctype="multipart/form-data"> 
  
  <div class="form-group">
        <label><strong>Service Name</strong></label>
		
		 <input type="text" id="servname" name="servname"  class="form-control" required>
		
      </div>
      
       <div class="form-group">
        <label><strong>Description</strong></label>
		
		 <textarea name="desc"  class="form-control" > </textarea>
		
      </div>  
      
      <div class="form-group">
        <label><strong>Category</strong></label>
		
		 <select id="category" name="category"  class="form-control" required>
		     <option selected disabled hidden>Select Category</option>
		     <optgroup label="Select Category">
		         <option value="bill">Bills</option>
		          <option value="airtime">Airtime</option>
		           <option value="data">Data</option>
		           <option value="edu">Educational</option>
		            <option value="bet">Betting</option>
		            <option value="others">Others</option>
		         
		     </optgroup>
		      </select>
		
      </div>
  
  <div class="form-group">
        <label><strong>Service Image </strong> Size: 738 x 415</label>
		 <input type="file" name="file" id="file" class="form-control" >
		    
		 <div id="charNum"></div>
		 
      </div> 
      
      
      
	 <div class="form-group">
        <label><strong>Service URL</strong></label>
		
		 <input type="text" id="link" name="link"  class="form-control" required>
		
      </div>

	   <div class="form-group">
        <label><strong>Action Button Name</strong></label>
		
		 <input type="text" id="action" name="action"  class="form-control" required>
		
      </div>
	  
	  
      <button type="submit" id="submit" name="upload" class="btn btn-info">Add Service</button>
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