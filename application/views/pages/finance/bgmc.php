<div class="container" ng-controller="FinanceController" ng-init="loadWithdraw()">

    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box" style="min-height:65px;">
                <div class="pull-left">
                    <h4 class="page-title">BITGAME WALLET (TOKEN)</h4>                                    
                    <div class="clearfix"></div>
                </div>
                <div ng-cloak class="pull-right price_box">
                    <p>
                        <i class="mdi mdi-gift"></i> Total BGC: <span><b>{{ balance }}</b> BGC</span>
                    </p>
                    <!--<p class="text-right">
                        <a href="#" class="color_blue">Withdraw</a> BGMC to MyEtherwallet
                    </p>-->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12"></div>
        <input type="hidden" id="coinName" value="Bitgame">
        <input type="hidden" id="typeCoin" value="token">
    </div>

    <!-- end row -->
    <div class="row">
        
        <div class="col-md-12">
            <!-- <div class="col-md-6"> -->
                <div class="card-box" ng-cloak>
                    <h4 class="header-title m-t-0 m-b-30">BITGAME {{ type.toUpperCase() }}</h4>

                    <ul class="nav nav-tabs">
                        <!-- <li class="nav-item active">
                            <a ng-click="loadDeposit()" href="#deposit" data-toggle="tab" aria-expanded="false" class="nav-link">
                                Address
                            </a>
                        </li> -->
                        <li class="nav-item active">
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
                        <div class="tab-pane" id="deposit" ng-if="type == 'deposit'">
                            <form id="depositForm" ng-submit="confirmDeposit()">
                                <input type="hidden" id="coinType" value="token">
                                <!-- <p style="font-weight:bold;color:#f00;font-size:14px;">- Step 1: Copy bitgame address or scan QR code to send bgmc from other app to this address</p> -->
                                
                                <p class="text-center" style="font-size:14px;">Deposit Address</p>
                                <div class="input-group col-md-8 col-md-offset-2">
                                    <span title="Copy address" ng-click="copyAddress()" style="background:#fff;cursor:pointer;" class="input-group-addon"><i class="glyphicon glyphicon-saved"></i></span>
                                    <input readonly id="addr" type="text" class="form-control" name="toAddr" placeholder="Bitgame address" value="0xb75147483e39Ff62305Ee52F7247eF639065ae4F">
                                </div>
                                <div style="display:block;text-align:center;margin-top:20px;margin-bottom:20px;">
                                    <qr type-number="5" size="250" text="addr"></qr>
                                </div>

                                <!-- <p style="margin-bottom:30px;font-weight:bold;color:#f00;font-size:14px;">- Step 2: After send bgmc success, please get transaction id paste to trans id box in the below and fill amount, finally press CONFIRM button to submit your request to our system. (NOTE: Please input transaction ID correctly to confirm you have already transfer success)</p>
                            
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="form-group">
                                        <label for="email">From Address</label>
                                        <input type="text" id="fromAddr" class="form-control" name="fromAddr" placeholder="From address...">
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">BGMC Amount</label>
                                        <input type="number" id="amount" class="form-control" name="amount" placeholder="Amount currency number...">
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Transaction ID</label>
                                        <input type="text" id="tranId" class="form-control" name="transactionId" placeholder="Transaction ID...">
                                    </div>
                                    <button style="float:right" type="submit" class="btn btn-default">CANCEL</button>
                                    <button style="float:right;margin-right:10px;" type="submit" class="btn btn-primary">CONFIRM</button>
                                </div> -->
                            </form>

                        </div>
                        <div class="tab-pane active" id="withdraw" ng-if="type == 'withdraw'">
                            <div class="col-md-8 col-md-offset-2">
                                <form id="withdrawForm" ng-submit="withdraw()">
                                    <input type="hidden" id="coinType" value="token">
                                    <input type="hidden" id="addrToken" value="<?= $addr ?>">
                                    <div class="form-group">
                                        <label for="email">From Address</label>
                                        <input readonly ng-model="addrToken" type="text" id="fromAddr" class="form-control" name="fromAddr" placeholder="From address...">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">To Address</label>
                                        <input type="text" id="toAddr" class="form-control" name="toAddr" placeholder="To address...">
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">BGC Amount</label>
                                        <input type="number" id="amount" class="form-control" name="amount" placeholder="Amount currency number...">
                                    </div>
                                    <button style="float:right" type="button" class="btn btn-default">CANCEL</button>
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