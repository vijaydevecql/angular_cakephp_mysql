<?php
App::uses('AppModel', 'Model');


class FavouriteAd extends AppModel {


	public $hasMany = array(
	

	);


	 public $belongsTo = array(

		'User' => array(
		'className' => 'User',
		'foreignKey' => 'user_id',
		'conditions' => '',
		'fields' => 'id,name,email,phone,photo,user_type,last_login',
		'order' => ''
	),
	// 	'Ad' => array(
	// 	'className' => 'Ad',
	// 	'foreignKey' => 'ad_id',
	// 	'conditions' => '',
	// 	'fields' => '',
	// 	'order' => ''
	// ),


	);

}
