<?php 
session_start();
require('../db.php');
if(!isset($_SESSION["loginId"]) || $_SESSION["loginId"] !== true){
header("location: index.php");
exit();
}							
$user = $_SESSION['user'];

include('../inc/logo.php');
?>

<?php include('inc/header.php');?>

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
          
     
     <h2 class="w3-xxxlarge w3-text-blue" align="center"><b>Service Update Alert</b></h2>
       
<p align="center"><strong>Description:</strong> Set service update popup alert</p>
      <!-- Example Bar Chart Card-->
       
     <?php 
         include('inc/news.php');
		 	$query_nrec = $conn->query("SELECT * FROM newsalert");
			$nebil = $query_nrec->fetch_assoc();
			
				if($nebil['img_stat'] === 'show'){	
			    
			 $Show = "checked";
			$hide = "unchecked";   
			    
			}elseif($nebil['img_stat'] === 'hide'){
				
				$Show = "unchecked";
				$hide = "checked";	
			
				
					}else{
					 
					 $show = NULL;
					 $hide = NULL;
					    
					}	
				
		?> 
       
  <form action="" method="post" autocomplete = 'off' enctype="multipart/form-data"> 
  
     <table class="table  margin-tp-10" id="transTable">
                     
                          <tr>
                            <td width="30%">Display Image (400 X 200)</td>
                            <td>
                                <label class="custom-radio custom-control-inline">
          <input type="radio" id="imgStat" name="imgStat"  class="form-control" value="show" <?php echo $Show; ?> > <label class="badge badge-warning">Show</label> 
                            </label>  
                     
                                            
                <label class="custom-radio custom-control-inline">
          <input type="radio" id="imgStat" name="imgStat"  class="form-control" value="hide" <?php echo $hide; ?> > <span class="custom-control-label"><label class="badge badge-danger">Hide</label></span>
                                            </label> 
                                            
                                <input type="file" id="file" name="file"  class="form-control" >    </td>
                            <td><img src="<?php echo $nebil['img_link'];?>" width="100"/></td>
                        </tr> 
                        <tr>
                            <td width="30%">Heading</td>
                            <td><textarea type="text" id="h" name="h"  class="form-control" required> <?php echo $nebil['heading'];?> </textarea>  </td>
                        </tr>  
                        
                        <tr>
                            <td width="30%">Content</td>
                            <td><textarea type="text" id="n" name="n"  class="form-control" required> <?php echo $nebil['content'];?> </textarea>  </td>
                        </tr>              
                                                            <tr>
                    
                    
                    <tr>
                            <td width="30%">Link</td>
                            <td><textarea type="text" id="l" name="l"  class="form-control" required> <?php echo $nebil['link'];?> </textarea>  </td>
                        </tr>  
                        
                        
                        
                        <tr>
                            <td width="30%">Call to action</td>
                            <td><textarea type="text" id="b" name="b"  class="form-control" required> <?php echo $nebil['btn'];?> </textarea>  </td>
                        </tr>       
                                                            <tr>
                    
                    
                                            <tr>
                            <td colspan="2">
                                                                                            <button type="submit" id="submit" name="news" style="cursor:pointer" class="btn btn-info">Publish</button>
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