function showTv(){
    if (document.getElementById('gotv').checked) {
        document.getElementById('ifGotv').style.display = 'block';
		
		var sourceOfPicture = "assets/images/Data-mtn.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
	
  $('#IsGotv').change(function(){
	  var selected = $(this).find('option:selected');
	  var amount = selected.data('amount');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	  var variation_code = selected.data('variation_code');
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  $('#variation_code').val(variation_code);
	  
	  }); 
	  
	   $('#mphone').on('keyup keydown',function(){
	  var m = $('#mphone').val().replace(/[^\d]+/g,'');
	  $('#tele').val(m);
	  });
  
  
    }else document.getElementById('ifGotv').style.display = 'none';
	
	
	if (document.getElementById('dstv').checked) {
        document.getElementById('ifDstv').style.display = 'block';
		
		var sourceOfPicture = "assets/images/Airtel-Data.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
  
  $('#IsDstv').change(function(){
	  var selected = $(this).find('option:selected');
	  var amount = selected.data('amount');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	   var variation_code = selected.data('variation_code');
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  $('#variation_code').val(variation_code);
	  });
		
	 $('#aphone').on('keyup keydown',function(){
	  var m = $('#aphone').val().replace(/[^\d]+/g,'');
	  $('#tele').val(m);
	  });
		
		}else document.getElementById('ifDstv').style.display = 'none';
	
	if (document.getElementById('startimes').checked) {
        document.getElementById('ifStar').style.display = 'block';
		
		var sourceOfPicture = "assets/images/GLO-Data.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
		
		
		$('#IsStar').change(function(){
	  var selected = $(this).find('option:selected');
	  var amount = selected.data('amount');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	   var variation_code = selected.data('variation_code');
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  $('#variation_code').val(variation_code);
	  });
	  
	   $('#gphone').on('keyup keydown',function(){
	  var m = $('#gphone').val().replace(/[^\d]+/g,'');
	  $('#tele').val(m);
	  });
		
	}
    
	else document.getElementById('ifStar').style.display = 'none';
	


if (document.getElementById('9mobile').checked) {
        document.getElementById('if9mob').style.display = 'block';
		
		var sourceOfPicture = "assets/images/9mobile-Data.jpg";
  var img = document.getElementById('bigpic')
  img.src = sourceOfPicture.replace('90x90', '225x225');
  img.style.display = "block";
		
		
	$('#Is9mob').change(function(){
	  var selected = $(this).find('option:selected');
	  var amount = selected.data('amount');
	  var service = selected.data('service');
	  var plan = selected.data('plan');
	   var variation_code = selected.data('variation_code');
	  $('#amount').val(amount);
	  $('#service').val(service);
	  $('#plan').val(plan);
	  $('#variation_code').val(variation_code);
	  });
	  
	   $('#ephone').on('keyup keydown',function(){
	  var m = $('#ephone').val().replace(/[^\d]+/g,'');
	  $('#tele').val(m);
	  });
		
	}
    
	else document.getElementById('if9mob').style.display = 'none';
	}