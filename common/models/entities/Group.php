<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\models\entities;

// Yii Imports
use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\interfaces\base\IApproval;
use cmsgears\core\common\models\interfaces\base\IAuthor;
use cmsgears\core\common\models\interfaces\base\IMultiSite;
use cmsgears\core\common\models\interfaces\base\INameType;
use cmsgears\core\common\models\interfaces\base\IOwner;
use cmsgears\core\common\models\interfaces\base\ISlugType;
use cmsgears\core\common\models\interfaces\base\IVisibility;
use cmsgears\core\common\models\interfaces\resources\IContent;
use cmsgears\core\common\models\interfaces\resources\IData;
use cmsgears\core\common\models\interfaces\resources\IVisual;
use cmsgears\core\common\models\interfaces\mappers\ICategory;
use cmsgears\core\common\models\interfaces\mappers\IFollower;
use cmsgears\core\common\models\interfaces\mappers\ITag;
use cmsgears\cms\common\models\interfaces\resources\IPageContent;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\core\common\models\base\Entity;
use cmsgears\core\common\models\entities\User;
use cmsgears\community\common\models\base\CmnTables;
use cmsgears\community\common\models\resources\GroupMeta;
use cmsgears\community\common\models\mappers\GroupFollower;

use cmsgears\core\common\models\traits\base\ApprovalTrait;
use cmsgears\core\common\models\traits\base\AuthorTrait;
use cmsgears\core\common\models\traits\base\MultiSiteTrait;
use cmsgears\core\common\models\traits\base\NameTypeTrait;
use cmsgears\core\common\models\traits\base\SlugTypeTrait;
use cmsgears\core\common\models\traits\base\VisibilityTrait;
use cmsgears\core\common\models\traits\resources\ContentTrait;
use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\resources\VisualTrait;
use cmsgears\core\common\models\traits\mappers\CategoryTrait;
use cmsgears\core\common\models\traits\mappers\FollowerTrait;
use cmsgears\core\common\models\traits\mappers\TagTrait;
use cmsgears\cms\common\models\traits\resources\PageContentTrait;

use cmsgears\core\common\behaviors\AuthorBehavior;

/**
 * Group can be formed by several users. The group members can do activities based on their
 * group role.
 *
 * @property integer $id
 * @property integer $siteId
 * @property integer $avatarId
 * @property integer $galleryId
 * @property integer $ownerId
 * @property integer $createdBy
 * @property integer $modifiedBy
 * @property string $name
 * @property string $slug
 * @property string $type
 * @property string $icon
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property integer $visibility
 * @property integer $order
 * @property boolean $featured
 * @property date $createdAt
 * @property date $modifiedAt
 * @property string $content
 * @property string $data
 * @property string $gridCache
 * @property boolean $gridCacheValid
 * @property datetime $gridCachedAt
 *
 * @since 1.0.0
 */
class Group extends Entity implements IApproval, IAuthor, ICategory, IContent, IData, IFollower, IMultiSite,
	INameType, IOwner, IPageContent, ISlugType, ITag, IVisibility, IVisual {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $modelType = CmnGlobal::TYPE_GROUP;

	protected $followerTable;

	// Private ----------------

	// Traits ------------------------------------------------------

	use ApprovalTrait;
	use AuthorTrait;
	use CategoryTrait;
	use ContentTrait;
	use DataTrait;
	use FollowerTrait;
	use MultiSiteTrait;
	use NameTypeTrait;
	use PageContentTrait;
	use SlugTypeTrait;
	use TagTrait;
	use VisibilityTrait;
	use VisualTrait;

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->followerTable = CmnTables::getTableName( CmnTables::TABLE_GROUP_FOLLOWER );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	/**
	 * @inheritdoc
	 */
	public function behaviors() {

		return [
			'authorBehavior' => [
				'class' => AuthorBehavior::class
			],
			'timestampBehavior' => [
				'class' => TimestampBehavior::class,
				'createdAtAttribute' => 'createdAt',
				'updatedAtAttribute' => 'modifiedAt',
				'value' => new Expression('NOW()')
			],
			'sluggableBehavior' => [
				'class' => SluggableBehavior::class,
				'attribute' => 'name',
				'slugAttribute' => 'slug', // Unique for Site Id
				'ensureUnique' => true,
				'uniqueValidator' => [ 'targetAttribute' => 'siteId' ]
			]
		];
	}

	// yii\base\Model ---------

    /**
     * @inheritdoc
     */
	public function rules() {

		// Model Rules
		$rules = [
			// Required, Safe
			[ [ 'siteId', 'name' ], 'required' ],
			[ [ 'id', 'content', 'data', 'gridCache' ], 'safe' ],
			// Text Limit
			[ 'type', 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
			[ 'icon', 'string', 'min' => 1, 'max' => Yii::$app->core->largeText ],
			[ 'name', 'string', 'min' => 1, 'max' => Yii::$app->core->xLargeText ],
			[ 'slug', 'string', 'min' => 0, 'max' => Yii::$app->core->xxLargeText ],
			[ 'title', 'string', 'min' => 0, 'max' => Yii::$app->core->xxxLargeText ],
			[ 'description', 'string', 'min' => 0, 'max' => Yii::$app->core->xtraLargeText ],
			// Other
			[ [ 'status', 'visibility', 'order' ], 'number', 'integerOnly' => true, 'min' => 0 ],
			[ [ 'featured', 'gridCacheValid' ], 'boolean' ],
			[ [ 'siteId', 'avatarId', 'ownerId', 'createdBy', 'modifiedBy' ], 'number', 'integerOnly' => true, 'min' => 1 ],
			[ [ 'createdAt', 'modifiedAt', 'gridCachedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
		];

		// Trim Text
		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'name', 'title', 'description' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'siteId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SITE ),
			'avatarId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_AVATAR ),
			'ownerId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_OWNER ),
			'createdBy' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_AUTHOR ),
			'name' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'slug' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SLUG ),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'icon' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ICON ),
			'title' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TITLE ),
			'description' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DESCRIPTION ),
			'status' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_STATUS ),
			'visibility' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VISIBILITY ),
			'order' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ORDER ),
			'featured' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_FEATURED ),
			'content' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA ),
			'gridCache' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_GRID_CACHE )
		];
	}

	// CMG interfaces ------------------------

	// IOwner

	/**
	 * Check whether user is owner of the group.
	 *
	 * @param \cmsgears\core\common\models\entities\User $user
	 * @param boolean $strict
	 * @return boolean
	 */
	public function isOwner( $user = null, $strict = false ) {

		if( !isset( $user ) && !$strict ) {

			$user	= Yii::$app->user->getIdentity();
		}

		if( isset( $user ) ) {

			if( isset( $this->ownerId ) ) {

				return $this->ownerId == $user->id;
			}
			else {

				return $this->createdBy == $user->id;
			}
		}

		return false;
	}

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Group ---------------------------------

	/**
	 * Return the group owner.
	 *
	 * @return \cmsgears\core\common\models\entities\User
	 */
	public function getOwner() {

		$userTable = CoreTables::getTableName( CoreTables::TABLE_USER );

		return $this->hasOne( User::class, [ 'id' => 'ownerId' ] )->from( "$userTable as owner" );
	}

	/**
	 * Return all the group members.
	 *
	 * @return \cmsgears\community\common\models\entities\GroupMember[]
	 */
	public function getMembers() {

		return $this->hasMany( GroupMember::class, [ 'groupId' => 'id' ] );
	}

	/**
	 * Return all the group member users.
	 *
	 * @return \cmsgears\core\common\models\entities\User[]
	 */
	public function getMemberUsers() {

		return $this->hasMany( User::class, [ 'id' => 'userId' ] )
			->viaTable( CmnTables::getTableName( CmnTables::TABLE_GROUP_MEMBER ), [ 'groupId' => 'id' ] );
	}

	/**
	 * Returns group followers.
	 *
	 * @return \cmsgears\community\common\models\mappers\GroupFollower[]
	 */
	public function getGroupFollowers() {

		return $this->hasMany( GroupFollower::class, [ 'modelId' => 'id' ] );
	}

	/**
	 * Returns the meta and attributes associated with the group.
	 *
	 * @return \cmsgears\community\common\models\resources\GroupMeta[]
	 */
	public function getMetas() {

		return $this->hasMany( GroupMeta::class, [ 'modelId' => 'id' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::getTableName( CmnTables::TABLE_GROUP );
	}

	// CMG parent classes --------------------

	// Group ---------------------------------

	// Read - Query -----------

    /**
     * @inheritdoc
     */
	public static function queryWithHasOne( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'avatar', 'modelContent', 'modelContent.template', 'site', 'owner', 'creator', 'modifier' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with avatar and content.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with avatar and content.
	 */
	public static function queryWithContent( $config = [] ) {

		$config[ 'relations' ] = [ 'avatar', 'modelContent' ];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with avatar, content, template, banner, video and gallery.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with avatar, content, template, banner, video and gallery.
	 */
	public static function queryWithFullContent( $config = [] ) {

		$config[ 'relations' ] = [ 'avatar', 'modelContent', 'modelContent.template', 'modelContent.banner', 'modelContent.video', 'modelContent.gallery' ];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with avatar, content, template, banner, owner and owner avatar.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with avatar, content, template, banner, owner and owner avatar.
	 */
	public static function queryWithOwner( $config = [] ) {

		$config[ 'relations' ][] = [ 'avatar', 'modelContent', 'modelContent.template', 'modelContent.banner', 'owner' ];

		$config[ 'relations' ][] = [ 'owner.avatar'  => function ( $query ) {
			$fileTable	= CoreTables::getTableName( CoreTables::TABLE_FILE );
			$query->from( "$fileTable oavatar" ); }
		];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with avatar, content, template, banner, author and author avatar.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with avatar, content, template, banner, author and author avatar.
	 */
	public static function queryWithAuthor( $config = [] ) {

		$config[ 'relations' ][] = [ 'avatar', 'modelContent', 'modelContent.template', 'modelContent.banner', 'creator' ];

		$config[ 'relations' ][] = [ 'creator.avatar'  => function ( $query ) {
			$fileTable	= CoreTables::getTableName( CoreTables::TABLE_FILE );
			$query->from( "$fileTable aavatar" ); }
		];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with avatar, content, template, banner, owner, owner avatar, author and author avatar.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with avatar, content, template, banner, owner, owner avatar, author and author avatar.
	 */
	public static function queryWithOwnerAuthor( $config = [] ) {

		$fileTable	= CoreTables::getTableName( CoreTables::TABLE_FILE );

		$config[ 'relations' ][] = [ 'avatar', 'modelContent', 'modelContent.template', 'modelContent.banner', 'owner', 'creator' ];

		$config[ 'relations' ][] = [ 'owner.avatar'  => function ( $query ) use( &$fileTable ) {
			$query->from( "$fileTable oavatar" ); }
		];

		$config[ 'relations' ][] = [ 'creator.avatar'  => function ( $query ) use( &$fileTable ) {
			$query->from( "$fileTable aavatar" ); }
		];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with avatar and followers.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with avatar and followers.
	 */
	public static function queryWithFollowers( $config = [] ) {

		$config[ 'relations' ][] = [ 'followers' ];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with avatar and meta.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with avatar and meta.
	 */
	public static function queryWithMetas( $config = [] ) {

		$config[ 'relations' ][] = [ 'metas' ];

		return parent::queryWithAll( $config );
	}

	public static function queryWithMembers( $config = [] ) {

		$config[ 'relations' ]	= [ 'avatar', 'members' ];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the group by owner id.
	 *
	 * @param integer $id
	 * @return \yii\db\ActiveQuery to query by owner id.
	 */
	public static function queryByOwnerId( $id ) {

		return self::find()->where( 'ownerId =:owner', [ ':owner' => $id ] );
	}

	/**
	 * Return query to find the group by appropriate owner.
	 *
	 * @param integer $id
	 * @return \yii\db\ActiveQuery to query by owner id.
	 */
	public static function queryByAuthorityId( $id ) {

		return self::find()->where( 'ownerId =:owner OR (ownerId IS NULL AND createdBy =:creator )', [ ':owner' => $id, ':creator' => $id ] );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
