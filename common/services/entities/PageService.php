<?php
namespace cmsgears\cms\common\services\entities;

// Yii Imports
use Yii;
use yii\data\Sort;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\entities\Page;

use cmsgears\core\common\services\interfaces\resources\IFileService;
use cmsgears\cms\common\services\interfaces\entities\IPageService;

use cmsgears\core\common\services\traits\NameTypeTrait;
use cmsgears\core\common\services\traits\SlugTypeTrait;

class PageService extends \cmsgears\cms\common\services\base\ContentService implements IPageService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\cms\common\models\entities\Page';

	public static $modelTable	= CmsTables::TABLE_PAGE;

	public static $parentType	= CmsGlobal::TYPE_PAGE;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $fileService;

	// Private ----------------

	// Traits ------------------------------------------------------

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

	// PageService ---------------------------

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

		// Filters ----------

		// Searching --------

		$searchCol	= Yii::$app->request->getQueryParam( 'search' );

		if( isset( $searchCol ) ) {

			$search = [ 'name' => "$modelTable.name", 'slug' => "$modelTable.slug", 'template' => "$modelTable.template" ];

			$config[ 'search-col' ] = $search[ $searchCol ];
		}

		// Reporting --------

		$config[ 'report-col' ]	= [
			'name' => "$modelTable.name", 'slug' => "$modelTable.slug", 'template' => "$modelTable.template"
		];

		// Result -----------

		//$config[ 'conditions' ][ 'type' ]	= CmsGlobal::TYPE_PAGE;

		return parent::findPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	public function getMenuPages( $pages, $map = false ) {

		if( count( $pages ) > 0 ) {

			if( $map ) {

				$pages		= Page::find()->andFilterWhere( [ 'in', 'id', $pages ] )->all();
				$pageMap	= [];

				foreach ( $pages as $page ) {

					$pageMap[ $page->id ] = $page;
				}

				return $pageMap;
			}
			else {

				return Page::find()->andFilterWhere( [ 'in', 'id', $pages ] )->all();
			}
		}

		return [];
	}

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$model->type = CmsGlobal::TYPE_PAGE;

		return parent::create( $model, $config );
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$attributes	= isset( $config[ 'attributes' ] ) ? $config[ 'attributes' ] : [ 'parentId', 'name', 'description', 'visibility', 'icon', 'title' ];
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

	// PageService ---------------------------

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
