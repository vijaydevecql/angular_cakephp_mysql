<?php
App::uses('AppModel', 'Model');


class Ad extends AppModel {


	public $hasMany = array(
	'Specification' => array(
	'className' => 'Specification',
	'foreignKey' => 'ad_id',
	'dependent' => false,
	'conditions' => '',
	'fields' => '',
	'order' => '',
	'limit' => '',
	'offset' => '',
	'exclusive' => '',
	'finderQuery' => '',
	'counterQuery' => ''
	),
	'AdImage' => array(
	'className' => 'AdImage',
	'foreignKey' => 'ad_id',
	'dependent' => false,
	'conditions' => '',
	'fields' => '',
	'order' => '',
	'limit' => '',
	'offset' => '',
	'exclusive' => '',
	'finderQuery' => '',
	'counterQuery' => ''
	)
	);


	 public $belongsTo = array(

		'Category' => array(
 		'className' => 'Category',
 		'foreignKey' => 'category_id',
 		'conditions' => '',
 		'fields' => 'name',
 		'order' => ''
 	),

		'User' => array(
		'className' => 'User',
		'foreignKey' => 'user_id',
		'conditions' => '',
		'fields' => 'id,name,email,phone,photo,user_type,last_login,active_offer,pending_offer',
		'order' => ''
	),

		'Type' => array(
		'className' => 'Type',
		'foreignKey' => 'type_id',
		'conditions' => '',
		'fields' => 'name',
		'order' => ''
	),
	);

}
