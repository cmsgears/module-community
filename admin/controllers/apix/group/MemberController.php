<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\admin\controllers\apix\group;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\behaviors\ActivityBehavior;

use cmsgears\core\common\utilities\AjaxUtil;

/**
 * MemberController provides actions specific to group member model.
 *
 * @since 1.0.0
 */
class MemberController extends \cmsgears\core\common\controllers\base\Controller {

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

		// Services
		$this->modelService = Yii::$app->factory->get( 'groupMemberService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

		return [
			'rbac' => [
				'class' => Yii::$app->core->getRbacFilterClass(),
				'actions' => [
					// Model
					'approve' => [ 'permission' => $this->crudPermission ],
					'toggle-block' => [ 'permission' => $this->crudPermission ],
					'terminate' => [ 'permission' => $this->crudPermission ],
					'bulk' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					// Model
					'approve' => [ 'post' ],
					'toggle-block' => [ 'post' ],
					'terminate' => [ 'post' ],
					'bulk' => [ 'post' ],
					'delete' => [ 'post' ],
					// Searching
					'auto-search' => [ 'post' ]
				]
			],
			'activity' => [
				'class' => ActivityBehavior::class,
				'admin' => true,
				'delete' => [ 'delete' ]
			]
		];
	}

	// yii\base\Controller ----

	public function actions() {

		return [
			// Model
			'approve' => [ 'class' => 'cmsgears\core\common\actions\approval\Approve' ],
			'toggle-block' => [ 'class' => 'cmsgears\core\common\actions\approval\ToggleBlock' ],
			'terminate' => [ 'class' => 'cmsgears\core\common\actions\approval\Terminate' ],
			'bulk' => [ 'class' => 'cmsgears\core\common\actions\grid\Bulk' ],
			'delete' => [ 'class' => 'cmsgears\core\common\actions\grid\Delete' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// MemberController ----------------------

	// Searching
	public function actionAutoSearch( $gid ) {

		$name	= Yii::$app->request->post( 'name' );
		$data	= $this->modelService->searchByGroupIdName( $gid, $name );

		// Trigger Ajax Success
		return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
	}

}
