<?php
session_start();
require('../db.php');
include('../inc/func.php');
include('../inc/gravatar.php');
include('../inc/logo.php');
include('../inc/query_processor.php');
date_default_timezone_set('Africa/Lagos');
$dat = date("Y-m-d h:i:s");
?>
<?php include('../inc/header1.php'); ?>
<style id="table_style">
  /* Float four columns side by side */
  .column-data {
    float: left;
    width: 40%;
    padding: 10px;
    border: 1px solid black;
    border-style: dashed;


  }

  /* Remove extra left and right margins, due to padding */
  .row-data {
    margin: 0 0px;
  }

  /* Clear floats after the columns */
  .row:after {
    content: "";
    display: table;
    clear: both;
  }

  /* Responsive columns */
  @media screen and (max-width: 600px) {
    .column-data {
      width: 100%;
      display: block;
      margin-bottom: 20px;
    }
  }

  /* Style the counter cards */
  .card-data {
    box-shadow: 1px 1px 1px 1px rgba(0.2, 0.2, 0.2, 0.2);
    padding: 5px;
    text-align: left;
    background-color: #fff;
  }
</style>

<style>
  .table,
  tr,
  td {
    border: 0px solid black;
    border-style: dashed;
    padding: 1px;
  }


  td {
    font-size: 13px;
  }
</style>
<!-- ============================================================== -->
<!-- end navbar -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- left sidebar -->
<!-- ============================================================== -->
<?php include('../inc/nav2.php'); ?>

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
            <h2 class="pageheader-title"><i class="fa fa-print"></i> RECHARGE CARD PRINTING </h2>


          </div>
        </div>
      </div>

      <div class="ecommerce-widget">


        <div class="row">

          <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
            <div class="card">


              <?php

              function fetchmerchant($conn, $email)
              {
                $qryMercht =  $conn->query("SELECT * FROM pin_merchants WHERE merchantid='$email' AND status='ACTIVE'");
                $rowmach = $qryMercht->num_rows;
                return $rowmach;
              }

              function fetchTransact($conn, $veriID)
              {
                $ftra = $conn->query("SELECT * FROM transactions WHERE ref='$veriID'");
                while ($rwp[] = $ftra->fetch_assoc()) {
                }
                return json_encode($rwp);
              }


              if (isset($_GET['id'])):
                $veriID = base64_decode($_GET['id']);
                $prowz = $conn->query("SELECT * FROM mypin WHERE ref='$veriID'");
                $result = $prowz->fetch_assoc();
              endif;
              ?>

              <div>
                <?php
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

                $cardname = json_decode(fetchTransact($conn, $veriID), true)[0]['cardname'];
                ?>

              </div>
              <div class="card-body">

                <?php if (fetchmerchant($conn, $email) > 0) { ?>
                  <div class="row-data" id="elem">
                    <?php
                    $dataPins = $result['pins'];
                    $xtracto = explode("\n", $dataPins);
                    foreach ($xtracto as $rowpin) {

                      if ($result['net'] === 'mtn') {
                        $customercare = "180";
                        $dialcode = "*311*PIN#";

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
                        $serNum =  preg_replace("/[^0-9]/", "", $str_arr[4]);
                        $pinvalue = preg_replace("/[^0-9]/", "", $str_arr[5]);
                      } else if ($result['net'] === 'etisalat') {
                        $customercare = "200";
                        $dialcode = "*222*PIN#";
                        $str_arr = preg_split("/\s+/", $rowpin);
                        $displayPin = preg_replace("/[^0-9]/", "", $str_arr[6]);
                        $serNum = $str_arr[5];
                        $pinvalue = $str_arr[4];
                      }
                      $split = str_split($displayPin, 4);
                      $numToken = implode('-', $split);
                    ?>
                      <?php if (!empty($rowpin)) { ?>

                        <div class="column-data">

                          <i style="text-align:center;"> <?php echo '&#8358;' . $pinvalue . ' | ' . $cardname; ?></i>
                          <table>
                            <tr>

                              <td><b>PIN:</b> <span style="font-size:18px; font-weight: bolder;"><?php echo $numToken; ?></span></td>
                              <td> <img src="../<?php echo $img; ?>" width="35px;" height="35px;" align="right" /></td>
                            </tr>
                            <tr>
                              <td> <strong>S/N:</strong> <?php echo $serNum; ?></td>
                            </tr>
                            <tr>
                              <td> <strong>Date:</strong> <?php echo $dat; ?></td>
                            </tr>

                            <tr>
                              <td colspan="3" style="font-size:12px;"><strong>Dial <?php echo $dialcode; ?> </strong>send | Customer care: <?php echo $customercare; ?></td>

                            </tr>

                          </table>

                        </div>


                    <?php } else {

                        //echo "No record found";   
                      }
                    } ?>

                  </div>

                  <div class="row float-right">

                    <div class="col-3">
                      <button id="print" onclick="PrintElem('elem');" class="btn btn-outline-primary"><i class="fa fa-print"></i> Print</button>
                    </div>
                  </div>

                <?php } else { ?>

                  <div id="btnactivate"></div>

                  <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> Activate Recharge card printer </div>
                  <div class="row float-right">
                    <div class="col-3">
                      <button id="printactivator" class="btn btn-outline-success"><i class="fa fa-key"></i> Activate Card Printer</button>
                    </div>
                  </div>




                <?php } ?>

                <script>
                  /*
   $(document).ready(function (){
       var trid = "<?php //echo $_GET['id'];
                    ?>";
       var tok = "<?php //base64_encode($UserEmail);
                  ?>";
       $.get("../processor/comprnt.php", { id: trid,token:tok })
        .done(function( data ) {
       res = JSON.parse(data);
       var pin = res['pin'];
       var sn = res['serial'];
        $('#amount').val(fee);
        $('#notice').html(descr);
       });
      
         }); 
         */
                </script>


              </div>
            </div>




          </div>


          <!-- 
                            ============================================================== -->
          <!-- end recent orders  -->
          <script>
            $('#printactivator').click(() => {
              $('#pinprinter').modal('show');

            });
          </script>
          <script src="js/prnt.js"></script>


          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- customer acquistion  -->
          <!-- ============================================================== -->
          <?php include('../inc/sidebar.php'); ?>
          <!-- ============================================================== -->
          <!-- end customer acquistion  -->


          <!-- ============================================================== -->
        </div>
        <div class="row">


          <!-- Modal -->
          <div class="modal fade" id="pinprinter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title" align="center"> Recharge Card Printer Activation</h3>
                  <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </a>



                </div>
                <div class="modal-body">

                  <form method="POST" action="javascript:void(0)" id="pack-form"> <?php
                                                                                  $qryPack = $conn->query("SELECT * FROM epins_activation WHERE duration='2'");
                                                                                  function checkMerchantRecord($conn, $UserEmail)
                                                                                  {
                                                                                    $merCheck = $conn->query("SELECT * FROM pin_merchants WHERE merchantid='$UserEmail'");
                                                                                    $mrow = $merCheck->num_rows;
                                                                                    return $mrow;
                                                                                  }
                                                                                  $mtncgl = $conn->query("SELECT * FROM epins_activation   ORDER BY `amount` ASC");

                                                                                  ?>

                    <input type="hidden" name="fee" id="fee">
                    <input type="hidden" name="token" id="token" value="<?php echo base64_encode($UserEmail); ?>">
                    <div class="row ">

                      <div class="col-12">
                        <label>
                          <li class="fa fa-briefcase"></li> Select plan
                        </label>

                        <select name="plan" class="form-control" id="plan">
                          <option selected hidden disabled>Please choose..</option>
                          <?php while ($mcgl = $mtncgl->fetch_assoc()) { ?>
                            <option value="<?php echo $mcgl['serial']; ?>"> <?php echo $mcgl['plan']; ?> </option>
                          <?php  } ?>

                        </select>

                      </div>

                      <div class="col-12" id="fee">
                        <label>
                          <li class="fa fa-hand-holding-usd"></li> Amount
                        </label>
                        <div class="input-group mb-3">
                          <div class="input-group-prepend"><span class="input-group-text">&#x20A6;</span></div>
                          <input type="number" class="form-control" name="amount" id="amount">
                          <div class="input-group-append"><span class="input-group-text">.00</span></div>


                        </div>
                      </div>

                      <span id="notice"></span>

                    </div>

                    <div class="modal-footer">

                      <button type="submit" id="btnpay" class="btn btn-success"><i class="fa fa-credit-card"></i> Pay & Activate</button>
                    </div>
                  </form>


                  <script>
                    $('#plan').change(function() {
                      var opt = $(this).val();
                      $.get("plan.php", {
                          id: opt
                        })
                        .done(function(data) {
                          res = JSON.parse(data);
                          var fee = res['amount'];
                          var descr = res['description'];
                          $('#amount').val(fee);
                          $('#notice').html(descr);
                        });

                    });

                    $('#amount').prop('disabled', true);

                    $('#pack-form').submit(function(e) {
                      e.preventDefault();
                      var form = $(this).serialize();
                      var url = "../processor/e_activate.php";
                      $.ajax({
                        type: "GET",
                        url: url,
                        data: form,
                        dataType: "json",
                        beforeSend: function() {

                          $('#btnpay').html('Please wait...');
                        },
                        success: function(data) {
                          // Process with the response data
                          if (data.status === true) {
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
                              text: data.msg
                            })
                            setTimeout(function() {
                              document.location.reload();
                            }, 3000);
                          } else {

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
                              text: data.msg
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



          <script type="text/javascript">
            //datepicker plugin
            //link	



            function countMsgsText(val) {

              val = val.split("\n").join('??').split('{').join('??').split('}').join('??');

              val = val.split('\\').join('??').split('[').join('??').split(']').join('??');

              val = val.split('~').join('??').split('|').join('??').split('^').join('??');

              val = val.split('€').join('??').split('"').join('??').split("'").join('??');

              len = val.length;

              if (len <= 160) {

                jQuery('#paget').html('Page: ' + Math.ceil(len / 160));
                jQuery('#count').html(', Characters left: ' + (1 + ((160 - 1) * Math.ceil(len / 160)) - len) + ', Total Typed Characters: ' + len);

                jQuery('#hiddenCount').html(Math.ceil(len / 160) + ' page');

              } else {
                jQuery('#paget').html('Page: ' + Math.ceil(len / 151));
                jQuery('#count').html(', Characters left: ' + (1 + ((151 - 1) * Math.ceil(len / 151)) - len) + ', Total Typed Characters: ' + len);

                jQuery('#hiddenCount').html(Math.ceil(len / 151) + ' pages');

              }

              countDest();

            }
          </script>
          <!-- product sales  -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- end product sales  -->
          <!-- ============================================================== -->
        </div>

        <div class="row">
          <!-- ============================================================== -->
          <!-- sales  -->

          <!-- ============================================================== -->

        </div>
        <div class="row">
          <!-- ============================================================== -->

          <!-- end category revenue  -->
          <!-- ============================================================== -->
        </div>
        <div class="row">
          <!-- ============================================================== -->
          <!-- end sales traffice source  -->
          <!-- ============================================================== -->

        </div>
      </div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- footer -->
  <!-- ============================================================== -->
  <?php include('../inc/footer1.php'); ?>
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
<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<!-- bootstap bundle js -->
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<!-- slimscroll js -->
<script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
<!-- main js -->
<script src="../assets/libs/js/main-js.js"></script>
<!-- chart chartist js -->
<script src="../assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
<!-- sparkline js -->
<script src="../assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
<!-- morris js -->
<script src="../assets/vendor/charts/morris-bundle/raphael.min.js"></script>
<script src="../assets/vendor/charts/morris-bundle/morris.js"></script>
<!-- chart c3 js -->
<script src="../assets/vendor/charts/c3charts/c3.min.js"></script>
<script src="../assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
<script src="../assets/vendor/charts/c3charts/C3chartjs.js"></script>
<script src="../assets/libs/js/dashboard-ecommerce.js"></script>


<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
  $(function() {
    $('#tableId').DataTable();
  });
</script>


</body>

</html>