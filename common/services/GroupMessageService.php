<?php
namespace cmsgears\modules\community\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\modules\community\common\models\entities\GroupMessage;

use cmsgears\modules\core\common\services\Service;

class GroupMessageService extends Service {

	// Static Methods ----------------------------------------------

	// Read ------------------

	public static function findById( $id ) {

		return GroupMessage::findById( $id );
	}
}

?>