<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="<?php echo $this->webroot ?>webhtml/js/jquery.loader.js"></script>

<script>
    var app = angular.module("carbook", ["ngRoute", "ngAnimate"]);
    app.config(function ($routeProvider) {
        $routeProvider
                .when("/", {
                    templateUrl: "<?php echo $this->webroot ?>html/profile.html",
                    controller: "update_profile",
                    animate: "slideRight"
                })
                .when("/details/:id", {
                    templateUrl: "<?php echo $this->webroot ?>html/details.html",
                    controller: "product_details",
                    animate: "slideRight"
                })
                .when("/buy_plan", {
                    templateUrl: "<?php echo $this->webroot ?>html/plan.html",
                    controller: "buy_plan",
                    animate: "slideRight"
                })
                .when("/dashboard", {
                    templateUrl: "<?php echo $this->webroot ?>html/searchdata.html",
                    controller: "dashboard",
                    animate: "slideRight"
                })
                .when("/buyer_dashboard", {
                    templateUrl: "<?php echo $this->webroot ?>html/searchdata.html",
                    controller: "buyer_dashboard",
                    animate: "slideRight"
                })
                .when("/fav", {
                    templateUrl: "<?php echo $this->webroot ?>html/fav.html",
                    controller: "fav",
                    animate: "slideRight"
                })
                .when("/seller_dashboard", {
                    templateUrl: "<?php echo $this->webroot ?>html/add_product.html",
                    controller: "seller_dashboard"
                })
                .when("/myprofile/:id", {
                    templateUrl: "<?php echo $this->webroot ?>html/edit_profile.html",
                    controller: "profile",
                    animate: "slideRight"
                })
                .when("/chat", {
                    templateUrl: "<?php echo $this->webroot ?>html/chat.html",
                    controller: "chat",
                    animate: "slideRight"
                })
                .when("/setting", {
                    templateUrl: "<?php echo $this->webroot ?>html/setting.html",
                    controller: "setting",
                    animate: "slideRight"
                })
                .when("/checkout", {
                    templateUrl: "<?php echo $this->webroot ?>html/checkout.html",
                    controller: "buy_plan",
                    animate: "slideRight"
                })
                .when("/seller_listing", {
                    templateUrl: "<?php echo $this->webroot ?>html/seller_listing.html",
                    controller: "seller_listing",
                    animate: "slideRight"
                })
                .when("/guest", {
                    templateUrl: "<?php echo $this->webroot ?>html/guest.html",
                    controller: "guest",
                    animate: "slideRight"
                })
                .when("/listing", {
                    templateUrl: "<?php echo $this->webroot ?>html/location.html",
                    controller: "listing",
                    animate: "slideRight"
                });
    });


    app.factory('timeago', function () {
        return {
            timeDifference: function (time) {
                var units = [
                    {name: "second", limit: 60, in_seconds: 1},
                    {name: "minute", limit: 3600, in_seconds: 60},
                    {name: "hour", limit: 86400, in_seconds: 3600},
                    {name: "day", limit: 604800, in_seconds: 86400},
                    {name: "week", limit: 2629743, in_seconds: 604800},
                    {name: "month", limit: 31556926, in_seconds: 2629743},
                    {name: "year", limit: null, in_seconds: 31556926}
                ];
                var diff = (new Date() - new Date(time * 1000)) / 1000;
                if (diff < 5)
                    return "now";

                var i = 0, unit;
                while (unit = units[i++]) {
                    if (diff < unit.limit || !unit.limit) {
                        var diff = Math.floor(diff / unit.in_seconds);
                        return diff + " " + unit.name + (diff > 1 ? "s" : "");
                    }
                }

            },
            left_days: function (time) {
                var now_time = parseInt(new Date().getTime() / 1000);
                var timeDiff = Math.abs(time - now_time);
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                return diffDays;
            },
            read_date: function (time) {
                var date = new Date(time * 1000);
                return date.getDay() + "/" + date.getMonth() + "/" + date.getFullYear()
            }
        };
    });

    app.run(function ($rootScope, $location, timeago) {
        console.log(window.localStorage.getItem('users'));
        if (window.localStorage.getItem('users') != undefined && window.localStorage.getItem('users') != null && window.localStorage.getItem('users') != '') {
            $rootScope.userinfo = JSON.parse(window.localStorage.getItem('users'));
            $rootScope.email = $rootScope.userinfo.body.email;
            $rootScope.phone = $rootScope.userinfo.body.phone;
            $rootScope.name = $rootScope.userinfo.body.name;
            $rootScope.state = $rootScope.userinfo.body.state;
            $rootScope.city = $rootScope.userinfo.body.city;
            $rootScope.zip_code = $rootScope.userinfo.body.zip_code;
            $rootScope.is_owen = 0;
            $rootScope.image = $rootScope.userinfo.body.photo;
            $rootScope.is_buyer = $rootScope.userinfo.body.is_buyer;
            if ($rootScope.is_buyer == 1) {
                $rootScope.page = "My Listing";
            } else {
                $rootScope.page = "All Post";
            }
            $rootScope.login_name = ($rootScope.is_buyer == '0') ? 'I am Buyer' : 'I am Seller';
            $rootScope.allnotification = [];
            $rootScope.counts = 0;
            getnotification();
            setInterval(getnotification, 30000);
            function getnotification() {
                $.ajax({
                    type: 'get',
                    headers: {
                        authorization_key: $rootScope.userinfo.body.authorization_key
                    },
                    url: '<?php echo $this->webroot . 'apis/Get_notification'; ?>', // point to server-side PHP script
                    beforeSend: function () {
                        $(".myloader").show();
                    },
                    success: function (data) {

                        data = JSON.parse(data);
                        $rootScope.allnotification = data.body;
                        $rootScope.counts = data.body.length;
                        //$scope.$apply();
                    }, error: function (data) {
                        console.log(data);
                        data = JSON.parse(data.responseText);
                        swal("Error", data.error_message, "error");
                    }
                });
            }
            $rootScope.is_guest = 0;
        } else {
            $rootScope.is_guest = 1;
            $rootScope.login_name = "Guest";
            $location.path("guest");
        }


    });


    app.controller("profile", function ($scope, $rootScope, $location, $routeParams, timeago) {
        $rootScope.classactive = "profile";
        $rootScope.is_active = 1;
        $rootScope.userinfo = JSON.parse(window.localStorage.getItem('users'));
        console.log($rootScope.userinfo);
        if ($routeParams.id == 0) {
            $rootScope.is_profile = 0;
            $rootScope.email = $rootScope.userinfo.body.email;
            $rootScope.phone = $rootScope.userinfo.body.phone;
            $rootScope.name = $rootScope.userinfo.body.name;
            $rootScope.state = $rootScope.userinfo.body.state;
            $rootScope.city = $rootScope.userinfo.body.city;
            $rootScope.zip_code = $rootScope.userinfo.body.zip_code;
            $rootScope.address_one = $rootScope.userinfo.body.address_one;
            $rootScope.address_two = $rootScope.userinfo.body.address_two;
            $rootScope.is_owen = 0;
            $rootScope.image = $rootScope.userinfo.body.photo;
        } else {
            $rootScope.is_profile = 1;
            $scope.friend_info = JSON.parse(window.localStorage.getItem('friend_info'));
            $rootScope.email = $scope.friend_info.email;
            $rootScope.phone = $scope.friend_info.phone;
            $rootScope.name_name = $scope.friend_info.name;
            $rootScope.state = $scope.friend_info.state;
            $rootScope.city = $scope.friend_info.city;
            $rootScope.zip_code = $scope.friend_info.zip_code;
            $rootScope.is_owen = 0;
            $rootScope.image = $scope.friend_info.photo;

        }

        $scope.showphone = function () {
            swal({
                title: 'Phone',
                text: $rootScope.phone
            });
        }
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.profile_image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imageprofile").change(function () {
            readURL(this);
        });

        $scope.upload_image = function () {
            var data = new FormData();
            image = $("#imageprofile")[0].files[0];
            if (image == undefined) {
                swal("Error", "Please Select image", "error");
                return false;
            }
            data.append('image', image);
            $.ajax({
                type: 'post',
                url: '<?php echo $this->webroot . 'apis/ProfileUpdate'; ?>', // point to server-side PHP script
                dataType: 'text', // what to expect back from the PHP script, if anything
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                beforeSend: function () {
                    swal({
                        text: "Please Wait..",
                        icon: "<?php echo $this->webroot ?>webhtml/images/spinner.gif",
                        buttons: false,
                        closeOnEsc: false,
                        closeOnClickOutside: false,
                    });
                },
                success: function (data) {
                    window.localStorage.setItem('users', data);
                    data = JSON.parse(data);
                    $rootScope.image = data.body.photo;
                    swal("Information", data.message, "success");
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }

        $scope.updateProfile = function () {
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/ProfileUpdate'; ?>', // point to server-side PHP script
                data: {name: $scope.name, state: $scope.state, zip_code: $scope.zip_code, city: $scope.city, address_one: $rootScope.address_one, address_two: $rootScope.address_two},
                beforeSend: function () {
                    swal({
                        text: "Please Wait..",
                        icon: "<?php echo $this->webroot ?>webhtml/images/spinner.gif",
                        buttons: false,
                        closeOnEsc: false,
                        closeOnClickOutside: false,
                    });
                },
                success: function (data) {
                    window.localStorage.setItem('users', data);
                    data = JSON.parse(data);
                    swal("Information", data.message, "success");
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }
    });

    app.controller("chat", function ($scope, $rootScope, $location, timeago) {
        $rootScope.classactive = "chat";
        $rootScope.is_active = 1;
        $rootScope.userinfo = JSON.parse(window.localStorage.getItem('users'));
        $rootScope.name = $rootScope.userinfo.body.name;
        $scope.friend_id = 0;
        $scope.ad_id = 0;
        $scope.is_on = 0;

        $scope.getchat = function (chat) {
            $scope.friend_id = chat.friend_info.id;
            $scope.ad_id = chat.ad_id;
            $scope.friend_name = chat.friend_info.name;
            $scope.friend_image = chat.friend_info.photo;
            $scope.is_on = 1;
            getallchat();
            //setInterval(getallchat, 6000);
            $scope.$apply();
        }

        $scope.gettime = function (time) {
            return timeago.timeDifference(time);
        }

        function getallchat() {
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/get_message'; ?>', // point to server-side PHP script
                data: {friend_id: $scope.friend_id, ad_id: $scope.ad_id},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $rootScope.allchat = data.body;
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }


        $.ajax({
            type: 'get',
            headers: {
                authorization_key: $rootScope.userinfo.body.authorization_key
            },
            url: '<?php echo $this->webroot . 'apis/last_chat'; ?>', // point to server-side PHP script

            beforeSend: function () {
                $(".myloader").show();
            },
            success: function (data) {
                data = JSON.parse(data);
                $rootScope.lastchat = data.body;
                $scope.$apply();
            }, error: function (data) {
                console.log(data);
                data = JSON.parse(data.responseText);
                swal("Error", data.error_message, "error");
            }
        });
        $scope.sendmesssage = function () {
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/send_message'; ?>', // point to server-side PHP script
                data: {friend_id: $scope.friend_id, message: $scope.message, message_type: 0, ad_id: $scope.ad_id},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $scope.message = '';
                    $rootScope.allchat.push(data.body);
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }
    });

    app.controller("setting", function ($scope, $rootScope, $location) {
        $rootScope.classactive = "setting";
        $rootScope.is_active = 1;
        $rootScope.userinfo = JSON.parse(window.localStorage.getItem('users'));
        $rootScope.is_notification_on = $rootScope.userinfo.body.is_notification_on;
        $rootScope.name = $rootScope.userinfo.body.name;
        $scope.show = function (id) {
            $("#info").show();
        }
        $scope.updateProfile = function () {

            if ($rootScope.is_notification_on == 1) {
                $rootScope.is_notification_on = 0;
            } else {
                $rootScope.is_notification_on = 1;
            }
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/ProfileUpdate'; ?>', // point to server-side PHP script
                data: {is_notification_on: $rootScope.is_notification_on},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {

                    window.localStorage.setItem('users', data);
                    data = JSON.parse(data);
                    //swal("Information", "", "success");
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }
    });

    app.controller("buy_plan", function ($scope, $rootScope, $location, timeago) {
        $rootScope.classactive = "dashbord";
        $rootScope.is_active = 1;
        $rootScope.userinfo = JSON.parse(window.localStorage.getItem('users'));
        $rootScope.is_notification_on = $rootScope.userinfo.body.is_notification_on;
        $rootScope.name = $rootScope.userinfo.body.name;
        $rootScope.state = $rootScope.userinfo.body.state;
        $rootScope.is_buyer = $rootScope.userinfo.body.is_buyer;
        $rootScope.city = $rootScope.userinfo.body.city;
        $rootScope.zip_code = $rootScope.userinfo.body.zip_code;
        $rootScope.planinfo = $rootScope.userinfo.body.plan_info;
        if ($rootScope.is_buyer == 0) {
            $location.path("buyer_dashboard");
        }
        if ($rootScope.planinfo.lenght == 0) {
            $rootScope.offer = $rootScope.planinfo.total_count;
            $rootScope.plan_name = $rootScope.planinfo.plan_details.name;
            $rootScope.plan_price = $rootScope.planinfo.plan_details.price;
        }
        $rootScope.plandetails = '';
        if ($rootScope.plandetails == '') {
            $rootScope.plandetails = JSON.parse(window.localStorage.getItem('select_plan_id'));
        }

        $.ajax({
            type: 'get',
            url: '<?php echo $this->webroot . 'apis/get_all_plan'; ?>', // point to server-side PHP script  
            beforeSend: function () {
                $(".myloader").show();
            },
            success: function (data) {
                data = JSON.parse(data);
                $rootScope.plan_list = data.body;
                $scope.$apply();
            }, error: function (data) {
                console.log(data);
                data = JSON.parse(data.responseText);
                swal("Error", data.error_message, "error");
            }
        });

        $scope.select_plan = function (plan) {
            $rootScope.plandetails = plan;
            window.localStorage.setItem('select_plan_id', JSON.stringify(plan));
            $location.path("checkout");
        }

        $scope.buy_plan_now = function () {

            $.ajax({
                type: 'post',
                url: '<?php echo $this->webroot . 'apis/paypalpro'; ?>', // point to server-side PHP script  
                data: {card_number: $scope.card_number, amount: $rootScope.plandetails.price, cvv: $scope.cvv, card_number: $scope.card_number, expiry_month: $scope.expiry_month, expiry_year: $scope.expiry_year},
                beforeSend: function () {
                    swal({

                        text: "Please Wait. Payment on progressing..",
                        icon: "<?php echo $this->webroot ?>webhtml/images/spinner.gif",
                        buttons: false,
                        closeOnEsc: false,
                        closeOnClickOutside: false,
                    });
                },
                success: function (data) {
                    data = JSON.parse(data);

                    if (data.body.ACK == 'Failure') {
                        $('.purchase').loader('hide');
                        swal("Error", data.body.L_SHORTMESSAGE0, "error");
                        return false;
                    }
                    $.ajax({
                        type: 'post',
                        headers: {
                            authorization_key: $rootScope.userinfo.body.authorization_key
                        },
                        url: '<?php echo $this->webroot . 'apis/buyPlan'; ?>', // point to server-side PHP script  
                        data: {plan_id: $rootScope.plandetails.id, transaction_no: "cxzcxzcxzc"},
                        beforeSend: function () {
                            $(".myloader").show();
                        },
                        success: function (data) {
                            window.localStorage.setItem('users', data);
                            swal("information", "Payment Done", "success");
                            $location.path("seller_dashboard");
                            $scope.$apply();
                        }, error: function (data) {
                            console.log(data);
                            data = JSON.parse(data.responseText);
                            $('.purchase').loader('hide');
                            swal("Error", data.error_message, "error");
                        }
                    });
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    $('.purchase').loader('hide');
                    swal("Error", data.error_message, "error");
                }
            });
        }
    });



    app.controller("fav", function ($scope, $rootScope, $location, timeago) {
        $rootScope.classactive = "fav";
        $rootScope.is_active = 1;
        $rootScope.userinfo = JSON.parse(window.localStorage.getItem('users'));
        $rootScope.is_notification_on = $rootScope.userinfo.body.is_notification_on;
        $rootScope.is_buyer = $rootScope.userinfo.body.is_buyer;
        $rootScope.name = $rootScope.userinfo.body.name;

        $scope.details = function (ad) {
            window.localStorage.setItem('ads', JSON.stringify(ad));
            $location.path("details/0");
        }

        $.ajax({
            type: 'get',
            headers: {
                authorization_key: $rootScope.userinfo.body.authorization_key
            },
            url: '<?php echo $this->webroot . 'apis/getFav'; ?>', // point to server-side PHP script

            beforeSend: function () {
                $(".myloader").show();
            },
            success: function (data) {
                data = JSON.parse(data);
                $rootScope.fav = data.body;
                //console.log($rootScope.fav);
                $scope.$apply();
            }, error: function (data) {
                console.log(data);
                data = JSON.parse(data.responseText);
                swal("Error", data.error_message, "error");
            }
        });
        $scope.favs = function (ads, index) {
            if (ads.is_fav == 1) {
                ads.is_fav = 0;
            } else {
                ads.is_fav = 1;
            }

            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/do_fav'; ?>', // point to server-side PHP script
                data: {ad_id: ads.id},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    $rootScope.fav.splice(index, 1);
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }
    });



    app.controller("dashboard", function ($scope, $rootScope, $location, timeago) {
        $rootScope.classactive = "dashboard";
        $rootScope.is_active = 1;
        $rootScope.userinfo = JSON.parse(window.localStorage.getItem('users'));
        $rootScope.is_buyer = $rootScope.userinfo.body.is_buyer;
        $rootScope.plan_info = $rootScope.userinfo.body.plan_info;

        if ($rootScope.is_buyer == 0) {
            $location.path("buyer_dashboard");
        } else {
            if ($rootScope.plan_info.length == '0') {
                $location.path("buy_plan");

            } else {
                $location.path("seller_dashboard");
            }
        }
    });

    app.controller("buyer_dashboard", function ($scope, $rootScope, $location, timeago) {
        $rootScope.classactive = "dashboard";
        $rootScope.is_active = 1;
        $rootScope.is_search = 1;
        $rootScope.userinfo = JSON.parse(window.localStorage.getItem('users'));
        $rootScope.is_buyer = $rootScope.userinfo.body.is_buyer;
        $rootScope.name = $rootScope.userinfo.body.name;
        $rootScope.is_buyer = $rootScope.userinfo.body.is_buyer;
        if ($rootScope.is_buyer == 1) {
            $location.path("seller_dashboard");
        }
        $scope.details = function (ad) {
            window.localStorage.setItem('ads', JSON.stringify(ad));
            $location.path("details/0");
        }

        $.ajax({
            type: 'get',

            url: '<?php echo $this->webroot . 'apis/get_all_category'; ?>', // point to server-side PHP script

            beforeSend: function () {
                $(".myloader").show();
            },
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                $rootScope.category = data.body;
            }, error: function (data) {
                console.log(data);
                data = JSON.parse(data.responseText);
                swal("Error", data.error_message, "error");
            }
        });

        $.get("http://freegeoip.net/json/", function (data, status) {
            $scope.lat = data.latitude;
            $scope.long = data.longitude;
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/getAds'; ?>', // point to server-side PHP script
                data: {latitude: $scope.lat, longitude: $scope.long},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    data = JSON.parse(data);
                    console.log(data.body);
                    $rootScope.car_details = data.body;
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        });
        $scope.find = function () {

            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/getAds'; ?>', // point to server-side PHP script
                data: {latitude: $scope.lat, longitude: $scope.long, make: $rootScope.make, modal: $rootScope.modal, from_price: $rootScope.from_price, to_price: $rootScope.to_price, from_year: $rootScope.from_year, to_year: $rootScope.to_year},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    data = JSON.parse(data);
                    console.log(data.body);
                    $rootScope.car_details = data.body;
                    $location.path("listing");
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }
    });


    app.controller("notification", function ($scope, $rootScope, $location, timeago) {
        $scope.delete_noti = function (id, index) {
            $.ajax({
                type: 'get',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/delete_notification'; ?>?notification_id=' + id, // point to server-side PHP script

                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    $rootScope.allnotification.splice(index, 1);
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });

        }
        $scope.logout = function () {
            window.localStorage.setItem('users', '');
            window.location = "<?php echo $this->webroot ?>users/logout";
        }
    });

    app.controller("seller_dashboard", function ($scope, $rootScope, $location, timeago) {
        $rootScope.classactive = "dashboard";
        $rootScope.is_active = 1;
        $rootScope.userinfo = JSON.parse(window.localStorage.getItem('users'));
        $rootScope.is_buyer = $rootScope.userinfo.body.is_buyer;
        $rootScope.name = $rootScope.userinfo.body.name;
        $rootScope.plan_info = $rootScope.userinfo.body.plan_info;
        $rootScope.offer = $rootScope.plan_info.total_count;
        $rootScope.is_buyer = $rootScope.userinfo.body.is_buyer;
        $rootScope.plan = new Date($rootScope.plan_info.expire_time * 1000);
        $rootScope.is_buyer = $rootScope.userinfo.body.is_buyer;
        if ($rootScope.is_buyer == 0) {
            $location.path("buyer_dashboard");
        }
        $rootScope.step = 1;
        $scope.ad_data = [];
        $scope.ad_data.is_new = 0;
        $scope.renew_plan = function () {
            $location.path("buy_plan");
        }
        $scope.new_old = function (val) {
            $scope.ad_data.is_new = val;
        }

        $("#fileUpload").on('change', function () {
            show_image(this);
        });

        $scope.step_complete = function (val) {
            $rootScope.step = val + 1;
            $(".step" + val).hide();
            $(".step" + $rootScope.step).show();
        }

        function show_image(file)
        {

            var countFiles = file.files.length;

            var imgPath = file.value;

            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

            var image_holder = $(".image-holder");
            image_holder.empty();

            var audio_holder = $("#audio_holder");
            audio_holder.empty();

            var video_holder = $("#video_holder");
            video_holder.empty();

            if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg" || extn == "mp3" || extn == "mp4" || extn == "wav")
            {
                if (typeof (FileReader) != "undefined")
                {
                    for (var i = 0; i < countFiles; i++)
                    {
                        var reader = new FileReader();

                        imgPath = file.files[i].name;
                        reader.onload = function (e) {
                            var _extn = e.target.result.split('/');
                            extn = _extn[1].split(';');
                            extn = extn[0].toLowerCase();
                            if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg")
                            {
                                $(".texting").append('<div class="col-md-4 image-holder"><img src="' + e.target.result + '" ></div>');

                            } else if (extn == "mp3" || extn == "wav")
                            {


                                $("<audio/>", {
                                    "src": e.target.result,
                                    'type': 'audio/mp3',
                                    "width": 100,
                                    "height": 30,
                                    'controls': true
                                }).appendTo(audio_holder);

                            } else if (extn == "mp4")
                            {


                                $("<video/>", {
                                    "src": e.target.result,
                                    'type': 'video/mp4',
                                    "width": 100,
                                    "height": 100,
                                    'controls': true
                                }).appendTo(video_holder);

                            }

                        }
                        image_holder.show();
                        reader.readAsDataURL(file.files[i]);
                    }
                } else
                {
                    alert("This browser does not support FileReader.");
                }
            } else
            {
                alert("Pls select only images");
            }

        }

        $.ajax({
            type: 'get',

            url: '<?php echo $this->webroot . 'apis/get_all_category'; ?>', // point to server-side PHP script

            beforeSend: function () {
                $(".myloader").show();
            },
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                $rootScope.category = data.body;
            }, error: function (data) {
                console.log(data);
                data = JSON.parse(data.responseText);
                swal("Error", data.error_message, "error");
            }
        });

        $scope.gettype = function (i) {

            $.ajax({
                type: 'get',
                url: '<?php echo $this->webroot . 'apis/get_all_type'; ?>', // point to server-side PHP script
                data: {category_id: $scope.ad_data.category_id},
                beforeSend: function () {

                },
                success: function (data) {
                    data = JSON.parse(data);
                    $rootScope.type = data.body;
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }

        $scope.get_latlong = function () {
            $.ajax({
                type: 'get',
                url: 'http://maps.googleapis.com/maps/api/geocode/json?address=' + $scope.ad_data.zip_code, // point to server-side PHP script
                beforeSend: function () {

                },
                success: function (data) {

                    $scope.ad_data.latitude = data.results[0].geometry.viewport.northeast.lat;
                    $scope.ad_data.longitude = data.results[0].geometry.viewport.northeast.lng;
                    $scope.ad_data.location = data.results[0].formatted_address;
                    $scope.ad_data.city = data.results[0].address_components[1].long_name;
                    $scope.ad_data.state = data.results[0].formatted_address;
                    $scope.ad_data.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
            //http://maps.googleapis.com/maps/api/geocode/json?address=174303
        }
        $scope.addnew = function () {
            var data = new FormData($scope.ad_data);
            image = $("#fileUpload")[0].files[0];
            if (image == undefined) {
                swal("Error", "Please Select Atleast one pic", "error");
                return false;
            } else {
                data.append('image[]', image);
                data.append('category_id', $scope.ad_data.category_id);
                data.append('type_id', $scope.ad_data.type_id);
                data.append('make', $scope.ad_data.make);
                data.append('modal', $scope.ad_data.modal);
                data.append('price', $scope.ad_data.price);
                data.append('mileage', $scope.ad_data.mileage);
                data.append('is_new', $scope.ad_data.is_new);
                data.append('year', $scope.ad_data.year);
                data.append('modified_date', $scope.ad_data.modified_date);
                data.append('state', $scope.ad_data.state);
                data.append('zip_code', $scope.ad_data.zip_code);
                data.append('location', $scope.ad_data.location);
                data.append('latitude', $scope.ad_data.latitude);
                data.append('longitude', $scope.ad_data.longitude);
                data.append('mileage', $scope.ad_data.mileage);
                data.append('fuel_type', $scope.ad_data.fuel_type);
                data.append('transmission', $scope.ad_data.transmission);
                data.append('condition', $scope.ad_data.condition);
                data.append('manual', $scope.ad_data.manual);
                data.append('vin_no', $scope.ad_data.vin_no);
                data.append('doors', $scope.ad_data.doors);
                data.append('miles', $scope.ad_data.miles);
                data.append('drive_unit', $scope.ad_data.drive_unit);
                data.append('drive_type', $scope.ad_data.drive_type);
                data.append('wheel', $scope.ad_data.wheel);
                data.append('tire', $scope.ad_data.tire);
                data.append('exterior_color', $scope.ad_data.exterior_color);
                data.append('interior_color', $scope.ad_data.interior_color);
                data.append('passenger_capacity', $scope.ad_data.passenger_capacity);
                data.append('engine', $scope.ad_data.engine);
                data.append('horse_power', $scope.ad_data.horse_power);
                data.append('basic_warranty', $scope.ad_data.basic_warranty);
                data.append('powertrain_warranty', $scope.ad_data.powertrain_warranty);
                data.append('stock_number', $scope.ad_data.stock_number);
                data.append('braking_traction', $scope.ad_data.braking_traction);
                data.append('comfort_convenience', $scope.ad_data.comfort_convenience);
                data.append('entertainment_instrumentation', $scope.ad_data.entertainment_instrumentation);
                data.append('lighting', $scope.ad_data.lighting);
                data.append('roofs_glass', $scope.ad_data.roofs_glass);
                data.append('safety_security', $scope.ad_data.safety_security);
                data.append('seats', $scope.ad_data.seats);
                data.append('steering', $scope.ad_data.steering);
                data.append('wheels_tires', $scope.ad_data.wheels_tires);
                data.append('additional_information', $scope.ad_data.additional_information);
            }
            $.ajax({
                type: 'post',
                url: '<?php echo $this->webroot . 'apis/addAd'; ?>', // point to server-side PHP script
                dataType: 'text', // what to expect back from the PHP script, if anything
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                beforeSend: function () {
                    swal({
                        text: "Please Wait..Your Post Publish",
                        icon: "<?php echo $this->webroot ?>webhtml/images/spinner.gif",
                        buttons: false,
                        closeOnEsc: false,
                        closeOnClickOutside: false,
                    });
                },
                success: function (data) {
                    data = JSON.parse(data);
                    swal("Information", data.message, "success");
                    $location.path("listing");
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }

    });



    app.controller("update_profile", function ($scope, $rootScope, $location, timeago) {
        $rootScope.classactive = "profile";
        $rootScope.is_active = 1;
        $rootScope.userinfo = JSON.parse(window.localStorage.getItem('users'));
        $rootScope.userinfo = $rootScope.userinfo.body;
        $rootScope.email = $rootScope.userinfo.email;
        $rootScope.phone = $rootScope.userinfo.phone;
        $rootScope.is_buyer = $rootScope.userinfo.is_buyer;
        if ($rootScope.userinfo.name == '') {
            $rootScope.is_active = 0;
        } else {
            if ($rootScope.is_buyer == 0) {
                $location.path("buyer_dashboard");
            } else {
                if ($rootScope.userinfo.plan_info.length == 0) {
                    $location.path("buy_plan");
                } else {
                    $location.path("seller_dashboard");
                }

            }

        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.profile_image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imageprofile").change(function () {
            readURL(this);
        });
        $scope.updateProfile = function () {
            image = $("#imageprofile")[0].files[0];
            var data = new FormData
            if (image != undefined) {
                data.append('image', image);
            }
            data.append('name', $scope.name);
            data.append('state', $scope.state);
            data.append('zip_code', $scope.zip_code);
            data.append('city', $scope.city);
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/ProfileUpdate'; ?>', // point to server-side PHP script
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                beforeSend: function () {
                    swal({
                        text: "Please Wait..",
                        icon: "<?php echo $this->webroot ?>webhtml/images/spinner.gif",
                        buttons: false,
                        closeOnEsc: false,
                        closeOnClickOutside: false,
                    });
                },

                success: function (data) {
                    $rootScope.userinfo = data;
                    window.localStorage.setItem('users', data);
                    console.log(window.localStorage.getItem('users'));
                    swal("information", "Welcome to Car Book", "success");
                    $rootScope.is_active = 1;
                    $location.path("listing");
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }
    });

    app.controller("product_details", function ($scope, $rootScope, $location, $routeParams, timeago) {
        $rootScope.classactive = "listing";
        $rootScope.userinfo = JSON.parse(window.localStorage.getItem('users'));
        if ($routeParams.id == 0) {
            $rootScope.fulldetails = JSON.parse(window.localStorage.getItem('ads'));
            $scope.ad_id = $rootScope.fulldetails.id;
        } else {
            $scope.ad_id = $routeParams.id;
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/get_info_ad'; ?>', // point to server-side PHP script
                data: {ad_id: $scope.ad_id},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $rootScope.fulldetails = data.body;
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }

        $rootScope.is_active = 1;
        $scope.show_profile = function (info) {
            window.localStorage.setItem('friend_info', JSON.stringify(info));
            $location.path("myprofile/1");
        }

        $.ajax({
            type: 'post',
            headers: {
                authorization_key: $rootScope.userinfo.body.authorization_key
            },
            url: '<?php echo $this->webroot . 'apis/Get_comment'; ?>', // point to server-side PHP script
            data: {ad_id: $scope.ad_id},
            beforeSend: function () {
                $(".myloader").show();
            },
            success: function (data) {
                data = JSON.parse(data);
                $rootScope.comments = data.body;
                $scope.$apply();
            }, error: function (data) {
                console.log(data);
                data = JSON.parse(data.responseText);
                swal("Error", data.error_message, "error");
            }
        });

        $scope.docomment = function () {
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/do_comment'; ?>', // point to server-side PHP script
                data: {ad_id: $rootScope.fulldetails.id, comment: $scope.comment},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $scope.comment = '';
                    $rootScope.comments.push(data.body);
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }

        $scope.fav = function (ads) {
            if (ads.is_fav == 1) {
                ads.is_fav = 0;
            } else {
                ads.is_fav = 1;
            }

            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/do_fav'; ?>', // point to server-side PHP script
                data: {ad_id: ads.id},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {

                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }
    });

    app.controller("listing", function ($scope, $rootScope, $location, timeago) {
        $rootScope.classactive = "listing";
        $rootScope.is_active = 1;
        $rootScope.userinfo = JSON.parse(window.localStorage.getItem('users'));
        $rootScope.name = $rootScope.userinfo.body.name;
        $rootScope.is_buyer = $rootScope.userinfo.body.is_buyer;
        if ($rootScope.is_buyer == 1) {
            $location.path("seller_listing");
        }
        $rootScope.page = "All Post";
        $scope.current_page = "Result";
        $rootScope.fulldetails = "";
        var options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        };


        function success(pos) {
            var crd = pos.coords;
            console.log('Your current position is:');
            console.log(`Latitude : ${crd.latitude}`);
            console.log(`Longitude: ${crd.longitude}`);
            console.log(`More or less ${crd.accuracy} meters.`);
        }

        function error(err) {
            console.warn(`ERROR(${err.code}): ${err.message}`);
        }
        $scope.id_address = "<?php echo $_SERVER['REMOTE_ADDR'] ?>";
        $scope.lat = '';
        $scope.long = '';
        if ($rootScope.is_search != 1) {
            $.get("http://freegeoip.net/json/", function (data, status) {
                $scope.lat = data.latitude;
                $scope.long = data.longitude;
                $.ajax({
                    type: 'post',
                    headers: {
                        authorization_key: $rootScope.userinfo.body.authorization_key
                    },
                    url: '<?php echo $this->webroot . 'apis/getAds'; ?>', // point to server-side PHP script
                    data: {latitude: $scope.lat, longitude: $scope.long},
                    beforeSend: function () {
                        $(".myloader").show();
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        console.log(data.body);
                        $rootScope.car_details = data.body;
                        $scope.$apply();
                    }, error: function (data) {
                        console.log(data);
                        data = JSON.parse(data.responseText);
                        swal("Error", data.error_message, "error");
                    }
                });
            });
        }


        navigator.geolocation.getCurrentPosition(success, error, options);


        $scope.details = function (ad) {
            window.localStorage.setItem('ads', JSON.stringify(ad));
            $location.path("details/0");
        }

        $("#exampleFormControlSelect1").on('change', function () {

            $.ajax({
                type: 'get',
                url: '<?php echo $this->webroot . 'apis/get_all_type'; ?>', // point to server-side PHP script
                data: {category_id: $(this).val()},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $rootScope.type = data.body;
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        });

        $.ajax({
            type: 'get',

            url: '<?php echo $this->webroot . 'apis/get_all_category'; ?>', // point to server-side PHP script

            beforeSend: function () {
                $(".myloader").show();
            },
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                $rootScope.category = data.body;
            }, error: function (data) {
                console.log(data);
                data = JSON.parse(data.responseText);
                swal("Error", data.error_message, "error");
            }
        });


        $scope.find = function () {
            
            price = $("#amount").val();
            if (price != '') {
                price = price.split("-");
                $scope.to_price = price[0];
                $scope.from_price = price[1];
            }
            year = $("#amount1").val();
            if (year != '') {
                year = year.split("-");
                $scope.to_year = year[0];
                $scope.from_year = year[1];
            }
            
            data={latitude: $scope.lat, longitude: $scope.long,to_price:$scope.to_price,from_price:$scope.from_price,from_year:$scope.from_year,to_year:$scope.to_year,state:$scope.state,city:$scope.city,type_id:$scope.type_id,category_id:$scope.category_id};
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/getAds'; ?>', // point to server-side PHP script
                data: data,
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    data = JSON.parse(data);
                    console.log(data.body);
                    $rootScope.car_details = data.body;
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });


        }



        $scope.fav = function (ads) {
            if (ads.is_fav == 1) {
                ads.is_fav = 0;
                ads.like_count -= 1;
            } else {
                ads.is_fav = 1;
                ads.like_count = 1 + parseInt(ads.like_count);
            }
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/do_fav'; ?>', // point to server-side PHP script
                data: {ad_id: ads.id},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {

                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }
        $scope.is_active = 1;
        $scope.active = function (active) {
            $scope.is_active = active;
        }

    });



    app.controller("guest", function ($scope, $rootScope, $location, timeago) {
        $rootScope.classactive = "guest";
        $rootScope.is_active = 1;
        $rootScope.page = "All Post";
        $scope.current_page = "Result";
        $rootScope.fulldetails = "";
        $scope.lat = '';
        $scope.long = '';
        if ($rootScope.is_search != 1) {
            $.get("http://freegeoip.net/json/", function (data, status) {
                $scope.lat = data.latitude;
                $scope.long = data.longitude;
                $.ajax({
                    type: 'post',
                    url: '<?php echo $this->webroot . 'apis/guest_ad'; ?>', // point to server-side PHP script
                    data: {latitude: $scope.lat, longitude: $scope.long},
                    beforeSend: function () {
                        $(".myloader").show();
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        console.log(data.body);
                        $rootScope.car_details = data.body;
                        $scope.$apply();
                    }, error: function (data) {
                        console.log(data);
                        data = JSON.parse(data.responseText);
                        swal("Error", data.error_message, "error");
                    }
                });
            });
        }
        
        
        $scope.find = function () {
            
            price = $("#amount").val();
            if (price != '') {
                price = price.split("-");
                $scope.to_price = price[0];
                $scope.from_price = price[1];
            }
            year = $("#amount1").val();
            if (year != '') {
                year = year.split("-");
                $scope.to_year = year[0];
                $scope.from_year = year[1];
            }
            
            data={latitude: $scope.lat, longitude: $scope.long,to_price:$scope.to_price,from_price:$scope.from_price,from_year:$scope.from_year,to_year:$scope.to_year,state:$scope.state,city:$scope.city,type_id:$scope.type_id,category_id:$scope.category_id};
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/getAds'; ?>', // point to server-side PHP script
                data: data,
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    data = JSON.parse(data);
                    console.log(data.body);
                    $rootScope.car_details = data.body;
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });


        }
        

        $scope.details = function (ad) {
            swal("Error", "Please login first for See details ", "error");
        }

        $("#exampleFormControlSelect1").on('change', function () {

            $.ajax({
                type: 'get',
                url: '<?php echo $this->webroot . 'apis/get_all_type'; ?>', // point to server-side PHP script
                data: {category_id: $(this).val()},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $rootScope.type = data.body;
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        });

        $.ajax({
            type: 'get',

            url: '<?php echo $this->webroot . 'apis/get_all_category'; ?>', // point to server-side PHP script

            beforeSend: function () {
                $(".myloader").show();
            },
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                $rootScope.category = data.body;
            }, error: function (data) {
                console.log(data);
                data = JSON.parse(data.responseText);
                swal("Error", data.error_message, "error");
            }
        });


        $scope.fav = function (ads) {
            swal("Error", "Please login first to perform this action", "error");
        }
        $scope.is_active = 1;
        $scope.active = function (active) {
            $scope.is_active = active;
        }

    });


    app.controller("seller_listing", function ($scope, $rootScope, $location, timeago) {
        $rootScope.classactive = "listing";
        $rootScope.is_active = 1;
        $rootScope.userinfo = JSON.parse(window.localStorage.getItem('users'));
        $rootScope.name = $rootScope.userinfo.body.name;
        $rootScope.is_buyer = $rootScope.userinfo.body.is_buyer;

        $scope.current_page = "Result";
        $rootScope.page = "My Listing";
        $scope.leftday = function (time) {
            return timeago.left_days(time);
        }

        $scope.lat = '';
        $scope.long = '';
        if ($rootScope.is_search != 1) {
            $.get("http://freegeoip.net/json/", function (data, status) {
                $scope.lat = data.latitude;
                $scope.long = data.longitude;
                $.ajax({
                    type: 'post',
                    headers: {
                        authorization_key: $rootScope.userinfo.body.authorization_key
                    },
                    url: '<?php echo $this->webroot . 'apis/getAds'; ?>', // point to server-side PHP script
                    data: {latitude: $scope.lat, longitude: $scope.long, is_my: 1},
                    beforeSend: function () {
                        $(".myloader").show();
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        console.log(data.body);
                        $rootScope.car_details = data.body;
                        $scope.$apply();
                    }, error: function (data) {
                        console.log(data);
                        data = JSON.parse(data.responseText);
                        swal("Error", data.error_message, "error");
                    }
                });
            });
        }

        $scope.change = function (is_delete) {
            if (is_delete == '2') {
                $scope.data = {latitude: $scope.lat, longitude: $scope.long, is_my: 1};
            } else {
                $scope.data = {latitude: $scope.lat, longitude: $scope.long, is_my: 1, is_deleted: is_delete};
            }
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/getAds'; ?>', // point to server-side PHP script
                data: $scope.data,
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    data = JSON.parse(data);
                    console.log(data.body);
                    $rootScope.car_details = data.body;
                    $scope.$apply();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });

        }

        $scope.details = function (ad) {
            window.localStorage.setItem('ads', JSON.stringify(ad));
            $location.path("details/0");
        }



        $scope.fav = function (ads) {
            if (ads.is_fav == 1) {
                ads.is_fav = 0;
                ads.like_count -= 1;
            } else {
                ads.is_fav = 1;
                ads.like_count = 1 + parseInt(ads.like_count);
            }
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: $rootScope.userinfo.body.authorization_key
                },
                url: '<?php echo $this->webroot . 'apis/do_fav'; ?>', // point to server-side PHP script
                data: {ad_id: ads.id},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {

                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        }
        $scope.is_active = 1;
        $scope.active = function (active) {
            $scope.is_active = active;
        }

    });

</script>
