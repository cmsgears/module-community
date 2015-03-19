<?php
namespace cmsgears\modules\community\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

class GroupCategory extends ActiveRecord {

	// Instance Methods --------------------------------------------

	// db columns

	public function getGroupId() {

		return $this->group_id;
	}

	public function setGroupId( $postId ) {

		$this->group_id = $postId;
	}

	public function getCategoryId() {

		return $this->category_id;
	}

	public function setCategoryId( $categoryId ) {

		$this->category_id = $categoryId;
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord

	public static function tableName() {

		return CommunityTables::TABLE_GROUP_CATEGORY;
	}

	// Delete
	
	public static function deleteByGroupId( $id ) {

		self::deleteAll( 'group_id=:id', [ ':id' => $id ] );
	}

	public static function deleteByCategoryId( $id ) {

		self::deleteAll( 'category_id=:id', [ ':id' => $id ] );
	}
}

?>