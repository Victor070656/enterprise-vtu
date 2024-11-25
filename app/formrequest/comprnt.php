<?php
date_default_timezone_set('Africa/Lagos');
$dat = date("Y-m-d h:i:s");
$error = array();
$resp = array();

$id = base64_decode($_REQUEST['id']);
$UserEmail = base64_decode($_REQUEST['token']);
if (empty($id)) {
  $error[] = "Transaction ID is empty";
}
if (empty($UserEmail)) {
  $error[] = "User Id is empty";
}

if (count($error) > 0) {
  $resp['status'] = false;
  $resp['msg'] = $error;
  echo json_encode($resp);
  exit();
}
require_once('../db.php');
$prowz = $conn->query("SELECT * FROM mypin WHERE ref='$id'");
$result = $prowz->fetch_assoc();

if (strtolower($result['net']) == 'mtn'):
  $img = "assets/images/mtn.jpg";
endif;
if (strtolower($result['net']) == 'airtel'):
  $img = "assets/images/Airtel-Data.jpg";
endif;
if (strtolower($result['net']) == 'etisalat'):
  $img = "assets/images/9mobile-Data.jpg";
endif;
if (strtolower($result['net']) == 'glo'):
  $img = "assets/images/GLO-Data.jpg";
endif;

if (fetchmerchant($conn, $UserEmail) > 0) {

  $dataPins = $result['pins'];
  $xtracto = explode("\n", $dataPins);
  foreach ($xtracto as $rowpin) {

    if ($result['net'] === 'mtn') {
      $customercare = "180";
      $dialcode = "*555*PIN#";

      $str_arr = preg_split("/\s+/", $rowpin);
      if (!empty($str_arr[6])) {
        $displayPin = preg_replace("/[^0-9]/", "", $str_arr[6]);
        $serNum = $str_arr[5];
        $pinvalue = $str_arr[4];
      } else {

        $string = preg_replace('/\s+/', '', $rowpin);
        if (mb_strlen($string) == intval(25)) {
          $pin = substr($string, 10);
          $displayPin = substr($pin, 0, -5);
          $serNum = substr($string, 0, -15);
          $pinvalue = preg_replace("/[^0-9]/", "", substr($rowpin, -5));
        } else if (mb_strlen($string) == intval(45)) {
          $pin = substr($string, 17);
          $displayPin = substr($pin, 0, -11);
          $serNum = substr($string, 0, -28);
          $pinvalue = preg_replace("/[^0-9]/", "", substr($rowpin, -5));
        } else {
          $pin = NULL;
          $displayPin = NULL;
          $serNum = NULL;
          $dialcode = NULL;
          $pinvalue = NULL;
        }
      }
    } else if ($result['net'] === 'airtel') {

      $customercare = "111";
      $dialcode = "*126*PIN#";
      $str_arr = preg_split("/\s+/", $rowpin);
      if (!empty($str_arr[6])) {
        $displayPin = preg_replace("/[^0-9]/", "", $str_arr[6]);
        $serNum = $str_arr[5];
        $pinvalue = $str_arr[4];
      } else {

        $str_arr = preg_split("/\,/", $rowpin);
        $displayPin = $str_arr[0];
        $serNum = $str_arr[1];
        $pinvalue = preg_replace("/[^0-9]/", "", substr($str_arr[2], 4));
      }
    } else if ($result['net'] === 'glo') {
      $customercare = "121";
      $dialcode = "*123*PIN#";
      $str_arr = preg_split("/\,/", $rowpin);
      $displayPin = preg_replace("/[^0-9]/", "", $str_arr[3] . $str_arr[2]);
      $serNum = $str_arr[4];
      $pinvalue = preg_replace("/[^0-9]/", "", $str_arr[5]);
    } else if ($result['net'] === 'etisalat') {
      $customercare = "200";
      $dialcode = "*222*PIN#";
      $str_arr = preg_split("/\s+/", $rowpin);
      $displayPin = preg_replace("/[^0-9]/", "", $str_arr[6]);
      $serNum = $str_arr[5];
      $pinvalue = $str_arr[4];
      $customercare = "";
    }
    $split = str_split($displayPin, 4);
    $numToken = implode('-', $split);

    if (!empty($rowpin)) {

      session_start();

      $resp['msg'] = ' <div class="column-data" >
    
    <i style="text-align:center;"> &#8358;' . $pinvalue . ' | ' . $_SESSION['cardname'] . ' </i>   
    <table>
     <tr>
    
    <td><b>PIN:</b> <span style="font-size:18px; font-weight: bolder;">' . $numToken . '</span></td> 
     <td> <img src="../' . $img . '" width="35px;" height="35px;" align="right"/></td>
    </tr>  
    <tr>
    <td> <strong>S/N:</strong> ' . $serNum . '</td> 
    </tr>
    <tr>
    <td> <strong>Date:</strong> ' . $dat . '</td> 
    </tr> 
   
     <tr>
    <td  colspan="3" style="font-size:12px;"><strong>Dial ' . $dialcode . ' </strong>send | Customer care: ' . $customercare . '</td> 
   
    </tr>
        
    </table>
    
  </div>';
      $resp['status'] = true;
      echo json_encode($resp);
      exit();
    } else {

      $error[] = "No record found";
      $resp['status'] = false;
      $resp['msg'] = $error;
      echo json_encode($resp);
      exit();
    }
  }
} else {

  $error[] = '<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> Activate your account now to generate and print recharge card </div>';
  $resp['status'] = false;
  $resp['msg'] = $error;
  echo json_encode($resp);
  exit();
}


function fetchmerchant($conn, $UserEmail)
{
  $qryMercht =  $conn->query("SELECT * FROM rechargecard_merchants WHERE merchantid='$UserEmail' AND status='ACTIVE'");
  $rowmach = $qryMercht->num_rows;
  return $rowmach;
}
