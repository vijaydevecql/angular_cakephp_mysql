<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-route.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-animate.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
<script src="<?php echo $this->webroot ?>webhtml/js/jquery.min.js"></script>
<body ng-app="carbook">
    <div ng-show="is_active == 1" id="header">
        <a href="#"><h1></h1> </a>

    </div>
    <!--close-Header-part-->

    <span ng-show="is_active == 1" class="deshbrd">{{classactive}}</span>
    <!--top-Header-menu-->
    <div ng-show="is_active == 1" id="user-nav" class="">
        <a   class="slr_btn">{{login_name}}</a>


        <ul class="nav" ng-controller="notification" ng-show="is_guest == 0">

            <li  class="dropdown" id="profile-messages2"  >
                <a title=""  data-toggle="dropdown" data-target="#profile-messages2" class="dropdown-toggle ntfctn">
                    <img src="<?php echo $this->webroot ?>webhtml/images/notification.png" > <span class="bell"> {{counts}}</span></a>

                <ul class="dropdown-menu width_bell" >
                    <li ng-click="offno()" ng-show="allnotification.length > 0" ng-repeat="notifi in  allnotification| limitTo:5">
                        <p class="top_ntify"><span class="span_left"> 10:28 AM 14/07/2018</span>  <span class="span_right"><img src="http://202.164.42.226/staging/designers/web-design/carbook/images/msg.png" > <img ng-click="delete_noti(notifi.id, $index)" src="<?php echo $this->webroot ?>webhtml/images/cross.png" ></span></p>
                        <div class="media_full">
                            <div class="media">
                                <div class="media-left media-middle">
                                    <a href="#!/profile/{{notifi.friend_id}}">
                                        <img class="media-object" ng-init="img = (notifi.user_info.photo == '') ? '../webhtml/images/todd.png' : notifi.user_info.photo" src="{{img}}" alt="...">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <a href="#!/details/{{notifi.ad_id}}"
                                       <h4 class="media-heading" ><span ng-bind="notifi.user_info.name"></span></h4>
                                        <p class="media-pera"><span ng-bind="notifi.text"></span></p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li ng-show="allnotification.length == 0">

                        <div class="media_full">
                            <div class="media">
                                <div class="media-left media-middle">
                                    <a >
                                        No Notification
                                    </a>
                                </div>
                                <div class="media-body">

                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>



            <li  class="dropdown" id="profile-messages" ng-init="photo = (image == '') ? '../webhtml/images/todd.png' : image">
                <img class="admin" src="{{photo}}" >
                <a title=""  data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle">
                    <span class="text">Welcome {{name}}
                        <span class="color_green"> {{offer}} offers</span> </span>
                    <b class="caret"></b></a>

                <ul class="dropdown-menu">
                    <li><a href="#!/myprofile/0"><i class="icon-user"></i> My Profile</a></li>
                    <li><a ng-click="logout()"><i class="icon-key"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!--close-top-Header-menu-->
    <!--start-top-serch-->

    <!--close-top-serch-->
    <!--sidebar-menu-->
    <div ng-controller="notification" ng-show=" ng-show="is_active == 1" id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
        <ul>
            <li class="submenu ">
                <div class="form-group srch_btn">
                    <i class="icon icon-search"></i>
                    <input class="form-control" id="email" type="text" placeholder="Search">
                </div>

            </li>

            <li ng-show="is_guest == 1" > <a ng-class="(classactive == 'guest') ? 'submenu active' : ''" href="#!/guest" ><i class="icon icon-signal"></i> <span>Dashboard</span></a> </li>
            <li ng-show="is_guest == 1" > <a  href="<?php echo $this->webroot ?>users/users" ><i class="icon icon-reply"></i> <span>Login</span></a> </li>
            <li ng-show="is_guest == 0" > <a ng-class="(classactive == 'dashboard') ? 'submenu active' : ''" href="#!/dashboard" ><i class="icon icon-signal"></i> <span>Dashboard</span></a> </li>
            <li ng-show="is_guest == 0" > <a ng-class="(classactive == 'chat') ? 'submenu active' : ''" href="#!/chat" ><i class="icon icon-signal"></i> <span>Messages</span></a> </li>

            <li ng-show="is_guest == 0" > <a ><i class="icon icon-gift"></i> <span>WishList</span> </a>

            </li>
            <li ng-show="is_guest == 0"> <a ng-class="(classactive == 'fav') ? 'submenu active' : ''" href="#!/fav"><i class="icon icon-random"></i> <span>Favorites</span> </a>

            </li>

            <li ng-show="is_guest == 0"> <a href="#!/myprofile/0" ng-class="(classactive == 'profile') ? 'submenu active' : ''"><i class="icon icon-file"></i> <span>My Account</span></a> </li>
            <li ng-show="is_guest == 0"><a href="#!/listing" ng-class="(classactive == 'listing') ? 'submenu active' : ''"><i class="icon icon-wrench"></i> <span ng-bind="page"></span></a></li>
            <li ng-show="is_guest == 0"><a href="#!/setting" ng-class="(classactive == 'setting') ? 'submenu active' : ''"><i class="icon icon-book"></i> <span>Setting</span></a></li>
            <li ng-show="is_guest == 0" class="visible-sm"><a href="<?php echo $this->webroot ?>users/logout"><i class="icon icon-book"></i> <span>Contact Us</span></a></li>
            <li ng-show="is_guest == 0" class="visible-sm"><a href="<?php echo $this->webroot ?>users/logout"><i class="icon icon-book"></i> <span>Contact Us</span></a></li>
            <li ng-show="is_guest == 0" ><a ng-click="logout()"><i class="icon icon-book"></i> <span>Logout</span></a></li>
            <li ng-show="is_guest == 0" class="visible-sm"><a href="<?php echo $this->webroot ?>users/logout"><i class="fab fa-google-play"></i> <span>apple</span></a></li>
            <li ng-show="is_guest == 0" class="visible-sm"><a href="<?php echo $this->webroot ?>users/logout"><i class="fab fa-app-store"></i> <span>google</span></a></li>

        </ul>
        <div class="btm_optn visible-lg visible-xs">
            <p> <a href="" > Recommend to friends</a></p>
            <p> <a href="" > Contact Us</a></p>
        </div>
        <div class="btm_imgs visible-lg visible-xs">
            <p> <a href="" ><img src="<?php echo $this->webroot ?>webhtml/images/google.jpg"></a></p>
            <p> <a href="" ><img src="<?php echo $this->webroot ?>webhtml/images/apple.jpg"></a></p>
        </div>
    </div>
    <div class="planet-view slideRight" ng-view></div>
</body>
