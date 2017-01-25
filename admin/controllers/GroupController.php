<?php
namespace cmsgears\community\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\resources\File;
use cmsgears\cms\common\models\resources\ModelContent;
use cmsgears\community\common\models\entities\Group;

class GroupController extends \cmsgears\core\admin\controllers\base\CrudController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $templateService;
	protected $modelContentService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->crudPermission 		= CmnGlobal::PERM_GROUP;
		$this->modelService			= Yii::$app->factory->get( 'groupService' );
		$this->templateService		= Yii::$app->factory->get( 'templateService' );
		$this->modelContentService	= Yii::$app->factory->get( 'modelContentService' );
		$this->sidebar 				= [ 'parent' => 'sidebar-community', 'child' => 'group' ];

		$this->returnUrl		= Url::previous( 'groups' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/group/all' ], true );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// GroupController -----------------------

	public function actionAll() {

		Url::remember( [ 'group/all' ], 'groups' );

		$dataProvider = $this->modelService->getPage();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionCreate() {

		$modelClass			= $this->modelService->getModelClass();
		$model				= new $modelClass;
		$model->type		= CoreGlobal::TYPE_SITE;
		$content			= new ModelContent();
		$avatar	 			= File::loadFile( null, 'Avatar' );
		$banner	 			= File::loadFile( null, 'Banner' );
		$video	 			= File::loadFile( null, 'Video' );

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
			$model->validate() && $content->validate() ) {

			$this->modelService->create( $model, [ 'admin' => true, 'avatar' => $avatar ] );

			$this->modelContentService->create( $content, [ 'parent' => $model, 'parentType' => CmnGlobal::TYPE_GROUP, 'publish' => true, 'banner' => $banner, 'video' => $video ] );

			return $this->redirect( $this->returnUrl );
		}

		$visibilityMap	= Group::$visibilityMap;
		$statusMap		= Group::$statusMap;
		$templatesMap	= $this->templateService->getIdNameMapByType( CmnGlobal::TYPE_GROUP, [ 'default' => true ] );

    	return $this->render( 'create', [
    		'model' => $model,
    		'content' => $content,
    		'avatar' => $avatar,
    		'banner' => $banner,
    		'video' => $video,
    		'visibilityMap' => $visibilityMap,
	    	'statusMap' => $statusMap,
    		'templatesMap' => $templatesMap
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$content	= $model->modelContent;
			$avatar	 	= File::loadFile( $model->avatar, 'Avatar' );
			$banner	 	= File::loadFile( $content->banner, 'Banner' );
			$video	 	= File::loadFile( $content->video, 'Video' );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
				$model->validate() && $content->validate() ) {

				$this->modelService->update( $model, [ 'admin' => true, 'avatar' => $avatar ] );

				$this->modelContentService->update( $content, [ 'publish' => true, 'banner' => $banner, 'video' => $video ] );

				return $this->redirect( $this->returnUrl );
			}

			$visibilityMap	= Group::$visibilityMap;
			$statusMap		= Group::$statusMap;
			$templatesMap	= $this->templateService->getIdNameMapByType( CmnGlobal::TYPE_GROUP, [ 'default' => true ] );

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'content' => $content,
	    		'avatar' => $avatar,
	    		'banner' => $banner,
	    		'video' => $video,
	    		'visibilityMap' => $visibilityMap,
		    	'statusMap' => $statusMap,
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

			$content	= $model->modelContent;

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				$this->modelService->delete( $model );

				$this->modelContentService->delete( $content );

				return $this->redirect( $this->returnUrl );
			}

			$visibilityMap	= Post::$visibilityMap;
			$statusMap		= Post::$statusMap;
			$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_POST, [ 'default' => true ] );

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'content' => $content,
	    		'banner' => $content->banner,
	    		'video' => $content->video,
	    		'visibilityMap' => $visibilityMap,
	    		'statusMap' => $statusMap,
	    		'templatesMap' => $templatesMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
