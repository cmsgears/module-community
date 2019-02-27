<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\services\interfaces\mappers;

// CMG Imports
use cmsgears\core\common\services\interfaces\base\IApproval;
use cmsgears\core\common\services\interfaces\base\IMapperService;

/**
 * IGroupMemberService declares methods specific to group member.
 *
 * @since 1.0.0
 */
interface IGroupMemberService extends IMapperService, IApproval {

	// Data Provider ------

	public function getPageByGroupId( $groupId );

	// Read ---------------

    // Read - Models ---

   	public function getByGroupId( $groupId );

   	public function getByUserId( $userId );

    // Read - Lists ----

    // Read - Maps -----

	public function searchByGroupIdName( $groupId, $name );

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	public function deleteByGroupId( $groupId );

	// Bulk ---------------

	public function applyBulkByGroupId( $column, $action, $target, $groupId );

	public function applyBulkByUserId( $column, $action, $target, $userId );

	// Notifications ------

	// Cache --------------

	// Additional ---------

}
