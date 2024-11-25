<!doctype html>
<html lang="en">
<?php 
session_start();
require('db.php');
include('inc/logo.php');
?>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    <link rel="icon" type="image/png" href="logincontent/images/icons/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Instant VTU Recharge Portal</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="#"><?php logo1($sitelogo); ?></a>
           <hr> 
       <h3>Set New Password</h3>     
    
<?php

$qrySt = $conn->query("SELECT * FROM settings");
$rowset = $qrySt->fetch_assoc();
$sitename = $rowset['sitename'];
$siteurl = $_SERVER['SERVER_NAME'];
$request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);

$errorMessage = '';
$FailerrorMessage = "Password do not match";

$successMessage = "Password Reset successful ";

$request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);
					  
if(!isset($_GET['o'])){
    
?><script>document.location='/';</script> <?php
}else{
	
	$resetPas = base64_decode($_GET['o']);
	
	$Stm_qry = mysqli_query($conn,"SELECT email,firstname FROM users WHERE email='$resetPas' ");
	
	$Rowdata = mysqli_fetch_array($Stm_qry);
	
	$myName = $Rowdata['firstname'];
	$target_email = $Rowdata['email'];
	if($resetPas !== $target_email){
	    
	echo '<div  class="alert alert-danger col-sm-12">Invalid Account </div> '; 
	    
	print('<script>
		document.location="/";</script>');    
	}else{
	
	
	$frm = '
                <form method="post" action="">
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="newpass" id="newpass" type="password" placeholder="Enter New Password " autocomplete="off" value="">
                    </div>
                  
                  
                   <div class="form-group">
                        <input class="form-control form-control-lg" name="confirmpass" id="confirmpass" type="password" placeholder="Confirm New Password " autocomplete="off" value="">
                    </div>
                   
                   
                    <button type="submit"  name="cpwd" class="btn btn-primary btn-lg btn-block">Change Password</button>
                </form>
                
                
            </div>
            <div class="card-footer bg-white p-0  ">
                
              
            </div>
        </div>
    </div>';
	
	
	
if(isset($_POST['cpwd'])){
    
    $RecovPwd = filter_var(test_input($_POST['newpass']),FILTER_SANITIZE_STRING);
    $Conf_RecovPwd = filter_var(test_input($_POST['confirmpass']),FILTER_SANITIZE_STRING);
    
   $SetNewPas = password_hash($RecovPwd, PASSWORD_DEFAULT);
    $ConfirmNewPas =  password_hash($Conf_RecovPwd, PASSWORD_DEFAULT); 
    
    if($RecovPwd !== $Conf_RecovPwd){
        
    echo '<div  class="alert alert-danger col-sm-12">'.$FailerrorMessage.'</div>';    
    }else{
    
$newPas = $conn->prepare("UPDATE users SET pass=? WHERE email=?");
$newPas->bind_param("ss",$SetNewPas,$resetPas);

if($newPas->execute()){

$qrysite = mysqli_query($conn,"SELECT * FROM settings");
$sql_logo = mysqli_fetch_array($qrysite);
// send email

$from = "".$sql_logo['sitename']."<no-reply@".$sql_logo['sitename'].">"; //the email address from which this is sent
$to = $Rowdata['email']; //the email address you're sending the message to
$subject = "Password Change Notification"; //the subject of the message

// To send HTML mail, the Content-type header must be set
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "Return-Path: ".$sql_logo['sitename']."<".$sql_logo['sitename'].">\r\n";
$headers .= "Organization: ".$sql_logo['sitename']."\r\n";
 
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

<h3>Dear $myName,</h3>

Your account password has been changed successfully. <p> 

".$sql_logo['sitename']." helps you make payments for services you enjoy right from your bedroom, office or on the go. <br>
 We offer you instant and automated recharge for Airtime, Data, Gotv, Dstv, Bet9ja, Startimes, Electric Token,Smile, Spectranet etc.<p>

<a href='https://".$_SERVER['SERVER_NAME']."'><button class='button'>Check it out!</button></a> <br>


Regards, <p>


</body><html>";

//now mail
$DoMail = mail($to,$subject,$message,$headers);

echo '<div  class="alert alert-success col-sm-12">'.$successMessage.'</div> <script>
			setTimeout(function(){ document.location="/" }, 1000);</script>';	

session_unset();    

session_destroy(); 
// end and destroy session
}		

$newPas->close();
    }			
		
}	

$conn->close();

	}
	
}
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = filter_var($data, FILTER_SANITIZE_STRING);
   return $data;
}
?>
       
        
<?php print($frm); ?>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
 
</html>