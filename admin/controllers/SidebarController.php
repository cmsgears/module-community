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
use cmsgears\cms\common\models\forms\SidebarWidget;

class SidebarController extends \cmsgears\core\admin\controllers\base\CrudController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $widgetService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permissions
		$this->crudPermission	= CmsGlobal::PERM_BLOG_ADMIN;

		// Services
		$this->modelService		= Yii::$app->factory->get( 'sidebarService' );
		$this->widgetService	= Yii::$app->factory->get( 'widgetService' );

		// Sidebar
		$this->sidebar			= [ 'parent' => 'sidebar-cms', 'child' => 'sdebar' ];

		// Return Url
		$this->returnUrl		= Url::previous( 'sidebars' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/sidebar/all' ], true );
		
		// Breadcrumbs
		$this->breadcrumbs		= [
			'all' => [ [ 'label' => 'Sidebar' ] ],
			'create' => [ [ 'label' => 'Sidebar', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Sidebar', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Sidebar', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'items' => [ [ 'label' => 'Sidebar', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SidebarController ---------------------

	public function actionAll() {

		Url::remember( Yii::$app->request->getUrl(), 'sidebars' );

		return parent::actionAll();
	}

	public function actionCreate() {

		$modelClass		= $this->modelService->getModelClass();
		$model			= new $modelClass;
		$model->siteId	= Yii::$app->core->siteId;
		$model->type	= CmsGlobal::TYPE_SIDEBAR;
		$model->data	= "{ \"widgets\": {} }";
		$widgets		= $this->widgetService->getIdNameList();

		// Sidebar Widgets
		$sidebarWidgets	= [];

		for ( $i = 0, $j = count( $widgets ); $i < $j; $i++ ) {

			$sidebarWidgets[] = new SidebarWidget();
		}

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && SidebarWidget::loadMultiple( $sidebarWidgets, Yii::$app->request->post(), 'SidebarWidget' ) &&
			$model->validate() && SidebarWidget::validateMultiple( $sidebarWidgets ) ) {

			$this->modelService->create( $model );

			$this->modelService->updateWidgets( $model, $sidebarWidgets );

			return $this->redirect( "update?id=$model->id" );
		}

		return $this->render( 'create', [
			'model' => $model,
			'widgets' => $widgets,
			'sidebarWidgets' => $sidebarWidgets
		]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$widgets		= $this->modelService->getIdNameList();
			$sidebarWidgets	= $this->modelService->getWidgetsForUpdate( $model, $widgets );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && SidebarWidget::loadMultiple( $sidebarWidgets, Yii::$app->request->post(), 'SidebarWidget' ) &&
				$model->validate() && SidebarWidget::validateMultiple( $sidebarWidgets ) ) {

				$this->modelService->update( $model );

				$this->modelService->updateWidgets( $model, $sidebarWidgets );

				return $this->redirect( "update?id=$model->id" );
			}

			return $this->render( 'update', [
				'model' => $model,
				'widgets' => $widgets,
				'sidebarWidgets' => $sidebarWidgets
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

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				$this->modelService->delete( $model );

				return $this->redirect( $this->returnUrl );
			}

			$widgets		= $this->modelService->getIdNameList();
			$sidebarWidgets	= $this->modelService->getWidgetsForUpdate( $model, $widgets );

			return $this->render( 'delete', [
				'model' => $model,
				'widgets' => $widgets,
				'sidebarWidgets' => $sidebarWidgets
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
