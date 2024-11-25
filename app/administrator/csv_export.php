<?php
/*
include('../db.php'); 

$filename = "Portal_subscribers.csv";
$fp = fopen('php://output', 'w');


$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='$dbname' AND TABLE_NAME='users'";
$result = mysqli_query($query);
while ($row = mysqli_fetch_row($result)) {
	$header[] = $row[0];
}	

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($fp, $header);

$query = "SELECT * FROM users";
$result = mysqli_query($query);
while($row = mysqli_fetch_row($result)) {
	fputcsv($fp, $row);
}
exit;
*/
?>

<?php
include('../db.php'); 

$filename = "Portal_subscribers.csv";

$query = "SELECT firstname,lastname,email FROM users";
$result = $conn->query($query);
if (!$result) die('Couldn\'t fetch records');
$headers = $result->fetch_fields();
foreach($headers as $header) {
    $head[] = $header->name;
}
$fp = fopen('php://output', 'w');

if ($fp && $result) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='.$filename);
    header('Pragma: no-cache');
    header('Expires: 0');
    fputcsv($fp, array_values($head)); 
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        fputcsv($fp, array_values($row));
    }
    die;
}

?>