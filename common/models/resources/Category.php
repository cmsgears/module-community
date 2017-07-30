<?php
namespace cmsgears\cms\common\models\resources;

// CMG Imports
use cmsgears\cms\common\models\traits\resources\ContentTrait;

/**
 * Category Entity
 *
 * @property long $id
 * @property long $siteId
 * @property long $parentId
 * @property long $rootId
 * @property string $name
 * @property string $slug
 * @property string $icon
 * @property string $type
 * @property string $description
 * @property boolean $featured
 * @property short lValue
 * @property short rValue
 * @property string $htmlOptions
 * @property string $data
 */
class Category extends \cmsgears\core\common\models\resources\Category {

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

	// Category ------------------------------

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	// CMG parent classes --------------------

	// Category ------------------------------

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
