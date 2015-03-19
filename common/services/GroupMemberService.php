<?php
namespace cmsgears\modules\community\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\modules\community\common\models\entities\GroupMember;

use cmsgears\modules\core\common\services\Service;

class GroupMemberService extends Service {

	// Static Methods ----------------------------------------------

	// Read ------------------

	public static function findById( $id ) {

		return GroupMember::findById( $id );
	}
}

?>