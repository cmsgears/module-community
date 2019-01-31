<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\services\interfaces\resources\group;

// CMG Imports
use cmsgears\core\common\services\interfaces\base\IApproval;
use cmsgears\core\common\services\interfaces\base\IResourceService;

/**
 * IPostService declares methods specific to group post.
 *
 * @since 1.0.0
 */
interface IPostService extends IResourceService, IApproval {

	// Data Provider ------

	public function getPageByType( $type, $config = [] );

	public function getPageByGroupId( $groupId, $config = [] );

	public function getPageByTypeGroupId( $type, $groupId, $config = [] );

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
