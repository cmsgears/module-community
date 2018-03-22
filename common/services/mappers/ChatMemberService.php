<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\services\mappers;

// CMG Imports
use cmsgears\community\common\models\base\CmnTables;

use cmsgears\community\common\services\interfaces\mappers\IChatMemberService;

use cmsgears\core\common\services\base\MapperService;

use cmsgears\core\common\utilities\DateUtil;

/**
 * ChatMemberService provide service methods of chat member.
 *
 * @since 1.0.0
 */
class ChatMemberService extends MapperService implements IChatMemberService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\community\common\models\mappers\ChatMember';

	public static $modelTable	= CmnTables::TABLE_CHAT_MEMBER;

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

	// ChatMemberService ---------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function update( $model, $config = [] ) {

		$model->syncedAt = DateUtil::getDateTime();

		return parent::update( $model, [
			'attributes' => [ 'syncedAt' ]
		]);
	}

	// Delete -------------

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// ChatMemberService ---------------------

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
