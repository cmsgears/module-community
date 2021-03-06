<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\models\resources;

// Yii Imports
use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\interfaces\base\IApproval;
use cmsgears\core\common\models\interfaces\base\IFeatured;
use cmsgears\core\common\models\interfaces\base\IVisibility;
use cmsgears\core\common\models\interfaces\mappers\IFile;
use cmsgears\core\common\models\interfaces\resources\IContent;
use cmsgears\core\common\models\interfaces\resources\IData;
use cmsgears\core\common\models\interfaces\resources\IGridCache;
use cmsgears\core\common\models\interfaces\resources\IMeta;
use cmsgears\core\common\models\interfaces\resources\ITemplate;
use cmsgears\core\common\models\interfaces\resources\IVisual;

use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\resources\Gallery;
use cmsgears\community\common\models\base\CmnTables;
use cmsgears\community\common\models\entities\Group;

use cmsgears\core\common\models\traits\base\ApprovalTrait;
use cmsgears\core\common\models\traits\base\FeaturedTrait;
use cmsgears\core\common\models\traits\base\VisibilityTrait;
use cmsgears\core\common\models\traits\mappers\FileTrait;
use cmsgears\core\common\models\traits\resources\ContentTrait;
use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\resources\GridCacheTrait;
use cmsgears\core\common\models\traits\resources\MetaTrait;
use cmsgears\core\common\models\traits\resources\TemplateTrait;
use cmsgears\core\common\models\traits\resources\VisualTrait;

/**
 * GroupPost represent a message posted on group time-line.
 *
 * @property integer $id
 * @property integer $groupId
 * @property integer $publisherId
 * @property integer $parentId
 * @property integer $templateId
 * @property integer $galleryId
 * @property integer $avatarId
 * @property integer $bannerId
 * @property integer $videoId
 * @property string $title
 * @property string $icon
 * @property string $texture
 * @property string $type
 * @property integer $status
 * @property integer $visibility
 * @property boolean $pinned
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
class GroupPost extends \cmsgears\core\common\models\base\Resource implements IApproval, IContent, IData,
	IFeatured, IFile, IGridCache, IMeta, ITemplate, IVisibility, IVisual {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $modelType = CmnGlobal::TYPE_GROUP_POST;

	protected $metaClass;

	// Private ----------------

	// Traits ------------------------------------------------------

	use ApprovalTrait;
	use ContentTrait;
	use DataTrait;
	use FeaturedTrait;
	use FileTrait;
	use GridCacheTrait;
	use MetaTrait;
	use TemplateTrait;
	use VisibilityTrait;
	use VisualTrait;

	// Constructor and Initialisation ------------------------------

	public function __construct( $config = [] ) {

		$this->metaClass = GroupPostMeta::class;

		parent::__construct();
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
            'timestampBehavior' => [
				'class' => TimestampBehavior::class,
				'createdAtAttribute' => 'createdAt',
 				'updatedAtAttribute' => 'modifiedAt',
 				'value' => new Expression('NOW()')
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
            [ [ 'groupId', 'visibility', 'type' ], 'required' ],
            [ [ 'id', 'content', 'data', 'gridCache' ], 'safe' ],
			// Text Limit
			[ 'type', 'string', 'min' => 0, 'max' => Yii::$app->core->mediumText ],
			[ [ 'icon', 'texture' ], 'string', 'min' => 0, 'max' => Yii::$app->core->largeText ],
			[ 'title', 'string', 'min' => 0, 'max' => Yii::$app->core->xxxLargeText ],
			// Other
            [ [ 'templateId', 'status' ], 'number', 'integerOnly' => true, 'min' => 0 ],
			[ 'gridCacheValid', 'boolean' ],
            [ [ 'groupId', 'publisherId', 'parentId', 'galleryId', 'avatarId', 'bannerId', 'videoId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt', 'modifiedAt', 'gridCachedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];

		// Trim Text
		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ 'content', 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'groupId' => Yii::$app->cmnMessage->getMessage( CmnGlobal::FIELD_GROUP ),
			'publisherId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PUBLISHER ),
			'parentId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'templateId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TEMPLATE ),
			'galleryId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_GALLERY ),
			'avatarId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_AVATAR ),
			'bannerId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_BANNER ),
			'videoId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VIDEO ),
			'icon' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ICON ),
			'texture' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TEXTURE ),
			'title' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TITLE ),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'status' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_STATUS ),
			'visibility' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VISIBILITY ),
			'content' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA ),
			'gridCache' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_GRID_CACHE )
		];
	}

	/**
	 * @inheritdoc
	 */
	public function beforeSave( $insert ) {

		if( parent::beforeSave( $insert ) ) {

			if( $this->templateId <= 0 ) {

				$this->templateId = null;
			}

			return true;
		}

		return false;
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// GroupPost -----------------------------

	/**
	 * Return the group to which the message belongs.
	 *
	 * @return \cmsgears\community\common\models\entities\Group
	 */
	public function getGroup() {

		return $this->hasOne( Group::class, [ 'id' => 'groupId' ] );
	}

	/**
	 * Return the user who published the post.
	 *
	 * @return \cmsgears\core\common\models\entities\User
	 */
	public function getPublisher() {

		return $this->hasOne( User::class, [ 'id' => 'publisherId' ] );
	}

	public function getParent() {

		return $this->hasOne( GroupPost::class, [ 'id' => 'parentId' ] );
	}

	public function getGallery() {

		return $this->hasOne( Gallery::class, [ 'id' => 'galleryId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::getTableName( CmnTables::TABLE_GROUP_POST );
	}

	// CMG parent classes --------------------

	// GroupPost -----------------------------

	// Read - Query -----------

    /**
     * @inheritdoc
     */
	public static function queryWithHasOne( $config = [] ) {

		$relations = isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'group', 'publisher', 'template' ];

		$config[ 'relations' ] = $relations;

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
