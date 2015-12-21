<?php
namespace cmsgears\community\admin\controllers\group;

// Yii Imports
use \Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\db\IntegrityException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\entities\Category;

use cmsgears\core\admin\services\CategoryService;

class CategoryController extends \cmsgears\core\admin\controllers\BaseCategoryController {

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
	                'all'  => [ 'permission' => CmnGlobal::PERM_GROUP ],
	                'create'  => [ 'permission' => CmnGlobal::PERM_GROUP ],
	                'update'  => [ 'permission' => CmnGlobal::PERM_GROUP ],
	                'delete'  => [ 'permission' => CmnGlobal::PERM_GROUP ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'all'  => ['get'],
	                'create'  => ['get', 'post'],
	                'update'  => ['get', 'post'],
	                'delete'  => ['get', 'post']
                ]
            ]
        ];
    }

	// CategoryController --------------------

	public function actionAll( $type = null ) {
		
		Url::remember( [ 'group/category/all' ], 'categories' );

		return parent::actionAll( [ 'parent' => 'sidebar-group', 'child' => 'category' ], CmnGlobal::TYPE_GROUP, false );
	}
	
	public function actionCreate() {

		return parent::actionCreate( Url::previous( 'categories' ), [ 'parent' => 'sidebar-group', 'child' => 'category' ], CmnGlobal::TYPE_GROUP, false );
	}
	 
	public function actionUpdate( $id ) {

		return parent::actionUpdate( $id, Url::previous( 'categories' ), [ 'parent' => 'sidebar-group', 'child' => 'category' ], CmnGlobal::TYPE_GROUP, false );
	}
	
	public function actionDelete( $id ) {

		return parent::actionDelete( $id, Url::previous( 'categories' ), [ 'parent' => 'sidebar-group', 'child' => 'category' ], CmnGlobal::TYPE_GROUP, false );
	}
}

?>