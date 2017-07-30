<?php
namespace cmsgears\cms\admin\controllers\post;

// Yii Imports
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;
use cmsgears\core\common\models\resources\Gallery;

class GalleryController extends \cmsgears\core\admin\controllers\base\GalleryController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $postService;

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->sidebar		= [ 'parent' => 'sidebar-cms', 'child' => 'post' ];

		$this->returnUrl	= Url::previous( 'posts' );
		$this->returnUrl	= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/post/all/' ], true );

		$this->postService	= Yii::$app->factory->get( 'postService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// GalleryController ---------------------

	public function actionAll() {

		// Remember return url for crud
		Url::remember( [ 'post/all' ], 'posts' );

		return parent::actionAll();
	}

	public function actionItems( $postId, $galleryId = null ) {

		$gallery	= null;

		if( $galleryId != null ) {

			$gallery	= $this->modelService->getById( $galleryId);
		}
		else {

			$post				= $this->postService->getById( $postId );
			$galleryModel		= new Gallery();
			$galleryModel->name	= $post->name;

			// Create Model Gallery and Gallery
			$modelGallery	= Yii::$app->factory->get( 'modelGalleryService' )->create( $galleryModel, [

										'parentId'	=> $postId,
										'parentType' => CmsGlobal::TYPE_PAGE
								] );

			$galleryModel->refresh();

			if( isset( $galleryModel->id ) ) {

				$galleryId	= $galleryModel->id;

				// Update post galleryId
				$this->postService->updateGalleryId( $post, $galleryId );
				return $this->redirect( "items?postId=$postId&galleryId=$galleryId" );
			}
		}

		// Update/Render if exist
		if( $gallery != null ) {

			return $this->render( 'items', [
				'gallery' => $gallery,
				'items' => $gallery->files
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
