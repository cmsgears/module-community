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
use cmsgears\cms\common\models\forms\Link;
use cmsgears\cms\common\models\forms\PageLink;

class MenuController extends \cmsgears\core\admin\controllers\base\CrudController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $pageService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission	= CmsGlobal::PERM_BLOG_ADMIN;

		// Service
		$this->modelService		= Yii::$app->factory->get( 'menuService' );

		$this->pageService		= Yii::$app->factory->get( 'pageService' );

		// Sidebar
		$this->sidebar			= [ 'parent' => 'sidebar-cms', 'child' => 'menu' ];

		// Return Url
		$this->returnUrl		= Url::previous( 'menus' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/menu/all' ], true );
		
		// Breadcrumbs
		$this->breadcrumbs		= [
			'all' => [ [ 'label' => 'Menu' ] ],
			'create' => [ [ 'label' => 'Menu', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Menu', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Menu', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'items' => [ [ 'label' => 'Menu', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// MenuController ------------------------

	public function actionAll() {

		Url::remember( Yii::$app->request->getUrl(), 'menus' );

		return parent::actionAll();
	}

	public function actionCreate() {

		$modelClass		= $this->modelService->getModelClass();
		$model			= new $modelClass;
		$model->siteId	= Yii::$app->core->siteId;
		$model->type	= CmsGlobal::TYPE_MENU;
		$model->data	= "{ \"links\": {} }";
		$pages			= $this->pageService->getIdNameList();

		// Menu Pages
		$pageLinks	= [];

		for ( $i = 0, $j = count( $pages ); $i < $j; $i++ ) {

			$pageLinks[] = new PageLink();
		}

		// Menu Links
		$links	= [];

		for ( $i = 0; $i < 6; $i++ ) {

			$links[] = new Link();
		}

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) &&
			Link::loadMultiple( $links, Yii::$app->request->post(), 'Link' ) && PageLink::loadMultiple( $pageLinks, Yii::$app->request->post(), 'PageLink' ) &&
			$model->validate() && Link::validateMultiple( $links ) && PageLink::validateMultiple( $pageLinks ) ) {

			$this->modelService->create( $model );

			$this->modelService->updateLinks( $model, $links, $pageLinks );

			return $this->redirect( "update?id=$model->id" );
		}

		return $this->render( 'create', [
			'model' => $model,
			'pages' => $pages,
			'links' => $links,
			'pageLinks' => $pageLinks
		]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$pages		= $this->pageService->getIdNameList();
			$links		= $this->modelService->getLinks( $model );
			$pageLinks	= $this->modelService->getPageLinksForUpdate( $model, $pages );

			Link::loadMultiple( $links, Yii::$app->request->post(), 'Link' );

			if( count( $links ) < 5 ) {

				for( $i = 0; $i < 4; $i++ ) {

					$links[]	= new Link();
				}
			}

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) &&
				Link::loadMultiple( $links, Yii::$app->request->post(), 'Link' ) && PageLink::loadMultiple( $pageLinks, Yii::$app->request->post(), 'PageLink' ) &&
				$model->validate() && Link::validateMultiple( $links ) && PageLink::validateMultiple( $pageLinks ) ) {

				$this->modelService->update( $model );

				$this->modelService->updateLinks( $model, $links, $pageLinks );

				return $this->redirect( "update?id=$model->id" );
			}

			return $this->render( 'update', [
				'model' => $model,
				'pages' => $pages,
				'links' => $links,
				'pageLinks' => $pageLinks
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

			$pages		= $this->pageService->getIdNameList();
			$links		= $this->modelService->getLinks( $model );
			$pageLinks	= $this->modelService->getPageLinksForUpdate( $model, $pages );

			return $this->render( 'delete', [
				'model' => $model,
				'pages' => $pages,
				'links' => $links,
				'pageLinks' => $pageLinks
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
