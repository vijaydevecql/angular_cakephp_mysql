
<body>

    <div class="form_wraper hiden_text" style="">
        <div class="col-md-6 padding_zero">
            <div id="myCarousel" class="carousel slide" data-ride="carousel" style="background:#4670ee">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="<?php echo $this->webroot ?>/webhtml/images/slide1.png" alt="Los Angeles">
                    </div>

                    <div class="item">
                        <img src="<?php echo $this->webroot ?>/webhtml/images/slide1.png" alt="Chicago">
                    </div>

                    <div class="item">
                        <img src="<?php echo $this->webroot ?>/webhtml/images/slide1.png" alt="New York">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>
        <div class="col-md-6 " style="text-align:center">
            <div class="logo_div">
                <img src="<?php echo $this->webroot ?>/webhtml/images/logo.png">
            </div>

            <div class="how_r register_choice">
              <div class="small_btns start">
                  <h3> My information </h3>
                  <p> Lorem Ipsum is simply dummy text.</p>
                  <div class="small_btns">
                      <a rel="0" class="btn_blue buyer">I AM Buyer</a>
                      <a rel="1" class="btn_gray buyer"> I AM Seller</a>
                  </div>
              </div>
                <div class="small_btns first" style="display:none;">
                    <h3> My information </h3>
                    <p> Lorem Ipsum is simply dummy text.</p>
                    <div class="small_btns">
                        <a rel="0" class="btn_blue enter">I AM INDIVIDUAL</a>
                        <a rel="1" class="btn_gray enter"> I AM CORPORATION</a>
                    </div>
                </div>
                <div class="small_btns second" style="display:none;">
                    <h3> Registration </h3>

                    <div class="form-group form_login">
                        <label class="lbls"> Phone</label>
                        <input class="form-control" id="phone" placeholder="Enter your phone" type="number">

                    </div>
                    <span style="color:red; display:none;" class="error_message">This phone is allready register</span>
                    <div class="form-group">
                        <div class="checkbox">

                        </div>
                        <button type="button" class="btn_blue added"  > Registration</button>

                    </div>

                </div>
                <div class="small_btns third" style="display:none;">
                    <h3> Registration </h3>
                    <form id="complete" method="post" class="form_login">

                        <div class="form-group">
                            <label class="lbls"> E-mail</label>
                            <input class="form-control" name="email" id="email" required placeholder="Enter corp e-mail" type="email">
                        </div>
                        <div class="form-group">
                            <label class="lbls"> EIN number</label>
                            <input class="form-control" name="ein_number" id="ein_number" required  placeholder="Enter corp EIN number" type="text">
                        </div>
                        <div class="form-group">
                            <label class="lbls"> Password</label>
                            <input class="form-control" name="password" id="password" required  placeholder="Password" type="password">
                        </div>
                        <div class="form-group">
                            <label class="lbls"> Confirm Password</label>
                            <input class="form-control" name="cp" required  placeholder="Confirm Password" type="password">
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label><input type="checkbox" required="false" id="is_eighteen" name="is_eighteen" value="1">I'm 18 years old</label>
                            </div>
                            <input type="submit" class="btn_blue" id="submit" Value="Registration" />
                    </form>

                </div>

            </div>


            <div class="already_acnt">
                <p>Allready have an account?</p>
                <a href="<?php echo $this->webroot ?>users/users">LOGIN </a>
            </div>
        </div>
    </div>
</div>

</body>
