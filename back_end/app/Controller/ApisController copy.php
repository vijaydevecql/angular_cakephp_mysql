		<?php

		App::uses('AppController', 'Controller');


		class ApisController extends AppController {

					public $components = array('Paginator');

					public $status=array(
						'code'=>SUCCESS_CODE,
						'message'=>'no message'
					);

					public $body=array();
					var $is_admin=false;

					function beforeRender() {
			        parent::beforeRender();
							$this->json($this->status, $this->body);
			    }


			/*
			*admin login api
			*/

			public function AdminLogin(){
				try {
						if (!$this->request->is(array('POST'))) {
								throw new Exception('Only POST supported');
						}
						$required = array(
								'email' => @$this->request->data['email'],
								'password' => @$this->request->data['password'],
								'checking_exits' => 0
						);
						$notrequired = array();
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel('Admin');
						$options = ['conditions' => ['Admin.email' => $requestdata['email'], 'Admin.password' => $requestdata['password']]];
						$admin = $this->Admin->find('first', $options);

						if ($admin) {
								$this->status['message']="login successfully";
								unset($admin['Admin']['password']);
								$this->body = $admin['Admin'];
						}
						else {
								throw new Exception('Wrong Email or password');
						}
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}


			public function dashboard(){
				try {
						if (!$this->request->is(array('POST'))) {
								throw new Exception('Only POST supported');
						}
						$required = array(
								'checking_exits' => 0
						);
						$notrequired = array();
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel('Ad');
						$this->loadModel('User');
						$this->loadModel('Category');
						$this->loadModel('SoldAd');
						$admin=[];
						$admin['ad'] = $this->Ad->find('count');
						$admin['users'] = $this->User->find('count');
						$admin['category'] = $this->Category->find('count');
						$admin['sold'] = $this->SoldAd->find('count');
						$this->status['message']="login successfully";
						$this->body=$admin;

				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}

			public function get_all_category(){
				try {
						if (!$this->request->is(array('get'))) {
								throw new Exception('Only get supported');
						}
						$required = array(
								'checking_exits' => 0
						);
						$notrequired = array();
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel('Category');
						$admin=[];
						$condition[]=[
							'order' => 'Category.id desc'
						];

						$data = $this->Category->find('all',$condition);
						if($data){
								foreach($data as $val){
										$admin[]=$val['Category'];
								}
						}
						$this->status['message']="Listing of Category";
						$this->body=$admin;
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}
			public function get_all_type(){
				try {
						if (!$this->request->is(array('get'))) {
								throw new Exception('Only get supported');
						}
						$required = array(
								'checking_exits' => 1
						);
						$notrequired = array();
						if(!isset($this->request->query['is_admin'])){
							$required['category_id']= @$this->request->query['category_id'];
						}
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel('Type');
						if(isset($requestdata['category_id'])){
							$condition=[
								'conditions' => [
									'Type.category_id' => $requestdata['category_id'],
								]
							];
						}else{
							$condition=[
								'order' => 'Type.id desc'
							];
						}

						$admin=[];
						$data = $this->Type->find('all',$condition);
						if($data){
								foreach($data as $key=>$val){
										$admin[]=$val['Type'];
										$admin[$key]['category_name']=$val['Category']['name'];
								}
						}
						$this->status['message']="Listing of Type";
						$this->body=$admin;
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}
			public function get_all_make(){
				try {
						if (!$this->request->is(array('get'))) {
								throw new Exception('Only get supported');
						}
						$required = array(
								'checking_exits' => 1
						);
						$notrequired = array();
						if(!isset($this->request->query['is_admin'])){
							$required['type_id']= @$this->request->query['type_id'];
						}
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel('Make');
						if(isset($requestdata['type_id'])){
							$condition=[
								'conditions' => [
									'Make.type_id' => $requestdata['type_id'],
								]
							];
						}else{
							$condition=[
								'order' => 'Make.id desc'
							];
						}

						$admin=[];
						$data = $this->Make->find('all',$condition);
						if($data){
								foreach($data as $key=>$val){
										$admin[]=$val['Make'];
										$admin[$key]['Type_name']=$val['Type']['name'];
								}
						}
						$this->loadModel('Model');
						if(isset($requestdata['type_id'])){
							$condition=[
								'conditions' => [
									'Model.type_id' => $requestdata['type_id'],
								]
							];
						}else{
							$condition=[
								'order' => 'Model.id desc'
							];
						}

						$admin1=[];
						$data = $this->Model->find('all',$condition);
						if($data){
								foreach($data as $key=>$val){
										$admin1[]=$val['Model'];
										$admin1[$key]['Type_name']=$val['Type']['name'];
								}
						}


						$this->status['message']="Listing of Make";
						$this->body['make']=$admin;
						$this->body['model']=$admin1;
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}

			public function get_all_model(){
				try {
						if (!$this->request->is(array('get'))) {
								throw new Exception('Only get supported');
						}
						$required = array(
								'checking_exits' => 1
						);
						$notrequired = array();
						if(!isset($this->request->query['is_admin'])){
							$required['type_id']= @$this->request->query['type_id'];
						}
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel('Model');
						if(isset($requestdata['type_id'])){
							$condition=[
								'conditions' => [
									'Model.type_id' => $requestdata['type_id'],
								]
							];
						}else{
							$condition=[
								'order' => 'Model.id desc'
							];
						}

						$admin=[];
						$data = $this->Model->find('all',$condition);
						if($data){
								foreach($data as $key=>$val){
										$admin[]=$val['Model'];
										$admin[$key]['Type_name']=$val['Type']['name'];
								}
						}
						$this->status['message']="Listing of Make";
						$this->body=$admin;
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}
			public function get_all_users(){
				try {
						if (!$this->request->is(array('get'))) {
								throw new Exception('Only get supported');
						}
						$required = array(
								'checking_exits' => 0
						);
						$notrequired = array();
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel('User');
						$admin=[];
						$condition[]=[
							'order' => 'User.id desc'
						];
						$data = $this->User->find('all',$condition);
						if($data){
								foreach($data as $val){
										$admin[]=$val['User'];
								}
						}
						$this->status['message']="User listing Category";
						$this->body=$admin;
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}
			// get plan api.
			public function get_all_plan(){
				try {
						if (!$this->request->is(array('get'))) {
								throw new Exception('Only get supported');
						}
						$required = array(
								'checking_exits' => 0
						);
						$notrequired = array();
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel('Plan');
						$admin=[];
						$data = $this->Plan->find('all');
						if($data){
								foreach($data as $val){
										$admin[]=$val['Plan'];
								}
						}
						$this->status['message']="Plan listing";
						$this->body=$admin;
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}

			// this api update  the all status
			public function update_status(){
				try {
						if (!$this->request->is(array('post'))) {
								throw new Exception('Only post supported');
						}
						$required = array(
								'id' => @$this->request->data['id'],
								'status' => @$this->request->data['status'],
								'model' => @$this->request->data['model'],
								'checking_exits' => 0
						);
						$notrequired = array();
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel($requestdata['model']);
						$this->{$requestdata['model']}->save($requestdata);
						$this->status['message']="status updated";
						$this->body=$admin;
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}
			// this api delete  any data id
			public function delete_data(){
				try {
						if (!$this->request->is(array('post'))) {
								throw new Exception('Only post supported');
						}
						$required = array(
								'id' => @$this->request->data['id'],
								'model' => @$this->request->data['model'],
								'checking_exits' => 0
						);
						$notrequired = array();
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel($requestdata['model']);
						$this->{$requestdata['model']}->id=$requestdata['id'];
						$this->{$requestdata['model']}->delete();
						$this->status['message']="deleted scuessfully";
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}

			// this api add any table data only for admin
			public function add_data(){
				try {
						if (!$this->request->is(array('post'))) {
								throw new Exception('Only post supported');
						}
						$required = array(
								'model' => @$this->request->data['model'],
								'checking_exits' => 0
						);
						$notrequired = array();
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel($requestdata['model']);
						$this->request->data['status']=1;
						$this->{$requestdata['model']}->save($this->request->data);
						$id=$this->{$requestdata['model']}->getLastInsertId();
						$this->body['id']=$id;
						$this->status['message']="Added scuessfully";
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}

			public function user_signup(){
				try {
						if (!$this->request->is(array('post'))) {
								throw new Exception('Only post supported');
						}
						$required = array(
								'name' => @$this->request->data['name'],
								'email' => @$this->request->data['email'],
								'phone' => @$this->request->data['phone'],
								'city' => @$this->request->data['city'],
								'state' => @$this->request->data['state'],
								'zip_code' => @$this->request->data['zip_code'],
								'otp' => round(00000,9999),
								'checking_exits' => 1
						);
						$notrequired = array(
							'device_type' =>  @$this->request->data['device_type'],
							'device_type' =>  $this->send_value(@$this->request->data['device_token'],'0'),
							'authorization_key' => $this->_generate_random_number(),
						);
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel('User');
						if ($this->User->save($requestdata, ['validate' => false])) {
								$user_id = $this->User->getLastInsertId();
								$_user = $this->User->read(null, $user_id);
							if(@$_FILES['image']){
								@$image= $this->_upload_file($_FILES['image'],'','users');
								if(@$image){
									@$_user['User']['photo']=$this->_abs_url('uploads/users/'.$image);
								}

								if ($_user['User']['photo'] && strlen(trim($_user['User']['photo']))) {
									$this->User->save($_user, ['validate' => false]);
								}
							}
								$mail = [];
								$mail['to'] = $requestdata['email'];
								$mail['from'] = 'Admin <admin@apphinge.com>';
								$mail['subject'] = 'Verfication Code | ' . date('M d Y H:i:s');
								$mail['body'] = 'verfication code of USER account is  | ' . @$requestdata['otp'] . ' ' . date('M d Y H:i:s');
								$Email = $this->sendmail($mail);
								$this->status['message']="Signup successfully";
								$this->body['authorization_key']=$requestdata['authorization_key'];
						} else {
								throw new Exception('Error to Signup USER');
						}
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}



			public function ProfileUpdate(){
				try {
						if (!$this->request->is(array('post'))) {
								throw new Exception('Only post supported');
						}
						$required = array(
								'authorization_key' => @$this->request->header('Authorization-key'),

								'checking_exits' => 1
						);
						$data=$this->information($required['authorization_key']);
						$notrequired = array(
							'name' => $this->send_value(@$this->request->data['name'],$data['name']),
							'city' => $this->send_value(@$this->request->data['city'],$data['city']),
							'state' => $this->send_value(@$this->request->data['state'],$data['state']),
							'zip_code' => $this->send_value(@$this->request->data['zip_code'],$data['zip_code']),
						);
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel('User');
						$requestdata['id']=$requestdata['user_id'];
						if ($this->User->save($requestdata, ['validate' => false])) {
								$user_id = $requestdata['user_id'];
								$_user = $this->User->read(null, $user_id);
							if(@$_FILES['image']){
								@$image= $this->_upload_file($_FILES['image'],'','users');
								if(@$image){
									@$_user['User']['photo']=$this->_abs_url('uploads/users/'.$image);
								}

								if ($_user['User']['photo'] && strlen(trim($_user['User']['photo']))) {
									$this->User->save($_user, ['validate' => false]);
								}
							}
								$this->status['message']="Profile updated successfully";
								$this->body=$this->information($requestdata['authorization_key']);
						} else {
								throw new Exception('Error to update profile');
						}
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}

			public function step_one(){
				try {
						if (!$this->request->is(array('post'))) {
								throw new Exception('Only post supported');
						}
						$required = array(
								'phone' => @$this->request->data['phone'],
								'checking_exits' => 1
						);
						$notrequired = array(
						);
						$requestdata = $this->validarray($required, $notrequired);
						$this->status['message']="Number is available";
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}

			public function step_two(){
				try {
						if (!$this->request->is(array('post'))) {
								throw new Exception('Only post supported');
						}
						$required = array(
								'email' => @$this->request->data['email'],
								'phone' => @$this->request->data['phone'],
								'password' => @$this->request->data['password'],
								'is_eighteen' => @$this->request->data['is_eighteen'],
								'is_buyer' => @$this->request->data['is_buyer'],
								'user_type' => @$this->request->data['user_type'],
								'otp' => 11111,//round(00000,9999),
								'checking_exits' => 1
						);
						$notrequired = array(
							'device_type' =>  @$this->request->data['device_type'],
							'device_type' =>  $this->send_value(@$this->request->data['device_token'],'0'),
							'authorization_key' => $this->_generate_random_number(),
						);
						$requestdata = $this->validarray($required, $notrequired);
						$this->loadModel('User');
						if ($this->User->save($requestdata, ['validate' => false])) {
								$user_id = $this->User->getLastInsertId();
								$mail = [];
								$mail['to'] = $requestdata['email'];
								$mail['from'] = 'Admin <admin@apphinge.com>';
								$mail['subject'] = 'Verfication Code | ' . date('M d Y H:i:s');
								$mail['body'] = 'verfication code of USER account is  | ' . @$requestdata['otp'] . ' ' . date('M d Y H:i:s');
								$Email = $this->sendmail($mail);
								$this->status['message']="Signup successfully";
								$this->body['authorization_key']=$requestdata['authorization_key'];
						} else {
								throw new Exception('Error to Signup USER');
						}
				} catch (Exception $ex) {
						$this->status = FAILURE_CODE;
						$this->body = $ex->getMessage();
				}
			}

			private function information($authorization_key) {
		      if (count($authorization_key) == 0) {
		          return false;
		      }
		      $this->loadModel('User');
		      $options = ['conditions' => ['User.authorization_key' => $authorization_key]];
		      $restaurant = $this->User->find('first', $options);
					//prx($restaurant);
		      // $restaurant['User']['image'] = strlen(trim($restaurant['User']['image'])) ? $this->_user_image_path($restaurant['User']['image']) : '';
		      unset($restaurant['User']['password']);
		      unset($restaurant['User']['ip_address']);
		      unset($restaurant['User']['email_verified']);
		      unset($restaurant['User']['phone_verified']);
		      unset($restaurant['User']['status_facebook']);
		      unset($restaurant['User']['status_twitter']);
		      unset($restaurant['User']['forgot_password_hash']);
		      unset($restaurant['User']['remember_me_hash']);
		      unset($restaurant['User']['language_id']);
		      unset($restaurant['User']['newsletter_subscription']);
		     // unset($restaurant['User']['otp']);
		      unset($restaurant['User']['device_type']);
		      unset($restaurant['User']['device_token']);
		      return $restaurant['User'];
		  }

			public function resend_otp() {
		      try {
		          if (!$this->request->is(array('POST'))) {
		              throw new Exception('Only POST  supported');
		          }
		          $required = array(
		              'authorization_key' => @$this->request->header('Authorization-key'),
		              'checking_exits' => 1
		          );
		          $notrequired = array(
		          );
		          $requestdata = $this->validarray($required, $notrequired);
		          $this->loadModel('User');
		          $options = ['conditions' => ['User.authorization_key' => $requestdata['authorization_key']]];
		          $restaurant = $this->User->find('first', $options);
		          $mail = [];
		          $mail['to'] = $restaurant['User']['email'];
		          $mail['from'] = 'Admin <admin@apphinge.com>';
		          $mail['subject'] = 'Verfication Code | ' . date('M d Y H:i:s');
		          $mail['body'] = 'verfication code of User account is  | ' . $restaurant['User']['otp'] . ' ' . date('M d Y H:i:s');
		          $Email = $this->sendmail($mail);
		          $mobile = $this->twilio('+' . $restaurant['User']['phone'], $restaurant['User']['otp']);

		          $this->status['message'] = "OTP send ";

		      } catch (Exception $ex) {
		        $this->status = FAILURE_CODE;
		        $this->body = $ex->getMessage();
		      }
		  }

			public function update_password() {
		      try {
		          if (!$this->request->is(array('POST'))) {
		              throw new Exception('Only POST  supported');
		          }
		          $required = array(
		              'authorization_key' => @$this->request->header('Authorization-key'),
									'password' => @$this->request->data['password'],
		              'checking_exits' => 1
		          );
		          $notrequired = array(
		          );
		          $requestdata = $this->validarray($required, $notrequired);
		          $this->loadModel('User');
		          $options = ['conditions' => ['User.authorization_key' => $requestdata['authorization_key']]];
		          $restaurant = $this->User->find('first', $options);
							$restaurant['User']['password']= $requestdata['password'];
							$this->User->save($restaurant);
		          $this->status['message'] = "password updated ";

		      } catch (Exception $ex) {
		        $this->status = FAILURE_CODE;
		        $this->body = $ex->getMessage();
		      }
		  }

			public function forgot_password() {

		      try {
		          if (!$this->request->is(array('POST'))) {
		              throw new Exception('Only POST  supported');
		          }
		          $required = array(
		              'phone' => @$this->request->data['phone'],
									'otp' => 121212,
		              'checking_exits' => 0
		          );
		          $notrequired = array(
		          );
		          $requestdata = $this->validarray($required, $notrequired);
		          $this->loadModel('User');
		          $options = ['conditions' => ['User.phone' => $requestdata['phone']]];
		          $user = $this->User->find('first', $options);
		          if ($user) {
								$mobile = $this->twilio('+' . $requestdata['phone'], $requestdata['otp']);
								$user['User']['otp']=$requestdata['otp'];
								$this->User->save($user);
		        	}else {
		              throw new Exception("Phone not found");
		          }
		          $this->status['message']="Otp send successfully";
		          $this->body['authorization_key']=$user['User']['authorization_key'];
		      } catch (Exception $ex) {
		          $this->status = FAILURE_CODE;
		          $this->body = $ex->getMessage();
		      }
		  }


			public function VerifyOtp() {
		      try {
		          if (!$this->request->is(array('POST'))) {
		              throw new Exception('Only POST  supported');
		          }
		          $required = array(
		              'authorization_key' => @$this->request->header('Authorization-key'),
									'otp' => @$this->request->data['otp'],
		              'checking_exits' => 0
		          );
		          $notrequired = array(
		              'device_type' => @($this->request->data['device_type'] == '') ? 0 : $this->request->data['device_type'],
		              'device_token' => @($this->request->data['device_token'] == '') ? '' : $this->request->data['device_token'],
									'authorization_key' => $this->_generate_random_number(),
		          );
		          $requestdata = $this->validarray($required, $notrequired);

		          $this->loadModel('User');
							$data=$this->information($required['authorization_key']);
							if($data['otp']==$requestdata['otp']){
			          $requestdata['id']=$requestdata['user_id'];
			          $requestdata['status']=1;
			          unset($requestdata['user_id']);
			          $this->User->save($requestdata, ['validate' => false]);
			          $this->status['message'] = "otp successfully verify ";
			          $this->body = $this->information($requestdata['authorization_key']);
						}else{
							throw new Exception("Wrong otp");
						}
		      } catch (Exception $ex) {
		          $this->status = FAILURE_CODE;
		          $this->body = $ex->getMessage();
		      }
		  }

			public function UserLogin(){
				try {
		        if (!$this->request->is(array('POST'))) {
		            throw new Exception('Only POST supported');
		        }
		        $required = array(
		            'phone' => @$this->request->data['phone'],
		            'password' => @$this->request->data['password'],
		            'checking_exits' => 0
		        );
		        $notrequired = array(
							'device_type' =>  $this->send_value(@$this->request->data['device_type'],'0'),
							'device_token' =>  $this->send_value(@$this->request->data['device_token'],'0'),
							'authorization_key' => $this->_generate_random_number(),
						);
		        $requestdata = $this->validarray($required, $notrequired);
		        $this->loadModel('User');
		        $options = ['conditions' => ['User.phone' => $requestdata['phone'], 'User.password' => $requestdata['password']]];
		        $admin = $this->User->find('first', $options);

		        if ($admin) {
		            $notrequired['id']=$admin['User']['id'];
		            $this->User->save($notrequired);
		            $admin['User']['authorization_key']=$notrequired['authorization_key'];
		            $this->status['message']="login successfully";
		            unset($admin['User']['password']);
		            $this->body = $admin['User'];
		        }
		        else {
		            throw new Exception('Wrong Email or password');
		        }
		    } catch (Exception $ex) {
		        $this->status = FAILURE_CODE;
		        $this->body = $ex->getMessage();
		    }
			}






		}
