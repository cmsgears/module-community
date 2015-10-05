<?php
namespace cmsgears\community\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter; 

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore; 

use cmsgears\community\common\services\GroupService;
use cmsgears\community\common\services\GroupMemberService;

class GroupController extends BaseController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {
 		
		$this->layout	= WebGlobalCore::LAYOUT_PRIVATE;

        parent::__construct( $id, $module, $config );
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->cmgCore->getRbacFilterClass(),
                'actions' => [
	                'index' => [ 'permission' => CoreGlobal::PERM_USER ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => [ 'get' ]
                ]
            ]
        ];
    }

	// GroupController

    public function actionIndex() {
    	
		$dataProvider	= GroupService::getPaginationDetailsByType( CoreGlobal::TYPE_CORE );
		$user			= Yii::$app->user->getIdentity(); 

	    return $this->render( WebGlobalCore::PAGE_INDEX, [
	         'dataProvider' => $dataProvider,
	         'user' => $user
	    ]); 
    }
  
}

?>