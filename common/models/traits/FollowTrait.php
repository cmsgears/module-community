<?php
namespace cmsgears\community\common\models\traits;

// Yii Imports
use \Yii;
use \yii\db\Query;

// CMG Imports
use cmsgears\community\common\models\entities\CmnTables;
use cmsgears\community\common\models\entities\Follower;

trait FollowTrait {

	private $followCounts;
	private $userFollows;
	private $userFollowCounts;

	public function getModelFollowers() {

	}

	public function getFollowers() {

	}

	// Model Followers ---------------------------------

	public function generateFollowCounts() {

		$returnArr		= [ Follower::TYPE_LIKE => 0, Follower::TYPE_FOLLOW => 0, Follower::TYPE_WISHLIST => 0 ];

		$followerTable	= CmnTables::TABLE_FOLLOWER;
		$query			= new Query();

    	$query->select( [ 'type', 'count(id) as total' ] )
				->from( $followerTable )
				->where( [ 'parentId' => $this->id, 'parentType' => $this->parentType, 'active' => true ] )
				->groupBy( 'type' );

		$counts 	= $query->all();

		foreach ( $counts as $count ) {

			$returnArr[ $count[ 'type' ] ] = $count[ 'total' ];
		}

		return $returnArr;
	}

	public function getLikesCount() {

		if( !isset( $this->followCounts ) ) {

			$this->followCounts	= $this->generateFollowCounts();
		}

		return $this->followCounts[ Follower::TYPE_LIKE ];
	}

	public function getFollowersCount() {

		if( !isset( $this->followCounts ) ) {

			$this->followCounts	= $this->generateFollowCounts();
		}

		return $this->followCounts[ Follower::TYPE_FOLLOW ];
	}

	public function getWishersCount() {

		if( !isset( $this->followCounts ) ) {

			$this->followCounts	= $this->generateFollowCounts();
		}

		return $this->followCounts[ Follower::TYPE_WISHLIST ];
	}

	// User Follow Tests -------------------------------

	public function generateUserFollows() {

		$user		= Yii::$app->user->identity;
		$returnArr	= [ Follower::TYPE_LIKE => false, Follower::TYPE_FOLLOW => false, Follower::TYPE_WISHLIST => false ];

		if( isset( $user ) ) {

			$followerTable	= CmnTables::TABLE_FOLLOWER;
			$query			= new Query();

	    	$query->select( [ 'type', 'active' ] )
					->from( $followerTable )
					->where( [ 'parentId' => $this->id, 'parentType' => $this->parentType, 'userId' => $user->id ] );

			$follows = $query->all();

			foreach ( $follows as $follow ) {

				$returnArr[ $follow[ 'type' ] ] = $follow[ 'active' ];
			}
		}

		return $returnArr;
	}

	public function isLiked() {

		if( !isset( $this->userFollows ) ) {

			$this->userFollows	= $this->generateUserFollows();
		}

		return $this->userFollows[ Follower::TYPE_LIKE ];
	}

	public function isFollowing() {

		if( !isset( $this->userFollows ) ) {

			$this->userFollows	= $this->generateUserFollows();
		}

		return $this->userFollows[ Follower::TYPE_FOLLOW ];
	}

	public function isWished() {

		if( !isset( $this->userFollows ) ) {

			$this->userFollows	= $this->generateUserFollows();
		}

		return $this->userFollows[ Follower::TYPE_WISHLIST ];
	}

	public static function getStatusCounts( $type = ListingFollower::TYPE_FOLLOW ) {

		$returnArr		= [ 'all' => 0, CoreGlobal::STATUS_ACTIVE => 0, CoreGlobal::STATUS_INACTIVE => 0 ];

		$followerTable	= CmnTables::TABLE_FOLLOWER;
		$query			= new Query();

    	$query->select( [ 'active', 'count(id) as total' ] )
				->from( $followerTable )
				->where( [ 'parentId' => $this->id, 'parentType' => $this->parentType, 'type' => $type ] )
				->groupBy( 'active' );

		$counts 	= $query->all();
		$returnArr	= [];
		$counter	= 0;

		foreach ( $counts as $count ) {

			$returnArr[ $count[ 'active' ] ] = $count[ 'total' ];

			$counter	= $counter + $count[ 'total' ];
		}

		$returnArr[ 'all' ] = $counter;

		return $returnArr;
	}
}

?>