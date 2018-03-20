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
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\interfaces\resources\IContent;
use cmsgears\core\common\models\interfaces\resources\IData;
use cmsgears\core\common\models\interfaces\resources\IGridCache;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\core\common\models\base\Resource;
use cmsgears\core\common\models\entities\User;
use cmsgears\community\common\models\base\CmnTables;

use cmsgears\core\common\models\traits\resources\ContentTrait;
use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\resources\GridCacheTrait;

/**
 * GroupMessage stores the messages published in group chat.
 *
 * @property integer $id
 * @property integer $senderId
 * @property integer $groupId
 * @property boolean $broadcasted
 * @property integer $type
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
class GroupMessage extends Resource implements IContent, IData, IGridCache {

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
            [ [ 'senderId', 'content' ], 'required' ],
            [ [ 'id', 'content', 'data', 'gridCache' ], 'safe' ],
			// Other
            [ 'type', 'number', 'integerOnly' => true, 'min' => 0 ],
            [ [ 'broadcasted', 'gridCacheValid' ], 'boolean' ],
			[ [ 'senderId', 'groupId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
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
			'groupId' => Yii::$app->cmnMessage->getMessage( CmnGlobal::FIELD_GROUP ),
			'broadcasted' => Yii::$app->cmnMessage->getMessage( CmnGlobal::FIELD_BROADCASTED ),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'content' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA ),
			'gridCache' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_GRID_CACHE )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// GroupMessage --------------------------

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
	 * Returns the corresponding group.
	 *
	 * @return \cmsgears\community\common\models\entities\Group
	 */
	public function getGroup() {

		$groupTable = CmnTables::getTableName( CmnTables::TABLE_GROUP );

		return $this->hasOne( Group::class, [ 'id' => 'groupId' ] )->from( "$groupTable group" );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::getTableName( CmnTables::TABLE_GROUP_MESSAGE );
	}

	// CMG parent classes --------------------

	// GroupMessage --------------------------

	// Read - Query -----------

    /**
     * @inheritdoc
     */
	public static function queryWithHasOne( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'sender', 'group' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the message with sender.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with sender.
	 */
	public static function queryWithSender( $config = [] ) {

		$config[ 'relations' ]	= [ 'sender' ];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the message with group.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with group.
	 */
	public static function queryWithGroup( $config = [] ) {

		$config[ 'relations' ]	= [ 'group' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

	/**
	 * Delete all messages having given group id.
	 *
	 * @param integer $groupId
	 * @return integer Number of rows.
	 */
	public static function deleteByGroupId( $groupId ) {

		return self::deleteAll( 'groupId=:id', [ ':id' => $groupId ] );
	}

}
