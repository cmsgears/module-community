<?php
namespace cmsgears\community\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\community\common\models\entities\Group;

class GroupService extends \cmsgears\community\common\services\GroupService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination( $conditions = [] ) {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'name' => SORT_ASC ],
	                'desc' => ['name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'cdate' => [
	                'asc' => [ 'createdAt' => SORT_ASC ],
	                'desc' => ['createdAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'cdate',
	            ],
	            'udate' => [
	                'asc' => [ 'updatedAt' => SORT_ASC ],
	                'desc' => ['updatedAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'udate',
	            ]
	        ],
	        'defaultOrder' => [
	        	'cdate' => SORT_DESC
	        ]
	    ]);

		if( !isset( $conditions[ 'query' ] ) ) {

			$conditions[ 'query' ] = Group::findWithContent();
		}

		if( !isset( $conditions[ 'sort' ] ) ) {

			$conditions[ 'sort' ] = $sort;
		}

		if( !isset( $conditions[ 'search-col' ] ) ) {

			$conditions[ 'search-col' ] = 'name';
		}

		return self::getDataProvider( new Group(), $conditions );
	}

	public static function getPaginationByType( $type ) {
		
		return self::getPagination( [ 'conditions' => [ 'type' => $type ] ] );
	}
}

?>