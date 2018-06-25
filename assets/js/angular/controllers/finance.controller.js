(function() {
    'use strict';

    angular
        .module('Bitgame')
        .controller('FinanceController', FinanceController);

    function FinanceController($rootScope, $scope, $q, $http, $window, $timeout, $uibModal) {

        $scope.transactions = [];
        $scope.loading = false;
        $scope.addr = '';

        $scope.loadDeposit = function () {
            $scope.type = 'deposit';
            $scope.loading = true;
            $http.get('/api/getCoinAddr?name='+$('#coinName').val())
                .success(function (response) {
                    $scope.addr = response.data.coin_addr;
                    $scope.balance = response.data.balance;
                    $scope.coinName = $('#coinName').val().toUpperCase();
                    $scope.loading = false;
                });
        }

        $scope.loadWithdraw = function () {
            $scope.type = 'withdraw';
        }

        $scope.loadHistory = function () {
            $scope.type = 'transaction history';
            $scope.loading = true;
            $http.get('/api/getTransactions?coinType='+$('#typeCoin').val())
                .success(function (response) {
                    $scope.transactions = response.data;
                    $scope.loading = false;
                });
        }

        $scope.copyAddress = function () {
            var copyText = document.getElementById("addr");
            copyText.select();
            document.execCommand("copy");
            toastr.success('Copied!', 'SUCCESS');
        }

        $scope.confirmDeposit = function () {

            swal({
                title: "Bạn chắc chắn đã hoàn tất và sẽ xác nhận ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: 'Confirm now',
                cancelButtonText: "Back",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                var data = {
                    fromAddr: $('#fromAddr').val(),
                    toAddr: $('#addr').val(),
                    amount: $('#amount').val(),
                    tranId: $('#tranId').val(),
                    coinType: $('#coinType').val()
                }
                $http({
                    url: '/finance/submitDeposit',
                    method: 'POST',
                    data: JSON.stringify(data),
                    headers : { 'Content-Type' : 'application/json' }
                }).success(function (response) {
                    swal({ title: '', text: response.message, type: response.type }, function (isConfirm) {
                        $('#depositForm')[0].reset();
                    });
                });
            });

        }

        $scope.withdraw = function () {

            swal({
                title: "Bạn chắc chắn đã hoàn tất và sẽ thực hiện rút ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: 'Withdraw',
                cancelButtonText: "Back",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                var data = {
                    fromAddr: $('#fromAddr').val(),
                    toAddr: $('#toAddr').val(),
                    amount: $('#amount').val(),
                    coinType: $('#coinType').val()
                }
                $http({
                    url: '/finance/submitWithdraw',
                    method: 'POST',
                    data: JSON.stringify(data),
                    headers : { 'Content-Type' : 'application/json' }
                }).success(function (response) {
                    swal({ title: '', text: response.message, type: response.type }, function (isConfirm) {
                        // $('#withdrawForm')[0].reset();
                    });
                });
            });

        }

	}
})();
