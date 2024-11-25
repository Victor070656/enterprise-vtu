<?php 
session_start();
require('../../db.php');

if(isset($_POST["login"]) ) { 

$errorMessage = '';	
	
 $loginId = test_input($_POST['loginId']);
$password = test_input($_POST['loginPass']);   
if ( !isset($loginId, $password) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}
 
 if ($stmt = $conn->prepare('SELECT user_id,pass FROM administrator WHERE user_id = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $loginId);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();

if ($stmt->num_rows > 0) {
	$stmt->bind_result($loginId,$pwd);
	$stmt->fetch();
	// Account exists, now we verify the password.
	// Note: remember to use password_hash in your registration file to store the hashed passwords.
	if (password_verify($password, $pwd)) {
		// Verification success! User has logged-in!
		// Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
		session_regenerate_id();
		$_SESSION['loginId'] = TRUE;
		$_SESSION['user'] = $loginId;
		$_SESSION['id'] = $id;
		$uid = mt_rand(100,1000);
	
	if(isset($_SESSION["loginId"]) && $_SESSION["loginId"] === TRUE){
    header('location: ../dashboard.php');
    exit; }	
    
		
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


$conn->close();
?>