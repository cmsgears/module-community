<?php
namespace cmsgears\community\common\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\CmgEntity;

class GroupMessage extends CmgEntity {

	const VISIBILITY_PUBLIC		= 0;	// Visible to All
	const VISIBILITY_PRIVATE	= 1;	// Visible to logged in users
	const VISIBILITY_MEMBERS	= 2;	// Visible to group members

	public static $visibilityMap = [
		self::VISIBILITY_PUBLIC => "Public",
		self::VISIBILITY_PRIVATE => "Private",
		self::VISIBILITY_MEMBERS => "Members"
	];

	// Instance Methods --------------------------------------------

	public function getGroup() {

		return $this->hasOne( Group::className(), [ 'id' => 'groupId' ] );
	}

	public function getMember() {

		return $this->hasOne( GroupMember::className(), [ 'id' => 'memberId' ] );
	}

	public function getVisibilityStr() {

		return self::$visibilityMap[ $this->visibility ];	
	}

	public function setVisibility( $visibility ) {
		
		$this->message_visibility = $visibility;
	}

	// yii\base\Model --------------------

	public function rules() {

        return [
        	[ [ 'groupId', 'memberId' ], 'required' ],
            [ [ 'visibility', 'content' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'visibility' => 'Visibility',
			'content' => 'Content'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CmnTables::TABLE_GROUP_MESSAGE;
	}

	// GroupMessage ----------------------

	public static function findById( $id ) {

		return self::find()->where( 'id=:id', [ ':id' => $id ] )->one();
	}
}

?>