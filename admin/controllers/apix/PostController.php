<?php
namespace cmsgears\cms\admin\controllers\apix;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class PostController extends \cmsgears\core\admin\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permissions
		$this->crudPermission	= CmsGlobal::PERM_BLOG_ADMIN;
		
		// Services
		$this->modelService		= Yii::$app->factory->get( 'postService' );
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
					'bindCategories' => [ 'permission' => $this->crudPermission ],
					'assignTags' => [ 'permission' => $this->crudPermission ],
					'removeTag' => [ 'permission' => $this->crudPermission ],
					'submitComment' => [ 'permission' => $this->crudPermission ],
					'bulk' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'bindCategories' => [ 'post' ],
					'assignTags' => [ 'post' ],
					'removeTag' => [ 'post' ],
					'submitComment' => [ 'post' ],
					'bulk' => [ 'post' ],
					'delete' => [ 'post' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	public function actions() {

		return [
			'bind-categories' => [
				'class' => 'cmsgears\core\common\actions\tag\BindCategories'
			],
			'assign-tags' => [
				'class' => 'cmsgears\core\common\actions\tag\AssignTags',
				'typed' => true, 'parent' => true
			],
			'remove-tag' => [
				'class' => 'cmsgears\core\common\actions\tag\RemoveTag',
				'typed' => true, 'parent' => true
			],
			'submit-comment' => [
				'class' => 'cmsgears\core\common\actions\comment\CreateComment'
			],
			'bulk' => [ 
				'class' => 'cmsgears\core\common\actions\grid\Bulk' 
			],
			'delete' => [ 
				'class' => 'cmsgears\core\common\actions\grid\Delete' 
			]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostController ------------------------
}
