<?php
namespace cmsgears\community\admin\controllers\apix;

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

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

		parent::init();

		$this->crudPermission	= CmnGlobal::PERM_GROUP;
		$this->modelService		= Yii::$app->factory->get( 'groupService' );
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
	                'updateAvatar' => [ 'permission' => $this->crudPermission ],
	                'assignCategory' => [ 'permission' => $this->crudPermission ],
	                'removeCategory' => [ 'permission' => $this->crudPermission ],
	                'assignTags' => [ 'permission' => $this->crudPermission ],
	                'removeTag' => [ 'permission' => $this->crudPermission ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'autoSearch' => [ 'post' ],
                    'updateAvatar' => [ 'post' ],
                    'assignCategory' => [ 'post' ],
                    'removeCategory' => [ 'post' ],
	                'assignTags' => [ 'post' ],
	                'removeTag' => [ 'post' ]
                ]
            ]
        ];
    }

	// yii\base\Controller ----

    public function actions() {

        return [
        	'auto-search' => [ 'class' => 'cmsgears\core\common\actions\content\AutoSearch' ],
            'update-avatar' => [ 'class' => 'cmsgears\core\common\actions\content\UpdateAvatar' ],
            'assign-category' => [ 'class' => 'cmsgears\core\common\actions\category\AssignCategory' ],
            'remove-category' => [ 'class' => 'cmsgears\core\common\actions\category\RemoveCategory' ],
            'assign-tags' => [ 'class' => 'cmsgears\core\common\actions\tag\AssignTags' ],
            'remove-tag' => [ 'class' => 'cmsgears\core\common\actions\tag\RemoveTag' ]
		];
    }

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// GroupController -----------------------
}
