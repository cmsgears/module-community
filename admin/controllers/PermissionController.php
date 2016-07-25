<?php
namespace cmsgears\community\admin\controllers;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

class PermissionController extends \cmsgears\core\admin\controllers\base\PermissionController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->crudPermission 	= CmnGlobal::PERM_COMMUNITY;
		$this->sidebar 			= [ 'parent' => 'sidebar-community', 'child' => 'permission' ];

		$this->type			= CmnGlobal::TYPE_COMMUNITY;

		$this->returnUrl	= Url::previous( 'permissions' );
		$this->returnUrl	= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/permission/all' ], true );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PermissionController ------------------

	public function actionAll() {

		Url::remember( [ 'permission/all' ], 'permissions' );

		return parent::actionAll();
	}
}
