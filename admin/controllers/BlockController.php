<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\File;
use cmsgears\cms\common\models\forms\BlockElement;

class BlockController extends \cmsgears\core\admin\controllers\base\CrudController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $templateService;
	protected $elementService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission	= CmsGlobal::PERM_BLOG_ADMIN;

		// Services
		$this->modelService		= Yii::$app->factory->get( 'blockService' );
		$this->templateService	= Yii::$app->factory->get( 'templateService' );
		$this->elementService	= Yii::$app->factory->get( 'elementService' );

		// Sidebar	
		$this->sidebar			= [ 'parent' => 'sidebar-cms', 'child' => 'block' ];

		// Return Url
		$this->returnUrl		= Url::previous( 'blocks' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/block/all' ], true );
		
		// Breadcrumbs
		$this->breadcrumbs		= [
			'all' => [ [ 'label' => 'Blocks' ] ],
			'create' => [ [ 'label' => 'Blocks', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Blocks', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Blocks', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'items' => [ [ 'label' => 'Blocks', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// BlockController -----------------------

	public function actionAll() {

		Url::remember( Yii::$app->request->getUrl(), 'blocks' );

		$dataProvider = $this->modelService->getPage();

		return $this->render( 'all', [
			 'dataProvider' => $dataProvider
		]);
	}

	public function actionCreate() {

		$modelClass		= $this->modelService->getModelClass();
		$model			= new $modelClass;
		$model->siteId	= Yii::$app->core->siteId;
		$banner			= File::loadFile( $model->banner, 'Banner' );
		$video			= File::loadFile( $model->video, 'Video' );
		$texture		= File::loadFile( $model->texture, 'Texture' );
		$elements		= $this->elementService->getIdNameList();

		// Block Elements
		$blockElements	= [];

		for ( $i = 0, $j = count( $elements ); $i < $j; $i++ ) {

			$blockElements[] = new BlockElement();
		}

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $model->validate() ) {

			$create = true;

			if( count( $blockElements ) > 0 ) {

				if( BlockElement::loadMultiple( $blockElements, Yii::$app->request->post(), 'BlockElement' ) && BlockElement::validateMultiple( $blockElements ) ) {

					$create = true;
				}
				else {

					$create = false;
				}
			}

			if( $create ) {

				$this->modelService->create( $model, [ 'banner' => $banner, 'video' => $video, 'texture' => $texture ] );

				$this->modelService->updateElements( $model, $blockElements );
				
				return $this->redirect( "update?id=$model->id" );
			}
		}

		$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_BLOCK, [ 'default' => true ] );

		return $this->render( 'create', [
			'model' => $model,
			'banner' => $banner,
			'video' => $video,
			'texture' => $texture,
			'templatesMap' => $templatesMap,
			'elements' => $elements,
			'blockElements' => $blockElements
		]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$banner			= File::loadFile( $model->banner, 'Banner' );
			$video			= File::loadFile( $model->video, 'Video' );
			$texture		= File::loadFile( $model->texture, 'Texture' );
			$elements		= $this->elementService->getIdNameList();
			$blockElements	= $this->modelService->getElementsForUpdate( $model, $elements );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $model->validate() ) {

				$update = true;

				if( count( $blockElements ) > 0 ) {

					if( BlockElement::loadMultiple( $blockElements, Yii::$app->request->post(), 'BlockElement' ) && BlockElement::validateMultiple( $blockElements ) ) {

						$update = true;
					}
					else {

						$update = false;
					}
				}

				if( $update ) {

					$this->modelService->update( $model, [ 'banner' => $banner, 'video' => $video, 'texture' => $texture ] );

					$this->modelService->updateElements( $model, $blockElements );

					return $this->redirect( "update?id=$model->id" );
				}
			}

			$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_BLOCK, [ 'default' => true ] );

			return $this->render( 'update', [
				'model' => $model,
				'banner' => $banner,
				'video' => $video,
				'texture' => $texture,
				'templatesMap' => $templatesMap,
				'elements' => $elements,
				'blockElements' => $blockElements
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

			$elements		= $this->elementService->getIdNameList();
			$blockElements	= $this->modelService->getElementsForUpdate( $model, $elements );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				$this->modelService->delete( $model );

				return $this->redirect( $this->returnUrl );
			}

			$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_ELEMENT, [ 'default' => true ] );

			return $this->render( 'delete', [
				'model' => $model,
				'banner' => $model->banner,
				'video' => $model->video,
				'texture' => $model->texture,
				'templatesMap' => $templatesMap,
				'elements' => $elements,
				'blockElements' => $blockElements
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
