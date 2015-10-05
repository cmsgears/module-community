<?php
namespace cmsgears\community\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\community\common\models\entities\GroupMember;

class GroupMemberService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ------------------

	public static function findById( $id ) {

		return GroupMember::findById( $id );
	} 
	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new GroupMember(), $config );
	}

	// Delete ----------------

	public static function delete( $member ) {

		$member->delete();

		return true;
	}
}

?>