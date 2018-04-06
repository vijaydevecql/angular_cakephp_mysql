<?php
App::uses('AppModel', 'Model');
/**
 * Image Model
 *
 * @property Folder $Folder
 */
class Image extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
	);

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Folder' => array(
			'className' => 'Folder',
			'foreignKey' => 'folder_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
