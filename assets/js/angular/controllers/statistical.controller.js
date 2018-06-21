(function() {
    'use strict';

    angular
        .module('Xgold')
        .controller('StatisticalController', StatisticalController);

    function StatisticalController($rootScope, $scope, $q, $http, $window, $timeout, $uibModal) {

        $scope.items = [];
        $scope.coins = ['btc', 'eth', 'ltc', 'bch', 'token'];
        $scope.loading = false;

		$scope.loadInit = function () {
            $scope.loading = true;

            $http.get('/statistical/countDataByDateRange').success(function (response) {
            	$scope.items = response.data;
                angular.forEach($scope.items, function (v, k) {
                    v.time = v._id.year+'-'+formatDate(v._id.month)+'-'+formatDate(v._id.day)+' '+formatDate(v._id.hour)+':'+formatDate(v._id.minute)+':'+formatDate(v._id.second);
                });
                $scope.loading = false;
            });
        }

	}
})();
