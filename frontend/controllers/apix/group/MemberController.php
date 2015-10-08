<?php
namespace cmsgears\community\frontend\controllers\apix\group; 

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal; 
use cmsgears\core\common\utilities\AjaxUtil;
use cmsgears\core\common\models\entities\User;
use cmsgears\community\common\models\entities\GroupMember;
use cmsgears\core\common\services\UserService;
use cmsgears\community\common\services\GroupMemberService;

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
	                'join' => [ 'permission' => CoreGlobal::PERM_USER ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'invite' => [ 'post' ],
                    'activate' => [ 'post' ],
                    'deactivate' => [ 'post' ],
                    'join' => [ 'post' ]
                ]
            ]
        ];
    }

	public function actionInvite() {
		  
		$users		= Yii::$app->request->post( 'User' );
		$groupId	= Yii::$app->request->post( 'group_id' ); 	
		$count 		= count( $users );		
		$users		= [];

		for ( $i = 0; $i < $count; $i++ ) {

			$users[] = new User();
		}
		 		
		if( User::loadMultiple( $users, Yii::$app->request->post(), 'User' ) ) {
			
			$count	= 0;

			foreach ( $users as $user ) {
				
				$count++;
				
				$userData		= $user->username;
				
				// Check whether the submit value is username or not
				
				$userByName		= UserService::findByUsername( $userData );
				
				// Check whether the submit value is email or not
				
				$userByEmail	= UserService::findByEmail( $userData );
				
				if( isset( $userByName ) ) {
					
					GroupMemberService::addMember( $groupId, $userByName->id );					 					
					Yii::$app->cmgCommunityMailer->sendInvitationMail( $userByName );
				} 
				
				else if( isset( $userByEmail ) ) {
					 
					GroupMemberService::addMember( $groupId, $userByEmail->id ); 
					Yii::$app->cmgCommunityMailer->sendInvitationMail( $userByEmail );
				}
				
				else {
					
					$username		= UserService::splitEmail( $userData );						
					$user->email 	= $userData;
					$user->username	= $username;
					 
					if(  $userModel = UserService::create( $user ) ) {
						
						GroupMemberService::addMember( $groupId, $userModel->id ); 
						Yii::$app->cmgCommunityMailer->sendCreateUserMail( $user );						
										 
					}
				}
				
				return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ) );		
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
}
?>