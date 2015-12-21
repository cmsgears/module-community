<?php
namespace cmsgears\community\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

/**
 * ChatMessage Entity
 *
 * @property integer $id
 * @property integer $chatId
 * @property integer $messageId
 */
class ChatMessage extends \cmsgears\core\common\models\entities\CmgEntity {

	// Instance Methods --------------------------------------------

	public function getChat() {

		return $this->hasOne( Chat::className(), [ 'id' => 'chatId' ] );
	}

	public function getMessage() {

		return $this->hasOne( Message::className(), [ 'id' => 'messageId' ] );
	}

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
        	[ [ 'chatId', 'messageId' ], 'required' ],
            [ [ 'id' ], 'safe' ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'chatId' => Yii::$app->cmgCmnMessage->getMessage( CmnGlobal::FIELD_CHAT ),
			'messageId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_MESSAGE )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::TABLE_CHAT_MESSAGE;
	}

	// ChatMessage -----------------------

}

?>