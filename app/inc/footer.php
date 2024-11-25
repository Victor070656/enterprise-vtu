<div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        
                    <?php 
                    function sitename($conn){
                $qrsn = $conn->query("SELECT * FROM settings");
                while($row[] = $qrsn->fetch_assoc()){}
                return json_encode($row);
                
                    }
                    ?>    
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            
                             Copyright © <SCRIPT language=JavaScript><!--

function affcopy() {
  /* Get the text field */
  var copyText = document.getElementById("myInput");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */

swal ( "Referral Link Copied" ,  "" ,  "success" ) 
  

}

function makeArray() {
     for (i = 0; i<makeArray.arguments.length; i++)
          this[i + 12] = makeArray.arguments[i];
}


var months = new makeArray('January','February','March',
    'April','May','June','July','August','September',
    'October','November','December');

var date = new Date();
var day  = date.getDate();
var month = date.getMonth() + 1;
var yy = date.getYear();
var year = (yy < 1000) ? yy + 1900 : yy;

document.write(year + " " ); 
//--></SCRIPT> <?php echo json_decode(sitename($conn),true)[0]['sitename'] ;?>. All rights reserved. 
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="text-md-right footer-links d-none d-sm-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="developers">Developers</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="assets/libs/js/dashboard-ecommerce.js"></script>
    <script src="js/sb-admin.js"></script>
    <script type="text/javascript" src="js/notify.min.js "></script>
</body>
 
</html>