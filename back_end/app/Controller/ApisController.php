<?php

App::uses('AppController', 'Controller');

class ApisController extends AppController {

    public $components = array('Paginator');
    public $status = array(
        'code' => SUCCESS_CODE,
        'message' => 'no message'
    );
    public $body = array();
    var $is_admin = false;

    function beforeRender() {
        parent::beforeRender();
        $this->json($this->status, $this->body);
    }

    /*
     * admin login api
     */

    public function AdminLogin() {
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
                $this->status['message'] = "login successfully";
                unset($admin['Admin']['password']);
                $this->body = $admin['Admin'];
            } else {
                throw new Exception('Wrong Email or password');
            }
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function dashboard() {
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
            $admin = [];
            $admin['ad'] = $this->Ad->find('count');
            $admin['users'] = $this->User->find('count');
            $admin['category'] = $this->Category->find('count');
            $admin['sold'] = $this->SoldAd->find('count');
            $this->status['message'] = "login successfully";
            $this->body = $admin;
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function get_all_category() {
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
            $admin = [];
            $condition[] = [
                'order' => 'Category.id desc'
            ];

            $data = $this->Category->find('all', $condition);
            if ($data) {
                foreach ($data as $val) {
                    $admin[] = $val['Category'];
                }
            }
            $this->status['message'] = "Listing of Category";
            $this->body = $admin;
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function get_all_type() {
        try {
            if (!$this->request->is(array('get'))) {
                throw new Exception('Only get supported');
            }
            $required = array(
                'checking_exits' => 1
            );
            $notrequired = array();
            if (!isset($this->request->query['is_admin'])) {
                $required['category_id'] = @$this->request->query['category_id'];
            }
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('Type');
            if (isset($requestdata['category_id'])) {
                $condition = [
                    'conditions' => [
                        'Type.category_id' => $requestdata['category_id'],
                    ]
                ];
            } else {
                $condition = [
                    'order' => 'Type.id desc'
                ];
            }

            $admin = [];
            $data = $this->Type->find('all', $condition);
            if ($data) {
                foreach ($data as $key => $val) {
                    $admin[] = $val['Type'];
                    $admin[$key]['category_name'] = $val['Category']['name'];
                }
            }
            $this->status['message'] = "Listing of Type";
            $this->body = $admin;
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function get_all_make() {
        try {
            if (!$this->request->is(array('get'))) {
                throw new Exception('Only get supported');
            }
            $required = array(
                'checking_exits' => 1
            );
            $notrequired = array();
            if (!isset($this->request->query['is_admin'])) {
                $required['type_id'] = @$this->request->query['type_id'];
            }
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('Make');
            if (isset($requestdata['type_id'])) {
                $condition = [
                    'conditions' => [
                        'Make.type_id' => $requestdata['type_id'],
                    ]
                ];
            } else {
                $condition = [
                    'order' => 'Make.id desc'
                ];
            }

            $admin = [];
            $data = $this->Make->find('all', $condition);
            if ($data) {
                foreach ($data as $key => $val) {
                    $admin[] = $val['Make'];
                    $admin[$key]['Type_name'] = $val['Type']['name'];
                }
            }
            $this->loadModel('Model');
            if (isset($requestdata['type_id'])) {
                $condition = [
                    'conditions' => [
                        'Model.type_id' => $requestdata['type_id'],
                    ]
                ];
            } else {
                $condition = [
                    'order' => 'Model.id desc'
                ];
            }

            $admin1 = [];
            $data = $this->Model->find('all', $condition);
            if ($data) {
                foreach ($data as $key => $val) {
                    $admin1[] = $val['Model'];
                    $admin1[$key]['Type_name'] = $val['Type']['name'];
                }
            }


            $this->status['message'] = "Listing of Make";
            $this->body['make'] = $admin;
            $this->body['model'] = $admin1;
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function get_all_model() {
        try {
            if (!$this->request->is(array('get'))) {
                throw new Exception('Only get supported');
            }
            $required = array(
                'checking_exits' => 1
            );
            $notrequired = array();
            if (!isset($this->request->query['is_admin'])) {
                $required['type_id'] = @$this->request->query['type_id'];
            }
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('Model');
            if (isset($requestdata['type_id'])) {
                $condition = [
                    'conditions' => [
                        'Model.type_id' => $requestdata['type_id'],
                    ]
                ];
            } else {
                $condition = [
                    'order' => 'Model.id desc'
                ];
            }

            $admin = [];
            $data = $this->Model->find('all', $condition);
            if ($data) {
                foreach ($data as $key => $val) {
                    $admin[] = $val['Model'];
                    $admin[$key]['Type_name'] = $val['Type']['name'];
                }
            }
            $this->status['message'] = "Listing of Make";
            $this->body = $admin;
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function get_all_users() {
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
            $admin = [];
            $condition[] = [
                'order' => 'User.id desc'
            ];
            $data = $this->User->find('all', $condition);
            if ($data) {
                foreach ($data as $val) {
                    $admin[] = $val['User'];
                }
            }
            $this->status['message'] = "User listing Category";
            $this->body = $admin;
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    // get plan api.
    public function get_all_plan() {
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
            $admin = [];
            $data = $this->Plan->find('all');
            if ($data) {
                foreach ($data as $val) {
                    $admin[] = $val['Plan'];
                }
            }
            $this->status['message'] = "Plan listing";
            $this->body = $admin;
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    // this api update  the all status
    public function update_status() {
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
            $this->status['message'] = "status updated";
            $this->body = $admin;
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    // this api delete  any data id
    public function delete_data() {
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
            $this->{$requestdata['model']}->id = $requestdata['id'];
            $this->{$requestdata['model']}->delete();
            $this->status['message'] = "deleted scuessfully";
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    // this api add any table data only for admin
    public function add_data() {
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
            $this->request->data['status'] = 1;
            $this->{$requestdata['model']}->save($this->request->data);
            $id = $this->{$requestdata['model']}->getLastInsertId();
            $this->body['id'] = $id;
            $this->status['message'] = "Added scuessfully";
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function user_signup() {
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
                'otp' => round(00000, 9999),
                'checking_exits' => 1
            );
            $notrequired = array(
                'device_type' => @$this->request->data['device_type'],
                'device_type' => $this->send_value(@$this->request->data['device_token'], '0'),
                'authorization_key' => $this->_generate_random_number(),
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('User');
            if ($this->User->save($requestdata, ['validate' => false])) {
                $user_id = $this->User->getLastInsertId();
                $_user = $this->User->read(null, $user_id);
                if (@$_FILES['image']) {
                    @$image = $this->_upload_file($_FILES['image'], '', 'users');
                    if (@$image) {
                        @$_user['User']['photo'] = $this->_abs_url('uploads/users/' . $image);
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
                $this->status['message'] = "Signup successfully";
                $this->body['authorization_key'] = $requestdata['authorization_key'];
            } else {
                throw new Exception('Error to Signup USER');
            }
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function ProfileUpdate() {
        try {
            if (!$this->request->is(array('post'))) {
                throw new Exception('Only post supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'checking_exits' => 1
            );
            $data = $this->information($required['authorization_key']);
            $notrequired = array(
                'name' => $this->send_value(@$this->request->data['name'], $data['name']),
                'city' => $this->send_value(@$this->request->data['city'], $data['city']),
                'state' => $this->send_value(@$this->request->data['state'], $data['state']),
                'zip_code' => $this->send_value(@$this->request->data['zip_code'], $data['zip_code']),
                'address_two' => $this->send_value(@$this->request->data['address_two'], $data['address_two']),
                'address_one' => $this->send_value(@$this->request->data['address_one'], $data['address_one']),
                'is_notification_on' => $this->send_value(@$this->request->data['is_notification_on'], $data['is_notification_on']),
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('User');
            $requestdata['id'] = $requestdata['user_id'];
            if ($this->User->save($requestdata, ['validate' => false])) {
                $user_id = $requestdata['user_id'];
                $_user = $this->User->read(null, $user_id);
                if (@$_FILES['image']) {
                    @$image = $this->_upload_file($_FILES['image'], '', 'image');
                    if (@$image) {
                        @$_user['User']['photo'] = $this->_abs_url('uploads/image/' . $image);
                    }

                    if ($_user['User']['photo'] && strlen(trim($_user['User']['photo']))) {
                        $this->User->save($_user, ['validate' => false]);
                    }
                }
                $this->status['message'] = "Profile updated successfully";
                $this->body = $this->information($requestdata['authorization_key']);
            } else {
                throw new Exception('Error to update profile');
            }
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function buyPlan() {

        try {
            if (!$this->request->is(array('post'))) {
                throw new Exception('Only post supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'plan_id' => @$this->request->data['plan_id'],
                'transaction_no' => @$this->request->data['transaction_no'],
                'total_count' => 30,
                'checking_exits' => 1
            );
            $notrequired = array(
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('ParchasPlan');
            $this->loadModel('PlanTransaction');
            $this->loadModel('Plan');
            $condition = [
                'conditions' => [
                    'Plan.id' => $requestdata['plan_id']
                ]
            ];
            $data = $this->Plan->find('first', $condition);
            $requestdata['amount'] = $data['Plan']['price'];
            $requestdata['expire_time'] = strtotime("+" . $data['Plan']['time'] . " days", time());
            if ($this->PlanTransaction->save($requestdata)) {
                $this->ParchasPlan->save($requestdata);
                $this->status['message'] = "Plan buy successfully";
                $this->body = $this->information($requestdata['authorization_key']);
            } else {
                throw new Expectation("Error to buy a plan");
            }
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function do_comment() {

        try {
            if (!$this->request->is(array('post'))) {
                throw new Exception('Only post supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'ad_id' => @$this->request->data['ad_id'],
                'comment' => @$this->request->data['comment'],
                'checking_exits' => 1
            );
            $notrequired = array(
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('Comment');
            $this->loadModel('Ad');
            $this->loadModel('Notification');
            $this->Comment->save($requestdata);
            $ad = $this->Ad->find('first', [
                'conditions' => [
                    'Ad.id' => $requestdata['ad_id']
                ]
            ]);
            $ad['Ad']['comment_count'] = $ad['Ad']['comment_count'] + 1;
            $this->Ad->save($ad);
            $notification_data=[];
            $notification_data1=$this->get_singal_comment($this->Comment->getLastInsertId());
            $notification_data=$notification_data1['Comment'];
            $notification_data['user_info']=$notification_data1['User'];
            if($ad['Ad']['user_id']!=$requestdata['user_id']){
              $requestdata['friend_id']=$requestdata['user_id'];
              $requestdata['user_id']=$ad['Ad']['user_id'];
              $requestdata['text']="comment on your ad";
              $this->Notification->save($requestdata);
              //prx(  $notification_data1);
              $push = [];
              $push['user_id'] = $ad['Ad']['user_id'];
              $push['message'] = "comment on your ad";
              $push['body'] = $notification_data;
              $push['notification_code'] = 2;
              $this->_send_push($push);

            }
            $requestdata['id'] = $this->Comment->getLastInsertId();
            $this->status['message'] = "Comment add successfully";
            $requestdata['created'] = (string) time();
            $this->body = $notification_data;
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    private function get_singal_comment($id){
        $this->loadModel('Comment');
        return $this->Comment->find('first',[
            'conditions' => [
                 'Comment.id' => $id
            ]
        ]);
    }

    public function Get_comment() {
        try {
            if (!$this->request->is(array('post'))) {
                throw new Exception('Only post supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'ad_id' => @$this->request->data['ad_id'],
                'checking_exits' => 1
            );
            $notrequired = array(
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('Comment');
            $ad = $this->Comment->find('all', [
                'conditions' => [
                    'Comment.ad_id' => $requestdata['ad_id']
                ]
            ]);
            $final = [];
            foreach ($ad as $k => $val) {
                $final[] = $val['Comment'];
                $final[$k]['user_info'] = $val['User'];
            }
            $this->status['message'] = "Comment fetch successfully";
            $this->body = $final;
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

      public function Get_notification() {
        try {
            if (!$this->request->is(array('get'))) {
                throw new Exception('Only get supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'checking_exits' => 1
            );
            $notrequired = array(
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('Notification');
            $ad = $this->Notification->find('all', [
                'conditions' => [
                    'Notification.user_id' => $requestdata['user_id']
                ]
            ]);
            $final = [];
            foreach ($ad as $k => $val) {
                $final[] = $val['Notification'];
                $final[$k]['user_info'] = $val['User'];
            }
            $this->status['message'] = "Notification fetch successfully";
            $this->body = $final;
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }


    public function delete_notification() {
        try {
            if (!$this->request->is(array('get'))) {
                throw new Exception('Only get supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'notification_id' => @$this->request->query('notification_id'),
                'checking_exits' => 1
            );
            $notrequired = array(
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('Notification');
            $this->Notification->id=$requestdata['notification_id'];
            $this->Notification->delete();
            $this->status['message'] = "Notification delete successfully";
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }


    public function do_fav() {

        try {
            if (!$this->request->is(array('post'))) {
                throw new Exception('Only post supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'ad_id' => @$this->request->data['ad_id'],
                'checking_exits' => 1
            );
            $notrequired = array();
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('FavouriteAd');
            $this->loadModel('Ad');
            $condition = [
                'conditions' => [
                    'FavouriteAd.user_id' => $requestdata['user_id'],
                    'FavouriteAd.ad_id' => $requestdata['ad_id'],
                ]
            ];
            $ad = $this->Ad->find('first', [
                'conditions' => [
                    'Ad.id' => $requestdata['ad_id']
                ]
            ]);
            $data = $this->FavouriteAd->find('first', $condition);
            if ($data) {
                $ad['Ad']['like_count'] = $ad['Ad']['like_count'] - 1;
                $this->FavouriteAd->id = $data['FavouriteAd']['id'];
                $this->FavouriteAd->delete();
                $this->status['message'] = "ad Unfavourite successfully";
            } else {
                $ad['Ad']['like_count'] = $ad['Ad']['like_count'] + 1;
                $this->FavouriteAd->save($requestdata);
                $this->status['message'] = "ad favourite successfully";
            }
            $this->Ad->save($ad);
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function get_transaction() {

        try {
            if (!$this->request->is(array('get'))) {
                throw new Exception('Only GET supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'checking_exits' => 1
            );
            $notrequired = array();
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('PlanTransaction');
            $condition = [
                'conditions' => [
                    'PlanTransaction.user_id' => $requestdata['user_id']
                ]
            ];
            $plan = $this->PlanTransaction->find('all', $condition);
            $final = [];
            foreach ($plan as $k => $value) {
                $final[] = $value['PlanTransaction'];
                $final[$k]['plan_info'] = $value['Plan'];
            }
            $this->body = $final;
            $this->status['message'] = "Transaction fetch successfully";
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function do_whishlist() {

        try {
            if (!$this->request->is(array('post'))) {
                throw new Exception('Only post supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'ad_id' => @$this->request->data['ad_id'],
                'checking_exits' => 1
            );
            $notrequired = array();
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('WishList');
            $condition = [
                'conditions' => [
                    'WishList.user_id' => $requestdata['user_id'],
                    'WishList.ad_id' => $requestdata['ad_id'],
                ]
            ];
            $data = $this->WishList->find('first', $condition);
            if ($data) {
                $this->WishList->id = $data['WishList']['id'];
                $this->WishList->delete();
                $this->status['message'] = "ad remove from WishList successfully";
            } else {
                $this->WishList->save($requestdata);
                $this->status['message'] = "ad add to WishList successfully";
            }
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function delete_ad() {

        try {
            if (!$this->request->is(array('post'))) {
                throw new Exception('Only post supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'ad_id' => @$this->request->data['ad_id'],
                'is_deleted' => 1,
                'checking_exits' => 1
            );
            $notrequired = array();
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('Ad');
            $requestdata['id'] = $requestdata['ad_id'];
            $this->Ad->save($requestdata);
            $this->status['message'] = "Ad deleted successfully";
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function getAds() {

        try {
            if (!$this->request->is(array('post'))) {
                throw new Exception('Only post supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'latitude' => @$this->request->data['latitude'],
                'longitude' => @$this->request->data['longitude'],
                'checking_exits' => 1
            );

            $notrequired = array(
                'is_my' => @$this->request->data['is_my'],
                'is_deleted' => @$this->request->data['is_deleted'],
                'make' => @$this->request->data['make'],
                'modal' => @$this->request->data['modal'],
                'from_price' => @$this->request->data['from_price'],
                'to_price' => @$this->request->data['to_price'],
                'from_price' => @$this->request->data['from_price'],
                'from_year' => @$this->request->data['from_year'],
                'to_year' => @$this->request->data['to_year'],
                'categoryid' => @$this->request->data['category_id'],
                'to_mileage' => @$this->request->data['to_mileage'],
                'from_mileage' => @$this->request->data['from_mileage'],
                'typeid' => @$this->request->data['type_id'],
                'is_new' => @$this->request->data['is_new'],
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('Ad');
            $condition = [
                'conditions' => [
                    "( 6371 * acos( cos( radians(" . @$requestdata['latitude'] . ") ) * cos( radians( `Ad`.`latitude`) ) * cos( radians( `Ad`.`longitude` ) - radians(" . @$requestdata['longitude'] . ") ) + sin( radians(" . @$requestdata['latitude'] . ") ) * sin(radians(`Ad`.`latitude`)) ) )<=10000"
                ],
                'fields' => [
                    'Category.*',
                    'Ad.*',
                    'Type.*',
                    'User.*',
                ],
                'order' => 'Ad.id desc'
            ];

            if (isset($requestdata['categoryid'])) {
                $condition['conditions'][0] = [
                    'Ad.category_id' => $requestdata['categoryid']
                ];
            }
            if (isset($requestdata['make'])) {
                $condition['conditions'][0] = [
                    'Ad.make' => $requestdata['make']
                ];
            }
            if (isset($requestdata['modal'])) {
                $condition['conditions'][0] = [
                    'Ad.modal' => $requestdata['modal']
                ];
            }
            if (isset($requestdata['make'])) {
                $condition['conditions'][0] = [
                    'Ad.make' => $requestdata['make']
                ];
            }
            if (isset($requestdata['is_new'])) {
                $condition['conditions'][0] = [
                    'Ad.is_new' => $requestdata['is_new']
                ];
            }
            if (isset($requestdata['to_year'])) {
                $condition['conditions']['and'][0] = [
                    'Ad.year < ' => $requestdata['from_year'],
                    'Ad.year > ' => $requestdata['to_year'],
                ];
            }
            if (isset($requestdata['to_price'])) {
                $condition['conditions']['and'][0] = [
                    'Ad.price <' => $requestdata['from_price'],
                    'Ad.price > ' => $requestdata['to_price'],
                ];
            }
            if (isset($requestdata['to_mileage'])) {
                $condition['conditions']['and'][0] = [
                    'Ad.mileage > ' => $requestdata['from_mileage'],
                    'Ad.mileage < ' => $requestdata['to_mileage'],
                ];
            }
            if (isset($requestdata['typeid'])) {
                $condition['conditions']['and'][0] = [
                    'Ad.type_id  ' => $requestdata['typeid'],
                ];
            }

            if (isset($requestdata['is_my']) && strlen($requestdata['is_my']) > 0) {
                unset($condition['conditions']);
                $condition['conditions'] = [
                    'Ad.user_id' => $requestdata['user_id'],
                ];
                if (isset($requestdata['is_deleted'])) {
                    $condition['conditions'][0] = [
                        'Ad.is_deleted' => $requestdata['is_deleted']
                    ];
                }
            }
            $condition['fields'][] = "(select count(id) as total from favourite_ads where favourite_ads.ad_id=Ad.id and user_id=" . $requestdata['user_id'] . " ) as is_fav ";
            $data = $this->Ad->find('all', $condition);
            $final = [];
            foreach ($data as $k => $v) {
                $final[] = $v['Ad'];
                $final[$k]['category_name'] = $v['Category']['name'];
                $final[$k]['type_name'] = $v['Type']['name'];
                $final[$k]['Specification'] = $v['Specification'];
                $final[$k]['images'] = $v['AdImage'];
                $final[$k]['userinfo'] = $v['User'];
                $final[$k]['is_fav'] = $v[0]['is_fav'];
            }
            $this->body = $final;
            $this->status['message'] = "Ad fetch scuessfully";
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }


    public function guest_ad() {

        try {
            if (!$this->request->is(array('post'))) {
                throw new Exception('Only post supported');
            }
            $required = array(
                //'authorization_key' => @$this->request->header('Authorization-key'),
                'latitude' => @$this->request->data['latitude'],
                'longitude' => @$this->request->data['longitude'],
                'checking_exits' => 1
            );

            $notrequired = array(
                'is_my' => @$this->request->data['is_my'],
                'is_deleted' => @$this->request->data['is_deleted'],
                'make' => @$this->request->data['make'],
                'modal' => @$this->request->data['modal'],
                'from_price' => @$this->request->data['from_price'],
                'to_price' => @$this->request->data['to_price'],
                'from_price' => @$this->request->data['from_price'],
                'from_year' => @$this->request->data['from_year'],
                'to_year' => @$this->request->data['to_year'],
                'categoryid' => @$this->request->data['category_id'],
                'to_mileage' => @$this->request->data['to_mileage'],
                'from_mileage' => @$this->request->data['from_mileage'],
                'is_new' => @$this->request->data['is_new'],
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('Ad');
            $condition = [
                'conditions' => [
                    "( 6371 * acos( cos( radians(" . @$requestdata['latitude'] . ") ) * cos( radians( `Ad`.`latitude`) ) * cos( radians( `Ad`.`longitude` ) - radians(" . @$requestdata['longitude'] . ") ) + sin( radians(" . @$requestdata['latitude'] . ") ) * sin(radians(`Ad`.`latitude`)) ) )<=10000"
                ],
                'fields' => [
                    'Category.*',
                    'Ad.*',
                    'Type.*',
                    'User.*',
                ],
                'order' => 'Ad.id desc'
            ];

            if (isset($requestdata['categoryid'])) {
                $condition['conditions'][0] = [
                    'Ad.category_id' => $requestdata['categoryid']
                ];
            }
            if (isset($requestdata['make'])) {
                $condition['conditions'][0] = [
                    'Ad.make' => $requestdata['make']
                ];
            }
            if (isset($requestdata['modal'])) {
                $condition['conditions'][0] = [
                    'Ad.modal' => $requestdata['modal']
                ];
            }
            if (isset($requestdata['make'])) {
                $condition['conditions'][0] = [
                    'Ad.make' => $requestdata['make']
                ];
            }
            if (isset($requestdata['is_new'])) {
                $condition['conditions'][0] = [
                    'Ad.is_new' => $requestdata['is_new']
                ];
            }
            if (isset($requestdata['to_year'])) {
                $condition['conditions']['and'][0] = [
                    'Ad.year > ' => $requestdata['from_year'],
                    'Ad.year < ' => $requestdata['to_year'],
                ];
            }
            if (isset($requestdata['to_price'])) {
                $condition['conditions']['and'][0] = [
                    'Ad.price > ' => $requestdata['from_price'],
                    'Ad.price < ' => $requestdata['to_price'],
                ];
            }
            if (isset($requestdata['to_mileage'])) {
                $condition['conditions']['and'][0] = [
                    'Ad.mileage > ' => $requestdata['from_mileage'],
                    'Ad.mileage < ' => $requestdata['to_mileage'],
                ];
            }

            if (isset($requestdata['is_my']) && strlen($requestdata['is_my']) > 0) {
                unset($condition['conditions']);
                $condition['conditions'] = [
                    'Ad.user_id' => $requestdata['user_id'],
                ];
                if (isset($requestdata['is_deleted'])) {
                    $condition['conditions'][0] = [
                        'Ad.is_deleted' => $requestdata['is_deleted']
                    ];
                }
            }
          //  $condition['fields'][] = "(select count(id) as total from favourite_ads where favourite_ads.ad_id=Ad.id and user_id=" . $requestdata['user_id'] . " ) as is_fav ";
            $data = $this->Ad->find('all', $condition);
            $final = [];
            foreach ($data as $k => $v) {
                $final[] = $v['Ad'];
                $final[$k]['category_name'] = $v['Category']['name'];
                $final[$k]['type_name'] = $v['Type']['name'];
                $final[$k]['Specification'] = $v['Specification'];
                $final[$k]['images'] = $v['AdImage'];
                $final[$k]['userinfo'] = $v['User'];
                $final[$k]['is_fav'] = 0;
            }
            $this->body = $final;
            $this->status['message'] = "Ad fetch scuessfully";
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }




    public function getFav() {

        try {
            if (!$this->request->is(array('get'))) {
                throw new Exception('Only GET supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'checking_exits' => 1
            );

            $notrequired = array(
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('FavouriteAd');
            $condition = [
                'joins' => [
                    [
                        'table' => 'ads',
                        'alias' => 'Ad',
                        'type' => 'INNER',
                        'conditions' => [
                            'Ad.id = FavouriteAd.ad_id'
                        ]
                    ],
                    [
                        'table' => 'specifications',
                        'alias' => 'Specification',
                        'type' => 'INNER',
                        'conditions' => [
                            'Ad.id = Specification.ad_id'
                        ]
                    ],
                ],
                'conditions' => [
                    'FavouriteAd.user_id' => $requestdata['user_id']
                ],
                'fields' => [
                    'Ad.*',
                    'User.*',
                    'Specification.*',
                ],
            ];

            $condition['fields'][] = "(select count(id) as total from favourite_ads where favourite_ads.ad_id=Ad.id and user_id=" . $requestdata['user_id'] . " ) as is_fav ";
            $condition['fields'][] = "(select name  from types where types.id=Ad.type_id) as type_name ";
            $condition['fields'][] = "(select name  from categories where categories.id=Ad.category_id) as category_name ";
            $data = $this->FavouriteAd->find('all', $condition);
            // prx($data);
            $final = [];
            foreach ($data as $k => $v) {
                $final[] = $v['Ad'];
                $final[$k]['category_name'] = $v[0]['category_name'];
                $final[$k]['type_name'] = $v[0]['type_name'];
                $final[$k]['Specification'][] = $v['Specification'];
                $final[$k]['images'] = $this->getimages($v['Ad']['id']);
                $final[$k]['userinfo'] = $v['User'];
                $final[$k]['is_fav'] = $v[0]['is_fav'];
            }
            $this->body = $final;
            $this->status['message'] = "favad fetch scuessfully";
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function getimages($ad_id) {
        $this->loadModel('AdImage');
        $image = $this->AdImage->find('all', [
            'conditions' => [
                'AdImage.ad_id' => $ad_id
            ]
        ]);
        $final = [];
        foreach ($image as $value) {
            $final[] = $value['AdImage'];
        }
        return $final;
    }

    public function addAd() {
        try {
            if (!$this->request->is(array('post'))) {
                throw new Exception('Only post supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'category_id' => @$this->request->data['category_id'],
                'type_id' => @$this->request->data['type_id'],
                'make' => @$this->request->data['make'],
                'modal' => @$this->request->data['modal'],
                'price' => @$this->request->data['price'],
                'mileage' => @$this->request->data['mileage'],
                'is_new' => @$this->request->data['is_new'],
                'year' => @$this->request->data['year'],
                'modified_date' => @$this->request->data['modified_date'],
                'state' => @$this->request->data['state'],
                'zip_code' => @$this->request->data['zip_code'],
                'location' => @$this->request->data['location'],
                'latitude' => @$this->request->data['latitude'],
                'longitude' => @$this->request->data['longitude'],
                'mileage' => @$this->request->data['mileage'],
                'checking_exits' => 1
            );

            $notrequired = array(
                'fuel_type' => @$this->request->data['fuel_type'],
                'transmission' => @$this->request->data['transmission'],
                'condition' => @$this->request->data['condition'],
                'manual' => @$this->request->data['manual'],
                'vin_no' => @$this->request->data['vin_no'],
                'doors' => @$this->request->data['doors'],
                'miles' => @$this->request->data['miles'],
                'drive_unit' => @$this->request->data['drive_unit'],
                'drive_type' => @$this->request->data['drive_type'],
                'wheel' => @$this->request->data['wheel'],
                'tire' => @$this->request->data['tire'],
                'exterior_color' => @$this->request->data['exterior_color'],
                'interior_color' => @$this->request->data['interior_color'],
                'passenger_capacity' => @$this->request->data['passenger_capacity'],
                'engine' => @$this->request->data['engine'],
                'horse_power' => @$this->request->data['horse_power'],
                'basic_warranty' => @$this->request->data['basic_warranty'],
                'powertrain_warranty' => @$this->request->data['powertrain_warranty'],
                'stock_number' => @$this->request->data['stock_number'],
                'braking_traction' => @$this->request->data['braking_traction'],
                'comfort_convenience' => @$this->request->data['comfort_convenience'],
                'entertainment_instrumentation' => @$this->request->data['entertainment_instrumentation'],
                'lighting' => @$this->request->data['lighting'],
                'roofs_glass' => @$this->request->data['roofs_glass'],
                'safety_security' => @$this->request->data['safety_security'],
                'seats' => @$this->request->data['seats'],
                'steering' => @$this->request->data['steering'],
                'wheels_tires' => @$this->request->data['wheels_tires'],
                'additional_information' => @$this->request->data['additional_information'],
            );
            $requestdata = $this->validarray($required, $notrequired);

            $this->loadModel('Ad');
            $this->loadModel('Specification');
            $this->loadModel('AdImage');
            $this->loadModel('ParchasPlan');
            $condition = [
                'conditions' => [
                    'ParchasPlan.user_id' => $requestdata['user_id'],
                    'ParchasPlan.expire_time > ' => time()
                ]
            ];
            $data = $this->ParchasPlan->find('first', $condition);
            if (!$data) {
                throw new Exception(" Your Plan is expire Please renew your Plan");
            } else {
                $requestdata['plan_id'] = $data['ParchasPlan']['id'];
                $requestdata['plan_expiredate'] = $data['ParchasPlan']['expire_time'];
            }
            if ($this->Ad->save($requestdata)) {
                $ad_id = $this->Ad->getLastInsertId();
                $notrequired['ad_id'] = $ad_id;
                $this->Specification->save($notrequired);
                //pr($_FILES['image']);
                if (count($_FILES['image']) > 0) {
                    $final = [];
                    if (is_array($_FILES['image'])) {
                        $image = [];
                        $i = 0;
                        foreach ($_FILES['image']['name'] as $k => $val) {
                            $image = [
                                'name' => $_FILES['image']['name'][$i],
                                'type' => $_FILES['image']['type'][$i],
                                'error' => $_FILES['image']['error'][$i],
                                'tmp_name' => $_FILES['image']['tmp_name'][$i],
                                'size' => $_FILES['image']['size'][$i],
                            ];
                            $i++;
                            $images = $this->_upload_file($image, '', 'image');
                            if (strlen($images) > 0) {
                                $images = $this->_abs_url1('/uploads/image/' . $images);
                            } else {
                                $images = "";
                            }
                            $final[] = [
                                'ad_id' => $ad_id,
                                'images' => $images,
                            ];
                        }
                        $this->AdImage->create();
                        $this->AdImage->saveall($final);
                    }
                }
                $requestdata['id'] = $ad_id;
                $requestdata['image'] = $final;
                $this->body = $requestdata;
                $this->status['message'] = "Ad add successfully";
            } else {
                throw new Exception("Eroor to add the ad");
            }
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function Edit_Ad() {
        try {
            if (!$this->request->is(array('post'))) {
                throw new Exception('Only post supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'ad_id' => @$this->request->data['ad_id'],
                'checking_exits' => 1
            );
            @$data = $this->getsingalad($required['ad_id']);
            $notrequired = array(
                'fuel_type' => $this->send_value(@$this->request->data['fuel_type'], $data['Specification'][0]['fuel_type']),
                'transmission' => $this->send_value(@$this->request->data['transmission'], $data['Specification'][0]['transmission']),
                'condition' => $this->send_value(@$this->request->data['condition'], $data['Ad']['condition']),
                'manual' => $this->send_value(@$this->request->data['manual'], $data['Ad']['manual']),
                'vin_no' => $this->send_value(@$this->request->data['vin_no'], $data['Ad']['vin_no']),
                'doors' => $this->send_value(@$this->request->data['doors'], $data['Ad']['doors']),
                'miles' => $this->send_value(@$this->request->data['miles'], $data['Ad']['miles']),
                'drive_unit' => $this->send_value(@$this->request->data['drive_unit'], $data['Ad']['drive_unit']),
                'drive_type' => $this->send_value(@$this->request->data['drive_type'], $data['Specification'][0]['drive_type']),
                'wheel' => $this->send_value(@$this->request->data['wheel'], $data['Specification'][0]['wheel']),
                'tire' => $this->send_value(@$this->request->data['tire'], $data['Specification'][0]['tire']),
                'exterior_color' => $this->send_value(@$this->request->data['exterior_color'], $data['Specification'][0]['exterior_color']),
                'interior_color' => $this->send_value(@$this->request->data['interior_color'], $data['Specification'][0]['interior_color']),
                'passenger_capacity' => $this->send_value(@$this->request->data['passenger_capacity'], $data['Specification'][0]['passenger_capacity']),
                'engine' => $this->send_value(@$this->request->data['engine'], $data['Specification'][0]['engine']),
                'horse_power' => $this->send_value(@$this->request->data['horse_power'], $data['Specification'][0]['horse_power']),
                'basic_warranty' => $this->send_value(@$this->request->data['basic_warranty'], $data['Specification'][0]['basic_warranty']),
                'powertrain_warranty' => $this->send_value(@$this->request->data['powertrain_warranty'], $data['Specification'][0]['powertrain_warranty']),
                'stock_number' => $this->send_value(@$this->request->data['stock_number'], $data['Specification'][0]['stock_number']),
                'braking_traction' => $this->send_value(@$this->request->data['braking_traction'], $data['Specification'][0]['braking_traction']),
                'comfort_convenience' => $this->send_value(@$this->request->data['comfort_convenience'], $data['Specification'][0]['comfort_convenience']),
                'entertainment_instrumentation' => $this->send_value(@$this->request->data['entertainment_instrumentation'], $data['Specification'][0]['entertainment_instrumentation']),
                'lighting' => $this->send_value(@$this->request->data['lighting'], $data['Specification'][0]['lighting']),
                'roofs_glass' => $this->send_value(@$this->request->data['roofs_glass'], $data['Specification'][0]['roofs_glass']),
                'safety_security' => $this->send_value(@$this->request->data['safety_security'], $data['Specification'][0]['safety_security']),
                'seats' => $this->send_value(@$this->request->data['seats'], $data['Specification'][0]['seats']),
                'steering' => $this->send_value(@$this->request->data['steering'], $data['Specification'][0]['steering']),
                'wheels_tires' => $this->send_value(@$this->request->data['wheels_tires'], $data['Specification'][0]['wheels_tires']),
                'additional_information' => $this->send_value(@$this->request->data['additional_information'], $data['Specification'][0]['additional_information']),
                'category_id' => $this->send_value(@$this->request->data['category_id'], $data['Ad']['category_id']),
                'type_id' => $this->send_value(@$this->request->data['type_id'], $data['Ad']['type_id']),
                'make' => $this->send_value(@$this->request->data['make'], $data['Ad']['make']),
                'modal' => $this->send_value(@$this->request->data['modal'], $data['Ad']['modal']),
                'price' => $this->send_value(@$this->request->data['price'], $data['Ad']['price']),
                'mileage' => $this->send_value(@$this->request->data['mileage'], $data['Ad']['mileage']),
                'is_new' => $this->send_value(@$this->request->data['is_new'], $data['Ad']['is_new']),
                'year' => $this->send_value(@$this->request->data['year'], $data['Ad']['year']),
                'modified_date' => $this->send_value(@$this->request->data['modified_date'], $data['Ad']['modified_date']),
                'state' => $this->send_value(@$this->request->data['state'], $data['Ad']['state']),
                'zip_code' => $this->send_value(@$this->request->data['zip_code'], $data['Ad']['zip_code']),
                'location' => $this->send_value(@$this->request->data['location'], $data['Ad']['location']),
                'latitude' => $this->send_value(@$this->request->data['latitude'], $data['Ad']['latitude']),
                'longitude' => $this->send_value(@$this->request->data['longitude'], $data['Ad']['longitude']),
                'mileage' => $this->send_value(@$this->request->data['mileage'], $data['Ad']['mileage']),
            );
            $requestdata = $this->validarray($required, $notrequired);

            $this->loadModel('Ad');
            $this->loadModel('Specification');
            $this->loadModel('AdImage');
            $this->loadModel('ParchasPlan');
            $requestdata['id'] = $data['Ad']['id'];
            if ($this->Ad->save($requestdata)) {
                $ad_id = $data['Ad']['id'];
                $notrequired['id'] = $data['Specification'][0]['id'];
                $this->Specification->save($notrequired);
                //pr($_FILES['image']);
                if (count(@$_FILES['image']) > 0) {
                    $final = [];
                    if (is_array($_FILES['image'])) {
                        $image = [];
                        $i = 0;
                        foreach ($_FILES['image']['name'] as $k => $val) {
                            $image = [
                                'name' => $_FILES['image']['name'][$i],
                                'type' => $_FILES['image']['type'][$i],
                                'error' => $_FILES['image']['error'][$i],
                                'tmp_name' => $_FILES['image']['tmp_name'][$i],
                                'size' => $_FILES['image']['size'][$i],
                            ];
                            $i++;
                            $images = $this->_upload_file($image, '', 'image');
                            if (strlen($images) > 0) {
                                $images = $this->_abs_url1('/uploads/image/' . $images);
                            } else {
                                $images = "";
                            }
                            $final[] = [
                                'ad_id' => $ad_id,
                                'images' => $images,
                            ];
                        }
                        $this->AdImage->create();
                        $this->AdImage->saveall($final);
                    }
                }
                $this->body = $this->getsingalad($required['ad_id']);
                $this->status['message'] = "Ad add successfully";
            } else {
                throw new Exception("Eroor to add the ad");
            }
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function getsingalad($ad_id) {
        $this->loadModel('Ad');
        return $this->Ad->find('first', [
                    'conditions' => [
                        'Ad.id' => $ad_id
                    ]
        ]);
    }

    public function step_one() {
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
            $this->status['message'] = "Number is available";
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function get_info_ad() {
        try {
            if (!$this->request->is(array('post'))) {
                throw new Exception('Only post supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'ad_id' => @$this->request->data['ad_id'],
                'checking_exits' => 1
            );
            $notrequired = array(
            );
            $requestdata = $this->validarray($required, $notrequired);
            $data = $this->getsingalad($required['ad_id']);
            $this->body=$data['Ad'];
            $this->body['category_name'] = $data['Category']['name'];
            $this->body['type_name'] = $data['Type']['name'];
            $this->body['Specification'] = $data['Specification'];
            $this->body['images'] = $data['AdImage'];
            $this->body['userinfo'] = $data['User'];
            $this->status['message'] = "details fetch successfully";
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function step_two() {
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
                'otp' => 11111, //round(00000,9999),
                'checking_exits' => 1
            );
            $notrequired = array(
                'device_type' => @$this->request->data['device_type'],
                'device_type' => $this->send_value(@$this->request->data['device_token'], '0'),
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
                $this->status['message'] = "Signup successfully";
                $this->body['authorization_key'] = $requestdata['authorization_key'];
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
        $this->loadModel('ParchasPlan');
        $options = ['conditions' => ['User.authorization_key' => $authorization_key]];
        $restaurant = $this->User->find('first', $options);
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
        unset($restaurant['User']['device_type']);
        unset($restaurant['User']['device_token']);
        $plan = $this->ParchasPlan->find('first', [
            'conditions' => [
                'ParchasPlan.user_id' => $restaurant['User']['id']
            ]
        ]);
        //prx($plan);
        if ($plan) {
            $restaurant['User']['plan_info'] = $plan['ParchasPlan'];
            $restaurant['User']['plan_info']['plan_details'] = $plan['Plan'];
        } else {
            $restaurant['User']['plan_info'] = (object) [];
        }
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
            $restaurant['User']['password'] = $requestdata['password'];
            $this->User->save($restaurant);
            $this->status['message'] = "password updated ";
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function report_ad() {
        try {
            if (!$this->request->is(array('POST'))) {
                throw new Exception('Only POST  supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'ad_id' => @$this->request->data['ad_id'],
                'checking_exits' => 1
            );
            $notrequired = array(
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('ReportAd');
            $options = [
                'conditions' =>
                [
                    'ReportAd.ad_id' => $requestdata['ad_id'],
                    'ReportAd.user_id' => $requestdata['user_id']
                ]
            ];
            $report = $this->ReportAd->find('first', $options);
            if ($report) {
                throw new Exception("You are already report the ad");
            }
            $this->ReportAd->save($requestdata);
            $this->status['message'] = "Ad Report successfully";
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function appinfo() {
        try {
            if (!$this->request->is(array('POST'))) {
                throw new Exception('Only POST  supported');
            }
            $required = array(
                'checking_exits' => 1
            );
            $notrequired = array(
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('AppSetting');
            $data = $this->AppSetting->find('all');
            $final = [];
            foreach ($data as $value) {
                $final[] = $value['AppSetting'];
            }
            $this->body = $final;
            $this->status['message'] = "App Information";
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function paypalpro() {
        try {
            if (!$this->request->is(array('POST'))) {
                throw new Exception('Only POST  supported');
            }
            $required = array(
                'card_number' => @$this->request->data['card_number'],
                'amount' => @$this->request->data['amount'],
                'card_type' => @$this->send_value($this->request->data['card_type'], 'Visa'),
                'cvv' => @$this->request->data['cvv'],
                'card_number' => @$this->request->data['card_number'],
                'expiry_year' => @$this->request->data['expiry_year'],
                'expiry_month' => @$this->request->data['expiry_month'],
                'checking_exits' => 1
            );
            $notrequired = array(
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->paypal($requestdata);
            $this->body = $this->paypal($requestdata);
            $this->status['message'] = "App Information";
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
                $user['User']['otp'] = $requestdata['otp'];
                $this->User->save($user);
            } else {
                throw new Exception("Phone not found");
            }
            $this->status['message'] = "Otp send successfully";
            $this->body['authorization_key'] = $user['User']['authorization_key'];
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
            $data = $this->information($required['authorization_key']);
            if ($data['otp'] == $requestdata['otp']) {
                $requestdata['id'] = $requestdata['user_id'];
                $requestdata['status'] = 1;
                unset($requestdata['user_id']);
                $this->User->save($requestdata, ['validate' => false]);
                $this->status['message'] = "otp successfully verify ";
                $this->body = $this->information($requestdata['authorization_key']);
                $this->Session->write('User', $this->body);
            } else {
                throw new Exception("Wrong otp");
            }
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function send_message() {

        try {
            if (!$this->request->is(array('Post'))) {
                throw new Exception('Only Post  supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'friend_id' => @$this->request->data['friend_id'],
                'ad_id' => @$this->request->data['ad_id'],
                'message_type' => @$this->request->data['message_type'],
                'checking_exits' => 1
            );
            $notrequired = array(
                'message' => @$this->request->data['message'],
            );
            if ($required['message_type'] == 2) {
                $required['thumb_img'] = $_FILES['thumb_img']['name'];
            }
            $requestdata = $this->validarray($required, $notrequired);
            // $this->loadmodel('ChatConstant');
            $this->loadmodel('Chat');
            // $conditions = [
            //     'conditions' => [
            //         'Or' => [
            //             [
            //                 'ChatConstant.user_id' => $requestdata['friend_id'],
            //                 'ChatConstant.friend_id' => $requestdata['user_id'],
            //             ],
            //             [
            //                 'ChatConstant.user_id' => $requestdata['user_id'],
            //                 'ChatConstant.friend_id' => $requestdata['friend_id'],
            //             ],
            //         ],
            //     ]
            // ];
            // $data = $this->ChatConstant->find('first', $conditions);
            // if (!$data) {
            //     $this->ChatConstant->save($requestdata);
            //     $requestdata['constant_id'] = $this->ChatConstant->getLastInsertID();
            // } else {
            //     $requestdata['constant_id'] = $data['ChatConstant']['id'];
            // }
            //$requestdata['sender_id'] = $requestdata['user_id'];
            if ($requestdata['message_type'] != 0) {
                $message = $this->_upload_file($_FILES['message'], '', 'chat');
                $requestdata['message'] = $this->_abs_url('uploads/chat/' . $message);
                if ($requestdata['message_type'] == 2) {
                    $thumb_img = $this->_upload_file($_FILES['thumb_img'], '', 'chat');
                    $requestdata['thumb_img'] = $this->_abs_url('uploads/chat/' . $thumb_img);
                }
            }
            $this->Chat->save($requestdata);
            $chat_id = $this->Chat->getLastInsertID();
            unset($requestdata['authorization_key']);
            $requestdata['id'] = $chat_id;
            $requestdata['created'] = (string) time();
            $requestdata['modified'] = (string) time();
            $requestdata['is_send'] = (string) 0;
            $requestdata['friend_info'] = $this->userinfo1($requestdata['user_id']);
            $requestdata['sender_info'] = $this->userinfo1($requestdata['user_id']);
            $this->status['message'] = "Message send successfully";
            $this->body = $requestdata;
            $push = [];
            $push['user_id'] = $requestdata['friend_id'];
            $push['message'] = $requestdata['message'];
            $push['body'] = $requestdata;
            $push['notification_code'] = 1;
            $this->_send_push($push);
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function get_message() {

        try {
            if (!$this->request->is(array('Post'))) {
                throw new Exception('Only Post  supported');
            }
            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'ad_id' => @$this->request->data['ad_id'],
                'friend_id' => @$this->request->data['friend_id'],
                'checking_exits' => 1
            );
            $notrequired = array(
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadmodel('Chat');
            $conditions = [
                'conditions' => [
                    'Or' => [
                        [
                            'Chat.user_id' => $requestdata['friend_id'],
                            'Chat.friend_id' => $requestdata['user_id'],
                            'Chat.ad_id' => $requestdata['ad_id'],
                        ],
                        [
                            'Chat.user_id' => $requestdata['user_id'],
                            'Chat.friend_id' => $requestdata['friend_id'],
                            'Chat.ad_id' => $requestdata['ad_id'],
                        ],
                    ],
                ]
            ];
            $data = $this->Chat->find('all', $conditions);
            $final = [];
            $new = [];
            foreach ($data as $k => $val) {
                $final[] = $val['Chat'];
                $final[$k]['is_send'] = (string) ($val['Chat']['user_id'] == $requestdata['user_id']) ? "1" : "0";
                $final[$k]['sender_info'] = $this->userinfo1($val['Chat']['user_id']);
                $final[$k]['friend_info'] = $this->userinfo1($val['Chat']['friend_id']);
                $new[]['id'] = $val['Chat']['id'];
                $new[$k]['status'] = 1;
            }

            if ($new) {
                $this->Chat->saveall($new); // update status for read message
            }
            if (!$data) {
                throw new Exception("no chat found");
            }
            $this->status['message'] = "Chat fetch successfully";
            $this->body = $final;
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    private function userinfo1($user_id) {
        $this->loadModel('User');
        $options = [
            'conditions' => ['User.id' => $user_id],
            'fields' => ['id', 'name', 'email', 'phone', 'photo', 'user_type', 'last_login']
        ];
        $restaurant = $this->User->find('first', $options);
        $restaurant['total_offer'] = (string) 0;
        $restaurant['active_offer'] = (string) 0;
        $restaurant['use_this_service'] = (string) 0;
        return $restaurant['User'];
    }

    public function last_chat() {
        try {
            if (!$this->request->is(array('get'))) {
                throw new Exception('Only get  supported');
            }

            $required = array(
                'authorization_key' => @$this->request->header('Authorization-key'),
                'checking_exits' => 1
            );
            $notrequired = array();
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadmodel('ChatConstant');
            $this->loadmodel('Chat');
            $conditions = [
                'conditions' => [
                    'Or' => [
                        [
                            'Chat.user_id' => $requestdata['user_id'],
                        ],
                        [
                            'Chat.friend_id' => $requestdata['user_id'],
                        ]
                    ],
                ],
                'group' => 'Chat.ad_id',
                'order' => 'Chat.id'
            ];


            $last_chat = $this->Chat->find('all', $conditions);
            $final = [];
            foreach ($last_chat as $k => $v) {
                $final[] = $v['Chat'];
                $friend_id = ($v['Chat']['user_id'] == $requestdata['user_id']) ? $v['Chat']['friend_id'] : $v['Chat']['user_id'];
                $final[$k]['friend_info'] = $this->userinfo1($friend_id);
            }

            $this->status['message'] = "last chat fetch successfully";
            $this->body = $final;
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

    public function UserLogin() {
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
                'device_type' => $this->send_value(@$this->request->data['device_type'], '0'),
                'device_token' => $this->send_value(@$this->request->data['device_token'], '0'),
                'authorization_key' => $this->_generate_random_number(),
            );
            $requestdata = $this->validarray($required, $notrequired);
            $this->loadModel('User');
            $options = ['conditions' => ['User.phone' => $requestdata['phone'], 'User.password' => $requestdata['password']]];
            $admin = $this->User->find('first', $options);

            if ($admin) {
                $notrequired['id'] = $admin['User']['id'];
                $this->User->save($notrequired);
                $admin['User']['authorization_key'] = $notrequired['authorization_key'];
                $this->status['message'] = "login successfully";
                unset($admin['User']['password']);
                $this->body = $this->information($notrequired['authorization_key']);
                $this->Session->write('User', $this->body);
            } else {
                throw new Exception('Wrong phone or password');
            }
        } catch (Exception $ex) {
            $this->status = FAILURE_CODE;
            $this->body = $ex->getMessage();
        }
    }

}
