<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property UserAllergy $UserAllergy
 * @property UserPrefer $UserPrefer
 */
class Chat extends AppModel {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
			
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

	 // public $belongsTo = array(
	  // 'User' => array(
	  // 'className' => 'User',
	  // 'foreignKey' => 'sender_id,friend_id',
	  // 'conditions' => '',
	  // 'fields' => '',
	  // 'order' => ''
	  // )
	  // );
	

}
