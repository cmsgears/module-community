<?php
namespace cmsgears\community\common\models\entities;

// Yii Imports
use \Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\entities\CoreTables;
use cmsgears\core\common\models\entities\NamedCmgEntity;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\traits\MetaTrait;
use cmsgears\core\common\models\traits\CategoryTrait;

/**
 * Content Entity
 *
 * @property int $id
 * @property int $ownerId
 * @property int $avatarId
 * @property int $bannerId
 * @property string $name
 * @property string $description
 * @property string $content
 * @property string $slug
 * @property short $type
 * @property short $status
 * @property short $visibility 
 * @property date $createdAt
 * @property date $modifiedAt
 */
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

	use MetaTrait;

	public $metaType		= CmnGlobal::META_TYPE_GROUP;

	use CategoryTrait;

	public $categoryType	= CmnGlobal::CATEGORY_TYPE_GROUP;

	// Instance Methods --------------------------------------------

	public function getOwner() {

		return $this->hasOne( User::className(), [ 'id' => 'ownerId' ] )->from( CoreTables::TABLE_USER . ' owner' );
	}

	public function getAvatar() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'avatarId' ] )->from( CoreTables::TABLE_USER . ' gavatar' );
	}

	public function getBanner() {

		return $this->hasOne( CmgFile::className(), [ 'id' => 'bannerId' ] )->from( CoreTables::TABLE_USER . ' gbanner' );
	}

	public function getStatusStr() {

		return self::$statusMap[ $this->status ];
	}
	
	public function getVisibilityStr() {
		
		return self::$visibilityMap[ $this->visibility ];
	}

	/**
	 * @return boolean - whether given user is owner
	 */
	public function checkOwner( $user ) {
		
		return $this->userId	= $user->id;		
	}

	// yii\base\Component ----------------

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [

            'sluggableBehavior' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true
            ],
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
				'createdAtAttribute' => 'createdAt',
 				'updatedAtAttribute' => 'modifiedAt'
            ]
        ];
    }

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
            [ [ 'name' ], 'required' ],
			[ [ 'ownerId', 'avatarId', 'bannerId', 'description', 'content' ], 'safe' ],
			[ [ 'status', 'type', 'visibility' ], 'number', 'integerOnly' => true ],
            [ [ 'name' ], 'alphanumhyphenspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'ownerId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_OWNER ),
			'avatarId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_AVATAR ),
			'bannerId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_BANNER ),
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'description' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_DESCRIPTION ),
			'content' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'status' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_STATUS ),
			'type' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'visibility' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_VISIBILITY )
		];
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

	public static function findBySlug( $slug ) {

		return self::find()->where( 'slug=:slug', [ ':slug' => $slug ] )->one();
	}
}

?>