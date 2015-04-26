<?php
namespace cmsgears\community\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\community\common\models\entities\Group;

use cmsgears\core\common\services\Service;

class GroupService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Group::findById( $id );
	}
}

?>