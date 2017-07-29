<?php
namespace cmsgears\community\admin\controllers\group;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

class CategoryController extends \cmsgears\cms\admin\controllers\base\CategoryController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		// Permissions
		$this->crudPermission 	= CmnGlobal::PERM_GROUP;

		$this->type				= CmnGlobal::TYPE_GROUP;
		$this->templateType		= CmnGlobal::TYPE_GROUP;

		// Sidebar
		$this->sidebar 			= [ 'parent' => 'sidebar-community', 'child' => 'group-category' ];

		// Return Url
		$this->returnUrl		= Url::previous( 'categories' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/group/category/all' ], true );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// CategoryController --------------------

	public function actionAll() {

		Url::remember( Yii::$app->request->getUrl(), 'categories' );

		return parent::actionAll();
	}
}
