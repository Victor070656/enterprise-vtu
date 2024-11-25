<?php
$qcal = mysqli_query($conn,"SELECT * FROM earnings WHERE user='$user'  ");
$elog = mysqli_fetch_array($qcal);

$qrysit = mysqli_query($conn,"SELECT * FROM settings");
$sit = mysqli_fetch_array($qrysit);
$sitename = $sit['sitename'];
$serName = $_SERVER['HTTP_HOST'];

	
$check=mysqli_query($conn,"SELECT * FROM bankinfo WHERE email='$user' ");
$num = mysqli_num_rows($check);
$bkinfo = mysqli_fetch_array($check);

if($num === 0){
	$btn = "Add Bank";
	}else{ $btn = "Save changes";}
	
	 // Bank information
  		
if(isset($_POST['bnk'])){

$bankname = test_input($_POST['bankname']);
$accno = test_input(floatval(intval(abs($_POST['accno']))));
$accname = test_input($_POST['accname']);

 if(!empty($bankname) && !empty($accno) && !empty($accname) ){


if ($num ==0){
	
$insertdat = mysqli_query($conn,"INSERT INTO bankinfo(bankname,accno,accname,email) VALUES('$bankname','$accno','$accname','$user') ") or die(mysqli_error());	

ok();

	 }else{

$updat = mysqli_query($conn,"UPDATE bankinfo SET bankname='$bankname',accno='$accno',accname='$accname',email='$user' WHERE email='$user'  ") or die(mysqli_error()); 


ok();

        
	 }
	 }else{
		echo '<div class="alert alert-danger">Enter required field</div> <script>setTimeout(function(){ window.location="earnings.php" }, 2000);</script>'; 
		 }
 
    } 

$period = date('Y-m');	
	// Withdraw Cash
	
  		
if(isset($_POST['withdraw'])){
	
$descr = "Commission Withdrawal";

 if(!empty($_POST['method']) && !empty(floatval(intval(abs($_POST['amount']))))){
	 
	 $amt = floatval(intval(abs($_REQUEST['amount'])));
	 
if ($_REQUEST['method'] !== 'tobank' && floatval(intval(abs($_REQUEST['amount']))) <= floatval(intval(abs($data[0]['refwallet'])))){

$rebalance = strval(floatval(intval(abs($data[0]['refwallet']))) - floatval(intval(abs($amt))));

$current_balance = strval($bal + floatval(intval(abs($amt))));

$pro = mysqli_query($conn,"UPDATE users SET refwallet='$rebalance',bal='$current_balance' WHERE email='$user' ");	

function fetchEarning($conn,$user){
$QrWt = $conn->query("SELECT * FROM earnings WHERE user='$user'");
while($erow[] = $QrWt->fetch_assoc()){}
return json_encode($erow);
}

$Old_withbal = json_decode(fetchEarning($conn,$user),true);

$prevWbal = $Old_withbal[0]['withdrawal'];

$New_withdrawalBal = strval($prevWbal + floatval(intval(abs($amt))));
$comm = mysqli_query($conn,"UPDATE earnings SET withdrawal='$New_withdrawalBal',period='$period' WHERE user='$user' ");	
$stat = "Completed";
$option = "Wallet";


$sendorder = mysqli_query($conn,"INSERT INTO withdraw(name,amount,email,description,status,method,del) VALUES('$fname $lname','$amt','$user','$descr','$stat','$option','Delete'); ");
	
	xt2();
}else{

if($num ==0){xt();}else{

if(intval($_POST['amount']) <= intval($data['refwallet']) && $_REQUEST['method'] !== 'towallet' ){		
$stat = "Pending";
$option = "Bank";		
$sendorder = mysqli_query($conn,"INSERT INTO withdraw(name,amount,email,description,status,method,action,del) VALUES('$fname $lname','$amt','$user','$descr','$stat','$option','Mark as paid','Delete'); ");
xt3();
}else{xt4();}} }
	 }else{
		echo '<div class="alert alert-danger">Enter required field</div> <script>setTimeout(function(){ window.location="earnings.php" }, 2000);</script>'; 
		 }
 
    } 
	 
?>