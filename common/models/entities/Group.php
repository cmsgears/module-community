<?php
namespace cmsgears\community\common\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\NamedCmgEntity;
use cmsgears\core\common\models\entities\Category;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\CmgFile;

class Group extends NamedCmgEntity {

	const STATUS_NEW		=  0;
	const STATUS_ACTIVE		= 10;
	const STATUS_DISABLED	= 20;

	public static $statusMap = [
		self::STATUS_NEW => "New",
		self::STATUS_ACTIVE => "Active",
		self::STATUS_DISABLED => "Disabled"
	];

	const VISIBILITY_PRIVATE	= 0;
	const VISIBILITY_PUBLIC		= 1;

	public static $visibilityMap = [
		self::VISIBILITY_PRIVATE => "Private",
		self::VISIBILITY_PUBLIC => "Public"
	];

	// Instance Methods --------------------------------------------

	public function getOwner() {

		return $this->hasOne( User::className(), [ 'id' => 'ownerId' ] );
	}

	public function getAvatar() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'avatarId' ] );
	}

	public function getBanner() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'bannerId' ] );
	}

	/**
	 * @return array - list of group meta
	 */
	public function getMetas() {

    	return $this->hasMany( GroupMeta::className(), [ 'groupId' => 'id' ] );
	}

	public function getStatusStr() {

		return self::$statusMap[ $this->status ];
	}
	
	public function getVisibilityStr() {
		
		return self::$visibilityMap[ $this->visibility ];
	}

	public function getCategories() {

    	return $this->hasMany( Category::className(), [ 'id' => 'categoryId' ] )
					->viaTable( CmnTables::TABLE_CATEGORY, [ 'groupId' => 'id' ] );
	}

	public function getCategoriesMap() {

    	return $this->hasMany( GroupCategory::className(), [ 'groupId' => 'id' ] );
	}

	public function getCategoriesIdList() {

    	$categories 		= $this->categoriesMap;
		$categoriesList		= array();

		foreach ( $categories as $category ) {

			array_push( $categoriesList, $category->categoryId );
		}

		return $categoriesList;
	}

	public function getCategoriesIdNameMap() {

		$categories 	= $this->categories;
		$categoriesMap	= array();

		foreach ( $categories as $category ) {

			$categoriesMap[] = [ 'id' => $category->id, 'name' => $category->name ];
		}

		return $categoriesMap;
	}

	// yii\base\Model --------------------

	public function rules() {

        return [
            [ [ 'name' ], 'required' ],
			[ [ 'description', 'content', 'status', 'type', 'visibility' ], 'safe' ],
            [ [ 'name' ], 'alphanumhyphenspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ]
        ];
    }

	public function attributeLabels() {

		return [
			'name' => 'Name',
			'description' => 'Description',
			'content' => 'Content',
			'status' => 'Status',
			'type' => 'Type',
			'visibility' => 'Visibility'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CommunityTables::TABLE_GROUP;
	}

	// Group -----------------------------

	public static function findBySlug( $slug ) {

		return self::find()->where( 'slug=:slug', [ ':slug' => $slug ] )->one();
	}
}

?>