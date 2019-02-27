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
use cmsgears\community\common\config\CmnGlobal;

class GroupController extends \cmsgears\community\admin\controllers\base\GroupController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permissions
		$this->crudPermission = CmnGlobal::PERM_GROUP_ADMIN;

		// Config
		$this->type			= CmnGlobal::TYPE_GROUP;
		$this->templateType	= CmnGlobal::TYPE_GROUP;
		$this->apixBase		= 'community/group';
		$this->title		= 'Group';

		// Services
		$this->modelService	= Yii::$app->factory->get( 'groupService' );
		$this->metaService	= Yii::$app->factory->get( 'groupMetaService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-community', 'child' => 'group' ];

		// Return Url
		$this->returnUrl = Url::previous( 'groups' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/group/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ]
			],
			'all' => [ [ 'label' => 'Groups' ] ],
			'create' => [ [ 'label' => 'Groups', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Groups', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Groups', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'gallery' => [ [ 'label' => 'Groups', 'url' => $this->returnUrl ], [ 'label' => 'Gallery' ] ],
			'review' => [ [ 'label' => 'Groups', 'url' => $this->returnUrl ], [ 'label' => 'Review' ] ],
			'data' => [ [ 'label' => 'Groups', 'url' => $this->returnUrl ], [ 'label' => 'Data' ] ],
			'attributes' => [ [ 'label' => 'Groups', 'url' => $this->returnUrl ], [ 'label' => 'Attributes' ] ],
			'config' => [ [ 'label' => 'Groups', 'url' => $this->returnUrl ], [ 'label' => 'Config' ] ],
			'settings' => [ [ 'label' => 'Groups', 'url' => $this->returnUrl ], [ 'label' => 'Settings' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// GroupController -----------------------

	public function actionAll( $config = [] ) {

		Url::remember( Yii::$app->request->getUrl(), 'groups' );

		return parent::actionAll( $config );
	}

}
