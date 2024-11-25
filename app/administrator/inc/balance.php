
<!-- Main content -->
   
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            
        
            
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="alert alert-info">
              <div class="inner">
                  <i class="fa fa-money"></i>
                <strong><?php epins($conn); ?></strong>

                <p>ePINs</p>
              </div>
              
             
            </div>
          </div>
          
          
          
          
          <!-- ./col -->
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="alert alert-success solid">
              <div class="inner"><i class="fa fa-money"></i>
                <strong><?php vtpass($conn); ?></strong>

                <p>VTPass</p>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          
          <!-- ./col -->
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="alert alert-secondary solid">
              <div class="inner"><i class="fa fa-money"></i>
                <strong><?php shago($conn); ?></strong>

                <p>Shago</p>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          
               <!-- ./col -->
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="alert alert-success solid">
              <div class="inner"><i class="fa fa-money"></i>
                <strong><?php paytev(); ?></strong>

                <p>Paytev</p>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          
            <!-- ./col -->
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="alert alert-primary solid">
              <div class="inner"><i class="fa fa-money"></i>
                <strong><?php 
                $Hosmresult = json_decode(husmo($conn));
                print (' &#x20A6;'.number_format($Hosmresult->user->Account_Balance,2).' ');

 ?></strong>

                <p>Husmo</p>
              </div>
              
            </div>
          </div>
          
          </div>
        </div>
          <!-- ./col -->
          <a href="#" id="more">Show all</a>
          
          
          
           <div class="container-fluid" id="showall" style="display:none;">
        <!-- Small boxes (Stat box) -->
        <div class="row">
       
          <!-- ./col -->
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="alert alert-primary solid">
              <div class="inner"><i class="fa fa-money"></i>
                <strong><?php mobilNg($conn); ?></strong>

                <p>MobileNG</p>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
        
       
       
          
          <!-- ./col -->
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="alert alert-danger solid">
              <div class="inner"><i class="fa fa-money"></i>
                <strong><?php clubk($conn); ?></strong>

                <p>Clubkonnect</p>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          
          
        
          
          <!-- ./col -->
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="alert alert-primary solid">
              <div class="inner"><i class="fa fa-money"></i>
                <strong><?php gongoz($conn); ?></strong>

                <p>Gongoz</p>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          
          <!-- ./col -->
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="alert alert-primary solid">
              <div class="inner"><i class="fa fa-money"></i>
                <strong><?php alrahuz($conn); ?></strong>

                <p>Alrahuz</p>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          
          <!-- ./col -->
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="alert alert-primary solid">
              <div class="inner"><i class="fa fa-money"></i>
                <strong><?php n3tdata($conn); ?></strong>

                <p>N3TDATA</p>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          
           <!-- ./col -->
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="alert alert-primary solid">
              <div class="inner"><i class="fa fa-money"></i>
                <strong><?php bigsub($conn); ?></strong>

                <p>BigSub</p>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          
          <!-- ./col -->
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="alert alert-primary solid">
              <div class="inner"><i class="fa fa-money"></i>
                <strong><?php zoedatahub($conn); ?></strong>

                <p>ZoeData</p>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          
         <!-- ./col -->
          <div class="col-sm-3 col-6">
            <!-- small box -->
            <div class="alert alert-dark">
              <div class="inner"><i class="fa fa-envelope"></i>
                <strong><?php SMS($apib); ?></strong>

                <p>SMS</p>
              </div>
              
            </div>
          </div>
          <!-- ./col --> 
      <a href="#" id="collapse">Hide</a>
        </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <?php	
        
        
 function paytev(){
     global $conn;
// get Key
$queryTev = $conn->query("SELECT * FROM providers_api_key WHERE provider='paytev'");
$tevkey = $queryTev->fetch_object();
$API_TOKEN = $tevkey->privatekey;
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://client.paytev.com/api/v1/balance?format=json&api-token=$API_TOKEN");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$respTev = curl_exec($ch);
$resultev = json_decode($respTev);

//Close the cURL handle.
curl_close($ch);
return  print('&#8358;'.number_format($resultev->balance, 2, '.', ','));

}       
        
        
        
        
        
function epins($conn){
function fetchEpin($conn){
$query_ep = $conn->query("SELECT * FROM providers_api_key WHERE provider='epins'");
$fetchepkey = $query_ep->fetch_assoc();
return json_encode($fetchepkey);
}    
$json_ep = json_decode(fetchEpin($conn));
$apikey = $json_ep->privatekey;
//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.epins.com.ng/v2/autho/balance/?apikey=$apikey");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$data_ep = curl_exec($ch);
$result_ep = json_decode($data_ep);

//Close the cURL handle.
curl_close($ch);
return  print('&#8358;'.number_format($result_ep, 2, '.', ','));

}


function shago($conn){
function fetchshago($conn){
$query_sh = $conn->query("SELECT * FROM providers_api_key WHERE provider='shago'");
$shagokey = $query_sh->fetch_assoc();
return json_encode($shagokey);
}    
$json_shago = json_decode(fetchshago($conn));
$hashkey = $json_shago->privatekey; 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://shagopayments.com/api/live/b2b");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
'serviceCode' => "BAL"
)));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "hashKey: $hashkey"
));
$successOk = curl_exec($ch);
curl_close($ch);
$resp = json_decode($successOk,true);	
                        
  return print("&#x20A6;".number_format($resp['wallet']['primaryBalance'],2,'.',','));   
            
        }  

function vtpass($conn){
function fetchVtp($conn){
$query_vtp = $conn->query("SELECT * FROM providers_api_key WHERE provider='vtpass'");
$vtpkey = $query_vtp->fetch_assoc();
return json_encode($vtpkey);
}    
$json_vt = json_decode(fetchVtp($conn));

//Initialize cURL.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://vtpass.com/api/balance');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERPWD , $json_vt->privatekey.":" .$json_vt->secretkey);
$vtdata = curl_exec($ch);
$result_vt = json_decode($vtdata);
curl_close($ch);
return print(number_format($result_vt->contents->balance, 2, '.', ','));
}
 
 function clubk($conn){
     
     function fetchclb($conn){
$query_cl = $conn->query("SELECT * FROM providers_api_key WHERE provider='clubkonnect'");
$clbkey = $query_cl->fetch_assoc();
return json_encode($clbkey);
}    
$json_clb = json_decode(fetchclb($conn));
 $clbtoken = $json_clb->privatekey;
       $userID = $json_clb->secretkey;
       
        $ch = curl_init();
        $url = "https://www.nellobytesystems.com/APIWalletBalanceV1.asp?UserID=$userID&APIKey=$clbtoken";
         curl_setopt($ch, CURLOPT_URL, $url); 
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_TIMEOUT, '3');
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
         $contentclb = trim(curl_exec($ch));
         $declub = json_decode($contentclb);
         curl_close($ch);
        return print (' &#x20A6;'.number_format($declub->balance,2).' ');
 }       
  
 function mobilNg($conn){
// mobile NG 
function fetchMg($conn){
$query_Mg = $conn->query("SELECT * FROM providers_api_key WHERE provider='mobileng'");
$Mgkey = $query_Mg->fetch_assoc();
return json_encode($Mgkey);
}    
$json_Mg = json_decode(fetchMg($conn));
 $mgtoken = $json_Mg->privatekey;
       $MuserID = $json_Mg->secretkey;
        $ch = curl_init();
        $url = "https://mobileairtimeng.com/httpapi/balance.php?userid=$mgtoken&pass=$MuserID";
         curl_setopt($ch, CURLOPT_URL, $url); 
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_TIMEOUT, '3');
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
         $content_ng = curl_exec($ch);
         $dec = json_decode($content_ng,true);
         curl_close($ch);
   return    print (' &#x20A6;'.$content_ng.' ');      
 }
      
   
function SMS($apib){
# Create a connection
$url = $apib['baseurl'];
$ch = curl_init($url);
# Form data string
# Setting our options
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
    'username' => $apib['smsUserid'],
    'password' => $apib['smsPass'],
	 'balance' => 'true'
), '', '&'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
# Get the response
$response = curl_exec($ch);
curl_close($ch);
echo $response;

}

function husmo($conn){
    
    function fetchhusm($conn){
$query_hus = $conn->query("SELECT * FROM providers_api_key WHERE provider='husmodata'");
$husmkey = $query_hus->fetch_assoc();
return json_encode($husmkey);
}    
$json_hus = json_decode(fetchhusm($conn));
 $husmokey = $json_hus->privatekey;
/////HusmoData
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://husmodataapi.com/api/user/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Token $husmokey"
  ),
));
$Husresponse = curl_exec($curl);
curl_close($curl);
return $Husresponse;
}



function gongoz($conn){
    
      function fetchgoz($conn){
$query_go = $conn->query("SELECT * FROM providers_api_key WHERE provider='gongoz'");
$gokey = $query_go->fetch_assoc();
return json_encode($gokey);
}    
$json_go = json_decode(fetchgoz($conn));
 $gongokey = $json_go->privatekey;
////////////////////////////////
/////Gongoz
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.gongozconcept.com/api/user/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Token $gongokey"
  ),
));
$Goresponse = curl_exec($curl);
$Goresult = json_decode($Goresponse);
curl_close($curl);
print (' &#x20A6;'.number_format($Goresult->user->Account_Balance,2).' ');
///////////////////////////////
}

function alrahuz($conn){
    
    function fetchalz($conn){
$query_alr = $conn->query("SELECT * FROM providers_api_key WHERE provider='alrahuz'");
$alrkey = $query_alr->fetch_assoc();
return json_encode($alrkey);
}    
$json_alr = json_decode(fetchalz($conn));
 $alrahuzkey = $json_alr->privatekey;
////////////////////////////////
/////Gongoz
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://alrahuzdata.com.ng/api/user/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Token $alrahuzkey"
  ),
));
$Alrahuzresponse = curl_exec($curl);
$Alrahresult = json_decode($Alrahuzresponse);
curl_close($curl);
print (' &#x20A6;'.number_format($Alrahresult->user->Account_Balance,2).' ');
///////////////////////////////
}



function n3tdata($conn){
    
    function fetchn3t($conn){
$query_n3t = $conn->query("SELECT * FROM providers_api_key WHERE provider='n3tdata'");
$n3tkey = $query_n3t->fetch_assoc();
return json_encode($n3tkey);
}    
$json_n3t = json_decode(fetchn3t($conn));
/////N3TDATA
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://n3tdata.com/api/user',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Basic ".base64_encode($json_n3t->privatekey.':'.$json_n3t->secretkey)
  ),
));
$N3Tresponse = curl_exec($curl);
$n3result = json_decode($N3Tresponse);
curl_close($curl);
return  print(' &#x20A6;'.number_format($n3result->balance,2).' ');
///////////////////////////////
}



function bigsub($conn){
    
function fetchbgsub($conn){
$query_bg = $conn->query("SELECT * FROM providers_api_key WHERE provider='bigsub'");
$bsubkey = $query_bg->fetch_assoc();
return json_encode($bsubkey);
}    
$json_big = json_decode(fetchbgsub($conn));
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://bigsub.com.ng/api/balance.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Basic ".base64_encode($json_big->privatekey.':'.$json_big->secretkey)
  ),
));
$Bigresponse = curl_exec($curl);
$bigresult = json_decode($Bigresponse);
curl_close($curl);
return print(' &#x20A6;'.number_format($bigresult->balance,2).' ');
///////////////////////////////
}

function zoedatahub($conn){
    
    function fetchzoekey($conn){
$query_zoehub = $conn->query("SELECT * FROM providers_api_key WHERE provider='zoedatahub'");
$zoekey = $query_zoehub->fetch_assoc();
return json_encode($zoekey);
}    
$json_zoe = json_decode(fetchzoekey($conn));
 $zoehubkey = $json_zoe->privatekey;
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://zoedatahub.com/api/user/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Token $zoehubkey"
  ),
));
$zoeresponse = curl_exec($curl);
$zoeresult = json_decode($zoeresponse);
curl_close($curl);
print (' &#x20A6;'.number_format($zoeresult->user->Account_Balance,2).' ');
///////////////////////////////
}
?>

<script>
$('#more').click(function(){
  $('#showall').slideDown("slow", function(){
   var action = $('#showall').show();  
   if (action) {
       $('#more').hide();
   }else {
      $('#more').show(); 
       $('#showall').hide(); 
   }
  });  
});  
    
    $('#collapse').click(function(){
  $('#showall').slideUp("slow", function(){
   var action = $('#showall').hide();  
   if (action) {
       $('#more').show();
   }else {
      $('#more').show(); 
       $('#showall').hide(); 
   }
  });  
});  
</script>