/**
 * Created by User on 17.02.2017.
 */

var app = angular.module('app', []);
app.controller('UsersCtrl', function ($scope, $http) {
    $http.get('/api/users').then(successCallback, errorCallback);
    function successCallback(data){
        $scope.users = data.data;
    }
    function errorCallback(error){
    }
});