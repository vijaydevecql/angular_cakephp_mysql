<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class PostsController extends AppController {

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

    function admin_add_posts() {
        $this->loadModel('Post');
           $id = 0;

           $filename = '';
        if($this->request->is('post'))
        {
            if($this->request->data['type'] != 1)
            {
               $filename =  $this->_upload_file($this->request->data['Post']['value'],'','admin');
            }
            else
            {
                $filename = $this->request->data['Post']['value'];
            }


           //prx($this->request->data);
            $post = array(
                        'Post' => array(
                            'user_id' => @$this->request->data['Post']['user_id'],
                            'type' => @$this->request->data['type'],
                            'value' => $filename,
                            'status' => ,1     
                        )
                    ); 
            if ($this->Post->save($post, ['validate' => false])) {
             $id = $this->Post->getLastInsertID();
        }
        else
        {
            $id = 0;
        }
        }
        echo $id;
        die;
    }
}