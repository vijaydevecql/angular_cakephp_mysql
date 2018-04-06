/*******************************NgAPP****************************************************/

angular.module('users',['oitozero.ngSweetAlert'])

/***************************************** User controller here **********************************/
.controller('Users', function($scope, $rootScope, $http, $location,$timeout,$interval,$window,SweetAlert){

  $rootScope.all_user=[];
  $.ajax({
      type:'get',
      url: $rootScope._data.server_url+'get_all_users/',
      data:0,
      cache:false,
      contentType: false,
      processData: false,
      success:function(data){
        data=JSON.parse(data);
        $rootScope.all_user=data.body;
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

  /*************** update profile ********************/

  $scope.Update_profile=function(user){
    $.ajax({
        type:'POST',
        url: $rootScope._data.server_url+'add_data/',
        data:{name:user.name,model:'User',id:user.id,city:user.city,state:user.city,zip_code:user.zip_code,user_type:user.user_type},
        success:function(data){
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
            data:$.param({id:user.id,status:user.status,model:'User'}),
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
  /*********** delete function here ***************/
  $scope.delete=function(user){
    console.log(user);
    swal({
        title: "Are you sure want delete?"+user.name,
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
              data:$.param({id:user.id,model:'User'}),
              success:function(data){
                swal("Poof!"+user.name+" has been deleted!", {
                  icon: "success",
                });
                user = $rootScope.all_user.indexOf(user);
                $rootScope.all_user.splice(user, 1);
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

  $scope.edit=function(user){
      $scope.edit_user=user;
      $("#add-contact").modal('show');
  }


  $scope.done=function(){
    $("#avc").attr('disabled',true);
    var data= new FormData();
    data.append('name',$scope.name);
    data.append('email',$scope.email);
    data.append('phone',$scope.phone);
    data.append('user_type',$scope.user_type);
    data.append('city',$scope.city);
    data.append('state',$scope.state);
    data.append('zip_code',$scope.zip_code);
    file=$("#photo").prop('files')[0]; ;
    data.append('photo',file);
    $.ajax({
        type:'POST',
        url: $rootScope._data.server_url+'user_signup/',
        data:data,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data){
          $("#avc").attr('disabled',false);
          data=JSON.parse(data);
          $("#ptoast").css('background-color','#333');
          $("#ptoast").html(data.message);
          $("#ptoast").addClass('show');
          $location.path("/users");
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
