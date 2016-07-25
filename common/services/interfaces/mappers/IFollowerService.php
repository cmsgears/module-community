<?php
namespace cmsgears\community\common\services\interfaces\mappers;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

interface IFollowerService extends \cmsgears\core\common\services\interfaces\base\IMapperService {

	// Data Provider ------

	// Read ---------------

	public function getUserLikeCount( $parentType );

	public function getUserFollowCount( $parentType );

	public function getUserWishlistCount( $parentType );

    public function getModelLikeCount( $parentType );

    public function getModelFollowCount( $parentType );

    public function getModelWishlistCount( $parentType );

    public function getFollowerStatus( $parentType, $userId, $type = Follower::TYPE_FOLLOW );

    public function getFollowingIdList( $userId, $parentType );

    public function getStatusCounts( $parentId, $type = Follower::TYPE_FOLLOW );

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Create -------------

	// Update -------------

	public function toggleStatus( $model );

	// Delete -------------

}
