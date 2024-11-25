
<?php 
if(isset($_POST['news'])){	
    
		$planE = $_POST['n'];
		$planF = $_POST['b'];
		$planG = $_POST['l'];
		$planH = $_POST['h'];
		$showhide = $_POST['imgStat'];
		
	if(!empty($planE)  ) {	
		
	// upload picture
$request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);
$target_dir = "uploads/news/";
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
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType !="jpeg" && $imageFileType != "gif" && $imageFileType != "webp" ) { echo "Sorry, only JPG, JPEG, PNG, webp & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "  ";
// if everything is ok, try to upload file
} else {
    
    
if (move_uploaded_file($_FILES["file"]["tmp_name"], "$target_dir" . $newfilename
        
        
       )) {
     

$fileurl = 'https://'.$request_dir.'/uploads/news/'.$newfilename.' ';	    
		
	$sql_store = $conn->query("UPDATE newsalert SET content='$planE',btn='$planF',link='$planG',heading='$planH',img_link='$fileurl',img_stat='$showhide'");	

if($sql_store){
?>
<div class='alert alert-success'>Settings saved</div>
<script>
setTimeout(function(){
    
window.location.replace('<?php echo basename($_SERVER['PHP_SELF']); ?>');    
},2000);

</script>
<?php
}
}}

	}else{
		
echo "<div class='alert alert-danger'>Field cannot be empty</div>";		
		}
}	
		
					
		
	
?>