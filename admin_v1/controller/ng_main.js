/*******************************NgAPP****************************************************/
var mainApp = angular.module("mainApp", ['ngRoute','ngTouch','ngAnimate','ui.bootstrap','ui.multiselect','ui.calendar', 'angularMoment','autocomplete','ngMap']);

mainApp.factory('Globals', function() { 

return {  ServerPath : 'http://202.164.42.226/staging/mertol_event/api/'};}   );

mainApp.run(function ($rootScope, $location) {
	if(window.localStorage.getItem("id")!=null && window.localStorage.getItem("id")!=undefined && window.localStorage.getItem("id")!=''){
		$location.path("/home");
	}else{
		$location.path("/welcome");
	}
	$rootScope.IsRemember=window.localStorage.getItem('IsRemember');
});
/************ the service that retrieves some movie title from an url*************/

mainApp.factory('MovieRetriever', function($http, $q, $timeout,Globals){
  var MovieRetriever = new Object();

  MovieRetriever.getmovies = function(i) {
    
    var moreMovies = new Array();
    $http({  
		method  : 'POST',
		url     : Globals.ServerPath + 'getalleventlocation.php',
		data    : $.param({}),  // pass in data as strings
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
		// set the headers so angular passing info as form data (not request payload)
	}).success(function(data) {
		if(data.status.code == 1){
			for(var i=0; i<data.body.length; i++){
				moreMovies.push(data.body[i].location);
			}
		}	
	});

    
    var moviedata = $q.defer();
    var movies;

    if(i && i.indexOf('T')!=-1)
      movies=moreMovies;
    else
      movies=moreMovies;

    $timeout(function(){
      moviedata.resolve(movies);
    },1000);

    return moviedata.promise
  }

  return MovieRetriever;
});


/*****************************************Routing*****************************************************/



mainApp.config(function($routeProvider) {
    $routeProvider
   .when('/home', {
            templateUrl: 'html/login.html',
             controller: 'welcomeController',
             
			  animate: "fadeClass"		 
        })
   .when('/signup', {
            templateUrl: 'html/signup.html',
             controller: 'signup',
            
			animate: "fadeClass"		 
        })
		.when('/login', {
            templateUrl: 'html/login-form.html',
             controller: 'logind',
            
			animate: "fadeClass"		 
        })
		.when('/event', {
            templateUrl: 'html/home.html',
             controller: 'event',
            
			animate: "fadeClass"	 
        })
   .when('/search', {
            templateUrl: 'html/search-result.html',
             controller: 'event',
             
			 animate: "fadeClass"			 
        })
      .when('/save-event', {
            templateUrl: 'html/save-event.html',
             controller: 'saveevent',
             
			animate: "fadeClass" 
        })
		
		.when('/chat/:friend_id/:name', {
            templateUrl: 'html/chat.html',
            controller: 'chat',
			 animate: "fadeClass"			 
        })
     .when('/edit-profile', {
            templateUrl: 'html/edit-profile.html',
             controller: 'userprofile',
             
			animate: "fadeClass"	 
        })
		 .when('/lastchat', {
            templateUrl: 'html/lastchat.html',
             controller: 'lastchats',
             
			animate: "fadeClass"		 
        })
    .when('/catsong/:cat_id', {
            templateUrl: 'html/songcat.html',
             controller: 'catsong',
             
			 animate: "fadeClass"			 
        })
    .when('/addsong', {
            templateUrl: 'html/uploadsong.html',
            controller: 'addsong',
			 animate: "fadeClass"			 
        })
   .when('/detalis', {
            templateUrl: 'html/single-event.html',
             controller: 'event',
			 animate: "fadeClass"			 
        }).otherwise({
            redirectTo: '/home'
             })
			 .when('/detalis1', {
            templateUrl: 'html/single-event1.html',
             controller: 'saveevent',
			 animate: "fadeClass"			 
        }).otherwise({
            redirectTo: '/home'
             })
                .when('/cp', {
            templateUrl: 'html/otp.html',
             controller: 'otp',
			 animate: "fadeClass"			 
        }).otherwise({
            redirectTo: '/home'
             })
              .when('/cat', {
            templateUrl: 'html/university.html',
             controller: 'cat1',
			 animate: "fadeClass"			 
        }).otherwise({
            redirectTo: '/home'
             })      
   .when('/sign_up', {
            templateUrl: 'html/sign_up.html',
             controller: 'signupController',
			 animate: "fadeClass"			 
        }).otherwise({
            redirectTo: '/home'
        })
         
        .when('/dis', {
            templateUrl: 'html/Discription.html',
             controller: 'bookdetails',
			 animate: "fadeClass"			 
        }).otherwise({
            redirectTo: '/home'
        })
         .when('/dd/:bookid', {
            templateUrl: 'html/book_name.html',
             controller: 'single',
			 animate: "fadeClass"			 
        })
        .when('/1_university', {
            templateUrl: 'html/books.html',
             controller: 'result',
			 animate: "fadeClass"			 
        })
         .when('/edit/:book_id', {
            templateUrl: 'html/edit.html',
             controller: 'edit',
			 animate: "fadeClass"			 
        })
        
          .when('/addbook1', {
            templateUrl: 'html/add.html',
             controller: 'add',
			 animate: "fadeClass"			 
        })
        
        
        
           .when('/setting', {
            templateUrl: 'html/setting.html',
             controller: 'result',
			 animate: "fadeClass"			 
        })
        
         .when('/messagner', {
            templateUrl: 'html/messanger.html',
            controller: 'friend',
			 animate: "fadeClass"			 
        })
		.when('/quote', {
            templateUrl: 'html/postsqu.html',
            controller: 'post',
			 animate: "fadeClass"			 
        })
		.when('/inst', {
            templateUrl: 'html/picu.html',
            controller: 'post',
			 animate: "fadeClass"			 
        })
		.when('/video', {
            templateUrl: 'html/video.html',
            controller: 'post',
			 animate: "fadeClass"			 
        })
        
        
          .when('/sell', {
            templateUrl: 'html/sell.html',
           controller: 'sell',
			 animate: "fadeClass"			 
        })
         .when('/forgot', {
            templateUrl: 'html/forgot_password.html',
           controller: 'forgot',
			 animate: "fade"			 
        })
         .when('/change_pasword', {
            templateUrl: 'html/change_pasword.html',
           controller: 'changepassword',
			 animate: "fade"			 
        })
         
        
        
        .when('/1_allbook', {
            templateUrl: 'html/1_allbook.html',
             controller: '',
			 animate: "fadeClass"			 
        }).otherwise({
            redirectTo: '/home'
        });
        
});

mainApp.directive('animClass',function($route){
  return {
    link: function(scope, elm, attrs){
      var enterClass = $route.current.animate;
      elm.addClass(enterClass);
      scope.$on('$destroy',function(){
        elm.removeClass(enterClass);
        elm.addClass($route.current.animate);
      })
    }
  }
});
mainApp.directive('audios', function($sce) {
  return {
    restrict: 'A',
    scope: { code:'=' },
    replace: true,
    template: '<audio ng-src="{{url}}" controls></audio>',
    link: function (scope) {
        scope.$watch('code', function (newVal, oldVal) {
           if (newVal !== undefined) {
               scope.url = $sce.trustAsResourceUrl("/data/media/" + newVal);
           }
        });
    }
  };
});
mainApp.directive('onTouch', function() {
  return {
        restrict: 'A',
        link: function(scope, elm, attrs) {
            var ontouchFn = scope.$eval(attrs.onTouch);
            elm.bind('touchstart', function(evt) {
                scope.$apply(function() {
                    ontouchFn.call(scope, evt.which);
                });
            });
            elm.bind('click', function(evt){
                    scope.$apply(function() {
                        ontouchFn.call(scope, evt.which);
                    });
            });
        }
    };
});
mainApp.directive("calendar", function() {
    return {
        restrict: "E",
        templateUrl: "templates/calendar.html",
        scope: {
            selected: "="
        },
        link: function(scope) {
            scope.selected = _removeTime(scope.selected || moment());
            scope.month = scope.selected.clone();

            var start = scope.selected.clone();
            start.date(1);
            _removeTime(start.day(0));

            _buildMonth(scope, start, scope.month);

            scope.select = function(day) {
                scope.selected = day.date;  
            };

            scope.next = function() {
                var next = scope.month.clone();
                _removeTime(next.month(next.month()+1)).date(1);
                scope.month.month(scope.month.month()+1);
                _buildMonth(scope, next, scope.month);
            };

            scope.previous = function() {
                var previous = scope.month.clone();
                _removeTime(previous.month(previous.month()-1).date(1));
                scope.month.month(scope.month.month()-1);
                _buildMonth(scope, previous, scope.month);
            };
        }
    };
    
    function _removeTime(date) {
        return date.day(0).hour(0).minute(0).second(0).millisecond(0);
    }

    function _buildMonth(scope, start, month) {
        scope.weeks = [];
        var done = false, date = start.clone(), monthIndex = date.month(), count = 0;
        while (!done) {
            scope.weeks.push({ days: _buildWeek(date.clone(), month) });
            date.add(1, "w");
            done = count++ > 2 && monthIndex !== date.month();
            monthIndex = date.month();
        }
    }

    function _buildWeek(date, month) {
        var days = [];
        for (var i = 0; i < 7; i++) {
            days.push({
                name: date.format("dd").substring(0, 1),
                number: date.date(),
                isCurrentMonth: date.month() === month.month(),
                isToday: date.isSame(new Date(), "day"),
                date: date
            });
            date = date.clone();
            date.add(1, "d");
        }
        return days;
    }
});

mainApp.directive('googleplace', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, model) {
            var options = {
                types: [],
                componentRestrictions: {}
            };
            scope.gPlace = new google.maps.places.Autocomplete(element[0], options);

            google.maps.event.addListener(scope.gPlace, 'place_changed', function() {
                scope.$apply(function() {
                    model.$setViewValue(element.val());                
                });
            });
        }
    };
});

/********************************** addsong controller*****************************************************/
mainApp.controller('addsong', function($scope, $rootScope, $http, $location,$timeout,$interval,$window, Globals){
$scope.user=	window.localStorage.getItem("id");
$scope.goBack=function(){

window.history.back();


}
$http({  
			  method  : 'POST',
			  url     : Globals.ServerPath + 'allcat.php',
			  data    : $.param({}),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			  // set the headers so angular passing info as form data (not request payload)
			 }).success(function(data) {
			   	if(data.status.code == 1){

              $scope.cati=data.body;




			
						$timeout(function() {
				
						$timeout(function() { window.plugins.spinnerDialog.hide(); }, 300);
						}, 2000);
						
				}if(data.status.code == 0){
				window.plugins.spinnerDialog.hide();
				navigator.notification.alert(
						data.status.message,
						function(){},         // callback
						'',            // title
						'Done'                  // buttonName
					);
				}	
						
				}); 
			 $scope.up=function(){

			 	if(window.localStorage.getItem("id")==null){

$location.path("/login");
return;

			 	}else{
			 		window.plugins.spinnerDialog.show("", "Uploading song...!",true);
var name=$("#name").val();
var cat=$("#cat").val();
var dis=$("#dis").val();
var user_id=$scope.user;
var file_data = $('#url').prop('files')[0];  
var form_data = new FormData(); 
form_data.append('url', file_data);
form_data.append('cat', cat);
form_data.append('name', name);
form_data.append('des', dis);
form_data.append('user_id', user_id);
form_data.append('type', '0');
console.log(form_data);
$http({  
			  method  : 'POST',
			  dataType: 'text',  // what to expect back from the PHP script, if anything
              cache: false,
              contentType: false,
              processData: false,
			  url     : Globals.ServerPath + 'add_song.php',
			  data    : form_data, 
			  transformRequest: angular.identity, // pass in data as strings
			  headers : { 'Content-Type': undefined }  
			  // set the headers so angular passing info as form data (not request payload)
			 }).success(function(data) {
			   	if(data.status.code == 1){

         $location.path("/allpost");

window.plugins.toast.showWithOptions({
						    message: "song uploaded",
						    duration: "short", // 2000 ms
						    position: "bottom",
						    styling: {
						      opacity: 0.75, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
						      backgroundColor: '#333333', // make sure you use #RRGGBB. Default #333333
						      textColor: '#FFFFFF', // Ditto. Default #FFFFFF
						      textSize: 13, // Default is approx. 13.
						      cornerRadius: 16, // minimum is 0 (square). iOS default 20, Android default 100
						    //  horizontalPadding: 20, // iOS default 16, Android default 50
						    //  verticalPadding: 16 // iOS default 12, Android default 30
						    }
						  });


			
						$timeout(function() {
				
						$timeout(function() { window.plugins.spinnerDialog.hide(); }, 300);
						}, 2000);
						
				}if(data.status.code == 0){
				window.plugins.spinnerDialog.hide();
				navigator.notification.alert(
						data.status.message,
						function(){},         // callback
						'',            // title
						'Done'                  // buttonName
					);
				}	
						
				});



			 	}
			 }



document.addEventListener("deviceready", onDeviceReady, false);
				function onDeviceReady() {
					window.plugins.PushbotsPlugin.initialize("58776e814a9efa34e28b4567", {"android":{"sender_id":"858929087471"}});
	
	
	

	
	
	window.plugins.PushbotsPlugin.on("notification:clicked", function(data){
		$scope.friend_id=data.sender_id;
		//alert($scope.friend_id);
	$location.path("/message/"+$scope.friend_id);
			$scope.$apply();
	console.log("clicked:" + JSON.stringify(data));
	 }); }
 
	$scope.user=	window.localStorage.getItem("id");
if($scope.user>0 && $scope.user!=''){
	$scope.b=1;
	
	}else {
		
		$scope.b=0;
		}
$scope.a=1;


$scope.a=2;
	
$scope.logout=function(){
		
		window.localStorage.setItem("id",'');
		 $location.path("/login");
		
		}
	
});


/********************************** Welcome controller*****************************************************/
mainApp.controller('welcomeController', function($scope, $rootScope, $http, $location,$timeout,$interval,$window, Globals){
if(window.localStorage.getItem("id")!=null && window.localStorage.getItem("id")!=undefined && window.localStorage.getItem("id")!=''){
		$location.path("/event");
	}else{
		$location.path("/home");
	}


var devicePlatform = device.platform;
                  if(devicePlatform=='Android') 
                   { $rootScope.device_type = 1;}
                  else 
                  {$rootScope.device_type = 0;}

$scope.user=	window.localStorage.getItem("id");

document.addEventListener("deviceready", onDeviceReady, false);
function onDeviceReady() {
	
	window.plugins.PushbotsPlugin.initialize("58d92e584a9efa23148b4567", {"android":{"sender_id":"155275800804"}});
    //window.plugins.PushbotsPlugin.getRegistrationId(function(token){
	window.plugins.PushbotsPlugin.on("user:ids", function(data){
	console.log("user:ids" + JSON.stringify(data));
	});
    window.plugins.PushbotsPlugin.getRegistrationId(function(token){
              
           console.log("Registration Id:" + token);
            if(token == null || token == '' || token == undefined){
                
            window.plugins.PushbotsPlugin.on("registered", function(token){
            
                $rootScope.Usertoken = token;
                var devicePlatform = device.platform;
             
              if(devicePlatform=='Android') 
               { $rootScope.device_type = 1;}
              else 
                  {$rootScope.device_type = 0;}
                        });


            }else{
                
                $rootScope.Usertoken = token;
                
            }



            });


         }

  $scope.fb=function(){
  window.facebookConnectPlugin.login(["public_profile","email"], function(success){
            var token = success.authResponse.accessToken;
            var profile_picture = "https://graph.facebook.com/" + success.authResponse.userID + "/picture?width=9999";
            console.log(token);
            console.log(profile_picture);
            window.facebookConnectPlugin.api('/me', [], function(result) {
                var data = {
                    username : result.name,
                    avatar: profile_picture
                }
				var social_id = result.id;
				console.log(result.email);
                localStorage.setItem('username', result.name);
                localStorage.setItem('pic', profile_picture);
				localStorage.setItem('soical_id', token);
				localStorage.setItem('email', result.email);
				ActivityIndicator.show("LOADING");
                
                $http({  
			  method  : 'POST',
			  url     : Globals.ServerPath + 'soical_login.php',
			  data    : $.param({soical_id:social_id,name:result.name,email:result.email,device_type:$rootScope.device_type,device_token:$rootScope.Usertoken}),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			  // set the headers so angular passing info as form data (not request payload)
			 }).success(function(data) {
			   	if(data.status.code == 1){

              $scope.userdata=data.body;

             window.localStorage.setItem("id",data.body.id);
			 $timeout(function() {
				
						$timeout(function() { ActivityIndicator.hide(); }, 300);
						}, 2000);
			 
	            $location.path("/event");

				window.plugins.toast.showWithOptions({
						    message: data.status.message,
						    duration: "short", // 2000 ms
						    position: "bottom",
						    styling: {
						      opacity: 0.75, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
						      backgroundColor: '#333333', // make sure you use #RRGGBB. Default #333333
						      textColor: '#FFFFFF', // Ditto. Default #FFFFFF
						      textSize: 20.5, // Default is approx. 13.
						      cornerRadius: 16, // minimum is 0 (square). iOS default 20, Android default 100
						      horizontalPadding: 20, // iOS default 16, Android default 50
						      verticalPadding: 16 // iOS default 12, Android default 30
						    }
						  });
				
				
				

			
						
						
				}if(data.status.code == 0){
				ActivityIndicator.hide();
				navigator.notification.alert(
						data.status.message,
						function(){},         // callback
						'',            // title
						'Done'                  // buttonName
					);
				}	
						
				});

            }, function(error) {
                console.log(error);
            })


            },function(error) {
            console.error(error);
                }
             );
 
}

$http({  
			  method  : 'GET',
			  url     : Globals.ServerPath + 'getalleventcount.php',
			  data    : $.param({}),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			  // set the headers so angular passing info as form data (not request payload)
			 }).success(function(data) {
			   	if(data.status.code == 1){
              $scope.total=data.body.total;
				window.plugins.toast.showWithOptions({
						    message: "MotorCal Total Events "+data.body.total,
						    duration: "short", // 2000 ms
						    position: "bottom",
						    styling: {
						      opacity: 0.75, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
						      backgroundColor: '#333333', // make sure you use #RRGGBB. Default #333333
						      textColor: '#FFFFFF', // Ditto. Default #FFFFFF
						      textSize: 20.5, // Default is approx. 13.
						      cornerRadius: 16, // minimum is 0 (square). iOS default 20, Android default 100
						      horizontalPadding: 20, // iOS default 16, Android default 50
						      verticalPadding: 16 // iOS default 12, Android default 30
						    }
						  });
				}if(data.status.code == 0){
				ActivityIndicator.hide();
				navigator.notification.alert(
						data.status.message,
						function(){},         // callback
						'',            // title
						'Done'                  // buttonName
					);
				}	
						
				});
        $scope.logout=function(){
		window.localStorage.setItem("id",'');
		$location.path("/home");
		}
	
});
/********************************** event controller*****************************************************/
mainApp.controller('event', function($scope, $rootScope,$routeParams, $http, $location,$timeout,$interval,$window, Globals,$filter, moment, uiCalendarConfig,MovieRetriever,NgMap){
	
		var theDate = Date.now();
		$scope.disable=function(){
		$('#wrapper').toggleClass('toggled');
		}
		
		$scope.tog=function(){
			$('#wrapper').toggleClass('toggled');
		}
		document.addEventListener("backbutton", callback, false);
		function callback(){
		   $(".modal").modal('hide');
		}
		
		// user_id
		$rootScope.user_id=window.localStorage.getItem("id");
		
		// event class function there 
		
		$scope.addclass=function(event_type){
		
			if(event_type==1){
			return "BrightGreen";
			}
		    if(event_type==2){
			return "Purple";
			}
			if(event_type==3){
			return "Red";
			}
			if(event_type==4){
			return "Pink";
			}
			if(event_type==5){
			return "Brown";
			}
			if(event_type==6){
			return "Orange";
			}
			if(event_type==7){
			return "Yellow";
			}
			if(event_type==8){
			return "Blue";
			}
		}
	
		
		
		
		
		
		
		
		// weak event get there 
		
		$scope.getweakevent=function(){
		$scope.typemonth=2;
		$scope.geteventbyday="";
		
      var DIsday = new Date($scope.year, $scope.mymonth, 1);
		$http({  
			  method  : 'POST',
			  url     : Globals.ServerPath + 'getevent.php',
			  data    : $.param({type:2,user_id:$rootScope.user_id}),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			  // set the headers so angular passing info as form data (not request payload)
			 }).success(function(data) {
				if(data.status.code == 1){
					$rootScope.inbox=data.status.inbox;
					if(data.body.length>0){
					
					$scope.geteventbyday=data.body;
					$rootScope.inbox=data.status.inbox;
					
					}else {
					
					$scope.noEventMsg = "No event in this Week";
					
					}
					
				}if(data.status.code == 0){
					navigator.notification.alert(
					data.status.message,
					function(){},         // callback
					'',            // title
					'Done'                  // buttonName
					);
				}	
			});
		
		
		
		
		
		}
		
		

	if($rootScope.tabId!=''){
	if($rootScope.tabId == 1) {
		openCity('calender1','London');
	} else if($rootScope.tabId == 2) {
		openCity('browse1','Tokyo');
			$http({  
				method  : 'POST',
				url     : Globals.ServerPath + 'getallevent.php',
				data    : $.param({}),  // pass in data as strings
				headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
				// set the headers so angular passing info as form data (not request payload)
			}).success(function(data) {
				if(data.status.code == 1){
					$scope.allevent=data.body;
				}if(data.status.code == 0){
					navigator.notification.alert(
					data.status.message,
					function(){},         // callback
					'',            // title
					'Done'                  // buttonName
					);
				}	
			});
	}
	}
	// user locaation 
	if(navigator.geolocation){
               // timeout at 60000 milliseconds (60 seconds)
               var options = {timeout:60000};
               navigator.geolocation.getCurrentPosition(showLocation, errorHandler, options);
            }
            
            else{
               alert("Sorry, browser does not support geolocation!");
            }
	 function showLocation(position) {
	     window.localStorage.setItem("lat",position.coords.latitude);
	     window.localStorage.setItem("long",position.coords.longitude);
		 if(window.localStorage.getItem("long")!=null){
	      $http({  
		  method  : 'POST',
		  url     : Globals.ServerPath + 'user_location.php',
		  data    : $.param({user_id:$scope.user,latitude:position.coords.latitude,longitude:position.coords.longitude}),  // pass in data as strings
		  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
		  // set the headers so angular passing info as form data (not request payload)
		 }).success(function(data) {

			if(data.status.code == 0){
				navigator.notification.alert(
					data.status.message,
					function(){},         // callback
					'',            // title
					'Done'                  // buttonName
				);
			} 
	        });
	 
	 }
			
    };
	function errorHandler(error) {
			  
    }
	
	
	
	
	
	
	if(window.localStorage.getItem("id")!=null && window.localStorage.getItem("id")!=undefined && window.localStorage.getItem("id")!=''){

	}else{
		$location.path("/home");
	}
	/**Start Get current day event**/
	$scope.currentday = mm+'/'+dd+'/'+yyyy;
	$http({  
		method  : 'POST',
		url     : Globals.ServerPath + 'getevent.php',
		data    : $.param({user_id:$rootScope.user_id}),  // pass in data as strings
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
		// set the headers so angular passing info as form data (not request payload)
	}).success(function(data) {
	$rootScope.inbox=data.status.inbox;
		if(data.status.code == 1){
			if(data.body.length > 0) {
				$scope.geteventbyday=data.body;
				$rootScope.inbox=data.status.inbox;
				//$scope.noEventMsg = "No event on this day";
			}  else {
				$scope.noEventMsg = "No event on this day";
			}
		}if(data.status.code == 0){
			navigator.notification.alert(
				data.status.message,
				function(){},         // callback
				'',            // title
				'Done'                  // buttonName
			);
		}	
	});
	/**End current day event**/
	$http({  
		method  : 'POST',
		url     : Globals.ServerPath + 'geteventname.php',
		data    : $.param({}),  // pass in data as strings
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
		// set the headers so angular passing info as form data (not request payload)
	}).success(function(data) {
	
		if(data.status.code == 1){
			$scope.eventtype=data.body;
		}if(data.status.code == 0){
			navigator.notification.alert(
				data.status.message,
				function(){},         // callback
				'',            // title
				'Done'                  // buttonName
			);
		}	
	});

	var today = new Date();	
	$scope.user= window.localStorage.getItem("id");

	$scope.goBack=function(tabId){
		window.history.back();
	}
    //date check
	$scope.checkdate=function(){
	      
		 var date1= new Date($scope.to_date).getTime();
		 var date2= new Date($scope.from_date).getTime();
	   
	     if(date2>date1){
		  $scope.to_date="";
		 navigator.notification.alert(
				'please select correct date',
				function(){},         // callback
				'',            // title
				'Done'                  // buttonName
			);
			
		
		 
		 }else {
		
		 
		 }
	
	
	       }
		   $scope.checkdate1=function(){
	      
		 var date1= new Date($scope.from_date).getTime();
         date1= new Date(date1);	
    		 
		 $scope.from_date=date1.getFullYear()+"-0"+(date1.getMonth()+1)+"-"+date1.getDate();
		
	   
	     if(date2>date1){
		  $scope.to_date="";
		 navigator.notification.alert(
				'please select correct date',
				function(){},         // callback
				'',            // title
				'Done'                  // buttonName
			);
			
		
		 
		 }else {
		 
		 }
	
	
	       }
	
	
	
	//search here//
	$scope.search=function(){
	 //
	     var date1= new Date($scope.to_date).getTime();
		 var date2= new Date($scope.from_date).getTime();
	  
		ActivityIndicator.show("searching");
		$http({  
		method  : 'POST',
		url     : Globals.ServerPath + 'search_event.php',
		data    : $.param({user_id:$scope.user,search_name:$scope.result,to_date:$scope.from_date,from_date:$scope.to_date,event_type:$scope.name}),  // pass in data as strings
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
		// set the headers so angular passing info as form data (not request payload)
	}).success(function(data) {
		if(data.status.code == 1){
			
				$rootScope.searchresult=data.body;
				$location.path("/search");
				//$scope.noEventMsg = "No event on this day";
			
		}if(data.status.code == 0){
		ActivityIndicator.hide();
			navigator.notification.alert(
				data.status.message,
				function(){},         // callback
				'',            // title
				'Done'                  // buttonName
			);
		}	
	});
		
	}
	//detalis here
	
	
	
	
	$scope.detalis=function(detalis,tabId){
		$rootScope.tabId = tabId ;
		$rootScope.eventdetalis=detalis;
		window.localStorage.setItem('event_id',detalis.id);
		$("#myModal").modal('show')
		//$location.path("/detalis");
	}

	/**Google map**/
	NgMap.getMap().then(function(map) {
		$scope.map = map;
	  });
    $scope.customIcon = {
        "scaledSize": [32, 32],
        "url": "http://www.cliparthut.com/clip-arts/823/arrowhead-clip-art-823528.png"
    };
    
	$scope.showDetail = function(event) {
		$scope.map.showInfoWindow('myInfoWindow', this);
	};
	  
	$scope.myvalue = true;
	
	$scope.showMap = function(){
		if($scope.myvalue == true) {
			$scope.myvalue = false;  
		}else {
			$scope.myvalue = true;  
		}
	};
	/**End Google map**/
	
	$scope.allevent=function(){
     $rootScope.typeactive=3;
		$http({  
			method  : 'POST',
			url     : Globals.ServerPath + 'getallevent.php',
			data    : $.param({}),  // pass in data as strings
			headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			// set the headers so angular passing info as form data (not request payload)
		}).success(function(data) {
			if(data.status.code == 1){
				$scope.allevent=data.body;
			}if(data.status.code == 0){
				navigator.notification.alert(
					data.status.message,
					function(){},         // callback
					'',            // title
					'Done'                  // buttonName
				);
			}	
		});
	}

	$scope.month=function(){
		$scope.typemonth=3;
		$scope.geteventbyday="";
		ActivityIndicator.show("LOADING");
      var DIsday = new Date($scope.year, $scope.mymonth, 1);
		$http({  
			  method  : 'POST',
			  url     : Globals.ServerPath + 'getevent.php',
			  data    : $.param({type:1,user_id:$rootScope.user_id}),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			  // set the headers so angular passing info as form data (not request payload)
			 }).success(function(data) {
			 $rootScope.inbox=data.status.inbox;
			   	if(data.status.code == 1){
				
					if(data.body.length > 0) {
					
						$scope.monthdays1=[];
				$scope.geteventbyday=data.body;
				
				var dd =0;
		for (i = 0; i < DIsday.getDay(); i++) {
			// if ( i%7 == 0 ) 
			
			console.log("rg "+i);
			
			var day={"day":dd,"data":0};
			
			
		 $scope.monthdays1.push(day);
		 dd--;
		
}
		
		for(var i=1;i<=getDaysInMonth($scope.mymonth+1,$scope.year);i++){
		
		if(checkarray(pankaj(i),data.body)){
			
			var day={"day":i,"data":1};
			
			
			}else {
			var day={"day":i,"data":0};
			
			}
	    
	     $scope.monthdays1.push(day);

	    }
					} else {
						$scope.noEventMsg = "No event in this month";
					}
					$timeout(function() {
						$timeout(function() { ActivityIndicator.hide(); }, 300);
					}, 1000);
				}
				if(data.status.code == 0){
					navigator.notification.alert(
						data.status.message,
						function(){},         // callback
						'',            // title
						'Done'                  // buttonName
					);
				}	
		});
	}
	// array margie there 
	
	
	
	
	
	
	$scope.getdot=function(month){
		for(var i=0;i<=data.body.length;i++){
			console.log(data.body[i]);
			if(data.body[i].event_date==month){
				return 1;
			}else {
				return 0;
			}
		}
	}

	$scope.save_event=function(dd){
		$http({  
			method  : 'POST',
			url     : Globals.ServerPath + 'saveevent.php',
			data    : $.param({user_id:$scope.user,event_id:dd}),  // pass in data as strings
			headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			// set the headers so angular passing info as form data (not request payload)
		}).success(function(data) {
			if(data.status.code == 1){
				window.plugins.toast.showWithOptions({
					message: "Event save scuessfully. ",
					duration: "short", // 2000 ms
					position: "bottom",
					styling: {
						opacity: 0.75, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
						backgroundColor: '#333333', // make sure you use #RRGGBB. Default #333333
						textColor: '#FFFFFF', // Ditto. Default #FFFFFF
						textSize: 20.5, // Default is approx. 13.
						cornerRadius: 16, // minimum is 0 (square). iOS default 20, Android default 100
						horizontalPadding: 20, // iOS default 16, Android default 50
						verticalPadding: 16 // iOS default 12, Android default 30
					}
				});
			}
			if(data.status.code == 0){
				navigator.notification.alert(
					data.status.message,
					function(){},         // callback
					'',            // title
					'Done'                  // buttonName
				);
			}	
		});
	}
	
	/***Start attendent Event***/
	//Get user attending event
	
	$http({  
		  method  : 'POST',
		  url     : Globals.ServerPath + 'getuserevent.php',
		  data    : $.param({user_id:$scope.user,event_id:window.localStorage.getItem('event_id')}),  // pass in data as strings
		  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
		  // set the headers so angular passing info as form data (not request payload)
		 }).success(function(data) {
			if(data.status.code == 1){
				if(data.body.length > 0) {
					$scope.test = "1";
				}else {
					$scope.test = "0";
				}
				$timeout(function() {
					$timeout(function() { ActivityIndicator.hide(); }, 300);
				}, 1000);
			}
			if(data.status.code == 0){
				navigator.notification.alert(
					data.status.message,
					function(){},         // callback
					'',            // title
					'Done'                  // buttonName
				);
			}
	});
   
	//Join / unjoin event
	$scope.test = "1";
	
	
	
	$scope.attend_event=function(event_id,status){
		console.log(event_id+"/"+status);
		$http({  
			method  : 'POST',
			url     : Globals.ServerPath + 'attendevent.php',
			data    : $.param({user_id:$scope.user,event_id:event_id,status:status}),  // pass in data as strings
			headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			// set the headers so angular passing info as form data (not request payload)
		}).success(function(data) {
			if(data.status.code == 1){
				window.plugins.toast.showWithOptions({
					message: "Successfully saved. ",
					duration: "short", // 2000 ms
					position: "bottom",
					styling: {
						opacity: 0.75, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
						backgroundColor: '#333333', // make sure you use #RRGGBB. Default #333333
						textColor: '#FFFFFF', // Ditto. Default #FFFFFF
						textSize: 20.5, // Default is approx. 13.
						cornerRadius: 16, // minimum is 0 (square). iOS default 20, Android default 100
						horizontalPadding: 20, // iOS default 16, Android default 50
						verticalPadding: 16 // iOS default 12, Android default 30
					}
				});
			}
			if(data.status.code == 0){
				navigator.notification.alert(
					data.status.message,
					function(){},         // callback
					'',            // title
					'Done'                  // buttonName
				);
			}	
		});
	}
	/***End attendent Event***/

	var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
	var month =["January","February","March","April","May","June","July","Auguest","Sep","Nov","December"];
	$scope.monthdays=[01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];

	$scope.monthname = month[today.getMonth()];
//	console.log(month);
	$scope.currentmonth= today.getMonth();
	$scope.weaks=days;

	var dd = today.getDate();
	var mm = today.getMonth()+1; 
	var yyyy = today.getFullYear();
	//$scope.mymonth=mm;
	$scope.mymonth=today.getMonth();
	if(dd<10) {
		dd='0'+dd
	} 

	if(mm<10) {
		mm='0'+mm
	} 
	//** weak work there **//
	Date.prototype.getWeek = function(start)
{
        // the starting point
    start = start || 0;
    var today = new Date(this.setHours(0, 0, 0, 0));
    var day = today.getDay() - start;
    var date = today.getDate() - day;

        //  Start/End Dates
    var StartDate = new Date(today.setDate(date));
    var EndDate = new Date(today.setDate(date + 6));
    return StartDate.getDate();
}
var curr = new Date; // get current date
var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
var last = first + 6;

var bk= new Date().getWeek();
$scope.weakarray=[
{"day":"sun"},
{"day":"mon"},
{"day":"Tue"},
{"day":"Web"},
{"day":"Thu"},
{"day":"Fri"},
{"day":"sat"},


];

console.log(bk);
for(var i= first;i<=         last;i++){
var addweak={"days":i};
$scope.weakarray.push(addweak);


}
// get next weak there 
        
		$scope.nextweak=function(){
		// again set the function
		var weakarray=getWeeksInMonth($scope.mymonth,$scope.year);
		
		
		for(var i=0;i<weakarray.length;i++){
		
		
		if(bk==weakarray[i].start){
			bk=weakarray[i].end;
			var lastday1=weakarray[i+1].end;
		}
		
		
		}
		
		bk=bk+1;
		
		
		 $scope.monthname=month[$scope.mymonth]; 
		
		
		  $scope.weakarray=[
				{"day":"sun"},
				{"day":"mon"},
				{"day":"Tue"},
				{"day":"Web"},
				{"day":"Thu"},
				{"day":"Fri"},
				{"day":"sat"},
            ];
		   var lastday = new Date($scope.year,$scope.mymonth+1,0);
		  
          lastday=lastday.getUTCDate();
           var endday=bk;
		
		  if(lastday+1==lastday1){
		   
		  
		$scope.mymonth=	$scope.mymonth+1;
		var  fistday = new Date($scope.year, $scope.mymonth+1, 1);
		bk=getWeeksInMonth($scope.mymonth,$scope.year)[0].start;
		  }
         for(var i= endday;i<=lastday1; i++){
         var addweak={"days":i};
         $scope.weakarray.push(addweak);
		 }

		}
		// back weak
		$scope.backweak=function(){
		// again set the function
		
		 var  Fi = new Date($scope.year, $scope.mymonth, 1);
	    
	    if(bk==Fi.getDate()){
	      La = new Date($scope.year, $scope.mymonth, 0);
		  bk=La.getDate();
		 
		if($scope.mymonth==0 ){
		  La = new Date($scope.year, $scope.mymonth, 0);
		  bk=La.getDate();
		    
		    $scope.monthname=month[11]; 
			$scope.mymonth=12;
		   $scope.year=$scope.year-1;
		
		}
		
		if($scope.mymonth==12){
		
	    $scope.monthname="December";
		$scope.mymonth=	$scope.mymonth-1;
	   }
	   $scope.mymonth=	$scope.mymonth-1;
	   $scope.monthname=month[$scope.mymonth];
	   
		var weakarray1=getWeeksInMonth($scope.mymonth-1,$scope.year);
		console.log(weakarray1);
		for(var i=0;i<weakarray1.length;i++){
		if(bk==weakarray[i].end || bk==weakarray[i].start ){
			bk=weakarray[i-1].start;
			var lastday1=weakarray[i-1].end;
		}
		
		
		}
		
	   
	   
	   }else{
		var weakarray=getWeeksInMonth($scope.mymonth,$scope.year);
		for(var i=0;i<weakarray.length;i++){
		if(bk==weakarray[i].end || bk==weakarray[i].start ){
			bk=weakarray[i-1].start;
			var lastday1=weakarray[i-1].end;
		}
		
		
		}
		}
	
		
		
		
		var  FirstDay = new Date($scope.year, $scope.mymonth, 1);
		  $scope.weakarray=[
				{"day":"sun"},
				{"day":"mon"},
				{"day":"Tue"},
				{"day":"Web"},
				{"day":"Thu"},
				{"day":"Fri"},
				{"day":"sat"},
            ];
		
		
	       
           var endday=bk;
		 var lastday = new Date($scope.year,$scope.mymonth+1,1);
		  
          lastday=lastday.getDay();
		 
           var endday=bk;
		
		  
         for(var i= endday;i<=lastday1; i++){
         var addweak={"days":i};
         $scope.weakarray.push(addweak);
		 
		 
		 
		 }

		}


	
	
	//** weak work over there **//
	$scope.currentday = mm+'/'+dd+'/'+yyyy
	$scope.year=yyyy;
	$scope.todays=dd;
	$scope.daywrite=days[today.getDay()];

	$scope.changedate= function(dd){
		var d=parseInt(dd);
		$scope.todays=eval("d+1");
	}
	$scope.monthdays1=[];
	var  FirstDay = new Date($scope.year, $scope.mymonth, 1);
	var ddp =0;
		for (i = 0; i < FirstDay.getDay(); i++) {
			// if ( i%7 == 0 ) 
		
			var day={"day":ddp};
		 $scope.monthdays1.push(day);
		 ddp--;
		
}
	for(var i=1;i<=getDaysInMonth($scope.mymonth+1,$scope.year);i++){
	var day={"day":i};
	$scope.monthdays1.push(day);

	}
   // next month function start here //
   
    //var LastDay = new Date($scope.year, $scope.mymonth + 1, 0);
	
	
	$scope.next=function(d){
	
	var DIsday = new Date($scope.year, $scope.mymonth+1, 1);
	
	
	     $scope.monthdays1=[];
	    $scope.geteventbyday="";
		console.log($scope.mymonth);
		if($scope.mymonth==10){
			$scope.mymonth=0;
			$scope.year=$scope.year+1;
			console.log($scope.mymonth);
		}else {
			$scope.mymonth++;
			
		}
		$scope.monthname=month[$scope.mymonth];
		
		var dd =0;
		for (i = 0; i < DIsday.getDay(); i++) {
			// if ( i%7 == 0 ) 
			console.log("rg "+i);
			var day={"day":dd};
		 $scope.monthdays1.push(day);
		 dd--;
		
}
         console.log("cg "+DIsday.getDay());
	
		for(var i=1;i<=getDaysInMonth($scope.mymonth+1,$scope.year);i++){
	      var day={"day":i};
	     $scope.monthdays1.push(day);

	    }
		
		if($scope.mymonth<=9){
		var m=$scope.mymonth+1;
		m="0"+m;
		}else {
		m=m;
		}
		var currentmonth=$scope.year+"-"+m+"-"+01;
		ActivityIndicator.show("LOADING");
		$http({  
		method  : 'POST',
		url     : Globals.ServerPath + 'getevent.php',
		data    : $.param({date:currentmonth,type:1,user_id:$rootScope.user_id}),  // pass in data as strings
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
		// set the headers so angular passing info as form data (not request payload)
		}).success(function(data) {
		$rootScope.inbox=data.status.inbox;
		if(data.status.code == 1){
			if(data.body.length > 0){
				$scope.monthdays1=[];
				$scope.geteventbyday=data.body;
				
				var dd =0;
		for (i = 0; i < DIsday.getDay(); i++) {
			// if ( i%7 == 0 ) 
			
			console.log("rg "+i);
			
			var day={"day":dd,"data":0};
			
			
		 $scope.monthdays1.push(day);
		 dd--;
		
}
		
		for(var i=1;i<=getDaysInMonth($scope.mymonth+1,$scope.year);i++){
		
		if(checkarray(pankaj(i),data.body)){
			
			var day={"day":i,"data":1};
			
			
			}else {
			var day={"day":i,"data":0};
			
			}
	    
	     $scope.monthdays1.push(day);

	    }
			}else {
				$scope.noEventMsg = "No event in this month";
			}
			$timeout(function() {
				$timeout(function() { ActivityIndicator.hide(); }, 300);
			}, 1000);
		}if(data.status.code == 0){
			navigator.notification.alert(
				data.status.message,
				function(){},         // callback
				'',            // title
				'Done'                  // buttonName
			);
		}	
		});
		
		
		
		
		
	}
	
	 // over there  //
	function getDaysInMonth(month, year) {
		// Since no month has fewer than 28 days
		var date = new Date(year, month, 1);
		var days = [];
		console.log('month', month, 'date.getMonth()', date.getMonth())
		while (date.getMonth() === month) {
			days.push(new Date(date).getDate());
			date.setDate(date.getDate() + 1);
		}
		return days;
	}
	
    // back month function start here 
	$scope.back=function(d){
	var DIsday = new Date($scope.year, $scope.mymonth-1, 1);
	$scope.monthdays1=[];
	$scope.geteventbyday="";
		console.log($scope.mymonth);
		if($scope.mymonth==0){
			$scope.year=$scope.year-1;
			$scope.mymonth=10;
		}else {
			$scope.mymonth--;
		}
		$scope.monthname=month[$scope.mymonth];
		
		
		$scope.monthname=month[$scope.mymonth];
		
		var dd =0;
		for (i = 0; i < DIsday.getDay(); i++) {
			// if ( i%7 == 0 ) 
			
			console.log("rg "+i);
			var day={"day":dd};
		 $scope.monthdays1.push(day);
		 dd--;
		
}
		
		for(var i=1;i<=getDaysInMonth($scope.mymonth+1,$scope.year);i++){
	     var day={"day":i};
	     $scope.monthdays1.push(day);

	    }
		
		if($scope.mymonth<=9){
		var m=$scope.mymonth+1;
		m="0"+m;
		}else {
		m=m;
		}
		var currentmonth=$scope.year+"-"+m+"-"+01;
		ActivityIndicator.show("LOADING");
		$http({  
		method  : 'POST',
		url     : Globals.ServerPath + 'getevent.php',
		data    : $.param({date:currentmonth,type:1,user_id:$rootScope.user_id}),  // pass in data as strings
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
		// set the headers so angular passing info as form data (not request payload)
		}).success(function(data) {
		$rootScope.inbox=data.status.inbox;
		if(data.status.code == 1){
			if(data.body.length > 0){
			 $scope.monthdays1=[];
				$scope.geteventbyday=data.body;
				
				var dd =0;
		for (i = 0; i < DIsday.getDay(); i++) {
			// if ( i%7 == 0 ) 
			
			console.log("rg "+i);
			
			var day={"day":dd,"data":0};
			
			
		 $scope.monthdays1.push(day);
		 dd--;
		
}
		
		for(var i=1;i<=getDaysInMonth($scope.mymonth+1,$scope.year);i++){
		
		if(checkarray(pankaj(i),data.body)){
			
			var day={"day":i,"data":1};
			
			
			}else {
			var day={"day":i,"data":0};
			
			}
	    
	     $scope.monthdays1.push(day);

	    }
				console.log("bacxk"+JSON.stringify($scope.monthdays1));
				
			}else {
				$scope.noEventMsg = "No event in this month";
			}
			$timeout(function() {
				$timeout(function() { ActivityIndicator.hide(); }, 300);
			}, 1000);
		}if(data.status.code == 0){
			navigator.notification.alert(
				data.status.message,
				function(){},         // callback
				'',            // title
				'Done'                  // buttonName
			);
		}	
		});
	}
	
	
	// array function 
	
	function checkarray(date,myArray){
	for (var i=0; i < myArray.length; i++) {
        if (myArray[i].event_date === date) {
		console.log(myArray[i].event_date);
            return 1;
        }
    }
	}
     //weak function here 
	 function getWeeksInMonth(month, year){
   var weeks=[],
       firstDate=new Date(year, month, 1),
       lastDate=new Date(year, month+1, 0), 
       numDays= lastDate.getDate();
   
   var start=1;
   var end=7-firstDate.getDay();
   while(start<=numDays){
       weeks.push({start:start,end:end});
       start = end + 1;
       end = end + 7;
       if(end>numDays)
           end=numDays;    
   }        
    return weeks;
}  

console.log(getWeeksInMonth(3,2017)) //
	
	 
	 
	 
	 
	// day next back function here

	$scope.nextday=function(){
	$(".no-event").hide();
	$("#spinner").show();
	    $scope.geteventbyday="";
		console.log("next");
		theDate += 86400000;
		var theCDate = new Date(theDate);
		$scope.daywrite= days[theCDate.getDay()] ;
		$scope.todays=theCDate.getDate();
		$scope.monthname=month[theCDate.getMonth()];
		$scope.year=theCDate.getFullYear();
		ActivityIndicator.show("LOADING");
		var m=theCDate.getMonth()+1;
		var passdate=$scope.year+"-0"+m+"-"+theCDate.getDate();
		$http({  
		method  : 'POST',
		url     : Globals.ServerPath + 'getevent.php',
		data    : $.param({date:passdate,user_id:$rootScope.user_id}),  // pass in data as strings
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
		// set the headers so angular passing info as form data (not request payload)
		}).success(function(data) {
		$(".no-event").show();
	    $("#spinner").hide();
		if(data.status.code == 1){
		$rootScope.inbox=data.status.inbox;
			if(data.body.length > 0){
				$scope.geteventbyday=data.body;
			}else {
				$scope.noEventMsg = "No event on this day";
			}
			$timeout(function() {
				$timeout(function() { ActivityIndicator.hide(); }, 300);
			}, 1000);
		}if(data.status.code == 0){
			navigator.notification.alert(
				data.status.message,
				function(){},         // callback
				'',            // title
				'Done'                  // buttonName
			);
		}	
		});
	}

	$scope.backday=function(){
	    $(".no-event").hide();
	    $("#spinner").show();
	    $scope.geteventbyday="";
		console.log("back");
		theDate -= 86400000;
		var theCDate = new Date(theDate);
		$scope.daywrite= days[theCDate.getDay()] ;
		$scope.todays=theCDate.getDate();
		$scope.monthname=month[theCDate.getMonth()];
		$scope.year=theCDate.getFullYear();
		var m=theCDate.getMonth()+1;
		var passdate=$scope.year+"-0"+m+"-"+theCDate.getDate();
		$http({  
		method  : 'POST',
		url     : Globals.ServerPath + 'getevent.php',
		data    : $.param({date:passdate}),  // pass in data as strings
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
		// set the headers so angular passing info as form data (not request payload)
		}).success(function(data) {
		$(".no-event").show();
	     $("#spinner").hide();
		if(data.status.code == 1){
			if(data.body.length > 0){
				$scope.geteventbyday=data.body;
			}else {
				$scope.noEventMsg = "No event on this day";
			}
			$timeout(function() {
				$timeout(function() { ActivityIndicator.hide(); }, 300);
			}, 1000);
		}if(data.status.code == 0){
			navigator.notification.alert(
				data.status.message,
				function(){},         // callback
				'',            // title
				'Done'                  // buttonName
			);
		}	
		});
		
		
		
		
		
		
	}

	$scope.logout=function(){
		$('#wrapper').toggleClass('toggled');
		var message = "Are you sure you want to Logout?";
		var title = "CONFIRM";
		var buttonLabels =  "YES,NO";

		navigator.notification.confirm(message, confirmCallback, title, buttonLabels);

		function confirmCallback(buttonIndex) {
			if(buttonIndex=="1"){
				var user_id = window.localStorage.getItem("id");
				$http({  
					method  : 'POST',
					url     : Globals.ServerPath + 'logout.php',
					data    : $.param({user_id:user_id}),  // pass in data as strings
					headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
					// set the headers so angular passing info as form data (not request payload)
				}).success(function(data) {
					if(data.status.code == 1){
						$scope.userdata=data.body;
						window.localStorage.setItem("id",'');
						$location.path("/home");
						window.plugins.toast.showWithOptions({
							message: data.status.message,
							duration: "short", // 2000 ms
							position: "bottom",
							styling: {
								opacity: 0.75, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
								backgroundColor: '#333333', // make sure you use #RRGGBB. Default #333333
								textColor: '#FFFFFF', // Ditto. Default #FFFFFF
								textSize: 20.5, // Default is approx. 13.
								cornerRadius: 16, // minimum is 0 (square). iOS default 20, Android default 100
								horizontalPadding: 20, // iOS default 16, Android default 50
								verticalPadding: 16 // iOS default 12, Android default 30
							}
						});
						$timeout(function() {
							$timeout(function() { ActivityIndicator.hide(); }, 300);
						}, 2000);
					}
					if(data.status.code == 0){
					ActivityIndicator.hide();
					navigator.notification.alert(
					data.status.message,
					function(){},         // callback
					'',            // title
					'Done'                  // buttonName
					);
					}	
				});
			}
		}	
	}
	$scope.bd=function(op){
		if(op<=9){
			op="0"+op;
		}
		
        var m=$scope.mymonth+1;
		if(m<10){
		m="0"+m;
		}else {
		m=m;
		}
		var currentmonth=$scope.year+"-"+m+"-"+op;		
		
		return currentmonth;
		
	}
	
	function pankaj(op){
		if(op<=9){
			op="0"+op;
		}
		
        var m=$scope.mymonth+1;
		if(m<10){
		m="0"+m;
		}else {
		m=m;
		}
		var currentmonth=$scope.year+"-"+m+"-"+op;		
		
		return currentmonth;
		
	}
	$scope.typemonth=1;
	$scope.gotoevent=function(date,today){
	$scope.typemonth=1;
	$scope.geteventbyday="";
	$scope.todays=today;
	var myDate=date;
    myDate=myDate.split("-");
    var newDate=myDate[0]+","+myDate[1]+","+myDate[2];
	theDate=new Date(newDate).getTime();
		
		ActivityIndicator.show("LOADING");
		$http({  
		method  : 'POST',
		url     : Globals.ServerPath + 'getevent.php',
		data    : $.param({date:date,user_id:$rootScope.user_id}),  // pass in data as strings
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
		// set the headers so angular passing info as form data (not request payload)
		}).success(function(data) {
		if(data.status.code == 1){
		$rootScope.inbox=data.status.inbox;
			if(data.body.length > 0){
				$scope.geteventbyday=data.body;
			}else {
				$scope.noEventMsg = "No event on this day";
			}
			$timeout(function() {
				$timeout(function() { ActivityIndicator.hide(); }, 300);
			}, 1000);
		}if(data.status.code == 0){
			navigator.notification.alert(
				data.status.message,
				function(){},         // callback
				'',            // title
				'Done'                  // buttonName
			);
		}	
		});
	}
	// calender js here 

	function setToday() {
		var now   = new Date();
		var day   = now.getDate();
		var month = now.getMonth();
		var year  = now.getYear();
		if (year < 2000)    // Y2K Fix, Isaac Powell
			year = year + 1900; // http://onyx.idbsu.edu/~ipowell
		this.focusDay = day;
		document.calControl.month.selectedIndex = month;
		document.calControl.year.value = year;
		displayCalendar(month, year);
	}
	function isFourDigitYear(year) {
		if (year.length != 4) {
			alert ("Sorry, the year must be four-digits in length.");
			document.calControl.year.select();
			document.calControl.year.focus();
		} else { return true; }
	}
	function selectDate() {
		var year  = document.calControl.year.value;
		if (isFourDigitYear(year)) {
			var day   = 0;
			var month = document.calControl.month.selectedIndex;
			displayCalendar(month, year);
		}
	}

	function setPreviousYear() {
		var year  = document.calControl.year.value;
		if (isFourDigitYear(year)) {
			var day   = 0;
			var month = document.calControl.month.selectedIndex;
			year--;
			document.calControl.year.value = year;
			displayCalendar(month, year);
		}
	}
	function setPreviousMonth() {
		var year  = document.calControl.year.value;
		if (isFourDigitYear(year)) {
			var day   = 0;
			var month = document.calControl.month.selectedIndex;
			if (month == 0) {
				month = 11;
				if (year > 1000) {
					year--;
					document.calControl.year.value = year;
				}
			} else { month--; }
			document.calControl.month.selectedIndex = month;
			displayCalendar(month, year);
		}
	}
	function setNextMonth() {
		var year  = document.calControl.year.value;
		if (isFourDigitYear(year)) {
			var day   = 0;
			var month = document.calControl.month.selectedIndex;
			if (month == 11) {
				month = 0;
				year++;
				document.calControl.year.value = year;
			} else { month++; }
			document.calControl.month.selectedIndex = month;
			displayCalendar(month, year);
		}
	}
	function setNextYear() {
		var year = document.calControl.year.value;
		if (isFourDigitYear(year)) {
			var day = 0;
			var month = document.calControl.month.selectedIndex;
			year++;
			document.calControl.year.value = year;
			displayCalendar(month, year);
		}
	}
	
	function getDaysInMonth1(month, year) {
     var date = new Date(year, month, 1);
     var days = [];
     while (date.getMonth() === month) {
        days.push(new Date(date));
        date.setDate(date.getDate() + 1);
     }
     return days;
}
	
	
	function getDaysInMonth(month,year)  {
	var days;
	if (month==1 || month==3 || month==5 || month==7 || month==8 || month==10 || month==12)  days=31;
	else if (month==4 || month==6 || month==9 || month==11) days=30;
	else if (month==2)  {
	if (isLeapYear(year)) { days=29; }
	else { days=28; }
	}
	return (days);
	}
	
	function isLeapYear (Year) {
		if (((Year % 4)==0) && ((Year % 100)!=0) || ((Year % 400)==0)) {
			return (true);
		} else { return (false); }
	}
	
	console.log(getDaysInMonth1(3,2017));
	
	
	//Start Search area
	
	//Start autocomplete location
	$scope.movies = MovieRetriever.getmovies("...");
	$scope.movies.then(function(data){
		$scope.movies = data;
	});

	$scope.getmovies = function(){
		return $scope.movies;
	}

	$scope.doSomething = function(typedthings){
		console.log("Do something like reload data with this: " + typedthings );
		$scope.newmovies = MovieRetriever.getmovies(typedthings);
		$scope.newmovies.then(function(data){
			$scope.movies = data;
		});
	}

	$scope.doSomethingElse = function(suggestion){
		console.log("Suggestion selected: " + suggestion );
	}
	//End autocomplete location
	
	//End Search area
	
	
	
});


//userprofile
/********************************** save event controller*****************************************************/
mainApp.controller('saveevent', function($scope, $rootScope,$routeParams, $http, $location,$timeout,$interval,$window, Globals,$filter, moment, uiCalendarConfig,MovieRetriever,NgMap){
$scope.user=	window.localStorage.getItem("id");
$scope.goBack=function(){
console.log("hello");
window.history.back();

}
$rootScope.tabId=1;
$scope.detalis=function(sv){
		console.log("save detalis"+sv);
		$rootScope.eventdetalis=sv;
		window.localStorage.setItem('eventdetalis',JSON.stringify(sv));
		$location.path("/detalis1");

}

ActivityIndicator.show("LOADING");
                
$http({  
			  method  : 'POST',
			  url     : Globals.ServerPath + 'getsaveevent.php',
			  data    : $.param({user_id:$scope.user}),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			  // set the headers so angular passing info as form data (not request payload)
			 }).success(function(data) {
			   	if(data.status.code == 1){

              $scope.saveevent=data.body;

             
			 $timeout(function() {
				
						$timeout(function() { ActivityIndicator.hide(); }, 300);
						}, 2000);
			 
	 

				
				
				

			
						
						
				}if(data.status.code == 0){
				ActivityIndicator.hide();
				navigator.notification.alert(
						data.status.message,
						function(){},         // callback
						'',            // title
						'Done'                  // buttonName
					);
				}	
						
				});


	
$scope.logout=function(){
		
		window.localStorage.setItem("id",'');
		 $location.path("/home");
		
		}
	
});


/********************************** signup controller*****************************************************/
mainApp.controller('signup', function($scope, $rootScope,$routeParams, $http, $location,$timeout,$interval,$window, Globals){

$scope.goBack=function(){

window.history.back();

}
document.addEventListener("deviceready", onDeviceReady, false);
function onDeviceReady() {
	
	window.plugins.PushbotsPlugin.initialize("58d92e584a9efa23148b4567", {"android":{"sender_id":"155275800804"}});

 window.plugins.PushbotsPlugin.getRegistrationId(function(token){
              

            if(token == null || token == '' || token == undefined){
                
            window.plugins.PushbotsPlugin.on("registered", function(token){
            	
                $rootScope.Usertoken = token;
                var devicePlatform = device.platform;
          
              if(devicePlatform=='Android') 
               { $rootScope.device_type = 1;}
              else 
                  {$rootScope.device_type = 0;}
                        });


            }else{
                
                $rootScope.Usertoken = token;
                var devicePlatform = device.platform;
                  if(devicePlatform=='Android') 
                   { $rootScope.device_type = 1;}
                  else 
                  {$rootScope.device_type = 0;}
            }



            });

}

// match otp function is here 
$scope.user_id= window.localStorage.getItem("otp");

$scope.matchotp=function(){

window.plugins.spinnerDialog.show(null, "loading...");
$http({  
			  method  : 'POST',
			  url     : Globals.ServerPath + 'match_otp.php',
			  data    : $.param({user_id:$scope.user_id,otp:$scope.otp}),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			  // set the headers so angular passing info as form data (not request payload)
			 }).success(function(data) {
			   	if(data.status.code == 1){

              $scope.userdata=data.body;
              
			
             localStorage.setItem('id', data.body.id);
             localStorage.setItem('username', data.body.name);
			 localStorage.setItem('email', data.body.email);
            $location.path("/event");
				window.plugins.toast.showWithOptions({
						    message: data.status.message,
						    duration: "short", // 2000 ms
						    position: "center",
						    styling: {
						      opacity: 0.75, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
						      backgroundColor: '#333333', // make sure you use #RRGGBB. Default #333333
						      textColor: '#FFFFFF', // Ditto. Default #FFFFFF
						      textSize: 20.5, // Default is approx. 13.
						      cornerRadius: 16, // minimum is 0 (square). iOS default 20, Android default 100
						      horizontalPadding: 20, // iOS default 16, Android default 50
						      verticalPadding: 16 // iOS default 12, Android default 30
						    }
						  });
				
				
				
				

			
						$timeout(function() {
				
						$timeout(function() { window.plugins.spinnerDialog.hide(); }, 300);
						}, 2000);
						
				}if(data.status.code == 0){
				window.plugins.spinnerDialog.hide();
				navigator.notification.alert(
						data.status.message,
						function(){},         // callback
						'',            // title
						'Done'                  // buttonName
					);
				}	
						
				});









}



$scope.search=function(){
ActivityIndicator.show("LOADING");
$timeout(function() {
				
$timeout(function() { ActivityIndicator.hide(); }, 300);
						}, 2000);



}


$scope.signup=function(){
window.plugins.spinnerDialog.show(null, "loading...");
$http({  
			  method  : 'POST',
			  url     : Globals.ServerPath + 'signup.php',
			  data    : $.param({name:$scope.name,email:$scope.email,password:$scope.password,dob:$scope.dob,address:$scope.address,device_type:$rootScope.device_type,device_token:$rootScope.Usertoken,user_type:3}),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			  // set the headers so angular passing info as form data (not request payload)
			 }).success(function(data) {
			   	if(data.status.code == 1){

              $scope.userdata=data.body;
               $('#myModal').modal();
			
              localStorage.setItem('otp', data.body.id);
                // localStorage.setItem('username', data.body.name);
				// localStorage.setItem('email', data.body.email);

				window.plugins.toast.showWithOptions({
						    message: data.status.message,
						    duration: "short", // 2000 ms
						    position: "center",
						    styling: {
						      opacity: 0.75, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
						      backgroundColor: '#333333', // make sure you use #RRGGBB. Default #333333
						      textColor: '#FFFFFF', // Ditto. Default #FFFFFF
						      textSize: 20.5, // Default is approx. 13.
						      cornerRadius: 16, // minimum is 0 (square). iOS default 20, Android default 100
						      horizontalPadding: 20, // iOS default 16, Android default 50
						      verticalPadding: 16 // iOS default 12, Android default 30
						    }
						  });
				
				
				
				
//$location.path("/event");
			
						$timeout(function() {
				
						$timeout(function() { window.plugins.spinnerDialog.hide(); }, 300);
						}, 2000);
						
				}if(data.status.code == 0){
				window.plugins.spinnerDialog.hide();
				navigator.notification.alert(
						data.status.message,
						function(){},         // callback
						'',            // title
						'Done'                  // buttonName
					);
				}	
						
				});



}



 





	
$scope.logout=function(){
		
		window.localStorage.setItem("id",'');
		 $location.path("/home");
		
		}
	
});


/********************************** login controller*****************************************************/
mainApp.controller('logind', function($scope, $rootScope,$routeParams, $http, $location,$timeout,$interval,$window, Globals){
$scope.user=	window.localStorage.getItem("id");

$scope.goBack=function(){

window.history.back();

}
document.addEventListener("backbutton", callback, false);
		function callback(){
		  window.history.back();
		}


$scope.search=function(){
ActivityIndicator.show("LOADING");
$timeout(function() {
				
$timeout(function() { ActivityIndicator.hide(); }, 300);
						}, 2000);



}

document.addEventListener("deviceready", onDeviceReady, false);
function onDeviceReady() {
	
	window.plugins.PushbotsPlugin.initialize("58d92e584a9efa23148b4567", {"android":{"sender_id":"155275800804"}});

 window.plugins.PushbotsPlugin.getRegistrationId(function(token){
              

            if(token == null || token == '' || token == undefined){
                
            window.plugins.PushbotsPlugin.on("registered", function(token){
            	
                $rootScope.Usertoken = token;
                var devicePlatform = device.platform;
          
              if(devicePlatform=='Android') 
               { $rootScope.device_type = 1;}
              else 
                  {$rootScope.device_type = 0;}
                        });


            }else{
                
                $rootScope.Usertoken = token;
                var devicePlatform = device.platform;
                  if(devicePlatform=='Android') 
                   { $rootScope.device_type = 1;}
                  else 
                  {$rootScope.device_type = 0;}
            }



            });

}

$scope.login=function(){

ActivityIndicator.show("LOADING");
$http({  
			  method  : 'POST',
			  url     : Globals.ServerPath + 'login.php',
			  data    : $.param({email:$scope.email,password:$scope.password,device_type:$rootScope.device_type,device_token:$rootScope.Usertoken,user_type:3}),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			  // set the headers so angular passing info as form data (not request payload)
			 }).success(function(data) {
			   	if(data.status.code == 1){

              $scope.userdata=data.body;

             localStorage.setItem('id', data.body.id);
                localStorage.setItem('username', data.body.name);
				localStorage.setItem('email', data.body.email);
$location.path("/event");
				window.plugins.toast.showWithOptions({
						    message: data.status.message,
						    duration: "short", // 2000 ms
						    position: "bottom",
						    styling: {
						      opacity: 0.75, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
						      backgroundColor: '#333333', // make sure you use #RRGGBB. Default #333333
						      textColor: '#FFFFFF', // Ditto. Default #FFFFFF
						      textSize: 20.5, // Default is approx. 13.
						      cornerRadius: 16, // minimum is 0 (square). iOS default 20, Android default 100
						      horizontalPadding: 20, // iOS default 16, Android default 50
						      verticalPadding: 16 // iOS default 12, Android default 30
						    }
						  });
				
				
				

			
						$timeout(function() {
				
						$timeout(function() { ActivityIndicator.hide(); }, 300);
						}, 2000);
						
				}if(data.status.code == 0){
				ActivityIndicator.hide();
				navigator.notification.alert(
						data.status.message,
						function(){},         // callback
						'',            // title
						'Done'                  // buttonName
					);
				}	
						
				});



}


	
$scope.logout=function(){
		
		window.localStorage.setItem("id",'');
		 $location.path("/home");
		
		}
	
});




/********************************** userprofile controller*****************************************************/
mainApp.controller('userprofile', function($scope, $rootScope,$routeParams, $http, $location,$timeout,$interval,$window, Globals){
$scope.user=	window.localStorage.getItem("id");
		$scope.goBack=function(){
			window.history.back();
		}
		document.addEventListener("backbutton", callback, false);
		function callback(){
		  window.history.back();
		}
     $scope.username= localStorage.getItem('username');
     $scope.pic= localStorage.getItem('pic');
	 $scope.email= localStorage.getItem('email');
	
	$scope.save=function(){
	    ActivityIndicator.show("Updating Profile");
		$http({  
			  method  : 'POST',
			  url     : Globals.ServerPath + 'upd_profile.php',
			  data    : $.param({id:$scope.user,name:$scope.username,email:$scope.email,password:$scope.password}),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			  
			 }).success(function(data) {
			 
			   	if(data.status.code == 1){
                       
						 ActivityIndicator.hide(); 
						 window.plugins.toast.showWithOptions({
						    message: data.status.message,
						    duration: "short", // 2000 ms
						    position: "bottom",
						    styling: {
						      opacity: 0.75, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
						      backgroundColor: '#333333', // make sure you use #RRGGBB. Default #333333
						      textColor: '#FFFFFF', // Ditto. Default #FFFFFF
						      textSize: 20.5, // Default is approx. 13.
						      cornerRadius: 16, // minimum is 0 (square). iOS default 20, Android default 100
						      horizontalPadding: 20, // iOS default 16, Android default 50
						      verticalPadding: 16 // iOS default 12, Android default 30
						    }
						  });
					
			   localStorage.setItem('username',$scope.username);
	             localStorage.setItem('email',$scope.email);
				
				}if(data.status.code == 0){
				ActivityIndicator.hide();
				navigator.notification.alert(
						data.status.message,
						function(){},         // callback
						'',            // title
						'Done'                  // buttonName
					);
				}	
						
				});
	
	
	
	
	
	
	
	
	
	}
	
	
	
$scope.logout=function(){
		
		window.localStorage.setItem("id",'');
		 $location.path("/home");
		
		}
	
});


/********************************** lastchat controller*****************************************************/
mainApp.controller('lastchats', function($scope, $rootScope,$routeParams, $http, $location,$timeout,$interval,$window, Globals){
$scope.user=	window.localStorage.getItem("id");
$scope.goBack=function(){

window.history.back();

}
document.addEventListener("backbutton", callback, false);
		function callback(){
		  window.history.back();
		}
$rootScope.tabId=1;
$scope.chat=function(f_id,name){

$location.path("/chat/"+f_id+"/"+name);

}

	 $scope.date=function(tt){
console.log(tt);
var date = new Date(tt*1000);

var hours = date.getHours();

var minutes = "0" + date.getMinutes();

var seconds = "0" + date.getSeconds();


var formattedTime = hours + ':' + minutes.substr(-2) ;


return formattedTime;


}

 window.plugins.spinnerDialog.show(null, "loading...");
			$http({  
			  method  : 'POST',
			  url     : Globals.ServerPath + 'getlastchat.php',
			  data    : $.param({user_id:$scope.user}),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			  // set the headers so angular passing info as form data (not request payload)
			 }).success(function(data) {
			   	if(data.status.code == 1){

              $scope.last=data.body;
						$timeout(function() {
				
						$timeout(function() { window.plugins.spinnerDialog.hide(); }, 300);
						}, 2000);
						
				}if(data.status.code == 0){
				window.plugins.spinnerDialog.hide();
				navigator.notification.alert(
						data.status.message,
						function(){},         // callback
						'',            // title
						'Done'                  // buttonName
					);
				}	
						
				}); 



document.addEventListener("deviceready", onDeviceReady, false);
				function onDeviceReady() {
					window.plugins.PushbotsPlugin.initialize("58776e814a9efa34e28b4567", {"android":{"sender_id":"858929087471"}});
	window.plugins.PushbotsPlugin.on("notification:clicked", function(data){
		$scope.friend_id=data.sender_id;
		//alert($scope.friend_id);
	$location.path("/chat/"+$scope.friend_id);
			$scope.$apply();
	console.log("clicked:" + JSON.stringify(data));
	 }); }
 
	

	
$scope.logout=function(){
		
		window.localStorage.setItem("id",'');
		 $location.path("/login");
		
		}
	
});

/**********************************chat*****************************************************/
mainApp.controller('chat', function($scope, $rootScope, $http, $location,$timeout,$interval,$window, Globals,$routeParams){
$rootScope.tabId=1;
	 $scope.goBack = function() {
        window.history.back();
    }
   $("#myModal").modal('hide');
	
	 document.addEventListener("backbutton", callback, false);
		function callback(){
		  window.history.back();
		}
	 $("#chat").animate({ scrollTop: $('#chat').prop("scrollHeight")}, 100);	
	 $("#chat").animate({
					scrollTop:  $("#chat")[0].scrollHeight + 1000
				  },
					'slow');
	 
	 $scope.timestamp=function(tt){
console.log(tt);
var date = new Date(tt*1000);

var hours = date.getHours();

var minutes = "0" + date.getMinutes();

var seconds = "0" + date.getSeconds();


var formattedTime = hours + ':' + minutes.substr(-2) ;


return formattedTime;


}
	
				
	
	
	
$scope.sender_id1=window.localStorage.getItem("id");


					 $scope.sender_id1=window.localStorage.getItem("id");
		console.log($routeParams.friend_id);
		console.log($routeParams.name);	
		console.log($routeParams.pic);	
		$scope.name=$routeParams.name;
		$scope.pic=$routeParams.pic;	
		$("html, body").animate({ scrollTop: $(document).height() }, 1000);
		
		
		$scope.sendmessage=function(){
		
			$("#chat").animate({ scrollTop: $('#chat').prop("scrollHeight")}, 1);	
	
	$scope.sender_id=window.localStorage.getItem("id");
		
		$scope.message1=$scope.message;
		$scope.message="";
		 $routeParams.friend_id;
		// alert($routeParams.friend_id);
			$http({  
			  method  : 'POST',
			  url     : Globals.ServerPath + 'chat.php',
			  data    : $.param({sender_id:$scope.sender_id,friend_id:$routeParams.friend_id,message:$scope.message1}),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			  
			 }).success(function(data) {
			   	if(data.status.code == 1){
					$scope.chat="";
				
					 
							 $("#chat").animate({
					scrollTop:  $("#chat")[0].scrollHeight + 1000
				  },
					'slow');
							
				}if(data.status.code == 0){
				window.plugins.spinnerDialog.hide();
				navigator.notification.alert(
						data.status.message,
						function(){},         // callback
						'',            // title
						'Done'                  // buttonName
					);
				}	
						
				}); 
			}
	
		$scope.sender_id=window.localStorage.getItem("id");
		
		$scope.message;
		 $routeParams.friend_id;
		$rootScope.arraylendhy = '';
		 if($scope.sender_id>0 && $routeParams.friend_id>0  ){
			 
	$("#chat").animate({ scrollTop: $('#chat').prop("scrollHeight")}, 1000);	
	
       $interval(function () {
 
		$http({  
			  method  : 'POST',
			  url     : Globals.ServerPath + 'getmessage.php',
			  data    : $.param({sender_id:$scope.sender_id,friend_id:$routeParams.friend_id}),  // pass in data as strings
			  headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
			  // set the headers so angular passing info as form data (not request payload)
			 }).success(function(data) {
			   	if(data.status.code == 1){
					

			$scope.getchat=data.body;
			if($rootScope.arraylendhy =='' || $rootScope.arraylendhy < data.body.length){
			$rootScope.arraylendhy = data.body.length;
			
		$("#chat").animate({
					scrollTop:  $("#chat")[0].scrollHeight + 1000
				  },
					'slow');

		}				$timeout(function() {
						$timeout(function() { window.plugins.spinnerDialog.hide(); }, 300);
						}, 2000);
				}if(data.status.code == 0){
				window.plugins.spinnerDialog.hide();
			
				}	
						
				});
 }, 1000);
       $scope.friend_id=$routeParams.friend_id;
  
   			if($scope.chat_id>0){
				alert($scope.chat_id);
				$("html, body").animate({ scrollTop: $(document).height() }, 100);
				}
  }
   			

});









/********************************** PAYMENT controller*****************************************************/
mainApp.controller('paymentController', function($scope, $rootScope, $http, $location,$timeout,$interval,$window, Globals){
	 $scope.goBack = function() {
        window.history.back();
    }
console.log($rootScope.BookingDetails);
    });
   

