<?php
namespace cmsgears\community\common\services;

// Yii Imports
use \Yii;

// CMG Imports    
use cmsgears\community\common\models\entities\Follower; 

class FollowerService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Follow::findOne( $id );
	}
	
	public static function findAllbyUserIdType( $userId, $type = Follow::TYPE_FOLLOW ) {
		
		return Follow::findAllbyUserIdType( $userId, $type );
	}
	
	public static function findAllByParentIdType( $parentId, $type = Follow::TYPE_FOLLOW ) {
		
		return Follow::findAllByParentIdType( $parentId, $type );
	}
	
	public static function findAllByParentIdParentTypeActive( $parentId, $parentType, $type, $active	= Follow::ACTIVE ) {
		
		return Follow::findAllByParentIdParentTypeActive( $parentId, $parentType, $type, $active );
	}
	
	public static function findByUserParentIdType(  $userId, $parentId, $parentType, $type ) {
		
		return Follow::findByUserParentIdType(  $userId, $parentId, $parentType, $type );
	}
	  
	// Create ----------------
	
	public static function createOrUpdatedByExisting( $userId, $parentId, $parentType, $type ) {
		
		$follower	= self::findByUserParentIdType( $userId, $parentId, $parentType, $type );
		 
		if( isset( $follower ) ) {
			 
			self::update( $follower );
		}
		else {
			
			$follower	= new Follow();
			
			$follower->userId		= $userId;
			$follower->parentId		= $parentId;
			$follower->parentType	= $parentType;
			$follower->type			= $type;
			$follower->active		= Follow::ACTIVE;
			
			self::create( $follower );
		}
		
		return $follower;
	}

 	public static function create( $model ) {

		$model->save();

		return $model;
 	}

	// Update ----------------
	
	public static function update( $model ) {

		if( $model->active	== Follow::INACTIVE ) {
			
			$model->active	= Follow::ACTIVE;
		}
		else {
			
			$model->active	= Follow::INACTIVE;
		}
		
		$model->update();
		
		return $model;
 	}
}

?>