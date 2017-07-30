<?php
namespace cmsgears\cms\admin\controllers\page;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\ModelComment;

class CommentController extends \cmsgears\core\admin\controllers\base\CommentController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

        $this->crudPermission	= CmsGlobal::PERM_BLOG_ADMIN;

		$this->commentUrl		= 'page/comment';

		$this->parentType		= CmsGlobal::TYPE_PAGE;
		$this->commentType		= ModelComment::TYPE_COMMENT;

		$this->parentService	= Yii::$app->factory->get( 'pageService' );

		$this->sidebar 			= [ 'parent' => 'sidebar-cms', 'child' => 'page-comments' ];

		$this->returnUrl		= Url::previous( $this->commentUrl );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/page/comment/all' ], true );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// CommentController ---------------------

}
