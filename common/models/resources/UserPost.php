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

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\interfaces\base\IVisibility;
use cmsgears\core\common\models\interfaces\resources\IContent;
use cmsgears\core\common\models\interfaces\resources\IData;
use cmsgears\core\common\models\interfaces\resources\IGridCache;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\core\common\models\base\Resource;
use cmsgears\core\common\models\entities\User;
use cmsgears\community\common\models\base\CmnTables;

use cmsgears\core\common\models\traits\base\VisibilityTrait;
use cmsgears\core\common\models\traits\resources\ContentTrait;
use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\resources\GridCacheTrait;

/**
 * UserPost represent a message posted to user by friends.
 *
 * @property integer $id
 * @property integer $senderId
 * @property integer $recipientId
 * @property integer $visibility
 * @property integer $type
 * @property date $createdAt
 * @property date $modifiedAt
 * @property string $content
 * @property string $data
 * @property string $gridCache
 * @property boolean $gridCacheValid
 * @property datetime $gridCachedAt
 *
 * @since 1.0.0
 */
class UserPost extends Resource implements IContent, IData, IGridCache, IVisibility {

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
	use VisibilityTrait;

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
            [ [ 'senderId', 'recipientId', 'visibility' ], 'required' ],
            [ [ 'id', 'content', 'data', 'gridCache' ], 'safe' ],
			// Other
            [ 'type', 'number', 'intergerOnly' => true, 'min' => 0 ],
			[ 'gridCacheValid', 'boolean' ],
            [ [ 'senderId', 'recipientId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
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
			'visibility' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VISIBILITY ),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'content' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA ),
			'gridCache' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_GRID_CACHE )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Post ----------------------------------

	/**
	 * Return the user who sent the message.
	 *
	 * @return \cmsgears\core\common\models\entities\User
	 */
	public function getSender() {

		$userTable = CoreTables::getTableName( CoreTables::TABLE_USER );

		return $this->hasOne( User::class, [ 'id' => 'senderId' ] )->from( "$userTable as sender" );
	}

	/**
	 * Return the user who receive the message.
	 *
	 * @return \cmsgears\core\common\models\entities\User
	 */
	public function getRecipient() {

		$userTable = CoreTables::getTableName( CoreTables::TABLE_USER );

		return $this->hasOne( User::class, [ 'id' => 'recipientId' ] )->from( "$userTable as recipient" );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::getTableName( CmnTables::TABLE_USER_POST );
	}

	// CMG parent classes --------------------

	// Post ----------------------------------

	// Read - Query -----------

    /**
     * @inheritdoc
     */
	public static function queryWithHasOne( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'sender', 'recipient' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
