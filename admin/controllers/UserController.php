<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\admin\controllers;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

class UserController extends \cmsgears\core\admin\controllers\UserController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission = CmnGlobal::PERM_GROUP_ADMIN;

		// Config
		$this->type		= CoreGlobal::TYPE_USER;
		$this->apixBase	= 'community/user';

		// Sidebar
		$this->sidebar	= [ 'parent' => 'sidebar-community', 'child' => 'user' ];

		// Return Url
		$this->returnUrl = Url::previous( 'community-users' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/sfcore/user/user/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ]
			],
			'all' => [ [ 'label' => 'Users' ] ],
			'create' => [ [ 'label' => 'Users', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Users', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Users', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'gallery' => [ [ 'label' => 'Users', 'url' => $this->returnUrl ], [ 'label' => 'Gallery' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// UserController ------------------------

	public function actionAll( $config = [] ) {

		$this->setViewPath( '@cmsgears/module-community/admin/views/user' );

		Url::remember( Yii::$app->request->getUrl(), 'community-users' );

		$modelClass = $this->modelService->getModelClass();

		//$dataProvider = $this->modelService->getPageByType( $this->type );

		$dataProvider = $this->modelService->getPage();

		$roleMap = $this->roleService->getIdNameMapByType( CoreGlobal::TYPE_SYSTEM );

		return $this->render( 'all', [
			'dataProvider' => $dataProvider,
			'roleMap' => $roleMap,
			'statusMap' => $modelClass::$statusMap
		]);
	}

}
