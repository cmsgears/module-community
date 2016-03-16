<?php
namespace cmsgears\community\common\services;

// Yii Imports
use \Yii;

// CMG Imports    
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\community\common\models\entities\Follower; 

class FollowerService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Follower::findById( $id );
	}

	public static function getUserLikeCount( $parentType ) {

		$user	= Yii::$app->user->identity;

		return Follower::findByParentTypeUserId( $parentType, $user->id, Follower::TYPE_LIKE )->count();
	}

	public static function getUserFollowCount( $parentType ) {

		$user	= Yii::$app->user->identity;

		return Follower::findByParentTypeUserId( $parentType, $user->id, Follower::TYPE_FOLLOW )->count();
	}

	public static function getUserWishlistCount( $parentType ) {

		$user	= Yii::$app->user->identity;

		return Follower::findByParentTypeUserId( $parentType, $user->id, Follower::TYPE_WISHLIST )->count();
	}
    
    public static function getModelLikeCount( $parentType ) {

        return Follower::findByParentType( $parentType, Follower::TYPE_LIKE )->count();
    }

    public static function getModelFollowCount( $parentType ) {

        return Follower::findByParentType( $parentType, Follower::TYPE_FOLLOW )->count();
    }

    public static function getModelWishlistCount( $parentType ) {

        return Follower::findByParentType( $parentType, Follower::TYPE_WISHLIST )->count();
    }

	// Create ----------------

	public static function createOrUpdate( $parentId, $parentType, $userId, $type ) {

		$follower	= Follower::findByParentUserId( $parentId, $parentType, $userId, $type )->one();

		if( isset( $follower ) ) {

			$follower = self::update( $follower );
		}
		else {

			$follower				= new Follower();
			$follower->parentId		= $parentId;
			$follower->parentType	= $parentType;
			$follower->userId		= $userId;
			$follower->type			= $type;
			$follower->active		= CoreGlobal::STATUS_ACTIVE;

			$follower = self::create( $follower );
		}

		return $follower;
	}

 	public static function create( $model ) {

		$model->save();

		return $model;
 	}

	// Update ----------------

	public static function update( $model ) {

		if( $model->active == CoreGlobal::STATUS_INACTIVE ) {

			$model->active	= CoreGlobal::STATUS_ACTIVE;
		}
		else {

			$model->active	= CoreGlobal::STATUS_INACTIVE;
		}

		$model->update();

		return $model;
 	}
}

?>