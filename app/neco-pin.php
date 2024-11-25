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
                            <li class="fa fa-book"></li> NECO PINs
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
                                    <input type="radio" name="carier" class="custom-control-input" value="NECO Result Checker" onclick="javascript:showTv();" id="smiledata"><span class="custom-control-label"><img src="assets/images/neco-result.jpg"></span>
                                </label>







                                <p></p>
                                <div class="float-center">
                                    <img style="display:none;" id="bigpic" src="bigpic" width="250" />

                                </div>



                                <!-- Start SmileData hidden -->
                                <div class="float-center" id="ifData" style="display:none;">
                                    <div class="form-group">
                                        <?php $waec = $conn->query("SELECT * FROM exam_package WHERE network='neco' AND plancode='neco'");

                                        ?>

                                        <label></label>

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
                    <script src="js/necopop.js"></script>
                    <!-- customer acquistion  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Account Status</h5>
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h5 class="text-muted">Current Balance</h5>
                                    <h2 class="mb-0"> &#x20A6;<?php echo number_format($bal, 2, '.', ','); ?></h2>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-brand-light mt-1">
                                    <i class="fa fa-money-bill-alt fa-fw fa-sm text-brand"></i>
                                </div>

                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h5 class="text-muted">Affiliate Link:</h5>
                                    <p class="mb-0"> <?php echo $data['reflink'];
                                                        echo $data['refid']; ?></p>

                                </div>
                                <div class="float-left">
                                    <p class="text-muted"><strong>Total Referred:</strong> <?php echo $data['refcount']; ?> <br>

                                        <strong> Earning:</strong> &#x20A6;<?php echo number_format($data['refwallet'], 2, '.', ','); ?>
                                    </p>
                                </div>


                                <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">

                                    <i class="fa fa-users fa-fw fa-sm text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
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