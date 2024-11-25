 
  $(document).ready(function(){
 
 $('#a').on('keyup keydown change',function(){
  var fp = $('#a').val().replace(/[^\d]+/g,''); 
  $('#at').val(fp);
  
  });  
 
 $('#p').on('keyup keydown change',function(){
  var fp = $('#p').val().replace(/[^\d]+/g,''); 
  $('#ph').val(fp);
  
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



                          