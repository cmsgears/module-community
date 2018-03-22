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
use cmsgears\community\common\models\base\CmnTables;
use cmsgears\community\common\models\resources\GroupMessage;

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

	public static $modelTable	= CmnTables::TABLE_GROUP_MESSAGE;

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

	    $sort = new Sort([
	        'attributes' => [
	            'group' => [
	                'asc' => [ 'groupId' => SORT_ASC ],
	                'desc' => ['groupId' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Group'
	            ],
	            'sender' => [
	                'asc' => [ 'senderId' => SORT_ASC ],
	                'desc' => ['senderId' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Sender'
	            ],
	            'type' => [
	                'asc' => [ 'type' => SORT_ASC ],
	                'desc' => ['type' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Type'
	            ],
	            'cdate' => [
	                'asc' => [ 'createdAt' => SORT_ASC ],
	                'desc' => ['createdAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Created At',
	            ],
	            'udate' => [
	                'asc' => [ 'modifiedAt' => SORT_ASC ],
	                'desc' => ['modifiedAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Update At',
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

		GroupMessage::deleteByGroupId( $groupId );
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
