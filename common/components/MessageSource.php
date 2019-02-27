<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\components;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

/**
 * MessageSource stores and provide the messages and message templates available in
 * Community Module.
 *
 * @since 1.0.0
 */
class MessageSource extends \cmsgears\core\common\base\MessageSource {

	// Variables ---------------------------------------------------

	// Global -----------------

	// Public -----------------

	// Protected --------------

	protected $messageDb = [
		// Generic Fields
		CmnGlobal::FIELD_FRIEND => 'Friend',
		CmnGlobal::FIELD_GROUP => 'Group',
		CmnGlobal::FIELD_CHAT => 'Chat',
		CmnGlobal::FIELD_BROADCASTED => 'Broadcasted'
	];

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// MessageSource -------------------------

}
