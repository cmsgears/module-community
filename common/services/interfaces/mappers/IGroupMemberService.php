<?php
namespace cmsgears\community\common\services\interfaces\mappers;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

interface IGroupMemberService extends \cmsgears\core\common\services\interfaces\base\IApprovalService {

	// Data Provider ------

	public function getPageByGroupId( $groupId );

	// Read ---------------

    // Read - Models ---

	public function getByUserId( $id );

    // Read - Lists ----

    // Read - Maps -----

	// Create -------------

	public function addMember( $groupId, $userId, $join = false, $admin = false );

	// Update -------------

	// Delete -------------

	public function deleteByGroupId( $groupId );
}
