<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\admin\controllers\base;

// Yii Imports
use Yii;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\resources\File;

use cmsgears\core\common\behaviors\ActivityBehavior;

abstract class GroupController extends \cmsgears\core\admin\controllers\base\CrudController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $title;

	public $metaService;

	// Protected --------------

	protected $type;
	protected $templateType;
	protected $reviews;
	protected $prettyReview;

	protected $templateService;
	protected $modelContentService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Views
		$this->setViewPath( '@cmsgears/module-community/admin/views/group' );

		// Config
		$this->title		= 'Group';
		$this->reviews		= true;
		$this->prettyReview	= false;

		// Services
		$this->templateService		= Yii::$app->factory->get( 'templateService' );
		$this->modelContentService	= Yii::$app->factory->get( 'modelContentService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

		$behaviors = parent::behaviors();

		$behaviors[ 'rbac' ][ 'actions' ][ 'gallery' ] = [ 'permission' => $this->crudPermission ];
		$behaviors[ 'rbac' ][ 'actions' ][ 'data' ] = [ 'permission' => $this->crudPermission ];
		$behaviors[ 'rbac' ][ 'actions' ][ 'attributes' ] = [ 'permission' => $this->crudPermission ];
		$behaviors[ 'rbac' ][ 'actions' ][ 'config' ] = [ 'permission' => $this->crudPermission ];
		$behaviors[ 'rbac' ][ 'actions' ][ 'settings' ] = [ 'permission' => $this->crudPermission ];

		$behaviors[ 'verbs' ][ 'actions' ][ 'gallery' ] = [ 'get' ];
		$behaviors[ 'verbs' ][ 'actions' ][ 'data' ] = [ 'get', 'post' ];
		$behaviors[ 'verbs' ][ 'actions' ][ 'attributes' ] = [ 'get', 'post' ];
		$behaviors[ 'verbs' ][ 'actions' ][ 'config' ] = [ 'get', 'post' ];
		$behaviors[ 'verbs' ][ 'actions' ][ 'settings' ] = [ 'get', 'post' ];

		$behaviors[ 'activity' ] = [
			'class' => ActivityBehavior::class,
			'admin' => true,
			'create' => [ 'create' ],
			'update' => [ 'update' ],
			'delete' => [ 'delete' ]
		];

		return $behaviors;
	}

	// yii\base\Controller ----

	public function actions() {

		return [
			'gallery' => [ 'class' => 'cmsgears\cms\common\actions\regular\gallery\Browse' ],
			'data' => [ 'class' => 'cmsgears\cms\common\actions\data\data\Form' ],
			'attributes' => [ 'class' => 'cmsgears\cms\common\actions\data\attribute\Form' ],
			'config' => [ 'class' => 'cmsgears\cms\common\actions\data\config\Form' ],
			'settings' => [ 'class' => 'cmsgears\cms\common\actions\data\setting\Form' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// GroupController -----------------------

	public function actionAll( $config = [] ) {

		$modelClass = $this->modelService->getModelClass();

		$dataProvider = $this->modelService->getPageByType( $this->type );

		return $this->render( 'all', [
			'dataProvider' => $dataProvider,
			'visibilityMap' => $modelClass::$visibilityMap,
			'statusMap' => $modelClass::$statusMap
		]);
	}

	public function actionCreate( $config = [] ) {

		$modelClass = $this->modelService->getModelClass();

		$model = new $modelClass;

		$model->siteId	= Yii::$app->core->siteId;
		$model->type	= $this->type;
		$model->reviews	= $this->reviews;

		$content = $this->modelContentService->getModelObject();

		$avatar	= File::loadFile( null, 'Avatar' );
		$banner	= File::loadFile( null, 'Banner' );
		$video	= File::loadFile( null, 'Video' );

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
			$model->validate() && $content->validate() ) {

			$this->model = $this->modelService->add( $model, [
				'admin' => true, 'content' => $content,
				'avatar' => $avatar, 'banner' => $banner, 'video' => $video
			]);

			return $this->redirect( 'all' );
		}

		$templatesMap = $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

		return $this->render( 'create', [
			'model' => $model,
			'content' => $content,
			'avatar' => $avatar,
			'banner' => $banner,
			'video' => $video,
			'visibilityMap' => $modelClass::$visibilityMap,
			'statusMap' => $modelClass::$statusMap,
			'templatesMap' => $templatesMap
		]);
	}

	public function actionUpdate( $id, $config = [] ) {

		$modelClass = $this->modelService->getModelClass();

		// Find Model
		$model = $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$content = $model->modelContent;

			$avatar	= File::loadFile( $model->avatar, 'Avatar' );
			$banner	= File::loadFile( $content->banner, 'Banner' );
			$video	= File::loadFile( $content->video, 'Video' );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
				$model->validate() && $content->validate() ) {

				$this->model = $this->modelService->update( $model, [
					'admin' => true, 'content' => $content,
					'avatar' => $avatar, 'banner' => $banner, 'video' => $video
				]);

				return $this->redirect( $this->returnUrl );
			}

			$templatesMap = $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

			return $this->render( 'update', [
				'model' => $model,
				'content' => $content,
				'avatar' => $avatar,
				'banner' => $banner,
				'video' => $video,
				'visibilityMap' => $modelClass::$visibilityMap,
				'statusMap' => $modelClass::$statusMap,
				'templatesMap' => $templatesMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id, $config = [] ) {

		$modelClass = $this->modelService->getModelClass();

		// Find Model
		$model = $this->modelService->getById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$content = $model->modelContent;

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

			$templatesMap = $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

			return $this->render( 'delete', [
				'model' => $model,
				'content' => $content,
				'avatar' => $model->avatar,
				'banner' => $content->banner,
				'video' => $content->video,
				'visibilityMap' => $modelClass::$visibilityMap,
				'statusMap' => $modelClass::$statusMap,
				'templatesMap' => $templatesMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionReview( $id ) {

		$modelClass = $this->modelService->getModelClass();

		$model = $this->modelService->getById( $id );

		// Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				$status		= Yii::$app->request->post( 'status' );
				$email		= $this->modelService->getEmail( $model );
				$message	= Yii::$app->request->post( 'message' );

				switch( $status ) {

					case $modelClass::STATUS_SUBMITTED: {

						$this->modelService->approve( $model, $message );

						if( !empty( $email ) ) {

							Yii::$app->coreMailer->sendApproveMail( $model, $email, $message );
						}

						break;
					}
					case $modelClass::STATUS_REJECTED: {

						$this->modelService->reject( $model, $message );

						if( !empty( $email ) ) {

							Yii::$app->coreMailer->sendRejectMail( $model, $email, $message );
						}

						break;
					}
					case $modelClass::STATUS_FROJEN: {

						$this->modelService->freeze( $model, $message );

						if( !empty( $email ) ) {

							Yii::$app->coreMailer->sendFreezeMail( $model, $email, $message );
						}

						break;
					}
					case $modelClass::STATUS_BLOCKED: {

						$this->modelService->block( $model, $message );

						if( !empty( $email ) ) {

							Yii::$app->coreMailer->sendBlockMail( $model, $email, $message );
						}

						break;
					}
					case $modelClass::STATUS_ACTIVE: {

						$this->modelService->activate( $model );

						$model->updateDataMeta( CoreGlobal::DATA_APPROVAL_REQUEST, false );

						if( !empty( $email ) ) {

							Yii::$app->coreMailer->sendActivateMail( $model, $email );
						}
					}
				}

				$this->redirect( $this->returnUrl );
			}

			$content	= $model->modelContent;
			$template	= $content->template;

			if( $this->prettyReview && isset( $template ) ) {

				return Yii::$app->templateManager->renderViewAdmin( $template, [
					'model' => $model,
					'content' => $content,
					'userReview' => false
				], [ 'layout' => false ] );
			}
			else {

				$templatesMap = $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

				return $this->render( 'review', [
					'model' => $model,
					'content' => $content,
					'avatar' => $model->avatar,
					'banner' => $content->banner,
					'video' => $content->video,
					'visibilityMap' => $modelClass::$visibilityMap,
					'statusMap' => $modelClass::$statusMap,
					'templatesMap' => $templatesMap
				]);
			}
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
