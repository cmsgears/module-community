<?php
namespace cmsgears\cms\common\models\forms;

// Yii Imports
use \Yii;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

class BlockElement extends \cmsgears\core\common\models\forms\JsonModel {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $element;
	public $elementId;
	public $htmlOptions;
	public $order;

	public $name; // used for update

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
			[ [ 'elementId', 'htmlOptions', 'order' ], 'safe' ],
			[ 'element', 'boolean' ],
			[ 'order', 'number', 'integerOnly' => true ]
		];

		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'htmlOptions' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	public function attributeLabels() {

		return [
			'elementId' => Yii::$app->cmsMessage->getMessage( CmsGlobal::FIELD_ELEMENT ),
			'htmlOptions' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_HTML_OPTIONS ),
			'order' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ORDER )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// BlockElement --------------------------
}
