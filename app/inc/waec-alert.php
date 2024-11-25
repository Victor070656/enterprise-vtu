<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$smtpMailRoot =  $_SERVER["DOCUMENT_ROOT"];
require "$smtpMailRoot/PHPMailer/src/Exception.php";
require "$smtpMailRoot/PHPMailer/src/PHPMailer.php";
require "$smtpMailRoot/PHPMailer/src/SMTP.php";

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
				$logo = $sit['sitelogo'];
				
$fname = $prevBal->firstname;				
SendEmail($conn, $sitname, $hosturl,$user, $fname , $plan, $pin,$smtpHost , $smtpPort, $smtpUser, $smtpPass,$support_email,$logo );								


// send email
function SendEmail($conn, $sitname, $hosturl,$user, $fname , $plan, $pin,$smtpHost , $smtpPort, $smtpUser, $smtpPass,$support_email,$logo ){
$from = "$sitname<support@$hosturl>"; //the email address from which this is sent
$to = "$user"; //the email address you're sending the message to
$subject = "Your $plan "; //the subject of the message

// To send HTML mail, the Content-type header must be set
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "Return-Path: $sitname<support@$hosturl>\r\n";
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

<img src='https://$hosturl/sitelogo/$logo'>

<h3>Hey $fname,</h3>

Your transaction is succeessful <br>

<strong>Your transaction details are as follows:</strong> <p>

<table class='table' >
  
   <tr>
    <td>Product Name</td>
    <td>$plan</td>
  </tr>
  <tr>
    <td>Serial No</td>
    <td> $pin</td>
  </tr>
  
</table> <p>


If you have any question regarding this transaction please.<p>
 
 <strong>Email:</strong> support@$hosturl 
<p>


Regards, <p>


$hosturl

</body><html>";

//now mail
//$DoMail = mail($to,$subject,$message,$headers);

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
    $mail->addAddress("$user", "$fname");     //Add a recipient
   
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "$subject";
    $mail->Body    = "$message";
    
    $mail->send();
   // echo 'Message has been sent';
   

return $mail;
				
}			

?>