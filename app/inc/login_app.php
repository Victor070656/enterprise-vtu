<?php 
session_start();
require('db.php');
include('logo.php');
date_default_timezone_set('Africa/Lagos');
$dateTime = date("d-M-Y h:i:A");
$qrysite = $conn->query("SELECT * FROM settings");
$sql_logo = $qrysite->fetch_assoc();
$siteName = $sql_logo['sitename'];
$support_phone = $sql_logo['mobile'];
$request_dir = $_SERVER['SERVER_NAME'];


if(isset($_POST["login"]) ) { 

$errorMessage = '';	
	
$loginId = test_input($_POST['loginId']);
$password = test_input($_POST['loginPass']);   
$loginPhone = test_input($_POST['loginId']);
if ( !isset($loginId, $password) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}
 
 if ($stmt = $conn->prepare('SELECT email,pass,phone FROM users WHERE email = ? OR phone=?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('ss', $loginId,$loginPhone);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();

if ($stmt->num_rows > 0) {
	$stmt->bind_result($loginId,$pwd,$userPhon);
	$stmt->fetch();
	// Account exists, now we verify the password.
	// Note: remember to use password_hash in your registration file to store the hashed passwords.
	if (password_verify($password, $pwd)) {
		// Verification success! User has logged-in!
		// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['user'] = $loginId;
		$_SESSION['id'] = $id;
		$uid = mt_rand(100,1000);
		
$userData = fetchUser($loginId, $loginPhone);
$ClientEmail = $userData->email;
$fname = $userData->firstname;


// send Login Notification to email
loginNotification($conn, $siteName, $dateTime, $fname,$smtpHost,$smtpPort,$smtpUser,$smtpPass,$ClientEmail,$sql_logo,$request_dir,$support_phone,$support_email);
	
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === TRUE){
    //header('location: ../dashboard.php');
     ?> <script>
    
       location.assign('dashboard.php');  
   
      </script><?php
    exit(); }	
    
		
$stmt->close();		
	} else {
		// Incorrect password
	
		$errorMessage = "Incorrect username or password!";	

		
	}
} else {
	// Incorrect username
$errorMessage = "Incorrect username or password!";

}
	

	
}

}
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = filter_var($data, FILTER_SANITIZE_STRING);
   return $data;
}
function settings($conn){
$sitQueryData = $conn->query("SELECT * FROM settings");
while($sitrow[] = $sitQueryData->fetch_assoc()){
    
}
}

function fetchUser($loginId, $loginPhone){
    global $conn;
$Qrtmt = $conn->query("SELECT email,firstname,phone FROM users WHERE email ='$loginId' OR phone='$loginPhone'");
$resultUs = $Qrtmt ->fetch_object();
return $resultUs;	
}

function ExactBrowserName()
{
$ExactBrowserNameUA=$_SERVER['HTTP_USER_AGENT'];

if (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")) {
    // OPERA
    $ExactBrowserNameBR="Opera";
} elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "chrome/")) {
    // CHROME
    $ExactBrowserNameBR="Chrome";
} elseIf (strpos(strtolower($ExactBrowserNameUA), "msie")) {
    // INTERNET EXPLORER
    $ExactBrowserNameBR="Internet Explorer";
} elseIf (strpos(strtolower($ExactBrowserNameUA), "firefox/")) {
    // FIREFOX
    $ExactBrowserNameBR="Firefox";
} elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")==false and strpos(strtolower($ExactBrowserNameUA), "chrome/")==false) {
    // SAFARI
    $ExactBrowserNameBR="Safari";
} else {
    // OUT OF DATA
    $ExactBrowserNameBR="OUT OF DATA";
};

return $ExactBrowserNameBR;
}

function loginNotification($conn, $siteName, $dateTime, $fname,$smtpHost,$smtpPort,$smtpUser,$smtpPass,$ClientEmail,$sql_logo,$request_dir,$support_phone,$support_email){
$Mailfrom = "".$sql_logo['sitename']."<$support_email>"; //the email address from which this is sent
$Mailto = "$ClientEmail"; //the email address you're sending the message to
$Mailsubject = "".$sql_logo['sitename']." Login Notification "; //the subject of the message

// To send HTML mail, the Content-type header must be set
$Mailheaders  = 'MIME-Version: 1.0' . "\r\n";
$Mailheaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$Mailheaders .= "X-Priority: 3\r\n";
$Mailheaders .= "Return-Path: ".$sql_logo['sitename']."<".$sql_logo['sitename'].">\r\n";
$Mailheaders .= "Organization: ".$sql_logo['sitename']."\r\n";
 
// Create email headers
$Mailheaders .= 'From: '.$Mailfrom."\r\n".
    'Reply-To: '.$Mailfrom."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$Mailmessage = "

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

 .bottom-three {
     margin-bottom: 1cm;
  }

</style>
</head>

<body>



Dear ".strtoupper($fname).",

<h3>$siteName LOGIN CONFIRMATION</h3>

Please be informed that your $siteName account was accessed on <strong> $dateTime </strong>. Browser ".ExactBrowserName()." <br>

<p>

If you did not log on to your account at the time detailed above, <br>
please call our customer care on $support_phone or send an email to support@$request_dir immediately. 
<p>
Thank you for choosing $siteName. <p>
<p>
<a href='https://$request_dir'><strong>$siteName</strong></a><p>
<hr>


<p class='bottom-three'>
<strong>DISCLAIMER:</strong>
<p></p>
The message and its attachments are for the designated recipient(s) only and may contain privileged, proprietary and private information. <br> 
If you have received it in error, kindly delete it and notify the sender immediately. $siteName accepts no liability for any damage resulting directly <br> or indirectly from the transmission of this email message.
<p>
</body><html>";

//now mail
$DoSendMail = mail($Mailto,$Mailsubject,$Mailmessage,$Mailheaders);	 




return $DoSendMail;
}

$conn->close();
?>