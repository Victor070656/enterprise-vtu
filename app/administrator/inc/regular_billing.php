
<?php 
		$airtelvtu = test_input($_POST['airtelvtu']);
		$mtnvtu = test_input($_POST['mtnvtu']);
		$glovtu = test_input($_POST['glovtu']);
		$etisalatvtu = test_input($_POST['etisalatvtu']);
		$dstv = test_input($_POST['dstv']);
		$gotv = test_input($_POST['gotv']);
		$startimes = test_input($_POST['startimes']);
		
		$airtelData = test_input($_POST['airtelData']);
		$mtnData = test_input($_POST['mtnData']);
		$gloData = test_input($_POST['gloData']);
		$etisalatData = test_input($_POST['etisalatData']);
		
		$ikeja = test_input($_POST['ikeja-electric']);
		$eko = test_input($_POST['eko-electric']);
		$kano = test_input($_POST['kano-electric']);
		$jos = test_input($_POST['jos-electric']);
		$phed = test_input($_POST['phed']);
		$ibedc = test_input($_POST['ibedc']);
		
		$waec = test_input($_POST['waec']);
		$smile = test_input($_POST['smile']);
		$sms = test_input($_POST['sms']);
		$abuja = test_input($_POST['aedc']);
		
		$conv = test_input($_POST['conv']);
		$jamb = test_input($_POST['jamb']);
			$jambmock = test_input($_POST['jambmock']);
				$neco = test_input($_POST['neco']);
					$nbais = test_input($_POST['nbais']);
						$nabteb = test_input($_POST['nabteb']);
		
	if(!empty($airtelvtu) && !empty($mtnvtu) && !empty($glovtu) && !empty($etisalatvtu) && !empty($dstv) && !empty($gotv) && !empty($startimes) && !empty($airtelData) && !empty($mtnData) && !empty($gloData) && !empty($etisalatData) && !empty($ikeja) && !empty($eko) && !empty($kano) && !empty($jos) && !empty($phed) && !empty($ibedc) && !empty($waec) && !empty($smile) && !empty($sms) && !empty($abuja) && !empty($conv)) {	
		
		
	$sql_store = mysqli_query($conn,
	
	"UPDATE regular_billing SET 
	
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
sms = '$sms',
aedc = '$abuja',
conv = '$conv',
jamb = '$jamb',
jambmock = '$jambmock',
neco = '$neco',
nbais = '$nbais',
nabteb = '$nabteb'
");	
?>
<div class='alert alert-success'>Settings saved</div>
<script>
setTimeout(function(){
    
window.location.replace('<?php echo basename($_SERVER['PHP_SELF']); ?>');    
},2000);

</script>
<?php
	}else{
		
echo "<div class='alert alert-danger'>Field cannot be empty</div>";		
		}
		
	
?>