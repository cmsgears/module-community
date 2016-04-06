<?php
namespace cmsgears\community\common\models\resources;

// Yii Imports
use \Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\community\common\models\base\CmnTables;

/**
 * GroupMember Entity
 *
 * @property integer $id
 * @property integer $groupId
 * @property integer $memberId
 * @property integer $visibility
 * @property integer $content
 * @property datetime $createdAt
 * @property datetime $modifiedAt
 */
class GroupMessage extends \cmsgears\core\common\models\base\CmgEntity {

	const VISIBILITY_PUBLIC		= 0;	// Visible to All
	const VISIBILITY_PRIVATE	= 1;	// Visible to logged in users
	const VISIBILITY_MEMBERS	= 2;	// Visible to group members

	public static $visibilityMap = [
		self::VISIBILITY_PUBLIC => 'Public',
		self::VISIBILITY_PRIVATE => 'Private',
		self::VISIBILITY_MEMBERS => 'Members'
	];

	// Instance Methods --------------------------------------------

	public function getGroup() {

		return $this->hasOne( Group::className(), [ 'id' => 'groupId' ] )->from( CmnTables::TABLE_GROUP . ' group' );
	}

	public function getMember() {

		return $this->hasOne( GroupMember::className(), [ 'id' => 'memberId' ] )->from( CmnTables::TABLE_GROUP_MEMBER . ' member' );
	}

	public function getVisibilityStr() {

		return self::$visibilityMap[ $this->visibility ];
	}

	public function setVisibility( $visibility ) {

		$this->message_visibility = $visibility;
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
        	[ [ 'groupId', 'memberId' ], 'required' ],
            [ [ 'visibility', 'content' ], 'safe' ],
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'groupId' => Yii::$app->cmgCmnMessage->getMessage( CmnGlobal::FIELD_GROUP ),
			'memberId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_MEMBER ),
			'visibility' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_VISIBILITY ),
			'content' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_CONTENT )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::TABLE_GROUP_MESSAGE;
	}

	// GroupMessage ----------------------

	// Read ----

	// Update ----

	// Delete ----

	/**
	 * Delete all entries having given group id.
	 */
	public static function deleteByGroupId( $groupId ) {

		self::deleteAll( 'groupId=:id', [ ':id' => $groupId ] );
	}

}

?>