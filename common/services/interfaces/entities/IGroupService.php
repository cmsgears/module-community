<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\services\interfaces\entities;

// CMG Imports
use cmsgears\core\common\services\interfaces\base\IEntityService;

/**
 * IGroupService declares methods specific to group model.
 *
 * @since 1.0.0
 */
interface IGroupService extends IEntityService {

	// Data Provider ------

	public function getPageByType( $type );

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
