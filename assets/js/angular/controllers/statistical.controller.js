(function() {
    'use strict';

    angular
        .module('Xgold')
        .controller('StatisticalController', StatisticalController);

    function StatisticalController($rootScope, $scope, $q, $http, $window, $timeout, $uibModal) {

        $scope.items = [];
        $scope.loading = false;

		$scope.loadInit = function () {
            $scope.loading = true;

            $http.get('/statistical/countDataByDateRange').success(function (response) {
            	$scope.items = response.data;
                $scope.loading = false;
            });
        }

	}
})();
