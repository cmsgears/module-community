<?php
namespace cmsgears\community\common\models\entities;

// CMG Imports
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
 * @property short $read
 */
class Message extends CmgEntity {

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

	// yii\base\Model --------------------

	public function rules() {

        return [
            [ [ 'senderId', 'recipientId', 'type', 'content' ], 'required' ],
            [ [ 'id', 'read' ], 'safe' ],
            [ [ 'senderId', 'recipientId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt' ], 'date', 'format' => 'yyyy-MM-dd HH:mm:ss' ]
        ];
    }

	public function attributeLabels() {

		return [
			'senderId' => 'Sender',
			'recipientId' => 'Recipient',
			'type' => 'Type',
			'content' => 'Content',
			'read' => 'Read'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CmnTables::TABLE_MESSAGE;
	}

	// Role ------------------------------

}

?>