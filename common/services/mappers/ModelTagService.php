<?php
namespace cmsgears\cms\common\services\mappers;

// CMG Imports
use cmsgears\core\common\models\mappers\ModelTag;

use cmsgears\cms\common\services\interfaces\resources\ITagService;
use cmsgears\cms\common\services\interfaces\mappers\IModelTagService;

/**
 * The class ModelTagService is base class to perform database activities for ModelTag Entity.
 */
class ModelTagService extends \cmsgears\core\common\services\mappers\ModelTagService implements IModelTagService {

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

	public function __construct( ITagService $tagService, $config = [] ) {

		parent::__construct( $tagService, $config );
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ModelTagService -----------------------

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

	// ModelTagService -----------------------

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
