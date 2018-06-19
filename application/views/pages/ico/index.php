<div class="container" ng-controller="IcoController" ng-init="loadInit()">

    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box">
                <div class="pull-left">
                    <h4 class="page-title">ICO</h4>                                    
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

    <!-- end row -->
    <div class="row">
        <div class="col-lg-8" ng-cloak>                              
            <div class="card-box">
                <div class="col-md-5">
                    <h4 class="header-title m-t-0 m-b-30">Choose payment currency:</h4>
                    <div class="row box-list-coin">
                        <div ng-cloak ng-repeat="coin in coins" ng-click="changeCurrency(coin)" class="col-md-6 col-xs-6 box-tk-item">
                            <img style="width:70px;cursor:pointer;" src="<?php echo base_url(); ?>assets/v2/images/icon-{{ coin.coin_type }}.png" class="img-responsive">
                            <p class="m-t-10">{{ coin.coin_name }}</p>
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
                    <form id="pay_ment_form" action="" class="m-t-50">
                        <div class="form-group">
                            <input readonly type="text" ng-model="buy.fromAddress" class="form-control" placeholder="Your {{ buy.currency }} address to pay">
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input id="example-input1-group1" ng-change="changeAmount()" type="number" ng-model="buy.amount" class="form-control" placeholder="TKC amount to buy">
                                <span class="input-group-addon"><b>TKC</b></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">                        
                                <input ng-change="changeValue()" type="number" ng-model="buy.value" class="form-control" placeholder="{{ buy.currency }} amount to pay">
                                <span class="input-group-addon"><b>{{ buy.currency }}</b></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left text-right">
                                        <p>TKC amount to buy:</p>
                                        <p>{{ buy.currency }} to pay:</p>
                                        <p>Bonus TKC:</p>
                                        <p>Total:</p>
                                    </div>
                                    <div class="pull-right">
                                        <p><b>{{ buy.amount | number }}</b> TKC</p>
                                        <p><b>{{ buy.value }}</b> {{ buy.currency }}</p>
                                        <p><b>{{ buy.bonusTotal | number }}</b> TKC ({{ buy.bonus | number }}%)</p>
                                        <p><b>{{ (buy.amount + ((buy.bonus * buy.amount) / 100)) | number }}</b> TKC</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" ng-click="buyIco()" class="pull-right btn btn-custom waves-effect waves-light" >
                                		<i ng-if="buyLoading" style="margin-right:5px;" class="fa fa-spinner fa-spin"></i>
                                    	BUY NOW
                                    </button>
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
        <div class="col-lg-4" ng-cloak>
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

        <div ng-if="loading">
            <i style="font-size:40px;position:fixed;left:50%;top:50%;z-index:99;" class="fa fa-spinner fa-spin"></i>
        </div>

        <div class="col-lg-12" ng-cloak>
            <div class="card-box table-responsive">
                <h4 class="m-t-0 header-title m-b-30"><b>Your transaction history:</b></h4>

                <!-- <div class="row" style="margin-bottom: 10px">
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
                </div> -->
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>From</th>
                                <th>Value</th>
                                <th>Amount</th>
                                <th>Bonus</th>
                                <th>Status</th>
                                <th>Time</th>
                            </thead>
                            <tbody>
                                <tr ng-if="!transactions.length">
                                    <td colspan="8" class="text-danger text-center">You don't have any transactions</td>
                                </tr>
                                <tr ng-cloak ng-repeat="transaction in transactions track by $index">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ transaction.from_addr }}</td>
                                    <td>{{ transaction.amount_currency_buy }} {{ transaction.buy_by.toUpperCase() }}</td>
                                    <td>{{ transaction.total }} TKC</td>
                                    <td>{{ transaction.bonus }}%</td>
                                    <td ng-if="transaction.status == 1">Pending</td>
                                    <td ng-if="transaction.status == 2">Complete</td>
                                    <td ng-if="transaction.status == 3">Fail</td>
                                    <td>{{ transaction.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <div class="row" style="margin-bottom: 10px">
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
                </div> -->
            </div>
        </div>
    </div>


</div> <!-- container -->