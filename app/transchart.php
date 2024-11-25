<?php
session_start();
require_once('db.php'); 
include('inc/func.php');
 date_default_timezone_set ( 'Africa/Lagos' );
header('Content-Type: application/json');
$sqlQuery = "SELECT * FROM transactions 
WHERE email='$email' AND status='Completed' AND date(date) = date(NOW())";
$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);


?>