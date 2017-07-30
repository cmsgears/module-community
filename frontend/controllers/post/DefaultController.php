<?php
namespace cmsgears\cms\frontend\controllers\post;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\entities\Post;
use cmsgears\cms\common\models\resources\ModelContent;
use cmsgears\cms\common\models\entities\Page;
use cmsgears\core\common\models\resources\File;
use cmsgears\cms\common\models\resources\ContentMeta;

class DefaultController extends \cmsgears\cms\frontend\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $basePath;

	// Protected --------------

	protected $templateService;

	protected $categoryService;
	protected $tagService;

	protected $modelContentService;
	protected $modelCategoryService;

	protected $contentMetaService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->basePath	 		= 'post/default';
		$this->crudPermission	= CoreGlobal::PERM_USER;

		$this->layout			= WebGlobalCore::LAYOUT_PUBLIC;

		$this->modelService			= Yii::$app->factory->get( 'postService' );

		$this->templateService		= Yii::$app->factory->get( 'templateService' );

		$this->categoryService		= Yii::$app->factory->get( 'categoryService' );
		$this->tagService			= Yii::$app->factory->get( 'tagService' );

		$this->modelContentService	= Yii::$app->factory->get( 'modelContentService' );
		$this->modelCategoryService	= Yii::$app->factory->get( 'modelCategoryService' );

		$this->contentMetaService	= Yii::$app->factory->get( 'contentMetaService' );
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
					'add' => [ 'permission' => $this->crudPermission ],
					'basic' => [ 'permission' => $this->crudPermission ],
					'media' => [ 'permission' => $this->crudPermission ],
					'settings' => [ 'permission' => $this->crudPermission ],
					'attribute' => [ 'permission' => $this->crudPermission ],
					'review' => [ 'permission' => $this->crudPermission ],
				]
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'basic' => [ 'get','post' ],
					'info' => [ 'get','post' ],
					'media' => [ 'get','post' ],
					'settings' => [ 'get','post' ],
					'attribute' => [ 'get','post' ],
					'review' => [ 'get', 'post' ],
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

	public function actionAdd() {

		$model				= new Post();
		$model->siteId		= Yii::$app->core->siteId;
		$model->comments	= false;

		$content			= new ModelContent();

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $model->validate() && $content->load(Yii::$app->request->post(),'ModelContent' ) && $content->getClassName() ) {

			$model->status	= Post::STATUS_BASIC;

			$this->modelService->register( $model, [ 'publish' => $model->isActive(), 'content' => $content ] );

			return $this->checkRefresh( $model );
		}

		$visibilityMap	= Page::$visibilityMap;

		return $this->render( 'reg/basic', [
			'model' => $model, 'content' => $content,
			'visibilityMap' => $visibilityMap
		]);
	}

	public function actionBasic( $slug ) {

		$model	= $this->modelService->getBySlug( $slug, true );

		if( $model ) {

			$content		= $model->modelContent;
			$visibilityMap	= Page::$visibilityMap;

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
				$model->validate() && $content->validate() ) {

				$this->modelService->update( $model, [ 'admin' => true ] );

				$this->modelContentService->update( $content, [ 'publish' => $model->isActive(), 'banner' => $banner, 'video' => $video ] );
			}

			return $this->render( 'reg/basic', [
	    		'model' => $model,
				'content' => $content,
				'visibilityMap' => $visibilityMap,
	    	]);
		}
	}

	public function actionMedia( $slug ) {

		$model	= $this->modelService->getBySlug( $slug, true );

		if( $model ) {

			$content	= $model->modelContent;
			$banner		= File::loadFile( $content->banner, 'Banner' );
			$video		= File::loadFile( $content->video, 'Video' );

			if(   $content->validate() ) {

				if( $model->status <= Post::STATUS_MEDIA ) {

					$this->modelService->updateStatus( $model, Post::STATUS_MEDIA );
				}

				$this->modelService->update( $model );

				$this->modelContentService->update( $content, [ 'publish' => $model->isActive(), 'banner' => $banner, 'video' => $video ] );

				//$this->modelCategoryService->bindCategories( $model->id, CmsGlobal::TYPE_POST );

				//return $this->redirect( $this->returnUrl );
			}

			return $this->render( 'reg/media', [
	    		'model' => $model,
				'content' => $content,
				'banner' => $banner,
				'video' => $video,
	    	]);
		}

	}

	public function actionSettings( $slug ) {

		$model	= $this->modelService->getBySlug( $slug, true );
		if( $model ) {

			$content	= $model->modelContent;
			if( $content->load( Yii::$app->request->post(), $content->getClassName()) && $content->validate()  ) {

				$this->modelContentService->update( $content, [ 'publish' => $model->isActive()] );

				$this->modelCategoryService->bindCategories( $model->id, CmsGlobal::TYPE_POST );
			}
			return $this->render( 'reg/settings', [
	    		'model' => $model,
				'content' => $content,
	    	]);
		}

	}

	public function actionAttributes( $slug ) {

		$model	= $this->modelService->getBySlug( $slug, true );

		if( $model ) {


			//return var_dump($this->contentMetaService->getModelClass());

			$metasToLoad	= [];
			$metas			= Yii::$app->request->post( 'ContentMeta' );
			$count 			= count( $metas );

			// Create models if form submitted

			if( $count > 0 ) {

				$metas	= array_values( $metas );

				foreach ( $metas as $meta ) {

					$metasToLoad[]	= $this->getUserMeta( $model, $meta );
				}
			} else {

				$metasToLoad	= $this->contentMetaService->getByType( $model->id, CoreGlobal::META_TYPE_USER );
			}

			if( count( $metasToLoad ) == 0 ) {

				$metasToLoad[]	= $this->getUserMeta( $model );
			}
			//return var_dump(Yii::$app->request->post('ContentMeta'));
			if( $count > 0 && ContentMeta::loadMultiple( $metasToLoad, Yii::$app->request->post(), 'ContentMeta' )
					&& ContentMeta::validateMultiple( $metasToLoad ) ) {

				// Update attributes
				$this->contentMetaService->updateMultiple( $metasToLoad, [ 'parent' => $model ] );
				//return var_dump($model->status);

				if( $model->status < Post::STATUS_ATTRIBUTES ) {

					return $this->updateStatus( $model, Post::STATUS_ATTRIBUTES );
				}
			}

			//return var_dump($modelMeta);
			return $this->render( 'reg/attributes', [
	    		'model' => $model,
				'metas' => $metasToLoad,
	    	]);
		}

	}

	public function actionReview( $slug ) {

		$model	= $this->modelService->getBySlug( $slug, true );

		if( $model ) {

			$content	= $post->modelContent;

			$metasToLoad	= [];

			$metasToLoad	= $this->contentMetaService->getByType( $model->id, CoreGlobal::META_TYPE_USER );


			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $model->validate() ) {

				// Update Listing Status
				if( $model->status < Post::STATUS_SUBMITTED ) {

					$this->modelService->updateStatus( $model, Post::STATUS_SUBMITTED );

					// Send admin notification for new listing.
					//$this->modelService->sendNewListingNotification( $model );

					$model->refresh();

					//$dataCache =  $this->modelService->cacheDb( $model, [ 'controller' => $this, 'process' => true ] );
				}
				else if( $model->isRejected() ) {

					$this->modelService->updateStatus( $model, Post::STATUS_RE_SUBMIT );

					// Send admin notification for re-submit listing.
					//$this->modelService->sendResubmitNotification( $model );
				}
				else if( $model->isFrojen() || $model->isBlocked() ) {

					Yii::$app->listingMailer->sendActivationRequestMail( $model );

					if( $model->isFrojen() ) {

						$this->modelService->updateStatus( $model, Post::STATUS_UPLIFT_FREEZE );

						// Send admin notification for uplift freeze.
						//$this->modelService->sendUpliftFreezeNotification( $model );
					}

					if( $model->isBlocked() ) {

						$this->modelService->updateStatus( $model, Post::STATUS_UPLIFT_BLOCK );

						// Send admin notification for uplift block.
						//$this->modelService->sendUpliftBlockNotification( $model );
					}
				}

				return $this->refresh();
			}

			return $this->render( 'reg/review', [
	    		'model' => $model,
				'content' => $content,
				'metas' => $metasToLoad,

	    	]);
		}

	}

	// State Handling ---------

	protected function checkStatus( $post ) {

		$slug	= $post->slug;

		switch( $listing->status ) {

			case Post::STATUS_BASIC: {

				return $this->redirect( [ "$this->basePath/info?slug=$slug" ] );
			}

			case Post::STATUS_SETTINGS: {

				return $this->redirect( [ "$this->basePath/attributes?slug=$slug" ] );
			}
			case Post::STATUS_ATTRIBUTES: {

				return $this->redirect( [ "$this->basePath/review?slug=$slug" ] );
			}
			case Post::STATUS_REJECTED: {

				return $this->redirect( [ "$this->basePath/review?slug=$slug" ] );
			}
			case Post::STATUS_RE_SUBMIT: {

				return $this->redirect( [ "$this->basePath/basic?slug=$slug" ] );
			}
			default: {

				return $this->redirect( [ "$this->basePath/info?slug=$slug" ] );
			}
		}
	}

	/**
	 * Check whether listing is under review. It will disable the registration tabs if status is new.
	 */
	protected function checkEditable( $post ) {

		if( !$listing->isEditable() ) {

			Yii::$app->getResponse()->redirect( [ "$this->basePath/review?slug=$listing->slug" ] )->send();
		}
	}

	/**
	 * Check whether listing is being registered and redirect user to the last step filled by user.
	 */
	protected function checkRefresh( $post ) {

		if( $post->isRegistration() ) {

			return $this->checkStatus( $post );
		}

		return $this->refresh();
	}

	/**
	 * Update listing status and redirect to the last step filled by user.
	 */
	protected function updateStatus( $post, $status ) {

		// Update Listing Status
		$this->modelService->updateStatus( $post, $status );

		return $this->checkStatus( $post );
	}

	protected function getUserMeta( $post, $meta = null ) {

		$postMeta		=  $this->contentMetaService->getModelClass();
		$metaToLoad		= new $postMeta;

		if( isset( $meta ) && isset( $meta[ 'id' ] ) && $meta[ 'id' ] > 0 ) {

			$metaToLoad	= $this->contentMetaService->findByNameType( $post->id, $meta[ 'name' ], CoreGlobal::META_TYPE_USER );
		}

		$metaToLoad->modelId	= $post->id;
		$metaToLoad->type		= CoreGlobal::META_TYPE_USER;
		$metaToLoad->valueType	= $postMeta::VALUE_TYPE_TEXT;

		return $metaToLoad;
	}
}
