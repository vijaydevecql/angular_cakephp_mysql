
<div class="row clearfix">
    <?php //pr($users_listing); ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Users Listing
                </h2>
              
               
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                       <button type="button" class="btn btn-info btn-lg pull-right" data-toggle="modal" data-target="#add_user">Add User</button>
                    </li>
                </ul>
            </div> 
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="dis">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><center>First Name</center></th>
                                <th><center>Last Name</center></th>
                                <th><center>Email</center></th>
                                <th><center>Status</center></th>
                                <th><center>Action</center></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th><center>#</center></th>
                                <th><center>First Name</center></th>
                                <th><center>Last Name</center></th>
                                <th><center>Email</center></th>
                                <th><center>Status</center></th>
                                <th><center>Action</center></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $id=0; foreach ($users_listing as $user) { $id++; ?>
                                <tr id="delete<?php echo $user['User']['id'] ?>">
                                    
                                     <td><center><?php echo $id; ?></td>
                                    <td><center><?php echo ucwords($user['User']['first_name']) ?></center></td>
                                    <td><center><?php echo ucwords($user['User']['last_name'])  ?></center></td>
                                    <td><center><?php echo $user['User']['email'] ?></center></td>
                                  
                                   
                                    <td><center><button class="btn btn-block btn-xs waves-effect g <?php echo ($user['User']['status'] == 1) ? 'bg-green' : 'bg-red'; ?>" model="User" data="<?php echo $user['User']['id'] ?>"><?php echo ($user['User']['status'] == 1) ? 'Active' : 'Deactive'; ?></button></center></td>
                                  
                                    <?php $users_info= $user['User'];
                                        unset($users_info['password']);
                                        unset($users_info['phone']);
                                        unset($users_info['phone_code']);
                                        unset($users_info['city']);
                                        unset($users_info['country']);
                                        unset($users_info['birthday']);
                                        unset($users_info['ip_address']);
                                        unset($users_info['photo']);
                                        unset($users_info['cover_photo']);
                                        unset($users_info['status']);
                                        unset($users_info['email_verified']);
                                        unset($users_info['phone_verified']);
                                        unset($users_info['status_facebook']);
                                        unset($users_info['photo_facebook']);
                                        unset($users_info['id_facebook']);
                                        unset($users_info['id_twitter']);
                                        unset($users_info['authorization_key']);
                                        unset($users_info['status_twitter']);
                                        unset($users_info['photo_twitter']);
                                        unset($users_info['id_google']);
                                        unset($users_info['status_google']);
                                        unset($users_info['photo_google']);
                                        unset($users_info['forgot_password_hash']);
                                        unset($users_info['remember_me_hash']);
                                        unset($users_info['timezone_id']);
                                        unset($users_info['currency_id']);
                                        unset($users_info['language_id']);
                                        unset($users_info['newsletter_subscription']);
                                        unset($users_info['otp']);
                                        unset($users_info['created']);
                                        unset($users_info['lat']);
                                        unset($users_info['long']);
                                        unset($users_info['gender']);
                                        unset($users_info['type']);
                                        unset($users_info['username']);
                                        unset($users_info['modified']);
                                    
                                    
                                    ?>
                                    <td><center><a controller="index" rel='<?php  echo json_encode($users_info); ?>' model="User" href="javascript:void(0);" class="btn bg-light-blue waves-effect edit" >Edit</a> <a rel="<?php echo $user['User']['id'] ?>" model="User" href="javascript:void(0);" alert-type="1" class="btn bg-red delete waves-effect">Delete</a></center></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Edit User</h4>
                        </div>
                        <div class="modal-body" id="models">
                           
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
<div id="add_user" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="reset()" >&times;</button>
       <h4 class="modal-title">Add User</h4>
      </div>
      <div class="modal-body">
      <div id = "msg">
      </div>
      <?php echo $this->Form->create('User', array('novalidate' => true)); ?>
            <div class="form-group">
                <label for="email">First Name:</label>
        <?php
        echo $this->Form->input(
                'first_name', array(
            'label' => false,
            'div' => false,
            'required' => true,
            'class' => 'form-control',
            'placeholder' => 'First Name',
            'type' => 'text',
            'autocomplete' => 'off',
            'value' => '',
            )
        );
        ?> 
            </div><div class="form-group">
                <label for="email">Last Name:</label>
        <?php
        echo $this->Form->input(
                'last_name', array(
            'label' => false,
            'div' => false,
            'required' => true,
            'class' => 'form-control',
            'placeholder' => 'Last Name',
            'type' => 'text',
            'autocomplete' => 'off',
            'value' => '',
           
                )
        );
        ?> 
                </div><div class="form-group">
                    <label for="email">Email:</label>
        <?php
        echo $this->Form->input(
                'email', array(
            'label' => false,
            'div' => false,
            'required' => true,
            'class' => 'form-control',
            'placeholder' => 'Email',
            'type' => 'text',
            'autocomplete' => 'off',
            'value' => '',
           
                )
        );
        ?>
                    </div><div class="form-group">
                        <label for="email">Password:</label>
        <?php
        echo $this->Form->input(
                'password', array(
            'label' => false,
            'div' => false,
            'required' => true,
            'class' => 'form-control',
            'placeholder' => 'Password',
            'type' => 'password',
            'autocomplete' => 'off',
            'value' => '',
           
                )
        );
        ?>

        

    </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-default"> Add </button>
      </div>
        <?php echo $this->Form->end(); ?>
      </div>
    </div>

  </div>
</div>
            <script>
                 function reset(){
                $("#add_user").modal('hide');
                $("#UserAdminIndexForm")[0].reset();
        }
            </script>
