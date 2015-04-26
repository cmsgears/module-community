<?php
namespace cmsgears\community\admin\controllers\apix;

// Yii Imports
use \Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\community\admin\models\forms\GroupCategoryBinderForm;

use cmsgears\community\admin\services\GroupService;

use cmsgears\core\common\utilities\AjaxUtil;

class GroupController extends Controller {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->cmgCore->getRbacFilterClass(),
                'actions' => [
	                'bindCategories'  => [ 'permission' => CmnGlobal::PERM_GROUP ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'bindCategories'  => ['get']
                ]
            ]
        ];
    }

	// UserController

	public function actionBindCategories() {

		$binder = new GroupCategoryBinderForm();

		if( $binder->load( Yii::$app->request->post(), "" ) ) {

			if( GroupService::bindCategories( $binder ) ) {

				// Trigger Ajax Success
				AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::MESSAGE_REQUEST ) );
			}
		}

		// Trigger Ajax Failure
        AjaxUtil::generateFailure( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_REQUEST ) );
	}
}

?>