<?php
namespace cmsgears\community\common\services\entities;

// Yii Imports
use \Yii;
use yii\db\Query;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\community\common\models\base\CmnTables;
use cmsgears\community\common\models\entities\Follower;

class FollowerService extends \cmsgears\core\common\services\base\Service {

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

		return Follower::findByParentTypeUserId( $parentType, $user->id, Follower::TYPE_FOLLOW )->andWhere( [ 'active' => CoreGlobal::STATUS_ACTIVE ] )->count();
	}

	public static function getUserWishlistCount( $parentType ) {

		$user	= Yii::$app->user->identity;

		return Follower::findByParentTypeUserId( $parentType, $user->id, Follower::TYPE_WISHLIST )->count();
	}

    public static function getModelLikeCount( $parentType ) {

        return Follower::findByParentType( $parentType, Follower::TYPE_LIKE )->count();
    }

    public static function getModelFollowCount( $parentType ) {

        return Follower::findByParentType( $parentType, Follower::TYPE_FOLLOW )->andWhere( [ 'active' => CoreGlobal::STATUS_ACTIVE ] )->count();
    }

    public static function getModelWishlistCount( $parentType ) {

        return Follower::findByParentType( $parentType, Follower::TYPE_WISHLIST )->count();
    }

    public static function getFollowerStatus( $parentType, $userId, $type = Follower::TYPE_FOLLOW ) {

        return Follower::findByParentTypeUserId( $parentType, $userId, $type )->one();
    }

    public static function getFollowingIdList( $userId, $parentType ) {

        return self::findList( 'parentId', CmnTables::TABLE_FOLLOWER, [ 'conditions' => [ 'userId' => $userId, 'type' => Follower::TYPE_FOLLOW, 'active' => CoreGlobal::STATUS_ACTIVE, 'parentType' => $parentType ] ] );
    }

    public static function getStatusCounts( $parentId, $type = Follower::TYPE_FOLLOW ) {

        $followerTable  = CmnTables::TABLE_FOLLOWER;
        $query          = new Query();

        $query->select( [ 'active', 'count(id) as total' ] )
                ->from( $followerTable )
                ->where( [ 'parentId' => $parentId, 'type' => $type ] )
                ->groupBy( 'active' );

        $counts     = $query->all();
        $returnArr  = [];
        $counter    = 0;

        foreach ( $counts as $count ) {

            $returnArr[ $count[ 'active' ] ] = $count[ 'total' ];

            $counter    = $counter + $count[ 'total' ];
        }

        $returnArr[ 'all' ] = $counter;

        if( !isset( $returnArr[ CoreGlobal::STATUS_INACTIVE ] ) ) {

            $returnArr[ CoreGlobal::STATUS_INACTIVE ]   = 0;
        }

        if( !isset( $returnArr[ CoreGlobal::STATUS_ACTIVE ] ) ) {

            $returnArr[ CoreGlobal::STATUS_ACTIVE ] = 0;
        }

        return $returnArr;
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