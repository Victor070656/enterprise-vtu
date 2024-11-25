
<?php 
		$planA = $_POST['a'];
		$planB = $_POST['b'];
		$planC = $_POST['c'];
		$planD = $_POST['d'];
		$planE = $_POST['e'];
		$planF = $_POST['f'];
		$g1 = $_POST['g1'];
		$g2 = $_POST['g2'];
		$g3 = $_POST['g3'];
		$g4 = $_POST['g4'];
		$g5 = $_POST['g5'];
		$g6 = $_POST['g6'];
		$g7 = $_POST['g7'];
		$g8 = $_POST['g8'];
		
		
	if(!empty($planA) && !empty($planB) && !empty($planC) && !empty($planD) && !empty($planE) && !empty($planF)) {	
		
		
	$sql_store = mysqli_query($conn,
	
	"UPDATE sme_data SET
	airtelA='$planA',
	airtelB='$planB',
	airtelC='$planC',
	airtelD='$planD',
	airtelE='$planE',
	airtelF='$planF',
	airtel_1='$g1',
	airtel_2='$g2',
	airtel_3='$g3',
	airtel_4='$g4',
	airtel_5='$g5',
	airtel_6='$g6',
	airtel_7='$g7',
	airtel_8='$g8'
	
");	

echo "<div class='alert alert-success'>Settings saved</div>";
	}else{
		
echo "<div class='alert alert-danger'>Field cannot be empty</div>";		
		}
		
	
?>