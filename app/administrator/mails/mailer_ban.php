<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require dirname(__FILE__)."/../../PHPMailer/src/Exception.php";
require dirname(__FILE__)."/../../PHPMailer/src/PHPMailer.php";
require dirname(__FILE__)."/../../PHPMailer/src/SMTP.php";

$qrySmtp = $conn->query("SELECT * FROM smtp_settings");
$rowsmtp = $qrySmtp->fetch_assoc();
$smtpHost = $rowsmtp['smtp_host']; 
$smtpPort = $rowsmtp['smtpport'];
$smtpUser = $rowsmtp['smtp_user'];
$smtpPass = $rowsmtp['smtp_pass'];
$support_email = $rowsmtp['adminEmail'];
			$qrysit = mysqli_query($conn,"SELECT * FROM settings");
			$sit = mysqli_fetch_array($qrysit);
						
$sitname = $sit['sitename'];
$hosturl = $_SERVER['HTTP_HOST'];
$base  = basename(dirname(__DIR__));
$cur_url = 'https://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']);
$logoUrl = str_replace($base,"",$cur_url);

$logo = $logoUrl."sitelogo/".$sit['sitelogo']."";				
							
// send email
function SendEmail($conn, $sitname, $hosturl,$token, $fname ,$smtpHost , $smtpPort, $smtpUser, $smtpPass,$support_email,$logo,$logoUrl){
$from = "$sitname<support@$hosturl>"; 
$subject = "Service Restriction Notification"; //the subject of the message
// To send HTML mail, the Content-type header must be set
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "Return-Path: $sitname<support@$hosturl>\r\n";
$headers .= "Organization: $sitname\r\n";
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$message = "<html><body>";
$message .= "<img src='$logo'>";
$message .= "<h1 style='color:#f40;'>Hi $fname!</h1></h3>";
$message .= "Your account has been restricted for bank transfer service. <br>";
$message .= "Kindly contact support. <br>";
$message .= 'Regards, <p>';
$message .= "$sitname Team<p>";
$message .= "$hosturl";
$message .= "</body><html>";

$mail = new PHPMailer(true);
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
    $mail->setFrom("$support_email", "$sitname");
    $mail->addAddress("$token", "$fname");     //Add a recipient
   
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "$subject";
    $mail->Body    = "$message";
    
    $mail->send();
   // echo 'Message has been sent';
  
return $mail;
				
}			

?>