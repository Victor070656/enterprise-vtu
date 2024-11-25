function showTv(){
    if (document.getElementById('smiledata').checked) {
        document.getElementById('ifData').style.display = 'block';
		
		var sourceOfPicture = "assets/images/spect-medium.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
	
  $('#IsData').change(function(){
	  var selected = $(this).find('option:selected');
	 var amount = selected.data('amount').replace(/[^\d]+/g,'');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	  var variation_code = selected.data('variation_code');
	  
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  $('#variation_code').val(variation_code);
	  }); 
  
  $('#qty').on('keyup keydown change',function(){
    var q = $('#qty').val().replace(/[^\d]+/g,'');
    $('#iuc').val(q);
  });
    }
	
	
	
	
	}
