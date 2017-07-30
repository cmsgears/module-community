<?php
namespace cmsgears\cms\common\models\resources;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\cms\common\models\traits\resources\ContentTrait;

/**
 * Tag Entity
 *
 * @property long $id
 * @property long $siteId
 * @property string $name
 * @property string $slug
 * @property string $type
 * @property string $icon
 * @property string $description
 */
class Tag extends \cmsgears\core\common\models\resources\Tag {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use ContentTrait;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Tag -----------------------------------

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	// CMG parent classes --------------------

	// Tag -----------------------------------

	// Read - Query -----------

	public static function queryWithContent( $config = [] ) {

		$config[ 'relations' ]	= [ 'modelContent' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------
}
