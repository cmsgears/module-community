<?php
namespace cmsgears\cms\admin\models\forms;

// Yii Imports
use \Yii;
use yii\helpers\ArrayHelper;

class WidgetForm extends \cmsgears\core\common\models\forms\JsonModel {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $classPath;
	public $data;

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
			[ [ 'classPath', 'data' ], 'safe' ]
		];

		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'classPath' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// WidgetForm ----------------------------
}
