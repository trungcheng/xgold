<div class="container">

    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box" style="min-height:65px;">
                <div class="pull-left">
                    <h4 class="page-title">Dashboard</h4>                                    
                </div>
                <div class="pull-right price_box">
                    <p>
                        <i class="mdi mdi-gift"></i> Your BGC Balance: <span><b><?= $tokenCount ?></b> BGC</span>
                    </p>
                    <!--<p class="text-right">
                        <a href="#" class="color_blue">Withdraw</a> BGC to MyEtherwallet
                    </p>-->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12"></div>
    </div>    

    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card-box-teky-1 card-box widget-box-two widget-two-custom">
                <div class="icon-box-teky">
                    <img src="<?php echo base_url(); ?>assets/v2/images/icon-box-1.png" class="img-responsive">
                </div>
                <div class="wigdet-two-content">
                    <h5 class="">
                        Enter your Ethereum address to receive and store your BGC tokens 
                    </h5>
                    <p class="m-0">Step 1</p>
                </div>
            </div>
        </div><!-- end col -->                            
        <div class="col-lg-3 col-md-6">
            <div class="card-box-teky-2 card-box widget-box-two widget-two-custom">
                <div class="icon-box-teky">
                    <img src="<?php echo base_url(); ?>assets/v2/images/icon-box-2.png" class="img-responsive">
                </div>
                <div class="teky-content-2 wigdet-two-content">
                    <h5 class="">
                        Press on Contribute Now button 
                    </h5>
                    <p class="m-0">Step 2</p>
                </div>
            </div>
        </div><!-- end col -->
        <div class="col-lg-3 col-md-6">
            <div class="card-box-teky-3 card-box widget-box-two widget-two-custom">
                <div class="icon-box-teky">
                    <img src="<?php echo base_url(); ?>assets/v2/images/icon-box-3.png" class="img-responsive">
                </div>
                <div class="wigdet-two-content">
                    <h5 class="">
                        Pay among with BTC, ETH, LTC, USDT via Changelly.
                    </h5>
                    <p class="m-0">Step 3</p>
                </div>
            </div>
        </div><!-- end col -->
        <div class="col-lg-3 col-md-6">
            <div class="card-box-teky-4 card-box widget-box-two widget-two-custom">
                <div class="icon-box-teky">
                    <img src="<?php echo base_url(); ?>assets/v2/images/icon-box-4.png" class="img-responsive">
                </div>
                <div class="wigdet-two-content">
                    <h5 class="">
                        Process your payment. For this payment you can use any type of wallet, including exchanges.
                    </h5>
                    <p class="m-0">Step 4</p>
                </div>
            </div>
        </div><!-- end col -->
    </div>
    <!-- end row -->

    <!-- end row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="header-title m-b-15 m-t-0">Wallet total</h4>
                <div class="text-center m-b-30">
                    <div class="row">
                        <?php
                            if (!empty($wallets)) {
                                foreach ($wallets as $wallet) {
                                    ?>
                                    <div class="col-xs-6 col-sm-3 card">
                                        <div class="m-t-20 m-b-20">
                                            <h3 class="m-b-10"><?= $wallet['balance'] ?></h3>
                                            <p class="text-uppercase m-b-5 font-13 font-600"><?= strtoupper($wallet['coin_type']) ?></p>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <p class="text-center" style="color:#f96a74;">You don't have any wallet</p>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title" style="margin-bottom:20px;">PENDING TRANSACTION</h4>
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Check Hash</th>
                                    <th>Transaction Type</th>
                                    <th>Address</th>
                                    <th>Amount</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if (!empty($transactions)) {
                                        foreach ($transactions as $key => $tran) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?= $key + 1 ?></th>
                                                <td><?= $tran['trans_id'] ?></td>
                                                <td><?php
                                                    if ($tran['trans_type'] == 1) {
                                                        echo 'Buy token';
                                                    } else if ($tran['trans_type'] == 2) {
                                                        echo 'Deposit '.$tran['coin_type'];
                                                    } else {
                                                        echo 'Withdraw '.$tran['coin_type'];
                                                    }
                                                ?></td>
                                                <td><?= $tran['to_addr'] ?></td>
                                                <td><?= $tran['total'] ?></td>
                                                <td><?= $tran['time'] ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <td colspan="7" style="color:#f96a74;">You don't have any pending transactions</td>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


</div> <!-- container -->