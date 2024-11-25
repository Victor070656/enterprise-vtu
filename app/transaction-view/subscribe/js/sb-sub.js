 $(document).ready(function(){   
     document.getElementById('plan').focus();
 $('#plan').change(function (){
        var opt = $(this).val();
       $.get("../../formrequest/plan.php", { id: opt })
        .done(function( data ) {
       res = JSON.parse(data);
       var fee = res['amount'];
       var descr = res['description'];
        $('#amount').val(fee);
        $('#pid').val(opt);
        $('#notice').html(descr);
       });
      
         }); 
         
          $("#refcode").on('keyup',function (){
        var sponsor = $("#refcode").val();
        var planid = $("#pid").val();
        var token = $("#token").val();
        if (sponsor.toString().length >= 5) {
       $.get("../../formrequest/sponsor.php", { sid: sponsor, pid: planid,tok:token })
        .done(function( invite ) {
       response = JSON.parse(invite);
       var comment =  response['msg'];
       if(planid === ''){ 
           $('#remark').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>  Please select activation plan first.</div>'); 
           $("#refcode").val('');
           
       } else {
       if(response['status'] === true){
        $('#remark').html('<div class="alert alert-success"> <i class="fa fa-check-circle"></i> '+comment+'</div>');
       } else {
       
       $('#remark').html('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> '+comment+'</div>');    
       } }
       });
        } else { 
           
            
        }
      
         }); 
         
$('#amount').prop('disabled',true);   

$('#activateform').submit(function(e){
        e.preventDefault();
        var form = $(this).serialize();
        var url = "../../formrequest/e_activate.php";
        $.ajax({
            type: "GET",
            url: url,
            data: form,
            dataType: "json",
            beforeSend: function(){
                
            $('#btnpay').html('Please wait...');    
            },
            success:function(data){
                // Process with the response data
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
document.location.replace(data.redirect);    
},3000);
}else { 
    
    if(data.exist === true){
    
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

setTimeout(function(){
document.location.replace(data.redirect);    
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
  text: data.msg
})  

setTimeout(()=>{
 $('#btnpay').html('Pay & Activate');     
},3000);   
    
} }
            }
        });
    });




                           
						   function show9mobile() {
  var sourceOfPicture = "assets/images/9mobile.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
} 
                   
function showMTN() {
  var sourceOfPicture = "assets/images/mtn.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
} 

function showAirtel() {
  var sourceOfPicture = "assets/images/airtel.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
} 

function showGlo() {
  var sourceOfPicture = "assets/images/glo.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
} 
        
 });									  
				