/*******************************NgAPP****************************************************/

angular.module('plan',[])

/***************************************** plan controller here **********************************/
.controller('plan', function($scope, $rootScope, $http, $location,$timeout,$interval,$window){
/** code here   ****/
$rootScope.all_plan=[];
$rootScope.buy_plan=[];
$rootScope.transaction=[];
$.ajax({
    type:'get',
    url: $rootScope._data.server_url+'get_all_plan/',
    data:0,
    cache:false,
    contentType: false,
    processData: false,
    success:function(data){
      data=JSON.parse(data);
      $rootScope.all_plan=data.body;
      $scope.$apply();
    },
    error: function(data){
      $("#avc").attr('disabled',false);
      data  =JSON.parse(data.responseText);
      $("#ptoast").css('background-color','red');
      $("#ptoast").html(data.error_message);
      $("#ptoast").addClass('show');
      $timeout(function() {   $("#ptoast").removeClass('show');
      }, 3000);
    }
});


$scope.plan_added=function(){
  $.ajax({
      type:'POST',
      url: $rootScope._data.server_url+'add_data/',
      data:{name:$scope.name,model:'Plan',price:$scope.price,description:$scope.description,time:$scope.time},
      success:function(data){
        data=JSON.parse(data);
        $("#ptoast").css('background-color','green');
        $("#ptoast").html("Add Successfully");
        $("#ptoast").addClass('show');
        $location.path("/plan");
        $scope.$apply();
        $timeout(function() {   $("#ptoast").removeClass('show');
      }, 3000);
      },
      error: function(data){
        $("#avc").attr('disabled',false);
        data  =JSON.parse(data.responseText);
        $("#ptoast").css('background-color','red');
        $("#ptoast").html(data.error_message);
        $("#ptoast").addClass('show');
        $timeout(function() {   $("#ptoast").removeClass('show');
      }, 3000);
      }
  });
}

/*********** delete function here ***************/
$scope.delete=function(user){
  console.log(user);
  swal({
      title: "Are you sure want delete "+user.name+" ?",
      text: "",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
            type:'post',
            url: $rootScope._data.server_url+'delete_data/',
            data:$.param({id:user.id,model:'Plan'}),
            success:function(data){
              swal("Plan! "+user.name+" has been deleted!", {
                icon: "success",
              });
              user = $rootScope.all_plan.indexOf(user);
              $rootScope.all_plan.splice(user, 1);
              $scope.$apply();
            },
            error: function(data){
              $("#avc").attr('disabled',false);
              data  =JSON.parse(data.responseText);
              $("#ptoast").css('background-color','red');
              $("#ptoast").html(data.error_message);
              $("#ptoast").addClass('show');
              $timeout(function() {   $("#ptoast").removeClass('show');
              }, 3000);
            }
        });

      } else {
        swal(""+user.name+" is safe!");
      }
    });
}

/*** status update function *****/
$scope.update_status=function(user){
    if(user.status==1){
        user.status=0;
    }else{
          user.status=1;
    }
      $.ajax({
          type:'post',
          url: $rootScope._data.server_url+'update_status/',
          data:$.param({id:user.id,status:user.status,model:'Plan'}),
          success:function(data){
          },
          error: function(data){
            $("#avc").attr('disabled',false);
            data  =JSON.parse(data.responseText);
            $("#ptoast").css('background-color','red');
            $("#ptoast").html(data.error_message);
            $("#ptoast").addClass('show');
            $timeout(function() {   $("#ptoast").removeClass('show');
            }, 3000);
          }
      });
}

$scope.type_add=function(){
  $location.path("/add_plan");
}
$scope.edit=function(user){
    $scope.name=user.name;
    $scope.price=parseInt(user.price);
    $scope.description=user.description;
    $scope.time=parseInt(user.time);
    $scope.plan=user;
    $("#add-contact").modal('show');
}

$scope.plan_update=function(user){
  $.ajax({
      type:'POST',
      url: $rootScope._data.server_url+'add_data/',
      data:{name:$scope.name,model:'Plan',id:user.id,description:$scope.description,price:$scope.price,time:$scope.time},
      success:function(data){
        user.name=$scope.name;
        user.price=$scope.price;
        user.description=$scope.description;
        user.time=$scope.time;
        data=JSON.parse(data);

        $("#add-contact").modal('hide');
        $("#ptoast").css('background-color','green');
        $("#ptoast").html("Updated Successfully");
        $("#ptoast").addClass('show');
        $scope.$apply();
        $timeout(function() {   $("#ptoast").removeClass('show');
      }, 3000);
      },
      error: function(data){
        $("#avc").attr('disabled',false);
        data  =JSON.parse(data.responseText);
        $("#ptoast").css('background-color','red');
        $("#ptoast").html(data.error_message);
        $("#ptoast").addClass('show');
        $timeout(function() {   $("#ptoast").removeClass('show');
      }, 3000);
      }
  });
}




})
