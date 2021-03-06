<div class="container" ng-controller="StatisticalController" ng-init="loadInit()">

    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box" style="min-height:65px;">
                <div class="pull-left">
                    <h4 class="page-title">Statistical</h4>                                    
                </div>
                <div class="pull-right price_box">
                    <p>
                        <i class="mdi mdi-gift"></i> Total BGC: <span><b><?= $tokenCount ?></b> BGC</span>
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

    <!-- end row -->
    <div class="row">
        <div class="table-responsive" style="margin-left:10px;margin-right:10px;border:none;">
            <input type="text" id="daterange" class="form-control" style="width:310px;float:right;margin-bottom:10px;" />
            <table ng-cloak class="table table-hover table-striped">
                <thead>
                    <th>Time / Currency</th>
                    <th ng-if="coin !== 'token'" ng-repeat="coin in coins">{{ coin.toUpperCase() }} (Dep | Wdr)</th>
                    <th ng-if="coin == 'token'" ng-repeat="coin in coins">{{ coin.toUpperCase() }} (Buy)</th>
                </thead>
                <tbody>
                    <tr ng-cloak ng-repeat="item in items track by $index">
                        <th>{{ item._id.time }}</th>
                        <td ng-if="coin !== 'token'" ng-repeat="coin in coins">
                            {{ item[coin+'_deposit'] + ' | ' + item[coin+'_withdraw'] }}
                        </td>
                        <td ng-if="coin == 'token'" ng-repeat="coin in coins">
                            {{ item[coin+'_buy'] }}
                        </td>
                    </tr>
                    <tr>
                        <td style="color:#f00;font-weight:bold;">Total: </td>
                        <td style="color:#f00;font-weight:bold;" ng-if="coin !== 'token'" ng-repeat="coin in coins">
                            {{ total[coin+'_total_dep'] + ' | ' + total[coin+'_total_wdr'] }}
                        </td>
                        <td style="color:#f00;font-weight:bold;" ng-if="coin == 'token'" ng-repeat="coin in coins">
                            {{ total[coin+'_total_buy'] }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div ng-if="loading">
                <i style="font-size:40px;position:fixed;left:50%;top:35%;z-index:99;" class="fa fa-spinner fa-spin"></i>
            </div>

            <div ng-cloak ng-if="!loading && items.length === 0">
                <h5 style="font-size:17px;color:#f00;margin-bottom:30px;margin-top:10px;">Oops! Không tìm thấy lịch sử giao dịch nào!</h5>
            </div>

        </div>
    </div>

</div> <!-- container -->

<script type="text/javascript">
    $('#daterange').daterangepicker({
        opens: 'left',
        timePicker: true,
        timePicker24Hour: true,
        timePickerSeconds: true,
        endDate: moment().format("YYYY/MM/DD HH:mm:ss"),
        startDate: moment().subtract(7, 'day').format('YYYY/MM/DD HH:mm:ss'),
        locale: {
            format: 'YYYY/MM/DD HH:mm:ss',
            applyLabel: "Lọc",
            cancelLabel: "Trở lại"
        }
    });
</script>