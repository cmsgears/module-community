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
 * UpdateLike can be used to add like for a model.
 *
 * The controller must provide modelService variable using approprite service class.
 */
class UpdateLike extends \cmsgears\core\frontend\actions\common\ModelAction {

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
			$follower	= FollowerService::createOrUpdate( $this->model->id, $this->modelType, $user->id, Follower::TYPE_LIKE );

			$data		= [ 'active' => $follower->active, 'count' => $this->model->getLikesCount() ];

			// Trigger Ajax Success
			return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
		}

		// Trigger Ajax Failure
        return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>
