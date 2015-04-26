<?php
namespace cmsgears\community\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\community\common\models\entities\GroupMessage;

use cmsgears\core\common\services\Service;

class GroupMessageService extends Service {

	// Static Methods ----------------------------------------------

	// Read ------------------

	public static function findById( $id ) {

		return GroupMessage::findById( $id );
	}
}

?>