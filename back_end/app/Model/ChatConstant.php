<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property UserAllergy $UserAllergy
 * @property UserPrefer $UserPrefer
 */
class ChatConstant extends AppModel {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'chat_id'=> array()		
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	/*
	  public $hasMany = array(
	  'UserAllergy' => array(
	  'className' => 'UserAllergy',
	  'foreignKey' => 'user_id',
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
	  'UserPrefer' => array(
	  'className' => 'UserPrefer',
	  'foreignKey' => 'user_id',
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
	 */

	 public $belongsTo = array(
	  'Chat' => array(
	  'className' => 'Chat',
	  'foreignKey' => 'id',
	  'conditions' => '',
	  'fields' => '',
	  'order' => ''
	  )
	  ); 
	

}
