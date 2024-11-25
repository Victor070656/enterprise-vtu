<?php 
require_once('db.php');
include('inc/logo.php');
?>
<!doctype html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $_SERVER['SERVER_NAME']; ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="index.php"><?php logo2($sitelogo); ?></a>
            
       <h3>Authorization</h3>     
       <span class="splash-description">Enter verification code sent to your email.</span>
    
 
                <form method="post" action="javascript:void(0)" id="otpform">
                    <div class="form-group">
                    <input class="form-control form-control-lg" name="ot_cod" id="ot_cod" type="text" placeholder="Enter verification code" autocomplete="off" >
                    </div>
                  
                   
                   
                    <button type="submit"  id="vrysign" class="btn btn-primary btn-lg btn-block">Verify</button>
                </form>
                
                
            </div>
            <div class="card-footer bg-white p-0  ">
                
              
            </div>
        </div>
    </div>
  <script>
   
    $('#otpform').submit(function(e){
                e.preventDefault();  
            $('#vrysign').html('processing,  please wait..');   
               // $('#btn-reg').toggleClass('Processing Please wait...');
                var data = $(this).serialize();
                $.ajax({
                   url: 'validate_signup.php',
                   type: 'GET',
                   data: data,
                }).done(function(res){
                res = JSON.parse(res);
              let redirUrl = res['redirect'];
              let Message = res['msg'];
                if(res['status']){
                   
                   if(res['success']){ 
                setTimeout(function(){
               window.location.replace(redirUrl);     
                },2000);   
        
          // alert(redirUrl);
          
          Swal.fire({
  position: 'top-center',
  icon: 'success',
  text: Message,
  showConfirmButton: false,
  timer: 2500
})  
                   }
          
                }else{
                    
         Swal.fire({
  position: 'top-center',
  icon: 'error',
  text: Message,
  showConfirmButton: false,
  timer: 2500
})  

setTimeout(function(){
window.location.replace(redirUrl); 
},10000);

                }
            
            });
                    
               
                      
                  }); 
       
   </script> 
   
   <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> 
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
 
</html>