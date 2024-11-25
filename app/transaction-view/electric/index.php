<?php
ob_start();
session_start();
session_regenerate_id();
require('../../db.php');
include_once('../../inc/func1.php');
include('../../inc/gravatar.php');
include('../../inc/logo.php');
include('../../inc/coinpayments.inc.php');
include('../../inc/query_processor.php');
include('../../inc/header2.php'); ?>
<!-- ============================================================== -->
<!-- end navbar -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- left sidebar -->
<!-- ============================================================== -->
<?php include('../../inc/nav3.php'); ?>
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

                                $amount = filter_var(validate_input(strval(floatval($_SESSION['amt']))), FILTER_SANITIZE_NUMBER_FLOAT);
                                $requestId = validate_input($_SESSION['transid']);
                                $txtadmin = "08084121526";
                                $totalPayable = $_SESSION['topay'];
                                $comi = $_SESSION['discount'];

                                ?>

                                <form method="post" id="cglitePay" action="javascript:void(0)">

                                    <h3 id="mtok">Please Confirm your Transaction Details: </h3>


                                    <table class="table  margin-tp-10 responsive" id="transTable">


                                        <tr>
                                            <td width="30%"> </td>
                                            <td id="mainService"><img src="../../assets/images/<?php echo strval($_SESSION['img']); ?>" width="100" height="100" class="rounded-corners"> </td>
                                        </tr>

                                        <tr>
                                            <td>Product</td>
                                            <td id="mainService"><?php echo strval($_SESSION['descr']); ?> </td>
                                        </tr>

                                        <tr>
                                            <td>Meter Number</td>
                                            <td><?php echo $_SESSION['phone']; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Customer Name</td>
                                            <td id="mainService"><?php echo strval($_SESSION['customer']); ?> </td>
                                        </tr>

                                        <tr>
                                            <td>Contact Address</td>
                                            <td id="mainService"><?php echo strval($_SESSION['Address']); ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Amount</td>
                                            <td>₦<?php echo $_SESSION['amt']; ?>.00 + ₦0.00 <i class="conv_fee">

                                                    (Service charge)

                                                </i></td>
                                        </tr>

                                        <tr>
                                            <td>Discount</td>
                                            <td>₦<d id="total_amount"><?php echo $comi; ?></d>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>Total Payable Amount</td>
                                            <td>₦<d id="total_amount"><?php echo $totalPayable; ?></d>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <stro>Transaction ID</h4>
                                            </td>
                                            <td id="transactionId"><?php echo $requestId; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td><?php echo $_SESSION['status']; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Time Left to Complete Transaction</td>
                                            <td><?php echo '<strong id="timing">' ?></td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td>
                                            </td>
                                        </tr>

                                    </table>

                                    <div style="margin-top: 20px;"><strong></strong></div>
                                    <div class="row responsive">
                                        <div class="col-8">
                                            <input type="hidden" name="_tok" value="<?php echo $_GET['trans']; ?>">
                                            <button type="submit" id="walletpay" class="btn-lg btn-rounded btn-primary float-right"> <i class="fas fa-fw fa-money-bill-alt"></i> Pay Now</button>
                                        </div>
                                        <div class="col-3 responsive">
                                            <button type="submit" name="cardpay" class="cardpay" style="display: none"></button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                    <?php $trans = $_SESSION["transid"]; ?>
                    <!-- ============================================================== -->
                    <script>
                        $('#walletpay').click(function(e) {
                            e.preventDefault();

                            var formData = $('#cglitePay').serialize();
                            $.ajax({
                                url: "../../formrequest/payelectric.php?trans=<?= $trans; ?>",
                                type: "GET",
                                data: formData,
                                dataType: "json",
                                contentType: 'application/json; charset=utf-8',
                                async: false,
                                beforeSend: function() {
                                    $('#walletpay').html('<i class="fa fa-spinner"></i> Processing...');
                                },
                                success: function(data) {
                                    // Process with the response data
                                    console.log(data);
                                    if (data.status === true) {
                                        var dirUrl = data.redirect;
                                        var disco = data.disco;
                                        var metertoken = data.token;
                                        Swal.fire({
                                            title: 'Transaction Successful',
                                            html: 'Your ' + disco + ' token is:  <b>' + metertoken + '</b>, ',
                                            icon: 'success',
                                            showCancelButton: true,
                                            showDenyButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Purchase New'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "../../electricity.php";
                                            } else if (result.isDeny) {

                                                document.location.replace(dirUrl);
                                            }
                                        })
                                        $('#mtok').html('<div class="alert alert-info"><b>' + data.msg + ':</b> Your ' + disco + ' token is: <b>' + metertoken + '</b> </div>');

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
                                        setTimeout(() => {
                                            $('#walletpay').html('<i class="fas fa-fw fa-money-bill-alt"></i> Pay Now');
                                        }, 3000);

                                    }

                                },
                                error: function(xhr, status, error) {
                                    console.error("AJAX error:", error);
                                    console.error("AJAX status:", status);
                                    console.log("Server response:", xhr.responseText);
                                    $("#walletpay").html("Pay Now"); // Reset button text on error
                                },
                            });
                        });
                    </script>
                    <!-- ============================================================== -->

                    <script>
                        // Set the date we're counting down to
                        var countDownDate = new Date("Jan 5, 2025 15:37:25").getTime();

                        // Update the count down every 1 second
                        var x = setInterval(function() {

                            // Get today's date and time
                            var now = new Date().getTime();

                            // Find the distance between now and the count down date
                            var distance = countDownDate - now;

                            // Time calculations for days, hours, minutes and seconds
                            var days = Math.floor(distance / (1000 * 60 * 60 * 0));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 1)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 5)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            // Display the result in the element with id="demo"
                            document.getElementById("timing").innerHTML = hours + "h " +
                                minutes + "m " + seconds + "s ";

                            // If the count down is finished, write some text
                            if (distance < 0) {
                                clearInterval(x);
                                document.getElementById("timing").innerHTML = "EXPIRED";
                                window.location.replace('../');
                            }
                        }, 1000);
                    </script>
                    <!-- ============================================================== -->
                    <!-- customer acquistion  -->
                    <!-- ============================================================== -->
                    <?php include('../../inc/sidebar.php'); ?>
                    <!-- ============================================================== -->



                    <!-- end customer acquistion  -->

                    <?php include('../../inc/recent-transaction-widget.php'); ?>
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
                    <!-- ============================================================== -->
                    <!-- end sales  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- new customer  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- end new customer  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- visitor  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- end visitor  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- total orders  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- end total orders  -->
                    <!-- ============================================================== -->
                </div>
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- total revenue  -->
                    <!-- ============================================================== -->


                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- category revenue  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- end category revenue  -->
                    <!-- ============================================================== -->
                </div>
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- end sales traffice source  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- sales traffic country source  -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- end sales traffice country source  -->
                    <!-- ============================================================== -->
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <?php include('../../inc/footer1.php'); ?>
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
<script src="../../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
<!-- bootstap bundle js -->
<script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<!-- slimscroll js -->
<script src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
<!-- main js -->
<script src="../../assets/libs/js/main-js.js"></script>
<!-- chart chartist js -->
<script src="../../assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
<!-- sparkline js -->
<script src="../../assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
<!-- morris js -->
<script src="../../assets/vendor/charts/morris-bundle/raphael.min.js"></script>
<script src="../../assets/vendor/charts/morris-bundle/morris.js"></script>
<!-- chart c3 js -->
<script src="../../assets/vendor/charts/c3charts/c3.min.js"></script>
<script src="../../assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
<script src="../../assets/vendor/charts/c3charts/C3chartjs.js"></script>
<script src="../../assets/libs/js/dashboard-ecommerce.js"></script>
</body>

</html>