
<?php 

		$smUser = $_REQUEST['smUser'];
		$smPass = $_REQUEST['smPass'];
		$smBase = $_REQUEST['smBase'];
		
	if(!empty($smUser)&& !empty($smPass) && !empty($smBase)  ) {	
		
		
	$sql_store = mysqli_query($conn,
	
	"UPDATE api_setting SET smsUserid='$smUser',smsPass='$smPass',baseurl='$smBase'");	

echo "<div class='alert alert-info'>Settings saved</div>";
	}else{
		
echo "<div class='alert alert-danger'>Field cannot be empty</div>";		
		}
		
	
?>