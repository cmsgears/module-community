<?php
namespace cmsgears\cms\common\utilities;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

/**
 * This utility can be used to find page name and other details for both Core and CMS modules.
 */
class ContentUtil {

	/**
	 * The method can be utilised by the Layouts for SEO purpose. It allows options to override default module and controller used for system pages.
	 * @param $view - The current view being rendered by controller.
	 * @param $module - The module to be considered for system pages.
	 * @param $controller - The site controller provided by given module to be considered for system pages.
	 * @return array having SEO related details.
	 */
	public static function initPage( $view, $config = [] ) {

		$page = self::findViewPage( $view, $config );

		if( isset( $page ) ) {

			$coreProperties				= $view->context->getCoreProperties();

			$content					= $page->modelContent;

			// Page and Content
			$view->params[ 'page' ]		= $page;
			$view->params[ 'content' ]	= $content;

			// SEO H1 - Page Summary
			$view->params[ 'summary' ]	= $content->summary;

			// SEO Meta Tags - Description, Keywords, Robot Text
			$view->params[ 'desc' ]		= isset( $content->seoDescription ) ? $content->seoDescription : $page->description;
			$view->params[ 'keywords' ]	= $content->seoKeywords;
			$view->params[ 'robot' ]	= $content->seoRobot;

			// SEO - Page Title
			$siteTitle					= $coreProperties->getSiteTitle();

			if( isset( $content->seoName ) && strlen( $content->seoName ) > 0 ) {

				$view->title		= $content->seoName . " | " . $siteTitle;
			}
			else if( isset( $page->name ) && strlen( $page->name ) > 0 ) {

				$view->title		= $page->name . " | " . $siteTitle;
			}
			else {

				$view->title		= $siteTitle;
			}
		}
	}

	public static function initFormPage( $view, $config = [] ) {

		$controller		= isset( $config[ 'module' ] ) ? $config[ 'controller' ] : 'site';
		$type			= isset( $config[ 'type' ] ) ? $config[ 'type' ] : CoreGlobal::TYPE_SITE;

		$form			= null;

		if( isset( Yii::$app->request->queryParams[ 'slug' ] ) ) {

			$slug	= Yii::$app->request->queryParams[ 'slug' ];
			$form	= Yii::$app->factory->get( 'formService' )->getBySlugType( $slug, $type );
		}

		if( isset( $form ) ) {

			$coreProperties				= $view->context->getCoreProperties();

			// Form
			$view->params[ 'form' ]		= $form;

			// SEO H1 - Page Summary
			$view->params[ 'summary' ]	= $form->description;

			// SEO Meta Tags - Description, Keywords, Robot Text
			$view->params[ 'desc' ]		= $form->description;

			// SEO - Page Title
			$siteTitle					= $coreProperties->getSiteTitle();

			if( isset( $form->name ) && strlen( $form->name ) > 0 ) {

				$view->title		= $form->name . " | " . $siteTitle;
			}
			else {

				$view->title		= $siteTitle;
			}
		}
	}

	/**
	 * The method can be utilised by the Layouts for SEO purpose. It can be used for models using content to render model pages apart from standard cms pages.
	 * @param $view - The current view being rendered by controller.
	 * @return array having SEO related details.
	 */
	public static function initModelPage( $view, $config = [] ) {

		$typed		= isset( $config[ 'typed' ] ) ? $config[ 'typed' ] : true;
		$service	= $config[ 'service' ];
		$service	= Yii::$app->factory->get( $service );

		$type		= isset( $config[ 'type' ] ) ? $config[ 'type' ] : $service->getParentType();

		$slug		= Yii::$app->request->queryParams[ 'slug' ];

		$model		= null;

		if( $typed ) {

			$model = $service->getBySlugType( $slug, $type );
		}
		else {

			$model = $service->getBySlug( $slug );
		}

		if( isset( $model ) ) {

			$coreProperties				= $view->context->getCoreProperties();

			$content					= isset( $model->modelContent ) ? $model->modelContent : null;
			$description				= isset( $model->description ) ? $model->description : null;

			// Page and Content
			$view->params[ 'model' ]	= $model;
			$view->params[ 'content' ]	= $content;

			// SEO H1 - Page Summary
			$view->params[ 'summary' ]	= isset( $content ) ? $content->summary : $description;

			// SEO Meta Tags - Description, Keywords, Robot Text
			$view->params[ 'desc' ]		= isset( $content ) ? $content->seoDescription : $description;
			$view->params[ 'keywords' ]	= isset( $content ) ? $content->seoKeywords : null;
			$view->params[ 'robot' ]	= isset( $content ) ? $content->seoRobot : null;

			// SEO - Page Title
			$siteTitle					= $coreProperties->getSiteTitle();

			if( isset( $content ) && isset( $content->seoName ) && strlen( $content->seoName ) > 0 ) {

				$view->title		= $content->seoName . " | " . $siteTitle;
			}
			else if( isset( $model->name ) && strlen( $model->name ) > 0 ) {

				$view->title		= $model->name . " | " . $siteTitle;
			}
			else {

				$view->title		= $siteTitle;
			}
		}
	}

	/**
	 * It returns page info to be used for system pages. We can decorate system pages using either this method or standard blocks using block widget.
	 * @return array - page details including content, author and banner.
	 */
	public static function getPageInfo( $view, $module = 'core', $controller = 'site' ) {

		$page = self::findViewPage( $view, $module, $controller );

		if( isset( $page ) ) {

			$info				= [];
			$info[ 'page' ]		= $page;
			$info[ 'content' ]	= $page->modelContent;

			return $info;
		}

		return null;
	}

	/**
	 * @return Page based on given slug
	 */
	public static function getPage( $slug, $type = CmsGlobal::TYPE_PAGE ) {

		return Yii::$app->factory->get( 'pageService' )->getBySlugType( $slug, $type );
	}

	/**
	 * It returns page summary to be used in page blocks on other pages.
	 * @return string - page summary
	 */
	public static function getPageSummary( $config = [] ) {

		if( isset( $config[ 'slug' ] ) ) {

			$slug	= $config[ 'slug' ];
			$type	= isset( $config[ 'type' ] ) ? $config[ 'type' ] : CmsGlobal::TYPE_PAGE;
			$page	= Yii::$app->factory->get( 'pageService' )->getBySlugType( $slug, $type );
		}

		if( isset( $config[ 'page' ] ) ) {

			$page	= $config[ 'page' ];
		}

		if( isset( $page ) ) {

			$limit			= isset( $config[ 'limit' ] ) ? $config[ 'limit' ] : null;
			$ellipsis		= isset( $config[ 'ellipsis' ] ) ? $config[ 'ellipsis' ] : true;

			$coreProperties	= Yii::$app->controller->getCoreProperties();
			$slugUrl		= Url::toRoute( "/$page->slug" );
			$summary		= $page->modelContent->summary;

			$summary		= isset( $limit ) && strlen( $summary ) > $limit ? substr( $summary, 0, $limit ) : $page->modelContent->summary;
			$summary		= $ellipsis ? "$summary ..." : $summary;
			$summary	    = "<div class='page-summary'>$summary</div>";
			$summary	   .= "<div class='page-link'><a class='btn btn-medium' href='$slugUrl'>Read More</a></div>";

			return $summary;
		}

		return '';
	}

	/**
	 * It returns page full content to be used in page blocks on other pages.
	 * @return string - page content
	 */
	public static function getPageContent( $config = [] ) {

		if( isset( $config[ 'slug' ] ) ) {

			$slug	= $config[ 'slug' ];
			$type	= $config[ 'type' ];
			$page	= Yii::$app->factory->get( 'pageService' )->getBySlugType( $slug, $type );
		}

		if( isset( $config[ 'page' ] ) ) {

			$page	= $config[ 'page' ];
		}

		if( isset( $page ) ) {

			$content	= $page->modelContent;
			$content	= $content->content;
			$content   .= "<div class='page-content'>$content</div>";

			return $content;
		}

		return '';
	}

	public static function findViewPage( $view, $config = [] ) {

		$module			= isset( $config[ 'module' ] ) ? $config[ 'module' ] : 'core';
		$controller		= isset( $config[ 'module' ] ) ? $config[ 'controller' ] : 'site';
		$type			= isset( $config[ 'type' ] ) ? $config[ 'type' ] : CmsGlobal::TYPE_POST;

		$moduleName		= $view->context->module->id;
		$controllerName	= Yii::$app->controller->id;
		$actionName		= Yii::$app->controller->action->id;

		$page			= null;

		// System/Public Pages - Landing, Login, Register, Confirm Account, Activate Account, Forgot Password, Reset Password
		if( strcmp( $moduleName, $module ) == 0 && strcmp( $controllerName, $controller ) == 0 ) {

			if( strcmp( $actionName, 'index' ) == 0 ) {

				$page	= self::getPage( 'home' );
			}
			else {

				$page	= self::getPage( $actionName );
			}
		}
		// Blog/CMS Pages
		else if( isset( Yii::$app->request->queryParams[ 'slug' ] ) ) {

			$page	= self::getPage( Yii::$app->request->queryParams[ 'slug' ], $type );
		}

		return $page;
	}
}
