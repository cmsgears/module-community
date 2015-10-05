<?php
namespace cmsgears\community\admin\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\community\common\models\entities\Group;

class GroupService extends \cmsgears\community\common\services\GroupService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination( $config = [] ) {

	  return self::getPaginationDetails( $config );
	}

	public static function getPaginationByType( $type ) {
		
		return self::getPaginationDetailsByType( $type );
	}
}

?>