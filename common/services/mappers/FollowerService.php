<?php
namespace cmsgears\community\common\services\mappers;

// Yii Imports
use \Yii;
use yii\data\Sort;
use yii\db\Query;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\community\common\models\base\CmnTables;
use cmsgears\community\common\models\mappers\Follower;

use cmsgears\community\common\services\interfaces\mappers\IFollowerService;

use cmsgears\core\common\services\traits\MapperTrait;

class FollowerService extends \cmsgears\core\common\services\base\EntityService implements IFollowerService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\community\common\models\mappers\Follower';

	public static $modelTable	= CmnTables::TABLE_FOLLOWER;

	public static $parentType	= null;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use MapperTrait;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// FollowerService -----------------------

	// Data Provider ------

	// Read ---------------

	public function getUserLikeCount( $parentType ) {

		$user	= Yii::$app->user->identity;

		return Follower::findByParentTypeUserId( $parentType, $user->id, Follower::TYPE_LIKE )->count();
	}

	public function getUserFollowCount( $parentType ) {

		$user	= Yii::$app->user->identity;

		return Follower::queryByParentTypeModelId( $parentType, $user->id, Follower::TYPE_FOLLOW )->andWhere( [ 'active' => CoreGlobal::STATUS_ACTIVE ] )->count();
	}

	public function getUserWishlistCount( $parentType ) {

		$user	= Yii::$app->user->identity;

		return Follower::queryByParentTypeModelId( $parentType, $user->id, Follower::TYPE_WISHLIST )->count();
	}

    public function getModelLikeCount( $parentType ) {

        return Follower::queryByParentType( $parentType, Follower::TYPE_LIKE )->count();
    }

    public function getModelFollowCount( $parentType ) {

        return Follower::queryByParentType( $parentType, Follower::TYPE_FOLLOW )->andWhere( [ 'active' => CoreGlobal::STATUS_ACTIVE ] )->count();
    }

    public function getModelWishlistCount( $parentType ) {

        return Follower::queryByParentType( $parentType, Follower::TYPE_WISHLIST )->count();
    }

    public function getFollowerStatus( $parentType, $userId, $type = Follower::TYPE_FOLLOW ) {

        return Follower::queryByParentTypeModelId( $parentType, $userId, $type )->one();
    }

    public function getFollowingIdList( $userId, $parentType ) {

        return self::findList( 'parentId', CmnTables::TABLE_FOLLOWER, [ 'conditions' => [ 'userId' => $userId, 'type' => Follower::TYPE_FOLLOW, 'active' => CoreGlobal::STATUS_ACTIVE, 'parentType' => $parentType ] ] );
    }

    public function getStatusCounts( $parentId, $type = Follower::TYPE_FOLLOW ) {

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

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function createByParams( $params = [], $config = [] ) {

		$params[ 'active' ]	= CoreGlobal::STATUS_ACTIVE;

		return parent::createByParams( $params, $config );
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		return parent::update( $model, [
			'attributes' => [ 'active' ]
		]);
	}

	public function updateByParams( $params = [], $config = [] ) {

		$userId		= $params[ 'modelId' ];
		$parentId	= $params[ 'parentId' ];
		$parentType	= $params[ 'parentType' ];
		$type		= $params[ 'type' ];

		$follower	= Follower::getByParentModelId( $parentId, $parentType, $userId, $type );

		if( isset( $follower ) ) {

			return $this->toggleStatus( $follower );
		}

		return $this->createByParams( $params, $config );
	}

	public function toggleStatus( $model ) {

		if( $model->active == CoreGlobal::STATUS_INACTIVE ) {

			$model->active	= CoreGlobal::STATUS_ACTIVE;
		}
		else {

			$model->active	= CoreGlobal::STATUS_INACTIVE;
		}

		return parent::update( $model, [
			'attributes' => [ 'active' ]
		]);
 	}

	// Delete -------------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// FollowerService -----------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------
}
