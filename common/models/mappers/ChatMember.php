<?php
namespace cmsgears\community\common\models\mappers;

// Yii Imports
use \Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\community\common\models\base\CmnTables;

/**
 * ChatMember Entity
 *
 * @property integer $id
 * @property integer $chatId
 * @property integer $userId
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 * @property datetime $syncedAt
 */
class ChatMember extends \cmsgears\core\common\models\base\CmgEntity {

	// Instance Methods --------------------------------------------

	public function getChat() {

		return $this->hasOne( Chat::className(), [ 'id' => 'chatId' ] );
	}

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

        return [
        	[ [ 'chatId', 'userId' ], 'required' ],
            [ [ 'id' ], 'safe' ],
            [ [ 'createdAt', 'modifiedAt', 'syncedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'chatId' => Yii::$app->cmgCmnMessage->getMessage( CmnGlobal::FIELD_CHAT ),
			'userId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_USER )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::TABLE_CHAT_MEMBER;
	}

	// ChatMember ------------------------

	// Read ----

	// Delete ----

	/**
	 * Delete all entries having given chat id.
	 */
	public static function deleteByChatId( $chatId ) {

		self::deleteAll( 'chatId=:id', [ ':id' => $chatId ] );
	}

	/**
	 * Delete all entries having given user id.
	 */
	public static function deleteByUserId( $userId ) {

		self::deleteAll( 'userId=:id', [ ':id' => $userId ] );
	}
}

?>