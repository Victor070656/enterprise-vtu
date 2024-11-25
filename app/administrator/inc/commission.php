
<?php 
		$airtelvtu = $_POST['airtelvtu'];
		$mtnvtu = $_POST['mtnvtu'];
		$glovtu = $_POST['glovtu'];
		$etisalatvtu = $_POST['etisalatvtu'];
		$dstv = $_POST['dstv'];
		$gotv = $_POST['gotv'];
		$startimes = $_POST['startimes'];
		
		$airtelData = $_POST['airtelData'];
		$mtnData = $_POST['mtnData'];
		$gloData = $_POST['gloData'];
		$etisalatData = $_POST['etisalatData'];
		
		$ikeja = $_POST['ikeja-electric'];
		$eko = $_POST['eko-electric'];
		$kano = $_POST['kano-electric'];
		$jos = $_POST['jos-electric'];
		$phed = $_POST['phed'];
		$ibedc = $_POST['ibedc'];
		
		$waec = $_POST['waec'];
		$smile = $_POST['smile'];
		
		$abuja = $_POST['aedc'];
		
	if(!empty($airtelvtu) && !empty($mtnvtu) && !empty($glovtu) && !empty($etisalatvtu) && !empty($dstv) && !empty($gotv) && !empty($startimes) && !empty($airtelData) && !empty($mtnData) && !empty($gloData) && !empty($etisalatData) && !empty($ikeja) && !empty($eko) && !empty($kano) && !empty($jos) && !empty($phed) && !empty($ibedc) && !empty($waec) && !empty($smile) && !empty($abuja)) {	
		
		
	$sql_store = mysqli_query($conn,
	
	"UPDATE commission SET 
	
airtelvtu='$airtelvtu',
mtnvtu='$mtnvtu',
glovtu='$glovtu',
9mobilevtu='$etisalatvtu',
dstv='$dstv',
gotv='$gotv',
startimes='$startimes',
airtelData='$airtelData',
mtnData='$mtnData',
gloData='$gloData',
9mobileData='$etisalatData',
IkejaElectric='$ikeja',
EkoElectric='$eko',
Kedc='$kano',
Phed='$phed',
Ibedc='$ibedc',
JosElectric='$jos',
smile='$smile',
waec='$waec',
aedc = '$abuja'
");	

echo "<div class='alert alert-success'>Settings saved</div>";
	}else{
		
echo "<div class='alert alert-danger'>Field cannot be empty</div>";		
		}
		
	
?>