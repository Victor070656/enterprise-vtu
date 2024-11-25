<?php 
if(!isset($_SESSION["loggedin"])){
header("location: index.php");
   exit();
}
								
$user = $_SESSION['user'];
function userInfo($conn,$user){
$instq = $conn->query("SELECT * FROM users WHERE email='$user'");
while($Userdata[] = $instq->fetch_assoc()){}
return json_encode($Userdata);
}
$data = json_decode(userInfo($conn,$user),true);
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
$accountID = $data[0]['accno'];


$cal = mysqli_query($conn,"SELECT * FROM earnings WHERE user='$user' LIMIT 3 ");
$clog = mysqli_fetch_array($cal);
					
$qrypat = "SELECT * FROM payalert WHERE email='$user' LIMIT 5 ";
$paynoti = $conn->query($qrypat);		
			

$fcal = "SELECT * FROM earnlog WHERE refby='$user' ORDER BY `date` DESC LIMIT 5  ";
$enlog = $conn->query($fcal);					
					
if($level === 'free'){
							    
	$accType = 'Normal';
	}else{
							    
	$accType = 'Reseller';
	}	
							
$bnk = mysqli_query($conn,"SELECT * FROM bankinfo");
$payinfo = mysqli_fetch_array($bnk);


function recentTransactions($conn,$user){
$resu = $conn->query("SELECT * FROM transactions WHERE email='$user' ORDER BY `serial` DESC LIMIT 5");
while($allTranshow[] = $resu->fetch_assoc()){}
return json_encode($allTranshow);
}

$getfil = $conn->query("SELECT * FROM services ORDER BY RAND()");
	
$apikey = substr(str_shuffle("0123456789ABCDEFGHIJklmnopqrstvwxyzAbAcAdAeAfAgAhBaBbBcBdC1C23C3C4C5C6C7C8C9xix2x3"), 0, 60);

$query_rec = $conn->query("SELECT * FROM settings");
$settings = $query_rec->fetch_assoc();
			
$query_bank = $conn->query("SELECT * FROM add_bank");
$bank = $query_bank->fetch_assoc();

$query_rec = $conn->query("SELECT * FROM billing");
$bil = $query_rec->fetch_assoc();

$query_regular = $conn->query("SELECT * FROM regular_billing");
$regbil = $query_regular->fetch_assoc();

$query_com = $conn->query("SELECT * FROM commission");
$afi = $query_com->fetch_assoc();


function referalInfo($conn,$rebid){
$qrefer = $conn->query("SELECT * FROM users WHERE refid='$rebid' ");
while($daref[] = $qrefer->fetch_assoc()){}
return json_encode($daref);
}
$datref = json_decode(referalInfo($conn,$rebid),true);
$affto = $datref[0]['email'] ?? null;

//Service List airtime and Data
$smtnServ_airtime = $conn->prepare("SELECT filename,name,description,link,action FROM services WHERE category='airtime' ORDER BY RAND()");
$smtnServ_airtime->execute();
$smtnServ_airtime->store_result();
$smtnServ_airtime->bind_result($filNam,$SevyName,$savyDescr,$ActLink,$actBtn);

//Service List airtime and Data
$smtnServ_data = $conn->prepare("SELECT filename,name,description,link,action FROM services WHERE category='data' ORDER BY RAND()");
$smtnServ_data->execute();
$smtnServ_data->store_result();
$smtnServ_data->bind_result($filNam,$SevyName,$savyDescr,$ActLink,$actBtn);
//Service List bill payment
$smtnServ_bill = $conn->prepare("SELECT filename,name,description,link,action FROM services WHERE category='bill' ORDER BY RAND()");
$smtnServ_bill->execute();
$smtnServ_bill->store_result();
$smtnServ_bill->bind_result($filNam,$SevyName,$savyDescr,$ActLink,$actBtn);
//Service List educational & others
$smtnServ_others = $conn->prepare("SELECT filename,name,description,link,action FROM services WHERE category='edu' OR category='others' ORDER BY RAND()");
$smtnServ_others->execute();
$smtnServ_others->store_result();
$smtnServ_others->bind_result($filNam,$SevyName,$savyDescr,$ActLink,$actBtn);

//earning log
$stmt_EarnLog = $conn->prepare("SELECT withdrawal,alltime,user FROM earnings WHERE user=? ");
$stmt_EarnLog->bind_Param("s",$email);
$stmt_EarnLog->execute();
$stmt_EarnLog->store_result();
$stmt_EarnLog->bind_result($NEWithdraw,$TOtWithdraw,$Holder);
$stmt_EarnLog->fetch();
$stmt_EarnLog->close();

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   $data = filter_var($data, FILTER_SANITIZE_STRING);
   return $data;
}

function urlbasemain(){
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/base?url=main");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$basedata = curl_exec($ch);
$result = json_decode($basedata,true);
//Close the cURL handle.
curl_close($ch);
return $result['description'][0]['main'];

	}
?>