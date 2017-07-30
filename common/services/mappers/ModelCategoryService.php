<?php
namespace cmsgears\cms\common\services\mappers;

// CMG Imports
use cmsgears\core\common\models\mappers\ModelCategory;

use cmsgears\cms\common\services\interfaces\resources\ICategoryService;
use cmsgears\cms\common\services\interfaces\mappers\IModelCategoryService;

/**
 * The class ModelCategoryService is base class to perform database activities for ModelCategory Entity.
 */
class ModelCategoryService extends \cmsgears\core\common\services\mappers\ModelCategoryService implements IModelCategoryService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function __construct( ICategoryService $categoryService, $config = [] ) {

		parent::__construct( $categoryService, $config );
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ModelCategoryService ------------------

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// ModelCategoryService ------------------

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
