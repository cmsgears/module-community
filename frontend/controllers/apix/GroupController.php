<?php
namespace cmsgears\community\frontend\controllers\apix;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\community\common\models\entities\Follower;

use cmsgears\community\common\services\entities\GroupService;
use cmsgears\community\common\services\entities\FollowerService;

use cmsgears\core\common\filters\UserExistFilter;

use cmsgears\core\common\utilities\AjaxUtil;

// TODO: Use ownership filter

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
	                'delete' => [ 'permission' => CoreGlobal::PERM_USER ]
                ]
            ],
            'userExists' => [
            	'class' => UserExistFilter::className(),
            	'actions' => [
            		'like', 'follow', 'wishlist'
            	]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'like' => [ 'post' ],
	                'follow' => [ 'post' ],
	                'wishlist' => [ 'post' ],
                    'delete' => [ 'post' ]
                ]
            ]
        ];
    }

	public function actionLike( $slug ) {

		$user 		= Yii::$app->user->getIdentity();
		$group		= GroupService::findBySlug( $slug );

		$follower	= FollowerService::createOrUpdate( $user->id, $group->id, Follower::TYPE_LIKE );

		$data		= [ 'active' => $follower->active, 'count' => $group->getLikesCount() ];

		return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
	}

	public function actionFollow( $slug ) {

		$user 		= Yii::$app->user->getIdentity();
		$group		= GroupService::findBySlug( $slug );

		$follower	= FollowerService::createOrUpdate( $user->id, $group->id, Follower::TYPE_FOLLOW );

		$data		= [ 'active' => $follower->active, 'count' => $group->getLikesCount() ];

		return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
	}

	public function actionWishlist( $slug ) {

		$user 		= Yii::$app->user->getIdentity();
		$group		= GroupService::findBySlug( $slug );

		$follower	= FollowerService::createOrUpdate( $user->id, $group->id, Follower::TYPE_WISHLIST );

		$data		= [ 'active' => $follower->active, 'count' => $group->getLikesCount() ];

		return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $data );
	}

	public function actionDelete( $id ) {

		$model	= GroupService::findById( $id );

		if( GroupService::delete( $model, $model->content ) ) {

			return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ) );
		}

		// Trigger Ajax Not Found
        return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>