<?php
namespace cmsgears\modules\community\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\modules\community\common\models\entities\Group;

use cmsgears\modules\core\common\services\Service;

class GroupService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Group::findOne( $id );
	}
}

?>