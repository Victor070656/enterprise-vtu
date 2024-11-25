<?php 
session_start();
require('../db.php');
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

$qrysit = mysqli_query($conn,"SELECT * FROM settings");
$sitnam = mysqli_fetch_array($qrysit);						
								
?> 
<?php include('inc/header.php');?>
<style>
    * { box-sizing: border-box; }

#content {
  
  border: 0px solid #000;
  padding: 0.5rem;
  display: flex;
}

#left,
#right {
  background-color: none;
  border: 0px solid #fff;
  padding: 0.5rem;
  flex-grow: 1;
  color: #000;
}
</style>
<body class="fixed-nav sticky-footer bg-light" id="page-top">



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
          
     
     <h1 class="w3-xxxlarge w3-text-green" align="center"><b>SMTP SETTINGS</b></h1>
       

      <!-- Example Bar Chart Card-->
       
     <?php $request_dir = $_SERVER['SERVER_NAME'];
     $qrySmtp = $conn->query("SELECT * FROM smtp_settings");
     $row = $qrySmtp->fetch_assoc();
     ?> 
       
  <form action="" method="post" autocomplete = 'off' id="smtpsettings" > 
  
   
  <div id="content">
  <div id="left">
     <div id="object1">SMTP host</div>
     <div id="object2"><input type="text" value="<?php echo $row['smtp_host']; ?>" class="form-control" name="smtpserver"></div>
  </div>

  <div id="right">
     <div id="object3">SMTP port</div>
     <div id="object4"><input type="text" value="<?php echo $row['smtpport']; ?>" class="form-control" name="smtpport"></div>
  </div>
</div> 
   
   <div id="content">
  <div id="left">
     <div id="object1">SMTP username</div>
     <div id="object2"><input type="text" value="<?php echo $row['smtp_user']; ?>" class="form-control" name="smtpuser"></div>
  </div>

  <div id="right">
     <div id="object3">SMTP Password</div>
     <div id="object4"><input type="text" value="<?php echo $row['smtp_pass']; ?>" class="form-control" name="smtppass"></div>
  </div>
</div> 


<div id="content">
    <div id="left">
     <div id="object1">Support Email Address</div>
     <div id="object2"><input type="email" value="<?php echo $row['adminEmail']; ?>" class="form-control" name="supemail" placeholder="support@<?php echo $request_dir;?>"></div>
  </div>
  
  <div id="right">
     <div id="object3"></div>
     <div id="object4"><input type="submit" class="btn-lg btn-success" value="Update"></div>
  </div>

  
</div> 
                           
                                    
  
  </form>
 <script>
  
 
    $('#smtpsettings').submit(function(e){
        e.preventDefault();
        var form = $('#smtpsettings').serialize();
        $.ajax({
            type: "POST",
            url: 'inc/smtp-setup.php',
            data: form,
            dataType: "json",
            success:function(data){
                // Process with the response data
            // alert(data);
             Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: data,
  showConfirmButton: false,
  timer: 1500
})
            }
        });
    });

  

</script>   
             
     
               
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
   <?php include('inc/footer.php');?>