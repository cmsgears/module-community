<?php
namespace cmsgears\community\common\models\mappers;

// Yii Imports
use \Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\community\common\models\base\CmnTables;

use cmsgears\core\common\models\traits\MapperTrait;

/**
 * Follow Entity
 *
 * @property int $id
 * @property int $modelId
 * @property int $parentId
 * @property int $parentType
 * @property int $type
 * @property int $active
 * @property int $createdAt
 * @property int $modifiedAt
 */
class Follower extends \cmsgears\core\common\models\base\Mapper {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Pre-Defined Type
	const TYPE_LIKE		=  0; // User Likes
	const TYPE_FOLLOW	= 10; // User Followers
	const TYPE_WISHLIST	= 20; // User who wish to have this model - specially if model is doing sales

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use MapperTrait;

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
            'timestampBehavior' => [
                'class' => TimestampBehavior::className(),
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

		// model rules
        $rules = [
            [ [ 'modelId', 'parentId', 'parentType' ], 'required' ],
            [ [ 'id', 'type', 'active' ], 'safe' ],
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];

		// trim if required
		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'parentType', 'type' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

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
			'parentType' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PARENT_TYPE ),
			'modelId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_USER ),
			'type'	=> Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'active' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ACTIVE ),
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Follower ------------------------------

	public function getUser() {

		return $this->hasOne( User::className(), [ 'id' => 'modelId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::TABLE_FOLLOWER;
	}

	// CMG parent classes --------------------

	// Follower ------------------------------

	// Read - Query -----------

	public static function queryByParentType( $parentType, $type ) {

        return self::find()->where( 'parentType =:pType AND type=:type', [ ':pType' => $parentType, ':type' => $type ] );
	}

	public static function queryByParentModelId( $parentId, $parentType, $modelId, $type ) {

		return self::find()->where( 'parentId =:pid AND parentType =:pType AND modelId=:uid AND type=:type ', [ ':pid' => $parentId, ':pType' => $parentType, ':uid' => $modelId, ':type' => $type ] );
	}

	public static function queryByParentTypeModelId( $parentType, $modelId, $type ) {

		return self::find()->where( 'parentType =:pType AND modelId=:uid AND type=:type ', [ ':pType' => $parentType, ':uid' => $modelId, ':type' => $type ] );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------
}
