<?php
namespace cmsgears\community\common\models\entities;

// Yii Imports
use \Yii;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\entities\CoreTables;
use cmsgears\core\common\models\entities\CmgEntity;
use cmsgears\core\common\models\entities\User;

/**
 * Message Entity
 *
 * @property integer $id
 * @property integer $senderId
 * @property integer $recipientId
 * @property short $type 
 * @property string $content
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 * @property short $mark
 */
class Message extends CmgEntity {

	// Instance Methods --------------------------------------------
	
	/**
	 * @return User
	 */
	public function getSender() {

		return $this->hasOne( User::className(), [ 'id' => 'senderId' ] )->from( CoreTables::TABLE_USER . ' sender' );
	}

	/**
	 * @return User
	 */
	public function getRecipient() {

		return $this->hasOne( User::className(), [ 'id' => 'recipientId' ] )->from( CoreTables::TABLE_USER . ' recipient' );
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
            [ [ 'senderId', 'recipientId', 'type', 'content' ], 'required' ],
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
			'type' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
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

}

?>