<?php
namespace cmsgears\community\common\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\CmgEntity;
use cmsgears\core\common\models\entities\User;

/**
 * Friend Entity
 *
 * @property integer $userId
 * @property integer $friendId
 * @property datetime $createdAt
 * @property integer $status
 */
class Friend extends CmgEntity {

	// Instance Methods --------------------------------------------

	/**
	 * @return User
	 */
	public function getUser() {

		return $this->hasOne( User::className(), [ 'id' => 'userId' ] );
	}

	/**
	 * @return User
	 */
	public function getFriend() {

		return $this->hasOne( User::className(), [ 'id' => 'friendId' ] );
	}

	// yii\base\Model --------------------

	public function rules() {

        return [
            [ [ 'userId', 'friendId' ], 'required' ],
            [ 'status', 'safe' ],
            [ [ 'userId', 'friendId' ], 'number', 'integerOnly' => true, 'min' => 1 ]
        ];
    }

	public function attributeLabels() {

		return [
			'userId' => 'User',
			'friendId' => 'Friend',
			'status' => 'status'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CmnTables::TABLE_FRIEND;
	}

	// RolePermission --------------------

	// Delete

	public static function deleteByUserId( $userId ) {

		self::deleteAll( 'userId=:id', [ ':id' => $userId ] );
	}

	public static function deleteByFriendId( $friendId ) {

		self::deleteAll( 'friendId=:id', [ ':id' => $friendId ] );
	}
}

?>