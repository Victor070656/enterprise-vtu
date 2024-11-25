<?php
session_start();
require_once('../db.php');
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
$user = $_SESSION['user'];
								
$ins = mysqli_query($conn,"SELECT * FROM users WHERE email='$user' ");
$data = mysqli_fetch_array($ins);
								
$email = $data['email'];
$rowpas = $data['pass'];
$bal = $data['bal'];
							
$deps = "SELECT * FROM deposit  ";
$payment = $conn->query($deps);

include('../inc/logo.php');	
?>

<?php include('inc/header.php');?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">


  <!-- Navigation-->
 <?php include('inc/nav.php');?>
        
  <!-- Navigation Ends-->
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
  
    <div class="container-fluid">
      <!-- Breadcrumbs-->
     
      <div class="row">
        <div class="col-12">
          
     
     <h1 class="w3-xxxlarge w3-text-green" align="center"><b>Create Account</b></h1>
       

      <!-- Example Bar Chart Card-->
       
     <?php 
		   // define variables and set to empty values
      require("function/functions.php");
	  
	  $request_dir = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);	
	
	$qryApi = mysqli_query($conn,"SELECT * FROM settings");
$apidata = mysqli_fetch_array($qryApi);

$sitename = $apidata['sitename']; 
$servName = $_SERVER['HTTP_HOST'];
		
	if(isset($_POST['create'])){
		
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$pass =  $_POST['pass'];
$phone = $_POST['phone'];
$level = "free";
$block = "Block";
$activate = "Activate";
$del = "Delete";
$bal = 0;
$cur = "₦";
$log=$_SERVER['REMOTE_ADDR'];
$acctype = "normal";
$country = $_POST['country'];
$accno = mt_rand(10000,298983);

$ref = mt_rand(1083,3981);

$refby = "Admin";
$refbyid = "Admin";
$refid = "Admin";
$refwallet = 0;
$refcount = 0;
$reflink = 'https://'.$request_dir.'/register.php?refid=';
$refunverified = 0;
$refverified = 0;

$pincredit = 0;

$blockpro = '0';

$check=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' OR phone='$phone' ");//looking through existing usernames
   
    $num = mysqli_num_rows($check);
    
    
    if ($num ==0){ //If there is already such username...

$sql = mysqli_query($conn,"INSERT into users(firstname,lastname,email,pass,phone,level,IPaddress,block,blockpro,activate,del,bal,pincredit,currency,acctype,country,accno,refid,refcount,refby,refwallet,reflink,refunverified,refverified,refbyid,credit) VALUES('$fname','$lname','$email','$pass','$phone','$level','$log','$block','$blockpro','$activate','$del','$bal','$pincredit','$cur','$acctype','$country','$accno','$ref','$refcount','$refby','$refwallet','$reflink','$refunverified','$refverified','$refbyid','Credit')") or die(mysqli_error());



echo '<div class="alert alert-success"><strong>Success!</strong> Account Created</div>';
	 // add to mailing list
    
    

// send email

$from = "$sitename<support@$servName>"; //the email address from which this is sent
$to = "$email"; //the email address you're sending the message to
$subject = "Welcome to $servName "; //the subject of the message

// To send HTML mail, the Content-type header must be set
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "Return-Path: $sitename<support@$servName>\r\n";
$headers .= "Organization: $sitename\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$message = "

<html>
<head>
<style>
.table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 50%;
}

td {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}


.button {
  background-color: #008CBA; /* Blue */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  border-radius: 8px;
  cursor: pointer;
  
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
}

.button:hover {
  background-color: #4CAF50; /* Green */
  color: white;
}

</style>
</head>

<body>

<img src='https://$servName/assets/images/logo.png'>

<h3>Hey $fname,</h3>

We are glad to welcome you on Nigeria <br>
most trusted Instant & Automated digital recharge solution.<p> 

We have got lots of stuff to eliminate stress<br>
recharging your devices and in turn put some money <br>
in your wallet while doing so.<p>


<strong>Your login details are as follows:</strong> <p>

<table class='table' >
  
  <tr>
    <td>Login ID</td>
    <td>$email</td>
  </tr>
  <tr>
    <td>Password</td>
    <td> $pass</td>
  </tr>
  
   <tr>
    <td>Account Type</td>
    <td> Normal </td>
  </tr>
  
</table> <p>

$sitename give you instant and automated recharge for Airtime, <br>
Internet Data, Gotv, Dstv, Startimes, Electric Token,Smile Internet.<p>

<a href='https://$servName'><button class='button'>Try it Now!</button></a> <br>


<p>
Our support team is standby to assist you wherever you need help.<p>
 
 <strong>Email:</strong> support@$servName 
<p>


Warm Regards, <p>


$servName

</body><html>";

//now mail
$DoMail = mail($to,$subject,$message,$headers);


  // add to mailing list
    
    
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://solutionforth.ipzmarketing.com/api/v1/subscribers",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"status\":\"active\",\"email\":\"$email\",\"name\":\"$fname\",\"group_ids\":[2]}",
  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "content-type: application/json",
    "x-auth-token: eoaJgH3Nq7FP3BD1i6ocQ17SLVG9FceJVsGHCZzi"
  ),
));

$response = curl_exec($curl);
$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$err = curl_error($curl);

curl_close($curl);        
	
	}

else {
	echo '<div class="alert alert-danger">User already exist.</div> '; 
	
}


}


		?>
	
  
  <form action="" method="post" autocomplete = 'off'> 
  
  <div class="form-group">
        <label><strong>FirstName</strong></label>
		 <input type="text" id="fname" name="fname" class="form-control"  >
		 <div id="charNum"></div>
		 
      </div> 
      
      
      <div class="form-group">
        <label><strong>LastName</strong></label>
		 <input type="text" id="lname" name="lname"    class="form-control"  >
		 <div id="charNum"></div>
		 
      </div> 
  
  
  
	 <div class="form-group">
        <label><strong>Email Address</strong></label>
		 <input type="text" id="email" name="email"    class="form-control"  >
		 <div id="charNum"></div>
		 
      </div> 

	   <div class="form-group">
        <label><strong>Phone</strong></label>
		 <input type="text" id="phone" name="phone" class="form-control"   required>
		 <div id="charNum"></div>
		 
      </div> 
	  
	 
		 <input type="hidden" id="pass" name="pass" value="<?php
		 
	$randomNum=substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);
		 
		 echo $randomNum;
		 
		 ?>"  >
	
	  
	 <input name="country" type="hidden" class="form-control" id="country" value="
<?php

    include("geoip.inc");

    function ipAddress(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])){ //check ip from share internet
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ // proxy pass ip
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    $gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);

    echo geoip_country_name_by_addr($gi, ipAddress());
    // echo geoip_country_code_by_addr($gi, ipAddress()); <-- country code   

    geoip_close($gi);

?>


">
      <button type="submit" id="submit" name="create" class="btn btn-info">Create</button>
    </form>  
 
             
            </div>
            
          </div>
          <!-- Card Columns Example Social Feed-->    
         </p>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>