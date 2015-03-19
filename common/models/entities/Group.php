<?php
namespace cmsgears\modules\community\common\models\entities;

// CMG Imports
use cmsgears\modules\core\common\models\entities\NamedActiveRecord;
use cmsgears\modules\core\common\models\entities\Option;
use cmsgears\modules\core\common\models\entities\User;
use cmsgears\modules\core\common\models\entities\CmgFile;

use cmsgears\modules\community\common\models\entities\CommunityTables;

class Group extends NamedActiveRecord {

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

	// db columns

	public function getId() {

		return $this->group_id;
	}

	public function getOwnerId() {

		return $this->group_owner;	
	}

	public function getOwner() {

		return $this->hasOne( User::className(), [ 'group_id' => 'group_owner' ] );
	}

	public function setOwnerId( $owner ) {

		$this->group_owner = $owner;	
	}

	public function getAvatarId() {

		return $this->group_avatar;
	}

	public function getAvatar() {

		return $this->hasOne( CmgFile::className(), [ 'file_id' => 'group_avatar' ] );
	}

	public function setAvatarId( $avatarId ) {

		$this->group_avatar = $avatarId;
	}

	public function getBannerId() {

		return $this->group_banner;
	}

	public function getBanner() {

		return $this->hasOne( CmgFile::className(), [ 'file_id' => 'group_banner' ] );
	}

	public function setBannerId( $bannerId ) {

		$this->group_banner = $bannerId;
	}

	public function getName() {

		return $this->group_name;	
	}

	public function setName( $name ) {

		$this->group_name = $name;	
	}

	public function getDesc() {

		return $this->group_desc;	
	}

	public function setDesc( $desc ) {

		$this->group_desc = $desc;	
	}

	public function getSlug() {
		
		return $this->group_slug;	
	}

	public function setSlug( $slug ) {
		
		$this->group_slug = $slug;
	}

	public function getStatus() {

		return $this->group_status;
	}

	public function getStatusStr() {

		return self::$statusMap[ $this->group_status ];
	}

	public function setStatus( $status ) {

		$this->group_status = $status;
	}

	public function getVisibility() {
		
		return $this->group_visibility;
	}
	
	public function getVisibilityStr() {
		
		return self::$visibilityMap[ $this->group_visibility ];
	}

	public function setVisibility( $visibility ) {

		$this->group_visibility = $visibility;
	}

	public function getCreatedOn() {
		
		return $this->group_created_on;
	}
	
	public function setCreatedOn( $date ) {
		
		$this->group_created_on = $date;
	}

	public function getUpdatedOn() {
		
		return $this->group_updated_on;
	}
	
	public function setUpdatedOn( $updatedOn ) {
		
		$this->group_updated_on = $updatedOn;
	}

	public function getCategories() {

    	return $this->hasMany( Option::className(), [ 'option_id' => 'category_id' ] )
					->viaTable( CommunityTables::TABLE_GROUP_CATEGORY, [ 'group_id' => 'group_id' ] );
	}

	public function getCategoriesMap() {

    	return $this->hasMany( GroupCategory::className(), [ 'group_id' => 'group_id' ] );
	}

	public function getCategoriesIdList() {

    	$categories 		= $this->categoriesMap;
		$categoriesList		= array();

		foreach ( $categories as $category ) {

			array_push( $categoriesList, $category->category_id );
		}

		return $categoriesList;
	}

	public function getCategoriesIdNameMap() {

		$categories 	= $this->categories;
		$categoriesMap	= array();

		foreach ( $categories as $category ) {

			$categoriesMap[]	= [ 'id' => $category->getId(), 'name' => $category->getKey() ];
		}

		return $categoriesMap;
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'group_name' ], 'required' ],
            [ [ 'group_name' ], 'alphanumspace' ],
            [ 'group_name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'group_name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'group_desc', 'group_status', 'group_visibility' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'group_name' => 'Name',
			'group_desc' => 'Description'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord

	public static function tableName() {

		return CommunityTables::TABLE_GROUP;
	}

	// Group

	public static function findById( $id ) {

		return Group::find()->where( 'group_id=:id', [ ':id' => $id ] )->one();
	}

	public static function findByName( $name ) {

		return Group::find()->where( 'group_name=:name', [ ':name' => $name ] )->one();
	}
}

?>