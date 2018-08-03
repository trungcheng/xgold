<div class="container" ng-controller="StatisticalController" ng-init="loadInit()">

    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box" style="min-height:65px;">
                <div class="pull-left">
                    <h4 class="page-title">Statistical</h4>                                    
                </div>
                <div class="pull-right price_box">
                    <p>
                        <i class="mdi mdi-gift"></i> Total BGMC: <span><b><?= $tokenCount ?></b> BGMC</span>
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
    </div>    

    <!-- end row -->
    <div class="row">
        <div class="table-responsive" style="margin-left:10px;margin-right:10px;border:none;">
            <input type="text" id="daterange" class="form-control" style="width:310px;float:right;margin-bottom:10px;" />
            <table ng-cloak class="table table-hover table-striped">
                <thead>
                    <th>Time / Currency</th>
                    <th ng-if="coin !== 'token'" ng-repeat="coin in coins">{{ coin.toUpperCase() }} (Nạp | Rút)</th>
                    <th ng-if="coin == 'token'" ng-repeat="coin in coins">{{ coin.toUpperCase() }} (Mua)</th>
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

                    <div ng-if="loading">
                        <i style="font-size:40px;position:fixed;left:50%;top:35%;z-index:99;" class="fa fa-spinner fa-spin"></i>
                    </div>

                    <div ng-if="!loading && items.length === 0">
                        <h5 style="font-size:17px;color:#f00;margin-bottom:30px;margin-top:10px;">Oops! Không tìm thấy lịch sử giao dịch nào!</h5>
                    </div>

                </tbody>
            </table>
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