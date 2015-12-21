<?php
namespace cmsgears\community\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter; 

// CMG Imports
use cmsgears\core\common\config\CoreGlobal; 
use cmsgears\core\frontend\config\WebGlobalCore;  
use cmsgears\community\common\config\CmnGlobal;	
use cmsgears\community\admin\services\GroupService; 
use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\Category; 

use cmsgears\core\common\models\forms\Binder;
use cmsgears\cms\common\models\entities\ModelContent;
use cmsgears\community\common\models\entities\Group; 
use cmsgears\community\common\models\entities\GroupMember; 
use cmsgears\core\admin\services\CategoryService;
use cmsgears\core\admin\services\TemplateService;

class GroupController extends \cmsgears\core\common\controllers\BaseController {

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
	                'index' => [ 'permission' => CoreGlobal::PERM_USER ],
	                'update' => [ 'permission' => CoreGlobal::PERM_USER ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => [ 'get' ],
                    'update' => [ 'get', 'post' ]
                ]
            ]
        ];
    }

	// GroupController

    public function actionIndex() {
    	
		$dataProvider			= GroupService::getPaginationDetailsByType( CoreGlobal::TYPE_CORE );
		$user					= Yii::$app->user->getIdentity(); 
		$statusActive			= Group::STATUS_ACTIVE;	
		$memberStatusNew		= GroupMember::STATUS_NEW;
		$memberStatusActive		= GroupMember::STATUS_ACTIVE;
		$memberStatusBlocked	= GroupMember::STATUS_BLOCKED; 	

	    return $this->render( WebGlobalCore::PAGE_INDEX, [
	         'dataProvider' => $dataProvider,
	         'user' => $user,
	         'statusActive' => $statusActive,
	         'memberStatusNew' => $memberStatusNew,
			 'memberStatusActive' => $memberStatusActive,
			 'memberStatusBlocked' => $memberStatusBlocked,
	    ]);
    }
	
	public function actionCreate() {

		$model			= new Group();
		$content		= new ModelContent();
		$avatar 		= new CmgFile();
		$banner 		= new CmgFile();

		$model->setScenario( 'create' );
		$model->type	= CoreGlobal::TYPE_CORE;
		$model->visibility = Group::VISIBILITY_PUBLIC;

		if( $model->load( Yii::$app->request->post(), 'Group' ) && $content->load( Yii::$app->request->post(), 'ModelContent' ) &&
		    $model->validate() && $content->validate() ) {

			$avatar->load( Yii::$app->request->post(), 'Avatar' );
			$banner->load( Yii::$app->request->post(), 'Banner' );

			if( $modelGroup =  GroupService::create( $model, $content, $avatar, $banner ) ) {

				$binder = new Binder();

				$binder->binderId	= $model->id;
				$binder->load( Yii::$app->request->post(), 'Binder' );

				GroupService::bindCategories( $binder, $modelGroup->type );

				return $this->redirect( [ 'index' ] );
			}
		}

		$categories		= CategoryService::getIdNameListByType( CmnGlobal::TYPE_GROUP );
		$visibilityMap	= Group::$visibilityMap;
		$statusMap		= Group::$statusMap;
		$templateMap	= TemplateService::getIdNameMap( CmnGlobal::TYPE_GROUP );

    	return $this->render( 'create', [
    		'model' => $model,
    		'content' => $content,
    		'avatar' => $avatar,
    		'banner' => $banner,
    		'categories' => $categories,
	    	'visibilityMap' => $visibilityMap,
	    	'statusMap' => $statusMap,
	    	'templateMap' => $templateMap
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= GroupService::findById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$content	= $model->content;
			$avatar 	= CmgFile::loadFile( $model->avatar, 'Avatar' );
			$banner 	= CmgFile::loadFile( $content->banner, 'Banner' );

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'Group' ) && $content->load( Yii::$app->request->post(), 'ModelContent' ) &&
			    $model->validate() && $content->validate() ) {

				if( GroupService::update( $model, $content, $avatar, $banner ) ) {

					$binder = new Binder();

					$binder->binderId	= $model->id;
					$binder->load( Yii::$app->request->post(), 'Binder' );

					GroupService::bindCategories( $binder, $model->type );

					return $this->redirect( [ 'index' ] );
				}
			}

			$categories		= CategoryService::getIdNameListByType( CmnGlobal::TYPE_GROUP );
			$visibilityMap	= Group::$visibilityMap;
			$statusMap		= Group::$statusMap;
			$templateMap	= TemplateService::getIdNameMap( CmnGlobal::TYPE_GROUP );

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'content' => $content,
	    		'avatar' => $avatar,
	    		'banner' => $banner,
	    		'categories' => $categories,
		    	'visibilityMap' => $visibilityMap,
		    	'statusMap' => $statusMap,
		    	'templateMap' => $templateMap
	    	]);
		}
		
		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
  
}

?>