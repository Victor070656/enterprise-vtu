<?php
session_start();
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
require('../db.php');						
								
								$user = $_SESSION['user'];
								
								$ins = mysqli_query($conn,"SELECT * FROM users WHERE email='$user' ");
								$data = mysqli_fetch_array($ins);
								
								$email = $data['email'];
								$rowpas = $data['pass'];
								$bal = $data['bal'];
							
			$deps = "SELECT * FROM deposit  ";
			$payment = $conn->query($deps);
	

define("sitename","Vtoper");
define("footername","vtoper.com");
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
     
      <div class="row">
        <div class="col-12">
          
     
     <h1 class="w3-xxxlarge w3-text-green" align="center"><b>Debit Wallet</b></h1>
       

      <!-- Example Bar Chart Card-->
       
     <?php 
		   // define variables and set to empty values
      include("function/functions.php");
      
      
	  
	  if(isset($_GET['id'])){
      
      $id = $_GET['id']; 
    $getuser = mysqli_query($conn, "SELECT * FROM users WHERE accno='$id' ");
    
    $qryuser = mysqli_fetch_array($getuser);
    
    $receiver = $qryuser['email'];
      
  }else{
      
      $receiver = "";
  }



$sender = 'eRecharge';	

$qrySt = mysqli_query($conn,"SELECT * FROM settings");
 $Getsit = mysqli_fetch_array($qrySt);
 
 $sitname = $Getsit['sitename'];
 $siturl = $_SERVER['SERVER_NAME'];
 $adminTel = $Getsit['mobile'];
 $sitlogo = $Getsit['sitelogo'];
 
 $datTime = date('Y-m-d H:m:s');
		
	if(isset($_POST['creditbtn'])){
				
		$dest = $_POST['sendto'];
		$amount = $_POST['amount'];
		$order = $_POST['order'];
		$stat = "Completed";
		$process = "";
		$del = "";
		
		
		
		// replace comma
		$str1 = $amount;
        $xamount = str_replace( ',', '', $str1);
		
		$description = "Debit Credit";
		
		$type = $_POST['type'];
		
		if($type === 'Debit'){
		    
		    $typ = "Completed";
		    $transTyp = "Debit";
		    
		    $showref = "Transaction Ref:"; 
		}else{
		    
		     $typ = "Reversed";
		     
		    $showref = "Transaction Ref:"; 
		    
		    $transTyp = "Reverse";
		}
		
		$channel = "Admin";
		
		$ref = mt_rand(5345678910,6789012372);
		
		$txt = "Your wallet has been Debited N$amount; Transaction ID:$ref. Thank you for choosing www.$siturl ";

if(empty($dest)){
	echo "Enter Customer Email";
	}
if(empty($amount)){
    
    echo "Enter Amount";
}	
		
  $getbal = "SELECT * FROM users WHERE email='$dest' ";
  $qbal = mysqli_query($conn,$getbal);
  $show = mysqli_fetch_array($qbal);
  
  $bal = $show['bal'];
  $phone = $show['phone'];
  $fname = $show['firstname'];
  $lname = $show['lastname'];
  $email = $show['email'];
  
  $newbal = $bal+$xamount;
  
  if($dest === $email){
      
  $addfund = "UPDATE users set bal=bal-$xamount WHERE email='$email' ";
  $qfund = mysqli_query($conn,$addfund);
  
  if($qfund){
      
$depos = "SELECT * FROM deposit WHERE ref='$order' ";
$qry = mysqli_query($conn,$depos);
$dro = mysqli_fetch_array($qry);
$orderno = $dro['ref'];
$amt = $dro['amount'];

// update deposit

if($order === $orderno){
$updepo = "UPDATE deposit set status='$stat',process='$process',del='$del' WHERE ref='$orderno' ";
  $qdep = mysqli_query($conn,$updepo); }else{
      
          
$Trans = "SELECT * FROM transactions WHERE ref='$order' ";
$qryTran = mysqli_query($conn,$Trans);
$doTrans = mysqli_fetch_array($qryTran);

$tref = $doTrans['ref'];

      
      if($order === $tref && $type !== 'Debit'){
    
    $updtran = mysqli_query($conn,"UPDATE transactions set status='$typ' WHERE ref='$tref' ");
 
   
      }else{

$addres = "INSERT INTO transactions (network,channel,amount,ref,status,email) VALUES('$description','$channel','$xamount','$ref','$stat','$email')";
	mysqli_query($conn,$addres);
  }
  }
      
      echo '
	<div class="alert alert-success">
    <strong>Wallet Debit</strong> Successful
  </div>

 ';
 
 $data = array(
    
    'username' => $apidata['smsUserid'],
    'password' => $apidata['smsPass'],
	 'sender' => $sender,
	  'recipient' => $phone,
	   'message' => $txt
	    
);
# Create a connection
$url = $apidata['baseurl'];
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch); 	

// Send Email Alert

$from = "$sitname<support@$siturl>"; //the email address from which this is sent
$to = "$email"; //the email address you're sending the message to
$subject = "Wallet $type Transaction "; //the subject of the message

// To send HTML mail, the Content-type header must be set
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "Return-Path: $sitname<support@$siturl>\r\n";
$headers .= "Organization: $sitname\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$message = "

<html>
<head>
<style>
.table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 50%;
}

td {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}


.button {
  background-color: #008CBA; /* Blue */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  border-radius: 8px;
  cursor: pointer;
  
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
}

.button:hover {
  background-color: #4CAF50; /* Green */
  color: white;
}

</style>
</head>

<body>

<img src='https://$siturl/user/sitelogo/$sitlogo'>

<h3>Hey $fname,</h3>

$transTyp Transaction has occur on your $sitname account.  <br>

<strong>Your transaction details are as follows:</strong> <p>

<table class='table' >
  
  <tr>
    <td>Amount</td>
    <td>N$amount</td>
  </tr>
  <tr>
    <td>Transaction ID</td>
    <td> $ref</td>
  </tr>
  
   <tr>
    <td>Date</td>
    <td>$datTime</td>
  </tr>
  
   <tr>
    <td>New Balance</td>
    <td> N$newbal</td>
  </tr>
  
</table> <p>


Thank you for choosing www.$siturl.<p>
 
<p>



</body><html>";

//now mail
$DoMail = mail($to,$subject,$message,$headers);



  }
  
    
}	
else{ 
    echo '
	<div class="alert alert-warning">
    <strong>Account Not Found</strong> - Fund not added
  </div>

 ';
}	

			
}
		?>
	
  
  <form action="" method="post" autocomplete = 'off'> 
  
  <div class="form-group">
        <label><strong>Transaction Type</strong></label>
		 <select name="type" class="form-control" >
		    
		    <option value="Debit">Debit</option>
		    
		 </select>
		 <div id="charNum"></div>
		 
      </div> 
      
      
	 <div class="form-group">
        <label><strong>Customer Email</strong></label>
		
		 <input type="email" id="sendto" name="sendto" value="<?php echo $receiver; ?>"  class="form-control" required>
		
      </div>

	   <div class="form-group">
        <label><strong>Amount</strong></label>
		 <input type="text" id="amount" name="amount" rows="8"   class="form-control" required onKeyUp="javascript:this.value=Comma(this.value);">
		 <div id="charNum"></div>
		 
		  <script>
							 
							 function Comma(Num)
 {
       Num += '';
       Num = Num.replace(/,/g, '');

       x = Num.split('.');
       x1 = x[0];

       x2 = x.length > 1 ? '.' + x[1] : '';

       
         var rgx = /(\d)((\d{3}?)+)$/;

       while (rgx.test(x1))

       x1 = x1.replace(rgx, '$1' + ',' + '$2');
     
       return x1 + x2;       
        
 }
                             </script> 
      </div> 
	  
	  <div class="form-group">
        <label><strong>Order No</strong></label>
		 <input type="text" id="order" name="order" rows="8"   class="form-control" placeholder="Optional" >
		 <div id="charNum"></div>
		 
      </div> 
	  
	  <input name="email" type="hidden" value="<?php echo $data['email'];?>">
      <button type="submit" id="submit" name="creditbtn" class="btn btn-info">Debit Wallet</button>
    </form>  
 
             
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