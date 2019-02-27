<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\admin\controllers\chat;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\resources\File;

use cmsgears\core\common\behaviors\ActivityBehavior;

/**
 * MessageController provides actions specific to chat messages.
 *
 * @since 1.0.0
 */
class MessageController extends \cmsgears\core\admin\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $type;

	protected $parentService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission = CmnGlobal::PERM_GROUP_ADMIN;

		// Config
		$this->type		= CoreGlobal::TYPE_DEFAULT;
		$this->apixBase	= 'community/chat/message';

		// Services
		$this->modelService		= Yii::$app->factory->get( 'chatMessageService' );
		$this->parentService	= Yii::$app->factory->get( 'chatService' );

		// Sidebar
		$this->sidebar = [ 'parent' => 'sidebar-community', 'child' => 'chat' ];

		// Return Url
		$this->returnUrl = Url::previous( 'chat-messages' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/chat/message/all' ], true );

		// All Url
		$allUrl = Url::previous( 'chats' );
		$allUrl = isset( $allUrl ) ? $allUrl : Url::toRoute( [ '/community/chat/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs = [
			'base' => [
				[ 'label' => 'Home', 'url' => Url::toRoute( '/dashboard' ) ],
				[ 'label' => 'Chats', 'url' =>  $allUrl ]
			],
			'all' => [ [ 'label' => 'Chat Messages' ] ],
			'create' => [ [ 'label' => 'Chat Messages', 'url' => $this->returnUrl ], [ 'label' => 'Create' ] ],
			'update' => [ [ 'label' => 'Chat Messages', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Chat Messages', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
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
					'index' => [ 'permission' => $this->crudPermission ],
					'all' => [ 'permission' => $this->crudPermission ],
					'create' => [ 'permission' => $this->crudPermission ],
					'update' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'index' => [ 'get', 'post' ],
					'all' => [ 'get' ],
					'create' => [ 'get', 'post' ],
					'update' => [ 'get', 'post' ],
					'delete' => [ 'get', 'post' ]
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

	// MessageController ---------------------

	public function actionAll( $pid ) {

		Url::remember( Yii::$app->request->getUrl(), 'chat-messages' );

		$modelClass = $this->modelService->getModelClass();

		$parent = $this->parentService->getById( $pid );

		if( isset( $parent ) ) {

			$dataProvider = $this->modelService->getPageByTypeChatId( CoreGlobal::TYPE_DEFAULT, $parent->id );

			return $this->render( 'all', [
				'dataProvider' => $dataProvider,
				'parent' => $parent
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionCreate( $pid ) {

		$modelClass = $this->modelService->getModelClass();

		$model	= new $modelClass;
		$parent = $this->parentService->getById( $pid );

		$model->chatId	= $parent->id;
		$model->type	= $this->type;

		$avatar	= File::loadFile( null, 'Avatar' );
		$banner	= File::loadFile( null, 'Banner' );
		$video	= File::loadFile( null, 'Video' );

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $model->validate() ) {

			$this->model = $this->modelService->add( $model, [
				'admin' => true,
				'avatar' => $avatar, 'banner' => $banner, 'video' => $video
			]);

			return $this->redirect( $this->returnUrl );
		}

		return $this->render( 'create', [
			'chat' => $parent,
			'model' => $model,
			'avatar' => $avatar,
			'banner' => $banner,
			'video' => $video
		]);
	}

	public function actionUpdate( $id, $pid ) {

		// Find Model
		$model = $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$modelClass = $this->modelService->getModelClass();

			$parent = $this->parentService->getById( $pid );

			$avatar	= File::loadFile( $model->avatar, 'Avatar' );
			$banner	= File::loadFile( $model->banner, 'Banner' );
			$video	= File::loadFile( $model->video, 'Video' );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $model->validate() ) {

				$this->model = $this->modelService->update( $model, [
					'admin' => true,
					'avatar' => $avatar, 'banner' => $banner, 'video' => $video
				]);

				return $this->redirect( $this->returnUrl );
			}

			return $this->render( 'update', [
				'chat' => $parent,
				'model' => $model,
				'avatar' => $avatar,
				'banner' => $banner,
				'video' => $video
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

			return $this->render( 'delete', [
				'chat' => $parent,
				'model' => $model,
				'avatar' => $model->avatar,
				'banner' => $model->banner,
				'video' => $model->video
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
