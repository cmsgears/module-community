<?php
namespace cmsgears\community\admin\controllers\group;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

class MemberController extends BaseMemberController {

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
	                'all' => [ 'permission' => CmnGlobal::PERM_GROUP ],
	                'delete' => [ 'permission' => CmnGlobal::PERM_GROUP ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'all'    => ['get'],
	                'delete' => ['get', 'post']
                ]
            ]
        ];
    }

	// MemberController

	public function actionAll( $id ) {

		return parent::actionAll( $id, [ 'parent' => 'sidebar-group', 'child' => 'group' ] );
	}

	public function actionDelete( $gid, $id ) {

		return parent::actionDelete( $gid, $id, [ 'parent' => 'sidebar-group', 'child' => 'group' ] );
	}
}

?>