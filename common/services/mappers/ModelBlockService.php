<?php
namespace cmsgears\core\common\services\mappers;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\entities\Block;
use cmsgears\cms\common\models\mappers\ModelBlock;

use cmsgears\cms\common\services\interfaces\mappers\IModelBlockService;

use cmsgears\core\common\services\traits\MapperTrait;

/**
 * The class ModelBlockService is base class to perform database activities for ModelBlock Entity.
 */
class ModelBlockService extends \cmsgears\core\common\services\base\EntityService implements IModelBlockService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\cms\common\models\mappers\ModelBlock';

	public static $modelTable	= CmsTables::TABLE_MODEL_BLOCK;

	public static $parentType	= null;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use MapperTrait;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ModelBlockService ---------------------

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

	// ModelBlockService ---------------------

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
