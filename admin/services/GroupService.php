<?php
namespace cmsgears\community\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\models\entities\CmgFile;

use cmsgears\community\common\models\entities\Group;
use cmsgears\community\common\models\entities\GroupCategory;

use cmsgears\core\admin\services\FileService;

use cmsgears\core\common\utilities\CodeGenUtil;
use cmsgears\core\common\utilities\DateUtil;

class GroupService extends \cmsgears\community\common\services\GroupService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination( $conditions = [] ) {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'name' => SORT_ASC ],
	                'desc' => ['name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'cdate' => [
	                'asc' => [ 'createdAt' => SORT_ASC ],
	                'desc' => ['createdAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'cdate',
	            ],
	            'udate' => [
	                'asc' => [ 'updatedAt' => SORT_ASC ],
	                'desc' => ['updatedAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'udate',
	            ]
	        ],
	        'defaultOrder' => [
	        	'cdate' => SORT_DESC
	        ]
	    ]);

		$conditions[ 'type' ]	= 0;

		return self::getPaginationDetails( new Group(), [ 'sort' => $sort, 'conditions' => $conditions, 'search-col' => 'name' ] );
	}

	// Create -----------

	public static function create( $group, $avatar, $banner ) {

		// Create Group		
		$date 		= DateUtil::getMysqlDate();
		$user		= Yii::$app->user->getIdentity();

		// Group Properties
		$group->createdAt 	= $date;
		$group->ownerId		= $user->id;
		$group->slug 		= CodeGenUtil::generateSlug( $group->name );

		// Save Avatar
		FileService::saveImage( $avatar, $user, [ 'model' => $group, 'attribute' => 'avatarId' ] );

		// Save Banner
		FileService::saveImage( $banner, $user, [ 'model' => $group, 'attribute' => 'bannerId' ] );

		$group->save();

		return $group;
	}

	// Update -----------

	public static function update( $group, $avatar, $banner ) {
		
		$date 			= DateUtil::getMysqlDate();
		$user			= Yii::$app->user->getIdentity();
		$groupToUpdate	= self::findById( $group->id );

		$groupToUpdate->updatedAt 	= $date;
		$groupToUpdate->slug 		= CodeGenUtil::generateSlug( $group->name );

		$groupToUpdate->copyForUpdateFrom( $group, [ 'name', 'description', 'avatarId', 'bannerId', 'content', 'visibility', 'status' ] );

		// Save Avatar
		FileService::saveImage( $avatar, $user, [ 'model' => $groupToUpdate, 'attribute' => 'avatarId' ] );

		// Save Banner
		FileService::saveImage( $banner, $user, [ 'model' => $groupToUpdate, 'attribute' => 'bannerId' ] );

		$groupToUpdate->update();

		return $groupToUpdate;
	}

	public static function bindCategories( $binder ) {

		$groupId		= $binder->groupId;
		$categories		= $binder->bindedData;

		// Clear all existing mappings
		GroupCategory::deleteByGroupId( $groupId );

		if( isset( $categories ) && count( $categories ) > 0 ) {

			foreach ( $categories as $key => $value ) {

				if( isset( $value ) ) {

					$toSave				= new GroupCategory();
					$toSave->groupId 	= $groupId;
					$toSave->categoryId	= $value;

					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	public static function delete( $group ) {

		$existingGroup	= self::findById( $group->id );

		// Delete Group
		$existingGroup->delete();

		return true;
	}
}

?>