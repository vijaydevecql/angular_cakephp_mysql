<?php

App::uses('AppController', 'Controller');

/**
 * Admins Controller
 *
 * @property Admin $Admin
 * @property PaginatorComponent $Paginator
 */
class AdminsController extends AppController {

    function beforeRender() {
        parent::beforeRender();
    }

    function beforeFilter() {
        parent::beforeFilter();
        /**
         * Stores array of deniable methods, without logging in.
         */
        $this->_deny = array(
            'admin' => array(
                'admin_dashboard',
                'admin_logout',
            ),
        );
        $this->_deny_url($this->_deny);
    }

    function admin_login() {
		if ($this->_admin_auth_check()) {
			return $this->redirect('/admin/dashboard');
		}
        $this->layout = 'admin_login';
        if ($this->request->is('post')) 
        {
            $admin = @$this->Admin->findByemail($this->request->data['Admin']['email']);
            
            if (@$admin['Admin']['password'] == sha1($this->request->data['Admin']['password'])) {
                $this->Session->write('Admin', $admin['Admin']);
                return $this->redirect('dashboard');
            } else {
				$this->set('$this->request->data', $this->request->data);
				$this->set('error', 1);
            }
        }
    }

    function admin_dashboard() {
        $this->layout = 'admin_dashboard';
		$this->loadModel('User');
		$this->loadModel('Post');
		$total=$this->User->find('count', ['conditions'=>['User.status'=>1]]);
		$total1=$this->Post->find('count', ['conditions'=>['Post.status'=>1]]);
		$total2=$this->Post->find('count', ['conditions'=>['Post.status'=>1 , 'Post.type'=>3]]);
		$total3=$this->Post->find('count', ['conditions'=>['Post.status'=>1 , 'Post.type'=>4]]);
		$this->set('total_user',$total);
		$this->set('total_post',$total1);
		$this->set('total_audio_post',$total2);
		$this->set('total_video_post',$total3);
		$this->set('page','dashboard');
    }

	function admin_logout() {
		// Delete Admin Cookie
		$this->Session->delete('Admin');
		// Reset Session ID
		$this->Session->renew();
		// Add  flash message
		//$this->f('You are now logged out.', 's');
		// Redirect to admin login
		$this->redirect('/admin/admins/login');
	}
	
	function admin_profile(){
		$this->layout = 'admin_dashboard';
	}
	
	
	function update_profile(){
		$this->Admin->save($this->request->data);
		$admin = $this->Admin->findByid($this->request->data['id']);
		//prx($this->request->data);
		$this->Session->write('Admin', $admin['Admin']);
		echo 1;
		die;
	}
	
	function change_password(){
		$admin = $this->Admin->findByid($this->request->data['id']);
		if($admin['Admin']['password']==sha1($this->request->data['old_password'])){
			$this->request->data['password']=sha1($this->request->data['password']);
			$this->Admin->save($this->request->data);
			echo 1;
			
		}else{
			echo 0;
		}
		die;
	}

	function upload_img()
{
	
	 $user_id = $this->_admin_data['id'];
	 
	 $name = $this->_upload_file($_FILES['image'],"",'admin');
	 $admin['Admin']['photo'] = $name;
	 $this->Admin->id = $user_id;
	 if($this->Admin->save($admin))
	 {
	 	$admin=$this->Admin->find('first',[
	 		'conditions' => [
	 				'Admin.id' => $user_id
	 			]
	 		]);
	 	$this->Session->write('Admin',$admin['Admin']);
	 	echo 1;
	 }
	 else
	 {
		echo  0;
	 } 
		die;
}

 function admin_Setting() {
        $this->loadModel('Setting');
        $this->set('title', 'setting');
        $this->set('page', 'setting');
        $this->layout = 'admin_dashboard';
        $data = $this->Setting->find('all');
        $this->set('setting', $data);
    }

	 function update_setting() {
        $this->loadModel('Setting');
        if ($this->Setting->save($this->request->data)) {
            echo 1;
        } else {
            echo 0;
        }
        die;
    }
	
	
	
}
