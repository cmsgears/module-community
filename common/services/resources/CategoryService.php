<?php
namespace cmsgears\cms\common\services\resources;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\common\models\resources\Category;

use cmsgears\cms\common\services\interfaces\resources\ICategoryService;
use cmsgears\cms\common\services\interfaces\resources\IModelContentService;

class CategoryService extends \cmsgears\core\common\services\resources\CategoryService implements ICategoryService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\cms\common\models\resources\Category';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $modelContentService;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function __construct( IModelContentService $modelContentService, $config = [] ) {

		$this->modelContentService = $modelContentService;

		parent::__construct( $config );
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// CategoryService -----------------------

	// Data Provider ------

	public function getPageWithContent( $config = [] ) {

		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'query' ] = Category::queryWithContent();
		}

		return $this->getPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$model		= parent::create( $model, $config );

		$content	= isset( $config[ 'content' ] ) ? $config[ 'content' ] : null;

		if( isset( $content ) ) {

			$config[ 'parent' ]		= $model;
			$config[ 'parentType' ]	= CoreGlobal::TYPE_CATEGORY;
			$config[ 'publish' ]	= true;

			$this->modelContentService->create( $content, $config );
		}

		return $model;
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$model		= parent::update( $model, $config );

		$content	= isset( $config[ 'content' ] ) ? $config[ 'content' ] : null;

		if( isset( $content ) ) {

			$config[ 'publish' ]	= true;

			$this->modelContentService->update( $content, $config );
		}

		return $model;
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		$content	= isset( $config[ 'content' ] ) ? $config[ 'content' ] : ( isset( $model->modelContent ) ? $model->modelContent : null );

		if( isset( $content ) ) {

			$this->modelContentService->delete( $content, $config );
		}

		return parent::delete( $model, $config );
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
	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// CategoryService -----------------------

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
