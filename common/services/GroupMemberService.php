<?php
namespace cmsgears\community\common\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\community\common\models\entities\GroupMember;
use cmsgears\community\common\config\CmnGlobal;
use cmsgears\core\common\services\RoleService;

class GroupMemberService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ------------------

	public static function findById( $id ) {

		return GroupMember::findById( $id );
	} 
	
	// create ----------
	
	public static function addMember( $groupId, $userId ) {
		
		$model			= new GroupMember();		
		$role			= RoleService::findBySlug( CmnGlobal::ROLE_GROUP_MEMBER );		
		$model->groupId	= $groupId;
		$model->userId	= $userId;
		$model->roleId	= $role->id;
		$model->status	= GroupMember::STATUS_ACTIVE;
		$model->save();
		
		return $model;
	}	
	
	// Data Provider ----
 
	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $conditions= [] ) {

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

			$conditions[ 'query' ] = GroupMember::findWithAll();
		}

		if( !isset( $conditions[ 'sort' ] ) ) {

			$conditions[ 'sort' ] = $sort;
		}

		if( !isset( $conditions[ 'search-col' ] ) ) {

			$conditions[ 'search-col' ] = 'name';
		}

		return self::getDataProvider( new GroupMember(), $conditions );
	}
	
	

	// Delete ----------------

	public static function delete( $member ) {

		$member->delete();

		return true;
	}
	
	public static function deleteByGroupId( $groupId ) {

		GroupMember::deleteByGroupId( $groupId );
	}
}

?>