
<?php
$host = "localhost";
$dbname = "vtu_app";
$dbuser = "root";
$dbpass = "";

$conn = new mysqli("localhost","$dbuser","$dbpass","$dbname");
// Check connection
if ($conn -> connect_errno) {
  echo "Failed to connect ";
  exit();
}
  function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = filter_var($data, FILTER_SANITIZE_STRING);
   return $data;
}   
?>