<?php
namespace cmsgears\community\common\services\entities;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\community\common\models\base\CmnTables;

use cmsgears\community\common\services\interfaces\entities\IChatService;

class ChatService extends \cmsgears\core\common\services\base\EntityService implements IChatService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\community\common\models\entities\Chat';

	public static $modelTable	= CmnTables::TABLE_CHAT;

	public static $parentType	= CmnGlobal::TYPE_CHAT;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ChatService ---------------------------

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

	// ChatService ---------------------------

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
