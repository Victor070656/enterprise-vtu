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
	
include('../inc/recaptcha.php');
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
          
     
     <h1 class="w3-xxxlarge w3-text-green" align="center"><b>Add Bank Details</b></h1>
       

      <!-- Example Bar Chart Card-->
       
     <?php 
	 
	function alert(){
		
		echo "
	
	<div class='alert alert-success'>
    Settings Saved
  </div>
  
  <script>
setTimeout(function(){ window.location.href='add_bank.php' }, 1000);</script>
   ";
		
		} 
	 
$chek = mysqli_query($conn,"SELECT * FROM add_bank  ");
 
 $pdata = mysqli_fetch_array($chek);
		  		
		if(isset($_POST['setting'])){
			
$bankname = $_POST['bankname'];

$accno = $_POST['accno'];
$accname = $_POST['accname'];		
			
	if(!empty($bankname) && !empty($accno) && !empty($accname)){
		
	if(mysqli_num_rows($chek) == 0){
		
	$inst = mysqli_query($conn,"INSERT INTO add_bank(BankName,AccNo,AccName) VALUES('$bankname','$accno','$accname');");	
		alert();
			}else{
	
	
		
$updat = mysqli_query($conn,"UPDATE add_bank SET BankName='$bankname',AccNo='$accno',AccName='$accname' ") or die(mysqli_error()); 		

    alert(); }
 
 }else{
	 
	echo "<div class='alert alert-danger'>No Entry made </div>"; 
	 }
       
    } 

		?> 
       
  <form action="" method="post" autocomplete = 'off' > 
  
  <div class="form-group">
        <label><strong>Bank Name</strong></label>
		
<?php
if(empty($pdata['BankName'])){

echo '<select type="text" class="form-control" id="bankname" name="bankname">
<option value="" selected>Select Your Bank</option>
<option value="Access(Diamond) Bank">Access(Diamond) Bank</option>
<option value="Ecobank Bank">Ecobank</option>
<option value="Fidelity Bank">Fidelity Bank</option>
<option value="First Bank">First Bank</option>
<option value="FCMB">First City Monument Bank (FCMB)</option>
<option value="GTBank">Guarantee Trust Bank (GTB)</option>
<option value="Heritage Bank">Heritage Bank</option>
<option value="Keystone Bank">Keystone Bank</option>
<option value="Polaris Bank">Polaris Bank</option>
<option value="Stanbic Bank">Stanbic IBTC Bank</option>
<option value="Sterling Bank">Sterling Bank</option>
<option value="Union Bank">Union Bank</option>
<option value="UBA Bank">United Bank for Africa (UBA)</option>
<option value="Unity Bank">Unity Bank</option>
<option value="Wema Bank">Wema Bank</option>
<option value="Zenith Bank">Zenith Bank</option>
</select>';	
	
	} else{
		
	echo '<input type="text" id="bankname" name="bankname" value="'.$pdata['BankName'].'"  class="form-control" required>';	
		}
?>
		
      </div>
      
      <div class="form-group">
        <label><strong>Account Number</strong></label>
		
		 <input type="text" id="accno" name="accno" value="<?php echo $pdata['AccNo'];?>"  class="form-control" required>
		
      </div>
  
  <div class="form-group">
        <label><strong>Account Name</strong>   </label>
		
		 <input type="text" id="accname" name="accname"  class="form-control" value="<?php echo $pdata['AccName'];?>" required>
         
		
      </div>
    
  
      <button type="submit" id="submit" name="setting" class="btn btn-info">Save Settings</button>
    </form>  
 
    
        
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>