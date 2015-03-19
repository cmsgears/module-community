<?php
namespace cmsgears\modules\community\common\models\entities;

// Yii Imports
use yii\db\Query;
use yii\db\ActiveRecord;

// CMG Imports
use cmsgears\modules\core\common\models\entities\User;

use cmsgears\modules\core\common\utilities\MessageUtil;

class GroupMessage extends ActiveRecord {

	const VISIBILITY_PUBLIC		= 0;	// Visible to All
	const VISIBILITY_PRIVATE	= 1;	// Visible to logged in users
	const VISIBILITY_MEMBERS	= 2;	// Visible to room members

	public static $visibilityMap = [
		self::VISIBILITY_PUBLIC => "Public",
		self::VISIBILITY_PRIVATE => "Private",
		self::VISIBILITY_MEMBERS => "Members"
	];

	// Instance Methods --------------------------------------------

	// db columns

	public function getId() {

		return $this->message_id;
	}

	public function getGroupId() {

		return $this->message_group;	
	}

	public function getGroup() {

		return $this->hasOne( Group::className(), [ 'user_id' => 'message_group' ] );
	}

	public function setGroupId( $groupId ) {

		$this->message_group = $groupId;	
	}

	public function getOwnerId() {

		return $this->message_owner;	
	}

	public function getOwner() {

		return $this->hasOne( User::className(), [ 'user_id' => 'message_owner' ] );
	}

	public function setOwnerId( $ownerId ) {

		$this->message_owner = $ownerId;
	}

	public function getVisibility() {

		return $this->message_visibility;	
	}

	public function getVisibilityStr() {

		return self::$visibilityMap[ $this->message_type ];	
	}

	public function setVisibility( $visibility ) {
		
		$this->message_visibility = $visibility;
	}

	public function getContent() {

		return $this->message_content;
	}

	public function setContent( $content ) {

		$this->message_content = $content;
	}

	public function getCreatedOn() {

		return $this->message_created_on;
	}

	public function setCreatedOn( $createdOn ) {

		$this->message_created_on = $createdOn;
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'message_type', 'message_content' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'message_type' => 'Type',
			'message_content' => 'Content'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord

	public static function tableName() {

		return CommunityTables::TABLE_GROUP_MESSAGE;
	}

	// GroupMessage

	public static function findById( $id ) {

		return GroupMessage::find()->where( 'message_id=:id', [ ':id' => $id ] )->one();
	}

	public static function findByGroup( $group ) {

		return GroupMessage::find()->where( 'message_group=:id', [ ':id' => $group->getId() ] )->all();
	}

	public static function findByGroupId( $groupId ) {

		return GroupMessage::find()->where( 'message_group=:id', [ ':id' => $groupId ] )->all();
	}
}

?>