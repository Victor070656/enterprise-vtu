<?php
session_start();
require('db.php');
include('inc/func.php');
include('inc/gravatar.php');
include('inc/logo.php');
include('inc/header.php');
?>
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
              <li class="fa fa-mobile-alt"></li> ePINs Generator
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


              <div class="card-body">



                <label for="inputText3" class="col-form-label">Please Select Network</label><br>
                <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="carier" class="custom-control-input" value="mtn" onclick="javascript:showTv();" id="mtn"><span class="custom-control-label"><img src="assets/images/mtn.jpg" width="35" height="30" class="rounded-corners"></span>
                </label>


                <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="carier" class="custom-control-input" value="airtel" onclick="javascript:showTv();" id="airtel"><span class="custom-control-label"><img src="assets/images/airtel.jpg" width="35" height="30" class="rounded-corners"></span>
                </label>

                <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="carier" class="custom-control-input" value="glo" onclick="javascript:showTv();" id="glo"><span class="custom-control-label"><img src="assets/images/glo.jpg" width="35" height="30" class="rounded-corners"></span>
                </label>

                <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="carier" class="custom-control-input" value="etisalat" onclick="javascript:showTv();" id="etisalat"><span class="custom-control-label"><img src="assets/images/9mobile.jpg" width="35" height="30" class="rounded-corners"></span>
                </label>



                <p></p>
                <div class="float-center">
                  <img style="display:none;" id="bigpic" src="bigpic" width="120" height="90" class="rounded-corners" />

                </div>

                <!-- Start MTN PIN hidden -->
                <div class="float-center" id="ifMtn" style="display:none;">
                  <p></p>
                  <div class="form-group">




                    <form action="javascript:void(0)" id="mtnpin" method="post">
                      <?php $mtncgl = $conn->query("SELECT * FROM pins_package WHERE network='mtn'  ORDER BY `price_user` ASC"); ?>
                      <input type="hidden" id="unit">
                      <input type="hidden" name="network" id="network">
                      <input type="hidden" name="token" id="token" value="<?php echo base64_encode($email); ?>">

                      <select class="form-control rounded-right" name="plan" id="plan" style="border-radius: 0px; height: 50px;">
                        <option value="" disabled selected hidden>Select Denomination</option>

                        <?php while ($mcgl = $mtncgl->fetch_assoc()) { ?>
                          <option value="<?php echo $mcgl['serial']; ?>"> <?php echo $mcgl['plan'] . ' - ' . '&#x20A6;' . $mcgl['price_user']; ?> </option>
                        <?php } ?>

                      </select>


                  </div>

                  <div class="form-group">
                    <label for="inputText3" class="col-form-label">Quantity</label>
                    <input id="pino" type="number" class="form-control" name="qty" min="0" oninput="this.value = Math.abs(this.value)" style="border-radius: 0px; height: 50px;">
                  </div>

                  <span id="amountpay"></span>
                  <div class="col-sm-6 pl-0">
                    <p class="text-center">
                      <button type="submit" id="mtnorder" class="btn btn-rounded btn-warning"><i class="fa fa-arrow-right"></i> Proceed </button>

                    </p>
                  </div>

                  </form>

                  <script>
                    $(document).ready(function() {
                      $('#plan').change(function() {
                        var selected = $(this).val();
                        var tok = $('#token').val();
                        $('#pino').val('');
                        $.get("formrequest/ch.php", {
                            id: selected,
                            token: tok
                          })
                          .done(function(resp) {
                            res = JSON.parse(resp);
                            var rate = res['msg'];
                            $('#unit').val(rate);
                          });
                      });

                      $("#pino").keyup(function() {
                        //var selectednetwork = $(this).children("option:selected").val();
                        var selectednetwork = $("#network").val();
                        var amounttopay = $('#unit').val();
                        var quantity = $("#pino").val();
                        amount_to_pay = "Amount to pay: " + "₦" + amounttopay * quantity

                        console.log(quantity)
                        console.log(amount_to_pay)
                        console.log(selectednetwork)

                        if (quantity > 20) {
                          $("#amountpay").html("<font color='blue'><i class='fa fa-exclamation-circle'></i> Maximum purchase per transaction is 20 </font>");
                          $('#mtnorder').prop('disabled', true);
                        } else if (quantity < 1) {
                          $("#amountpay").html("<font color='blue'><i class='fa fa-exclamation-circle'></i> Minimum purchase is 1 </font>");
                          $('#mtnorder').prop('disabled', true);
                        } else if (amounttopay === "") {

                          $("#amountpay").html('<font color="red"> <i class="fa fa-exclamation-circle"></i>  Please select denomination first </font>');
                          $(this).val('');

                        } else {
                          $('#mtnorder').prop('disabled', false);
                          $("#amountpay").text(amount_to_pay);
                        }

                      });

                    });


                    $('#mtnpin').submit(function(e) {
                      e.preventDefault();
                      var formData = $(this).serialize();
                      var url = "formrequest/ini_pin.php";
                      $.ajax({
                        url: url,
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

                            if (data.activation == 0) {

                              var redir = data.redirect;
                              const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                iconColor: 'white',
                                customClass: {
                                  popup: 'colored-toast'
                                },
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

                              setTimeout(function() {
                                document.location.replace(redir);
                              }, 3000);

                            } else {

                              const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                iconColor: 'white',
                                customClass: {
                                  popup: 'colored-toast'
                                },
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

                        }
                      });
                    });
                  </script>

                </div>
                <!-- End MTN PIN hidden -->


                <!-- Start Airtel PIN hidden -->
                <div class="float-center" id="ifAirtel" style="display:none;">

                  <p></p>
                  <div class="form-group">

                    <form action="javascript:void(0)" id="airtelpin" method="post">
                      <?php $airtel = $conn->query("SELECT * FROM pins_package WHERE network='airtel'  ORDER BY `price_user` ASC"); ?>

                      <input type="hidden" name="network" id="networkairtel">
                      <input type="hidden" name="token" value="<?php echo base64_encode($email); ?>">

                      <select class="form-control" id="Airtelplan" name="plan" style="border-radius: 0px; height: 50px;">
                        <option value="" disabled selected hidden>Select Denomination</option>

                        <?php while ($a = $airtel->fetch_assoc()) { ?>
                          <option value="<?php echo $a['serial']; ?>"> <?php echo $a['plan'] . ' - ' . '&#x20A6;' . $a['price_user']; ?> </option>
                        <?php } ?>

                      </select>


                  </div>


                  <div class="form-group">
                    <label for="inputText3" class="col-form-label">Quantity</label>
                    <input id="airtelpino" type="number" class="form-control" name="qty" min="0" oninput="this.value = Math.abs(this.value)" style="border-radius: 0px; height: 50px;">
                  </div>

                  <span id="amountpayaitel"></span>
                  <div class="col-sm-6 pl-0">
                    <p class="text-center">
                      <button type="submit" id="airtelorder" class="btn btn-rounded btn-danger"><i class="fa fa-arrow-right"></i> Proceed </button>

                    </p>
                  </div>

                  </form>

                  <script>
                    $(document).ready(function() {
                      $('#Airtelplan').change(function() {
                        var selected = $(this).val();
                        var tok = $('#token').val();
                        $('#airtelpino').val('');
                        $.get("formrequest/ch.php", {
                            id: selected,
                            token: tok
                          })
                          .done(function(resp) {
                            res = JSON.parse(resp);
                            var rate = res['msg'];
                            $('#unit').val(rate);
                          });
                      });

                      $("#airtelpino").keyup(function() {
                        //var selectednetwork = $(this).children("option:selected").val();
                        var selectednetwork = $("#networkairtel").val();
                        var amounttopay = $('#unit').val();
                        var quantity = $("#airtelpino").val();
                        amount_to_pay = "Amount to pay: " + "₦" + amounttopay * quantity

                        console.log(quantity)
                        console.log(amount_to_pay)
                        console.log(selectednetwork)

                        if (quantity > 20) {
                          $("#amountpayaitel").html("<font color='blue'><i class='fa fa-exclamation-circle'></i> Maximum purchase per transaction is 20 </font>");
                          $('#airtelorder').prop('disabled', true);
                        } else if (quantity < 1) {
                          $("#amountpayaitel").html("<font color='blue'><i class='fa fa-exclamation-circle'></i> Minimum purchase is 1 </font>");
                          $('#airtelorder').prop('disabled', true);
                        } else if (amounttopay === "") {

                          $("#amountpayaitel").html('<font color="red"> <i class="fa fa-exclamation-circle"></i>  Please select denomination first </font>');
                          $(this).val('');

                        } else {
                          $('#airtelorder').prop('disabled', false);
                          $("#amountpayaitel").text(amount_to_pay);
                        }

                      });

                    });

                    $('#airtelpin').submit(function(e) {
                      e.preventDefault();
                      var formData = $(this).serialize();
                      var url = "formrequest/ini_pin.php";
                      $.ajax({
                        url: url,
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

                            if (data.activation == 0) {

                              var redir = data.redirect;
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

                              setTimeout(function() {
                                document.location.replace(redir);
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

                        }
                      });
                    });
                  </script>

                </div>
                <!-- End Airtel PIN hidden -->

                <!-- Start Glo PIN hidden -->
                <div class="float-center" id="ifGlo" style="display:none;">

                  <p></p>
                  <div class="form-group">

                    <form action="javascript:void(0)" id="glopin" method="post">
                      <?php $glo = $conn->query("SELECT * FROM pins_package WHERE network='glo'  ORDER BY `price_user` ASC"); ?>

                      <input type="hidden" name="network" id="networkglo">
                      <input type="hidden" name="token" value="<?php echo base64_encode($email); ?>">

                      <select class="form-control" id="gloplan" name="plan" style="border-radius: 0px; height: 50px;">
                        <option value="" disabled selected hidden>Select Denomination</option>

                        <?php while ($g = $glo->fetch_assoc()) { ?>
                          <option value="<?php echo $g['serial']; ?>"> <?php echo $g['plan'] . ' - ' . '&#x20A6;' . $g['price_user']; ?> </option>
                        <?php } ?>


                      </select>

                  </div>


                  <div class="form-group">
                    <label for="inputText3" class="col-form-label">Quantity</label>
                    <input id="glopino" type="number" class="form-control" name="qty" min="0" oninput="this.value = Math.abs(this.value)" style="border-radius: 0px; height: 50px;">
                  </div>

                  <span id="amountpayglo"></span>
                  <div class="col-sm-6 pl-0">
                    <p class="text-center">
                      <button type="submit" id="gloorder" class="btn btn-rounded btn-success active"><i class="fa fa-arrow-right"></i> Proceed </button>

                    </p>
                  </div>

                  </form>

                  <script>
                    $(document).ready(function() {
                      $('#gloplan').change(function() {
                        var selected = $(this).val();
                        var tok = $('#token').val();
                        $('#glopino').val('');
                        $.get("formrequest/ch.php", {
                            id: selected,
                            token: tok
                          })
                          .done(function(resp) {
                            res = JSON.parse(resp);
                            var rate = res['msg'];
                            $('#unit').val(rate);
                          });
                      });

                      $("#glopino").keyup(function() {
                        //var selectednetwork = $(this).children("option:selected").val();
                        var selectednetwork = $("#networkglo").val();
                        var amounttopay = $('#unit').val();
                        var quantity = $("#glopino").val();
                        amount_to_pay = "Amount to pay: " + "₦" + amounttopay * quantity

                        console.log(quantity)
                        console.log(amount_to_pay)
                        console.log(selectednetwork)

                        if (quantity > 20) {
                          $("#amountpayglo").html("<font color='blue'><i class='fa fa-exclamation-circle'></i> Maximum purchase per transaction is 20 </font>");
                          $('#gloorder').prop('disabled', true);
                        } else if (quantity < 1) {
                          $("#amountpayglo").html("<font color='blue'><i class='fa fa-exclamation-circle'></i> Minimum purchase is 1 </font>");
                          $('#gloorder').prop('disabled', true);
                        } else if (amounttopay === "") {

                          $("#amountpayglo").html('<font color="red"> <i class="fa fa-exclamation-circle"></i>  Please select denomination first </font>');
                          $(this).val('');

                        } else {
                          $('#gloorder').prop('disabled', false);
                          $("#amountpayglo").text(amount_to_pay);
                        }

                      });

                    });

                    $('#glopin').submit(function(e) {
                      e.preventDefault();
                      var formData = $(this).serialize();
                      var url = "formrequest/ini_pin.php";
                      $.ajax({
                        url: url,
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

                            if (data.activation == 0) {

                              var redir = data.redirect;
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

                              setTimeout(function() {
                                document.location.replace(redir);
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

                        }
                      });
                    });
                  </script>

                </div>
                <!-- End Glo PIN hidden -->


                <!-- Start Etisalat PIN hidden -->
                <div class="float-center" id="ifEtisalat" style="display:none;">

                  <p></p>
                  <div class="form-group">

                    <form action="javascript:void(0)" id="etisalatpin" method="post">
                      <?php $eti = $conn->query("SELECT * FROM pins_package WHERE network='etisalat'  ORDER BY `price_user` ASC"); ?>

                      <input type="hidden" name="network" id="networketisalat">
                      <input type="hidden" name="token" value="<?php echo base64_encode($email); ?>">

                      <select class="form-control" id="Etisalatplan" name="plan" style="border-radius: 0px; height: 50px;">
                        <option value="" disabled selected hidden>Select Denomination</option>

                        <?php while ($et = $eti->fetch_assoc()) { ?>
                          <option value="<?php echo $et['serial']; ?>"> <?php echo $et['plan'] . ' - ' . '&#x20A6;' . $et['price_user']; ?> </option>
                        <?php } ?>

                      </select>

                  </div>


                  <div class="form-group">
                    <label for="inputText3" class="col-form-label">Quantity</label>
                    <input id="etipino" type="number" class="form-control" name="qty" min="0" oninput="this.value = Math.abs(this.value)" style="border-radius: 0px; height: 50px;">
                  </div>

                  <span id="amountpayeti"></span>
                  <div class="col-sm-6 pl-0">
                    <p class="text-center">
                      <button type="submit" id="etiorder" class="btn btn-rounded btn-success"><i class="fa fa-arrow-right"></i> Proceed </button>

                    </p>
                  </div>

                  </form>

                  <script>
                    $(document).ready(function() {
                      $('#Etisalatplan').change(function() {
                        var selected = $(this).val();
                        var tok = $('#token').val();
                        $('#etipino').val('');
                        $.get("formrequest/ch.php", {
                            id: selected,
                            token: tok
                          })
                          .done(function(resp) {
                            res = JSON.parse(resp);
                            var rate = res['msg'];
                            $('#unit').val(rate);
                          });
                      });

                      $("#etipino").keyup(function() {
                        //var selectednetwork = $(this).children("option:selected").val();
                        var selectednetwork = $("#networketisalat").val();
                        var amounttopay = $('#unit').val();
                        var quantity = $("#etipino").val();
                        amount_to_pay = "Amount to pay: " + "₦" + amounttopay * quantity

                        console.log(quantity)
                        console.log(amount_to_pay)
                        console.log(selectednetwork)

                        if (quantity > 20) {
                          $("#amountpayeti").html("<font color='blue'><i class='fa fa-exclamation-circle'></i> Maximum purchase per transaction is 20 </font>");
                          $('#etiorder').prop('disabled', true);
                        } else if (quantity < 1) {
                          $("#amountpayeti").html("<font color='blue'><i class='fa fa-exclamation-circle'></i> Minimum purchase is 1 </font>");
                          $('#etiorder').prop('disabled', true);
                        } else if (amounttopay === "") {

                          $("#amountpayeti").html('<font color="red"> <i class="fa fa-exclamation-circle"></i>  Please select denomination first </font>');
                          $(this).val('');

                        } else {
                          $('#etiorder').prop('disabled', false);
                          $("#amountpayeti").text(amount_to_pay);
                        }

                      });

                    });

                    $('#etisalatpin').submit(function(e) {
                      e.preventDefault();
                      var formData = $(this).serialize();
                      var url = "formrequest/ini_pin.php";
                      $.ajax({
                        url: url,
                        type: "GET",
                        data: formData,
                        dataType: "json",
                        contentType: 'application/json; charset=utf-8',
                        async: false,
                        beforeSend: function() {
                          $('#etiorder').html('<i class="fa fa-spinner"></i> Please wait...');
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

                            if (data.activation == 0) {

                              var redir = data.redirect;
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

                              setTimeout(function() {
                                document.location.replace(redir);
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

                        }
                      });
                    });
                  </script>

                </div>

                <!-- End Etisalat PIN hidden -->






              </div>
            </div>
          </div>
          <!-- ============================================================== -->
          <!-- end recent orders  -->



          <script>
            function Comma(Num) {
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



            function showTv() {
              if (document.getElementById('mtn').checked) {
                document.getElementById('ifMtn').style.display = 'block';
                document.getElementById('network').value = document.getElementById("mtn").value;
                var sourceOfPicture = "assets/images/mtn.jpg";
                var img = document.getElementById('bigpic')
                img.src = sourceOfPicture.replace('90x90', '225x225');
                img.style.display = "block";

              } else document.getElementById('ifMtn').style.display = 'none';


              if (document.getElementById('airtel').checked) {
                document.getElementById('ifAirtel').style.display = 'block';

                var sourceOfPicture = "assets/images/airtel.jpg";
                var img = document.getElementById('bigpic')
                img.src = sourceOfPicture.replace('90x90', '225x225');
                img.style.display = "block";

                document.getElementById('networkairtel').value = document.getElementById("airtel").value;

              } else document.getElementById('ifAirtel').style.display = 'none';

              if (document.getElementById('glo').checked) {
                document.getElementById('ifGlo').style.display = 'block';

                var sourceOfPicture = "assets/images/glo.jpg";
                var img = document.getElementById('bigpic')
                img.src = sourceOfPicture.replace('90x90', '225x225');
                img.style.display = "block";

                document.getElementById('networkglo').value = document.getElementById("glo").value;

              } else document.getElementById('ifGlo').style.display = 'none';


              if (document.getElementById('etisalat').checked) {
                document.getElementById('ifEtisalat').style.display = 'block';

                var sourceOfPicture = "assets/images/9mobile.jpg";
                var img = document.getElementById('bigpic')
                img.src = sourceOfPicture.replace('90x90', '225x225');
                img.style.display = "block";

                document.getElementById('networketisalat').value = document.getElementById("etisalat").value;

              } else document.getElementById('ifEtisalat').style.display = 'none';

            }
          </script>
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- customer acquistion  -->
          <!-- ============================================================== -->
          <?php include('inc/sidebar.php'); ?>
          <!-- ============================================================== -->



          <!-- end customer acquistion  -->

          <!-- ============================================================== -->



          <!-- end customer acquistion  -->
          <?php include('inc/recent-transaction-widget.php'); ?>

          <!-- ============================================================== -->
        </div>
        <div class="row">

        </div>

        <div class="row">
          <!-- ============================================================== -->
          <!-- sales  -->

          <!-- end new customer  -->

        </div>
        <div class="row">

        </div>
        <div class="row">

        </div>
      </div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- footer -->
  <!-- ============================================================== -->
  <?php include('inc/footer.php'); ?>