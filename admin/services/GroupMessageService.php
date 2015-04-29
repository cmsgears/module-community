<?php
namespace cmsgears\community\admin\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\community\common\models\entities\Group;
use cmsgears\community\common\models\entities\GroupMessage;

use cmsgears\core\common\utilities\DateUtil;

class GroupMessageService extends \cmsgears\community\common\services\GroupMessageService {

	// Static Methods ----------------------------------------------

	// Pagination ------------

	public static function getPagination( $conditions = [] ) {

		return self::getPaginationDetails( new GroupMessage(), [ 'conditions' => $conditions ] );
	}

	public static function getPaginationByGroupId( $groupId ) {

		return self::getPagination( [ 'groupId' => $groupId ] );
	}

	// Delete ----------------

	public static function delete( $message ) {

		$message->delete();

		return true;
	}
}

?>