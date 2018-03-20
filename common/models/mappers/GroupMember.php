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

use cmsgears\core\common\models\interfaces\base\IApproval;

use cmsgears\core\common\models\base\Mapper;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Role;
use cmsgears\community\common\models\base\CmnTables;

use cmsgears\core\common\models\traits\base\ApprovalTrait;

/**
 * GroupMember represents member of group.
 *
 * @property integer $id
 * @property integer $groupId
 * @property integer $userId
 * @property integer $roleId
 * @property integer $status
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 * @property datetime $syncedAt
 *
 * @since 1.0.0
 */
class GroupMember extends Mapper implements IApproval {

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

	use ApprovalTrait;

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
        	[ [ 'groupId', 'userId', 'roleId' ], 'required' ],
			[ 'id', 'safe' ],
			// Other
            [ 'status', 'number', 'integerOnly' => true, 'min' => 0 ],
            [ [ 'createdAt', 'modifiedAt', 'syncedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];

		return $rules;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'groupId' => Yii::$app->cmnMessage->getMessage( CmnGlobal::FIELD_GROUP ),
			'userId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_USER ),
			'roleId' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ROLE ),
			'status' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_STATUS )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// GroupMember ---------------------------

	/**
	 * Returns the group corresponding to the member.
	 *
	 * @return \cmsgears\community\common\models\entities\Group
	 */
	public function getGroup() {

		return $this->hasOne( Group::class, [ 'id' => 'groupId' ] );
	}

	/**
	 * Returns the user corresponding to the member.
	 *
	 * @return \cmsgears\core\common\models\entities\User
	 */
	public function getUser() {

		return $this->hasOne( User::class, [ 'id' => 'userId' ] );
	}

	/**
	 * Returns the role corresponding to the member.
	 *
	 * @return \cmsgears\core\common\models\entities\Role
	 */
	public function getRole() {

		return $this->hasOne( Role::class, [ 'id' => 'roleId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::getTableName( CmnTables::TABLE_GROUP_MEMBER );
	}

	// CMG parent classes --------------------

	// GroupMember ---------------------------

	// Read - Query -----------

    /**
     * @inheritdoc
     */
	public static function queryWithHasOne( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'group', 'user', 'role' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with group.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with group.
	 */
	public static function queryWithGroup( $config = [] ) {

		$config[ 'relations' ]	= [ 'group' ];

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with user.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with user.
	 */
	public static function queryWithUser( $config = [] ) {

		$config[ 'relations' ]	= [ 'user', 'role' ];

		return parent::queryWithAll( $config );
	}


	// Read - Find ------------

	/**
	 * Find and return the members by given user id.
	 *
	 * @param integer $id
	 * @return GroupMember[]
	 */
	public static function findByUserId( $id ) {

		return self::find()->where( [ 'userId' => $id ] )->all();
	}

	// Create -----------------

	// Update -----------------

	// Delete -----------------

	/**
	 * Delete all entries having given group id.
	 *
	 * @param integer $groupId
	 * @return integer Number of rows.
	 */
	public static function deleteByGroupId( $groupId ) {

		return self::deleteAll( 'groupId=:id', [ ':id' => $groupId ] );
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
