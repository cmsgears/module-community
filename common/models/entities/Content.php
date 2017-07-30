<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\interfaces\IApproval;
use cmsgears\core\common\models\interfaces\IVisibility;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\core\common\models\entities\Site;
use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\core\common\models\resources\Gallery;

use cmsgears\core\common\models\traits\CreateModifyTrait;
use cmsgears\core\common\models\traits\NameTypeTrait;
use cmsgears\core\common\models\traits\SlugTypeTrait;
use cmsgears\core\common\models\traits\interfaces\ApprovalTrait;
use cmsgears\core\common\models\traits\interfaces\VisibilityTrait;
use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\interfaces\OwnerTrait;

use cmsgears\core\common\behaviors\AuthorBehavior;

/**
 * Content Entity
 *
 * @property int $id
 * @property int $siteId
 * @property int $parentId
 * @property int $createdBy
 * @property int $modifiedBy
 * @property string $name
 * @property string $title
 * @property string $slug
 * @property short $type
 * @property string $icon
 * @property string $description
 * @property short $status
 * @property short $visibility
 * @property short $order
 * @property boolean $showGallery
 * @property short $featured
 * @property short $comments
 * @property date $createdAt
 * @property date $modifiedAt
 * @property string $content
 * @property string $data
 * @property string $widgetData
 */
class Content extends \cmsgears\core\common\models\base\Entity implements IApproval, IVisibility {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $multiSite	= true;

	public static $postClass	= 'cmsgears\cms\common\models\entities\Post';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use ApprovalTrait;
	use CreateModifyTrait;
	use DataTrait;
	use NameTypeTrait;
	use SlugTypeTrait;
	use VisibilityTrait;
	use OwnerTrait;

	// Constructor and Initialisation ------------------------------

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
				'class' => AuthorBehavior::className()
			],
			'timestampBehavior' => [
				'class' => TimestampBehavior::className(),
				'createdAtAttribute' => 'createdAt',
				'updatedAtAttribute' => 'modifiedAt',
				'value' => new Expression('NOW()')
			],
			'sluggableBehavior' => [
				'class' => SluggableBehavior::className(),
				'attribute' => 'name',
				'slugAttribute' => 'slug',
				'immutable' => true,
				'ensureUnique' => true
			]
		];
	}

	// yii\base\Model ---------

	/**
	 * @inheritdoc
	 */
	public function rules() {

		// model rules
		$rules = [
			// Required, Safe
			[ [ 'name', 'siteId' ], 'required' ],
			[ [ 'id', 'content', 'data', 'widgetData' ], 'safe' ],
			// Text Limit
			[ 'type', 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
			[ 'icon', 'string', 'min' => 1, 'max' => Yii::$app->core->largeText ],
			[ [ 'name', 'title' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xLargeText ],
			[ [ 'slug', 'description' ], 'string', 'min' => 1, 'max' => Yii::$app->core->xxLargeText ],
			// Other
			[ [ 'status', 'visibility', 'order' ], 'number', 'integerOnly' => true, 'min' => 0 ],
			[ [ 'featured', 'comments', 'showGallery' ], 'boolean' ],
			[ [ 'parentId' ], 'number', 'integerOnly' => true, 'min' => 0, 'tooSmall' => Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_SELECT ) ],
			[ [ 'createdBy', 'modifiedBy', 'siteId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
			[ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
		];

		// trim if required
		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'name', 'type' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {

		return [
			'parentId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'createdBy' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_AUTHOR ),
			'name' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'title' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TITLE ),
			'slug' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SLUG ),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'icon' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ICON ),
			'visibility' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VISIBILITY ),
			'status' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_STATUS ),
			'slug' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SLUG ),
			'order' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ORDER ),
			'featured' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_FEATURED )
		];
	}

	// yii\db\BaseActiveRecord

	public function beforeSave( $insert ) {

		if( parent::beforeSave( $insert ) ) {

			if( $this->parentId <= 0 ) {

				$this->parentId = null;
			}

			if( !isset( $this->order ) || strlen( $this->order ) <= 0 ) {

				$this->order = 0;
			}

			return true;
		}

		return false;
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Content -------------------------------

	public function getParent() {

		switch( $row['type'] ) {

			case self::TYPE_PAGE: {

				return $this->hasOne( Page::className(), [ 'id' => 'parentId' ] );
			}
			case self::TYPE_POST: {

				return $this->hasOne( Post::className(), [ 'id' => 'parentId' ] );
			}
		}
	}

	public function getSite() {

		return $this->hasOne( Site::className(), [ 'id' => 'siteId' ] );
	}

	public function getMetas() {

		return $this->hasMany( ContentMeta::className(), [ 'pageId' => 'id' ] );
	}

	public function getGallery() {

		return $this->hasOne( Gallery::className(), [ 'id' => 'galleryId' ] );
	}

	public function isPage() {

		return $this->type == CmsGlobal::TYPE_PAGE;
	}

	public function isPost() {

		return $this->type == CmsGlobal::TYPE_POST;
	}

	public function isPublished() {

		$user	= Yii::$app->user->getIdentity();

		if( isset( $user ) && $this->createdBy == $user->id ) {

			return true;
		}

		return $this->isPublic() && $this->isVisibilityPublic();
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	/**
	 * @inheritdoc
	 */
	public static function tableName() {

		return CmsTables::TABLE_PAGE;
	}

	// yii\db\BaseActiveRecord

	public static function instantiate( $row ) {

		switch( $row['type'] ) {

			case CmsGlobal::TYPE_PAGE: {

				$class = 'cmsgears\cms\common\models\entities\Page';

				break;
			}
			case CmsGlobal::TYPE_POST: {

				$class = static::$postClass;

				break;
			}
		}

		$model = new $class( null );

		return $model;
	}

	// CMG parent classes --------------------

	// Content -------------------------------

	// Read - Query -----------

	public static function queryWithHasOne( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'modelContent', 'site', 'creator', 'modifier' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	public static function queryWithContent( $config = [] ) {

		$config[ 'relations' ]	= [ 'modelContent' ];

		return parent::queryWithAll( $config );
	}

	public static function queryWithAuthor( $config = [] ) {

		$postTable					= CmsTables::TABLE_PAGE;
		$config[ 'relations' ][]	= [ 'modelContent', 'creator' ];
		$config[ 'relations' ][]	= [ 'creator.avatar'  => function ( $query ) {
											$fileTable	= CoreTables::TABLE_FILE;
											$query->from( "$fileTable avatar" ); }
										];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
