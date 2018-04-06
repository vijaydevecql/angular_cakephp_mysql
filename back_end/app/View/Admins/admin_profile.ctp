<?php $admin=$_admin_data;
//pr($admin);

?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Admin Profile

                </h2>

            </div>     



            <div class="body">
                <form method="post" id="first">
                <div class="demo-masked-input">
                    <div class="row clearfix">
                        <div class="col-md-3">
                            <b>First Name:</b>
                            <div class="input-group">

                                <div class="form-line">
                                    <input type="text" class="form-control" value="<?php echo ucwords($admin['first_name']); ?>" name="first_name" placeholder="Last Name" required="true" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <b>Last Name </b>
                            <div class="input-group">

                                <div class="form-line">
                                    <input type="hidden" value="<?php echo $admin['id']; ?>" name="id"/>
                                    <input type="text" class="form-control time24" value="<?php echo ucwords($admin['last_name']); ?>" name="last_name" placeholder="Last Name" required="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <b>Email</b>
                            <div class="input-group">

                                <div class="form-line">
                                    <input type="email" class="form-control time12" value="<?php echo $admin['email']; ?>" name="email" placeholder="Email" required="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!--<b>Date Time</b>-->
                            <div class="input-group">

                                <div class="form-line">
                                    <button type="submit" class="btn bg-light-blue waves-effect  form-control" > Update Profile </button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Change Password

                </h2>

            </div>     



            <div class="body">
                <form method="post" id="second">
                <div class="demo-masked-input">
                    <div class="row clearfix">
                        <div class="col-md-3">
                            <b>Old Password:</b>
                            <div class="input-group">

                                <div class="form-line">
                                    <input type="hidden" value="<?php echo $admin['id']; ?>" name="id"/>
                                    <input type="password" class="form-control" name="old_password" placeholder="Old Password" required="true" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <b>New Password: </b>
                            <div class="input-group">

                                <div class="form-line">
                                    <input type="password" class="form-control time24" id="pass" name="password" placeholder="New Password" required="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <b>Confirm Password:</b>
                            <div class="input-group">

                                <div class="form-line">
                                    <input type="password" class="form-control time12" name="confirm_password" placeholder="Confirm Password" required="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!--<b>Date Time</b>-->
                            <div class="input-group">

                                <div class="form-line">
                                    <button type="submit" class="btn bg-red waves-effect  form-control" > Change Password </button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Update Profile

                </h2>

            </div>     



            <div class="body">
                    <form method="post" id="third">
                <div class="demo-masked-input">
                    <div class="row clearfix">
                        <div class="col-md-4">
                            <b>Image:</b>
                            <div class="input-group">

                                <div class="form-line">
                                    <input type="file" id="admin_pic" data="_pic" class="form-control " name="first_name" placeholder="Old Password" required="true" >
                                </div>
                            </div>
                        </div>
                         <div class="col-md-4">
                            <b>Preview Image:</b>
                            <div class="input-group">

                               
                                    <img src="" id="prv" alt="no Image" class="_pic" height="100px" />
                               
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!--<b>Date Time</b>-->
                            <div class="input-group">

                                <div class="form-line">
                                    <button type="button" onclick="update_image()" class="btn bg-light-green waves-effect  form-control"> Update Image </button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function update_image() {
        var form = new FormData();
            image=$("#admin_pic")[0].files[0];

            form.append('image',image);
            $.ajax({                                                                         
            method:'post',                                                         
            url: "<?php echo $this->webroot ?>admins/upload_img",
            contentType: false,       // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached


            processData:false,  
            data: form,
            beforeSend: function() {
                swal({
                title: 'Image uploading',
                text: 'Please Wait ...',
                timer: 5000,
                onOpen: function () {
                    swal.showLoading()
                }
                })
           
           },
        success: function (data, status) {
            swal.close();
            var allowDismiss = true;
                        $.notify({
                            message: "Image Updated Successfully "
                        },
                                {
                                    type: 'bg-light-blue',
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
            //$('#uploadFrontImage').attr('src', data.tmp_path);
        },
        error: function (data, status, e) {
            alert(e);
        }
    })
    return false;
}

</script>