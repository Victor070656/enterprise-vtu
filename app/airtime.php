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
                            <li class="fa fa-phone"></li> Buy Airtime
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

                                <form action="javascript:void(0)" id="buyairtime" method="post">

                                    <label for="inputText3" class="col-form-label">Select Network to Recharge</label><br>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="carier" id="mtn" class="custom-control-input" value="mtn" onclick="showMTN()"><span class="custom-control-label"><img src="assets/images/mtn.jpg" width="35" height="30" class="rounded-corners"></span>
                                    </label>


                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="carier" id="airtel" class="custom-control-input" value="airtel" onclick="showAirtel()"><span class="custom-control-label"><img src="assets/images/airtel.jpg" width="35" height="30" class="rounded-corners"></span>
                                    </label>

                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="carier" id="glo" class="custom-control-input" value="glo" onclick="showGlo()"><span class="custom-control-label"><img src="assets/images/glo.jpg" width="35" height="30" class="rounded-corners"></span>
                                    </label>

                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="carier" id="etisalat" class="custom-control-input" value="etisalat" onclick="show9mobile()"><span class="custom-control-label"><img src="assets/images/9mobile.jpg" width="35" height="30" class="rounded-corners"></span>
                                    </label>


                                    <!-- <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="carier" id="ntel" class="custom-control-input" value="ntel" onclick="showntel()"><span class="custom-control-label"><img src="assets/images/ntel.jpg" class="rounded-corners"></span>
                                    </label> -->
                                    <label id="resultcarier"></label>

                                    <p></p>
                                    <div class="float-center">
                                        <img style="display:none;" id="bigpic" src="bigpic" width="120" height="90" class="rounded-corners" />

                                    </div>


                                    <label for="inputText3" class="col-form-label">Enter Amount</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend"><span class="input-group-text">&#x20A6;</span></div>
                                        <input type="number" id="amt" class="form-control" name="amt" min="0" oninput="this.value = Math.abs(this.value)" required style="border-radius: 0px; height: 50px;">
                                        <div class="input-group-append"><span class="input-group-text">.00</span></div>

                                        <label id="resultamt"></label>
                                    </div>

                                    <input type="hidden" name="network" id="network"> <input type="hidden" name="token" id="token" value="<?php echo base64_encode($email); ?>">
                                    <div class="form-group">
                                        <label for="inputText3" class="col-form-label">Phone Number</label>
                                        <input type="tel" id="phone" pattern="[0-9]{11}" title="Please enter valid phone number" class="form-control rounded-right" name="phone" required style="border-radius: 0px; height: 50px;">
                                        <label id="resultphone"></label>
                                    </div>

                                    <div class="col-sm-6 pl-0">

                                        <p class="text-center">
                                            <button type="submit" name="topup" id="btnairtime" class="btn btn-rounded btn-primary">Proceed</button>

                                        </p>

                                        <p align="center">


                                        </p>

                                    </div>
                                </form>

                                <script>
                                    $('#buyairtime').submit(function(e) {
                                        e.preventDefault();
                                        var formData = $(this).serialize();
                                        var url = "formrequest/ini-airtime.php";
                                        $.ajax({
                                            url: url,
                                            type: "GET",
                                            data: formData,
                                            dataType: "json",
                                            contentType: 'application/json; charset=utf-8',
                                            async: false,
                                            beforeSend: function() {
                                                $('#btnairtime').html('<i class="fa fa-spinner"></i> Please wait...');
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

                                                    $('#btnairtime').html('<i class="fa fa-arrow-right"></i> Proceed');

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
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end recent orders  -->
                    <script>
                        function show9mobile() {
                            var sourceOfPicture = "assets/images/9mobile.jpg";
                            var img = document.getElementById('bigpic')
                            img.src = sourceOfPicture.replace('90x90', '225x225');
                            document.getElementById('network').value = document.getElementById("etisalat").value;
                            img.style.display = "block";
                        }

                        function showMTN() {
                            var sourceOfPicture = "assets/images/mtn.jpg";
                            var img = document.getElementById('bigpic')
                            img.src = sourceOfPicture.replace('90x90', '225x225');
                            document.getElementById('network').value = document.getElementById("mtn").value;
                            img.style.display = "block";
                        }

                        function showAirtel() {
                            var sourceOfPicture = "assets/images/airtel.jpg";
                            var img = document.getElementById('bigpic')
                            img.src = sourceOfPicture.replace('90x90', '225x225');
                            document.getElementById('network').value = document.getElementById("airtel").value;
                            img.style.display = "block";
                        }

                        function showGlo() {
                            var sourceOfPicture = "assets/images/glo.jpg";
                            var img = document.getElementById('bigpic')
                            img.src = sourceOfPicture.replace('90x90', '225x225');
                            document.getElementById('network').value = document.getElementById("glo").value;
                            img.style.display = "block";
                        }

                        function showntel() {
                            document.getElementById('network').value = document.getElementById("ntel").value;
                            var sourceOfPicture = "assets/images/ntel-airtime.jpg";
                            var img = document.getElementById('bigpic')
                            img.src = sourceOfPicture.replace('90x90', '225x225');
                            img.style.display = "block";
                        }

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



                        function yesnoCheck() {
                            if (document.getElementById('yescard').checked) {
                                document.getElementById('ifYes').style.visibility = 'visible';
                            }

                            if (document.getElementById('yescash').checked) {
                                document.getElementById('ifYes').style.visibility = 'visible';
                            }

                            if (document.getElementById('yesbitcoin').checked) {
                                document.getElementById('ifYes').style.visibility = 'visible';
                            }



                        }
                    </script>
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- customer acquistion  -->
                    <!-- ============================================================== -->
                    <?php include('inc/sidebar.php'); ?>
                    <!-- ============================================================== -->



                    <!-- end customer acquistion  -->

                    <?php include('inc/recent-transaction-widget.php'); ?>
                    <!-- ============================================================== -->
                </div>
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- product category  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- end product category  -->




                    <script type="text/javascript">
                        //datepicker plugin
                        //link	
                        $('#sendWithPhoneBook').click(function(e) {
                            $('#pb_groups').css('display', 'block');
                            e.preventDefault();
                        });

                        $("input[type=checkbox].grp_select").change(function() {
                            if ($(this).is(":checked")) {
                                var bin = chkK();
                                $("#grp_select_check").html('+' + bin + ' Selected Phonebook Group Recepient(s)');
                            } else {
                                var bin = chkK();
                                if (bin > 0) {
                                    $("#grp_select_check").html('+' + bin + ' Selected Phonebook Group Recepient(s)');
                                } else {
                                    $("#grp_select_check").html('');
                                }
                            }
                        });

                        function countDest() {
                            destcount = jQuery("#recipient").val();
                            destcount = destcount.split(' ').join(',').split("\n").join(',').split(',,').join(',');
                            // console.log(countUnit());
                            destcount = destcount.split(',').length;
                            if (destcount < 2) jQuery("#destcount").html(destcount + " recipient typed");
                            else jQuery("#destcount").html(destcount + " recipients typed");
                            $('#hiddenCount').html(destcount);
                            // return destcount;
                        }

                        function chkK() {
                            var val = [];
                            $(':checkbox:checked').each(function(i) {
                                val[i] = $(this).val();
                            });
                            return (val.length);
                        }



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


                        $('#recipient').keyup(function() {
                            if (this.value.length > 0) {
                                $('#destcount').css('display', 'block');
                                countDest();
                            } else {
                                $('#destcount').css('display', 'none');
                            }
                        });

                        function showUsage(messagesCount) {
                            var x = jQuery('#paget').html() + ", " + jQuery('#destcount').html() + "\nSend Message? Duplicate Numbers will be removed";
                            return confirm(x);
                        }

                        function showUsageFree(messagesCount) {
                            var x = jQuery('#paget').html() + ", " + jQuery('#destcount').html() + "\nSend Message. You are using Free SMS Units and it ll contain an Advert?";
                            return confirm(x);
                        }
                        $('#myForm input').on('change', function() {
                            var oname = ($('input[name="mode"]:checked', '#myForm').val());
                            // alert(oname);
                            if (oname == 'sms') {
                                $('#emailbox').css("display", "none");
                                $('#smsbox').css("display", "block");
                            } else if (oname == 'email') {
                                $('#smsbox').css("display", "none");
                                $('#emailbox').css("display", "block");
                            }
                        });
                        $('#form-field-select-1').on('change', function() {
                            var selectVal = $('#form-field-select-1').val();
                            if (selectVal == '4') {
                                $('#date-range').css("display", "none");
                                $('#wallet-range').css("display", "block");
                            } else {
                                $('#date-range').css("display", "block");
                                $('#wallet-range').css("display", "none");
                            }
                        });
                    </script>
                    <script type="text/javascript">
                        $(function() {
                            var scntDiv = $('#more-xtra');
                            var i = $('#more-xtra div').length + 1;
                            $('#addScnt').on('click', function() {
                                // alert('ooooo');
                                console.log(i);
                                $('#addScnt').html('Add More Date');
                                $('<div id="extr" class="form-group"><label class="col-md-4 control-label">Schedule Date</label><div class="col-md-8"><div class="input-group"><input type="datetime-local" value="2019-11-05T18:18" id="example-input2-group1" name="schedule_date[]" class="form-control" placeholder="Email"><span  id="remScnt"class="input-group-addon"><i class="fa fa-minus"></i></span></div></div></div>').appendTo(scntDiv);
                                i++;
                                return false;
                            });

                            $('#more-xtra').on('click', '#remScnt', function(e) {
                                // alert(i);
                                // if( i > 2 ) {
                                $('#more-xtra #extr:last').remove();
                                i--;

                                // }
                                e.preventDefault();
                                return false;
                            });
                        });
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
                    <!-- total revenue  -->
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
    <?php include('inc/footer.php');  ?>