<?php
namespace cmsgears\community\common\services\resources;

// CMG Imports
use cmsgears\community\common\models\base\CmnTables;

use cmsgears\community\common\services\interfaces\resources\IPostService;

class PostService extends \cmsgears\core\common\services\base\EntityService implements IPostService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\community\common\models\resources\Post';

	public static $modelTable	= CmnTables::TABLE_POST;

	public static $parentType	= null;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostService ---------------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function update( $model, $config = [] ) {

		$admin = isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;

		if( $admin ) {

			return parent::update( $model, [
				'attributes' => [ 'visibility', 'type', 'content', 'data' ]
			]);
		}

		return parent::update( $model, [
			'attributes' => [ 'content', 'data' ]
		]);
	}

	// Delete -------------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// PostService ---------------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

}
