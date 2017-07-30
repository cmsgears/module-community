<?php
namespace cmsgears\cms\frontend\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore;
use cmsgears\cms\common\config\CmsGlobal;

class PostController extends \cmsgears\cms\frontend\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $templateService;

	protected $categoryService;
	protected $tagService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->crudPermission	= CoreGlobal::PERM_USER;

		$this->layout			= WebGlobalCore::LAYOUT_PUBLIC;

		$this->modelService		= Yii::$app->factory->get( 'postService' );

		$this->templateService	= Yii::$app->factory->get( 'templateService' );

		$this->categoryService	= Yii::$app->factory->get( 'categoryService' );
		$this->tagService		= Yii::$app->factory->get( 'tagService' );
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
					// secure actions
					'all' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'all' => [ 'get' ],
					'search' => [ 'get' ],
					'category' => [ 'get' ],
					'tag' => [ 'get' ],
					'single' => [ 'get' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	public function actions() {

		if ( !Yii::$app->user->isGuest ) {

			$this->layout	= WebGlobalCore::LAYOUT_PRIVATE;
		}

		return [
			'error' => [
				'class' => 'yii\web\ErrorAction'
			]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostController ------------------------

	public function actionAll( $status = null ) {

		$this->layout	= WebGlobalCore::LAYOUT_PRIVATE	;

		$user			= Yii::$app->user->getIdentity();
		$dataProvider 	= null;

		if( isset( $user ) ) {

			$dataProvider = $this->modelService->getPageByOwnerId( $user->id );

			// TODO: Get data provider for status using textual representation of status

			return $this->render( 'all', [
				 'dataProvider' => $dataProvider,
				 'status' => $status
			]);
		}
	}

	public function actionSearch() {

		$user			= Yii::$app->user->getIdentity();
		$template		= $this->templateService->getBySlugType( CmsGlobal::TEMPLATE_POST, CmsGlobal::TYPE_POST );

		if( isset( $template ) ) {

			$dataProvider	= $this->modelService->getPageForSearch([
									'route' => 'blog/search', 'searchContent' => true,
									'searchCategory' => true, 'searchTag' => true
								]);

			return Yii::$app->templateManager->renderViewSearch( $template, [
				'dataProvider' => $dataProvider
			]);
		}

		// Error - Template not defined
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
	}

	public function actionCategory( $slug ) {

		$category	= $this->categoryService->getBySlugType( $slug, CmsGlobal::TYPE_POST );

		if( isset( $category ) ) {

			$user			= Yii::$app->user->getIdentity();
			$content		= $category->modelContent;
			$template		= $content->template;

			// Fallback to default template
			if( empty( $template ) ) {

				$template = $this->templateService->getBySlugType( CmsGlobal::TEMPLATE_POST, CmsGlobal::TYPE_POST );
			}

			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewCategory( $template, [
					'category' => $category
				]);
			}

			// Error - Template not defined
			throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Error- Post not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionTag( $slug ) {

		$tag	= $this->tagService->getBySlugType( $slug, CmsGlobal::TYPE_POST );

		if( isset( $tag ) ) {

			$user		= Yii::$app->user->getIdentity();
			$template	= null;

			if( isset( $tag->modelContent ) ) {

				$content	= $tag->modelContent;
				$template	= $content->template;
			}

			// Fallback to default template
			if( empty( $template ) ) {

				$template	= $this->templateService->getBySlugType( CmsGlobal::TEMPLATE_POST, CmsGlobal::TYPE_POST );
			}

			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewTag( $template, [
					'tag' => $tag
				]);
			}

			// Error - Template not defined
			throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Error- Post not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionSingle( $slug ) {

		$post	= $this->modelService->getBySlugType( $slug, CmsGlobal::TYPE_POST );

		if( isset( $post ) ) {

			if( !$post->isPublished() ) {

				// Error- Not allowed
				throw new UnauthorizedHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_ALLOWED ) );
			}

			// Find post template
			$content	= $post->modelContent;
			$template	= $content->template;

			// Fallback to default template for blog posts in case no post is assigned
			if( empty( $template ) ) {

				$template = $this->templateService->getBySlugType( CmsGlobal::TEMPLATE_POST, CmsGlobal::TYPE_POST );
			}

			// Render post using template
			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewPublic( $template, [
					'page' => $post,
					'author' => $post->createdBy,
					'content' => $content,
					'banner' => $content->banner
				], [ 'page' => true ] );
			}

			// Error - Template not defined
			throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Error- Post not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
