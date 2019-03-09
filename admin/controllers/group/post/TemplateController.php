<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\admin\controllers\group\post;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

/**
 * TemplateController provide actions specific to group templates.
 *
 * @since 1.0.0
 */
class TemplateController extends \cmsgears\core\admin\controllers\base\TemplateController {

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
		$this->title	= 'Group Post';
		$this->type		= CmnGlobal::TYPE_GROUP_POST;
		$this->apixBase	= 'community/group/post/template';

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-community', 'child' => 'group-post-template' ];

		// Return Url
		$this->returnUrl = Url::previous( 'group-post-templates' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/group/post/template/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ]
			],
			'all' => [ [ 'label' => 'Group Post Templates' ] ],
			'create' => [ [ 'label' => 'Group Post Templates', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Group Post Templates', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Group Post Templates', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TemplateController --------------------

	public function actionAll( $config = [] ) {

		Url::remember( Yii::$app->request->getUrl(), 'group-post-templates' );

		return parent::actionAll( $config );
	}

}
