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

use cmsgears\community\common\models\entities\Group;
use cmsgears\community\common\models\entities\GroupMember;
use cmsgears\community\admin\models\forms\GroupCategoryBinderForm;

use cmsgears\core\admin\services\CategoryService;
use cmsgears\community\admin\services\GroupService;
use cmsgears\community\admin\services\GroupMemberService;
use cmsgears\community\admin\services\GroupMessageService;

use cmsgears\core\admin\controllers\BaseController;

class GroupController extends BaseController {

	const URL_ALL 			= 'all';

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

	    $this->redirect( self::URL_ALL );
	}

	public function actionAll() {

		$pagination = GroupService::getPagination();

	    return $this->render('all', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total']
	    ]);
	}

	public function actionMatrix() {

		$pagination 	= GroupService::getPagination();
		$allCategories	= CategoryService::getIdNameMapByType( CmnGlobal::CATEGORY_TYPE_GROUP );

	    return $this->render('matrix', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total'],
	         'allCategories' => $allCategories
	    ]);
	}

	public function actionCreate() {

		$model	= new Group();
		$avatar = new CmgFile();
		$banner = new CmgFile();

		$model->setScenario( "create" );

		if( $model->load( Yii::$app->request->post( "Group" ), "" )  && $model->validate() ) {

			$avatar->load( Yii::$app->request->post( "Avatar" ), "" );
			$banner->load( Yii::$app->request->post( "Banner" ), "" );

			if( GroupService::create( $model, $avatar, $banner ) ) {

				$binder = new GroupCategoryBinderForm();

				$binder->groupId	= $model->id;
				$binder->load( Yii::$app->request->post( "Binder" ), "" );

				GroupService::bindCategories( $binder );

				return $this->redirect( [ self::URL_ALL ] );
			}
		}

		$categories		= CategoryService::getIdNameMapByType( CmnGlobal::CATEGORY_TYPE_GROUP );
		$visibilities	= Group::$visibilityMap;
		$status			= Group::$statusMap;

    	return $this->render('create', [
    		'model' => $model,
    		'avatar' => $avatar,
    		'banner' => $banner,
    		'categories' => $categories,
	    	'visibilities' => $visibilities,
	    	'status' => $status
    	]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= GroupService::findById( $id );
		$avatar 	= new CmgFile();
		$banner 	= new CmgFile();

		// Update/Render if exist
		if( isset( $model ) ) {

			$model->setScenario( "update" );

			if( $model->load( Yii::$app->request->post( "Group" ), "" )  && $model->validate() ) {

				$avatar->load( Yii::$app->request->post( "Avatar" ), "" );
				$banner->load( Yii::$app->request->post( "Banner" ), "" );

				if( GroupService::update( $model, $avatar, $banner ) ) {

					$binder = new GroupCategoryBinderForm();
	
					$binder->groupId	= $model->id;
					$binder->load( Yii::$app->request->post( "Binder" ), "" );
	
					GroupService::bindCategories( $binder );

					$this->refresh();
				}
			}

			$categories		= CategoryService::getIdNameMapByType( CmnGlobal::CATEGORY_TYPE_GROUP );
			$visibilities	= Group::$visibilityMap;
			$status			= Group::$statusMap;
			$avatar			= $model->avatar;
			$banner			= $model->banner;

	    	return $this->render( 'update', [
	    		'model' => $model,
	    		'avatar' => $avatar,
	    		'banner' => $banner,
	    		'categories' => $categories,
	    		'visibilities' => $visibilities,
	    		'status' => $status
	    	]);
		}
		
		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model		= GroupService::findById( $id );
		$avatar 	= new CmgFile();
		$banner 	= new CmgFile();

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post( "Group" ), "" ) ) {

				if( GroupService::delete( $model ) ) {

					return $this->redirect( [ self::URL_ALL ] );
				}
			}

			$categories		= CategoryService::getIdNameMapByType( CmnGlobal::CATEGORY_TYPE_GROUP );
			$visibilities	= Group::$visibilityMap;
			$status			= Group::$statusMap;
			$avatar			= $model->avatar;
			$banner			= $model->banner;

	    	return $this->render( 'delete', [
	    		'model' => $model,
	    		'avatar' => $avatar,
	    		'banner' => $banner,
	    		'categories' => $categories,
	    		'visibilities' => $visibilities,
	    		'status' => $status
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	// Categories -------------------

	public function actionCategories() {

		$pagination = CategoryService::getPaginationByType( CmnGlobal::CATEGORY_TYPE_GROUP );

	    return $this->render('categories', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total'],
	         'type' => CmnGlobal::CATEGORY_TYPE_GROUP
	    ]);
	}

	// Members --------------------------------

	public function actionMembers( $id ) {

		// Find Model
		$model		= GroupService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$pagination = GroupMemberService::getPaginationByGroupId( $id );

		    return $this->render('/group/member/all', [
		         'page' => $pagination['page'],
		         'pages' => $pagination['pages'],
		         'total' => $pagination['total'],
		         'group' => $model
		    ]);
		}
		
		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
	
	public function actionDeleteMember( $gid, $id ) {

		// Find Model
		$group	= GroupService::findById( $gid );
		$model	= GroupMemberService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post( "GroupMember" ), "" ) ) {

				if( GroupMemberService::delete( $model ) ) {

					return $this->redirect( [ 'members?id=' . $gid ] );
				}
			}

	    	return $this->render( '/group/member/delete', [
	    		'group' => $group,
	    		'model' => $model,
	    		'statusMap' => GroupMember::$statusMap
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
	
	// Messages --------------------------------

	public function actionMessages( $id ) {

		// Find Model
		$model		= GroupService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$pagination = GroupMessageService::getPaginationByGroupId( $id );

		    return $this->render( '/group/message/all', [
		         'page' => $pagination['page'],
		         'pages' => $pagination['pages'],
		         'total' => $pagination['total'],
		         'group' => $model
		    ]);
		}
		
		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
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

	    	return $this->render( '/group/message/delete', [
	    		'group' => $group,
	    		'model' => $model
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>