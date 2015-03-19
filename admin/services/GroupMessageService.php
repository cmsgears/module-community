<?php
namespace cmsgears\modules\community\admin\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\modules\community\common\models\entities\Group;
use cmsgears\modules\community\common\models\entities\GroupMessage;

use cmsgears\modules\core\common\utilities\DateUtil;

class GroupMessageService extends \cmsgears\modules\community\common\services\GroupMessageService {

	// Static Methods ----------------------------------------------

	// Pagination ------------

	public static function getPagination() {

		return self::getPaginationDetails( new GroupMessage() );
	}
	
	public static function getPaginationByGroup( $groupId ) {

		return self::getPaginationDetails( new GroupMessage(), [ 'message_group' => $groupId ] );
	}

	// Delete ----------------

	public static function delete( $message ) {

		$message->delete();

		return true;
	}
}

?>