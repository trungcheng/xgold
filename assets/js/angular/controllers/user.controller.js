(function() {
    'use strict';

    angular
        .module('Bitgame')
        .controller('UserController', UserController);

    function UserController($rootScope, $scope, $http, $window, $timeout, $uibModal) {

        $scope.users = [];
        $scope.loading = false;

        $scope.getResultPage = function (name) {
            $scope.loading = true;

            $timeout(function() {
                $http.get('/user/getAll?name='+name).success(function (response) {
                    $scope.name = name;
                    $scope.users = response.data;
                    $scope.loading = false;
                });
            }, 500)
        }

		$scope.loadInit = function () {
            $scope.getResultPage('all-user');
        }

        $scope.search = function () {
            if ($scope.textUser.length >= 2) {
                $scope.getResultPage($scope.textUser);
            } else {
                $scope.loadInit();
            }
        }

        $scope.addUser = function () {
            var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'popup-add.html',
                scope: $scope,
                controller: ModalInstanceAddCtrl
            });
        }

        var ModalInstanceAddCtrl = function ($scope, $uibModalInstance) {

            $scope.userModalAdd = {};
            $scope.userModalAdd.selectedOption = 'Admin';

            $scope.close = function () {
                $uibModalInstance.dismiss('cancel');
            };

            $scope.add = function () {
                swal({
                    title: "Are you sure you want to add this user ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-info",
                    confirmButtonText: 'Add now',
                    cancelButtonText: "Back",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                }, function () {
                    $http({
                        method: 'POST',
                        url: '/user/create',
                        headers: {'Content-Type': 'application/json'},
                        data: JSON.stringify($scope.userModalAdd)
                    }).success(function (response) {
                        swal({ title: '', text: response.message, type: response.type }, function (isConfirm) {
                            if (isConfirm) {
                                if (response.status) {
                                    $scope.close();
                                    toastr.success(response.message, 'SUCCESS');
                                    $scope.loadInit();
                                } else {
                                    toastr.error(response.message, 'ERROR');
                                }
                            }
                        })
                    });
                });
            }
        }

        $scope.editUser = function (user) {
            var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'popup-edit.html',
                scope: $scope,
                controller: ModalInstanceEditCtrl,
                resolve: {
                    user: function () {
                        return user;
                    }
                }
            });
        }

        var ModalInstanceEditCtrl = function ($scope, $uibModalInstance, user) {
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

        $scope.deleteUser = function (user) {
            swal({
                title: "Are you sure to delete this user ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: 'Delete now',
                cancelButtonText: "Back",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                $http({
                    url: '/user/delete',
                    method: 'DELETE',
                    headers: {'Content-Type': 'application/json'},
                    data: JSON.stringify(user)
                }).success(function (response) {
                    swal({ title: '', text: response.message, type: response.type }, function (isConfirm) {
                        if (isConfirm) {
                            if (response.status) {
                                $scope.loadInit();
                            }
                        }
                    })
                });
            });
        }

	}
})();
