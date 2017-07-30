<?php
namespace cmsgears\cms\common\components;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

class MessageSource extends \yii\base\Component {

	// Global -----------------

	// Public -----------------

	// Protected --------------

	protected $messageDb = [
		// Generic Fields
		CmsGlobal::FIELD_ELEMENT => 'Element',
		CmsGlobal::FIELD_BLOCK => 'Block',
		CmsGlobal::FIELD_PAGE => 'Page',
		CmsGlobal::FIELD_MENU => 'Menu',
		CmsGlobal::FIELD_WIDGET => 'Widget',
		CmsGlobal::FIELD_SIDEBAR => 'Sidebar',
		CmsGlobal::FIELD_URL_RELATIVE => 'Relative URL',
		CmsGlobal::FIELD_KEYWORDS => 'Keywords',
		// SEO
		CmsGlobal::FIELD_SEO_NAME => 'SEO Name',
		CmsGlobal::FIELD_SEO_DESCRIPTION => 'SEO Description',
		CmsGlobal::FIELD_SEO_KEYWORDS => 'SEO Keywords',
		CmsGlobal::FIELD_SEO_ROBOT => 'SEO Robot',
		// Block Fields
		CmsGlobal::FIELD_BACKGROUND => 'Background',
		CmsGlobal::FIELD_TEXTURE => 'Texture'
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
