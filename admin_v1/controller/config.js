/*******************************NgAPP****************************************************/

angular.module("admin_app", ['ngRoute','admin.controller','dashboard','profile','plan','category','ads','transaction','ngAnimate','users','oitozero.ngSweetAlert'])

/** create the factory for api path **/



/**** check the session *****/
.run(function ($rootScope, $location,$http) {
	//console.log("czxcxc"+window.localStorage.getItem('admin_info'));
	if(window.localStorage.getItem('admin_info')!=undefined && window.localStorage.getItem('admin_info')!=''){
			$rootScope.login=0;
			console.log(window.localStorage.getItem('admin_info'));
			$rootScope.admin_info=JSON.parse(window.localStorage.getItem('admin_info'));
	}else{
			$rootScope.login=1;
	}

  $rootScope._data=[];
  $http.get('./config.json').then(function (result) {
           $rootScope._data = result.data;
           console.log($rootScope._data.App_name);
       }, function(data) {
       });

})


/******************* routeing ************************/


.config(function($routeProvider) {
    $routeProvider
   .when('/', {
            templateUrl: 'html/dashboard1.html',
             controller: 'dashboard',
						 animation: 'third'
        })
   .when('/users', {
            templateUrl: 'html/users.html',
             controller: 'Users',
						  animation: 'third'
        })
   .when('/add_user', {
            templateUrl: 'html/add_users.html',
             controller: 'Users',
						  animation: 'third'
        })
   .when('/category', {
            templateUrl: 'html/category.html',
             controller: 'category',
						  animation: 'third'
        })
   .when('/type', {
            templateUrl: 'html/type.html',
             controller: 'category',
						  animation: 'third'
        })
   .when('/make', {
            templateUrl: 'html/make.html',
             controller: 'category',
						  animation: 'third'
        })
   .when('/model', {
            templateUrl: 'html/model.html',
             controller: 'category',
						  animation: 'third'
        })
   .when('/active', {
            templateUrl: 'html/active.html',
             controller: 'Ads',
						  animation: 'third'
        })
   .when('/sold', {
            templateUrl: 'html/sold.html',
             controller: 'Ads',
						  animation: 'third'
        })
   .when('/expires', {
            templateUrl: 'html/expires.html',
             controller: 'Ads',
						  animation: 'third'
        })
   .when('/plan', {
            templateUrl: 'html/plan.html',
             controller: 'plan',
						  animation: 'third'
        })
   .when('/transaction', {
            templateUrl: 'html/transaction.html',
             controller: 'transaction',
						  animation: 'third'
        })
   .when('/add_type', {
            templateUrl: 'html/add_type.html',
             controller: 'category',
						  animation: 'third'
        })
   .when('/add_plan', {
            templateUrl: 'html/add_plan.html',
             controller: 'plan',
						  animation: 'third'
        })
   .when('/buy_plan', {
            templateUrl: 'html/buy_plan.html',
             controller: 'plan',
						  animation: 'third'
        })
   .when('/transaction', {
            templateUrl: 'html/transaction.html',
             controller: 'plan',
						  animation: 'third'
        })
   .when('/balance', {
            templateUrl: 'html/total_blance.html',
             controller: 'profile',
						  animation: 'third'
        })
   .when('/profile', {
            templateUrl: 'html/profile.html',
             controller: 'profile',
						  animation: 'third'
        })
   .when('/dashboard1', {
            templateUrl: 'html/dashboard1.html',
             controller: 'dashboard',
						  animation: 'third'
        }).otherwise({
            redirectTo: '/'
        });

});
