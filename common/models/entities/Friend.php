<?php
namespace cmsgears\community\common\models\entities;

// Yii Imports
use \Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\community\common\models\base\CmnTables;

/**
 * Friend Entity
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $friendId
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 * @property integer $status
 */
class Friend extends \cmsgears\core\common\models\base\CmgEntity {

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

	/**
	 * @return boolean - whether given user created this entry
	 */
	public function checkOwner( $user ) {

		return $this->userId	= $user->id;
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
 				'updatedAtAttribute' => 'modifiedAt',
 				'value' => new Expression('NOW()')
            ]
        ];
    }

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
            [ [ 'userId', 'friendId' ], 'required' ],
            [ [ 'id', 'status' ], 'safe' ],
            [ [ 'userId', 'friendId' ], 'number', 'integerOnly' => true, 'min' => 1 ],
			[ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'userId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_USER ),
			'friendId' => Yii::$app->cmgCmnMessage->getMessage( CmnGlobal::FIELD_FRIEND ),
			'status' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_STATUS )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::TABLE_FRIEND;
	}

	// Friend ----------------------------

	// Read

	// Delete

	public static function deleteByUserId( $userId ) {

		self::deleteAll( 'userId=:id', [ ':id' => $userId ] );
	}

	public static function deleteByFriendId( $friendId ) {

		self::deleteAll( 'friendId=:id', [ ':id' => $friendId ] );
	}
}

?>