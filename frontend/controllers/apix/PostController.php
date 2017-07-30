<?php
namespace cmsgears\cms\frontend\controllers\apix;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\utilities\AjaxUtil;

class PostController extends \cmsgears\core\admin\controllers\base\Controller {

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
		$this->modelService		= Yii::$app->factory->get( 'postService' );
		$this->metaService		= Yii::$app->factory->get( 'contentMetaService' );
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
					'assign-category' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'remove-category' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'assign-tags' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'remove-tag' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'add-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'update-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ],
					'delete-meta' => [ 'permission' => $this->crudPermission, 'filters' => [ 'owner' ] ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'auto-search' => [ 'post' ],
					'assign-category' => [ 'post' ],
					'remove-category' => [ 'post' ],
					'assign-tags' => [ 'post' ],
					'remove-tag' => [ 'post' ],
					'add-meta' => [ 'post' ],
					'update-meta' => [ 'post' ],
					'delete-meta' => [ 'post' ],
					'submit-comment' => [ 'post' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	public function actions() {

		return [
			'auto-search' => [ 'class' => 'cmsgears\core\common\actions\content\AutoSearch' ],
			'assign-category' => [ 'class' => 'cmsgears\core\common\actions\category\AssignCategory' ],
			'remove-category' => [ 'class' => 'cmsgears\core\common\actions\category\RemoveCategory' ],
			'assign-tags' => [ 'class' => 'cmsgears\core\common\actions\tag\AssignTags' ],
			'remove-tag' => [ 'class' => 'cmsgears\core\common\actions\tag\RemoveTag' ],
			'add-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\CreateMeta' ],
			'update-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\UpdateMeta' ],
			'delete-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\DeleteMeta' ],
			'submit-comment' => [ 'class' => 'cmsgears\core\common\actions\comment\Comment' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostController ------------------------

}
