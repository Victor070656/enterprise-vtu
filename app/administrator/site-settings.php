<?php 
session_start();
require('../db.php');
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
						
	$user = $_SESSION['user'];

	
include('../inc/recaptcha.php');
include('../inc/logo.php');	
							
						?> 

<?php include('inc/header.php');?>

<body class="fixed-nav sticky-footer bg-light" id="page-top">



  <!-- Navigation-->
 <?php include('inc/nav.php');?>
        
  <!-- Navigation Ends--> 
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
  
    <div class="container-fluid">
      <!-- Breadcrumbs-->
     
      <div class="row justify-content-center">
        <div class="col-8" >
        <hr>  
     
     <h2 class="w3-xxxlarge w3-text-green" align="center"><b>Settings</b></h2>
       

      <!-- Example Bar Chart Card-->
       
     <?php 
	 
$chek = mysqli_query($conn,"SELECT * FROM settings  ");
 
 $pdata = mysqli_fetch_array($chek);
		  		
		if(isset($_POST['setting'])){
			
$sitename = $_POST['sitename'];

$mobile = $_POST['mobile'];
$ad_email = $_POST['email'];

$sitekey = $_POST['sitekey'];
$secretkey = $_POST['secretkey'];		
			
	if(!empty($sitename) && !empty($sitekey) && !empty($secretkey) && !empty($ad_email)){

$updat = mysqli_query($conn,"UPDATE settings SET sitekey='$sitekey',secretkey='$secretkey',sitename='$sitename',mobile='$mobile',email='$ad_email'  ") or die(mysqli_error()); 

    echo "
	
	<div class='alert alert-success'>
    Settings Saved
  </div>
  
  <script>
setTimeout(function(){ window.location.href='site-settings.php' }, 1000);</script>
   ";

 }else{
	 
	echo "<div class='alert alert-danger'>No Entry made </div>"; 
	 }
       
    } 

?> 
    
  <form action="" method="post" autocomplete = 'off' > 
  
  <div class="row">
  <div class="col-6">
  <div class="form-group">
        <label><strong>Site Name</strong></label>
		
		 <input type="text" id="sitename" name="sitename" value="<?php echo $pdata['sitename'];?>"  class="form-control" >
		
      </div>
      </div>
      
      <div class="col-6">
      <div class="form-group">
        <label><strong>Contact Phone</strong></label>
		
		 <input type="text" id="mobile" name="mobile" value="<?php echo $pdata['mobile'];?>"  class="form-control" >
		
      </div>
      </div>
      
      </div>
      
        <div class="row">
      <div class="col-6">
      <div class="form-group">
        <label><strong>Admin Email</strong></label>
		
		 <input type="email" id="email" name="email" value="<?php echo $pdata['email'];?>"  class="form-control" >
		
      </div>
      </div>
  
  <div class="col-6">
  <div class="form-group">
        <label><strong>Recaptcha Site Key</strong>   <a href="https://www.google.com/recaptcha/admin/create" target="_blank">Create recaptcha v2 here</a> </label>
		
		 <input type="text" id="sitekey" name="sitekey"  class="form-control" value="<?php echo $pdata['sitekey'];?>" >
		
      </div>
      
      </div>
      </div>
      
      
        <div class="row">
      <div class="col-6">
      <div class="form-group">
        <label><strong>Recaptcha Secret Key</strong></label>
		
		 <input type="text" id="secretkey" name="secretkey"  class="form-control" value="<?php echo $pdata['secretkey'];?>" >
		
      </div>
      </div>

	  <div class="col-6">
      <div class="form-group">
      <button type="submit" id="submit" name="setting" class="btn btn-primary">Save Changes</button>
      </div></div>
      </div>
    </form>  
    
   
 
<?php 
if(isset($_POST['logo'])){
	
$target_dir = "../sitelogo/";
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
    Settings Saved
  </div>
  
  <script>
setTimeout(function(){ window.location.href='site-settings.php' }, 1000);</script>
   ";

$updatlogo = mysqli_query($conn,"UPDATE settings SET sitelogo='$newfilename'") or die(mysqli_error()); 

       
    } else {
        echo "<div class='alert alert-danger'>Sorry, there was an error uploading your 
file. </div>";
    }
}
   
    } 

?> 
<form action="" method="post" autocomplete = 'off' enctype="multipart/form-data" > 
  
  <div class="form-group">
        <label><strong>Site Logo</strong> </label>
		 <input type="file" name="file" id="file" class="form-control" required >
		    
		 <img src="../sitelogo/<?php echo $pdata['sitelogo'];?>"> 
         <div id="charNum"></div>
		 
      </div> 
   
	  
      <button type="submit" id="submit" name="logo" class="btn btn-info">Change Logo</button>
    </form>

     <hr>       
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