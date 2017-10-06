<?php
namespace cmsgears\community\admin\controllers\group;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

class MessageController extends BaseMessageController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

		return [
			'rbac' => [
				'class' => Yii::$app->cmgCore->getRbacFilterClass(),
				'actions' => [
					'all' => [ 'permission' => CmnGlobal::PERM_GROUP ],
					'delete' => [ 'permission' => CmnGlobal::PERM_GROUP ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'all'    => [ 'get' ],
					'delete' => [ 'get', 'post' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// MessageController----------------------

	public function actionAll( $id ) {

		return parent::actionAll( $id, [ 'parent' => 'sidebar-group', 'child' => 'group' ] );
	}

	public function actionDelete( $gid, $id ) {

		return parent::actionDelete( $gid, $id, [ 'parent' => 'sidebar-group', 'child' => 'group' ] );
	}
}
