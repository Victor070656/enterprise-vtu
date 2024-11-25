<?php
session_start();
require_once('../db.php');
$errorMessage = '';
if(isset($_POST["login"]) ) { 
 $loginId = test_input($_POST['loginId']);
$password = test_input($_POST['loginPass']);   
 
 if ( !isset($loginId, $password) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}
 
 if ($stmt = $conn->prepare('SELECT user_id, pass FROM administrator WHERE user_id = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $loginId);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();

if ($stmt->num_rows > 0) {
	$stmt->bind_result($loginId, $pwd);
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
		
		if(!empty($_POST["remember"])) {
			setcookie ("loginId", $loginId, time()+ (10 * 365 * 24 * 60 * 60));  
			setcookie ("loginPass",	$password,	time()+ (10 * 365 * 24 * 60 * 60));
		} else {
			setcookie ("loginId",""); 
			setcookie ("loginPass","");
		}
	
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === TRUE){
    header('location: dashboard.php?a='.$uid.'');
    exit; }	
		
		
	} else {
		// Incorrect password
	
		$errorMessage = "Access denied!";	
	}
} else {
	// Incorrect username
$errorMessage = "Access denied!";

}
	
$stmt->close();
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
