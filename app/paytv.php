<?php
session_start();
require_once('db.php');
include('inc/func.php');
include('inc/gravatar.php');
include('inc/logo.php');
include('inc/header.php'); ?>


<!-- ============================================================== -->
<!-- end navbar -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- left sidebar -->
<!-- ============================================================== -->
<?php include('inc/nav.php'); ?>
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
            <h2 class="pageheader-title">
              <li class="fa fa-tv"></li> TV Subscription
            </h2>

          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end pageheader  -->
      <!-- ============================================================== -->
      <div class="ecommerce-widget">

        <div class="row"></div>
        <div class="row">
          <!-- ============================================================== -->

          <!-- ============================================================== -->

          <!-- recent orders  -->
          <!-- ============================================================== -->
          <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">

            <div class="card">

              <h5 class="card-header"></h5>
              <div class="card-body">


                <label for="inputText3" class="col-form-label">Please Decoder To Recharge</label><br>
                <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="carier" id="gotv" class="custom-control-input" value="gotv" onclick="javascript:showTv();"><span class="custom-control-label"><img src="assets/images/Gotv-Payment.jpg" width="35" height="30" class="rounded-corners"></span>
                </label>


                <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="carier" id="dstv" class="custom-control-input" value="dstv" onclick="javascript:showTv();"><span class="custom-control-label"><img src="assets/images/Pay-DSTV-Subscription.jpg" width="35" height="30" class="rounded-corners"></span>
                </label>

                <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="carier" class="custom-control-input" value="startimes" onclick="javascript:showTv();" id="startimes"><span class="custom-control-label"><img src="assets/images/Startimes-Subscription.jpg" width="35" height="30" class="rounded-corners"></span>
                </label>





                <p></p>
                <div class="float-center">
                  <img style="display:none;" id="bigpic" src="bigpic" width="120" height="90" class="rounded-corners" />

                </div>






                <!-- Start GOTV hidden -->
                <div class="float-center" id="ifGotv" style="display:none;">

                  <form action="javascript:void(0)" id="mtncglite" method="post">

                    <div class="form-group" id="dataplans">
                      <label for="inputText3" class="col-form-label"></label>
                      <input type="hidden" id="unit">
                      <input type="hidden" name="network" id="network">
                      <input type="hidden" name="token" id="token" value="<?php echo base64_encode($email); ?>">


                      <select class="form-control rounded-right" name="plan" id="plan" style="border-radius: 0px; height: 50px;">
                        <?php $mtncgl = $conn->query("SELECT * FROM tv_package WHERE network='gotv'  ORDER BY `amount` ASC"); ?>
                        <option selected disabled hidden>Select Gotv Plan</option>

                        <?php while ($mcgl = $mtncgl->fetch_assoc()) { ?>
                          <option value="<?php echo $mcgl['serial']; ?>"> <?php echo $mcgl['plan']; ?> </option>
                        <?php } ?>

                      </select>

                    </div>


                    <div class="form-group">
                      <label for="inputText3" class="col-form-label">Enter IUC Number</label>
                      <input id="iuc" type="number" class="form-control rounded-right" name="iuc" style="border-radius: 0px; height: 50px;">
                    </div>
                    <span id="amountpay"></span>

                    <div class="col-sm-6 pl-0">
                      <p class="text-center">
                        <button type="submit" id="gotvorder" class="btn btn-rounded btn-danger"><i class="fa fa-arrow-right"></i> Proceed </button>

                      </p>
                    </div>

                  </form>

                  <script>
                    $(document).ready(function() {
                      $('#gotvorder').prop('disabled', true);
                      $("#iuc").on('keyup change', function() {
                        //var selectednetwork = $(this).children("option:selected").val();
                        var selected = $('#plan :selected').val();
                        var tok = $('#token').val();
                        var selectednetwork = $("#network").val();
                        var amounttopay = $('#unit').val();
                        var smartno = $("#iuc").val();
                        var amount_to_pay = amounttopay

                        if (smartno.toString().length >= 10) {

                          $.ajax({
                              url: "formrequest/validatedecoder.php",
                              type: 'GET',
                              data: {
                                id: selected,
                                token: tok,
                                iuc: smartno
                              },
                              beforeSend: function() {
                                $("#amountpay").html('<i class="fa fa-spinner"></i> Validating IUC Number, Please wait...');
                              },
                            })
                            .done(function(resp) {
                              res = JSON.parse(resp);
                              var msg = res['msg'];
                              var banquet = res['banquet'];
                              var name = res['name'];
                              var due = res['due'];
                              if (res['status'] === true) {
                                $("#amountpay").html("<font color='green'><i class='fa fa-check-circle'></i> " + msg + " </font> <b>Customer Name:</b> " + name + " | <b>Current Banquet:</b> " + banquet + " | <b>Due Date:</b> " + due + " ");
                                $('#gotvorder').prop('disabled', false);
                              } else {

                                $("#amountpay").html("<font color='red'><i class='fa fa-exclamation-circle'></i> " + msg + " </font>");
                                $('#gotvorder').prop('disabled', true);
                              }
                            });


                        } else if (smartno.toString().length < 10) {
                          $("#amountpay").html("<font color='blue'><i class='fa fa-exclamation-circle'></i> Enter valid decoder number </font>");
                          $('#gotvorder').prop('disabled', true);
                        } else if (selected === "") {
                          $('#gotvorder').prop('disabled', true);
                          $("#amountpay").html('<font color="red"> <i class="fa fa-exclamation-circle"></i>  Please select TV Plan first </font>');
                          //$(this).val(''); 

                        } else {
                          $('#gotvorder').prop('disabled', true);
                          $("#amountpay").text(amount_to_pay);
                        }

                      });


                      $('#mtncglite').submit(function(e) {
                        e.preventDefault();
                        var formData = $(this).serialize();
                        $.ajax({
                          url: "formrequest/ini-tv.php",
                          type: "GET",
                          data: formData,
                          dataType: "json",
                          contentType: 'application/json; charset=utf-8',
                          async: false,
                          beforeSend: function() {
                            $('#gotvorder').html('<i class="fa fa-spinner"></i> Please wait...');
                          },
                          success: function(data) {
                            // Process with the response data
                            // alert(data);
                            if (data.status === true) {
                              var dirUrl = data.redirect;
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
                                document.location.replace(dirUrl);
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

                    });
                  </script>

                </div>
                <!-- End GOTV hidden -->


                <!-- Start DSTV hidden -->
                <div class="float-center" id="ifDstv" style="display:none;">
                  <div class="form-group">
                    <form action="javascript:void(0)" id="dstvpay" method="post"> <label for="inputText3" class="col-form-label"></label>
                      <input type="hidden" name="network" id="networkDstv"> <input type="hidden" id="dunit">
                      <input type="hidden" name="token" id="tokendstv" value="<?php echo base64_encode($email); ?>">



                      <select class="form-control rounded-right" name="plan" id="dstvplan" style="border-radius: 0px; height: 50px;">
                        <?php $airtelsme = $conn->query("SELECT * FROM tv_package WHERE network='dstv'  ORDER BY `amount` ASC"); ?>
                        <option selected disabled hidden>Select Dstv Plan</option>

                        <?php while ($asm = $airtelsme->fetch_assoc()) { ?>
                          <option value="<?php echo $asm['serial']; ?>"> <?php echo $asm['plan']; ?> </option>

                        <?php } ?>

                      </select>



                  </div>

                  <div class="form-group">
                    <label for="inputText3" class="col-form-label">Enter Smartcard Number</label>
                    <input id="dstvno" type="number" class="form-control rounded-right" name="iuc" style="border-radius: 0px; height: 50px;">
                  </div>
                  <span id="dstv_stats"></span>
                  <div class="col-sm-6 pl-0">
                    <p class="text-center">
                      <button type="submit" id="dstvorder" class="btn btn-rounded btn-primary"><i class="fa fa-arrow-right"></i> Proceed </button>

                    </p>
                  </div>

                  </form>

                  <script>
                    $(document).ready(function() {
                      $('#dstvorder').prop('disabled', true);
                      $("#dstvno").on('keyup change', function() {
                        //var selectednetwork = $(this).children("option:selected").val();
                        var dstvselected = $('#dstvplan :selected').val();
                        var dstvtok = $('#tokendstv').val();
                        var selectednetwork = $("#networkDstv").val();
                        var dstvamounttopay = $('#dunit').val();
                        var dstvsmartno = $("#dstvno").val();
                        //amount_to_pay = amounttopay 

                        if (dstvsmartno.toString().length >= 10) {

                          $.ajax({
                              url: "formrequest/validatedecoder.php",
                              type: 'GET',
                              data: {
                                id: dstvselected,
                                token: dstvtok,
                                iuc: dstvsmartno
                              },
                              beforeSend: function() {
                                $("#dstv_stats").html('<i class="fa fa-spinner"></i> Validating Smartcard Number, Please wait...');
                              },
                            })
                            .done(function(response) {
                              des = JSON.parse(response);
                              var msg = des['msg'];
                              var banquet = des['banquet'];
                              var name = des['name'];
                              var due = des['due'];
                              if (des['status'] === true) {
                                $("#dstv_stats").html("<font color='green'><i class='fa fa-check-circle'></i> " + msg + " </font> <b>Customer Name:</b> " + name + " | <b>Current Banquet:</b> " + banquet + " | <b>Due Date:</b> " + due + " ");
                                $('#dstvorder').prop('disabled', false);
                              } else {

                                $("#dstv_stats").html("<font color='red'><i class='fa fa-exclamation-circle'></i> " + msg + " </font>");
                                $('#dstvorder').prop('disabled', true);
                              }
                            });


                        } else if (dstvsmartno.toString().length < 10) {
                          $("#dstv_stats").html("<font color='blue'><i class='fa fa-exclamation-circle'></i> Enter valid decoder number </font>");
                          $('#dstvorder').prop('disabled', true);
                        } else if (dstvselected === "") {
                          $('#dstvorder').prop('disabled', true);
                          $("#dstv_stats").html('<font color="red"> <i class="fa fa-exclamation-circle"></i>  Please select TV Plan first </font>');
                          //$(this).val(''); 

                        } else {
                          $('#dstvorder').prop('disabled', true);
                          $("#dstv_stats").text(amount_to_pay);
                        }

                      });

                      $('#dstvpay').submit(function(e) {
                        e.preventDefault();
                        var formData = $(this).serialize();
                        $.ajax({
                          url: "formrequest/ini-tv.php",
                          type: "GET",
                          data: formData,
                          dataType: "json",
                          contentType: 'application/json; charset=utf-8',
                          async: false,
                          beforeSend: function() {
                            $('#dstvorder').html('<i class="fa fa-spinner"></i> Please wait...');
                          },
                          success: function(data) {
                            // Process with the response data
                            // alert(data);
                            if (data.status === true) {
                              var dirUrl = data.redirect;
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
                                document.location.replace(dirUrl);
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

                    });
                  </script>

                </div>
                <!-- End DSTV hidden -->

                <!-- Start STARTTIMES hidden -->
                <div class="float-center" id="ifStar" style="display:none;">
                  <div class="form-group">

                    <form action="javascript:void(0)" id="starpay" method="post">
                      <input type="hidden" name="network" id="networkstar">

                      <input type="hidden" name="token" id="tokenstar" value="<?php echo base64_encode($email); ?>">
                      <div class="form-group">
                        <label for="inputText3" class="col-form-label"></label>

                      </div>

                      <select class="form-control rounded-right" name="plan" id="stvplan" style="border-radius: 0px; height: 50px; ">
                        <?php $glosme = $conn->query("SELECT * FROM tv_package WHERE network='startimes'  ORDER BY `amount` ASC"); ?>
                        <option selected disabled hidden>Select Startimes Plan</option>

                        <?php while ($gsm = $glosme->fetch_assoc()) { ?>
                          <option value="<?php echo $gsm['serial']; ?>"> <?php echo $gsm['plan']; ?> </option>

                        <?php } ?>

                      </select>

                  </div>




                  <div class="form-group">
                    <label for="inputText3" class="col-form-label">Enter Smartcard Number</label>
                    <input id="stvno" type="number" class="form-control rounded-right" name="iuc" style="border-radius: 0px; height: 50px;">
                  </div>
                  <span id="statstar"></span>
                  <div class="col-sm-6 pl-0">
                    <p class="text-center">
                      <button type="submit" id="starorder" class="btn btn-rounded btn-warning active"><i class="fa fa-arrow-right"></i> Proceed </button>

                    </p>
                  </div>

                  </form>

                  <script>
                    $(document).ready(function() {
                      $('#starorder').prop('disabled', true);
                      $("#stvno").on('keyup change', function() {
                        //var selectednetwork = $(this).children("option:selected").val();
                        var stvselected = $('#stvplan :selected').val();
                        var stvtok = $('#tokenstar').val();
                        var selectednetworkstv = $("#networkstv").val();
                        //var staramounttopay = $('#unit').val();
                        var stvsmartno = $("#stvno").val();
                        //amount_to_pay = amounttopay 

                        if (stvsmartno.toString().length >= 10) {

                          $.ajax({
                              url: "formrequest/validatedecoder.php",
                              type: 'GET',
                              data: {
                                id: stvselected,
                                token: stvtok,
                                iuc: stvsmartno
                              },
                              beforeSend: function() {
                                $("#statstar").html('<i class="fa fa-spinner"></i> Validating Smartcard Number, Please wait...');
                              },
                            })
                            .done(function(respon) {
                              ses = JSON.parse(respon);
                              var msg = ses['msg'];
                              var banquet = ses['banquet'];
                              var name = ses['name'];
                              var due = ses['due'];
                              if (ses['status'] === true) {
                                $("#statstar").html("<font color='green'><i class='fa fa-check-circle'></i> " + msg + " </font> <b>Customer Name:</b> " + name + " | <b>Current Banquet:</b> " + banquet + " | <b>Due Date:</b> " + due + " ");
                                $('#starorder').prop('disabled', false);
                              } else {

                                $("#statstar").html("<font color='red'><i class='fa fa-exclamation-circle'></i> " + msg + " </font>");
                                $('#starorder').prop('disabled', true);
                              }
                            });


                        } else if (stvsmartno.toString().length < 10) {
                          $("#statstar").html("<font color='blue'><i class='fa fa-exclamation-circle'></i> Enter valid decoder number </font>");
                          $('#starorder').prop('disabled', true);
                        } else if (stvselected === "") {
                          $('#stvorder').prop('disabled', true);
                          $("#statstar").html('<font color="red"> <i class="fa fa-exclamation-circle"></i>  Please select TV Plan first </font>');
                          //$(this).val(''); 

                        } else {
                          $('#starorder').prop('disabled', true);
                          $("#statstar").text(amount_to_pay);
                        }

                      });

                      $('#starpay').submit(function(e) {
                        e.preventDefault();
                        var formData = $(this).serialize();
                        $.ajax({
                          url: "formrequest/ini-tv.php",
                          type: "GET",
                          data: formData,
                          dataType: "json",
                          contentType: 'application/json; charset=utf-8',
                          async: false,
                          beforeSend: function() {
                            $('#starorder').html('<i class="fa fa-spinner"></i> Please wait...');
                          },
                          success: function(data) {
                            // Process with the response data
                            // alert(data);
                            if (data.status === true) {
                              var dirUrl = data.redirect;
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
                                document.location.replace(dirUrl);
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
                    });
                  </script>

                </div>
                <!-- End STARTIMES hidden -->














              </div>
            </div>
          </div>
          <!-- ============================================================== -->
          <!-- end recent orders  -->

          <script src="js/sb-tv.js"></script>
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- customer acquistion  -->
          <!-- ============================================================== -->
          <?php include('inc/sidebar.php'); ?>
          <!-- ============================================================== -->



          <!-- end customer acquistion  -->

          <?php include('inc/recent-transaction-widget.php'); ?>
          <!-- ============================================================== -->
          <!-- ============================================================== -->
        </div>



      </div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- footer -->
  <!-- ============================================================== -->
  <?php include('inc/footer.php');  ?>