<?php
namespace cmsgears\community\frontend\controllers\apix\group; 

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal; 
use cmsgears\core\common\utilities\AjaxUtil;
use cmsgears\core\common\utilities\DateUtil;
use cmsgears\community\common\models\entities\GroupMessage; 
use cmsgears\community\frontend\services\GroupMessageService;

class MessageController extends \cmsgears\core\frontend\controllers\BaseController {
	
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
	                'create' => [ 'permission' => CoreGlobal::PERM_USER ],
	                'udpate' => [ 'permission' => CoreGlobal::PERM_USER ],
	                'delete' => [ 'permission' => CoreGlobal::PERM_USER ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => [ 'post' ],
                    'update' => [ 'post' ],
                    'delete' => [ 'post' ]
                ]
            ]
        ];
    }
	
	public function actionCreate() {
		
		$model			= new GroupMessage();
		$response		= [];
		$contentClass	= '';
		
		if( $model->load( Yii::$app->request->post(), 'Message' ) && $model->validate() ) {
			
			if( $message = GroupMessageService::create( $model ) ) {
				
				$id			= $message->id;				
				$message	= GroupMessageService::findById( $id);				
				$content	= $message->content;
				
				if( $content == null ) {
					
					$contentClass	= 'warning';
					$content		= 'Blank Message';
				}
				 
				$response	= [
					
					'messageId'	=> $message->id,
					'createdAt' => DateUtil::getDateTime( $message->createdAt ),
					'username' => $message->member->user->username,
					'contentClass' => $contentClass,
					'content' => $content,
					'updateUrl' => Url::toRoute( '/cmgcmn/apix/group/message/update?id='.$id ),
					'deleteUrl' => Url::toRoute( '/cmgcmn/apix/group/message/delete?id='.$id )
				];
				
				return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $response );
			}
		}
		
		return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
		
	}

	public function actionUpdate( $id ) {
		
		$model			= GroupMessageService::findById( $id );
		$grid			= Yii::$app->request->post( 'grid' );
		$response		= [];
		$contentClass	= '';
		
		if( $model->load( Yii::$app->request->post(), 'Message' ) && $model->validate() ) {
			
			if( $message = GroupMessageService::Update( $model ) ) {
				
				$id			= $message->id;				
				$message	= GroupMessageService::findById( $id);				
				$content	= $message->content;
				
				if( $content == null ) {
					
					$contentClass	= 'warning';
					$content		= 'Blank Message';
				}
				 
				$response	= [
					
					'messageId'	=> $message->id,
					'createdAt' => DateUtil::getDateTime( $message->createdAt ),
					'username' => $message->member->user->username,
					'contentClass' => $contentClass,
					'content' => $content,
					'updateUrl' => Url::toRoute( '/cmgcmn/apix/group/message/update?id='.$id ),
					'deleteUrl' => Url::toRoute( '/cmgcmn/apix/group/message/delete?id='.$id ),
					'grid'	=> $grid
				];
				
				return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $response );
			}
		}
		
		return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	} 

	public function actionDelete( $id ) {
		
		$model	= GroupMessageService::findById( $id );
		$grid	= Yii::$app->request->post( 'grid' );
		
		if( GroupMessageService::delete( $model ) ) {
			 
			return AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $grid );
		}
		
		return AjaxUtil::generateFailure( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
?>