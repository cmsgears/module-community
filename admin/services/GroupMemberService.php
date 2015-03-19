<?php
namespace cmsgears\modules\community\admin\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\modules\community\common\models\entities\Group;
use cmsgears\modules\community\common\models\entities\GroupMember;

use cmsgears\modules\core\common\utilities\DateUtil;

class GroupMemberService extends \cmsgears\modules\community\common\services\GroupMemberService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination() {

		return self::getPaginationDetails( new GroupMember() );
	}
	
	public static function getPaginationByGroup( $groupId ) {

		return self::getPaginationDetails( new GroupMember(), [ 'member_group' => $groupId ] );
	}

	// Delete ----------------

	public static function delete( $member ) {

		$member->delete();

		return true;
	}
}

?>