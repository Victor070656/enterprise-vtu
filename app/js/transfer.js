
      $('#initranfer').submit(function(e){
         
        e.preventDefault();
        
        var form = $('#initranfer').serialize();
        $.ajax({
            type: "GET",
            url: 'inc/verify-bank.php',
            data: form,
            dataType: "json",
            beforeSend: (function(){
                $('#btntransfer').html('<i class="fa fa-spinner fa-spin"></i> Validating account.. please wait');
            }),
            success: function(resp){
       if(resp.status === true){ 
        var fee = parseFloat((Math.round(resp.fee*100)/100).toFixed(2));
     $('#acn').html('<b> '+resp.msg+ '</b>').css('color','green');
     $('#fe').html('<i class="fa fa-exclamation-circle"></i> You will be charged &#8358;'+fee+ ' for this transaction.').css('color','gray');
     $('#btntransfer').html('<li class="fa fa-arrow-right"></li> confirm transfer').css('background-color', '#fa960a');
     document.getElementById('acntname').value = resp.msg;
     ////////////////////////////////////////////////////////
     
  $('#btntransfer').click(function(){
      
   (async () => { 
  
  const { value: password } = await Swal.fire({
            title: 'Enter PIN',
            input: 'password',
            inputPlaceholder: 'Enter your transaction PIN',
            confirmButtonText: 'Continue'
        })

        if (password) {

            document.getElementById('acntpass').value = password;
            var fd = $('#initranfer').serialize();
        $.ajax({
            type: "GET",
            url: 'inc/process_transfer.php',
            data: fd,
            dataType: "json",
            beforeSend: (function(){
                $('#btntransfer').html('<i class="fa fa-spinner fa-spin"></i> Processing.. please wait');
            }),
            success: function(resp){
            
          if(resp.status === true){       
          $('#btntransfer').html('<li class="fa fa-arrow-right"></li> Transfer Completed').css('background-color', '#287554');
          
          Swal.fire({
                title: 'Transfer successful',
                text: 'You have just sent N'+resp.amount+' to '+resp.destination+' ',
                icon: 'success',
                confirmButtonText: 'Alright'
            })  
          
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
            
  setTimeout(() =>{
  window.location.reload();    
  },3000);            
          }
            }
        });
                
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
  text: 'Transaction PIN is required'
})
           
        }
       
   })()
      
      
   });
   
     /////////////////////////////////////////////////////
     
       }else{
           
      $('#btntransfer').html('<li class="fa fa-refresh"></li> Try again'); 
      $('#acn').html(''+resp.msg+ '').css('color','red');
       }
          
            }
        });
        


    }); 
 