<?php
namespace cmsgears\community\common\components;

// Yii Imports
use \Yii;
use yii\base\Component;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;

class MessageSource extends Component {

	// Variables ---------------------------------------------------

	private $messageDb = [
		// Generic Fields
		CmnGlobal::FIELD_FRIEND => 'Friend',
		CmnGlobal::FIELD_GROUP => 'Group',
		CmnGlobal::FIELD_CHAT => 'Chat'
	];

	/**
	 * Initialise the Cms Message DB Component.
	 */
    public function init() {

        parent::init();
    }

	public function getMessage( $messageKey, $params = [], $language = null ) {

		return $this->$messageDb[ $messageKey ];
	}
}

?>