<?php
namespace cmsgears\cms\common\services\resources;

// CMG Imports
use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\resources\ModelContent;

use cmsgears\cms\common\services\interfaces\resources\IModelContentService;
use cmsgears\core\common\services\interfaces\resources\IFileService;

use cmsgears\core\common\utilities\DateUtil;

class ModelContentService extends \cmsgears\core\common\services\base\EntityService implements IModelContentService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\cms\common\models\resources\ModelContent';

	public static $modelTable	= CmsTables::TABLE_MODEL_CONTENT;

	public static $parentType	= null;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $fileService;

	// Private ----------------

	// Traits ------------------------------------------------------

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

	// ModelContentService -------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$sort = new Sort([
			'attributes' => [
				'pDate' => [
					'asc' => [ 'publishedAt' => SORT_ASC ],
					'desc' => ['publishedAt' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Published At'
				]
			]
		]);

		$config[ 'sort' ] = $sort;

		return parent::findPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$parent		= $config[ 'parent' ];
		$publish	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner		= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$video		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;

		// publish
		if( $publish && !isset( $model->publishedAt ) ) {

			$model->publishedAt	= DateUtil::getDateTime();
		}

		// parent
		$model->parentId	= $parent->id;
		$model->parentType	= $config[ 'parentType' ];

		$this->fileService->saveFiles( $model, [ 'bannerId' => $banner, 'videoId' => $video ] );

		return parent::create( $model, $config );
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$publish	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner		= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$video		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;

		// publish
		if( $publish && !isset( $model->publishedAt ) ) {

			$model->publishedAt	= DateUtil::getDateTime();
		}

		$this->fileService->saveFiles( $model, [ 'bannerId' => $banner, 'videoId' => $video ] );

		return parent::update( $model, [
			'attributes' => [ 'bannerId', 'videoId', 'templateId', 'summary', 'content', 'publishedAt', 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ]
		]);
	}

	public function updateBanner( $model, $banner ) {

		$this->fileService->saveFiles( $model, [ 'bannerId' => $banner ] );

		return parent::update( $model, [
			'attributes' => [ 'bannerId' ]
		]);
	}

	public function updateViewCount( $model, $views ) {

		$model->views   = $views;

		$model->update();
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		$this->fileService->deleteFiles( [ $model->banner, $model->video ] );

		return parent::delete( $model, $config );
	}

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// ModelContentService -------------------

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
