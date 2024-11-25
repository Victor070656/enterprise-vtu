
<?php 
		$planA = $_POST['a'];
		$planB = $_POST['b'];
		//$planC = $_POST['c'];
		//$planD = $_POST['d'];
		//$planE = $_POST['e'];
		//$planF = $_POST['f'];
		
		
	if(!empty($planA) && !empty($planB) ) {	
		
		
	$sql_store = mysqli_query($conn,
	
	"UPDATE sme_data SET
	mtnA='$planA',
	mtng='$planB'
	 
");	
/*

mtnC='$planC',
	mtnD='$planD',
	mtnE='$planE',
	mtnF='$planF'

*/
?>
<div class='alert alert-success'>Settings saved</div>
<script>
setTimeout(function(){
    
window.location.replace('<?php echo basename($_SERVER['PHP_SELF']); ?>');    
},2000);

</script>
<?php
	}else{
		
echo "<div class='alert alert-danger'>Field cannot be empty</div>";		
		}
	
		
	
?>