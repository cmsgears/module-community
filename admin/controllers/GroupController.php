<?php
namespace cmsgears\community\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\Category;

use cmsgears\core\common\models\forms\Binder;
use cmsgears\cms\common\models\entities\ModelContent;
use cmsgears\community\common\models\entities\Group;
use cmsgears\community\common\models\entities\GroupMember;

use cmsgears\core\admin\services\CategoryService;
use cmsgears\core\admin\services\TemplateService;
use cmsgears\community\admin\services\GroupService;
use cmsgears\community\admin\services\GroupMemberService;
use cmsgears\community\admin\services\GroupMessageService;

use cmsgears\core\admin\controllers\BaseController;

class GroupController extends BaseController {

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
	                'index'  => [ 'permission' => CmnGlobal::PERM_GROUP ],
	                'all'    => [ 'permission' => CmnGlobal::PERM_GROUP ],
	                'create' => [ 'permission' => CmnGlobal::PERM_GROUP ],
	                'update' => [ 'permission' => CmnGlobal::PERM_GROUP ],
	                'delete' => [ 'permission' => CmnGlobal::PERM_GROUP ],
	                'members' => [ 'permission' => CmnGlobal::PERM_GROUP ],
	                'deleteMember' => [ 'permission' => CmnGlobal::PERM_GROUP ],
	                'messages' => [ 'permission' => CmnGlobal::PERM_GROUP ],
	                'deleteMessage' => [ 'permission' => CmnGlobal::PERM_GROUP ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'index'  => ['get'],
	                'all'    => ['get'],
	                'create' => ['get', 'post'],
	                'update' => ['get', 'post'],
	                'delete' => ['get', 'post'],
	                'members' => ['get'],
	                'deleteMember' => ['get', 'post'],
	                'messages' => ['get'],
	                'deleteMessage' => ['get', 'post']
                ]
            ]
        ];
    }

	// GroupController

	public function actionIndex() {

	    $this->redirect( [ 'all' ] );
	}

	public function actionAll() {

		$dataProvider = GroupService::getPagination();

	    return $this->render( 'all', [
	         'dataProvider' => $dataProvider
	    ]);
	}

	public function actionMatrix() {

		$dataProvider 	= GroupService::getPagination();
		$categoriesList	= CategoryService::getIdNameListByType( CmnGlobal::TYPE_GROUP );

	    return $this->render( 'matrix', [
	         'dataProvider' => $dataProvider,
	         'categoriesList' => $categoriesList
	    ]);
	}

	public function actionCreate() {

		$model		= new Group();
		$content	= new ModelContent();
		$avatar 	= new CmgFile();
		$banner 	= new CmgFile();

		$model->setScenario( 'create' );
		$model->type	= CoreGlobal::TYPE_CORE;

		if( $model->load( Yii::$app->request->post(), 'Group' )  && $model->validate() &&
		    $content->load( Yii::$app->request->post(), 'ModelContent' )  && $content->validate() ) {

			$avatar->load( Yii::$app->request->post(), 'Avatar' );
			$banner->load( Yii::$app->request->post(), 'Banner' );

			if( GroupService::create( $model, CmnGlobal::TYPE_GROUP, $content, $avatar, $banner ) ) {

				$binder = new Binder();

				$binder->binderId	= $model->id;
				$binder->load( Yii::$app->request->post(), 'Binder' );

				GroupService::bindCategories( $binder, CmnGlobal::TYPE_GROUP );

				return $this->redirect( [ 'all' ] );
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
			$avatar 	= new CmgFile();
			$banner 	= new CmgFile();

			$model->setScenario( 'update' );

			if( $model->load( Yii::$app->request->post(), 'Group' )  && $model->validate() &&
			    $content->load( Yii::$app->request->post(), 'ModelContent' )  && $content->validate() ) {
	
				$avatar->load( Yii::$app->request->post(), 'Avatar' );
				$banner->load( Yii::$app->request->post(), 'Banner' );

				if( GroupService::update( $model, $content, $avatar, $banner ) ) {

					$binder = new Binder();
	
					$binder->binderId	= $model->id;
					$binder->load( Yii::$app->request->post(), 'Binder' );
	
					GroupService::bindCategories( $binder, CmnGlobal::TYPE_GROUP );

					return $this->redirect( [ 'all' ] );
				}
			}

			$avatar			= $model->avatar;
			$banner			= $content->banner;
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

	public function actionDelete( $id ) {

		// Find Model
		$model		= GroupService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$content	= $model->content;

			if( $model->load( Yii::$app->request->post(), 'Group' ) ) {

				if( GroupService::delete( $model, $content ) ) {

					return $this->redirect( [ 'all' ] );
				}
			}

			$avatar			= $model->avatar;
			$banner			= $content->banner;
			$categories		= CategoryService::getIdNameListByType( CmnGlobal::TYPE_GROUP );
			$visibilityMap	= Group::$visibilityMap;
			$statusMap		= Group::$statusMap;
			$templateMap	= TemplateService::getIdNameMap( CmnGlobal::TYPE_GROUP );

	    	return $this->render( 'delete', [
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

	// Members --------------------------------

	public function actionMembers( $id ) {

		// Find Model
		$model		= GroupService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$dataProvider = GroupMemberService::getPaginationByGroupId( $id );

		    return $this->render( 'member/all', [
		         'dataProvider' => $dataProvider,
		         'group' => $model
		    ]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDeleteMember( $gid, $id ) {

		// Find Model
		$group	= GroupService::findById( $gid );
		$model	= GroupMemberService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post(), 'GroupMember' ) ) {

				if( GroupMemberService::delete( $model ) ) {

					return $this->redirect( [ 'members?id=' . $gid ] );
				}
			}

	    	return $this->render( 'member/delete', [
	    		'group' => $group,
	    		'model' => $model,
	    		'statusMap' => GroupMember::$statusMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
	
	// Messages --------------------------------

	public function actionMessages( $id ) {

		// Find Model
		$model		= GroupService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$dataProvider = GroupMessageService::getPaginationByGroupId( $id );

		    return $this->render( 'message/all', [
		         'dataProvider' => $dataProvider,
		         'group' => $model
		    ]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
	
	public function actionDeleteMessage( $gid, $id ) {

		// Find Model
		$group	= GroupService::findById( $gid );
		$model	= GroupMessageService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post( "GroupMessage" ), "" ) ) {

				if( GroupMessageService::delete( $model ) ) {

					return $this->redirect( [ 'messages?id=' . $gid ] );
				}
			}

	    	return $this->render( 'message/delete', [
	    		'group' => $group,
	    		'model' => $model
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>