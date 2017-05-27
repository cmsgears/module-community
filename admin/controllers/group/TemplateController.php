<?php
namespace cmsgears\community\admin\controllers\group;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

class TemplateController extends \cmsgears\core\admin\controllers\base\TemplateController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->sidebar 			= [ 'parent' => 'sidebar-community', 'child' => 'group-template' ];

		$this->crudPermission 	= CmnGlobal::PERM_GROUP;

		$this->type				= CmnGlobal::TYPE_GROUP;

		$this->returnUrl		= Url::previous( 'templates' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/group/template/all' ], true );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TemplateController --------------------

	public function actionAll() {

		Url::remember( [ 'group/template/all' ], 'templates' );

		return parent::actionAll();
	}
}
