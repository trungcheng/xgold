(function() {
    'use strict';

    angular
        .module('Bitgame')
        .controller('StatisticalController', StatisticalController);

    function StatisticalController($rootScope, $scope, $q, $http, $window, $timeout, $uibModal) {

        $scope.items = [];
        $scope.coins = ['btc', 'eth', 'ltc', 'bch', 'token'];
        $scope.loading = false;

        $scope.total = {
            btc_total_dep: 0, btc_total_wdr: 0,
            eth_total_dep: 0, eth_total_wdr: 0,
            ltc_total_dep: 0, ltc_total_wdr: 0,
            bch_total_dep: 0, bch_total_wdr: 0,
            token_total_buy: 0,
        }

        $scope.getResultsPage = function (date) {
            $scope.loading = true;

            $http.get('/statistical/countDataByDateRange?date='+date).success(function (response) {

                angular.forEach(response.data, function (item) {
                    angular.forEach($scope.coins, function (coin) {
                        if (coin !== 'token') {
                            $scope.total[coin+'_total_dep'] += item[coin+'_deposit'];
                            $scope.total[coin+'_total_wdr'] += item[coin+'_withdraw'];
                        } else {
                            $scope.total[coin+'_total_buy'] += item[coin+'_buy'];
                        }
                    });
                });

                $scope.items = response.data;

                $scope.loading = false;
            });
        }

		$scope.loadInit = function () {
            var startDate = moment().subtract(7, 'day').format('YYYY-MM-DD HH:mm:ss');
            var endDate = moment().format('YYYY-MM-DD HH:mm:ss');
            $scope.getResultsPage(startDate + ',' + endDate);
        }

        $('#daterange').on('apply.daterangepicker', function (ev, picker) {
            var start_time = $(this).data('daterangepicker').startDate.format('YYYY-MM-DD HH:mm:ss');
            var end_time = $(this).data('daterangepicker').endDate.format('YYYY-MM-DD HH:mm:ss');
            var date = start_time + ',' + end_time;
            $scope.getResultsPage(date);
        });

        $('#daterange').on('cancel.daterangepicker', function (ev, picker) {
            var start_date = moment().subtract(7, 'day').format('YYYY/MM/DD HH:mm:ss');
            var end_date = moment().format('YYYY/MM/DD HH:mm:ss');
            $('#daterange').val(start_date + ' - ' + end_date);
            $scope.getResultsPage('all-date');
        });

	}
})();
