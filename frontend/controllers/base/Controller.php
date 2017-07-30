<?php
namespace cmsgears\cms\frontend\controllers\base;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsProperties;

class Controller extends \cmsgears\core\frontend\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Private ----------------

	private $cmsProperties;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Controller ----------------------------

	public function getCmsProperties() {

		if( !isset( $this->cmsProperties ) ) {

			$this->cmsProperties	= CmsProperties::getInstance();
		}

		return $this->cmsProperties;
	}
}
