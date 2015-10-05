<?php
namespace cmsgears\community\common\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

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
	
	public static function getPaginationDetailsByType( $type ) {
		
		return self::getPagination( [ 'conditions' => [ 'type' => $type ] ] );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $conditions= [] ) {

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

		if( !isset( $conditions[ 'query' ] ) ) {

			$conditions[ 'query' ] = Group::findWithContent();
		}

		if( !isset( $conditions[ 'sort' ] ) ) {

			$conditions[ 'sort' ] = $sort;
		}

		if( !isset( $conditions[ 'search-col' ] ) ) {

			$conditions[ 'search-col' ] = 'name';
		}

		return self::getDataProvider( new Group(), $conditions );
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

		$groupToUpdate		= self::findById( $group->id );
		$contentToUpdate	= ModelContent::findById( $content->id );

		$groupToUpdate->copyForUpdateFrom( $group, [ 'avatarId', 'name', 'visibility', 'status' ] );

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

	public static function bindCategories( $binder, $type ) {

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