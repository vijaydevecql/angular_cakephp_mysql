/*******************************NgAPP****************************************************/

angular.module('profile',[])

/***************************************** profile controller here **********************************/
.controller('profile', function($scope, $rootScope, $http, $location,$timeout,$interval,$window){
    $scope.logout=function(){
    	window.localStorage.setItem('admin_info','');
    	$rootScope.login=1;
    }
    $scope.isCurrentPath = function () {
     return $location.path() ;
    };
})
