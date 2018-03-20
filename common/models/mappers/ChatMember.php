<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\models\mappers;

// Yii Imports
use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\base\Mapper;
use cmsgears\core\common\models\entities\User;
use cmsgears\community\common\models\base\CmnTables;
use cmsgears\community\common\models\entities\Chat;

/**
 * ChatMember represents member of chat.
 *
 * @property integer $id
 * @property integer $chatId
 * @property integer $userId
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 * @property datetime $syncedAt
 *
 * @since 1.0.0
 */
class ChatMember extends Mapper {

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
        	[ [ 'chatId', 'userId' ], 'required' ],
            [ 'id', 'safe' ],
            // Other
            [ [ 'createdAt', 'modifiedAt', 'syncedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'chatId' => Yii::$app->cmnMessage->getMessage( CmnGlobal::FIELD_CHAT ),
			'userId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_USER )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// ChatMember ----------------------------

	/**
	 * Returns the chat corresponding to the member.
	 *
	 * @return \cmsgears\community\common\models\entities\Chat
	 */
	public function getChat() {

		return $this->hasOne( Chat::class, [ 'id' => 'chatId' ] );
	}

	/**
	 * Returns the user corresponding to the member.
	 *
	 * @return \cmsgears\core\common\models\entities\User
	 */
	public function getUser() {

		return $this->hasOne( User::class, [ 'id' => 'userId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::getTableName( CmnTables::TABLE_CHAT_MEMBER );
	}

	// CMG parent classes --------------------

	// ChatMember ----------------------------

	// Read - Query -----------

    /**
     * @inheritdoc
     */
	public static function queryWithHasOne( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'chat', 'user' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with chat.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with chat.
	 */
	public static function queryWithChat( $config = [] ) {

		$config[ 'relations' ]	= [ 'chat' ];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with user.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with user.
	 */
	public static function queryWithUser( $config = [] ) {

		$config[ 'relations' ]	= [ 'user' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

	/**
	 * Delete all entries having given chat id.
	 *
	 * @param integer $chatId
	 * @return integer Number of rows.
	 */
	public static function deleteByChatId( $chatId ) {

		return self::deleteAll( 'chatId=:id', [ ':id' => $chatId ] );
	}

	/**
	 * Delete all entries having given user id.
	 *
	 * @param integer $userId
	 * @return integer Number of rows.
	 */
	public static function deleteByUserId( $userId ) {

		return self::deleteAll( 'userId=:id', [ ':id' => $userId ] );
	}

}
