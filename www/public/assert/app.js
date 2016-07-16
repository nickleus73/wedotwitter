var app = angular.module('app', [ ]);

$(document).ready(function () {
    angular.bootstrap(document, ['app']);
});

app.controller('SearchCtrl', ['$scope', '$search', function($scope, $search) {
    $scope.error = false;
    $scope.search = null;
    $scope.results = [];

    $scope.submitted = function() {
        $search.search($scope.search).then(function(response) {
            if(response.error) {
                $scope.error = response.error;
                return;
            }

            $scope.results = response.statuses;
        });
    };
}]);

app.factory('$search', ['$http', '$q', function($http, $q) {
    var res = {};
    var current_search = null;

    return {
        search: function(data) {
            var deferred = $q.defer();

            current_search = data;

            $http.post('/api/v1/tweets', {
                search: current_search,
                count: 50
            }).then(function(response) {
                res = response.data;
                deferred.resolve(response.data);
            });

            return deferred.promise;
        }
    }
}]);