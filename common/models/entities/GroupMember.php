<?php
namespace cmsgears\modules\community\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

// CMG Imports
use cmsgears\modules\core\common\models\entities\User;
use cmsgears\modules\core\common\models\entities\rbac\Role;

use cmsgears\modules\core\common\utilities\MessageUtil;

class GroupMember extends ActiveRecord {

	const STATUS_NEW		= 0;
	const STATUS_ACTIVE		= 1;
	const STATUS_BLOCKED	= 2;

	public static $statusMap = [
		self::STATUS_NEW => "New",
		self::STATUS_ACTIVE => "Active",
		self::STATUS_BLOCKED => "Blocked"
	];

	// Instance Methods --------------------------------------------

	// db columns

	public function getId() {

		return $this->member_id;
	}

	public function getGroupId() {

		return $this->member_group;	
	}

	public function getGroup() {

		return $this->hasOne( Group::className(), [ 'user_id' => 'member_group' ] );
	}

	public function setGroupId( $groupId ) {

		$this->member_group = $groupId;	
	}

	public function getUserId() {

		return $this->member_user;	
	}

	public function getUser() {

		return $this->hasOne( User::className(), [ 'user_id' => 'member_user' ] );
	}

	public function setUserId( $userId ) {

		$this->member_user = $userId;
	}

	public function getRoleId() {

		return $this->member_role;
	}

	public function getRole() {

		return $this->hasOne( Role::className(), [ 'role_id' => 'member_role' ] );
	}

	public function setRoleId( $roleId ) {

		$this->member_role = $roleId;
	}

	public function getStatus() {

		return $this->member_status;
	}

	public function getStatusStr() {

		return self::$statusMap[ $this->member_status ];
	}

	public function setStatus( $status ) {

		$this->member_status = $status;
	}

	public function getJoinedOn() {

		return $this->member_joined_on;
	}

	public function setJoinedOn( $joinedOn ) {

		$this->member_joined_on = $joinedOn;
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'member_status' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'member_status' => 'Status'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord

	public static function tableName() {

		return CommunityTables::TABLE_GROUP_MEMBER;
	}

	// GroupMember

	public static function findById( $id ) {

		return GroupMember::find()->where( 'member_id=:id', [ ':id' => $id ] )->one();
	}

	public static function findByGroup( $group ) {

		return GroupMember::find()->where( 'member_group=:id', [ ':id' => $group->getId() ] )->all();
	}

	public static function findByGroupId( $groupId ) {

		return GroupMember::find()->where( 'member_group=:id', [ ':id' => $groupId ] )->all();
	}
}

?>