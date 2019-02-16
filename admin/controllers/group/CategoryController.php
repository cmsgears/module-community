<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\admin\controllers\group;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

/**
 * CategoryController provides actions specific to group categories.
 *
 * @since 1.0.0
 */
class CategoryController extends \cmsgears\cms\admin\controllers\base\CategoryController {

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
		$this->title		= 'Group';
		$this->type			= CmnGlobal::TYPE_GROUP;
		$this->templateType	= CmnGlobal::TYPE_GROUP;
		$this->apixBase		= 'community/group/category';
		$this->parentPath	= '/community/group/category';

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-community', 'child' => 'group-category' ];

		// Return Url
		$this->returnUrl = Url::previous( 'group-categories' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/group/category/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ]
			],
			'all' => [ [ 'label' => 'Group Categories' ] ],
			'create' => [ [ 'label' => 'Group Categories', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Group Categories', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Group Categories', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'gallery' => [ [ 'label' => 'Group Categories', 'url' => $this->returnUrl ], [ 'label' => 'Gallery' ] ],
			'data' => [ [ 'label' => 'Group Categories', 'url' => $this->returnUrl ], [ 'label' => 'Data' ] ],
			'config' => [ [ 'label' => 'Group Categories', 'url' => $this->returnUrl ], [ 'label' => 'Config' ] ],
			'settings' => [ [ 'label' => 'Group Categories', 'url' => $this->returnUrl ], [ 'label' => 'Settings' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// CategoryController --------------------

	public function actionAll( $config = [] ) {

		Url::remember( Yii::$app->request->getUrl(), 'group-categories' );

		return parent::actionAll( $config );
	}

}
