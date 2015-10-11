<?php
namespace cmsgears\community\common\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\community\common\models\entities\GroupMessage;

class GroupMessageService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ------------------

	public static function findById( $id ) {

		return GroupMessage::findById( $id );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $conditions= [] ) {

		  $sort = new Sort([
	        'attributes' => [
	            'createdAt' => [
	                'asc' => [ 'createdAt' => SORT_ASC ],
	                'desc' => ['createdAt' => SORT_DESC ],
	                'default' => SORT_ASC,
	                'label' => 'createdAt',
	            ], 
	        ],
	        'defaultOrder' => [
	        	'createdAt' => SORT_DESC
	        ]
	    ]); 

		if( !isset( $conditions[ 'sort' ] ) ) {

			$conditions[ 'sort' ] = $sort;
		}

		if( !isset( $conditions[ 'search-col' ] ) ) {

			$conditions[ 'search-col' ] = 'name';
		}

		return self::getDataProvider( new GroupMessage(), $conditions );
	}

	// Delete ----------------

	public static function delete( $message ) {

		$message->delete();

		return true;
	}
	
	public static function deleteByGroupId( $groupId ) {

		GroupMessage::deleteByGroupId( $groupId );
	}
}

?>