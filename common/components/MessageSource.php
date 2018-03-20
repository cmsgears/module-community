<?php
namespace cmsgears\community\common\components;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

class MessageSource extends \yii\base\Component {

	// Variables ---------------------------------------------------

	// Global -----------------

	// Public -----------------

	// Protected --------------

	protected $messageDb = [
		// Generic Fields
		CmnGlobal::FIELD_FRIEND => 'Friend',
		CmnGlobal::FIELD_GROUP => 'Group',
		CmnGlobal::FIELD_CHAT => 'Chat',
		CmnGlobal::FIELD_BROADCASTED => 'Broadcasted'
	];

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// MessageSource -------------------------

	public function getMessage( $messageKey, $params = [], $language = null ) {

		return $this->messageDb[ $messageKey ];
	}

}
