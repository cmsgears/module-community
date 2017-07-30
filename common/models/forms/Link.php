<?php
namespace cmsgears\cms\common\models\forms;

// Yii Imports
use \Yii;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

class Link extends \cmsgears\core\common\models\forms\JsonModel {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $address;
	public $label;
	public $htmlOptions;
	public $urlOptions;
	public $private;
	public $relative;
	public $icon;
	public $order;

	public $type;

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	public function rules() {

		$rules = [
			[ [ 'address', 'label', 'private', 'relative', 'htmlOptions', 'urlOptions', 'icon', 'order' ], 'safe' ],
			[ 'order', 'number', 'integerOnly' => true ]
		];

		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'address', 'label', 'private', 'relative', 'htmlOptions', 'urlOptions', 'icon', 'order' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	public function attributeLabels() {

		return [
			'address' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_LINK ),
			'label' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_LABEL ),
			'private' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_PRIVATE ),
			'relative' => Yii::$app->cmsMessage->getMessage( CmsGlobal::FIELD_URL_RELATIVE ),
			'htmlOptions' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_HTML_OPTIONS ),
			'icon' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ICON ),
			'order' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ORDER )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Link ----------------------------------

	public function isPublic() {

		if( isset( $this->private ) && $this->private ) {

			return false;
		}

		return true;
	}
}
