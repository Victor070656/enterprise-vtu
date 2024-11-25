<?php
session_start();
require('db.php');
include('inc/func.php');
include('inc/gravatar.php');
include('inc/logo.php');
include('inc/coinpayments.inc.php');
?>
<?php include('inc/header.php'); ?>

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
                            <li class="fa fa-book"></li> WAEC PINs
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




                                <label for="inputText3" class="col-form-label">Please Select Service</label><br>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="carier" class="custom-control-input" value="WAEC Result Checker" onclick="javascript:showTv();" id="smiledata"><span class="custom-control-label"><img src="assets/images/waec-result.jpg"></span>
                                </label>


                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="carier" class="custom-control-input" value="voice" onclick="javascript:showTv();" id="voice"><span class="custom-control-label"><img src="assets/images/waec-reg.jpg"></span>
                                </label>




                                <p></p>
                                <div class="float-center">
                                    <img style="display:none;" id="bigpic" src="bigpic" width="250" />

                                </div>



                                <!-- Start SmileData hidden -->
                                <div class="float-center" id="ifData" style="display:none;">
                                    <div class="form-group">
                                        <?php $waec = $conn->query("SELECT * FROM exam_package WHERE network='waec' AND plancode='waec'");
                                        $waecdir = $conn->query("SELECT * FROM exam_package WHERE network='waec' AND plancode='waecdirect'");
                                        ?>

                                        <label>WAEC Result Checking PIN</label>

                                        <select class="form-control" id="IsData" required="required">
                                            <option selected hidden disabled>Select ExamType</option>
                                            <?php while ($w = $waec->fetch_assoc()) { ?>
                                                <option data-plan="<?php echo $w['plan']; ?>" data-variation_code="<?php echo $w['plancode']; ?>" data-amount="<?php echo $w['price_user']; ?>" data-service="<?php echo $w['network']; ?>"><?php echo $w['plan']; ?> - <?php echo '&#8358;' . $w['price_user']; ?> </option>
                                            <?php } ?>
                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label for="inputText3" class="col-form-label">Quantity</label>
                                        <input id="qty1" type="number" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputText3" class="col-form-label">Phone Number</label>
                                        <input id="rctel" type="tel" class="form-control">
                                    </div>


                                </div>
                                <!-- End SmileData hidden -->


                                <!-- Start SmileVoice hidden -->
                                <div class="float-center" id="ifVoice" style="display:none;">
                                    <div class="form-group">


                                        <label>WAEC REGISTRATION PIN</label>

                                        <select class="form-control" id="IsVoice" required="required">

                                            <option selected hidden disabled>Select ExamType</option>
                                            <?php while ($wd = $waecdir->fetch_assoc()) { ?>
                                                <option data-plan="<?php echo $wd['plan']; ?>" data-variation_code="<?php echo $wd['plancode']; ?>" data-amount="<?php echo $wd['price_user']; ?>" data-service="<?php echo $wd['network']; ?>"><?php echo $wd['plan']; ?> - <?php echo '&#8358;' . $wd['price_user']; ?> </option>
                                            <?php } ?>

                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label for="inputText3" class="col-form-label">Quantity</label>
                                        <input id="qty2" type="number" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputText3" class="col-form-label">Phone</label>
                                        <input id="rgtel" type="tel" class="form-control">
                                    </div>


                                </div>
                                <!-- End SmileVoice hidden -->




                                <form method="post" action="javascript:void(0)" id="waecForm">
                                    <input type="hidden" name="plan" id="plan">
                                    <input type="hidden" name="service" id="service">
                                    <input type="hidden" name="amount" id="amount">
                                    <input type="hidden" name="variation_code" id="variation_code">
                                    <input type="hidden" name="telNumber" id="tele">
                                    <input type="hidden" name="iuc" id="iuc">
                                    <input type="hidden" name="transType" id="transType">

                                    <div class="col-sm-6 pl-0">
                                        <p class="text-center">
                                            <button type="submit" id="btnsub" class="btn btn-rounded btn-primary">Proceed </button>

                                        </p>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                    <script src="js/waecpop.js"></script>
                    <!-- customer acquistion  -->
                    <!-- ============================================================== -->
                    <?php include('inc/sidebar.php'); ?>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- ============================================================== -->
    <?php include('inc/footer.php'); ?>