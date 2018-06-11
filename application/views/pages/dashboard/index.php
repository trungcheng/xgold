<div class="container">

    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box">
                <div class="pull-left">
                    <h4 class="page-title">BUY TKC</h4>                                    
                    <div class="clearfix"></div>
                                        <p class="m-t-10 m-b-0 hidden-xs">A few simple steps to invest in TEKY ICO, minimum investment: $50 (~311 TKC)</p>
                                </div>
                <div class="pull-right price_box">
                    <p>
                        <i class="mdi mdi-gift"></i> Your TKC Balance: <span><b>0</b> TKC</span>
                    </p>
                    <!--<p class="text-right">
                        <a href="#" class="color_blue">Withdraw</a> TKC to MyEtherwallet
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
                        Enter your Ethereum address to receive and store your TKC tokens 
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
        <div class="col-lg-8">                              
            <div class="card-box">
                <div class="col-md-5">
                    <h4 class="header-title m-t-0 m-b-30">Choose payment currency:</h4>
                    <div class="row box-list-coin">
                        <div ng-click="changeCurrency('BTC')" class="col-md-6 col-xs-6 box-tk-item">
                            <img src="<?php echo base_url(); ?>assets/v2/images/icon-btc.png" class="img-responsive">
                            <p class="m-t-10" ng-class="buy.currency=='BTC'?'m-t-10 bold':'m-t-10'" >Bitcoin</p>
                        </div>
                        <div ng-click="changeCurrency('ETH')"  class="col-md-6 col-xs-6 box-tk-item">
                            <img src="<?php echo base_url(); ?>assets/v2/images/icon-eth.png" class="img-responsive">
                            <p class="m-t-10" ng-class="buy.currency=='ETH'?'m-t-10 bold':'m-t-10'">Ethereum</p>
                        </div>
                        <div ng-click="changeCurrency('LTC')" class="col-md-6 col-xs-6 box-tk-item m-t-10">
                            <img src="<?php echo base_url(); ?>assets/v2/images/icon-ltc.png" class="img-responsive">
                            <p class="m-t-10" ng-class="buy.currency=='LTC'?'m-t-10 bold':'m-t-10'">Litecoin</p>
                        </div>
                        <div ng-click="changeCurrency('USDT')" class="col-md-6 col-xs-6 box-tk-item m-t-10">
                            <img src="<?php echo base_url(); ?>assets/v2/images/icon-usdt.png" class="img-responsive">
                            <p class="m-t-10" ng-class="buy.currency=='USDT'?'m-t-10 bold':'m-t-10'">Tether</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <!-- <form id="pay_ment_form" action="" class="m-t-50" ng-if="step == 3" >
                        <div class="form-group">
                            <label style="width: 100%;">Please enter the transaction code: <div ng-if="time != ''" class="pull-right text-danger" ng-bind="time" ></div></label>
                            <input type="text" ng-model="buy.transaction_id" class="form-control" placeholder="Transaction id" />
                        </div>
                        <div class="form-group">
                            <button type="button" ng-click="step3Submit()" class="pull-right btn btn-custom waves-effect waves-light" >Submit</button>
                        </div>
                    </form> -->
                    <form id="pay_ment_form" action="" class="m-t-50" ng-if="step != 3" >
                        <div class="form-group">
                            <input ng-disabled="!requirePhone" type="text" ng-model="buy.phone" class="form-control" placeholder="Your phone number" value="0975123644">
                        </div>
                        <div class="form-group">
                            <input ng-disabled="!requireFrom" type="text" ng-model="buy.fromAddress" class="form-control" placeholder="Your ETH address to pay">
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input id="example-input1-group1" ng-change="changeAmount()" type="number" ng-model="buy.amount" class="form-control" placeholder="TKC amount to buy">
                                <span class="input-group-addon"><b>TKC</b></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">                        
                                <input ng-change="changeValue()" type="number" ng-model="buy.value" class="form-control" placeholder="ETH amount to pay">
                                <span class="input-group-addon"><b>ETH</b></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left text-right">
                                        <p>TKC amount to buy:</p>
                                        <p>ETH to pay:</p>
                                        <p>Bonus TKC:</p>
                                        <p>Total:</p>
                                    </div>
                                    <!-- <div class="pull-right">
                                        <p><b>{{buy.amount| number}}</b> TKC</p>
                                        <p><b>{{buy.value| number}}</b> {{buy.currency}}</p>
                                        <p><b>{{buy.bonus| number}}</b> TKC ({{((buy.bonus / buy.amount) * 100) | number}}%)</p>
                                        <p><b>{{(buy.amount + buy.bonus) | number}}</b> TKC</p>
                                    </div> -->
                                </div>
                                <div class="col-md-12">
                                    <button type="button" ng-click="step2()" class="pull-right btn btn-custom waves-effect waves-light" >CONTRIBUTE NOW</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <!-- <div ng-if="step == 3">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p>Please send
                                            <b class="color-red">{{buy.value}} {{buy.currency}}</b> to this address to complete your purchase. Thank you!
                                        </p>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input id="referral_text" readonly="" type="text" ng-model="address" class="form-control">
                                                <span class="input-group-addon copy_addon btn btn-primary" style="cursor: pointer" ng-click="copy()" >COPY</span>
                                            </div>
                                        </div>
                                        <p>After payment, please call us at <b class="color-red"> (+84) 938 690 253 </b> or email us at <a href="/cdn-cgi/l/email-protection#88ebe7e6fce9ebfcc8fcede3f1ebe7faf8a6ebe7e5"><b style="color: #1b71fc"> <span class="__cf_email__" data-cfemail="e98a86879d888a9da99d8c82908a869b99c78a8684">[email&#160;protected]</span> </b></a> to confirm your purchase. Thank you!
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <qr size="200" text="address"></qr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --><!-- /.modal -->
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card-box have_min">
                <h4 class="header-title m-t-0 m-b-30">Review your receiving ETH wallet:</h4>
                <form action="">
                    <div class="form-group">
                        <input type="text" class="form-control" ng-model="buy.toAddress" disabled />
                    </div>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        You have to use here your personal Ethereum wallets like MyEtherWallet, Metamask, Parity, Mist, imToken, Ledger (hardware wallet) or ask support about your wallet. WARNING NOT SUPPORTED: Coinbase wallet, all wallets from exchanges, Free Ethereum Wallet for Android.
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title m-b-30"><b>Your transaction history:</b></h4>

                <div class="row" style="margin-bottom: 10px">
                    <div class="col-sm-12">
                        <div class="form-inline pull-right">
                            <div class="form-group">
                                <label>Page: </label>
                                <select class="form-control">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Buy detail</th>
                                    <th>TKC delivery detail</th>
                                </tr>
                                <tr ng-if="!transactions.length">
                                    <td colspan="3" class="text-danger text-center">You don't have any transactions</td>
                                </tr>
                                <!-- <tr ng-repeat="transaction in transactions">
                                    <td>
                                        <p>txHash:
                                            {{transaction.id}}
                                        </p>
                                        <p>From: {{transaction.from}}</p>
                                        <p>To: {{transaction.to}}</p>
                                        <p>Time: {{transaction.time * 1000| date:'dd/MM/yyyy h:mma'}}</p>
                                        <p>Value: {{transaction.value}} {{transaction.currency}}</p>
                                    </td>
                                    <td>
                                        <p>Amount: {{transaction.buyAmount}} TKC</p>
                                        <p>Bonus: {{transaction.bonusAmount}} TKC</p>
                                        <p>Status: {{transaction.deliveryTime?'Completed':'Pending'}}</p>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-sm-12">
                        <div class="form-inline pull-right">
                            <div class="form-group">
                                <label>Page: </label>
                                <select class="form-control">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div> <!-- container -->