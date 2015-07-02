<?php
namespace cmsgears\community\common\models\entities;

// Yii Imports
use \Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\entities\CmgEntity;
use cmsgears\core\common\models\entities\User;

/**
 * Message Entity
 *
 * @property integer $id
 * @property integer $senderId
 * @property integer $recipientId
 * @property short $visibility
 * @property string $content
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 * @property short $mark
 */
class Message extends CmgEntity {

	const VISIBILITY_PRIVATE	=  0; // visible only among sender and recipient - ex: private chat
	const VISIBILITY_FRIENDS	=  5; // friends can view the message - ex: wall post
	const VISIBILITY_PUBLIC		= 10; // anyone can view the message - ex: wall post

	public static $visibilityMap = [
		self::VISIBILITY_PRIVATE => "Private",
		self::VISIBILITY_FRIENDS => "Friends",
		self::VISIBILITY_PUBLIC => "Public"
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
            [ [ 'id', 'read' ], 'safe' ],
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
			'mark' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_MARK )
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

	// Read

	/**
	 * @return Message - by id
	 */
	public static function findById( $id ) {

		return self::find()->where( 'id=:id', [ ':id' => $id ] )->one();
	}
}

?>