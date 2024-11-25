<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card">
        <h5 class="card-header">Transaction History</h5>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered first">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Description</th>
                            <th>Destination</th>
                            <th>Amount</th>
                            <th>Amount Paid</th>
                            <th>Status</th>
                            <th>Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $json_allTrans = json_decode(recentTransactions($conn, $user));
                        if (is_array($json_allTrans)) {
                            foreach ($json_allTrans as $row_sw) {
                                if (is_countable($row_sw)) {
                                    for ($i = 0, $t = count($row_sw); $i < $t; $i++) {
                        ?>
                                        <tr>

                                            <td><?php echo $row_sw->ref; ?></td>
                                            <td><?php echo $row_sw->network; ?></td>
                                            <td><?php echo $row_sw->phone; ?></td>

                                            <td><?php echo '&#x20A6;' . number_format($row_sw->amount, 2, '.', ',') . ' '; ?></td>
                                            <td><?php echo '&#x20A6;' . number_format($row_sw->charge, 2, '.', ',') . ' '; ?></td>
                                            <td><?php echo $row_sw->status; ?></td>
                                            <td><?php echo $row_sw->date; ?></td>

                                        </tr>

                        <?php
                                    }
                                }
                            }
                        }
                        ?>


                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Description</th>
                            <th>Destination</th>
                            <th>Amount</th>
                            <th>Amount Paid</th>
                            <th>Status</th>
                            <th>Date</th>

                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>