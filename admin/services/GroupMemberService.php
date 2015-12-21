<?php
namespace cmsgears\community\admin\services;

// Yii Imports
use \Yii;

// CMG Imports

class GroupMemberService extends \cmsgears\community\common\services\GroupMemberService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPaginationByGroupId( $groupId ) {

		return self::getPagination( [ 'sort' => false, 'conditions' => [ 'groupId' => $groupId ] ] );
	}
}

?>