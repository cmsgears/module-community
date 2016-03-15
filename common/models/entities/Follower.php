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
	const TYPE_LIKE		=  0;
	const TYPE_FOLLOW	= 10;
	const TYPE_WISHLIST	= 20; 

	// Instance Methods --------------------------------------------


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
            [ [ 'id', 'type', 'active', 'createdAt', 'modifiedAt' ], 'safe' ]
        ];

		// trim if required
		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'userId', 'parentId', 'parentType', 'type', 'active', 'createdAt', 'modifiedAt' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

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

		return CmnTables::TABLE_FOLLOW;
	}

	// Follower --------------------------

	public static function findAllbyUserIdType( $userId, $type ) {
		
		return self::find()->where( 'userId=:uid AND type=:type AND active=1', [ ':uid' => $userId, ':type' => $type ] )->all();
	}
	
	public static function findAllByParentIdType( $parentId, $type ) {
		
		return self::find()->where( 'parentId=:lid AND type=:type', [ ':lid' => $parentId, ':type' => $type ] )->all();
	}
	
	public static function findAllByParentIdParentTypeActive( $parentId, $parentType, $type, $active ) {
		
		return self::find()->where( 'parentId=:lid AND parentType=:pType AND type=:type AND active=:active', [ ':lid' => $parentId, ':pType' => $parentType, ':type' => $type, ':active' => $active ] )->all();
	}
	
	public static function findByUserParentIdType( $userId, $parentId, $parentType, $type ) {
		
		return self::find()->where( 'userId=:uid AND parentId=:pid AND parentType =:pType AND type=:type ', [ ':uid' => $userId, ':pid' => $parentId,':pType' => $parentType, ':type' => $type ] )->one();
	}
}

?>