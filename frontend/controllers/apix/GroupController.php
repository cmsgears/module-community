<?php
namespace cmsgears\community\frontend\controllers\apix;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

use cmsgears\core\common\utilities\AjaxUtil;

class GroupController extends \cmsgears\core\admin\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $metaService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

		parent::init();

		$this->crudPermission	= CoreGlobal::PERM_USER;
		$this->modelService		= Yii::$app->factory->get( 'groupService' );
		$this->metaService		= Yii::$app->factory->get( 'groupMetaService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->core->getRbacFilterClass(),
                'actions' => [
	                'updateAvatar' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'updateBanner' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'assignCategory' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'removeCategory' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'assignTags' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'removeTag' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'addMeta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'updateMeta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'deleteMeta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
	                'delete' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'autoSearch' => [ 'post' ],
                    'updateAvatar' => [ 'post' ],
                    'updateBanner' => [ 'post' ],
                    'assignCategory' => [ 'post' ],
                    'removeCategory' => [ 'post' ],
	                'assignTags' => [ 'post' ],
	                'removeTag' => [ 'post' ],
	                'addMeta' => [ 'post' ],
	                'updateMeta' => [ 'post' ],
	                'deleteMeta' => [ 'post' ],
	                'follow' => [ 'post' ],
	                'like' => [ 'post' ],
	                'wishlist' => [ 'post' ],
	                'delete' => [ 'post' ]
                ]
            ]
        ];
    }

	// yii\base\Controller ----

    public function actions() {

        return [
        	'auto-search' => [ 'class' => 'cmsgears\core\common\actions\content\AutoSearch' ],
            'update-avatar' => [ 'class' => 'cmsgears\core\common\actions\content\UpdateAvatar' ],
            'update-banner' => [ 'class' => 'cmsgears\core\common\actions\content\UpdateContentBanner' ],
            'assign-category' => [ 'class' => 'cmsgears\core\common\actions\category\AssignCategory' ],
            'remove-category' => [ 'class' => 'cmsgears\core\common\actions\category\RemoveCategory' ],
            'assign-tags' => [ 'class' => 'cmsgears\core\common\actions\tag\AssignTags' ],
            'remove-tag' => [ 'class' => 'cmsgears\core\common\actions\tag\RemoveTag' ],
            'add-meta' => [ 'class' => 'cmsgears\core\common\actions\attribute\CreateMeta' ],
            'update-meta' => [ 'class' => 'cmsgears\core\common\actions\attribute\UpdateMeta' ],
            'delete-meta' => [ 'class' => 'cmsgears\core\common\actions\attribute\DeleteMeta' ],
            'follow' => [ 'class' => 'cmsgears\community\frontend\actions\follower\Follow' ],
            'like' => [ 'class' => 'cmsgears\community\frontend\actions\follower\Like' ],
            'wishlist' => [ 'class' => 'cmsgears\community\frontend\actions\follower\Wishlist' ]
		];
    }

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// GroupController -----------------------

	public function actionDelete( $id ) {

		$model	= $this->modelService->getById( $id );

		if( GroupService::delete( $model, $model->content ) ) {

			return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ) );
		}

		// Trigger Ajax Not Found
        return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
