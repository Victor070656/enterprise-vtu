$('#apv').on('click', function() {
 var usn = $('#usr').val();   
  Swal.fire({
  title: 'Are you sure you want to Approve '+usn+' ?',
 
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Approve it!'
}).then((result) => {
  if (result.isConfirmed) {

 var ap = $('#ap').val();
 var fvdat = JSON.stringify({se : ap});
 $.ajax({
     type: 'POST',
     url : 'k_ap.php',
     data: fvdat,
     dataType: "json",
     success: function(res){
     
      if(res.status === true){
          
     const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer);
    toast.addEventListener('mouseleave', Swal.resumeTimer);
  }
});

Toast.fire({
  icon: 'success',
  text: res.msg
});

if(res.ch === 'Approved'){
$('#apv').prop("disabled",true);    
}

setTimeout(()=>{
window.location.reload();    
},3000);
          
      }else{
    
   $('#kyc').modal('show');
   $("#btntransfer").prop("disabled",true);
      }   
     }
 }); 
    



    
  }
})   
    
    
});





///////////////////////


$('#btnban').on('click', function() {
 var usn = $('#usr').val();   
  Swal.fire({
  title: 'Are you sure you want to Ban '+usn+' ?',
 
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Ban!'
}).then((result) => {
  if (result.isConfirmed) {

 var em = $('#em').val();
 var fvdat = JSON.stringify({em : em});
 $.ajax({
     type: 'POST',
     url : 'b_k.php',
     data: fvdat,
     dataType: "json",
     success: function(res){
     
      if(res.status === true){
          
     const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer);
    toast.addEventListener('mouseleave', Swal.resumeTimer);
  }
});

Toast.fire({
  icon: 'error',
  text: res.msg
});


setTimeout(()=>{
window.location.reload();    
},3000);
          
      }  
     }
 }); 
    



    
  }
})   
    
    
});



$('#rej').on('click', function() {
 var usn = $('#usr').val();   
  Swal.fire({
  title: 'Are you sure you want to Delete '+usn+' KYC request ?',
 
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Delete!'
}).then((result) => {
  if (result.isConfirmed) {

 var em = $('#kr').val();
 var fvdat = JSON.stringify({em : em});
 $.ajax({
     type: 'POST',
     url : 're_kyc.php',
     data: fvdat,
     dataType: "json",
     success: function(res){
     
      if(res.status === true){
          
     const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer);
    toast.addEventListener('mouseleave', Swal.resumeTimer);
  }
});

Toast.fire({
  icon: 'error',
  text: res.msg
});


setTimeout(()=>{
window.location.reload();    
},3000);
          
      }  
     }
 }); 
    



    
  }
})   
    
    
});