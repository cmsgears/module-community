<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\models\resources;

// Yii Imports
use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\interfaces\resources\IContent;
use cmsgears\core\common\models\interfaces\resources\IData;
use cmsgears\core\common\models\interfaces\resources\IGridCache;
use cmsgears\core\common\models\interfaces\resources\IVisual;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\core\common\models\entities\User;
use cmsgears\community\common\models\base\CmnTables;
use cmsgears\community\common\models\entities\Chat;

use cmsgears\core\common\models\traits\resources\ContentTrait;
use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\resources\GridCacheTrait;
use cmsgears\core\common\models\traits\resources\VisualTrait;

/**
 * ChatMessage stores the messages sent in chat sessions.
 *
 * @property integer $id
 * @property integer $senderId
 * @property integer $recipientId
 * @property integer $chatId
 * @property integer $avatarId
 * @property integer $bannerId
 * @property integer $videoId
 * @property string $icon
 * @property string $texture
 * @property string $type
 * @property string $code
 * @property boolean $sent
 * @property boolean $delivered
 * @property boolean $consumed
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 * @property string $content
 * @property string $data
 * @property string $gridCache
 * @property boolean $gridCacheValid
 * @property datetime $gridCachedAt
 *
 * @since 1.0.0
 */
class ChatMessage extends \cmsgears\core\common\models\base\Resource implements IContent, IData, IGridCache, IVisual {

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

	use ContentTrait;
	use DataTrait;
	use GridCacheTrait;
	use VisualTrait;

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
				'class' => TimestampBehavior::class,
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

		// Model Rules
		$rules = [
			// Required, Safe
            [ [ 'senderId', 'type', 'content' ], 'required' ],
            [ [ 'id', 'content', 'data', 'gridCache' ], 'safe' ],
			// Text Limit
			[ [ 'type', 'code' ], 'string', 'min' => 0, 'max' => Yii::$app->core->mediumText ],
			[ [ 'icon', 'texture' ], 'string', 'min' => 0, 'max' => Yii::$app->core->largeText ],
			// Other
            [ [ 'sent', 'delivered', 'consumed', 'gridCacheValid' ], 'boolean' ],
            [ [ 'senderId', 'recipientId', 'chatId', 'avatarId', 'bannerId', 'videoId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt', 'modifiedAt', 'gridCachedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];

		// Trim Text
		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ 'content', 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'senderId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SENDER ),
			'recipientId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_RECIPIENT ),
			'chatId' => Yii::$app->cmnMessage->getMessage( CmnGlobal::FIELD_CHAT ),
			'avatarId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_AVATAR ),
			'bannerId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_BANNER ),
			'videoId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VIDEO ),
			'sent' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_SENT ),
			'delivered' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DELIVERED ),
			'consumed' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CONSUMED ),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'code' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CODE ),
			'content' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA ),
			'gridCache' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_GRID_CACHE )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// ChatMessage ---------------------------

	/**
	 * Returns the message sender.
	 *
	 * @return \cmsgears\core\common\models\entities\User
	 */
	public function getSender() {

		$userTable = CoreTables::getTableName( CoreTables::TABLE_USER );

		return $this->hasOne( User::class, [ 'id' => 'senderId' ] )->from( "$userTable sender" );
	}

	/**
	 * Returns the message recipient.
	 *
	 * @return \cmsgears\core\common\models\entities\User
	 */
	public function getRecipient() {

		$userTable = CoreTables::getTableName( CoreTables::TABLE_USER );

		return $this->hasOne( User::class, [ 'id' => 'recipientId' ] )->from( "$userTable recipient" );
	}

	/**
	 * Returns the corresponding chat.
	 *
	 * @return \cmsgears\community\common\models\entities\Chat
	 */
	public function getChat() {

		return $this->hasOne( Chat::class, [ 'id' => 'chatId' ] );
	}

	public function getSentStr() {

		return Yii::$app->formatter->asBoolean( $this->sent );
	}

	public function getDeliveredStr() {

		return Yii::$app->formatter->asBoolean( $this->delivered );
	}

	public function getConsumedStr() {

		return Yii::$app->formatter->asBoolean( $this->consumed );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::getTableName( CmnTables::TABLE_CHAT_MESSAGE );
	}

	// CMG parent classes --------------------

	// ChatMessage ---------------------------

	// Read - Query -----------

    /**
     * @inheritdoc
     */
	public static function queryWithHasOne( $config = [] ) {

		$relations = isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'sender', 'recipient', 'chat' ];

		$config[ 'relations' ] = $relations;

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the message with sender.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with sender.
	 */
	public static function queryWithSender( $config = [] ) {

		$config[ 'relations' ] = [ 'sender' ];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the message with recipient.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with recipient.
	 */
	public static function queryWithRecipient( $config = [] ) {

		$config[ 'relations' ] = [ 'recipient' ];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the message with chat.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with chat.
	 */
	public static function queryWithChat( $config = [] ) {

		$config[ 'relations' ] = [ 'chat' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

	/**
	 * Delete all messages having given chat id.
	 *
	 * @param integer $chatId
	 * @return integer Number of rows.
	 */
	public static function deleteByChatId( $chatId ) {

		return self::deleteAll( 'chatId=:id', [ ':id' => $chatId ] );
	}

}
