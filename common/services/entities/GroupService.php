<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\services\entities;

// Yii Imports
use yii\data\Sort;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\community\common\models\base\CmnTables;

use cmsgears\core\common\services\interfaces\resources\IFileService;
use cmsgears\community\common\services\interfaces\entities\IGroupService;
use cmsgears\community\common\services\interfaces\resources\IGroupMessageService;
use cmsgears\community\common\services\interfaces\mappers\IGroupMemberService;

use cmsgears\core\common\services\base\EntityService;

use cmsgears\core\common\services\traits\base\NameTypeTrait;
use cmsgears\core\common\services\traits\base\SlugTypeTrait;

/**
 * GroupService provide service methods of group model.
 *
 * @since 1.0.0
 */
class GroupService extends EntityService implements IGroupService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\community\common\models\entities\Group';

	public static $modelTable	= CmnTables::TABLE_GROUP;

	public static $typed		= true;

	public static $parentType	= CmnGlobal::TYPE_GROUP;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $fileService;
	protected $groupMessageService;
	protected $groupMemberService;

	// Private ----------------

	// Traits ------------------------------------------------------

	use NameTypeTrait;
	use SlugTypeTrait;

	// Constructor and Initialisation ------------------------------

    public function __construct( IFileService $fileService, IGroupMessageService $groupMessageService, IGroupMemberService $groupMemberService, $config = [] ) {

		$this->fileService			= $fileService;
		$this->groupMessageService 	= $groupMessageService;
		$this->groupMemberService 	= $groupMemberService;

        parent::__construct( $config );
    }

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// GroupService --------------------------

	// Data Provider ------

    public function getPage( $config = [] ) {

    	$modelTable = static::$modelTable;

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ "$modelTable.name" => SORT_ASC ],
	            	'desc' => [ "$modelTable.name" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Name'
	            ],
	            'slug' => [
            		'asc' => [ "$modelTable.slug" => SORT_ASC ],
            		'desc' => [ "$modelTable.slug" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Slug'
	            ],
	            'owner' => [
	                'asc' => [ 'createdBy' => SORT_ASC ],
	                'desc' => ['createdBy' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Owner'
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
	                'label' => 'Updated At',
	            ]
	        ],
	        'defaultOrder' => [
	        	'cdate' => SORT_DESC
	        ]
	    ]);

	    if( !isset( $config[ 'sort' ] ) ) {

	    	$config[ 'sort' ] = $sort;
		}

		return parent::findPage( $config );
	}

	public function getPageByType( $type ) {

		return $this->getPage( [ 'conditions' => [ 'type' => $type ] ] );
	}

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$avatar = isset( $config[ 'avatar' ] ) ? $config[ 'avatar' ] : null;

		$this->fileService->saveFiles( $model, [ 'avatarId' => $avatar ] );

		return parent::create( $model, $config );
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$avatar = isset( $config[ 'avatar' ] ) ? $config[ 'avatar' ] : null;
		$admin 	= isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;

		$this->fileService->saveFiles( $model, [ 'avatarId' => $avatar ] );

		if( $admin ) {

			return parent::update( $model, [
				'attributes' => [ 'avatarId', 'name', 'visibility', 'status' ]
			]);
		}

		return parent::update( $model, [
			'attributes' => [ 'avatarId', 'name' ]
		]);
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		// Delete Members
		$this->groupMemberService->deleteByGroupId( $group->id );

		// Delete Messages
		$this->groupMessageService->deleteByGroupId( $group->id );

		return parent::delete( $model, $config );
	}

	// Bulk ---------------

	protected function applyBulk( $model, $column, $action, $target, $config = [] ) {

		switch( $column ) {

			case 'model': {

				switch( $action ) {

					case 'delete': {

						$this->delete( $model );

						break;
					}
				}

				break;
			}
		}
	}

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// GroupService --------------------------

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
