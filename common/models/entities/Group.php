<?php
namespace cmsgears\community\common\models\entities;

// Yii Imports
use \Yii;
use yii\behaviors\SluggableBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\interfaces\IApproval;
use cmsgears\core\common\models\interfaces\IOwner;
use cmsgears\core\common\models\interfaces\IVisibility;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\resources\File;
use cmsgears\community\common\models\base\CmnTables;

use cmsgears\core\common\models\traits\CreateModifyTrait;
use cmsgears\core\common\models\traits\NameTypeTrait;
use cmsgears\core\common\models\traits\SlugTypeTrait;
use cmsgears\core\common\models\traits\interfaces\ApprovalTrait;
use cmsgears\core\common\models\traits\interfaces\VisibilityTrait;
use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\mappers\CategoryTrait;
use cmsgears\core\common\models\traits\mappers\TagTrait;
use cmsgears\cms\common\models\traits\resources\ContentTrait;

use cmsgears\core\common\behaviors\AuthorBehavior;

/**
 * Group Entity
 *
 * @property int $id
 * @property int $avatarId
 * @property int $createdBy
 * @property int $modifiedBy
 * @property string $name
 * @property string $slug
 * @property string $type
 * @property string $icon
 * @property string $description
 * @property short $status
 * @property short $visibility
 * @property date $createdAt
 * @property date $modifiedAt
 * @property string $content
 * @property string $data
 */
class Group extends \cmsgears\core\common\models\base\Entity implements IApproval, IOwner, IVisibility {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use ApprovalTrait;
	use CategoryTrait;
	use ContentTrait;
	use CreateModifyTrait;
	use DataTrait;
	use NameTypeTrait;
	use SlugTypeTrait;
	use TagTrait;
	use VisibilityTrait;

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
            'sluggableBehavior' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
                'uniqueValidator' => [ 'targetAttribute' => 'type' ]
            ]
        ];
    }

	// yii\base\Model ---------

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
            [ [ 'name', 'type' ], 'required' ],
            [ [ 'id', 'content', 'data' ], 'safe' ],
            [ [ 'name', 'type', 'icon' ], 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
            [ 'slug', 'string', 'min' => 1, 'max' => Yii::$app->core->largeText ],
            [ 'description', 'string', 'min' => 0, 'max' => Yii::$app->core->extraLargeText ],
            [ [ 'name', 'type' ], 'unique', 'targetAttribute' => [ 'name', 'type' ] ],
            [ [ 'slug', 'type' ], 'unique', 'targetAttribute' => [ 'slug', 'type' ] ],
			[ [ 'status', 'visibility' ], 'number', 'integerOnly' => true ],
            [ [ 'createdBy', 'modifiedBy' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'avatarId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_AVATAR ),
			'createdBy' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_OWNER ),
			'name' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'status' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_STATUS ),
			'visibility' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VISIBILITY )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Group ---------------------------------

	public function getMembers() {

		return $this->hasMany( GroupMember::className(), [ 'groupId' => 'id' ] );
	}

	/**
	 * @return boolean - whether given user is group owner
	 */
	public function isOwner( $user = null, $strict = false ) {

		return $this->createdBy	= $user->id;
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::TABLE_GROUP;
	}

	// CMG parent classes --------------------

	// Group ---------------------------------

	// Read - Query -----------

	public static function queryWithAll( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'modelContent', 'members' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	public static function queryWithContent( $config = [] ) {

		$config[ 'relations' ]	= [ 'modelContent' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------
}
