<?php
namespace cmsgears\community\admin\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\community\common\models\entities\Group;
use cmsgears\community\common\models\entities\GroupMember;

use cmsgears\core\common\utilities\DateUtil;

class GroupMemberService extends \cmsgears\community\common\services\GroupMemberService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination( $conditions = [] ) {

		return self::getPaginationDetails( new GroupMember(), [ 'conditions' => $conditions ] );
	}

	public static function getPaginationByGroupId( $groupId ) {

		return self::getPagination( [ 'groupId' => $groupId ] );
	}

	// Delete ----------------

	public static function delete( $member ) {

		$member->delete();

		return true;
	}
}

?>