<?php
session_start();
require('../db.php');
//include("inc/functions.php");
 date_default_timezone_set ( 'Africa/Lagos' );
header('Content-Type: application/json');
$sqlQuery = "SELECT * FROM transactions WHERE  status='Completed' AND date(date) = date(NOW())";
$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>