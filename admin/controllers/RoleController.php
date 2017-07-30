<?php
namespace cmsgears\community\admin\controllers;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

class RoleController extends \cmsgears\core\admin\controllers\base\RoleController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		// Permission
		$this->crudPermission 	= CmnGlobal::PERM_COMMUNITY;

		// Sidebar
		$this->sidebar 			= [ 'parent' => 'sidebar-community', 'child' => 'role' ];

		$this->type				= CmnGlobal::TYPE_COMMUNITY;

		// Return Url
		$this->returnUrl		= Url::previous( 'roles' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/role/all' ], true );
		
		// Breadcrumbs
		$this->breadcrumbs		= [
			'all' => [ [ 'label' => 'Role' ] ],
			'create' => [ [ 'label' => 'Role', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Role', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Role', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'items' => [ [ 'label' => 'Role', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// RoleController ------------------------

	public function actionAll() {

		Url::remember( Yii::$app->request->getUrl(), 'roles' );

		return parent::actionAll();
	}
	
}
