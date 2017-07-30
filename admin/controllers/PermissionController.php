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

		// Permissions
		$this->crudPermission 	= CmnGlobal::PERM_COMMUNITY;

		// Sidebar
		$this->sidebar 			= [ 'parent' => 'sidebar-community', 'child' => 'permission' ];

		$this->type				= CmnGlobal::TYPE_COMMUNITY;

		// Return Url
		$this->returnUrl		= Url::previous( 'permissions' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/permission/all' ], true );
		
		// Breadcrumbs
		$this->breadcrumbs		= [
			'all' => [ [ 'label' => 'Permission' ] ],
			'create' => [ [ 'label' => 'Permission', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Permission', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Permission', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'items' => [ [ 'label' => 'Permission', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ]
		];
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

		Url::remember( Yii::$app->request->getUrl(), 'permissions' );

		return parent::actionAll();
	}
}
