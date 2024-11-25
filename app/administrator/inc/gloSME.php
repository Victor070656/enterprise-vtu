
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
	gloA='$planA',
	gloB='$planB',
	gloC='$planC',
	gloD='$planD',
	gloE='$planE',
	gloF='$planF',
	gloG='$planG',
	gloH='$planH',
	gloI='$planI' 
");	

echo "<div class='alert alert-success'>Settings saved</div>";
	}else{
		
echo "<div class='alert alert-danger'>Field cannot be empty</div>";		
		}
		
	
?>