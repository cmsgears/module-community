<?php
namespace cmsgears\community\common\models\entities;

// Yii Imports
use \Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\entities\User;

/**
 * Message Entity
 *
 * @property integer $id
 * @property integer $senderId
 * @property integer $recipientId
 * @property short $visibility
 * @property string $content
 * @property short $consumed
 * @property short $type
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 */
class Message extends \cmsgears\core\common\models\entities\CmgEntity {

	const VISIBILITY_PRIVATE	=  0; // visible only among sender and recipient
	const VISIBILITY_FRIENDS	=  5; // friends can view the message
	const VISIBILITY_PUBLIC		= 10; // anyone can view the message

	public static $visibilityMap = [
		self::VISIBILITY_PRIVATE => 'Private',
		self::VISIBILITY_FRIENDS => 'Friends',
		self::VISIBILITY_PUBLIC => 'Public'
	];

	const TYPE_WALL		= 0;
	const TYPE_CHAT		= 5;

	public static $typeMap = [
		self::TYPE_WALL => 'Wall',
		self::TYPE_CHAT => 'Chat'
	];

	// Instance Methods --------------------------------------------

	/**
	 * @return User
	 */
	public function getSender() {

		return $this->hasOne( User::className(), [ 'id' => 'senderId' ] );
	}

	/**
	 * @return User
	 */
	public function getRecipient() {

		return $this->hasOne( User::className(), [ 'id' => 'recipientId' ] );
	}

	/**
	 * @return String
	 */
	public function getTypeStr() {

		return self::$typeMap[ $this->type ];
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

        return [
            [ [ 'senderId', 'recipientId', 'visibility', 'content' ], 'required' ],
            [ [ 'id', 'consumed', 'type' ], 'safe' ],
            [ [ 'senderId', 'recipientId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'senderId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_SENDER ),
			'recipientId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_RECIPIENT ),
			'visibility' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_VISIBILITY ),
			'content' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'consumed' => Yii::$app->cmgCmnMessage->getMessage( CmnGlobal::FIELD_CONSUMED ),
			'type' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TYPE )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::TABLE_MESSAGE;
	}

	// Message ---------------------------

}

?>