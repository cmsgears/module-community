<?php
namespace cmsgears\community\frontend\controllers\apix\group; 

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal; 
use cmsgears\core\common\utilities\AjaxUtil;
use cmsgears\core\common\models\entities\User;
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
	                'invite' => [ 'permission' => CoreGlobal::PERM_USER ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'invite' => [ 'post' ]
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
}
?>