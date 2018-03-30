<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\services\mappers;

// Yii Imports
use yii\data\Sort;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\community\common\models\mappers\GroupMember;

use cmsgears\community\common\services\interfaces\mappers\IGroupMemberService;

use cmsgears\core\common\services\traits\ApprovalTrait;

use cmsgears\core\common\services\base\MapperService;

use cmsgears\core\common\utilities\DateUtil;

/**
 * GroupMemberService provide service methods of group member.
 *
 * @since 1.0.0
 */
class GroupMemberService extends MapperService implements IGroupMemberService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\cmsgears\community\common\models\mappers\GroupMember';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use ApprovalTrait;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// GroupMemberService --------------------

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
	            'user' => [
	                'asc' => [ "$modelTable.userId" => SORT_ASC ],
	                'desc' => [ "$modelTable.userId" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'User'
	            ],
	            'role' => [
	                'asc' => [ "$modelTable.roleId" => SORT_ASC ],
	                'desc' => [ "$modelTable.roleId" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Role'
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
	            ],
	            'sdate' => [
	                'asc' => [ "$modelTable.syncedAt" => SORT_ASC ],
	                'desc' => [ "$modelTable.syncedAt" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Synced At'
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

   	public function getByUserId( $id ) {

		$modelClass	= static::$modelClass;

		return $modelClass::findByUserId( $id );
	}

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function addMember( $groupId, $userId, $join = false, $admin = false ) {

		$model	= $this->getModelObject();
		$role	= null;

		if( $admin ) {

			$role = Yii::$app->get( 'roleService' )->getBySlugType( CmnGlobal::ROLE_GROUP_MASTER, CmnGlobal::TYPE_COMMUNITY );
		}
		else {

			$role = Yii::$app->get( 'roleService' )->getBySlugType( CmnGlobal::ROLE_GROUP_MEMBER, CmnGlobal::TYPE_COMMUNITY );
		}

		$model->groupId	= $groupId;
		$model->userId	= $userId;
		$model->roleId	= $role->id;

		if( !$join ) {

			$model->status = GroupMember::STATUS_ACTIVE;
		}

		$model->save();

		return $model;
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$admin = isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;

		$model->syncedAt = DateUtil::getDateTime();

		if( $admin ) {

			return parent::update( $model, [
				'attributes' => [ 'status', 'syncedAt' ]
			]);
		}

		return parent::update( $model, [
			'attributes' => [ 'syncedAt' ]
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

	// GroupMemberService --------------------

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
