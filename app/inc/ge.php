  <?php 
 $chek = mysqli_query($conn,"SELECT * FROM users WHERE email='$user' ");
 
 $pdata = mysqli_fetch_array($chek); 
 if(isset($_POST['gen'])){
			

$updat = mysqli_query($conn,"UPDATE users SET level='paid',apikey='$apikey' WHERE email ='$user' ") or die(mysqli_error()); 

?>
<script language="javascript" type="text/javascript">
alert("New API Key generated. Old Key becomes unsuable");

setTimeout(function(){ document.location="apikey.php" }, 1000);
</script>
<?php

    } 

echo "<strong>Your API Key:</strong> <div class='alert alert-info'> ".$pdata['apikey']."</div>";
?> 
                                    
                              
                                        
           <form method="post" action="" id="TransTable">
                                        <br>
                              
                                         
                                     <div class="col-sm-6 pl-0">
                                         
                                                <p class="text-center">
                                                    <button type="submit" name="gen" class="btn btn-rounded btn-primary" >Generate New API Key</button>
                                                    
