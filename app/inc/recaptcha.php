<?php 

$qrykey = mysqli_query($conn,"SELECT * FROM settings");

$keydata = mysqli_fetch_array($qrykey);

$capkey = $keydata['sitekey'];
$capsec = $keydata['secretkey'];
$sitelogo = $keydata['sitelogo'];

?>