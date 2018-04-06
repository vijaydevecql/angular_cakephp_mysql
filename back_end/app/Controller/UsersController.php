<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

    function beforeRender() {
        parent::beforeRender();

    }

    function beforeFilter() {
      // if($this->Session->read('User')){
      //   $this->redirect('complete');
      // }else{
      //   $this->redirect('users');
      // }
        parent::beforeFilter();
        /**
         * Stores array of deniable methods, without logging in.
         */
        $this->_deny = array(
            'admin' => array(
                'admin_index',
                'admin_posts',
                'admin_login',
                'admin_update',
                'admin_folder',
                'admin_video',
                'admin_images',
                'admin_logout',
                'admin_all_images',
            ),
        );
        $this->_deny_url($this->_deny);
    }


    public function users(){
      if($this->Session->read('User')){
         $this->redirect('complete');
       }
      $this->layout = 'web';
    }
    public function change_password(){
      $this->layout = 'web';
    }
    public function register(){
      if($this->Session->read('User')){
         $this->redirect('complete');
       }
      $this->layout = 'web';
    }

    public function complete(){

      $this->layout = 'web';
      //  if(!$this->Session->read('User')){
      //   $this->redirect("users");
      // }
      //prx($this->Session->read('User'));

    }
    public function logout(){
      $this->Session->delete('User');
      $this->redirect("users");
    }

}
