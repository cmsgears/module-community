<?php
namespace cmsgears\community\common\models\resources;

// Yii Imports
use \Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\community\common\models\base\CmnTables;
use cmsgears\community\common\models\entities\Chat;

/**
 * ChatMessage Entity
 *
 * @property integer $id
 * @property integer $senderId
 * @property integer $recipientId
 * @property integer $chatId
 * @property boolean $consumed
 * @property short $type
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 * @property string $content
 * @property string $data
 */
class ChatMessage extends \cmsgears\core\common\models\base\Entity {

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

        return [
            [ [ 'senderId' ], 'required' ],
            [ [ 'id', 'content', 'data' ], 'safe' ],
            [ 'type', 'string', 'min' => 1, 'max' => Yii::$app->core->mediumText ],
            [ 'consumed', 'boolean' ],
            [ [ 'senderId', 'recipientId', 'chatId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'senderId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SENDER ),
			'recipientId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_RECIPIENT ),
			'chatId' => Yii::$app->cmnMessage->getMessage( CmnGlobal::FIELD_CHAT ),
			'consumed' => Yii::$app->cmnMessage->getMessage( CmnGlobal::FIELD_CONSUMED ),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'content' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// ChatMessage ---------------------------

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

	public function getChat() {

		return $this->hasOne( Chat::className(), [ 'id' => 'chatId' ] );
	}

	public function getMessage() {

		return $this->hasOne( Message::className(), [ 'id' => 'messageId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::TABLE_CHAT_MESSAGE;
	}

	// CMG parent classes --------------------

	// ChatMessage ---------------------------

	// Read - Query -----------

	public static function queryWithAll( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'sender', 'recipient', 'group' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------
}
