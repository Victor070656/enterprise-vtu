<?php
require_once('db.php');
include('inc/logo.php');
include('inc/recaptcha.php');

?>
<!doctype html>
<html lang="en">
 
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Create A Free Account - Buy Airtime and Data for MTN, Glo, Etisalat, Airtel. Make payment for DSTV, GOTV, PHCN other services </title>
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    
      
<meta property="og:title" content="247Bills.ng"/>  
<meta property="og:description" content=" Buy Airtime and Data for MTN, Glo, Etisalat, Airtel. Make payment for DSTV, GOTV, PHCN other services"/> 

<meta property="og:image:width" content="600" />
<meta property="og:image:height" content="600" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<!-- ============================================================== -->
<!-- signup form  -->
<!-- ============================================================== -->
<?php //include('inc/regauth.php');
function sign_protect($data) {  
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   //$data = filter_var($data, FILTER_SANITIZE_STRING);
   return $data;
}
if(isset($_GET['refid'])){
$aff = sign_protect($_GET['refid']);
	
	}else{
	
	$aff = "System";	
		}
		
?>
<body>
    <!-- ============================================================== -->
    <!-- signup form  -->
    <!-- ============================================================== -->
    <form  method="post" action="javascript:void(0)" class="splash-container" id="reg-Form">
        <div class="card">
            <div class="card-header">
        <h3 class="mb-1" align="center"><a href="index.php"><?php logo2($sitelogo); ?></a></h3>
        <hr>
                <h3 class="mb-1" align="center">Create Free Account</h3>
                <p align="center">Please enter your user information.</p>

            </div>
            <div class="card-body">
                
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="fname" id="fname" required placeholder="First Name" >
                </div>
                
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="lname" id="lname" required placeholder="Last Name" >
                </div>
                
               
                <div class="form-group">
                    <input class="form-control form-control-lg" type="email" name="email" id="email" required placeholder="E-mail" >
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" name="password"  type="password" id="password" required placeholder="Password">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="phone" name="phone" required placeholder="Phone">
                </div>
                
               <input type="hidden" value="<?php echo $aff; ?>" id="referal" name="referal">
               <!-- Google reCAPTCHA box -->
    <div class="g-recaptcha" data-sitekey="<?php echo $capkey; ?>" ></div>
                
                <input name="country" type="hidden" class="form-control" id="country" value="">
                
                
                <div class="form-group pt-2">
                    <button class="btn btn-block btn-primary" id="btn-reg" type="submit">Create My Account</button>
                </div>
               
                
            </div>
            <div class="card-footer bg-white">
                <p>Already member? <a href="../" class="text-secondary">Login Here.</a></p>
            </div>
        </div>
    </form>
    
   <script>
   
    $('#reg-Form').submit(function(e){
                e.preventDefault();  
               var fname = $('#fname').val();
               var lname = $('#lname').val();
               var email = $('#email').val();
               var password = $('#password').val();
               var phone = $('#phone').val();
               var referal = $('#referal').val();
               var country = $('#country').val();
               var recapt = $('#g-recaptcha-response').val();
                var fdata = JSON.stringify({fname: fname,
                    lname : lname,
                    email : email,
                    password : password,
                    phone : phone,
                    referal : referal,
                    country : country,
                    g_recaptcha_response : recapt
                });
                //var fd = $(this).serialize();
                $.ajax({
                   url: 'regauth.php',
                   type: 'POST',
                   data:  fdata,
                   dataType: 'json',
                   async : false,
                   beforeSend: function(){
                  $('#btn-reg').html('<i class="fa fa-spinner"></i> Please wait...');     
                   },
                success: function(data){
               // res = JSON.parse(res);
              //var dirUrl = data.redirect;
             // var Msg = data.msg;
                if(data.status === true){
                    
                    const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

Toast.fire({
  icon: 'success',
  text: data.msg
})            
setTimeout(function(){
window.location.replace(data.redirect);    
},3000);

   $('#btn-reg').html('processing,  please wait..');
         
                }else{
                    
         const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

Toast.fire({
  icon: 'error',
  text: data.msg
})                    
            }
                }
            
            });
                    
               
                      
                  }); 
       
   </script> 
   
  
</body>

 
</html>