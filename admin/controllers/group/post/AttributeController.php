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
 * AttributeController provides actions specific to post attributes.
 *
 * @since 1.0.0
 */
class AttributeController extends \cmsgears\core\admin\controllers\base\AttributeController {

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
		$this->title	= 'Post Attribute';
		$this->apixBase	= 'community/group/post/attribute';

		// Services
		$this->modelService		= Yii::$app->factory->get( 'groupPostMetaService' );
		$this->parentService	= Yii::$app->factory->get( 'groupPostService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-community', 'child' => 'group' ];

		// Return Url
		$this->returnUrl = Url::previous( 'group-post-attributes' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/group/post/attribute/all' ], true );

		// All Url
		$allUrl = Url::previous( 'group-posts' );
		$allUrl = isset( $allUrl ) ? $allUrl : Url::toRoute( [ '/community/group/post/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ],
				[ 'label' => 'Posts', 'url' =>  $allUrl ]
			],
			'all' => [ [ 'label' => 'Post Attributes' ] ],
			'create' => [ [ 'label' => 'Post Attributes', 'url' => $this->returnUrl ], [ 'label' => 'Create' ] ],
			'update' => [ [ 'label' => 'Post Attributes', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Post Attributes', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// AttributeController -------------------

	public function actionAll( $pid ) {

		Url::remember( Yii::$app->request->getUrl(), 'group-post-attributes' );

		return parent::actionAll( $pid );
	}

}
