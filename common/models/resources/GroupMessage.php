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
use cmsgears\community\common\models\entities\Group;

use cmsgears\core\common\models\traits\resources\ContentTrait;
use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\resources\GridCacheTrait;
use cmsgears\core\common\models\traits\resources\VisualTrait;

/**
 * GroupMessage stores the messages published in group chat.
 *
 * @property integer $id
 * @property integer $senderId
 * @property integer $groupId
 * @property integer $avatarId
 * @property integer $bannerId
 * @property integer $videoId
 * @property string $icon
 * @property string $texture
 * @property string $type
 * @property string $code
 * @property boolean $broadcasted
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
class GroupMessage extends \cmsgears\core\common\models\base\Resource implements IContent, IData, IGridCache, IVisual {

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
            [ [ 'senderId', 'groupId', 'type', 'content' ], 'required' ],
            [ [ 'id', 'content', 'data', 'gridCache' ], 'safe' ],
			// Text Limit
			[ [ 'type', 'code' ], 'string', 'min' => 0, 'max' => Yii::$app->core->mediumText ],
			[ [ 'icon', 'texture' ], 'string', 'min' => 0, 'max' => Yii::$app->core->largeText ],
			// Other
            [ [ 'broadcasted', 'delivered', 'consumed', 'gridCacheValid' ], 'boolean' ],
			[ [ 'senderId', 'groupId', 'avatarId', 'bannerId', 'videoId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
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
			'avatarId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_AVATAR ),
			'bannerId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_BANNER ),
			'videoId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_VIDEO ),
			'broadcasted' => Yii::$app->cmnMessage->getMessage( CmnGlobal::FIELD_BROADCASTED ),
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

	public function getBroadcastedStr() {

		return Yii::$app->formatter->asBoolean( $this->broadcasted );
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

		return CmnTables::getTableName( CmnTables::TABLE_GROUP_MESSAGE );
	}

	// CMG parent classes --------------------

	// GroupMessage --------------------------

	// Read - Query -----------

    /**
     * @inheritdoc
     */
	public static function queryWithHasOne( $config = [] ) {

		$relations = isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'sender', 'group' ];

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
	 * Return query to find the message with group.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with group.
	 */
	public static function queryWithGroup( $config = [] ) {

		$config[ 'relations' ] = [ 'group' ];

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

	public static function deleteBySenderId( $senderId ) {

		return self::deleteAll( 'senderId=:id', [ ':id' => $senderId ] );
	}

}
