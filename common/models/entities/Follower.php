<?php
namespace cmsgears\community\common\models\entities;

// Yii Imports
use \Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\User; 

/**
 * Follow Entity
 *
 * @property int $id
 * @property int $userId
 * @property int $parentType
 * @property int $parentId
 * @property int $type
 * @property int $active
 * @property int $createdAt
 * @property int $modifiedAt
 */
class Follower extends \cmsgears\core\common\models\entities\CmgEntity {

	// Pre-Defined Type
	const TYPE_LIKE		=  0; // User Likes
	const TYPE_FOLLOW	= 10; // User Followers
	const TYPE_WISHLIST	= 20; // User who wish to have this model - specially if model is doing sales

	// Instance Methods --------------------------------------------

	public function getUser() {

		return $this->hasOne( User::className(), [ 'id' => 'userId' ] );
	}

	// yii\base\Component ----------------

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

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

		// model rules
        $rules = [
            [ [ 'userId', 'parentId', 'parentType' ], 'required' ],
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
			'parentId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT ),
			'parentType' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PARENT_TYPE ),
			'userId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_USER ),
			'type'	=> Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'active' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ACTIVE ),
		];
	}

	// Follower --------------------------

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::TABLE_FOLLOWER;
	}

	// Follower --------------------------
	
	public static function findByParentType( $parentType, $type ) {

        return self::find()->where( 'parentType =:pType AND type=:type ', [ ':pType' => $parentType, ':type' => $type ] );
	}

	public static function findByParentUserId( $parentId, $parentType, $userId, $type ) {

		return self::find()->where( 'parentId =:pid AND parentType =:pType AND userId=:uid AND type=:type ', [ ':pid' => $parentId, ':pType' => $parentType, ':uid' => $userId, ':type' => $type ] );
	}

	public static function findByParentTypeUserId( $parentType, $userId, $type ) {

		return self::find()->where( 'parentType =:pType AND userId=:uid AND type=:type ', [ ':pType' => $parentType, ':uid' => $userId, ':type' => $type ] );
	}
}

?>