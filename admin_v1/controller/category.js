/*******************************NgAPP****************************************************/

angular.module('category',[])

  .controller('category', function($scope, $rootScope, $http, $location,$timeout,$interval,$window){
    $rootScope.all_cat=[];
    $.ajax({
        type:'get',
        url: $rootScope._data.server_url+'get_all_category/',
        data:0,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data){
          data=JSON.parse(data);
          $rootScope.all_cat=data.body;
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

    $scope.type_add=function(){
      $location.path("/add_type");
    }

    /*************add type function is here *****************/

    $scope.type_added=function(){
      $.ajax({
          type:'POST',
          url: $rootScope._data.server_url+'add_data/',
          data:{name:$scope.name,model:'Type',category_id:$scope.category_id},
          success:function(data){
            data=JSON.parse(data);
            $("#ptoast").css('background-color','#333');
            $("#ptoast").html("Add Successfully");
            $("#ptoast").addClass('show');
            $location.path("/type");
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
              data:$.param({id:user.id,status:user.status,model:'Category'}),
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

    /*** status update type function *****/
    $scope.update_status_type=function(user){
        if(user.status==1){
            user.status=0;
        }else{
              user.status=1;
        }
          $.ajax({
              type:'post',
              url: $rootScope._data.server_url+'update_status/',
              data:$.param({id:user.id,status:user.status,model:'Type'}),
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
                data:$.param({id:user.id,model:'Category'}),
                success:function(data){
                  swal("Category! "+user.name+" has been deleted!", {
                    icon: "success",
                  });
                  user = $rootScope.all_cat.indexOf(user);
                  $rootScope.all_cat.splice(user, 1);
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
        $scope.name=user.name;
        $scope.user=user;
        $("#add-contact").modal('show');
    }

    $scope.add_cat=function(user){
      $.ajax({
          type:'POST',
          url: $rootScope._data.server_url+'add_data/',
          data:{name:$scope.name,model:'Category',id:user.id},
          success:function(data){
            user.name=$scope.name;
            data=JSON.parse(data);

            $("#add-contact").modal('hide');
            $("#ptoast").css('background-color','#333');
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

    /**************************** edit type ****************************/
    $scope.edit_type=function(user){
      console.log(user);
      $scope.name=user.name;
      $scope.type=user;
      $scope.category_id=user.category_id;
      $scope.user=user;
      $("#add-contact").modal('show');
    }

  
    /********************** update type **********************/
      $scope.update_type=function(user){
        $.ajax({
            type:'POST',
            url: $rootScope._data.server_url+'add_data/',
            data:{name:$scope.name,category_id:$scope.category_id,model:'Type',id:user.id},
            success:function(data){
              user.name=$scope.name;
              data=JSON.parse(data);
              $("#add-contact").modal('hide');
              $("#ptoast").css('background-color','#333');
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


    /***************** add cat********************************/

    $scope.add=function(){
      swal({
  text: 'Add New Category".',
  content: "input",
  button: {
    text: "Add",
    closeModal: false,
  },
})
.then(name => {
  if (!name) throw null;
  $.ajax({
      type:'POST',
      url: $rootScope._data.server_url+'add_data/',
      data:{name:name,model:'Category'},

      success:function(data){
        data=JSON.parse(data);
        new_data={
          "id":data.body.id,
          "name":name,
          "status":1,
          "created":"",
          "modified":"",
        }
        swal.close();
        $rootScope.all_cat.unshift(new_data);
        $("#ptoast").css('background-color','#333');
        $("#ptoast").html(data.message);
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

})

.catch(err => {
  if (err) {
    swal("Oh noes!", "The AJAX request failed!", "error");
  } else {
    swal.stopLoading();
    swal.close();
  }
});

    }
    $rootScope.all_type=[];
    $.ajax({
        type:'get',
        url: $rootScope._data.server_url+'get_all_type?is_admin=true',

        cache:false,
        contentType: false,
        processData: false,
        success:function(data){
          data=JSON.parse(data);
          $rootScope.all_type=data.body;
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

    /*********** delete type function here ***************/
    $scope.delete_type=function(user){
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
                data:$.param({id:user.id,model:'Type'}),
                success:function(data){
                  swal("Type! "+user.name+" has been deleted!", {
                    icon: "success",
                  });
                  user = $rootScope.all_type.indexOf(user);
                  $rootScope.all_type.splice(user, 1);
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




  })
