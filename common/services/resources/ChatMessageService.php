<?php
namespace cmsgears\community\common\services\resources;

// CMG Imports
use cmsgears\community\common\models\base\CmnTables;
use cmsgears\community\common\models\resources\ChatMessage;

use cmsgears\community\common\services\interfaces\resources\IChatMessageService;

class ChatMessageService extends \cmsgears\core\common\services\base\EntityService implements IChatMessageService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\community\common\models\resources\ChatMessage';

	public static $modelTable	= CmnTables::TABLE_CHAT_MESSAGE;

	public static $parentType	= null;

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

	// ChatMessageService --------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function update( $model, $config = [] ) {

		return parent::update( $model, [
			'attributes' => [ 'consumed', 'content', 'data' ]
		]);
	}

	// Delete -------------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// ChatMessageService --------------------

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
