<!doctype html>
<html lang="en">
<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$smtpMailRoot =  $_SERVER["DOCUMENT_ROOT"]. dirname($_SERVER['REQUEST_URI']);
require "$smtpMailRoot/PHPMailer/src/Exception.php";
require "$smtpMailRoot/PHPMailer/src/PHPMailer.php";
require "$smtpMailRoot/PHPMailer/src/SMTP.php";
require('db.php');
include('inc/logo.php');
?>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    <link rel="icon" type="image/png" href="logincontent/images/icons/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $_SERVER['SERVER_NAME']; ?></title>
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
            <div class="card-header text-center"><a href="index.php"><?php logo2($sitelogo); ?></a>
           <hr> 
       <h3>Forgot Password?</h3>     
       <span class="splash-description">Don't worry, we'll send you an email to recover your password.</span>
            
<?php
$qrySt = $conn->query("SELECT * FROM settings");
$rowset = $qrySt->fetch_assoc();
$sitename = $rowset['sitename'];
$siteurl = $_SERVER['SERVER_NAME'];
$request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);
$errorMessage = '';	
$qrySmtp = $conn->query("SELECT * FROM smtp_settings");
$rowsmtp = $qrySmtp->fetch_assoc();
$smtpHost = $rowsmtp['smtp_host']; 
$smtpPort = $rowsmtp['smtpport'];
$smtpUser = $rowsmtp['smtp_user'];
$smtpPass = $rowsmtp['smtp_pass'];
$support_email = $rowsmtp['adminEmail'];
					  
if(isset($_POST["reset"]) ) {	
	
	$Stmtpara = filter_var($_POST['resetpass'],FILTER_SANITIZE_STRING);
	
	$qry = mysqli_query($conn,"SELECT * FROM users WHERE email='$Stmtpara' OR phone='$Stmtpara' ");
	
	$dataQuery = mysqli_fetch_array($qry);
	
	$mypass = $dataQuery['pass'];
	$fname = $dataQuery['firstname'];
	
	$comb = array($dataQuery['email'],$dataQuery['phone']);
	$recover_val = base64_encode($dataQuery['email']);
	if(in_array($Stmtpara, $comb)){

sendmailSMTP($conn,$smtpHost,$smtpPort,$smtpUser,$smtpPass,$support_email,$to,$sitename,$fname,$request_dir,$dataQuery,$siteurl,$recover_val);


	
		
		}else{
			
			$errorMessage = "Account doesn't exist";
			
			echo '<div  class="alert alert-danger col-sm-12">'.$errorMessage.'</div>';
			
			}
		
}
$conn->close();

?>
       
        

                <form method="post" action="">
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="resetpass" id="resetpass" type="text" placeholder="Enter Email or Phone Number " autocomplete="off" value="" required>
                    </div>
                  
                   
                   
                    <button type="submit"  name="reset" class="btn btn-primary btn-lg btn-block">Recover Password</button>
                </form>
                
                
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                   Don't have an account? <a href="signup.php" class="footer-link">signup</a></div>
              
            </div>
        </div>
    </div>
 <?php
 
 function sendmailSMTP($conn,$smtpHost,$smtpPort,$smtpUser,$smtpPass,$support_email,$to,$sitename,$myName,$request_dir,$dataQuery,$siteurl,$recover_val){
$from = "$sitename<no-reply@$siteurl>"; //the email address from which this is sent
$to = $dataQuery['email']; //the email address you're sending the message to
$subject = "Your Password has arrived"; //the subject of the message

// To send HTML mail, the Content-type header must be set
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Priority: 1\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    
$message = "<html><body>


<h3 style='color:#f40;'>Hello $myName</h3>

You requested for password recovery on your Account.<br>

<a href='https://$request_dir/password_recovery.php?o=$recover_val'><strong>Reset Password</strong></a><p>

If you didn't make this request, <br>

kindly contact support@$siteurl <p>

Support Team<br>

<b>$siteurl</b><br>
<a href='http://$siteurl'>www.$siteurl</a> <p>

</body><html>";


//now mail

//$send = mail($to,$subject,$body,$headers);
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $smtpHost;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $smtpUser;                  //SMTP username
    $mail->Password   = $smtpPass;               //SMTP password
    $mail->SMTPSecure = 'tls';     //Enable implicit TLS encryption
    $mail->Port       = $smtpPort;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom("$support_email", "$sitename");
    $mail->addAddress("$to", "$fname");     //Add a recipient
   
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "$subject";
    $mail->Body    = "$message";
    
    $mail->send();
   // echo 'Message has been sent';
   
   ?>
   <div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Password recovery link has been sent to your registered email</strong> 
			</div>
	<script>
setTimeout(function(){ window.location.href="forgot-password.php" }, 5000);</script>		
			<?php
} catch (Exception $s) {
   
    ?>
    <div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Mailer Error: { could not connect to SMTP server } </strong> 
			</div>
    <?php
}
} ?> 
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
 
</html>