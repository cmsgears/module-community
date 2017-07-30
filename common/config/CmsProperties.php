<?php
namespace cmsgears\cms\common\config;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class CmsProperties extends \cmsgears\core\common\config\CmgProperties {

	// Variables ---------------------------------------------------

	// Global -----------------

	/**
	 * The property to find whether comments are enabled at page level.
	 */
	const PROP_COMMENT_PAGE		= "page_comment";

	/**
	 * The property to find whether comments are enabled at post level.
	 */
	const PROP_COMMENT_POST		= "post_comment";

	// Public -----------------

	// Protected --------------

	// Private ----------------

	private static $instance;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// CmgProperties -------------------------

	// Singleton

	public static function getInstance() {

		if( !isset( self::$instance ) ) {

			self::$instance	= new CmsProperties();

			self::$instance->init( CmsGlobal::CONFIG_BLOG );
		}

		return self::$instance;
	}

	// Properties

	/**
	 * Returns whether comments are required for pages.
	 */
	public function isPageComments() {

		return $this->properties[ self::PROP_COMMENT_PAGE ];
	}

	/**
	 * Returns whether comments are required for posts.
	 */
	public function isPostComments() {

		return $this->properties[ self::PROP_COMMENT_POST ];
	}
}
