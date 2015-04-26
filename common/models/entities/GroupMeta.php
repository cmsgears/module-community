<?php
namespace cmsgears\community\common\models\entities;

/**
 * GroupMeta Entity
 *
 * @property integer $userId
 * @property string $name
 * @property string $value
 */
class GroupMeta extends CmgEntity {

	// Instance methods --------------------------------------------------

	/**
	 * @return Group
	 */
	public function getGroup() {

		return $this->hasOne( Group::className(), [ 'id' => 'groupId' ] );
	}

	// yii\base\Model --------------------

	public function rules() {

        return [
            [ [ 'groupId', 'name' ], 'required' ],
			[ [ 'value' ], 'safe' ],
            [ 'groupId', 'number', 'integerOnly' => true, 'min' => 1 ],
            [ 'name', 'alphanumhyphenspace' ],
            [ 'name', 'string', 'min'=>1, 'max'=>100 ]
        ];
    }

	public function attributeLabels() {

		return [
			'name' => 'Name',
			'value' => 'Value'
		];
	}

	// Static methods --------------------------------------------------

	// yii\db\ActiveRecord ----------------

	public static function tableName() {

		return CmnTables::TABLE_GROUP_META;
	}

	// UserMeta ---------------------------

	// Find

	public static function findByGroupId( $groupId ) {

		return self::find()->where( 'groupId=:id', [ ':id' => $groupId ] )->all();
	}

	// Delete

	public static function deleteByGroupId( $groupId ) {

		self::deleteAll( 'groupId=:id', [ ':id' => $groupId ] );
	}
}

?>