<?php
namespace cmsgears\cms\common\services\entities;

// Yii Imports
use Yii;
use yii\data\Sort;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\entities\Post;

use cmsgears\core\common\services\interfaces\resources\IFileService;
use cmsgears\cms\common\services\interfaces\entities\IPostService;
use cmsgears\cms\common\services\resources\ModelContentService;

use cmsgears\core\common\services\traits\ApprovalTrait;
use cmsgears\core\common\services\traits\NameTypeTrait;
use cmsgears\core\common\services\traits\SlugTypeTrait;

class PostService extends \cmsgears\cms\common\services\base\ContentService implements IPostService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\cms\common\models\entities\Post';

	public static $modelTable	= CmsTables::TABLE_PAGE;

	public static $parentType	= CmsGlobal::TYPE_POST;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $fileService;

	// Private ----------------

	// Traits ------------------------------------------------------

	use ApprovalTrait;
	use NameTypeTrait;
	use SlugTypeTrait;

	// Constructor and Initialisation ------------------------------

	public function __construct( IFileService $fileService, $config = [] ) {

		$this->fileService	= $fileService;

		parent::__construct( $config );
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostService ---------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$modelClass		= static::$modelClass;
		$modelTable		= static::$modelTable;

		// Sorting ----------

		$sort = new Sort([
			'attributes' => [
				'name' => [
					'asc' => [ 'name' => SORT_ASC ],
					'desc' => ['name' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'name',
				],
				'slug' => [
					'asc' => [ 'slug' => SORT_ASC ],
					'desc' => ['slug' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'name',
				],
				'visibility' => [
					'asc' => [ 'visibility' => SORT_ASC ],
					'desc' => ['visibility' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'visibility',
				],
				'status' => [
					'asc' => [ 'status' => SORT_ASC ],
					'desc' => ['status' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'status',
				],
				'template' => [
					'asc' => [ 'template' => SORT_ASC ],
					'desc' => ['template' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'template',
				],
				'cdate' => [
					'asc' => [ 'createdAt' => SORT_ASC ],
					'desc' => ['createdAt' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'cdate',
				],
				'pdate' => [
					'asc' => [ 'publishedAt' => SORT_ASC ],
					'desc' => ['publishedAt' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'pdate',
				],
				'udate' => [
					'asc' => [ 'updatedAt' => SORT_ASC ],
					'desc' => ['updatedAt' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'udate',
				]
			]
		]);

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		// Query ------------

		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'hasOne' ] = true;
		}
		
		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'query' ] = Post::queryWithAuthor();
		}

		// Filters ----------
		
		// Filter - Status
		$status	= Yii::$app->request->getQueryParam( 'status' );

		if( isset( $status ) && isset( $modelClass::$urlRevStatusMap[ $status ] ) ) {

			$config[ 'conditions' ][ "$modelTable.status" ]	= $modelClass::$urlRevStatusMap[ $status ];
		}
		// Searching --------

		$searchCol	= Yii::$app->request->getQueryParam( 'search' );

		if( isset( $searchCol ) ) {

			$search = [ 'name' => "$modelTable.name", 'desc' => "$modelTable.description", 'summary' => "$modelContentTable.summary", 'content' => "$modelContentTable.content" ];

			$config[ 'search-col' ] = $search[ $searchCol ];
		}

		// Reporting --------

		$config[ 'report-col' ]	= [ 'name' => "$modelTable.name", 'desc' => "$modelTable.description", 'summary' => "$modelContentTable.summary", 'content' => "$modelContentTable.content" ];

		// Result -----------

		$config[ 'conditions' ][ "$modelTable.type" ]	= CmsGlobal::TYPE_POST;

		return parent::getPage( $config );

	}

	public function getPublicPage( $config = [] ) {

		$config[ 'route' ] = isset( $config[ 'route' ] ) ? $config[ 'route' ] : 'blog';

		return parent::getPublicPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	public function getFeatured() {

		return Post::find()->where( 'featured=:featured', [ ':featured' => true ] )->all();
	}

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$model->type = CmsGlobal::TYPE_POST;

		if( !isset( $model->visibility ) ) {

			$model->visibility	= Post::VISIBILITY_PRIVATE;
		}

		return parent::create( $model, $config );
	}

	public function add( $model, $config = [] ) {

		$config[ 'admin' ]	= true;

		return $this->register( $model, $config );
	}

	public function register( $model, $config = [] ) {

		$content 	= $config[ 'content' ];

		$gallery	= isset( $config[ 'gallery' ] ) ? $config[ 'gallery' ] : false;
		$publish	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner 	= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$video 		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;

		$galleryService			= Yii::$app->factory->get( 'galleryService' );
		$modelContentService	= Yii::$app->factory->get( 'modelContentService' );
		$modelCategoryService	= Yii::$app->factory->get( 'modelCategoryService' );

		$transaction = Yii::$app->db->beginTransaction();

		try {

			// Create post
			$this->create( $model, $config );

			$model->refresh();

			// Create and attach gallery
			if( $gallery ) {

				$gallery 	= $galleryService->createByParams(
									[ 'type' => CmsGlobal::TYPE_POST, 'active' => true, 'name' => $model->name, 'siteId' => Yii::$app->core->siteId ],
									[ 'autoName' => true ]
								);

				$this->linkGallery( $model, $gallery );
			}

			// Create and attach model content
			$modelContentService->create( $content, [ 'parent' => $model, 'parentType' => CmsGlobal::TYPE_POST, 'publish' => $publish, 'banner' => $banner, 'video' => $video ] );

			// Bind categories
			$modelCategoryService->bindCategories( $model->id, CmsGlobal::TYPE_POST );

			$model->refresh();

			$transaction->commit();

			return $model;
		}
		catch( Exception $e ) {

			$transaction->rollBack();
		}

		return false;
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$attributes	= isset( $config[ 'attributes' ] ) ? $config[ 'attributes' ] : [ 'parentId', 'name', 'description', 'visibility', 'title' ];
		$admin 		= isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;

		if( $admin ) {

			$attributes	= ArrayHelper::merge( $attributes, [ 'status', 'order', 'featured', 'comments', 'showGallery' ] );
		}

		return parent::update( $model, [
			'attributes' => $attributes
		]);
	}
	
	protected function applyBulk( $model, $column, $action, $target, $config = [] ) {

		switch( $column ) {

			case 'model': {

				switch( $action ) {

					case 'delete': {

						$this->delete( $model );

						break;
					}
				}

				break;
			}
		}
	}

	// Delete -------------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// PostService ---------------------------

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

}
