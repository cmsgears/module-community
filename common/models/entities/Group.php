<?php
namespace cmsgears\community\common\models\entities;

// Yii Imports
use \Yii;
use yii\behaviors\SluggableBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\resources\CmgFile;
use cmsgears\community\common\models\base\CmnTables;

use cmsgears\core\common\models\traits\MetaTrait;
use cmsgears\core\common\models\traits\CategoryTrait;
use cmsgears\core\common\models\traits\TagTrait;
use cmsgears\core\common\models\traits\CreateModifyTrait;
use cmsgears\cms\common\models\traits\ContentTrait;

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
 * @property short $status
 * @property short $visibility
 */
class Group extends \cmsgears\core\common\models\entities\CmgEntity {

	const STATUS_NEW		=  0;
	const STATUS_ACTIVE		= 10;
	const STATUS_DISABLED	= 20;

	public static $statusMap = [
		self::STATUS_NEW => 'New',
		self::STATUS_ACTIVE => 'Active',
		self::STATUS_DISABLED => 'Disabled'
	];

	const VISIBILITY_PRIVATE	=  0; // Only accessed by members, protected by password
	const VISIBILITY_PUBLIC		=  5; // Visible to logged in users
	const VISIBILITY_GLOBAL		= 10; // Publicly visible, logged in users can do activities

	public static $visibilityMap = [
		self::VISIBILITY_PRIVATE => 'Private',
		self::VISIBILITY_PUBLIC => 'Public',
		self::VISIBILITY_GLOBAL => 'Global'
	];

	use MetaTrait;

	public $metaType		= CmnGlobal::TYPE_GROUP;

	use CategoryTrait;

	public $categoryType	= CmnGlobal::TYPE_GROUP;

	use TagTrait;

	public $tagType			= CmnGlobal::TYPE_GROUP;

	use ContentTrait;

	public $contentType		= CmnGlobal::TYPE_GROUP;

	use CreateModifyTrait;

	// Instance Methods --------------------------------------------

	public function getAvatar() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'avatarId' ] );
	}

	public function getMembers() {

		return $this->hasMany( GroupMember::className(), [ 'groupId' => 'id' ] );
	}

	public function getStatusStr() {

		return self::$statusMap[ $this->status ];
	}

	public function isNew() {

		return $this->status == self::STATUS_NEW;
	}

	public function isPublished() {

		return $this->status == self::STATUS_PUBLISHED;
	}

	public function getVisibilityStr() {

		return self::$visibilityMap[ $this->visibility ];
	}

	public function isPrivate() {

		return $this->visibility == self::VISIBILITY_PRIVATE;
	}

	public function isPublic() {

		return $this->visibility == self::VISIBILITY_PUBLIC;
	}

	public function isGlobal() {

		return $this->visibility == self::VISIBILITY_GLOBAL;
	}

	/**
	 * @return boolean - whether given user is group owner
	 */
	public function checkOwner( $user ) {

		return $this->createdBy	= $user->id;
	}

	// yii\base\Component ----------------

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
                'ensureUnique' => true
            ]
        ];
    }

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
            [ [ 'name', 'type' ], 'required' ],
			[ [ 'id', 'slug', 'avatarId' ], 'safe' ],
			[ [ 'status', 'visibility' ], 'number', 'integerOnly' => true ],
            [ [ 'name' ], 'alphanumhyphenspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'createdBy', 'modifiedBy' ], 'number', 'integerOnly' => true, 'min' => 1 ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'avatarId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_AVATAR ),
			'createdBy' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_OWNER ),
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'status' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_STATUS ),
			'visibility' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_VISIBILITY )
		];
	}

	// Province --------------------------

	/**
	 * Validates whether a group exists with the same name for same type.
	 */
    public function validateNameCreate( $attribute, $params ) {

        if( !$this->hasErrors() ) {

            if( self::isExistByNameType( $this->name, $this->type ) ) {

                $this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_EXIST ) );
            }
        }
    }

	/**
	 * Validates whether a province existing with the same name for same country.
	 */
    public function validateNameUpdate( $attribute, $params ) {

        if( !$this->hasErrors() ) {

			$existingGroup = self::findByNameType( $this->name, $this->type );

			if( isset( $existingGroup ) && $this->name == $existingGroup->name &&
				$this->id != $existingGroup->id && strcmp( $existingGroup->name, $this->name ) == 0 ) {

				$this->addError( $attribute, Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_EXIST ) );
			}
        }
    }

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::TABLE_GROUP;
	}

	// Group -----------------------------

	// Read ----

	/**
	 * @return ActiveRecord - with page content.
	 */
	public static function findWithContent() {

		return self::find()->joinWith( 'content' );
	}

	public static function findBySlug( $slug ) {

		return self::find()->where( 'slug=:slug', [ ':slug' => $slug ] )->one();
	}

	/**
	 * @return Group - by name and type
	 */
	public static function findByNameType( $name, $type ) {

		return self::find()->where( 'name=:name AND type=:type', [ ':name' => $name, ':type' => $type ] )->one();
	}

	/**
	 * @return Group - check whether a group exist by the provided name and type
	 */
	public static function isExistByNameType( $name, $type ) {

		$group = self::findByNameType( $name, $type );

		return isset( $group );
	}
}

?>