<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>functions</title>
</head>

<body>

<?php





//agent upgrade alert
	function agentupgrade(){
		
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => $_POST['phone'],
	   'message' => 'Dear '.$_POST['fname'].' your ePINs account has been upgraded to Agent and N'.$_POST['amount'].' upgrade fee deducted. Thank you! epins.com.ng',
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);
		}	


	//Wallet credit alert
	function walletcredit(){
		
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => $_POST['phone'],
	   'message' => 'Dear '.$_POST['fname'].', your ePINs wallet has been funded with N'.$_POST['amount'].'. Thank you! epins.com.ng',
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);
		}	



	//send bank details
	function fundalert(){
		
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => $_POST['phone'],
	   'message' => 'Dear '.$_POST['fname'].', your ePINs wallet funding request via '.$_POST['method'].' has been received. Kindly make a deposit / transfer of N'.$_POST['amount'].' to Diamond Bank: 0043791119, Name: SolutionForth Web Resources so we can fund you immediately. Thank you!',
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);
		}	



//send bank details
	function upgradealert(){
		
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => '08064507989',
	   'message' => 'Hi admin,  '.$_POST['fname'].' have made account upgrade request on ePINs via '.$_POST['method'].'',
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);
		}	




// registration success
	
	function regiok(){
	    
	   echo '<html>
	<body>
	
	<div class="alert alert-success">
    <strong>Success!</strong> Your signup was successful. <a href="../">Please login here to start using ePINs</a>
  </div>

	</body>
	 </html> ';
		
		
		}	
		
		
// Block Notice
	
	function blocknotice(){
	    
	   echo '<html>
	<body>
	
	<div class="alert alert-warning">
    <strong>Account Blocked!</strong> Transaction Not Allowed</a>
  </div>

	</body>
	 </html> ';
		
		
		}		
		

// registration success
	
	function voiceok(){
	    
	   echo '<html>
	<body>
	
	<div class="alert alert-success">
    <strong>Call</strong> Logged</a>
  </div>

	</body>
	 </html> ';
		
		
		}	



// invalid Login details
	
	function loginerr(){
	    
	   echo '<html>
	<body>
	
	<div class="alert alert-danger">
    <strong>Invalid</strong> Login details. Try again.
  </div>
	
	</body>
	 </html> ';
		
		
		}
		
// invalid deposit amount
	
	function depomin(){
	    
	   echo '<html>
	<body>
	
	<div class="alert alert-danger">
    <strong>Invalid Amount</strong> Minimum Deposit is N500.
  </div>
	
	</body>
	 </html> ';
		
		
		}		

// not pin available
function nopin(){
	    
	   echo '<html>
	<body>
	
	<div class="alert alert-danger">
    <strong>No PINs Available</strong> in your account
  </div>
	
	</body>
	 </html> ';
		
		
		}


// pin available
function showpin(){
	    
	   echo '<html>
	<body>
	
	<div class="alert alert-success">
    <strong>PIN Generation successful</strong>. Your Recharge PINS are below;
  </div>
	
	</body>
	 </html> ';
		
		
		}



//recover password
	function recoverpwd($user,$phone,$pas){
	
	
# Our new data
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => $phone,
	   'message' => 'Hi '.$user.' we have just send your ePINs password to your registered email address. Please check your inbox/spam. Thanks! epins.com.ng'
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);
		}		




// invite info
	
	function inviteinfo(){
	    
	    echo '
   <html>
	<body>

	<div class="alert alert-danger">
    <strong>Hey!</strong> Invite your friends  and get paid for every transactions they carry out on epins.com.ng.
  </div>
	
	</body>
	 </html>';
		
		
		}	

//signup sms alert

function regsms(){
    
    //SEnd SMS to registered USER
# Our new data
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => $_POST['phone'],
	   'message' => 'Dear '.$_POST['fname'].', Thank you for signing up on ePINs Solution. Earn money when you Recharge Data, airtime, Dstv, Gotv, PHCN on epins.com.ng.',
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);

    
}
	
		
// TV recharge success
	
	function tvok(){
	    
	   echo '
	
	<html>
	<body>

	<div class="alert alert-success">
    <strong>Success!</strong> Your N'.$_POST['amount'].' '.$_POST['identifier'].' recharge was successful.
  </div>

	</body>
	 </html>
	 ';
		
		
		}	


// transfer to self
	
	function selftrans(){
	    
	    echo '
   <html>
	<body>
	
	<div class="alert alert-danger">
    <strong>Hey!</strong> you cannot transfer fund to yourself.
  </div>
	
	</body>
	 </html>';
		
		
		}	
		
		
		// transfer to success
	
	function successtrans($nam,$lname){
	    
	    echo '
   <html>
	<body>

	<div class="alert alert-success">
    <strong>Success!</strong>  N'.$_POST['amount'].' has been transfered to '.$nam.' '.$lname.'.
 
	</div>
	</body>
	 </html>';
		
		
		}	
	
		
	//failed transaction
	function timeout(){
	    echo '
   <html>
	<body>
	
	<div class="alert alert-danger">
    <strong>Service timeout.</strong> Please Try again shortly.
  
	</div>
	</body>
	 </html> ';
	    
		
		}	
		
		
		//convert airtime to glo data
	function glo2data(){
	    echo '
   <html>
	<body>
	<p align="center">
	<a  href="glodata.html" class="btn btn-primary" >Convert Airtime to Glo Mega Data bundle</a>
	</p>
	</body>
	 </html> ';
	    
		
		}	
		
		
		
		
// send failed sms alert
function sendfailsms(){
  
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => '08064507989',
	   'message' => 'service timeout down epins.com.ng.',
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch); 
  }
  
  
  	//send success sms
	function airtimesuccess(){
		

		}	
  
  
	
	//send success sms
	function sendsuccesssms(){
		
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => $_POST['recepient'],
	   'message' => 'Your N'.$_POST['amount'].' '.$_POST['identifier'].' recharge was successful. Enjoy safe Data, airtime, Dstv, Gotv, Electricity recharge on epins.com.ng',
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);
		}	
		


	//reverse TV transaction sms
	function reversetv(){
		
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => $_POST['phone'],
	   'message' => 'Your N'.$_POST['amount'].''.$_POST['identifier'].' failed transaction has been reversed. Enjoy safe Recharge on epins.com.ng.',
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);
		}	



	//reverse TV transaction sms
	function reversebill(){
		
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => $rowfetch['phone'],
	   'message' => 'Your N'.$amount.''.$serviceID.' failed transaction has been reversed. Enjoy safe Recharge on epins.com.ng.',
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);
		}	

		
		

//send credit alert sms
	function creditalert($dest,$dname,$name,$balance){
	
	
# Our new data
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => $dest,
	   'message' => 'Dear '.$dname.', N'.$_POST['amount'].' has been transfered to your ePINs Wallet by '.$name.', Send robocall for as low as N6 on epins.com.ng'
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);
		}		
		

//send credit alert sms
	function creditadmin($txtadmin,$dname,$name,$nam,$lname,$lnam){
	
	
# Our new data
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => $txtadmin,
	   'message' => 'Dear Admin, '.$name.' '.$lnam.' transfered N'.$_POST['amount'].' to '.$nam.' '.$lname.' on epins.com.ng'
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);
		}		

		

	//account not found
	function notfound(){
	    
	      echo '
   <html>
	<body>
	
	<div class="alert alert-danger">
    <strong>Transfer Failed!</strong> Account not found.
  </div>

	</body>
	 </html>';
	    
		
		}	
		
		
//withdraw sms alert to admin
	function withdrawalert($des,$accNumber,$accName,$bank,$name){
	
# Our new data
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => $des,
	   'message' => 'Hi admin, '.$name.' have made a request to withdraw N'.$_POST['amount'].' commission on ePINs. Bank:'.$bank.', AccNo: '.$accNumber.', Name: '.$accName.''
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);
		}			
		
//withdraw sms notification
 function withdraw($phone,$accNumber,$accName,$bank,$name){
	
$data = array(
    'username' => 'admin',
    'password' => 'chime098',
	 'sender' => 'ePINs',
	  'recipient' => $phone,
	   'message' => 'Dear'.$name.', your request to withdraw N'.$_POST['amount'].' commission on ePINs has been received and its been processed. '
	    
);
# Create a connection
$url = 'http://www.solutionforth.com/reseller/index.php?option=com_spc&comm=spc_api';
$ch = curl_init($url);
# Form data string
$postString = http_build_query($data, '', '&');
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);
		}	
		
//low balance notification

function lowbalance(){
    
 echo '
   <html>
	<body>
	
	<div class="alert alert-danger">
    <strong>Insufficient Fund!</strong> <a href="fund.php">Add fund to your wallet</a>
  
	</div>
	</body>
	 </html> ';   
    
}
		
		
 ?>
</body>
</html>