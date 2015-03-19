<?php
namespace cmsgears\modules\community\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\modules\core\common\config\CoreGlobal;
use cmsgears\modules\community\common\config\CommunityGlobal;

use cmsgears\modules\core\common\models\entities\CmgFile;
use cmsgears\modules\core\common\models\entities\Category;

use cmsgears\modules\community\common\models\entities\Group;
use cmsgears\modules\community\common\models\entities\CommunityPermission;

use cmsgears\modules\community\admin\models\forms\GroupCategoryBinderForm;

use cmsgears\modules\core\admin\services\CategoryService;
use cmsgears\modules\community\admin\services\GroupService;
use cmsgears\modules\community\admin\services\GroupMemberService;
use cmsgears\modules\community\admin\services\GroupMessageService;

use cmsgears\modules\core\admin\controllers\BaseController;

use cmsgears\modules\core\common\utilities\MessageUtil;

class GroupController extends BaseController {

	const URL_ALL 			= 'all';
	const URL_ALL_MEMBERS 	= 'members?id=';
	const URL_ALL_MESSAGES 	= 'messages?id=';

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
	                'index'  => CommunityPermission::PERM_COMMUNITY_GROUP,
	                'all'    => CommunityPermission::PERM_COMMUNITY_GROUP,
	                'create' => CommunityPermission::PERM_COMMUNITY_GROUP,
	                'update' => CommunityPermission::PERM_COMMUNITY_GROUP,
	                'delete' => CommunityPermission::PERM_COMMUNITY_GROUP,
	                'members' => CommunityPermission::PERM_COMMUNITY_GROUP,
	                'messages' => CommunityPermission::PERM_COMMUNITY_GROUP,
	                'deleteMessage' => CommunityPermission::PERM_COMMUNITY_GROUP,
	                'deleteMember' => CommunityPermission::PERM_COMMUNITY_GROUP
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
	                'messages' => ['get'],
	                'deleteMessage' => ['get', 'post'],
	                'deleteMember' => ['get', 'post']
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
		$allCategories	= CategoryService::getIdNameMapByType( CommunityGlobal::CATEGORY_TYPE_GROUP );

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

				$binder->groupId	= $model->getId();
				$binder->load( Yii::$app->request->post( "Binder" ), "" );

				GroupService::bindCategories( $binder );

				return $this->redirect( [ self::URL_ALL ] );
			}
		}

		$categories		= CategoryService::getIdNameMapByType( CommunityGlobal::CATEGORY_TYPE_GROUP );
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
	
					$binder->groupId	= $model->getId();
					$binder->load( Yii::$app->request->post( "Binder" ), "" );
	
					GroupService::bindCategories( $binder );

					$this->refresh();
				}
			}

			$categories		= CategoryService::getIdNameMapByType( CommunityGlobal::CATEGORY_TYPE_GROUP );
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
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model		= GroupService::findById( $id );
		$avatar 	= new CmgFile();
		$banner 	= new CmgFile();

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( isset( $_POST ) && count( $_POST ) > 0 ) {

				if( GroupService::delete( $model ) ) {

					return $this->redirect( [ self::URL_ALL ] );
				}
			}

			$categories		= CategoryService::getIdNameMapByType( CommunityGlobal::CATEGORY_TYPE_GROUP );
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
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	// Categories -------------------

	public function actionCategories() {

		$pagination = CategoryService::getPaginationByType( CommunityGlobal::CATEGORY_TYPE_GROUP );

	    return $this->render('categories', [
	         'page' => $pagination['page'],
	         'pages' => $pagination['pages'],
	         'total' => $pagination['total'],
	         'type' => CommunityGlobal::CATEGORY_TYPE_GROUP
	    ]);
	}

	// Members --------------------------------

	public function actionMembers( $id ) {

		// Find Model
		$model		= GroupService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$pagination = GroupMemberService::getPaginationByGroup( $id );

		    return $this->render('member/all', [
		         'page' => $pagination['page'],
		         'pages' => $pagination['pages'],
		         'total' => $pagination['total'],
		         'group' => $model
		    ]);
		}
		
		// Model not found
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
	
	public function actionDeleteMember( $gid, $id ) {

		// Find Model
		$group	= GroupService::findById( $gid );
		$model	= GroupMemberService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( isset( $_POST ) && count( $_POST ) > 0 ) {

				if( GroupMemberService::delete( $model ) ) {

					return $this->redirect( [ self::URL_ALL_MEMBERS . $gid ] );
				}
			}

	    	return $this->render( 'member/delete', [
	    		'group' => $group,
	    		'model' => $model
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
	
	// Messages --------------------------------

	public function actionMessages( $id ) {

		// Find Model
		$model		= GroupService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$pagination = GroupMessageService::getPaginationByGroup( $id );

		    return $this->render('message/all', [
		         'page' => $pagination['page'],
		         'pages' => $pagination['pages'],
		         'total' => $pagination['total'],
		         'group' => $model
		    ]);
		}
		
		// Model not found
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
	
	public function actionDeleteMessage( $gid, $id ) {

		// Find Model
		$group	= GroupService::findById( $gid );
		$model	= GroupMessageService::findById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( isset( $_POST ) && count( $_POST ) > 0 ) {

				if( GroupMessageService::delete( $model ) ) {

					return $this->redirect( [ self::URL_ALL_MESSAGES . $gid ] );
				}
			}

	    	return $this->render( 'message/delete', [
	    		'group' => $group,
	    		'model' => $model
	    	]);
		}

		// Model not found
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>