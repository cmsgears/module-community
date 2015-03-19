<?php
namespace cmsgears\modules\community\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\modules\core\common\models\entities\CmgFile;

use cmsgears\modules\community\common\models\entities\Group;
use cmsgears\modules\community\common\models\entities\GroupCategory;

use cmsgears\modules\core\admin\services\FileService;

use cmsgears\modules\core\common\utilities\CodeGenUtil;
use cmsgears\modules\core\common\utilities\DateUtil;

class GroupService extends \cmsgears\modules\community\common\services\GroupService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination() {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'group_name' => SORT_ASC ],
	                'desc' => ['group_name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'cdate' => [
	                'asc' => [ 'group_created_on' => SORT_ASC ],
	                'desc' => ['group_created_on' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'cdate',
	            ],
	            'udate' => [
	                'asc' => [ 'group_updated_on' => SORT_ASC ],
	                'desc' => ['group_updated_on' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'udate',
	            ]
	        ],
	        'defaultOrder' => [
	        	'cdate' => SORT_DESC
	        ]
	    ]);

		return self::getPaginationDetails( new Group(), [ 'sort' => $sort, 'search-col' => 'group_name' ] );
	}

	// Create -----------

	public static function create( $group, $avatar, $banner ) {

		// Create Group		
		$date 		= DateUtil::getMysqlDate();
		$user		= Yii::$app->user->getIdentity();

		// Group Properties
		$group->setCreatedOn( $date );
		$group->setOwnerId( $user->getId() );
		$group->setSlug( CodeGenUtil::generateSlug( $group->getName() ) );

		// Save Avatar
		FileService::saveImage( $avatar, $user, Yii::$app->fileManager );

		// New Avatar
		$avatarId 	= $avatar->getId();

		if( isset( $avatarId ) && intval( $avatarId ) > 0 ) {

			$group->setAvatarId( $avatarId );
		}

		// Save Banner
		FileService::saveImage( $banner, $user, Yii::$app->fileManager );

		// New Banner
		$bannerId 	= $banner->getId();

		if( isset( $bannerId ) && intval( $bannerId ) > 0 ) {

			$group->setBannerId( $bannerId );
		}

		$group->save();

		return true;
	}

	// Update -----------

	public static function update( $group, $avatar, $banner ) {
		
		$date 			= DateUtil::getMysqlDate();
		$user			= Yii::$app->user->getIdentity();
		$groupToUpdate	= self::findById( $group->getId() );

		$groupToUpdate->setName( $group->getName() );
		$groupToUpdate->setDesc( $group->getDesc() );
		$groupToUpdate->setUpdatedOn( $date );
		$groupToUpdate->setAvatarId( $group->getAvatarId() );
		$groupToUpdate->setBannerId( $group->getBannerId() );
		$groupToUpdate->setStatus( $group->getStatus() );
		$groupToUpdate->setVisibility( $group->getVisibility() );
		$groupToUpdate->setSlug( CodeGenUtil::generateSlug( $group->getName() ) );

		// Save Avatar
		FileService::saveImage( $avatar, $user, Yii::$app->fileManager );

		// New Avatar
		$avatarId 	= $avatar->getId();

		if( isset( $avatarId ) && intval( $avatarId ) > 0 ) {

			$groupToUpdate->setAvatarId( $avatarId );
		}

		// Save Banner
		FileService::saveImage( $banner, $user, Yii::$app->fileManager );

		// New Banner
		$bannerId 	= $banner->getId();

		if( isset( $bannerId ) && intval( $bannerId ) > 0 ) {

			$groupToUpdate->setBannerId( $bannerId );
		}

		$groupToUpdate->update();

		return true;
	}

	public static function bindCategories( $binder ) {

		$groupId		= $binder->groupId;
		$categories		= $binder->bindedData;

		// Clear all existing mappings
		GroupCategory::deleteByGroupId( $groupId );

		if( isset( $categories ) && count( $categories ) > 0 ) {

			foreach ( $categories as $key => $value ) {

				if( isset( $value ) ) {

					$toSave		= new GroupCategory();

					$toSave->setGroupId( $groupId );
					$toSave->setCategoryId( $value );

					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	public static function deleteCategories( $category ) {

		// Clear all existing mappings
		GroupCategory::deleteByCategory( $category->getId() );

		return true;
	}

	public static function delete( $group ) {

		$groupId		= $group->getId();
		$existingGroup	= self::findById( $groupId );

		// Delete Group
		$existingGroup->delete();

		return true;
	}
}

?>