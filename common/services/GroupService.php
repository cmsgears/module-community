<?php
namespace cmsgears\community\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\ModelCategory;
use cmsgears\cms\common\models\entities\ModelContent;
use cmsgears\community\common\models\entities\Group;

use cmsgears\core\admin\services\FileService;

/**
 * The class GroupService is base class to perform database activities for Group Entity.
 */
class GroupService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Group::findById( $id );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new Group(), $config );
	}

	// Create -----------

	public static function create( $group, $content, $avatar = null, $banner = null ) {

		// Save Avatar
		if( isset( $avatar ) ) {

			FileService::saveImage( $avatar, [ 'model' => $group, 'attribute' => 'avatarId' ] ); 
		}

		// Create Group
		$group->save();

		$content->parentId		= $group->id;
		$content->parentType	= CmnGlobal::TYPE_GROUP;

		// Save Banner
		if( isset( $banner ) ) {

			FileService::saveImage( $banner, [ 'model' => $content, 'attribute' => 'bannerId' ] );
		}

		// Create Content
		$content->save();

		return $group;
	}

	// Update -----------

	public static function update( $group, $content, $avatar = null, $banner = null ) {

		$user				= Yii::$app->user->getIdentity();
		$groupToUpdate		= self::findById( $group->id );
		$contentToUpdate	= ModelContent::findById( $content->id );

		$groupToUpdate->copyForUpdateFrom( $group, [ 'avatarId', 'name', 'visibility', 'status' ] );

		$groupToUpdate->modifiedBy	= $user->id;

		$contentToUpdate->copyForUpdateFrom( $content, [ 'bannerId', 'templateId', 'summary', 'content', 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ] );

		// Save Avatar
		if( isset( $banner ) ) {

			FileService::saveImage( $avatar, [ 'model' => $groupToUpdate, 'attribute' => 'avatarId' ] );
		}

		// Save Banner
		if( isset( $banner ) ) {

			FileService::saveImage( $banner, [ 'model' => $contentToUpdate, 'attribute' => 'bannerId' ] );
		}

		$groupToUpdate->update();

		$contentToUpdate->update();

		return $groupToUpdate;
	}

	public static function bindCategories( $binder ) {

		$groupId		= $binder->binderId;
		$categories		= $binder->bindedData;

		// Clear all existing mappings
		ModelCategory::deleteByParentIdType( $groupId, $type );

		if( isset( $categories ) && count( $categories ) > 0 ) {

			foreach ( $categories as $key => $value ) {

				if( isset( $value ) && $value > 0 ) {

					$toSave		= new ModelCategory();

					$toSave->parentId	= $groupId;
					$toSave->parentType	= CmnGlobal::TYPE_GROUP;
					$toSave->categoryId	= $value;

					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	public static function delete( $group, $content ) {

		$existingGroup		= self::findById( $group->id );
		$existingContent	= ModelContent::findById( $content->id );

		// Delete Group
		$existingGroup->delete();

		// Delete Content
		$existingContent->delete();

		return true;
	}
}

?>