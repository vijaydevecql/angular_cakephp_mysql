/*******************************NgAPP****************************************************/

angular.module("admin.controller", [])

  .controller('login', function($scope, $rootScope, $http, $location,$timeout,$interval,$window){
    $rootScope.admin_info={};

    $scope.login=function(){
      $.ajax({
      			  method  : 'POST',
      			  url     : $rootScope._data.server_url + 'AdminLogin',
      			  data    : $.param({email:$scope.email,password:$scope.password}),
              success:function(data) {
                    data=JSON.parse(data);
                    $rootScope.login=0;
                    window.localStorage.setItem('admin_info',JSON.stringify(data.body));
                    $rootScope.admin_info=data.body;
                    //$("#ptoast").css('background-color','#a4bb80');
                    $("#ptoast").html("Welcome "+data.body.first_name+' '+data.body.last_name);
                    $("#ptoast").addClass('show');
                    $timeout(function() {   $("#ptoast").removeClass('show');
                  }, 4000);
                    $location.path('/dashboard1');
                    $scope.$apply();
      				},
                error: function(data){
                  aler(data);
                  data  =JSON.parse(data.responseText);
                  $("#ptoast").css('background-color','red');
                  $("#ptoast").html(data.error_message);
                  $("#ptoast").addClass('show');
                  $timeout(function() {   $("#ptoast").removeClass('show');
                  }, 3000);
                }
              });
            }
              $scope.total_users=0;
              $scope.total_ad=0;
              $scope.total_sold=0;
              $scope.total_category=0;

  })
