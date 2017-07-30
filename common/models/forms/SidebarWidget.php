<?php
namespace cmsgears\cms\common\models\forms;

// Yii Imports
use \Yii;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

class SidebarWidget extends \cmsgears\core\common\models\forms\JsonModel {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $widget;
	public $widgetId;
	public $htmlOptions;
	public $icon;
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
			[ [ 'widgetId', 'htmlOptions', 'icon', 'order' ], 'safe' ],
			[ 'widget', 'boolean' ],
			[ 'order', 'number', 'integerOnly' => true ]
		];

		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'htmlOptions', 'icon' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	public function attributeLabels() {

		return [
			'widgetId' => Yii::$app->cmsMessage->getMessage( CmsGlobal::FIELD_WIDGET ),
			'htmlOptions' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_HTML_OPTIONS ),
			'icon' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ICON ),
			'order' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ORDER )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// SidebarWidget -------------------------
}
