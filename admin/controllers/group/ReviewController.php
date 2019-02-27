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

use cmsgears\core\common\models\resources\ModelComment;

/**
 * ReviewController provides actions specific to group reviews.
 *
 * @since 1.0.0
 */
class ReviewController extends \cmsgears\core\admin\controllers\base\CommentController {

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
		$this->parentType	= CmnGlobal::TYPE_GROUP;
		$this->commentType	= ModelComment::TYPE_REVIEW;
		$this->apixBase		= 'community/group/review';
		$this->parentUrl	= '/community/group/update?id=';
		$this->urlKey		= 'group-reviews';

		// Services
		$this->parentService = Yii::$app->factory->get( 'groupService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-community', 'child' => 'group-reviews' ];

		// Return Url
		$this->returnUrl = Url::previous( $this->urlKey );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/group/comment/all' ], true );

		// All Url
		$allUrl = Url::previous( 'groups' );
		$allUrl = isset( $allUrl ) ? $allUrl : Url::toRoute( [ '/community/group/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ],
				[ 'label' => 'Groups', 'url' =>  $allUrl ]
			],
			'all' => [ [ 'label' => 'Group Reviews' ] ],
			'create' => [ [ 'label' => 'Group Reviews', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Group Reviews', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Group Reviews', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ReviewController ----------------------

}
