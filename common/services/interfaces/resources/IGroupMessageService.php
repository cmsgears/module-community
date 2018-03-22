<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\services\interfaces\resources;

// CMG Imports
use cmsgears\core\common\services\interfaces\base\IResourceService;

/**
 * IGroupMessageService declares methods specific to group message.
 *
 * @since 1.0.0
 */
interface IGroupMessageService extends IResourceService {

	// Data Provider ------

	public function getPageByGroupId( $groupId );

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	public function deleteByGroupId( $groupId );

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

}
