<?php 
session_start();
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}
require('../db.php');

$user = $_SESSION['user'];
include('../inc/logo.php');
include('inc/header.php');
?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">



  <!-- Navigation-->
 <?php include('inc/nav.php');?>
  <!-- Navigation Ends--> 
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
  
    <div class="container-fluid">
      <!-- Breadcrumbs-->
     
      <div class="row">
        <div class="col-12">
          
     <p></p>
     <h1 class="w3-xxxlarge w3-text-green" align="center"><b>PIN ANALYTICS</b></h1>
       
<p align="center">PIN Analytics gives you analysis of Airtime PINs available for download in your database </p>
      <!-- Example Bar Chart Card-->
       
     <?php 
		   // define variables and set to empty values
 
		
	$query_rec = $conn->query("SELECT * FROM pin_billing");
	$pin_bil = $query_rec->fetch_array();
//echo	$server = $_SERVER['SERVER_NAME'].'/'.basename(dirname(__FILE__));

$base  = basename(dirname(__FILE__));
$cur_url = 'https://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']);
$server = str_replace($base,"",$cur_url);
	
	
		$SQLmtn1 = "SELECT COUNT(*) FROM pinstock WHERE net='MTN' AND deno='1' ";
$mt1 = $conn->query($SQLmtn1);
$mtpin1 = $mt1->fetch_row();
			
$SQLmtn2 = "SELECT COUNT(*) FROM pinstock WHERE net='MTN' AND deno='2' ";
$mt2 = $conn->query($SQLmtn2);
$mtpin2 = $mt2->fetch_row();

$SQLmtn4 = "SELECT COUNT(*) FROM pinstock WHERE net='MTN' AND deno='4' ";
$mt4 = $conn->query($SQLmtn4);
$mtpin4 = $mt4->fetch_row();

$SQLmtn5 = "SELECT COUNT(*) FROM pinstock WHERE net='MTN' AND deno='5' ";
$mt5 = $conn->query($SQLmtn5);
$mtpin5 = $mt5->fetch_row();
			
$SQLmtn7 = "SELECT COUNT(*) FROM pinstock WHERE net='MTN' AND deno='7.5' ";
$mt7 = $conn->query($SQLmtn7);
$mtpin7 = $mt7->fetch_row();

$SQLmtn10 = "SELECT COUNT(*) FROM pinstock WHERE net='MTN' AND deno='10' ";
$mt10 = $conn->query($SQLmtn10);
$mtpin10 = $mt10->fetch_row();

$SQLmtn15 = "SELECT COUNT(*) FROM pinstock WHERE net='MTN' AND deno='15' ";
$mt15 = $conn->query($SQLmtn15);
$mtpin15 = $mt15->fetch_row();
			

$SQLatPins1 = "SELECT COUNT(*) FROM pinstock WHERE net='Airtel' AND deno='1' ";
$qryatPin1 = $conn->query($SQLatPins1);
$atpin1 = $qryatPin1->fetch_row();
		
$SQLatPins2 = "SELECT COUNT(*) FROM pinstock WHERE net='Airtel' AND deno='2' ";
$qryatPin2 = $conn->query($SQLatPins2);
$atpin2 = $qryatPin2->fetch_row();			
			
$SQLatPins5 = "SELECT COUNT(*) FROM pinstock WHERE net='Airtel' AND deno='5' ";
$qryatPin5 = $conn->query($SQLatPins5);
$atpin5 = $qryatPin5->fetch_row();
			
$SQLatPins10 = "SELECT COUNT(*) FROM pinstock WHERE net='Airtel' AND deno='10' ";
$qryatPin10 = $conn->query($SQLatPins10);
$atpin10 = $qryatPin10->fetch_row();			
			
			

$SQLglPins1 = "SELECT COUNT(*) FROM pinstock WHERE net='Glo' AND deno='1' ";
$qryglPin1 = $conn->query($SQLglPins1);
$glpin1 = $qryglPin1->fetch_row();

$SQLglPins2 = "SELECT COUNT(*) FROM pinstock WHERE net='Glo' AND deno='2' ";
$qryglPin2 = $conn->query($SQLglPins2);
$glpin2 = $qryglPin2->fetch_row();	
			
$SQLglPins5 = "SELECT COUNT(*) FROM pinstock WHERE net='Glo' AND deno='5' ";
$qryglPin5 = $conn->query($SQLglPins5);
$glpin5 = $qryglPin5->fetch_row();			
			
$SQLglPins10 = "SELECT COUNT(*) FROM pinstock WHERE net='Glo' AND deno='10' ";
$qryglPin10 = $conn->query($SQLglPins10);
$glpin10 = $qryglPin10->fetch_row();
			
		
$SQLetiPins1 = "SELECT COUNT(*) FROM pinstock WHERE net='9mobile' AND deno='1' ";
$qryetiPin1 = $conn->query($SQLetiPins1);
$etipin1 = $qryetiPin1->fetch_row();
			
$SQLetiPins2 = "SELECT COUNT(*) FROM pinstock WHERE net='9mobile' AND deno='2' ";
$qryetiPin2 = $conn->query($SQLetiPins2);
$etipin2 = $qryetiPin2->fetch_row();			

$SQLetiPins5 = "SELECT COUNT(*) FROM pinstock WHERE net='9mobile' AND deno='5' ";
$qryetiPin5 = $conn->query($SQLetiPins5);
$etipin5 = $qryetiPin5->fetch_row();
			
			
$SQLetiPins10 = "SELECT COUNT(*) FROM pinstock WHERE net='9mobile' AND deno='10' ";
$qryetiPin10 = $conn->query($SQLetiPins10);
$etipin10 = $qryetiPin10->fetch_row();		
		?> 
       
  <form action="" method="post" autocomplete = 'off' > 
  
     <table class="table   table-responsive" id="transTable">
                     
                     
                 
                          <tr>
                            <td width="15%"><img src="<?php echo $server;?>/assets/images/mtn.jpg" width="55" height="50" /></td>
							  
							  <td id="mainService"> ₦100 = <?php print($mtpin1[0]);?> </td>
							  <td id="mainService"> ₦200 = <?php print($mtpin2[0]);?> </td>
							  <td id="mainService"> ₦400 = <?php print($mtpin4[0]);?></td>
							  <td id="mainService"> ₦500 = <?php print($mtpin5[0]);?></td>
							  <td id="mainService"> ₦750 = <?php print($mtpin7[0]);?> </td>
							  <td id="mainService"> ₦1000 = <?php print($mtpin10[0]);?> </td>
							  <td id="mainService"> ₦1500 = <?php print($mtpin15[0]);?> </td>
                             </tr>
                                                <tr>
                            <td width="15%"><img src="<?php echo $server;?>/assets/images/airtel.jpg" width="55" height="50"/></td>
                            
							<td id="mainService"> ₦100 = <?php print($atpin1[0]);?> </td>
							  <td id="mainService"> ₦200 = <?php print($atpin2[0]);?> </td>
							  <td id="mainService"> ₦500 = <?php print($atpin5[0]);?> </td>
							  
							  <td id="mainService"> ₦1000 = <?php print($atpin10[0]);?> </td>						
                        </tr>                   
                                                            <tr>
                        <td width="15%"><img src="<?php echo $server;?>/assets/images/glo.jpg" width="55" height="50"/></td>
																
                        <td id="mainService"> ₦100 = <?php print($glpin1[0]);?> </td>
							  <td id="mainService"> ₦200 = <?php print($glpin2[0]);?> </td>
							  <td id="mainService"> ₦500 = <?php print($glpin5[0]);?> </td>
							  
							  <td id="mainService"> ₦1000 = <?php print($glpin10[0]);?> </td>
                    </tr>
                                          
                    <tr>
                        <td width="15%"><img src="<?php echo $server;?>/assets/images/9mobile.jpg" width="55" height="50"/></td>
						
                        <td id="mainService"> ₦100 = <?php print($etipin1[0]);?> </td>
							  <td id="mainService"> ₦200 = <?php print($etipin2[0]);?> </td>
							  <td id="mainService"> ₦500 = <?php print($etipin5[0]);?> </td>
							  
							  <td id="mainService"> ₦1000 = <?php print($etipin10[0]);?> </td>
                    </tr>                                       
                   
                    
                                            <tr>
                            <td colspan="2">
                           
                                <div class="pay-button">
                                                                                                                                                                                                                                
                                </div>
                              							               </td>
                        </tr>
                                    </table> 
  
  </form>
  
        
    </div>
    <!-- /.container-fluid-->
    
   
    
    <!-- /.content-wrapper-->
    <?php include('inc/footer.php');?>