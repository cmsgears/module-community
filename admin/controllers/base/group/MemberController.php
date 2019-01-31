<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\admin\controllers\base\group;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\resources\File;

use cmsgears\core\common\behaviors\ActivityBehavior;

/**
 * MemberController provides actions specific to group members.
 *
 * @since 1.0.0
 */
abstract class MemberController extends \cmsgears\core\admin\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $title;

	// Protected --------------

	protected $parentService;

	protected $userService;
	protected $memberService;

	protected $roleService;

	protected $superRoleId;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Views
		$this->setViewPath( '@cmsgears/module-community/admin/views/group/member' );

		// Permission
		$this->crudPermission = CmnGlobal::PERM_GROUP_ADMIN;

		// Services
		$this->modelService = Yii::$app->factory->get( 'groupMemberService' );

		$this->parentService = Yii::$app->factory->get( 'groupService' );

		$this->userService		= Yii::$app->factory->get( 'userService' );
		$this->memberService	= Yii::$app->factory->get( 'siteMemberService' );

		$this->roleService	= Yii::$app->factory->get( 'roleService' );

		// Super Admin
		$superRole = $this->roleService->getBySlugType( CoreGlobal::ROLE_SUPER_ADMIN, CoreGlobal::TYPE_SYSTEM );

		$this->superRoleId = isset( $superRole ) ?$superRole->id : null;
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
					'index'	 => [ 'permission' => $this->crudPermission ],
					'all'  => [ 'permission' => $this->crudPermission ],
					'create'  => [ 'permission' => $this->crudPermission ],
					'update'  => [ 'permission' => $this->crudPermission ],
					'delete'  => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'index' => [ 'get', 'post' ],
					'all'  => [ 'get' ],
					'create'  => [ 'get', 'post' ],
					'update'  => [ 'get', 'post' ],
					'delete'  => [ 'get', 'post' ]
				]
			],
			'activity' => [
				'class' => ActivityBehavior::class,
				'admin' => true,
				'create' => [ 'create' ],
				'update' => [ 'update' ],
				'delete' => [ 'delete' ]
			]
		];
	}

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// MemberController ----------------------

	public function actionAll( $pid ) {

		$modelClass = $this->modelService->getModelClass();

		$parent = $this->parentService->getById( $pid );

		if( isset( $parent ) ) {

			$dataProvider = $this->modelService->getPageByGroupId( $parent->id );

			$roleMap = $this->roleService->getIdNameMapByType( CmnGlobal::TYPE_COMMUNITY );

			return $this->render( 'all', [
				'dataProvider' => $dataProvider,
				'parent' => $parent,
				'statusMap' => $modelClass::$statusMap,
				'roleMap' => $roleMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionCreate( $pid ) {

		$modelClass = $this->modelService->getModelClass();

		$model	= new $modelClass;
		$parent = $this->parentService->getById( $pid );

		$user	= $this->userService->getModelObject();
		$member	= $this->memberService->getModelObject();
		$avatar	= File::loadFile( null, 'Avatar' );

		$model->groupId = $parent->id;

		$user->setScenario( 'create' );

		$member->siteId = Yii::$app->core->siteId;

		$mloaded = $model->load( Yii::$app->request->post(), $model->getClassName() );
		$uloaded = $user->load( Yii::$app->request->post(), $user->getClassName() );
		$sloaded = $member->load( Yii::$app->request->post(), $member->getClassName() );

		if( $model->registerUser ) {

			$model->setScenario( 'register' );
		}
		else {

			$model->setScenario( 'create' );
		}

		if( $mloaded && $model->validate() ) {

			if( $model->registerUser ) {

				if( $uloaded && $sloaded && $user->validate() && $member->validate() ) {

					$this->model = $this->modelService->add( $model, [ 'admin' => true, 'avatar' => $avatar, 'group' => $parent, 'user' => $user, 'member' => $member ] );

					return $this->redirect( $this->returnUrl );
				}
			}
			else {

				$this->model = $this->modelService->add( $model, [ 'admin' => true, 'avatar' => $avatar ] );

				return $this->redirect( $this->returnUrl );
			}
		}

		$roleMap = $this->roleService->getIdNameMapByType( CmnGlobal::TYPE_COMMUNITY );

		$siteRoleMap = $this->roleService->getIdNameMapByType( CoreGlobal::TYPE_SYSTEM );

		unset( $siteRoleMap[ $this->superRoleId ] );

		return $this->render( 'create', [
			'group' => $parent,
			'model' => $model,
			'user' => $user,
			'member' => $member,
			'avatar' => $avatar,
			'statusMap' => $modelClass::$statusMap,
			'roleMap' => $roleMap,
			'siteRoleMap' => $siteRoleMap
		]);
	}

	public function actionUpdate( $id, $pid ) {

		// Find Model
		$model = $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$modelClass = $this->modelService->getModelClass();

			$parent = $this->parentService->getById( $pid );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $model->validate() ) {

				$this->model = $this->modelService->update( $model, [ 'admin' => true ] );

				return $this->redirect( $this->returnUrl );
			}

			$roleMap = $this->roleService->getIdNameMapByType( CmnGlobal::TYPE_COMMUNITY );

			return $this->render( 'update', [
				'group' => $parent,
				'model' => $model,
				'statusMap' => $modelClass::$statusMap,
				'roleMap' => $roleMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id, $pid ) {

		// Find Model
		$model = $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$modelClass = $this->modelService->getModelClass();

			$parent = $this->parentService->getById( $pid );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				try {

					$this->model = $model;

					$this->modelService->delete( $model, [ 'admin' => true ] );

					return $this->redirect( $this->returnUrl );
				}
				catch( Exception $e ) {

					throw new HttpException( 409, Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_DEPENDENCY )  );
				}
			}

			$roleMap = $this->roleService->getIdNameMapByType( CmnGlobal::TYPE_COMMUNITY );

			return $this->render( 'delete', [
				'group' => $parent,
				'model' => $model,
				'statusMap' => $modelClass::$statusMap,
				'roleMap' => $roleMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
