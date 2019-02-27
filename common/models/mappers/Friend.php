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

use cmsgears\core\common\models\interfaces\base\IOwner;
use cmsgears\core\common\models\interfaces\resources\IContent;
use cmsgears\core\common\models\interfaces\resources\IData;
use cmsgears\core\common\models\interfaces\resources\IGridCache;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\core\common\models\entities\User;
use cmsgears\community\common\models\base\CmnTables;

use cmsgears\core\common\models\traits\base\UserOwnerTrait;
use cmsgears\core\common\models\traits\resources\ContentTrait;
use cmsgears\core\common\models\traits\resources\DataTrait;
use cmsgears\core\common\models\traits\resources\GridCacheTrait;

/**
 * Friend maps one user to another.
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $friendId
 * @property integer $status
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
class Friend extends \cmsgears\core\common\models\base\Mapper implements IContent, IData, IGridCache, IOwner {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	const TYPE_CHILDHOOD	=     0;
	const TYPE_SCHOOL		=   500;
	const TYPE_COLLEGE		=  1000;
	const TYPE_TRAVEL		=  1500;
	const TYPE_PROFESSIONAL	=  2000;
	const TYPE_OTHER		= 10000;

	const STATUS_REQUEST	=    0;
	const STATUS_REJECTED	=  500;
	const STATUS_BLOCKED	= 1000;
	const STATUS_ACTIVE		= 1500;

	// Public -----------------

	public static $typeMap = [
		self::TYPE_CHILDHOOD => 'Childhood',
		self::TYPE_SCHOOL => 'School',
		self::TYPE_COLLEGE => 'College',
		self::TYPE_TRAVEL => 'Travel',
		self::TYPE_PROFESSIONAL => 'Professional',
		self::TYPE_OTHER => 'Other'
	];

	public static $statusMap = [
		self::STATUS_REQUEST => 'Request',
		self::STATUS_REJECTED => 'Rejected',
		self::STATUS_BLOCKED => 'Blocked',
		self::STATUS_ACTIVE => 'Active'
	];

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $modelType = CmnGlobal::TYPE_FRIEND;

	// Private ----------------

	// Traits ------------------------------------------------------

	use ContentTrait;
	use DataTrait;
	use GridCacheTrait;
	use UserOwnerTrait;

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
            [ [ 'userId', 'friendId' ], 'required' ],
            [ [ 'id', 'content', 'data', 'gridCache' ], 'safe' ],
			// Unique
			[ 'friendId', 'unique', 'targetAttribute' => [ 'userId', 'friendId' ], 'comboNotUnique' => 'Friend already exist.' ],
            // Other
            [ [ 'status', 'type' ], 'number', 'integerOnly' => true, 'min' => 0 ],
			[ 'gridCacheValid', 'boolean' ],
            [ [ 'userId', 'friendId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
			[ [ 'createdAt', 'modifiedAt', 'gridCachedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'userId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_USER ),
			'friendId' => Yii::$app->cmnMessage->getMessage( CmnGlobal::FIELD_FRIEND ),
			'status' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_STATUS ),
			'type' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_TYPE ),
			'content' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_CONTENT ),
			'data' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_DATA ),
			'gridCache' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_GRID_CACHE )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Friend --------------------------------

	/**
	 * Return the user who initiated friendship.
	 *
	 * @return \cmsgears\core\common\models\entities\User
	 */
	public function getUser() {

		return $this->hasOne( User::class, [ 'id' => 'userId' ] );
	}

	/**
	 * Return user who got friendship invite.
	 *
	 * @return \cmsgears\core\common\models\entities\User
	 */
	public function getFriend() {

		$userTable = CoreTables::getTableName( CoreTables::TABLE_USER );

		return $this->hasOne( User::class, [ 'id' => 'friendId' ] )->from( "$userTable as friend" );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::getTableName( CmnTables::TABLE_FRIEND );
	}

	// CMG parent classes --------------------

	// Friend --------------------------------

	// Read - Query -----------

    /**
     * @inheritdoc
     */
	public static function queryWithHasOne( $config = [] ) {

		$relations = isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'user', 'friend' ];

		$config[ 'relations' ] = $relations;

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

	/**
	 * Delete all mappings associated with given user id.
	 *
	 * @param integer $userId
	 * @return integer Number of rows
	 */
	public static function deleteByUserId( $userId ) {

		return self::deleteAll( 'userId=:id', [ ':id' => $userId ] );
	}

	/**
	 * Delete all mappings associated with given friend id.
	 *
	 * @param integer $friendId
	 * @return integer Number of rows
	 */
	public static function deleteByFriendId( $friendId ) {

		return self::deleteAll( 'friendId=:id', [ ':id' => $friendId ] );
	}

}
