<?php
session_start();
require('db.php');
include('inc/func.php');
include('inc/gravatar.php');
include('inc/logo.php');
include('inc/coinpayments.inc.php');
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
              <li class="fa fa-wifi"></li> BUY DATA Bundle
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

                <?php



                $glo = $conn->query("SELECT * FROM data_package WHERE network='02' AND datatype='cglite'");
                $etisalat = $conn->query("SELECT * FROM data_package WHERE network='03' AND datatype='cglite'");
                ?>



                <label for="inputText3" class="col-form-label">Please Network To Recharge</label><br>
                <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="carier" id="mtn" class="custom-control-input" value="01" onclick="javascript:showTv();"><span class="custom-control-label"><img src="assets/images/mtn.jpg" width="35" height="30" class="rounded-corners"></span>
                </label>


                <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="carier" id="airtel" class="custom-control-input" value="04" onclick="javascript:showTv();"><span class="custom-control-label"><img src="assets/images/airtel.jpg" width="35" height="30" class="rounded-corners"></span>
                </label>

                <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="carier" class="custom-control-input" value="02" onclick="javascript:showTv();" id="glo"><span class="custom-control-label"><img src="assets/images/glo.jpg" width="35" height="30" class="rounded-corners"></span>
                </label>


                <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="carier" class="custom-control-input" value="03" onclick="javascript:showTv();" id="9mobile"><span class="custom-control-label"><img src="assets/images/9mobile.jpg" width="35" height="30" class="rounded-corners"></span>
                </label>



                <p></p>
                <div class="float-center">
                  <img style="display:none;" id="bigpic" src="bigpic" width="120" height="90" class="rounded-corners" />

                </div>






                <!-- Start GOTV hidden -->
                <div class="float-center" id="ifGotv" style="display:none;">

                  <form action="javascript:void(0)" id="mtncglite" method="post">

                    <div class="form-group">
                      <label for="inputText3" class="col-form-label"></label>
                      <select id="data_type" class="form-control rounded-right" name="dataplan" style="border-radius: 0px; height: 50px;" required>
                        <option selected disabled hidden>Select DataType</option>
                        <option id="SME" style="display: none;">SME</option>
                        <option id="CG_LITE" style="display: none;">CG_LITE</option>
                        <option id="GIFTING" style="display: none;">GIFTING</option>
                        <option id="DIRECT" style="display: none;">DIRECT</option>

                      </select>
                    </div>

                    <div class="form-group" id="dataplans" style="display: none">
                      <label for="inputText3" class="col-form-label"></label>
                      <input type="hidden" name="network" id="network">
                      <input type="hidden" name="token" id="token" value="<?php echo base64_encode($email); ?>">


                      <select class="form-control rounded-right" name="plan" id="cglite" style="border-radius: 0px; height: 50px; display: none">
                        <?php $mtncgl = $conn->query("SELECT * FROM data_package WHERE network='01' AND datatype='cglite' ORDER BY `price_user` ASC"); ?>
                        <option selected disabled hidden>Select MTN CG LITE Data Plan</option>

                        <?php while ($mcgl = $mtncgl->fetch_assoc()) { ?>
                          <option value="<?php echo $mcgl['serial']; ?>"> <?php echo $mcgl['plan'] . ' - ' . '&#x20A6;' . $mcgl['price_user']; ?> </option>
                        <?php } ?>

                      </select>

                      <select class="form-control rounded-right" name="plan" id="sme" style="border-radius: 0px; height: 50px; display: none">
                        <?php $mtnsme = $conn->query("SELECT * FROM data_package WHERE network='01' AND datatype='sme' ORDER BY `price_user` ASC"); ?>
                        <option selected disabled hidden>Select MTN SME Data Plan</option>

                        <?php while ($msm = $mtnsme->fetch_assoc()) { ?>
                          <option value="<?php echo $msm['serial']; ?>"> <?php echo $msm['plan'] . ' - ' . '&#x20A6;' . $msm['price_user']; ?> </option>

                        <?php } ?>

                      </select>

                      <select class="form-control rounded-right" name="plan" id="cg" style="border-radius: 0px; height: 50px; display: none">
                        <?php $mtncg = $conn->query("SELECT * FROM data_package WHERE network='01' AND datatype='gifting' ORDER BY `price_user` ASC"); ?>
                        <option selected disabled hidden>Select MTN Gifting Plan</option>

                        <?php while ($mcg = $mtncg->fetch_assoc()) { ?>
                          <option value="<?php echo $mcg['serial']; ?>"> <?php echo $mcg['plan'] . ' - ' . '&#x20A6;' . $mcg['price_user']; ?> </option>

                        <?php } ?>

                      </select>

                      <select class="form-control rounded-right" name="plan" id="direct" style="border-radius: 0px; height: 50px; display: none">
                        <?php $mtndirect = $conn->query("SELECT * FROM data_package WHERE network='01' AND datatype='directdata' ORDER BY `price_user` ASC"); ?>
                        <option selected disabled hidden>Select MTN Direct Data Plan</option>

                        <?php while ($mdr = $mtndirect->fetch_assoc()) { ?>
                          <option value="<?php echo $mdr['serial']; ?>"> <?php echo $mdr['plan'] . ' - ' . '&#x20A6;' . $mdr['price_user']; ?> </option>

                        <?php } ?>

                      </select>
                    </div>


                    <div class="form-group">
                      <label for="inputText3" class="col-form-label">Receiver's Phone Number</label>
                      <input id="mobile" type="tel" class="form-control rounded-right" name="phone" style="border-radius: 0px; height: 50px;">
                    </div>

                    <div class="col-sm-6 pl-0">
                      <p class="text-center">
                        <button type="submit" id="mtnorder" class="btn btn-rounded btn-warning"><i class="fa fa-arrow-right"></i> Proceed </button>

                      </p>
                    </div>

                  </form>

                  <script>
                    $('#mtncglite').submit(function(e) {
                      e.preventDefault();
                      var formData = $(this).serialize();
                      $.ajax({
                        url: "formrequest/ini-data.php",
                        type: "GET",
                        data: formData,
                        dataType: "json",
                        contentType: 'application/json; charset=utf-8',
                        async: false,
                        beforeSend: function() {
                          $('#mtnorder').html('<i class="fa fa-spinner"></i> Please wait...');
                        },
                        success: function(data) {
                          // Process with the response data
                          console.log(data);
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

                        },
                        error: function(xhr, status, error) {
                          console.error("Server response: ", xhr.responseText);
                          console.error("Ajax status: ", status);
                          console.error("Ajax error: ", error);

                        }
                      });
                    });
                  </script>

                </div>
                <!-- End GOTV hidden -->


                <!-- Start DSTV hidden -->
                <div class="float-center" id="ifDstv" style="display:none;">
                  <div class="form-group">
                    <form action="javascript:void(0)" id="airtelcglite" method="post">
                      <input type="hidden" name="network" id="networkAirtel">
                      <input type="hidden" name="token" id="token" value="<?php echo base64_encode($email); ?>">

                      <div class="form-group">
                        <label for="inputText3" class="col-form-label"></label>
                        <select id="data_type_airtel" class="form-control rounded-right" name="dataplan" style="border-radius: 0px; height: 50px;" required>
                          <option selected disabled hidden>Select DataType</option>
                          <option id="SME_AIRTEL" style="display: none;">SME</option>
                          <option id="GIFTING_AIRTEL" style="display: none;">GIFTING</option>
                          <option id="DIRECT_AIRTEL" style="display: none;">DIRECT</option>

                        </select>
                      </div>

                      <select class="form-control rounded-right" name="plan" id="sme_airtel" style="border-radius: 0px; height: 50px; display: none">
                        <?php $airtelsme = $conn->query("SELECT * FROM data_package WHERE network='04' AND datatype='sme' ORDER BY `price_user` ASC"); ?>
                        <option selected disabled hidden>Select Airtel Data Plan</option>

                        <?php while ($asm = $airtelsme->fetch_assoc()) { ?>
                          <option value="<?php echo $asm['serial']; ?>"> <?php echo $asm['plan'] . ' - ' . '&#x20A6;' . $asm['price_user']; ?> </option>

                        <?php } ?>

                      </select>

                      <select class="form-control rounded-right" name="plan" id="cg_airtel" style="border-radius: 0px; height: 50px; display: none">
                        <?php $airtelcg = $conn->query("SELECT * FROM data_package WHERE network='04' AND datatype='gifting' ORDER BY `price_user` ASC"); ?>
                        <option selected disabled hidden>Select Airtel Gifting Plan</option>

                        <?php while ($acg = $airtelcg->fetch_assoc()) { ?>
                          <option value="<?php echo $acg['serial']; ?>"> <?php echo $acg['plan'] . ' - ' . '&#x20A6;' . $acg['price_user']; ?> </option>

                        <?php } ?>

                      </select>

                      <select class="form-control rounded-right" name="plan" id="direct_airtel" style="border-radius: 0px; height: 50px; display: none">
                        <?php $airteldirect = $conn->query("SELECT * FROM data_package WHERE network='04' AND datatype='directdata' ORDER BY `price_user` ASC"); ?>
                        <option selected disabled hidden>Select Airtel Direct Data Plan</option>

                        <?php while ($adr = $airteldirect->fetch_assoc()) { ?>
                          <option value="<?php echo $adr['serial']; ?>"> <?php echo $adr['plan'] . ' - ' . '&#x20A6;' . $adr['price_user']; ?> </option>

                        <?php } ?>

                      </select>


                  </div>




                  <div class="form-group">
                    <label for="inputText3" class="col-form-label">Receiver's Phone Number</label>
                    <input id="phone" type="tel" class="form-control rounded-right" name="phone" style="border-radius: 0px; height: 50px;">
                  </div>

                  <div class="col-sm-6 pl-0">
                    <p class="text-center">
                      <button type="submit" id="airtelorder" class="btn btn-rounded btn-danger"><i class="fa fa-arrow-right"></i> Proceed </button>

                    </p>
                  </div>

                  </form>

                  <script>
                    $('#airtelcglite').submit(function(e) {
                      e.preventDefault();
                      var formData = $(this).serialize();
                      $.ajax({
                        url: "formrequest/ini-data.php",
                        type: "GET",
                        data: formData,
                        dataType: "json",
                        contentType: 'application/json; charset=utf-8',
                        async: false,
                        beforeSend: function() {
                          $('#airtelorder').html('<i class="fa fa-spinner"></i> Please wait...');
                        },
                        success: function(data) {
                          // Process with the response data
                          console.log(data);
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

                        },
                        error: function(xhr, status, error) {
                          console.error("Server response: ", xhr.responseText);
                          console.error("Ajax status: ", status);
                          console.error("Ajax error: ", error);

                        }
                      });
                    });
                  </script>

                </div>
                <!-- End DSTV hidden -->

                <!-- Start STARTTIMES hidden -->
                <div class="float-center" id="ifStar" style="display:none;">
                  <div class="form-group">

                    <form action="javascript:void(0)" id="glocglite" method="post">
                      <input type="hidden" name="network" id="networkGlo">

                      <input type="hidden" name="token" id="token" value="<?php echo base64_encode($email); ?>">
                      <div class="form-group">
                        <label for="inputText3" class="col-form-label"></label>
                        <select id="data_type_glo" class="form-control rounded-right" name="dataplan" style="border-radius: 0px; height: 50px;" required>
                          <option selected disabled hidden>Select DataType</option>
                          <option id="SME_GLO" style="display: none;">SME</option>
                          <option id="GIFTING_GLO" style="display: none;">GIFTING</option>
                          <option id="DIRECT_GLO" style="display: none;">DIRECT</option>

                        </select>
                      </div>

                      <select class="form-control rounded-right" name="plan" id="sme_glo" style="border-radius: 0px; height: 50px; display: none">
                        <?php $glosme = $conn->query("SELECT * FROM data_package WHERE network='02' AND datatype='sme' ORDER BY `price_user` ASC"); ?>
                        <option selected disabled hidden>Select Glo SME Data Plan</option>

                        <?php while ($gsm = $glosme->fetch_assoc()) { ?>
                          <option value="<?php echo $gsm['serial']; ?>"> <?php echo $gsm['plan'] . ' - ' . '&#x20A6;' . $gsm['price_user']; ?> </option>

                        <?php } ?>

                      </select>

                      <select class="form-control rounded-right" name="plan" id="cg_glo" style="border-radius: 0px; height: 50px; display: none">
                        <?php $glocg = $conn->query("SELECT * FROM data_package WHERE network='02' AND datatype='gifting' ORDER BY `price_user` ASC"); ?>
                        <option selected disabled hidden>Select Glo Gifting Plan</option>

                        <?php while ($gcg = $glocg->fetch_assoc()) { ?>
                          <option value="<?php echo $gcg['serial']; ?>"> <?php echo $gcg['plan'] . ' - ' . '&#x20A6;' . $gcg['price_user']; ?> </option>

                        <?php } ?>

                      </select>

                      <select class="form-control rounded-right" name="plan" id="direct_glo" style="border-radius: 0px; height: 50px; display: none">
                        <?php $glodirect = $conn->query("SELECT * FROM data_package WHERE network='02' AND datatype='directdata' ORDER BY `price_user` ASC"); ?>
                        <option selected disabled hidden>Select Glo Direct Data Plan</option>

                        <?php while ($gdr = $glodirect->fetch_assoc()) { ?>
                          <option value="<?php echo $gdr['serial']; ?>"> <?php echo $gdr['plan'] . ' - ' . '&#x20A6;' . $gdr['price_user']; ?> </option>

                        <?php } ?>

                      </select>

                  </div>




                  <div class="form-group">
                    <label for="inputText3" class="col-form-label">Receiver's Phone Number</label>
                    <input id="mobil" type="tel" class="form-control rounded-right" name="phone" style="border-radius: 0px; height: 50px;">
                  </div>
                  <div class="col-sm-6 pl-0">
                    <p class="text-center">
                      <button type="submit" id="gloorder" class="btn btn-rounded btn-success"><i class="fa fa-arrow-right"></i> Proceed </button>

                    </p>
                  </div>

                  </form>

                  <script>
                    $('#glocglite').submit(function(e) {
                      e.preventDefault();
                      var formData = $(this).serialize();
                      $.ajax({
                        url: "formrequest/ini-data.php",
                        type: "GET",
                        data: formData,
                        dataType: "json",
                        contentType: 'application/json; charset=utf-8',
                        async: false,
                        beforeSend: function() {
                          $('#gloorder').html('<i class="fa fa-spinner"></i> Please wait...');
                        },
                        success: function(data) {
                          // Process with the response data
                          console.log(data);
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

                        },
                        error: function(xhr, status, error) {
                          console.error("Server response: ", xhr.responseText);
                          console.error("Ajax status: ", status);
                          console.error("Ajax error: ", error);

                        }
                      });
                    });
                  </script>

                </div>
                <!-- End STARTIMES hidden -->



                <!-- Start 9Mobile hidden -->
                <div class="float-center" id="if9mob" style="display:none;">
                  <div class="form-group">
                    <form action="javascript:void(0)" id="9mobilecglite" method="post">
                      <input type="hidden" name="network" id="network9mobile">
                      <input type="hidden" name="token" id="token" value="<?php echo base64_encode($email); ?>">
                      <div class="form-group">
                        <label for="inputText3" class="col-form-label"></label>
                        <select id="data_type_eti" class="form-control rounded-right" name="dataplan" style="border-radius: 0px; height: 50px;" required>
                          <option selected disabled hidden>Select DataType</option>
                          <option id="SME_ETI" style="display: none;">SME</option>
                          <option id="GIFTING_ETI" style="display: none;">GIFTING</option>
                          <option id="DIRECT_ETI" style="display: none;">DIRECT</option>

                        </select>
                      </div>

                      <select class="form-control rounded-right" name="plan" id="sme_eti" style="border-radius: 0px; height: 50px; display: none">
                        <?php $etisme = $conn->query("SELECT * FROM data_package WHERE network='03' AND datatype='sme' ORDER BY `price_user` ASC"); ?>
                        <option selected disabled hidden>Select 9Mobile SME Data Plan</option>

                        <?php while ($esm = $etisme->fetch_assoc()) { ?>
                          <option value="<?php echo $esm['serial']; ?>"> <?php echo $esm['plan'] . ' - ' . '&#x20A6;' . $esm['price_user']; ?> </option>

                        <?php } ?>

                      </select>

                      <select class="form-control rounded-right" name="plan" id="cg_eti" style="border-radius: 0px; height: 50px; display: none">
                        <?php $eticg = $conn->query("SELECT * FROM data_package WHERE network='03' AND datatype='gifting' ORDER BY `price_user` ASC"); ?>
                        <option selected disabled hidden>Select 9Mobile Gifting Plan</option>

                        <?php while ($ecg = $eticg->fetch_assoc()) { ?>
                          <option value="<?php echo $ecg['serial']; ?>"> <?php echo $ecg['plan'] . ' - ' . '&#x20A6;' . $ecg['price_user']; ?> </option>

                        <?php } ?>

                      </select>

                      <select class="form-control rounded-right" name="plan" id="direct_eti" style="border-radius: 0px; height: 50px; display: none">
                        <?php $etidirect = $conn->query("SELECT * FROM data_package WHERE network='03' AND datatype='directdata' ORDER BY `price_user` ASC"); ?>
                        <option selected disabled hidden>Select 9Mobile Direct Data Plan</option>

                        <?php while ($edr = $etidirect->fetch_assoc()) { ?>
                          <option value="<?php echo $edr['serial']; ?>"> <?php echo $edr['plan'] . ' - ' . '&#x20A6;' . $edr['price_user']; ?> </option>

                        <?php } ?>

                      </select>


                  </div>

                  <div class="form-group">
                    <label for="inputText3" class="col-form-label">Receiver's Phone Number</label>
                    <input id="9mobil" type="tel" class="form-control rounded-right" name="phone" style="border-radius: 0px; height: 50px;">
                  </div>
                  <div class="col-sm-6 pl-0">
                    <p class="text-center">
                      <button type="submit" id="9mobileorder" class="btn btn-rounded btn-success  active"><i class="fa fa-arrow-right"></i> Proceed </button>
                    </p>
                  </div>
                  </form>

                  <script>
                    $('#9mobilecglite').submit(function(e) {
                      e.preventDefault();
                      var formData = $(this).serialize();
                      $.ajax({
                        url: "formrequest/ini-data.php",
                        type: "GET",
                        data: formData,
                        dataType: "json",
                        contentType: 'application/json; charset=utf-8',
                        async: false,
                        beforeSend: function() {
                          $('#9mobileorder').html('<i class="fa fa-spinner"></i> Please wait...');
                        },
                        success: function(data) {
                          // Process with the response data
                          console.log(data);
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

                        },
                        error: function(xhr, status, error) {
                          console.error("Server response: ", xhr.responseText);
                          console.error("Ajax status: ", status);
                          console.error("Ajax error: ", error);

                        }
                      });
                    });
                  </script>
                </div>
                <!-- End 9Mobile hidden -->










              </div>
            </div>
          </div>
          <!-- ============================================================== -->
          <!-- end recent orders  -->

          <script src="js/buydata-pop.js"></script>
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