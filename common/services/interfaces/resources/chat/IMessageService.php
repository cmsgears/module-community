<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\services\interfaces\resources\chat;

// CMG Imports
use cmsgears\core\common\services\interfaces\base\IResourceService;

/**
 * IMessageService declares methods specific to chat message.
 *
 * @since 1.0.0
 */
interface IMessageService extends IResourceService {

	// Data Provider ------

	public function getPageByType( $type, $config = [] );

	public function getPageByChatId( $chatId, $config = [] );

	public function getPageByTypeChatId( $type, $chatId, $config = [] );

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

}
