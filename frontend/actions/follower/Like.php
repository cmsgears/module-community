<?php
namespace cmsgears\community\frontend\actions\follower;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\community\common\models\mappers\Follower;

use cmsgears\core\common\utilities\AjaxUtil;

/**
 * Like action allow users to like/dislike model in action.
 *
 * The controller must provide appropriate model service having model class, model table and parent type defined for the base model.
 */
class Like extends \cmsgears\core\common\actions\base\ModelAction {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	public $typed 	= true;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Like ----------------------------------

	public function run() {

		if( isset( $this->model ) ) {

			$followerService	=	Yii::$app->factory->get( 'followerService' );
			$user 				=	Yii::$app->user->getIdentity();
			$model				=	$this->model;
			$parentType			=	$this->modelService->getParentType();
			$follower			=	$followerService->updateByParams( [ 'modelId' => $user->id, 'parentId' => $model->id, 'parentType' => $parentType, 'type' => Follower::TYPE_LIKE ] );

			$likeFlag			=	isset( $user->id ) ?
									count( $followerService->getByConfig( [ 'modelId' => $user->id, 'parentId' => $model->id, 'parentType' => $parentType, 'type' => Follower::TYPE_LIKE, 'active' => true ] ) )
									: false;

			$dislikeFlag		=	isset( $user->id ) ?
									count( $followerService->getByConfig( [ 'modelId' => $user->id, 'parentId' => $model->id, 'parentType' => $parentType, 'type' => Follower::TYPE_DISLIKE, 'active' => true ] ) )
									: false;

			$data				= [
									'likeFlag' => $likeFlag,
									'dislikeFlag' => $dislikeFlag,
									'dislikesCount' => $model->getDislikesCount(),
									'likesCount' => $model->getLikesCount()
								];

			return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
		}

		// Trigger Ajax Failure
        return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}