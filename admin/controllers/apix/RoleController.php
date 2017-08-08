<?php
namespace cmsgears\community\admin\controllers\apix;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

class RoleController extends \cmsgears\core\admin\controllers\apix\RoleController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission 	= CmnGlobal::PERM_COMMUNITY;
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// RoleController ------------------------

}
