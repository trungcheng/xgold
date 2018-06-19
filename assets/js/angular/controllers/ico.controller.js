(function() {
    'use strict';

    angular
        .module('Xgold')
        .controller('IcoController', IcoController);

    function IcoController($rootScope, $scope, $q, $http, $window, $timeout, $uibModal) {

        $scope.coins = [];
        $scope.transactions = [];
        $scope.loading = false;
        $scope.buy = {};

		$scope.loadInit = function () {
            $scope.loading = true;

            $scope.buy.currency = 'BTC';
		    $scope.buy.amount = 0;
		    $scope.buy.value = 0;
		    $scope.buy.bonusTotal = 0;

            var getSetting = $http.get('/api/getAllSetting');
            var getEventBonus = $http.get('/api/getEventBonus');
            var getCoinsWithoutToken = $http.get('/api/getCoinsWithoutToken');
            var getTransaction = $http.get('/api/getTokenTransaction');

            $q.all([getSetting, getEventBonus, getCoinsWithoutToken, getTransaction]).then(function (response) {
            	$scope.buyInfo = response[0].data.data[0];
            	$scope.buy.bonus = response[1].data.bonus;
            	$scope.coins = response[2].data.data;
            	$scope.transactions = response[3].data.data;
                angular.forEach($scope.coins, function (v, k) {
                	if (v.coin_type == 'btc') {
                		$scope.buy.fromAddress = v.coin_addr;
                	}
                });
                $scope.loading = false;
            });
        }

        $scope.changeCurrency = function (coin) {
        	$scope.buy.fromAddress = coin.coin_addr;
        	$scope.buy.currency = coin.coin_type.toUpperCase();
        	$scope.changeAmount();
        }

        $scope.changeAmount = function () {
	        $scope.buy.value = $scope.buy.amount / $scope.buyInfo[$scope.buy.currency.toLowerCase()+'_rate'];
	        $scope.buy.bonusTotal = $scope.buy.amount * $scope.buy.bonus / 100;
	    };

	    $scope.changeValue = function () {
	        $scope.buy.amount = $scope.buy.value * $scope.buyInfo[$scope.buy.currency.toLowerCase()+'_rate'];
	        $scope.buy.bonusTotal = $scope.buy.amount * $scope.buy.bonus / 100;
	    };

	    $scope.buyIco = function () {
	    	$scope.buyLoading = true;
	    	$http.post('/ico/buy', $scope.buy).success(function (response) {
	    		$timeout(function() {
	    			$scope.buyLoading = false;
		    		if (response.status) {
		    			$scope.loadInit();
		    			toastr.success(response.message, 'SUCCESS');
		    		} else {
		    			toastr.error(response.message, 'ERROR');
		    		}
	    		}, 1000);
	    	});
	    }

	}
})();
