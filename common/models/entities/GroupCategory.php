<?php
namespace cmsgears\community\common\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\CmgEntity;

class GroupCategory extends CmgEntity {

	// Instance Methods --------------------------------------------

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CmnTables::TABLE_GROUP_CATEGORY;
	}

	// GroupCategory ---------------------

	// Delete

	public static function deleteByGroupId( $groupId ) {

		self::deleteAll( 'groupId=:id', [ ':id' => $groupId ] );
	}

	public static function deleteByCategoryId( $categoryId ) {

		self::deleteAll( 'categoryId=:id', [ ':id' => $categoryId ] );
	}
}

?>