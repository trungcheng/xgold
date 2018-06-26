<div class="container" ng-controller="FinanceController" ng-init="loadDeposit()">

    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box" style="min-height:65px;">
                <div class="pull-left">
                    <h4 class="page-title">BITCOIN CASH WALLET</h4>                                    
                    <div class="clearfix"></div>
                </div>
                <div ng-cloak class="pull-right price_box">
                    <p>
                        <i class="mdi mdi-gift"></i> Your BCH Balance: <span><b>{{ balance }}</b> BCH</span>
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
        <input type="hidden" id="coinName" value="Bitcoin Cash">
        <input type="hidden" id="typeCoin" value="bch">
    </div>

    <!-- end row -->
    <div class="row">
        
        <div class="col-md-12">
            <!-- <div class="col-md-6"> -->
                <div class="card-box" ng-cloak>
                    <h4 class="header-title m-t-0 m-b-30">{{ coinName }} {{ type.toUpperCase() }}</h4>

                    <ul class="nav nav-tabs">
                        <li class="nav-item active">
                            <a ng-click="loadDeposit()" href="#deposit" data-toggle="tab" aria-expanded="false" class="nav-link">
                                Deposit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a ng-click="loadWithdraw()" href="#withdraw" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                Withdraw
                            </a>
                        </li>
                        <li class="nav-item">
                            <a ng-click="loadHistory()" href="#history" data-toggle="tab" aria-expanded="false" class="nav-link">
                                History
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="deposit" ng-if="type == 'deposit'">
                            <form id="depositForm" ng-submit="confirmDeposit()">
                                <input type="hidden" id="coinType" value="bch">
                                <p style="font-weight:bold;color:#f00;font-size:14px;">- Step 1: Copy bitcoin cash address or scan QR code to send bch from other app to this address</p>
                                
                                <p class="text-center" style="font-size:14px;">Deposit Address</p>
                                <div class="input-group col-md-8 col-md-offset-2">
                                    <span title="Copy address" ng-click="copyAddress()" style="background:#fff;cursor:pointer;" class="input-group-addon"><i class="glyphicon glyphicon-saved"></i></span>
                                    <input readonly id="addr" type="text" class="form-control" name="toAddr" placeholder="Bitcoin cash address" ng-model="addr">
                                </div>
                                <div style="display:block;text-align:center;margin-top:20px;margin-bottom:20px;">
                                    <qr type-number="5" size="250" text="addr"></qr>
                                </div>

                                <p style="margin-bottom:30px;font-weight:bold;color:#f00;font-size:14px;">- Step 2: After send bch success, please get transaction id paste to trans id box in the below and fill amount, finally press CONFIRM button to submit your request to our system. (NOTE: Please input transaction ID correctly to confirm you have already transfer success)</p>
                            
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="form-group">
                                        <label for="email">From Address</label>
                                        <input type="text" id="fromAddr" class="form-control" name="fromAddr" placeholder="From address...">
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">BCH Amount</label>
                                        <input type="number" id="amount" class="form-control" name="amount" placeholder="Amount currency number...">
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Transaction ID</label>
                                        <input type="text" id="tranId" class="form-control" name="transactionId" placeholder="Transaction ID...">
                                    </div>
                                    <button style="float:right" type="submit" class="btn btn-default">CANCEL</button>
                                    <button style="float:right;margin-right:10px;" type="submit" class="btn btn-primary">CONFIRM</button>
                                </div>
                            </form>

                        </div>
                        <div class="tab-pane" id="withdraw" ng-if="type == 'withdraw'">
                            <div class="col-md-8 col-md-offset-2">
                                <form id="withdrawForm" ng-submit="withdraw()">
                                    <input type="hidden" id="coinType" value="bch">
                                    <div class="form-group">
                                        <label for="email">From Address</label>
                                        <input readonly ng-model="addr" type="text" id="fromAddr" class="form-control" name="fromAddr" placeholder="From address...">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">To Address</label>
                                        <input type="text" id="toAddr" class="form-control" name="toAddr" placeholder="From address...">
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">BCH Amount</label>
                                        <input type="number" id="amount" class="form-control" name="amount" placeholder="Amount currency number...">
                                    </div>
                                    <button style="float:right" type="submit" class="btn btn-default">CANCEL</button>
                                    <button style="float:right;margin-right:10px;" type="submit" class="btn btn-primary">WITHDRAW</button>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="history" ng-if="type == 'transaction history'">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <th>#</th>
                                        <th>Check Hash</th>
                                        <th>Transaction Type</th>
                                        <th>Send To</th>
                                        <th>Amount</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody>
                                        <tr ng-if="!transactions.length">
                                            <td colspan="8" class="text-danger text-center">You don't have any transactions</td>
                                        </tr>
                                        <tr ng-cloak ng-repeat="transaction in transactions track by $index">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ transaction.trans_id }}</td>
                                            <td ng-if="transaction.trans_type == 2">Deposit</td>
                                            <td ng-if="transaction.trans_type == 3">Withdraw</td>
                                            <td>{{ transaction.to_addr }}</td>
                                            <td>{{ transaction.total }}</td>
                                            <td>{{ transaction.time }}</td>
                                            <td ng-if="transaction.status == 1">
                                                <button class="btn btn-warning btn-xs">Pending</button>
                                            </td>
                                            <td ng-if="transaction.status == 2">
                                                <button class="btn btn-success btn-xs">Success</button>
                                            </td>
                                            <td ng-if="transaction.status == 3">
                                                <button class="btn btn-danger btn-xs">Failed</button>
                                            </td>
                                            <td ng-if="transaction.status == 4">
                                                <button class="btn btn-info btn-xs">Waiting refund</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div ng-if="loading">
                    <i style="font-size:40px;position:fixed;left:52%;top:50%;z-index:99;" class="fa fa-spinner fa-spin"></i>
                </div>
            <!-- </div> -->
        </div>

    </div>


</div> <!-- container -->