<?php 
//function
//$qrykey = mysqli_query($conn,"SELECT * FROM settings");

//$keydata = mysqli_fetch_array($qrykey);

function setting($conn){
$sitQueryData = $conn->query("SELECT * FROM settings");
while($sitedata[] = $sitQueryData->fetch_assoc()){}
return json_encode($sitedata);
    
}
$keydata = json_decode(setting($conn),true);

$sitelogo = $keydata[0]['sitelogo'];

function logo($sitelogo){
	
echo '<img class="logo-img" src="../sitelogo/'.$sitelogo.'"  >';
}

function logo1($sitelogo){
	
echo '<img class="logo-img" src="../../sitelogo/'.$sitelogo.'" ';
}

function logo2($sitelogo){
	
echo '<img class="logo-img" src="sitelogo/'.$sitelogo.'"  >';
}

function logo3($sitelogo){
	
echo '<img class="logo-img" src="sitelogo/'.$sitelogo.'" width="150" >';
}
function logobeta($sitelogo){
	
echo '<img class="logo-img" src="../sitelogo/'.$sitelogo.'"  >';
}

function gw(){
echo "Don't have API Key yet? <a href='https://superjarang.com/register.php' style='color:#00F' target='_blank'>Create API Key</a>";
	}

function cp(){
echo "Don't have Coinpayment API Key yet? <a href='https://gocps.net/sfg19sphdczurdh5x45f3gyh4wyf/' style='color:#00F' target='_blank'>Create API Key</a>";
	}	
	
function sm(){
echo "Don't have SMS API Account yet? <a href='http://superjarang.com/sms/index.php/create-account' style='color:#00F' target='_blank'>Create API Account</a>";
	}	
function maut(){
echo "Don't have monnify account yet? <a href='https://app.monnify.com/create-account' style='color:#00F' target='_blank'>Create an account</a>";
	}	
	
?>