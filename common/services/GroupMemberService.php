<?php
namespace cmsgears\community\common\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\community\common\models\entities\GroupMember;
use cmsgears\community\common\config\CmnGlobal;
use cmsgears\community\common\services\GroupMessageService;
use cmsgears\core\common\services\RoleService;

class GroupMemberService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ------------------

	public static function findById( $id ) {

		return GroupMember::findById( $id );
	}
	
	public function findByUserId( $id ) {
		
		return GroupMember::findByUserId( $id );
	} 
	
	// create ----------
	
	public static function addMember( $groupId, $userId, $join = false, $admin = false ) {
		
		$model			= new GroupMember();		
		$role			= null;
				
		if( $admin ) {
			
			$role		= RoleService::findBySlug( CmnGlobal::ROLE_GROUP_SUPER_ADMIN );
		}
		else {
				
			$role		= RoleService::findBySlug( CmnGlobal::ROLE_GROUP_MEMBER );		
		}
		
		$model->groupId	= $groupId;
		$model->userId	= $userId;
		$model->roleId	= $role->id;
		
		if( !$join ) {
			$model->status	= GroupMember::STATUS_ACTIVE;
		}		
		
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
	
	// Update ---------------
	
	public static function changeStatus( $memberId, $status ) {
		
		$model			= self::findById( $memberId );
		$model->status	= $status;
		$model->update();
		
		return $model;
	} 
	
	public static function update( $model ) {
		
		$model->update();
		
		return $model;
	}

	// Delete ----------------

	public static function delete( $member ) { 
		
		GroupMessageService::deleteByGroupId( $member->groupId );

		$member->delete();

		return true;
		 
	}
	
	public static function deleteByGroupId( $groupId ) {

		GroupMember::deleteByGroupId( $groupId );
	}
}

?>