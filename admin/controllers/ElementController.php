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
use cmsgears\core\common\models\resources\File;
use cmsgears\cms\admin\models\forms\ElementForm;

class ElementController extends \cmsgears\core\admin\controllers\base\CrudController {

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
		$this->modelService		= Yii::$app->factory->get( 'elementService' );
		$this->templateService	= Yii::$app->factory->get( 'templateService' );

		// Sidebar	
		$this->sidebar			= [ 'parent' => 'sidebar-cms', 'child' => 'element' ];

		// Return Url
		$this->returnUrl		= Url::previous( 'elements' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/element/all' ], true );
		
		// Breadcrumbs
		$this->breadcrumbs		= [
			'all' => [ [ 'label' => 'Elements' ] ],
			'create' => [ [ 'label' => 'Elements', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Elements', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Elements', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'items' => [ [ 'label' => 'Elements', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ElementController ---------------------

	public function actionAll() {

		Url::remember( [ 'element/all' ], 'elements' );

		return parent::actionAll();
	}

	public function actionCreate() {

		$modelClass		= $this->modelService->getModelClass();
		$model			= new $modelClass;
		$model->siteId	= Yii::$app->core->siteId;
		$model->type	= CmsGlobal::TYPE_ELEMENT;
		$banner			= File::loadFile( null, 'Banner' );
		$meta			= new ElementForm();

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $meta->load( Yii::$app->request->post(), 'ElementForm' ) && $model->validate() ) {

			$this->modelService->create( $model, [ 'data' => $meta, 'banner' => $banner ] );

			return $this->redirect( "update?id=$model->id" );
		}

		$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_ELEMENT, [ 'default' => true ] );

		return $this->render( 'create', [
			'model' => $model,
			'banner' => $banner,
			'meta' => $meta,
			'templatesMap' => $templatesMap
		]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$banner	= File::loadFile( $model->banner, 'Banner' );
			$meta	= new ElementForm( $model->data );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $meta->load( Yii::$app->request->post(), 'ElementForm' ) && $model->validate() ) {

				$this->modelService->update( $model, [ 'data' => $meta, 'banner' => $banner ] );

				return $this->redirect( "update?id=$model->id" );
			}

			$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_ELEMENT, [ 'default' => true ] );

			return $this->render( 'update', [
				'model' => $model,
				'banner' => $banner,
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

			$banner		= $model->banner;
			$meta		= new ElementForm( $model->data );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				$this->modelService->delete( $model, [ 'banner' => $banner ] );

				return $this->redirect( $this->returnUrl );
			}

			$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_ELEMENT, [ 'default' => true ] );

			return $this->render( 'delete', [
				'model' => $model,
				'banner' => $banner,
				'meta' => $meta,
				'templatesMap' => $templatesMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
