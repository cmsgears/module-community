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
 * MemberController provides actions specific to group members.
 *
 * @since 1.0.0
 */
class MemberController extends \cmsgears\community\admin\controllers\base\group\MemberController {

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
		$this->title	= 'Group Member';
		$this->apixBase	= 'community/group/member';
		$this->baseUrl	= 'room/member';

		// Services
		$this->parentService = Yii::$app->factory->get( 'groupService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-community', 'child' => 'group' ];

		// Return Url
		$this->returnUrl = Url::previous( 'group-members' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/group/member/all' ], true );

		// All Url
		$allUrl = Url::previous( 'groups' );
		$allUrl = isset( $allUrl ) ? $allUrl : Url::toRoute( [ '/community/group/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ],
				[ 'label' => 'Groups', 'url' =>  $allUrl ]
			],
			'all' => [ [ 'label' => 'Group Members' ] ],
			'create' => [ [ 'label' => 'Group Members', 'url' => $this->returnUrl ], [ 'label' => 'Create' ] ],
			'update' => [ [ 'label' => 'Group Members', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Group Members', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// MemberController ----------------------

	public function actionAll( $pid ) {

		Url::remember( Yii::$app->request->getUrl(), 'group-members' );

		return parent::actionAll( $pid );
	}

}
