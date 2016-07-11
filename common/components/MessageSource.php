<?php
namespace cmsgears\community\common\components;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\community\common\config\CmnGlobal;

class MessageSource extends \yii\base\Component {

	// Variables ---------------------------------------------------

	// Global -----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	private $messageDb = [
		// Generic Fields
		CmnGlobal::FIELD_FRIEND => 'Friend',
		CmnGlobal::FIELD_GROUP => 'Group',
		CmnGlobal::FIELD_CHAT => 'Chat',
		CmnGlobal::FIELD_CONSUMED => 'Consumed'
	];

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// MessageSource -------------------------

	public function getMessage( $messageKey, $params = [], $language = null ) {

		return $this->messageDb[ $messageKey ];
	}
}
