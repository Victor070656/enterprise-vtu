<?php
session_start();
require('../../db.php');
include('../../inc/func1.php');
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

            <!-- pageheader  -->

            <div class="ecommerce-widget">

                <div class="row"></div>
                <div class="row">
                    <!-- ============================================================== -->


                    <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                        <p></p>
                        <div class="card">



                            <div class="card-body">

                                <script>
                                    function walletCredit() {
                                        document.location = "../../add_fund.php";
                                    }
                                </script>



                                <form method="post" action="javascript:void(0)" id="activateform">

                                    <h5 class='alert alert-info' align="center">
                                        <li class="fa fa-exclamation-circle"></li> Activate your account to start generating and printing recharge cards with no special software.
                                    </h5>
                                    <table class="table  margin-tp-10" id="transTable">

                                        <tr>
                                            <td width="30%"> </td>
                                            <td id="mainService">
                                                <img src="../../assets/images/mtn.jpg" width="50" height="50" class="rounded-corners">
                                                <img src="../../assets/images/airtel.jpg" width="50" height="50" class="rounded-corners">
                                                <img src="../../assets/images/glo.jpg" width="50" height="50" class="rounded-corners">
                                                <img src="../../assets/images/9mobile.jpg" width="50" height="50" class="rounded-corners">


                                            </td>
                                        </tr>


                                        <tr>
                                            <td width="30%">Product</td>
                                            <td id="mainService">Activation for ePINs generator & printing </td>
                                        </tr>

                                        <tr>
                                            <td width="30%">Plan:</td>
                                            <td>

                                                <?php $mtncgl = $conn->query("SELECT * FROM epin_package WHERE duration <> 2   ORDER BY `amount` ASC"); ?>

                                                <input type="hidden" name="fee" id="fee">
                                                <input type="hidden" name="token" id="token" value="<?php echo base64_encode($email); ?>">

                                                <select class="form-control" id="plan" name="plan">

                                                    <option selected hidden disabled>Please choose..</option>

                                                    <?php while ($mcgl = $mtncgl->fetch_assoc()) { ?>
                                                        <option value="<?php echo $mcgl['serial']; ?>"> <?php echo $mcgl['plan']; ?> </option>
                                                    <?php } ?>

                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="30%">Total Payable Amount</td>
                                            <td>

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend"><span class="input-group-text">&#x20A6;</span></div>
                                                    <input type="number" class="form-control" name="amount" id="amount">
                                                    <div class="input-group-append"><span class="input-group-text">.00</span></div>


                                                </div>

                                            </td>
                                        </tr>


                                        <tr>
                                            <td width="30%">
                                                <span>Your referal code is: <strong> <?php echo $refyid; ?></strong></span>
                                                Invite your friends and Earn 20% of the activation fee <br>
                                                <div id="share-buttons">
                                                    <a href="whatsapp://send?text=Instantly recharge Gotv, Dstv,Bet9ja,Smile, Spectranet, Startimes, Electricity at a discount and earn money. Try it here <?php echo $refy_url; ?><?php echo $refyid; ?>" data-action="share/whatsapp/share"> <?php echo $whatsapp; ?></a>

                                                    <!-- Facebook -->
                                                    <a href="http://www.facebook.com/sharer.php?u=<?php echo $refy_url; ?><?php echo $refyid; ?>" target="_blank">
                                                        <?php echo $facebook; ?>
                                                    </a>


                                                    <!-- Twitter -->
                                                    <a href="https://twitter.com/share?url=<?php echo $refy_url; ?><?php echo $refyid; ?>&amp;text=Instantly recharge Gotv, Dstv,Bet9ja,Smile, Spectranet, Startimes, Electricity at a discount and earn money. Try it here <?php echo $rlink; ?><?php echo $refk; ?>&amp;hashtags=epins" target="_blank">
                                                        <?php echo $twitter; ?>

                                                    </a>




                                                </div>
                                            </td>
                                            <td>

                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
                                                    <input type="number" class="form-control" name="refcode" id="refcode" placeholder="Please Enter referal code of the person that invited you.">
                                                    <div class="input-group-append"><span class="input-group-text"></span></div>

                                                    <input type="hidden" id="pid">
                                                </div>
                                                <span id="remark"></span>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td colspan="1"></td>
                                            <td>

                                                <span id="notice"></span>
                                                <button type="submit" id="btnpay" class="btn btn-rounded btn-warning"><i class="fas fa-fw fa-money-bill-alt"></i> Pay & Activate</button>
                                            </td>
                                        </tr>
                                    </table>

                                </form>

                                <script src="js/sb-sub.js"></script>

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

                    <script>
                        // Set the date we're counting down to
                        var countDownDate = new Date("Jan 5, 2021 15:37:25").getTime();

                        // Update the count down every 1 second
                        var x = setInterval(function() {

                            // Get today's date and time
                            var now = new Date().getTime();

                            // Find the distance between now and the count down date
                            var distance = countDownDate - now;

                            // Time calculations for days, hours, minutes and seconds
                            var days = Math.floor(distance / (1000 * 60 * 60 * 0));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 1)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 30)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                            // Display the result in the element with id="demo"
                            document.getElementById("timing").innerHTML = hours + "h " +
                                minutes + "m " + seconds + "s ";

                            // If the count down is finished, write some text
                            if (distance < 0) {
                                clearInterval(x);
                                document.getElementById("timer").innerHTML = "EXPIRED";
                            }
                        }, 1000);
                    </script>
                    <!-- ============================================================== -->
                    <!-- customer acquistion  -->
                    <!-- ============================================================== -->
                    <?php include('../../inc/sidebar.php'); ?>
                    <!-- ============================================================== -->



                    <!-- end customer acquistion  -->
                    <!-- end customer acquistion  -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Recent Transactions</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th>Transaction ID</th>

                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Date</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql_trans = "SELECT * FROM transactions WHERE email='$user' ORDER BY `serial` DESC LIMIT 3 ";

                                            $Show_trans = $conn->query($sql_trans);

                                            while ($trow = $Show_trans->fetch_assoc()) {

                                            ?>
                                                <tr>

                                                    <td><?php echo $trow['ref']; ?></td>

                                                    <td><?php echo '&#x20A6;' . $trow['amount'] . ' '; ?></td>
                                                    <td><?php echo $trow['status']; ?></td>
                                                    <td><?php echo $trow['date']; ?></td>

                                                </tr>

                                            <?php } ?>


                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Transaction ID</th>

                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Date</th>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

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