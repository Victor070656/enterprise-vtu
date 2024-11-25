<?php 
session_start();
require('../db.php');
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}				
$user = $_SESSION['user'];

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
          
     <hr>
     <h4  align="center"><b>Change Password</b></h4>
       

      <!-- Example Bar Chart Card-->
       
     <?php 
	 
$chek = mysqli_query($conn,"SELECT * FROM administrator WHERE user_id='$user' ");
 
 $pdata = mysqli_fetch_array($chek);
		  		
		if(isset($_POST['reset'])){
			
$oldpwd = filter_var($_POST['pwd'],FILTER_SANITIZE_STRING);

$newpwd = filter_var(password_hash($_POST['newpwd'],PASSWORD_DEFAULT),FILTER_SANITIZE_STRING);

$userid = filter_var($_POST['userid'],FILTER_SANITIZE_STRING);

 if(!empty($oldpwd) && !empty($newpwd) && !empty($userid)){
 
 if(password_verify($oldpwd, $pdata['pass']) == false){
	 
echo "<div class='alert alert-danger'>Password Do not match </div>"; 

	 } else{     
	   
	   
$updat = mysqli_query($conn,"UPDATE administrator SET pass='$newpwd',user_id='$userid' WHERE user_id ='$user' ") or die(mysqli_error()); 



echo "<div class='alert alert-success'>Password Changed</div>";

	 }
   
 }else{
	 
	echo "<div class='alert alert-danger'>No Entry made </div>"; 
	 }
       
    } 


			

	 
		?> 
  <div class="row justify-content-center">     
  <form action="" method="post" autocomplete = 'off' > 
  
  <div class="form-group">
        <label><strong>Admin Username</strong></label>
		
		 <input type="text" id="userid" name="userid" value="<?php echo $pdata['user_id'];?>"  class="form-control" required>
		
      </div>
  
  <div class="form-group">
        <label><strong>Current Password</strong></label>
		
		 <input type="password" id="pwd" name="pwd"  class="form-control" required>
		
      </div>
  
  <div class="form-group">
        <label><strong>New Password</strong> </label>
		 <input type="password" name="newpwd" id="newpwd" class="form-control" required >
		    
		 <div id="charNum"></div>
		 
      </div> 
    
      <button type="submit" id="submit" name="reset" class="btn btn-info">Save Changes</button>
    </form>  
 </div>
             
            </div>
            
          </div>
          <!-- Card Columns Example Social Feed-->  
 <hr>         
    <form method="POST" action="javascript:void(0)" id="changeadmin">       
        <p align="center" style="color:gray"><strong>Change Admin Directory</strong></p>
          <div class="row justify-content-center">
                 
     <div class="divcol2">
 <strong><li class="fa fa-folder"></li> Enter new name</strong>
 
 <input type="text" name="fol" id="fol" class="form-control">
  
 </div>
 
 <div class="divcol2">
       <button type="submit" id="adf" class="btn btn-primary solid"><li class="fa fa-folder"></li> Change</button> 
       <span id="sh"></span>
     </div>

  </div>
  <p align="center" style="color:red"><i class="fa fa-exclamation-triangle"></i> Caution: Changing admin directory name will automatically render the current admin url invalid. <br> Enter only folder name. Do not enter complete URL.</p>
<p align="center" style="color:gray"><strong>Current admin url:</strong>   <?php echo 'https://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']);?> </p>

            
 </form>   

 <script> 

    $('#changeadmin').submit(function(e){
        e.preventDefault();
        var n = $('#fol').val();
        var c = '<?php echo realpath(dirname(__FILE__)); ?>';
        var b = '<?php echo basename(getcwd()); ?>';
         var fd = {
            newname : n,
            opath : c,
            base : b
            };
        $.ajax({
            type: "POST",
            url: 'adminfolder.php',
            data: JSON.stringify(fd),
            dataType: "json",
            beforeSend : function(){
            $('#adf').html('<i class="fa fa-spinner"></i> Please wait..');    
            },
            success:function(resp){
                // Process with the response data
                
    if(resp.status === true){            
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
  text: resp.msg
})
setTimeout(function(){
document.location.reload();    
},3000);

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
  text: resp.msg
})  

setTimeout(function(){
document.location.reload();    
},3000);
    }
            }
        });
    });

  

</script>          
          
          
          
         </p>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
   <?php include('inc/footer.php');?>