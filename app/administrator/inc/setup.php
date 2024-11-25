
<?php 
		$planA = $_POST['a'];
		$planB = $_POST['b'];
		$planC = $_POST['c'];
		
		
	if(!empty($planA) && !empty($planB) ) {	
		
		
	$sql_store = mysqli_query($conn,
	
	"UPDATE billing SET
	setup='$planA',
	reseller='$planB',
	affiliate='$planC'
 
");	

echo "<div class='alert alert-success'>Settings saved</div>";
	}else{
		
echo "<div class='alert alert-danger'>Field cannot be empty</div>";		
		}
		
	
?>