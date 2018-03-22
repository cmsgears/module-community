<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\services\resources;

// CMG Imports
use cmsgears\community\common\models\base\CmnTables;

use cmsgears\community\common\services\interfaces\resources\IChatMessageService;

use cmsgears\core\common\services\base\ResourceService;

/**
 * ChatMessageService provide service methods of chat message.
 *
 * @since 1.0.0
 */
class ChatMessageService extends ResourceService implements IChatMessageService {

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

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

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
