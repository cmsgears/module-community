<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\services\resources;

// Yii Imports
use yii\data\Sort;

// CMG Imports
use cmsgears\community\common\services\interfaces\resources\IGroupMessageService;

use cmsgears\core\common\services\base\ResourceService;

/**
 * GroupMessageService provide service methods of group message.
 *
 * @since 1.0.0
 */
class GroupMessageService extends ResourceService implements IGroupMessageService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\community\common\models\resources\GroupMessage';

	public static $parentType	= null;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// GroupMessageService -------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

	    $sort = new Sort([
	        'attributes' => [
	            'id' => [
	                'asc' => [ "$modelTable.id" => SORT_ASC ],
	                'desc' => [ "$modelTable.id" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Id'
	            ],
	            'group' => [
	                'asc' => [ "$modelTable.groupId" => SORT_ASC ],
	                'desc' => [ "$modelTable.groupId" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Group'
	            ],
	            'sender' => [
	                'asc' => [ "$modelTable.senderId" => SORT_ASC ],
	                'desc' => [ "$modelTable.senderId" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Sender'
	            ],
	            'type' => [
	                'asc' => [ "$modelTable.type" => SORT_ASC ],
	                'desc' => [ "$modelTable.type" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Type'
	            ],
	            'cdate' => [
	                'asc' => [ "$modelTable.createdAt" => SORT_ASC ],
	                'desc' => [ "$modelTable.createdAt" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Created At'
	            ],
	            'udate' => [
	                'asc' => [ "$modelTable.modifiedAt" => SORT_ASC ],
	                'desc' => [ "$modelTable.modifiedAt" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Update At'
	            ]
	        ],
	        'defaultOrder' => [
	        	'cdate' => SORT_DESC
	        ]
	    ]);

		if( !isset( $conditions[ 'sort' ] ) ) {

			$conditions[ 'sort' ] = $sort;
		}

		return parent::findPage( $config );
	}

	public function getPageByGroupId( $groupId ) {

		return $this->getPage( [ 'conditions' => [ 'groupId' => $groupId ] ] );
	}

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function update( $model, $config = [] ) {

		return parent::update( $model, [
			'attributes' => [ 'content', 'data' ]
		]);
	}

	// Delete -------------

	public function deleteByGroupId( $groupId ) {

		$modelClass	= static::$modelClass;

		$modelClass::deleteByGroupId( $groupId );
	}

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// GroupMessageService -------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

}
