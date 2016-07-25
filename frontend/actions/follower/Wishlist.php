<?php
namespace cmsgears\community\frontend\actions\follower;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\community\common\models\entities\Follower;

use cmsgears\community\common\services\entities\FollowerService;

use cmsgears\core\common\utilities\AjaxUtil;

/**
 * UpdateWishlist can be used to add wishlist for a model.
 *
 * The controller must provide modelService variable using approprite service class.
 */
class UpdateWishlist extends \cmsgears\core\frontend\actions\common\ModelAction {

	// Variables ---------------------------------------------------

	// Constants/Statics --

	// Public -------------

	// Private/Protected --

	// Constructor and Initialisation ------------------------------

	// Instance Methods --------------------------------------------

	// CreateTags ------------------------

	public function run() {

		if( isset( $this->model ) ) {

			$user 		= Yii::$app->user->getIdentity();
			$follower	= FollowerService::createOrUpdate( $this->model->id, $this->modelType, $user->id, Follower::TYPE_WISHLIST );

			$data		= [ 'active' => $follower->active, 'count' => $this->model->getWishersCount() ];

			// Trigger Ajax Success
			return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
		}

		// Trigger Ajax Failure
        return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

	public function actionWishlist( $slug ) {

		$user 		= Yii::$app->user->getIdentity();
		$group		= $this->modelService->getBySlug( $slug );

		$follower	= FollowerService::createOrUpdate( $user->id, $group->id, Follower::TYPE_WISHLIST );

		$data		= [ 'active' => $follower->active, 'count' => $group->getLikesCount() ];

		return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
	}

?>
