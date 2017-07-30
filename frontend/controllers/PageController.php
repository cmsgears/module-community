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

// TODO: Add options to allow user to configure template for search page. A default check in table might be the best option.

class PageController extends \cmsgears\cms\frontend\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $templateService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->layout			= WebGlobalCore::LAYOUT_PUBLIC;

		$this->modelService		= Yii::$app->factory->get( 'pageService' );

		$this->templateService	= Yii::$app->factory->get( 'templateService' );
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
				]
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
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

	// PageController ------------------------

	// Site Pages -------------

	/* 1. It finds the associated page for the given slug.
	 * 2. If page is found, the associated template will be used.
	 * 3. If no template found, the cmgcore module's SiteController will handle the request.
	 */
	public function actionSingle( $slug ) {

		$page	= $this->modelService->getBySlugType( $slug, CmsGlobal::TYPE_PAGE );

		if( isset( $page ) ) {

			if( !$page->isPublished() ) {

				// Error- No access
				throw new UnauthorizedHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_ACCESS ) );
			}

			// Find Template
			$content	= $page->modelContent;
			$template	= $content->template;

			// Fallback to default template
			if( empty( $template ) ) {

				$template = $this->templateService->getBySlugType( CmsGlobal::TEMPLATE_PAGE, CmsGlobal::TYPE_PAGE );
			}

			// Page using Template
			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewPublic( $template, [
					'page' => $page,
					'author' => $page->createdBy,
					'content' => $content,
					'banner' => $content->banner
				], [ 'page' => true ] );
			}

			// Page without Template - Redirect to System Pages
			return $this->redirect( 'site/' . $page->slug );
		}

		// Error- Page not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
