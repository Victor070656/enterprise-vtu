
<?php 
		$planA = $_POST['a'];
		$planB = $_POST['b'];
		$planC = $_POST['c'];
		$planD = $_POST['d'];
		$planE = $_POST['e'];
		$planF = $_POST['f'];
		$planG = $_POST['g'];
		$planH = $_POST['h'];
		$planI = $_POST['i'];
		
		
	if(!empty($planA) && !empty($planB) && !empty($planC) && !empty($planD) && !empty($planE) && !empty($planF) && !empty($planG) && !empty($planH) && !empty($planI)) {	
		
		
	$sql_store = mysqli_query($conn,
	
	"UPDATE sme_data SET
	etisalatA='$planA',
	etisalatB='$planB',
	etisalatC='$planC',
	etisalatD='$planD',
	etisalatE='$planE',
	etisalatF='$planF',
	etisalatG='$planG',
	etisalatH='$planH',
	etisalatI='$planI' 
");	

echo "<div class='alert alert-success'>Settings saved</div>";
	}else{
		
echo "<div class='alert alert-danger'>Field cannot be empty</div>";		
		}
		
	
?>