(function() {
    'use strict';

    angular
        .module('Xgold')
        .controller('RefController', RefController);

    function RefController($rootScope, $scope, $q, $http, $window, $timeout, $uibModal) {

        $scope.refs = [];
        $scope.loading = false;

		$scope.loadInit = function () {
            $scope.loading = true;

            $http.get('/api/getRefs').success(function (response) {
            	$scope.refs = response.data;
                $scope.loading = false;
            });
        }

        $scope.seeAct = function (ref) {
            var uibModalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'activity.html',
                scope: $scope,
                controller: ModalInstanceCtrl,
                resolve: {
                    ref: function () {
                        return ref;
                    }
                }
            });
        }

        var ModalInstanceCtrl = function ($scope, $uibModalInstance, ref) {

            $scope.close = function () {
                $uibModalInstance.dismiss('cancel');
            };

            $scope.refModal = ref;
            $http.get('/api/getRefTransaction/'+ref.user_id).success(function (response) {
                if (response.status) {
                    $scope.refModal.trans = response.data;
                }
            });

        }

	}
})();
