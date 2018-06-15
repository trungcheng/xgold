(function() {
    'use strict';

    angular
        .module('Xgold')
        .controller('EventController', EventController);

    function EventController($rootScope, $scope, $http, $window, $timeout, $uibModal) {

        $scope.events = [];
        $scope.loading = false;

		$scope.loadInit = function () {
            $scope.loading = true;

            $timeout(function() {
                $http.get('/event/getAll').success(function (response) {
                    $scope.events = response.data;
                    $scope.loading = false;
                });
            }, 1000)
        }

        $scope.addEvent = function () {
            var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'popup-add.html',
                scope: $scope,
                controller: ModalInstanceAddCtrl
            });
            $timeout(function () {
                $('.datetimepicker').datetimepicker({
                    format: 'yyyy-mm-dd hh:ii:ss'
                });
            },1000)
        }

        var ModalInstanceAddCtrl = function ($scope, $uibModalInstance) {

            $scope.eventModalAdd = {};
            $scope.eventModalAdd.selectedOption = 'Yes';

            $scope.close = function () {
                $uibModalInstance.dismiss('cancel');
            };

            $scope.add = function () {
                $http({
                    method: 'POST',
                    url: '/event/create',
                    headers: {'Content-Type': 'application/json'},
                    data: JSON.stringify($scope.eventModalAdd)
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

        $scope.editEvent = function (event) {
            var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'popup-edit.html',
                scope: $scope,
                controller: ModalInstanceEditCtrl,
                resolve: {
                    event: function () {
                        return event;
                    }
                }
            });
            $timeout(function () {
                $('.datetimepicker').datetimepicker({
                    format: 'yyyy-mm-dd hh:ii:ss'
                });
            },100)
        }

        var ModalInstanceEditCtrl = function ($scope, $uibModalInstance, event) {
            $scope.eventModal = event;
            $scope.eventModal.selectedOption = (event.is_selected) ? 'Yes' : 'No';

            $scope.close = function () {
                $uibModalInstance.dismiss('cancel');
            };

            $scope.update = function () {
                $http({
                    method: 'PUT',
                    url: '/event/update',
                    headers: {'Content-Type': 'application/json'},
                    data: JSON.stringify($scope.eventModal)
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

        $scope.deleteEvent = function (event) {
            swal({
                title: "Bạn chắc chắn muốn xóa event này ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: 'Xóa ngay',
                cancelButtonText: "Quay lại",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                $http({
                    url: '/event/delete',
                    method: 'DELETE',
                    headers: {'Content-Type': 'application/json'},
                    data: JSON.stringify(event)
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
