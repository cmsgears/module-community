<?php
namespace cmsgears\community\frontend\controllers\apix; 

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\community\common\models\entities\Follow;

use cmsgears\community\common\services\GroupService; 
use cmsgears\community\common\services\FollowService;

use cmsgears\core\common\utilities\AjaxUtil;


class GroupController extends \cmsgears\core\frontend\controllers\BaseController {
	
	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
	}

	// Instance Methods ------------------

	// yii\base\Component ----------------

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->cmgCore->getRbacFilterClass(),
                'actions' => [
	                'like' => [ 'permission' => CoreGlobal::PERM_USER ],
	                'wishlist' => [ 'permission' => CoreGlobal::PERM_USER ],
	                'delete' => [ 'permission' => CoreGlobal::PERM_USER ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'like' => [ 'post' ],
	                'wishlist' => [ 'post' ],
                    'delete' => [ 'post' ]
                ]
            ]
        ];
    }

	public function actionLike( $slug ) {

		if( yii::$app->user->getIdentity() != null ) {

			$userId		= yii::$app->user->getIdentity()->id;
			$group		= GroupService::findBySlug( $slug );
			$contentId	= yii::$app->request->post('contentId');

			if( isset( $group ) ) {

				$follower	= FollowService::createOrUpdatedByExisting( $userId, $group->id, CmnGlobal::TYPE_GROUP, Follow::TYPE_LIKE );

				if( isset( $follower ) ) {

					$data	= [ 'active' => $follower->active, 'user' => true, 'contentId' => $contentId ];

					return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
				}
			}
		}
		else {

			$data	= [ 'user' => false ];

			// Trigger Ajax Success
	        return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
		}
	}

	public function actionWishlist( $slug ) {

		if( yii::$app->user->getIdentity() != null ) {

			$userId		= yii::$app->user->getIdentity()->id;
			$group		= GroupService::findBySlug( $slug );

			if( isset( $group ) ) {

				$follower	= FollowService::createOrUpdatedByExisting( $userId, $group->id, CmnGlobal::TYPE_GROUP, Follow::TYPE_WISHLIST );

				if( isset( $follower ) ) {

					$data	= [ 'active' => $follower->active, 'user' => true ];

					return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
				}
			}
		}
		else {

			$data	= [ 'user' => false ];

			// Trigger Ajax Success
	        return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
		}
	}

	public function actionFollow( $slug ) {
		
		$user		= yii::$app->user->getIdentity();
		$listing	= $this->listingService->findModelBySlug( $slug );
		$data		= [];

		if( isset( $listing ) && isset( $user ) ) {

			$follower	= ListingFollowerService::createOrUpdate( $user->id, $listing->id, ListingFollower::TYPE_FOLLOW );
			$data		= [ 'active' => $follower->active ];
			
			// Trigger Ajax Success
			return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
		}
	}

	public function actionDelete( $id ) {
		 
		$model	= GroupService::findById( $id ); 
		
		if( GroupService::delete( $model, $model->content ) ) {
		 	 
			return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ) );
		} 
		
		else {
			
			// Trigger Ajax Not Found
	        return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );	
		}				 
		  
	}
}
?>