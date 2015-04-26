<?php
namespace cmsgears\community\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\community\common\models\entities\GroupMember;

use cmsgears\core\common\services\Service;

class GroupMemberService extends Service {

	// Static Methods ----------------------------------------------

	// Read ------------------

	public static function findById( $id ) {

		return GroupMember::findById( $id );
	}
}

?>