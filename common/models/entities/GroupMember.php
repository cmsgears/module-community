<?php
namespace cmsgears\community\common\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\CmgEntity;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\rbac\Role;

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

		return $this->hasOne( Group::className(), [ 'id' => 'groupId' ] );
	}

	public function getMember() {

		return $this->hasOne( User::className(), [ 'id' => 'memberId' ] );
	}

	public function getRole() {

		return $this->hasOne( Role::className(), [ 'id' => 'roleId' ] );
	}

	public function getStatusStr() {

		return self::$statusMap[ $this->status ];
	}

	// yii\base\Model --------------------

	public function rules() {

        return [
        	[ [ 'groupId', 'memberId', 'roleId' ], 'required' ],
            [ [ 'status' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'groupId' => 'Group',
			'memberId' => 'Member',
			'roleId' => 'Role',
			'status' => 'Status'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CmnTables::TABLE_GROUP_MEMBER;
	}

	// GroupMember -----------------------

	public static function findByGroupIdUserId( $groupId, $userId ) {

		return self::find()->where( 'groupId=:gid AND memberId=:mid', [ ':gid' => $groupId, ':mid' => $userId ] )->one();
	}
}

?>