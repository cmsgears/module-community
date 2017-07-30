<?php
namespace cmsgears\cms\common\models\forms;

// Yii Imports
use \Yii;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

class PageLink extends \cmsgears\core\common\models\forms\JsonModel {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $link;
	public $pageId;
	public $htmlOptions;
	public $urlOptions;
	public $icon;
	public $order;

	public $type;	// used by service for create
	public $name;	// used for update

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
			[ [ 'link', 'pageId', 'htmlOptions', 'urlOptions', 'icon', 'order' ], 'safe' ],
			[ 'order', 'number', 'integerOnly' => true ]
		];

		if( Yii::$app->core->trimFieldValue ) {

			$trim[] = [ [ 'link', 'htmlOptions', 'urlOptions', 'icon', 'order' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	public function attributeLabels() {

		return [
			'link' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_LINK ),
			'pageId' => Yii::$app->cmsMessage->getMessage( CmsGlobal::FIELD_PAGE ),
			'htmlOptions' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_HTML_OPTIONS ),
			'icon' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ICON ),
			'order' => Yii::$app->coreMessage->getMessage( CoreGlobal::FIELD_ORDER )
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// PageLink ------------------------------
}
