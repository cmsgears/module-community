<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\ObjectData;
use cmsgears\cms\admin\models\forms\WidgetForm;

class WidgetController extends \cmsgears\core\admin\controllers\base\CrudController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $templateService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permissions
		$this->crudPermission	= CmsGlobal::PERM_BLOG_ADMIN;

		// Services
		$this->modelService		= Yii::$app->factory->get( 'widgetService' );

		$this->templateService	= Yii::$app->factory->get( 'templateService' );

		// Sidebar
		$this->sidebar			= [ 'parent' => 'sidebar-cms', 'child' => 'widget' ];

		// Return Url
		$this->returnUrl		= Url::previous( 'widgets' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/widget/all' ], true );
		
		// Breadcrumbs
		$this->breadcrumbs		= [
			'all' => [ [ 'label' => 'Widget' ] ],
			'create' => [ [ 'label' => 'Widget', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Widget', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Widget', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'items' => [ [ 'label' => 'Widget', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

		$behaviors	= parent::behaviors();

		$behaviors[ 'rbac' ][ 'actions' ][ 'settings' ] = [ 'permission' => $this->crudPermission ];

		$behaviors[ 'verbs' ][ 'actions' ][ 'settings' ] = [ 'get', 'post' ];

		return $behaviors;
	}

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// WidgetController ----------------------

	public function actionAll() {

		Url::remember( Yii::$app->request->getUrl(), 'widgets' );

		return parent::actionAll();
	}

	public function actionCreate() {

		$modelClass		= $this->modelService->getModelClass();
		$model			= new $modelClass;
		$model->siteId	= Yii::$app->core->siteId;
		$model->type	= CmsGlobal::TYPE_WIDGET;
		$meta			= new WidgetForm();

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $meta->load( Yii::$app->request->post(), 'WidgetForm' ) && $model->validate() ) {

			$this->modelService->create( $model, [ 'data' => $meta ] );

			return $this->redirect( "update?id=$model->id" );
		}

		$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_WIDGET, [ 'default' => true ] );

		return $this->render( 'create', [
			'model' => $model,
			'meta' => $meta,
			'templatesMap' => $templatesMap
		]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$meta	= new WidgetForm( $model->data );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $meta->load( Yii::$app->request->post(), 'WidgetForm' ) && $model->validate() ) {

				$this->modelService->update( $model, [ 'data' => $meta ] );

				return $this->redirect( "update?id=$model->id" );
			}

			$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_WIDGET, [ 'default' => true ] );

			return $this->render( 'update', [
				'model' => $model,
				'meta' => $meta,
				'templatesMap' => $templatesMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model		= $this->modelService->getById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$meta	= new WidgetForm( $model->data );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				$this->modelService->delete( $model );

				return $this->redirect( $this->returnUrl );
			}

			$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_WIDGET, [ 'default' => true ] );

			return $this->render( 'delete', [
				'model' => $model,
				'meta' => $meta,
				'templatesMap' => $templatesMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionSettings( $id ) {

		// Find Model
		$model	= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$meta	= new WidgetForm( $model->data );

			if( $meta->load( Yii::$app->request->post(), 'WidgetForm' ) ) {

				$this->modelService->update( $model, [ 'data' => $meta ] );

				return $this->redirect( $this->returnUrl );
			}

			return $this->render( 'settings', [
				'model' => $model,
				'meta' => $meta
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
