<?php
namespace cmsgears\community\frontend\controllers\apix; 

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\services\GroupService; 
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
	                'delete' => [ 'permission' => CoreGlobal::PERM_USER ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => [ 'post' ]
                ]
            ]
        ];
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