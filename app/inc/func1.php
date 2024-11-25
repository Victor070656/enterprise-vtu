<?php
if (!isset($_SESSION["loggedin"])) {
    header("location: ../../index.php");
    exit();
}

$user = $_SESSION['user'];

function userInfo($conn, $user)
{
    $instq = $conn->query("SELECT * FROM users WHERE email='$user'");
    while ($Userdata[] = $instq->fetch_assoc()) {
    }
    return json_encode($Userdata);
}
$data = json_decode(userInfo($conn, $user), true);
$fname = $data[0]['firstname'];
$lname = $data[0]['lastname'];
$email = $data[0]['email'];
$rowpas = $data[0]['pass'];
$level = $data[0]['level'];
$bal = floatval($data[0]['bal']);
$rebid = $data[0]['refbyid'];
$com_w = $data[0]['refwallet'];
$Phone = $data[0]['phone'];
$cwal = $data[0]['cwallet'];
$refy_url = $data[0]['reflink'];
$refyid = $data[0]['refid'];
$customerName = "$fname .' '.$lname";
$Refer_total = $data[0]['refcount'];


$cal = mysqli_query($conn, "SELECT * FROM earnings WHERE user='$user' LIMIT 3 ");
$clog = mysqli_fetch_array($cal);

$qrypat = "SELECT * FROM payalert WHERE email='$user' LIMIT 5 ";
$paynoti = $conn->query($qrypat);


$fcal = "SELECT * FROM earnlog WHERE refby='$user' ORDER BY `date` DESC LIMIT 5  ";
$enlog = $conn->query($fcal);

if ($data[0]['level'] === 'free') {

    $accType = 'Normal';
} else {

    $accType = 'Reseller';
}

$bnk = mysqli_query($conn, "SELECT * FROM bankinfo");
$payinfo = mysqli_fetch_array($bnk);


$sql = "SELECT * FROM transactions WHERE email='$user' ORDER BY `serial` DESC LIMIT 5";
$resu = $conn->query($sql);


$service_ID = "SELECT * FROM services ORDER BY RAND() ";
$getfil = $conn->query($service_ID);

$apikey = substr(str_shuffle("0123456789ABCDEFGHIJklmnopqrstvwxyzAbAcAdAeAfAgAhBaBbBcBdC1C23C3C4C5C6C7C8C9xix2x3"), 0, 60);

$query_rec = mysqli_query($conn, "SELECT * FROM settings");

$settings = mysqli_fetch_array($query_rec);

$query_bank = mysqli_query($conn, "SELECT * FROM add_bank");

$bank = mysqli_fetch_array($query_bank);

$query_rec = mysqli_query($conn, "SELECT * FROM billing");
$bil = mysqli_fetch_array($query_rec);

$query_regular = mysqli_query($conn, "SELECT * FROM regular_billing");
$Regubil = mysqli_fetch_array($query_regular);

$query_com = mysqli_query($conn, "SELECT * FROM commission");
$afi = mysqli_fetch_array($query_com);

$qrefer = mysqli_query($conn, "SELECT * FROM users WHERE refid='$rebid' ");
$datref = mysqli_fetch_array($qrefer);
$affto = $datref['email'] ?? null;

function urlbasemain()
{
    //Initialize cURL.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/base?url=main");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $basedata = curl_exec($ch);
    $result = json_decode($basedata, true);
    //Close the cURL handle.
    curl_close($ch);
    return $result['description'][0]['main'];
}

function recentTransactions($conn, $user)
{
    $resu = $conn->query("SELECT * FROM transactions WHERE email='$user' ORDER BY `serial` DESC LIMIT 5");
    while ($allTranshow[] = $resu->fetch_assoc()) {
    }
    return json_encode($allTranshow);
}
function validate_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data);
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    $data = filter_var($data, FILTER_SANITIZE_SPECIAL_CHARS);
    $_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $_REQUEST = (array)$_POST + (array)$_GET + (array)$_REQUEST;
    return $data;
}
