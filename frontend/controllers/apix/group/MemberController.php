<?php
namespace cmsgears\community\frontend\controllers\apix\group;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\entities\User;
use cmsgears\community\common\models\mappers\GroupMember;

use cmsgears\core\common\services\entities\UserService;
use cmsgears\core\common\services\entities\RoleService;
use cmsgears\community\common\services\mappers\GroupMemberService;

use cmsgears\core\common\utilities\CodeGenUtil;
use cmsgears\core\common\utilities\AjaxUtil;

class MemberController extends \cmsgears\core\frontend\controllers\BaseController {

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
	                'invite' => [ 'permission' => CoreGlobal::PERM_USER ],
	                'activate' => [ 'permission' => CoreGlobal::PERM_USER ],
	                'deactivate' => [ 'permission' => CoreGlobal::PERM_USER ],
	                'join' => [ 'permission' => CoreGlobal::PERM_USER ],
	                'update-role' => [ 'permission' => CoreGlobal::PERM_USER ],
	                'delete' => [ 'permission' => CoreGlobal::PERM_USER ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'invite' => [ 'post' ],
                    'activate' => [ 'post' ],
                    'deactivate' => [ 'post' ],
                    'join' => [ 'post' ],
                    'update-role' => [ 'post' ],
                    'delete' => [ 'post' ]
                ]
            ]
        ];
    }

	public function actionInvite() {

		$users		= Yii::$app->request->post( 'User' );
		$groupId	= Yii::$app->request->post( 'group_id' );
		$count 		= count( $users );
		$users		= [];
		$model		= null;
		$modelData	= [];
		$roleList	= RoleService::getIdNameList( [ 'conditions' => [ 'type' => CmnGlobal::TYPE_COMMUNITY ] ] );
 		$avatar		= Yii::getAlias('@images').'/avatar.png';

		for ( $i = 0; $i < $count; $i++ ) {

			$users[] = new User();
		}

		if( User::loadMultiple( $users, Yii::$app->request->post(), 'User' ) ) {

			$counter = 0;

			foreach ( $users as $user ) {

				$counter++;

				$userData		= $user->username;

				// Check whether the submit value is username or not

				$userByName		= UserService::findByUsername( $userData );

				// Check whether the submit value is email or not

				$userByEmail	= UserService::findByEmail( $userData );

				if( isset( $userByName ) ) {

					$model	= GroupMemberService::addMember( $groupId, $userByName->id );

					Yii::$app->cmgCommunityMailer->sendInvitationMail( $userByName );
				}

				else if( isset( $userByEmail ) ) {

					$model	= GroupMemberService::addMember( $groupId, $userByEmail->id );

					Yii::$app->cmgCommunityMailer->sendInvitationMail( $userByEmail );
				}

				else {

					// Register New User

					$username		= CodeGenUtil::splitEmail( $userData );
					$user->email 	= $userData;
					$user->username	= $username;

					if(  $userModel = UserService::create( $user ) ) {

						$model	= GroupMemberService::addMember( $groupId, $userModel->id );

						Yii::$app->cmgCommunityMailer->sendCreateUserMail( $user );
					}
				}

				if( isset( $model->user->avatar )) {

					$avatar	= Yii::$app->fileManager->uploadUrl.$model->user->avatar->thumb;
				}

				$modelData	+= [ $counter => [
								'name' => $model->user->username,
								'avatar' => $avatar,
								'roleName' => $model->role->name,
								'memberId' => $model->id,
								'roleList' => CodeGenUtil::generateSelectOptionsIdName( $roleList, "{$model->role->name}" ),
								'deactivateUrl' => Url::toRoute( [ '/cmgcmn/apix/group/member/deactivate?id='.$model->id] ),
								'updateUrl' => Url::toRoute( [ '/cmgcmn/apix/group/member/update-role?id='.$model->id] ),
								'deleteUrl' => Url::toRoute( [ '/cmgcmn/apix/group/member/delete?id='.$model->id ] )
								] ];
			}

			if( $counter == $count ) {

				return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $modelData );
			}
		}

		else {

			// Trigger Ajax Not Found
	        return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
		}

	}

	public function actionActivate( $id ) {

		$grid	= Yii::$app->request->post( 'id' );

		if( GroupMemberService::changeStatus( $id, GroupMember::STATUS_ACTIVE ) ) {

			return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $grid );
		}
		else {

			// Trigger Ajax Not Found
	        return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
		}
	}

	public function actionDeactivate( $id ) {

		$grid	= Yii::$app->request->post( 'id' );

		if( GroupMemberService::changeStatus( $id, GroupMember::STATUS_BLOCKED ) ) {

			return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $grid );
		}
		else {

			// Trigger Ajax Not Found
	        return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
		}
	}

	public function actionJoin( $id ) {

		$grid		= Yii::$app->request->post( 'grid' );
		$groupId	= Yii::$app->request->post( 'group' );

		if( GroupMemberService::addMember( $groupId, $id, true ) ) {

			return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $grid );
		}
	}

	public function actionUpdateRole( $id ) {

		$row			= Yii::$app->request->post( 'row_id' );
		$model			= GroupMemberService::findById( $id );
		$responseData	= [];

		if( $model->load( Yii::$app->request->post(), 'GroupMember' ) && $model->validate() ) {

			if( GroupMemberService::update( $model ) ) {

				$roleListLi		= RoleService::getIdNameList( [ 'conditions' => [ 'type' => CmnGlobal::TYPE_COMMUNITY ] ] );
				$roleListLi		= CodeGenUtil::generateListItemsIdName( $roleListLi);
				$roleList		= RoleService::getIdNameList( [ 'conditions' => [ 'type' => CmnGlobal::TYPE_COMMUNITY ] ] );
				$roleList		= CodeGenUtil::generateSelectOptionsIdName( $roleList, "{$model->role->name}" );
				$responseData	= [ 'row' => $row, 'role' => $model->role->name, 'roleList' => $roleList, 'roleListLi' => $roleListLi ];

				return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $responseData );
			}
			else {

				// Trigger Ajax Not Found
		        return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
			}
		}

	}

	public function actionDelete( $id ) {

		$row	= Yii::$app->request->post( 'id' );
		$model	= GroupMemberService::findById( $id );

		if( isset( $model ) ) {

			if( ( GroupMemberService::delete( $model ) ) ) {

				return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $row );
			}
		}

		return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
?>