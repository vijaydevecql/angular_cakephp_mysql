
<script src="<?php echo $this->webroot ?>webhtml/js/jquery.min.js"></script>
<script src="<?php echo $this->webroot ?>webhtml/js/jquery.ui.custom.js"></script>
<script src="<?php echo $this->webroot ?>webhtml/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.12.0/firebase.js"></script>

<script>

    $(document).ready(function () {
        // fcm code is here 

        var config = {
            apiKey: "BGOduFTSjdRaHS4QAZUxie4zmH2gy7k0W9Hsj8KzT9EKgcISLFt4Lsfj_h_gU8zU5sIsJvgmZ1x_j1eiKfLKrXA",
            authDomain: "car-book-6ebf0.firebaseapp.com",
            authDomain: "car-book-6ebf0.firebaseapp.com",
            databaseURL: "https://car-book-6ebf0.firebaseio.com",
            storageBucket: "car-book-6ebf0.appspot.com",
            messagingSenderId: "138473396578"
        };
        firebase.initializeApp(config);

        var fcm_token='';
      
        jQuery.validator.addMethod("alphanumeric", function (value, element)
        {
            return this.optional(element) || /^[a-zA-Z]+$/.test(value);
        });

        $("#login").validate({
            rules:
                    {
                        'phone': {
                            required: true
                        },
                        'password': {
                            required: true
                        },
                    },
            messages:
                    {
                        'phone': {
                            required: "Please enter your phone.",
                        },
                        'password': {
                            required: "Please enter your password.",
                        },
                    },
            submitHandler: function () {
                phone = $("#phone").val();
                password = $("#password").val();
                $.ajax({
                    type: 'post',
                    url: '<?php echo $this->webroot . 'apis/UserLogin'; ?>', // point to server-side PHP script
                    data: {phone: phone, password: password,device_token:fcm_token},
                    beforeSend: function () {
                        $(".myloader").show();
                    },
                    success: function (data) {
                        window.localStorage.setItem('users', data);
                        document.cookie = "userinfo=" + data;
                        window.location = "<?php echo $this->webroot ?>users/complete";
                    }, error: function (data) {
                        console.log(data);
                        data = JSON.parse(data.responseText);
                        swal("Error", data.error_message, "error");
                        //  alert(data.error_message);
                    }
                });
            }
        });

        $("#update_password").validate({
            rules:
                    {
                        'password': {
                            required: true
                        },
                        'cp': {
                            required: true,
                            equalTo: "#pwd"
                        },
                    },
            messages:
                    {
                        'password': {
                            required: "Please the password"
                        },
                        'cp': {
                            required: "Please enter confirm password.",
                            equalTo: "confirm password dose not match with the password.",
                        },
                    },
            submitHandler: function () {
                password = $("#pwd").val();
                key = window.localStorage.getItem("auth_key");
                $.ajax({
                    type: 'post',
                    headers: {
                        authorization_key: key
                    },
                    url: "<?php echo $this->webroot . 'apis/update_password/'; ?>", // point to server-side PHP script
                    data: "password=" + password,
                    beforeSend: function () {
                        $(".myloader").show();
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        swal("Information", data.message, "success");
                        window.localStorage.setItem("auth_key", '');
                        setTimeout(function () {
                            window.location = "<?php echo $this->webroot ?>users/users/";
                        }, 2000)
                    }, error: function (data) {
                        console.log(data);
                        data = JSON.parse(data.responseText);
                        swal("Error", data.error_message, "error");
                        //  alert(data.error_message);
                    }
                });
            }
        });
        var auth_key = "";
        $(document.body).on('click', '.forgot', function () {
            swal({
                text: 'Please Enter Your Register Mobile Number',
                content: "input",
                button: {
                    text: "Forgot Password!",
                    closeModal: false,
                },
            })
                    .then(name => {
                        if (!name)
                            throw null;
                        $.ajax({
                            type: 'post',
                            url: '<?php echo $this->webroot . 'apis/forgot_password'; ?>', // point to server-side PHP script
                            data: {phone: name},
                            beforeSend: function () {
                                $(".myloader").show();
                            },
                            success: function (data) {
                                data = JSON.parse(data);
                                auth_key = data.body.authorization_key;
                                window.localStorage.setItem("auth_key", data.body.authorization_key);
                                return otp_enter();
                            }
                            , error: function (data) {
                                data = JSON.parse(data.responseText);
                                return swal("Error", data.error_message, "error");
                                //  alert(data.error_message);
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
        });

        function otp_enter() {
            swal({
                text: 'Please Enter Your OTP',
                content: "input",
                button: {
                    text: "Match OTP",
                    closeModal: false,
                },
            }).then(name => {
                if (!name)
                    throw null;
                $.ajax({
                    type: 'post',
                    headers: {
                        authorization_key: auth_key
                    },
                    url: '<?php echo $this->webroot . 'apis/VerifyOtp'; ?>', // point to server-side PHP script
                    data: {otp: name},
                    beforeSend: function () {
                        $(".myloader").show();
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        window.localStorage.setItem("auth_key", data.body.authorization_key);
                        window.location = "<?php echo $this->webroot ?>users/change_password/";
                    }, error: function (data) {
                        console.log(data);
                        data = JSON.parse(data.responseText);
                        alert(data.error_message);
                        swal.stopLoading();
                        return otp_enter();
                        //  alert(data.error_message);
                    }
                });

            }).catch(err => {
                if (err) {
                    swal("Oh noes!", "The AJAX request failed!", "error");
                } else {
                    swal.stopLoading();
                    swal.close();
                }
            });
        }

        var is_buyer = '';
        $(document.body).on('click', '.buyer', function () {
            is_buyer = $(this).attr('rel');
            $(".first").fadeIn('slow');
            $(".start").fadeOut('slow');
            $(".how_r").removeClass('register_choice');
        });

        $(document.body).on('click', '.enter', function () {
            user_type = $(this).attr('rel');
            $(".first").fadeOut('slow');
            $(".second").fadeIn();
            $(".how_r").removeClass('register_choice');
        });

        $("#phone").on('input', function () {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->webroot . 'apis/step_one'; ?>', // point to server-side PHP script
                data: {phone: $(this).val()},
                beforeSend: function () {
                    $(".myloader").show();
                },
                success: function (data) {
                    data = JSON.parse(data);
                    $(".added").addClass('set_two');
                    $(".error_message").hide();
                }, error: function (data) {
                    console.log(data);
                    data = JSON.parse(data.responseText);
                    $(".added").removeClass('set_two');
                    $(".error_message").show();
                    $(".error_message").html(data.error_message);
                }
            });
        });

        $(document.body).on('click', '.set_two', function () {
            $(".second").fadeOut('slow');
            $(".third").fadeIn();
            $(".how_r").removeClass('register_choice');
        });


        var otp = "";
        otp += '<div class="small_btns form_login">';
        otp += '<h3> SMS Verification </h3>';
        otp += '<p>Otp Send your on your Register number. </p>';
        otp += '<div class="form-group">';
        otp += '<label class="lbls"> SMS-code</label>';
        otp += '<img style="display:none;" src="<?php echo $this->webroot ?>webhtml/images/check.png"  class="check">';
        otp += '<input class="form-control" id="otp" placeholder="Enter code from sms" type="number">';
        otp += '</div>';
        otp += ' <span style="color:red; display:none;" class="error_message">This phone is allready register</span>';
        otp += '<p class="for_pas resend_otp">Resend verification code</p>';
        otp += '<a class="btn_blue "> Continue </a>';
        otp += '</div>';


        $("#complete").validate({
            rules:
                    {
                        'email': {
                            required: true,
                            email: true
                        },
                        'password': {
                            required: true
                        },
                        'cp': {
                            required: true,
                            equalTo: "#password"
                        },
                        'is_eighteen': {
                            required: true
                        },
                        'ein_number': {
                            required: true
                        },
                    },
            messages:
                    {
                        'email': {
                            required: "Please enter your phone.",
                            email: "Please Enter the correct email"
                        },
                        'password': {
                            required: "Please enter your password.",
                        },
                        'cp': {
                            required: "Please enter confirm password.",
                            equalTo: "confirm Password dosen't match with your password"
                        },
                        'ein_number': {
                            required: "Please enter the Ein Number."
                        },
                    },
            submitHandler: function () {
                phone = $("#phone").val();
                email = $("#email").val();
                password = $("#password").val();
                phone = $("#phone").val();
                ein_number = $("#ein_number").val();
                is_eighteen = $("#is_eighteen").val();
                $.ajax({
                    type: 'post',
                    url: '<?php echo $this->webroot . 'apis/step_two'; ?>', // point to server-side PHP script
                    data: {phone: phone, email: email, password: password, is_eighteen: is_eighteen, ein_number: ein_number, user_type: user_type, is_buyer: is_buyer},
                    beforeSend: function () {
                        $("#submit").attr('disabled', true);
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        $(".how_r").html(otp);
                        $(".how_r").addClass('register_choice');
                        window.localStorage.setItem("auth_key", data.body.authorization_key);
                        auth_key = data.body.authorization_key;
                    }, error: function (data) {
                        $("#submit").attr('disabled', false);
                        data = JSON.parse(data.responseText);
                        swal("Error", data.error_message, "error");
                        //  alert(data.error_message);
                    }
                });
            }
        });

        $(document.body).on('blur', '#otp', function () {
            $.ajax({
                type: 'post',
                headers: {
                    authorization_key: auth_key
                },
                url: '<?php echo $this->webroot . 'apis/VerifyOtp'; ?>', // point to server-side PHP script
                data: {otp: $(this).val()},
                beforeSend: function () {

                },
                success: function (data) {
                    document.cookie = "userinfo=" + data;
                    window.localStorage.setItem('users', data);
                    data = JSON.parse(data);
                    window.localStorage.setItem('userinfo', data.body);
                    $(".btn_blue").addClass('complete_data');
                    $(".check").show();
                    $(".error_message").hide();
                }, error: function (data) {
                    console.log(data);
                    $(".btn_blue").removeClass('complete_data');
                    data = JSON.parse(data.responseText);
                    $(".added").removeClass('set_two');
                    $(".error_message").show();
                    $(".error_message").html(data.error_message);
                }
            });
        });
        $(document.body).on('click', '.complete_data', function () {
            window.location = "<?php echo $this->webroot ?>users/complete";
        });

        $(document.body).on('click', '.resend_otp', function () {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->webroot . 'apis/resend_otp'; ?>', // point to server-side PHP script
                headers: {
                    authorization_key: auth_key
                },
                beforeSend: function () {

                },
                success: function (data) {
                    data = JSON.parse(data);
                    swal("Information", data.message, "success");
                }, error: function (data) {
                    $("#submit").attr('disabled', false);
                    data = JSON.parse(data.responseText);
                    swal("Error", data.error_message, "error");
                }
            });
        });

    });
</script>
