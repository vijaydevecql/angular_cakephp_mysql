<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Sign In | Admin |<?php echo "BARS" ?></title>
        <!-- Favicon-->
       <link rel="icon" href="<?php echo $this->webroot.'uploads/admin/admin.png' ?>" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

        <!-- Bootstrap Core Css -->
        <link href="<?php echo $this->webroot ?>bsb/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

        <!-- Waves Effect Css -->
        <link href="<?php echo $this->webroot ?>bsb/plugins/node-waves/waves.css" rel="stylesheet" />

        <!-- Animation Css -->
        <link href="<?php echo $this->webroot ?>bsb/plugins/animate-css/animate.css" rel="stylesheet" />

        <!-- Custom Css -->
        <link href="<?php echo $this->webroot ?>bsb/css/style.css" rel="stylesheet">
    </head>

    <body class="login-page">
        <div class="login-box">
            <div class="logo">
                <a href="javascript:void(0);">Admin</a>
                <small><?php echo "BARS" ?></small>
            </div>
            <div class="card">
                <div class="body">
                    <form id="sign_in" action='<?php echo $this->webroot ?>admin/admins/login' method="POST">
                        <div class="msg">Sign in to start your session</div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">person</i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control" name="data[Admin][email]" value="<?php echo @$_POST['data[Admin][email]'] ?>" placeholder="Email" required autofocus style="padding-left:5px;">
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>
                            <div class="form-line">
                                <input type="password" class="form-control" name="data[Admin][password]" value="<?php echo @$_POST['data[Admin][password]'] ?>" placeholder="Password" required style="padding-left: 5px;">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-xs-4 col-xs-offset-4  text-center">
                            <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                            </div>
                        </div>
                        <div class="row m-t-15 m-b--20">
                            <div class="col-xs-6">
                                <!--<a href="sign-up.html">Register Now!</a>-->
                            </div>
                            <div class="col-xs-6 align-right">
                                <!--<a href="forgot-password.html">Forgot Password?</a>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Jquery Core Js -->
        <script src="<?php echo $this->webroot ?>bsb/plugins/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core Js -->
        <script src="<?php echo $this->webroot ?>bsb/plugins/bootstrap/js/bootstrap.js"></script>

        <!-- Waves Effect Plugin Js -->
        <script src="<?php echo $this->webroot ?>bsb/plugins/node-waves/waves.js"></script>

        <!-- Validation Plugin Js -->
        <script src="<?php echo $this->webroot ?>bsb/plugins/jquery-validation/jquery.validate.js"></script>
        <script src="<?php echo $this->webroot ?>bsb/plugins/bootstrap-notify/bootstrap-notify.js"></script>
        <!-- Custom Js -->
        <script src="<?php echo $this->webroot ?>bsb/js/admin.js"></script>
        <script src="<?php echo $this->webroot ?>bsb/js/pages/examples/sign-in.js"></script>
        <?php if(@$error=='1'){ ?>
        <script>
            errors();
            function errors(){
        var allowDismiss = true;
        $.notify({
            message: "Wrong Email or Password "
        },
                {
                    type: 'bg-red',
                    allow_dismiss: allowDismiss,
                    newest_on_top: true,
                    timer: 1000,
                    placement: {
                        from: 'top',
                        align: 'center'
                    },
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },
                    template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
                            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">x</button>' +
                            '<span data-notify="icon"></span> ' +
                            '<span data-notify="title">{1}</span> ' +
                            '<span data-notify="message">{2}</span>' +
                            '<div class="progress" data-notify="progressbar">' +
                            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                            '</div>' +
                            '<a href="{3}" target="{4}" data-notify="url"></a>' +
                            '</div>'
                });

}
        </script>
        <?php } ?>
    </body>

</html>
