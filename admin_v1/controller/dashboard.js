/*******************************NgAPP****************************************************/

angular.module('dashboard',[])

  .controller('dashboard', function($scope, $rootScope, $http, $location,$timeout,$interval,$window){

    $.ajax({
   				method  : 'POST',
   				url     : $rootScope._data.server_url + 'dashboard',
   				data    : $.param({}),
   				headers : { 'Content-Type': 'application/x-www-form-urlencoded' }

   			}).then(function(data,txt_status) {
   							data=JSON.parse(data);
   							$scope.total_users=data.body.users;
   							$rootScope.total_ad=data.body.ad;
   							$scope.total_sold=data.body.sold;
   							$scope.total_category=data.body.category;
   							$scope.$apply();
   				}),function errorCallback(data) {
   						alert(data.message);
   				}

          $scope.go=function(data){
              $location.path("/"+data);
          }


  })
