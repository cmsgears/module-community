<?php
namespace cmsgears\cms\common\services\resources;


// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\common\models\resources\ModelContent;
use cmsgears\cms\common\models\resources\Tag;

use cmsgears\cms\common\services\interfaces\resources\IModelContentService;
use cmsgears\cms\common\services\interfaces\resources\ITagService;

class TagService extends \cmsgears\core\common\services\resources\TagService implements ITagService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\cms\common\models\resources\Tag';

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

	// TagService ----------------------------

	// Data Provider ------

	public function getPageWithContent( $config = [] ) {

		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'query' ] = Tag::queryWithContent();
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

		// Model content is required for all the tags to form tag page
		if( !isset( $content ) ) {

			$content = new ModelContent();
		}

		$config[ 'parent' ]			= $model;
		$config[ 'parentType' ]		= CoreGlobal::TYPE_TAG;

		$this->modelContentService->create( $content, $config );

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

		$content	= isset( $config[ 'content' ] ) ? $config[ 'content' ] : null;

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

	// TagService ----------------------------

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
