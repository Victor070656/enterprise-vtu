<?php
$error = array();
$resp = array();

$id = $_REQUEST['id'];
$UserEmail = base64_decode($_REQUEST['token']);

if (empty($id)) {
    $error[] = "Id is empty";
}
require_once('../db.php');
$packInfo = json_decode(fetchPackage($conn, $id), true);
$mechantlevel =  json_decode(fetchmerchant($conn, $UserEmail), true);

// echo "<script>console.log(" . var_dump($mechantlevel) . ")</script>";

if (is_array($mechantlevel) && isset($mechantlevel) && count($mechantlevel) > 0) {
    if (isset($mechantlevel[0]) && $mechantlevel[0]['plan'] === 'Classic') {
        $price = $packInfo[0]['price_user'];
    } else if (isset($mechantlevel[0]) && $mechantlevel[0]['plan'] === 'Premium') {
        $price = $packInfo[0]['price_api'];
    } else {

        $price = $packInfo[0]['price_user'];
    }
} else {

    $price = $packInfo[0]['price_user'];
}


//file_put_contents('airtime.txt',$id.$UserEmail.$price);
$resp['status'] = true;
$resp['msg'] = $price;
echo json_encode($resp);
exit();

function fetchPackage($conn, $id)
{
    $query = $conn->query("SELECT * FROM pins_packages WHERE plan_id='$id'");
    while ($row[] = $query->fetch_assoc()) {
    }
    return json_encode($row);
}

function fetchmerchant($conn, $UserEmail)
{
    $qryMercht =  $conn->query("SELECT * FROM pin_merchants WHERE merchantid='$UserEmail' AND status='ACTIVE'");
    while ($rowmach[] = $qryMercht->fetch_assoc()) {
    }
    return json_encode($rowmach);
}
