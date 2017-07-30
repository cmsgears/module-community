<?php
namespace cmsgears\cms\common\components;

// Yii Imports
use Yii;

class Cms extends \yii\base\Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	/**
	 * Initialise the CMG Core Component.
	 */
	public function init() {

		parent::init();

		// Register application components and objects i.e. CMG and Project
		$this->registerComponents();
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Cms -----------------------------------

	// Properties

	// Components and Objects

	public function registerComponents() {

		// Init system services
		$this->initSystemServices();

		// Register services
		$this->registerResourceServices();
		$this->registerMapperServices();
		$this->registerEntityServices();

		// Init services
		$this->initResourceServices();
		$this->initMapperServices();
		$this->initEntityServices();
	}

	public function initSystemServices() {

		$factory = Yii::$app->factory->getContainer();

		//$factory->set( '<name>', '<classpath>' );
	}

	public function registerResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\cms\common\services\interfaces\resources\IContentMetaService', 'cmsgears\cms\common\services\resources\ContentMetaService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\resources\IModelContentService', 'cmsgears\cms\common\services\resources\ModelContentService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\resources\ICategoryService', 'cmsgears\cms\common\services\resources\CategoryService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\resources\ITagService', 'cmsgears\cms\common\services\resources\TagService' );
	}

	public function registerMapperServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\cms\common\services\interfaces\mappers\IModelCategoryService', 'cmsgears\cms\common\services\mappers\ModelCategoryService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\mappers\IModelTagService', 'cmsgears\cms\common\services\mappers\ModelTagService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\mappers\IModelBlockService', 'cmsgears\cms\common\services\mappers\ModelBlockService' );
	}

	public function registerEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\IElementService', 'cmsgears\cms\common\services\entities\ElementService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\IBlockService', 'cmsgears\cms\common\services\entities\BlockService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\IPageService', 'cmsgears\cms\common\services\entities\PageService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\IPostService', 'cmsgears\cms\common\services\entities\PostService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\IMenuService', 'cmsgears\cms\common\services\entities\MenuService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\ISidebarService', 'cmsgears\cms\common\services\entities\SidebarService' );
		$factory->set( 'cmsgears\cms\common\services\interfaces\entities\IWidgetService', 'cmsgears\cms\common\services\entities\WidgetService' );
	}

	public function initResourceServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'contentMetaService', 'cmsgears\cms\common\services\resources\ContentMetaService' );
		$factory->set( 'modelContentService', 'cmsgears\cms\common\services\resources\ModelContentService' );
		$factory->set( 'categoryService', 'cmsgears\cms\common\services\resources\CategoryService' );
		$factory->set( 'tagService', 'cmsgears\cms\common\services\resources\TagService' );
	}

	public function initMapperServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'modelCategoryService', 'cmsgears\cms\common\services\mappers\ModelCategoryService' );
		$factory->set( 'modelTagService', 'cmsgears\cms\common\services\mappers\ModelTagService' );
		$factory->set( 'modelBlockService', 'cmsgears\cms\common\services\mappers\ModelBlockService' );
	}

	public function initEntityServices() {

		$factory = Yii::$app->factory->getContainer();

		$factory->set( 'elementService', 'cmsgears\cms\common\services\entities\ElementService' );
		$factory->set( 'blockService', 'cmsgears\cms\common\services\entities\BlockService' );
		$factory->set( 'pageService', 'cmsgears\cms\common\services\entities\PageService' );
		$factory->set( 'postService', 'cmsgears\cms\common\services\entities\PostService' );
		$factory->set( 'menuService', 'cmsgears\cms\common\services\entities\MenuService' );
		$factory->set( 'sidebarService', 'cmsgears\cms\common\services\entities\SidebarService' );
		$factory->set( 'widgetService', 'cmsgears\cms\common\services\entities\WidgetService' );
	}
}
