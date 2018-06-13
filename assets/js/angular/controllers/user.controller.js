(function() {
    'use strict';

    angular
        .module('Xgold')
        .controller('UserController', UserController);

    function UserController($rootScope, $scope, $http, $window, $timeout, $uibModal) {

        $scope.users = [];
        $scope.loading = false;

		$scope.loadInit = function () {
            $scope.loading = true;

            $timeout(function() {
                $http.get('/user/getAll').success(function (response) {
                    $scope.users = response.data;
                    $scope.loading = false;
                });
            }, 1000)
        }

        $scope.editUser = function (user) {
            var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'popup-edit.html',
                scope: $scope,
                controller: ModalInstanceCtrl,
                resolve: {
                    user: function () {
                        return user;
                    }
                }
            });
        }

        var ModalInstanceCtrl = function ($scope, $uibModalInstance, user) {
            $scope.userModal = user;
            $scope.userModal.selectedOption = (user.is_admin) ? 'Admin' : 'User';

            $scope.close = function () {
                $uibModalInstance.dismiss('cancel');
            };

            $scope.update = function () {
                $http({
                    method: 'POST',
                    url: '/user/update',
                    headers: {'Content-Type': 'application/json'},
                    data: JSON.stringify($scope.userModal)
                }).success(function (response) {
                    if (response.status) {
                        $scope.close();
                        toastr.success(response.message, 'SUCCESS');
                        $scope.loadInit();
                    } else {
                        toastr.error(response.message, 'ERROR');
                    }
                });
            }
        }

	}
})();
