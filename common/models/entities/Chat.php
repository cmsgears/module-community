<?php
namespace cmsgears\community\common\models\entities;

// Yii Imports
use \Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\community\common\models\base\CmnTables;

use cmsgears\core\common\behaviors\AuthorBehavior;

/**
 * Chat Entity
 *
 * @property int $id
 * @property int $createdBy
 * @property int $modifiedBy
 * @property string $sessionId
 * @property integer $status
 * @property date $createdAt
 * @property date $modifiedAt
 */
class Chat extends \cmsgears\core\common\models\base\CmgEntity {

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

    /**
     * @inheritdoc
     */
    public function behaviors() {

        return [

			'authorBehavior' => [
				'class' => AuthorBehavior::className()
			],
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
            [ [ 'sessionId' ], 'required' ],
			[ [ 'id', 'status' ], 'safe' ],
			[ [ 'createdBy', 'modifiedBy' ], 'number', 'integerOnly' => true, 'min' => 1 ],
            [ [ 'createdAt', 'modifiedAt' ], 'date', 'format' => Yii::$app->formatter->datetimeFormat ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'sessionId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_SESSION ),
			'status' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_STATUS )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmnTables::TABLE_CHAT;
	}

	// Chat ------------------------------

}

?>