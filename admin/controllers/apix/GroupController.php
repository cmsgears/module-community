<?php
namespace cmsgears\modules\community\admin\controllers\apix;

// Yii Imports
use \Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\modules\core\common\config\CoreGlobal;

use cmsgears\modules\community\common\models\entities\CommunityPermission;

use cmsgears\modules\community\admin\models\forms\GroupCategoryBinderForm;

use cmsgears\modules\community\admin\services\GroupService;

use cmsgears\modules\community\core\utilities\MessageUtil;
use cmsgears\modules\community\core\utilities\AjaxUtil;

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
                'permissions' => [
	                'bindCategories'  => CommunityPermission::PERM_COMMUNITY_GROUP
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
				AjaxUtil::generateSuccess( MessageUtil::getMessage( CoreGlobal::MESSAGE_REQUEST ) );
			}
		}

		// Trigger Ajax Failure
        AjaxUtil::generateFailure( MessageUtil::getMessage( CoreGlobal::ERROR_REQUEST ) );
	}
}

?>