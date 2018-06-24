(function() {
    'use strict';

    angular
        .module('Xgold')
        .controller('StatisticalController', StatisticalController);

    function StatisticalController($rootScope, $scope, $q, $http, $window, $timeout, $uibModal) {

        $scope.items = [];
        $scope.coins = ['btc', 'eth', 'ltc', 'bch', 'token'];
        $scope.loading = false;

        $scope.getResultsPage = function (date) {
            $scope.loading = true;

            $http.get('/statistical/countDataByDateRange?date='+date).success(function (response) {
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
