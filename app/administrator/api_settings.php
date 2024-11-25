<?php 
session_start();
require('../db.php');
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}					
$user = $_SESSION['user'];
include('../inc/logo.php');	
$qrysit = mysqli_query($conn,"SELECT * FROM settings");
$sitnam = mysqli_fetch_array($qrysit);						
include('inc/header.php');
?>
<style>
#vuser {
display : none;    
}  
#vpwd {
display : none;    
} 
#username {
    display:none;
}
#password {
    display:none;
}
#apiurl {
    display:none;
}
#baseurl {
    display:none;
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
  
    <div class="container-fluid ">
      <!-- Breadcrumbs-->
     
      <div class="row justify-content-center">
        <div class="col-12">
          
          <p> 
   
       
      <form method="POST" action="javascript:void(0)" id="providerkey">       	

<a href="#" id="action" class="btn btn-primary float-right"><i class="fa fa-pencil"></i> Add/Edit</a>	    
	    
<div class="row responsive"  id="gform" style="display:none;">
    
 <div class="col-6">
 <strong><li class="fa fa-server"></li>  Gateway </strong>
    
     <select id="provider" name="provider" class="form-control">
   <option  selected hidden disabled >Select Gateway Provider </option>  
   <option value="epins">ePINs</option>
   <option value="husmodata">HusmoData</option>
   <option value="bigsub">BigSub</option>
   <option value="zoedatahub">ZoeDataHub</option>
   <option value="n3tdata">N3tData</option>
   <option value="gongoz">Gongoz Data</option>
   <option value="alrahuz">Alrahuz Data</option>
    <option value="shago">Shago</option>
     <option value="vtpass">VTPass</option>
      <option value="mobileng">Mobile Ng</option>
       <option value="smartrecharge">Smart Recharge</option>
         <option value="clubkonnect">ClubKonnect</option>
         <option value="monnify">Monnify</option>
          <option value="flutterwave">Flutterwave</option>
           <option value="paystack">Paystack</option>
           <option value="vpay">VPay</option>
           <option value="sms">BulkSMS</option>
     
 </select>
 </div> 
 
 <div class="col-6">
     <strong><li class="fa fa-key"></li>  key Type</strong>
    <select id="keytype" class="form-control">
   <option  selected hidden disabled >Select API Key Type</option>  
   <option value="1">Private</option>
   <option value="2">Secret</option>
   <option value="4" id="cc" style="display:none;">Contract Code</option>
   <option value="5" id="wa" style="display:none;">Wallet Account Number</option>
   <option value="6" id="vuser">Username</option>
   <option value="7" id="vpwd">Password</option>
   <option value="8" id="base">Base URL</option>
   <option value="3">All</option>
 </select>
 </div>
 
<div class="col-6">
 <label></label>
   <input type="text"  id="private" name="private"  class="form-control" placeholder="Enter Private / API Key " autocomplete="off" style="display:none;" >
 </div> 
 <div class="col-6">
<label></label>
   <input type="text"  id="secret" name="secret"  class="form-control" placeholder="Enter Secret Key / UserId" autocomplete="off" style="display:none;" >
 </div>
 <div class="col-6">
     <label></label>
 <input type="text"  id="contractcode" name="contractcode"  class="form-control" placeholder="Enter Contract Code" autocomplete="off" style="display:none;" >
 </div>
 <div class="col-6">
<label></label>
   <input type="text"  id="walletno" name="walletno"  class="form-control" placeholder="Enter wallet account number" autocomplete="off" style="display:none;" >
 </div>
 <div class="col-6">
<label></label>
    <input type="text"  id="username" name="username"  class="form-control" placeholder="Enter username" autocomplete="off" >
 </div>
 <div class="col-6">
<label></label>
   <input type="text"  id="password" name="password"  class="form-control" placeholder="Enter password" autocomplete="off">
 </div>
 <div class="col-6">
 <label></label>
 <input type="text"  id="baseurl" name="baseurl"  class="form-control" placeholder="Enter Base URL " autocomplete="off" >
 </div>
 
  <p>  
<badge id="mfy" class="alert alert-warning responsive" style="display:none;" ><i class="fa fa-exclamation-circle"></i> <strong>Monnify Webhook URL:</strong>  <?php print('https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']). "/plugin/ibank.php" ) ?></badge>
  
 <badge id="vpayhook" class="alert alert-danger responsive" style="display:none;" ><i class="fa fa-exclamation-circle"></i> <strong>VPay Webhook URL:</strong>  <?php print('https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']). "/plugin/vfd.php" ) ?></badge>
 
 <badge id="apiurl" class="alert alert-info" ></badge>
 </p>
 
 <div class="col-6">
            <label></label>
       <button type="submit" id="btnsd" class="btn btn-primary solid"><li class="fa fa-upload"></li> Add / Update Key</button>  
     </div>

<!-- /////// end of variation div/// -->
</div>


           
   </form>                 
     <!-- ////////////////////////End SME Data ////////////////-->             
                  
                  
                  

  
            
 <script>
  $(document).ready(function(){ 
      
  $('#action').click(function(){
  $('#gform').slideDown('slow',function(){
    $('#gform').show();
    $('#action').hide();
  });   
  });    
    
      
  $('#keytype').change(function(){
   var opt = $('#keytype option:selected').val(); 
   var prv = $('#provider option:selected').val();
  if (opt == 1){ 
   $('#private').show();   
   $('#secret').hide();    
   $('#contractcode').hide();
     $('#walletno').hide();
     $('#username').css('display','none'); 
     $('#password').css('display','none');
     $('#baseurl').css('display','none');
  } else if (opt == 2) {
     $('#secret').show();  
     $('#private').hide();
     $('#contractcode').hide();
     $('#walletno').hide();
     $('#username').css('display','none'); 
     $('#password').css('display','none');
     $('#baseurl').css('display','none');
  } else if ( opt == 3 && prv !== 'monnify') {
   
   $('#secret').show();  
     $('#private').show(); 
     $('#contractcode').hide();
     $('#walletno').hide();
     if(prv !== 'vpay'){
         if (prv === 'sms'){
          
          $('#username').css('display','block'); 
     $('#password').css('display','block');   
     $('#baseurl').css('display','block');   
             
         } else {
     $('#username').css('display','none'); 
     $('#password').css('display','none');
         }
     
     } else {
      $('#username').css('display','block'); 
     $('#password').css('display','block');   
     $('#baseurl').css('display','none');    
     }
  }else if (opt == 3 && prv === 'monnify') {
      
      
     $('#secret').show();  
     $('#private').show(); 
     $('#contractcode').show();
     $('#walletno').show();
     $('#username').css('display','none'); 
     $('#password').css('display','none');
     $('#baseurl').css('display','none');
     
  } else if (opt == 3 && prv === 'vpay') {
      
     $('#secret').show();  
     $('#private').show(); 
     $('#contractcode').hide();
     $('#walletno').hide();
     $('#username').css('display','block'); 
     $('#password').css('display','block');
     $('#baseurl').css('display','none');
     
  } else if (opt == 3 && prv === 'sms') {
      
      $('#secret').hide();  
     $('#private').show(); 
     $('#contractcode').hide();
     $('#walletno').hide();
     $('#username').css('display','block'); 
     $('#password').css('display','block');
     $('#baseurl').css('display','block');
      
  } else if(opt == 4) { 
   $('#secret').hide();  
     $('#private').hide();
     $('#contractcode').show();
     $('#walletno').hide();
     $('#username').css('display','none'); 
     $('#password').css('display','none');
      $('#baseurl').css('display','none');
  } else if (opt == 5){ 
   
    $('#secret').hide();  
     $('#private').hide();
     $('#contractcode').hide();
     $('#walletno').show();
     $('#username').css('display','none'); 
     $('#password').css('display','none');
      $('#baseurl').css('display','none');
  } else if (opt == 6){ 
   
    $('#secret').hide();  
     $('#private').hide();
     $('#contractcode').hide();
     $('#walletno').hide();   
      $('#username').css('display','block'); 
     $('#password').css('display','none'); 
     $('#baseurl').css('display','none');
  }
  
  else if (opt == 7){ 
   
    $('#secret').hide();  
     $('#private').hide();
     $('#contractcode').hide();
     $('#walletno').hide();   
     $('#username').hide(); 
     $('#username').css('display','none'); 
     $('#password').css('display','block'); 
     $('#baseurl').css('display','none');
  } else if (opt == 8) {
   
    $('#secret').hide();  
     $('#private').hide();
     $('#contractcode').hide();
     $('#walletno').hide();   
     $('#username').hide(); 
     $('#username').css('display','none'); 
     $('#password').css('display','none'); 
     $('#baseurl').css('display','block');   
      
  }
  
  else {
      
    $('#secret').hide();  
     $('#private').hide();
     $('#contractcode').hide();
     $('#walletno').hide();
     $('#username').css('display','none'); 
     $('#password').css('display','none');
     $('#baseurl').css('display','none');
  } 
  $('#btnsd').prop('disabled',false);    
  });   
    
    $("#providerkey").submit(function(e){
        e.preventDefault();
     var formData = $(this).serialize();
        $.ajax({
            url: 'inc/apikey_config.php',
            data:  formData,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (){
             $('#btnsd').html('<i class=" fa fa-spinner"></i> Please wait..');  
            },
            success:function(data){
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
 window.location.reload();   
},3000);

} else {
    

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
$('#btnsd').html('<i class=" fa fa-plus"></i> Add/Update');

}
            }
        });
    });

  }); 


$('#provider').change(function(){
  var selected  = $('#provider option:selected').val();
  
  $('#keytype').prop('selectedIndex',-1).trigger( "change" );
  $('#keytype').focus();
  if (selected === 'monnify'){ 
   $('#mfy').show();
   $('#cc').show();
    $('#wa').show();
    $('#vpayhook').hide();
    $('#vuser').hide();
     $('#vpwd').hide();
     $('#base').css('display','none');
  } else if (selected === 'vpay'){
   
   $('#mfy').hide();
   $('#cc').hide();
    $('#wa').hide();
    $('#base').css('display','none');
    $('#vuser').show();
     $('#vpwd').show(); 
     $('#vpayhook').show();
  } else if (selected === 'sms'){
    $('#mfy').hide();
   $('#cc').hide();
    $('#wa').hide();  
    $('#vuser').show();
     $('#vpwd').show();
   $('#base').css('display','block');
   $('#vpayhook').hide();
  } else {
       $('#cc').hide();
    $('#wa').hide();
     $('#mfy').hide(); 
   $('#vuser').hide();
     $('#vpwd').hide();
     $('#vpayhook').hide();
     $('#base').css('display','none');
  }
  
  if(selected === 'epins'){
      var epinUrl = "https://epins.com.ng";
   $('#apiurl').html('<i class="fa fa-exclamation-circle"></i> Generate API key at <a href="'+epinUrl+'">'+epinUrl+'</a> ').css('display','block');   
  } else if (selected === 'sms') { 
    
    var smsUrl = "https://epins.com.ng/sms";
   $('#apiurl').html('<i class="fa fa-exclamation-circle"></i> Create SMS account at <a href="'+smsUrl+'">'+smsUrl+'</a> Your base url is: <code>https://www.epins.com.ng/sms/index.php?option=com_spc&comm=spc_api</code> ').css('display','block');  
      
  } else {
      
    $('#apiurl').css('display','none');  
  }
  
});
</script>   

<hr>

<div class="table-responsive"> 
     <h4 class="w3-xxxlarge w3-text-yellow" align="center"><b>Gateway Keys </b></h4>
   
     <?php 
     function providerkey($conn){
		$Runqry = $conn->query("SELECT * FROM providers_api_key ");
	 while($rkey[] = $Runqry->fetch_assoc()){}	
		return json_encode($rkey);
     }
     
		?> 
       
     <table class="table table-bordered" id="others" width="100%" cellspacing="0" >
            <thead>
              <tr>
                 <th>Provider</td>
                <th>Private/API Key</td>
                <th>Secret Key</td>
                <th>Contract Code</td>
                <th>Wallet Number</td>
                <th>Username</td>
                  <th>Password</td>
                  <th>Base URL</td>
                <th></th>
                
              </tr>
              </thead>
              <tfoot>
              <tr>
               <th>Provider</td>
                <th>Private/API Key</td>
                <th>Secret Key</td>
                <th>Contract Code</td>
                <th>Wallet Number</td>
                 <th>Username</td>
                  <th>Password</td>
                  <th>Base URL</td>
                <th></th>
                
              </tr>
              </tfoot>
              <tbody>
                <?php 
               $json_key = json_decode(providerkey($conn));
               foreach($json_key as $row ){
               for ( $i = 0, $m = count($row); $i < $m; $i++){
               ?>
                <tr>
                  <td><?php echo strtoupper($row->provider); ?></td>
                  
                    <td><?php echo $row->privatekey; ?></td>
                    <td><?php echo $row->secretkey; ?></td>
                  <td><?php echo $row->contractcode; ?></td>
                    <td><?php echo $row->wallet_no; ?></td>
                    <td><?php echo $row->username; ?></td>
                    <td><?php echo $row->password; ?></td>
                    <td><?php echo $row->baseurl; ?></td>
                    
                    <td><div class="btn-group dropdown">
											<button type="button" class="btn btn-outline-info dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-gear"></i> Action <span class="caret"></span> </button>
											<div class="dropdown-menu">
									
								<a class="dropdown-item" href="delete?apk=<?php echo $row->serial; ?>"> <button class="btn btn-outline-danger" style="cursor:pointer"><i class="fa fa-trash"></i> Delete</button> </a>
										
											</div>
										</div>  
                          </td>
                </tr>
               
              <?php } }?>
                </tbody>
            </table>
             
</div>
            
</div>


    </div>           
  </div>
  
  </div>
  
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
   <?php include('inc/footer.php');?>