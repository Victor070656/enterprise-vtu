<?php 
require_once('../../db.php');
$data = json_decode(file_get_contents('php://input'));
$error = array();
$resp = array();
		$epinsKey = $data->epins;
		$shagokey = $data->shagokey;
		$vtuser = $data->VTuser;
		$vtpass = $data->VTpass;
		$clubkey = $data->clubkey;
		$clubid = $data->clubUserid;
		$smartkey = $data->smartkey;
		$mobilekey = $data->mobilekey;
		$mobileID = $data->mobileID; 
		$activeAPI = $data->payactive;
        $smeplug = $data->smeplugkey;
        $smeplgSecret = $data->smeplugsecret;
		$activesme = $data->smeactive;
        $husmodata = $data->husmodata;
        $gongoz = $data->gongoz;
        $alrahuz = $data->alrahuz;
  // file_put_contents("test.txt",file_get_contents('php://input'));   
        
  if(empty($epinsKey)){
    $error[] = "Enter ePINs API Key";  
  }      
   
   if(count($error) > 0){
     $resp['status'] =  false;
     $resp['msg'] = $error;
     echo json_encode($resp);
     exit();
   }     
    
/////////////////////////////////////////////////////////////////////        
 $runQuery = $conn->query("UPDATE api_setting SET APIkey ='$epinsKey',VTuser='$vtuser',VTpass='$vtpass',clubkey='$clubkey',clubId='$clubid',smartkey='$smartkey',mobilekey='$mobilekey',mobileID='$mobileID',active='$activeAPI',smeactive='$activesme',tvactive='$tvactive',poweractive='$poweractive',smileactive='$smileactive',dataactive='$dataactive',waecactive='$waecactive',smeplugkey='$smeplug',smeplugsecret='$smeplgSecret',husmodata='$husmodata',necoactive='$necoactive',shago='$shagokey',moneytransfer='$moneytransfer',spectranet='$spectranet',gongoz='$gongoz',alrahuz='$alrahuz' ");
 
 ////////////////////////////END DATA ID UPDATE ///////////////////////

if($runQuery){
// response

$resp['msg'] = "Gateway Updated";
$resp['status'] =  true;
echo json_encode($resp);
exit(); 

}else{
    $error[] = "Error processing your request";
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit();   

}


?>