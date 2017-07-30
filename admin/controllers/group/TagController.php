<?php
namespace cmsgears\community\admin\controllers\group;

// Yii Imports
use \Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

class TagController extends \cmsgears\cms\admin\controllers\base\TagController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

        parent::init();

		$this->crudPermission 	= CmnGlobal::PERM_GROUP;

		$this->type				= CmnGlobal::TYPE_GROUP;
		$this->templateType		= CmnGlobal::TYPE_GROUP;

		$this->sidebar 			= [ 'parent' => 'sidebar-community', 'child' => 'group-tag' ];
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/community/group/tag/all' ], true );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TagController -------------------------

	public function actionAll() {

		Url::remember( [ 'group/tag/all' ], 'tags' );

		return parent::actionAll();
	}
}
