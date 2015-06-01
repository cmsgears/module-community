<?php
namespace cmsgears\community\common\models\entities;

// Yii Imports
use \Yii;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\entities\CoreTables;
use cmsgears\core\common\models\entities\CmgEntity;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Role;

/**
 * GroupMember Entity
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $groupId
 * @property integer $roleId
 * @property integer $status
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 * @property datetime $syncedAt
 */
class GroupMember extends CmgEntity {

	const STATUS_NEW		= 0;
	const STATUS_ACTIVE		= 1;
	const STATUS_BLOCKED	= 2;

	public static $statusMap = [
		self::STATUS_NEW => "New",
		self::STATUS_ACTIVE => "Active",
		self::STATUS_BLOCKED => "Blocked"
	];

	// Instance Methods --------------------------------------------

	public function getGroup() {

		return $this->hasOne( Group::className(), [ 'id' => 'groupId' ] )->from( CmnTables::TABLE_GROUP . ' group' );
	}

	public function getUser() {

		return $this->hasOne( User::className(), [ 'id' => 'userId' ] )->from( CoreTables::TABLE_USER . ' user' );
	}

	public function getRole() {

		return $this->hasOne( Role::className(), [ 'id' => 'roleId' ] )->from( CoreTables::TABLE_ROLE . ' role' );
	}

	public function getStatusStr() {

		return self::$statusMap[ $this->status ];
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
 				'updatedAtAttribute' => 'modifiedAt'
            ]
        ];
    }

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
        	[ [ 'groupId', 'userId', 'roleId' ], 'required' ],
            [ [ 'status' ], 'safe' ],
            [ [ 'createdAt', 'modifiedAt', 'syncedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'groupId' => Yii::$app->cmgCmnMessage->getMessage( CmnGlobal::FIELD_GROUP ),
			'userId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_USER ),
			'roleId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ROLE ),
			'status' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_STATUS )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::TABLE_GROUP_MEMBER;
	}

	// GroupMember -----------------------
	
	// Read ----

	public static function findById( $id ) {

		return self::find()->where( 'id=:id', [ ':id' => $id ] )->one();
	}
	
	public static function findByGroupIdUserId( $groupId, $userId ) {

		return self::find()->where( 'groupId=:gid AND userId=:uid', [ ':gid' => $groupId, ':uid' => $userId ] )->one();
	}

	// Delete ----
	
	/**
	 * Delete all entries having given group id.
	 */
	public static function deleteByGroupId( $groupId ) {

		self::deleteAll( 'groupId=:id', [ ':id' => $groupId ] );
	}

	/**
	 * Delete all entries having given user id.
	 */
	public static function deleteByUserId( $userId ) {

		self::deleteAll( 'userId=:id', [ ':id' => $userId ] );
	}
}

?>