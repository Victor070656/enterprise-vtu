<?php 
session_start();
require('db.php'); 
include('inc/func.php');
include('inc/gravatar.php');
include('inc/logo.php');
 $banks = $conn->query("SELECT * FROM bank_gateway ORDER BY bankname ASC");
?> 
<?php include('inc/header.php');?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
      
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php include('inc/nav.php');?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title"><li class="fa fa-exchange-alt"></li> Transfer To Bank Account </h2>
                        
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="ecommerce-widget">

                        <div class="row"></div>
                        <div class="row">
                            <!-- ============================================================== -->
                      
                            <!-- ============================================================== -->

                                          <!-- recent orders  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                            
                                <div class="card">
                                          
                                    <h5 class="card-header"></h5>
                                    <div class="card-body">
                                    <span id="st"></span>
                                    <form method="post" action="javascript:void(0)" id="initranfer"> 
                                        <div class="float-center">
                                        <img style="display:none;" id="bigpic" src="bigpic" width="120"  height="90"/>                
                                    </div>
                          <input type="hidden" name="token" id="token" value="<?php echo $user;?>">              
                          <div class="form-group">
                          <label class="col-form-label">Bank Name</label>    
                           <select class="form-control" name="bankName"  >
		    <option  selected disabled hidden>Select Destination Bank</option>
		    <?php while($m = $banks->fetch_assoc()){ ?> 
		        <option value="<?php echo $m['serial']; ?>"> <?php echo ucwords(strtolower($m['bankname']));?> </option>
		        <?php } ?>
		        
                </select>
                <span id="bk"></span>
                </div>
                          <div class="form-group">
          <label class="col-form-label">Account Number</label>
    <input type="number" min="0" maxlength="10" id="accountNo" class="form-control" name="accountNo" >
    <div id="acn"></div>
                                            </div>    
										
										
                                        <label for="inputText3" class="col-form-label">How much do you want to send?</label>    
                                       <div class="input-group mb-3">
                                                <div class="input-group-prepend"><span class="input-group-text">&#x20A6;</span></div>
                                                <input type="number" class="form-control" name="amt" id="amt" >
                                                <div class="input-group-append"><span class="input-group-text">.00</span></div>
                                               
                                        <input type="hidden" id="acntpass" name="acntpass"> 
                                        <input type="hidden" id="acntname" name="acntname">
                                        <input type="hidden" id="reference" name="reference">
                                        
                                            </div>  
                                            <span id="am"></span>
                                            <span id="fe"></span> 
                                        <input type="hidden" value="<?php echo 'TRF'.date('Ymdhis').rand(2023,2050);?>" name="uniq">   
                                           
                                     <div class="col-sm-12 pl-0">
                                         
                                                <p class="text-center">
                                                    <button type="submit" id="btntransfer" class="btn btn-rounded btn-primary">Proceed</button>
                                              
                                                </p>
                                                
                                                <p align="center">
                                            
                                                     </p>
                                               
                                            </div>   
										
                                        </form>
                          <script src="js/transfer.js"></script>
                           <?php if(empty($data[0]['acc'])){ ?>
                           <input type="hidden" id="tok" value="<?php echo base64_encode($user); ?>">
                      <script src="js/sb-prop.js"> </script>
                      <?php } ?>
                   
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->
<script>

$(document).ready(function(){	

 var vfd = $('#token').val();
 var fvdataky = JSON.stringify({vmail : vfd});
 $.ajax({
     type: 'POST',
     url : 'formrequest/vd.php',
     data: fvdataky,
     dataType: "json",
     success: function(res){
      if(res.status === true){
    $("#btntransfer").prop("disabled",false);         
      } else {
   
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
$("#btntransfer").prop("disabled",true);    
       
   setTimeout(()=>{
   $('#kyc').modal('show');     
   },3000);
     
   //$("#btntransfer").prop("disabled",true); 
   
   
      }   
     }
 }); 
    
});             
							 
function Comma(Num)
 {
       Num += '';
       Num = Num.replace(/,/g, '');

       x = Num.split('.');
       x1 = x[0];

       x2 = x.length > 1 ? '.' + x[1] : '';

       
         var rgx = /(\d)((\d{3}?)+)$/;

       while (rgx.test(x1))

       x1 = x1.replace(rgx, '$1' + ',' + '$2');
     
       return x1 + x2;       
        
 }
 
 
 
 function yesnoCheck() {
    if (document.getElementById('yescard').checked) {
        document.getElementById('ifYes').style.visibility = 'visible';
    }
    
     if (document.getElementById('yescash').checked) {
        document.getElementById('ifYes').style.visibility = 'visible';
    }
    
     if (document.getElementById('yesbitcoin').checked) {
        document.getElementById('ifYes').style.visibility = 'visible';
    }
    
    

}



                            </script> 
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- customer acquistion  -->
                            <!-- ============================================================== -->
                           <?php include('inc/sidebar.php'); ?>
                            <!-- ============================================================== -->
                            
                            
                            
                            <!-- end customer acquistion  -->
                      
                         <?php include('inc/recent-transaction-widget.php'); ?>
                          
                            <!-- ============================================================== -->
                        </div>
                        <div class="row">
                            <!-- ============================================================== -->
              				                        <!-- product category  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- end product category  -->
                          
  	<script type="text/javascript">
		//datepicker plugin
		//link	
		$('#sendWithPhoneBook').click(function(e){
		    $('#pb_groups').css('display','block');
		    e.preventDefault();
		});

		$("input[type=checkbox].grp_select").change( function() {
		    if($(this).is(":checked")){
		    	var bin = chkK();
		    		$("#grp_select_check").html('+'+bin+' Selected Phonebook Group Recepient(s)');	       	
			}else{
				var bin = chkK();
				if (bin > 0) {
					$("#grp_select_check").html('+'+bin+' Selected Phonebook Group Recepient(s)');
				}else{
					$("#grp_select_check").html('');
				}
			}
	  	});

		function countDest(){
			destcount = jQuery("#recipient").val();
			destcount = destcount.split(' ').join(',').split("\n").join(',').split(',,').join(',');
			// console.log(countUnit());
			destcount = destcount.split(',').length;
			if(destcount < 2) jQuery("#destcount").html(destcount+" recipient typed");
			else jQuery("#destcount").html(destcount+" recipients typed");
			$('#hiddenCount').html(destcount);
			// return destcount;
		}

		function chkK() {
			var val = [];
			$(':checkbox:checked').each(function(i){
	          val[i] = $(this).val();
	        });
	        return (val.length);
		}



		function countMsgsText(val){

			val = val.split("\n").join('??').split('{').join('??').split('}').join('??');

			val = val.split('\\').join('??').split('[').join('??').split(']').join('??');

			val = val.split('~').join('??').split('|').join('??').split('^').join('??');

			val = val.split('€').join('??').split('"').join('??').split("'").join('??');

			len = val.length;

			if(len<=160){

				jQuery('#paget').html('Page: '+Math.ceil(len/160));
				jQuery('#count').html(', Characters left: ' + (1+((160 - 1) * Math.ceil(len/160))-len) + ', Total Typed Characters: '+len);

				jQuery('#hiddenCount').html(Math.ceil(len/160)+' page');

			} else {
				jQuery('#paget').html('Page: '+Math.ceil(len/151));
				jQuery('#count').html(', Characters left: ' + (1+((151 - 1) * Math.ceil(len/151))-len) + ', Total Typed Characters: '+len);	

				jQuery('#hiddenCount').html(Math.ceil(len/151)+' pages');

			}

			countDest();

		}

		
		$('#recipient').keyup(function(){
			if (this.value.length > 0) {
				$('#destcount').css('display','block');
				countDest();
			}else{
				$('#destcount').css('display','none');
			}
		});
		
		function showUsage(messagesCount) {
			var x = jQuery('#paget').html()+", "+jQuery('#destcount').html()+"\nSend Message? Duplicate Numbers will be removed";
			return confirm(x);
		}
		function showUsageFree(messagesCount) {
			var x = jQuery('#paget').html()+", "+jQuery('#destcount').html()+"\nSend Message. You are using Free SMS Units and it ll contain an Advert?";
			return confirm(x);
		}
		$('#myForm input').on('change', function() {
		   var oname = ($('input[name="mode"]:checked', '#myForm').val()); 
		   // alert(oname);
		   if (oname =='sms') {
		   		$('#emailbox').css("display","none");
		   		$('#smsbox').css("display","block");
		   }else if(oname =='email'){
		   		$('#smsbox').css("display","none");
		   		$('#emailbox').css("display","block");
		   }
		});
		$('#form-field-select-1').on('change',function () {
			var selectVal = $('#form-field-select-1').val();
			if (selectVal == '4') {
				$('#date-range').css("display","none");
				$('#wallet-range').css("display","block");
			}else{
				$('#date-range').css("display","block");
				$('#wallet-range').css("display","none");
			}
		});
		</script>
		<script type="text/javascript">
	$(function() {
	    var scntDiv = $('#more-xtra');
	    var i = $('#more-xtra div').length + 1;
	    $('#addScnt').on('click', function() {
	    	// alert('ooooo');
	    	console.log(i);
	    	$('#addScnt').html('Add More Date');
	        $('<div id="extr" class="form-group"><label class="col-md-4 control-label">Schedule Date</label><div class="col-md-8"><div class="input-group"><input type="datetime-local" value="2019-11-05T18:18" id="example-input2-group1" name="schedule_date[]" class="form-control" placeholder="Email"><span  id="remScnt"class="input-group-addon"><i class="fa fa-minus"></i></span></div></div></div>').appendTo(scntDiv);
	        i++;
	        return false;
	    });
	    
	    $('#more-xtra').on('click','#remScnt' ,function(e) { 
	    	// alert(i);
	        // if( i > 2 ) {
	        	$('#more-xtra #extr:last').remove();
	            i--;

	        // }
	        e.preventDefault();
	        return false;
	    });
	});

	</script>


<!-- Button trigger modal -->
                                               
                                                <!-- Modal -->
                                                <div class="modal fade" id="kyc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="exampleModalLabel2">KYC INFORMATION</h4>
                                                                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </a>
                                                                   
                                                                        
                                                                        
                                                            </div>
                                         <div class="modal-body">
                                                       
                                                            
<form method="POST" action="javascript:void(0)" id="kycform" enctype="multipart/form-data">       
         
<div class="row">
            
  <div class="col-6">
 <label class="form-label"><li class="fa fa-user"></li> Your Full Name</label>
    <input type="text" id="fname"  class="form-control"  >
 </div>

<p>  
  
 <div class="col-6">
 <label class="form-label"><li class="fa fa-phone"></li> Your Phone Number</label>
    <input type="tel" id="phone"  class="form-control" >
 </div>
 </div>
 </p>
 <p>
 <div class="row">            
 <div class="col-12">
<label class="form-label"><li class="fa fa-user"></li> Your BVN</label>
    <input type="number" id="bv"  class="form-control" >
 </div>
 
</div>
</p>
 
 <div class="modal-footer">
                                           
  <button type="submit"  class="btn btn-primary">Submit</button>
                                                           
  </div>
 </form>   
 <script>
        $('#kycform').submit(function(e){
        e.preventDefault();
        var f = $('#fname').val();
        var p = $('#phone').val();
        var b = $('#bv').val();
        var e = '<?php echo $email;?>';
        var fd = JSON.stringify({
            fname : f,
            phone : p,
            bvn : b,
            email: e
            });
            
        $.ajax({
            type: "POST",
            url: 'kyc.php',
            data: fd,
            dataType: "json",
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
//document.location.reload();    
},2000);

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
    }
            }
        });
    });

  

</script>
                           
                                   
                                                    </div>
                                                </div>
                                            </div>
                                     
                        </div>

                       
                    </div>
                </div>
            </div>
            
            
        
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include('inc/footer.php');?>