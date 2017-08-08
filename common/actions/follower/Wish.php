<?php
namespace cmsgears\community\common\actions\follower;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\community\common\models\mappers\Follower;

use cmsgears\core\common\utilities\AjaxUtil;

/**
 * Wish action allow users to add model in action to their wishlist.
 *
 * The controller must provide appropriate model service having model class, model table and parent type defined for the base model.
 */
class Wish extends \cmsgears\core\common\actions\base\ModelAction {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $parent 	= true;

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Wish ----------------------------------

	public function run() {

		if( isset( $this->model ) ) {

			$followerService	= Yii::$app->factory->get( 'followerService' );

			$user 		= Yii::$app->user->getIdentity();
			$model		= $this->model;

			$follower	= $followerService->updateByParams([
							'modelId' => $user->id, 'parentId' => $model->id,
							'parentType' => $this->modelService->getParentType(), 'type' => Follower::TYPE_WISHLIST
						]);

			$data		= [ 'active' => $follower->active, 'count' => $model->getWishersCount() ];

			return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
		}

		// Trigger Ajax Failure
        return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
