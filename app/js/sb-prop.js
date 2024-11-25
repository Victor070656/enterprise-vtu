
    (async () => {
 
        const { value: password } = await Swal.fire({
            title: 'Set Transaction PIN',
            input: 'password',
            inputPlaceholder: 'Enter 4 digits PIN',
            showConfirmButton: true,
            ConfirmButtonText: 'Set PIN'
        })

        if (password) {

            //document.getElementById('acntpass').value = password;
        var token  = document.getElementById('tok').value;
            let fd = {
                pin: password,
                user: atob(token)
            };
            $.ajax({
                url: "inc/touser.php",
                type: 'POST',
                dataType: "json",
                data: JSON.stringify(fd),
                beforeSend: function(){
                     $("#btntransfer").attr( "disabled", "disabled" ).val('Please wait....');
                },
            
            success: function(resp) {

                    if (resp.status === true) {
                       
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
  title: resp.msg
})
             
                     
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
  title: resp.msg
})

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

 
  
  