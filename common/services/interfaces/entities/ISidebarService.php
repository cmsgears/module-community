<?php
namespace cmsgears\cms\common\services\interfaces\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

interface ISidebarService extends \cmsgears\core\common\services\interfaces\entities\IObjectService {

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	public function getWidgets( $sidebar, $associative = false );

	public function getWidgetsForUpdate( $sidebar, $widgets );

	// Read - Lists ----

	// Read - Maps -----

	// Create -------------

	// Update -------------

	public function updateWidgets( $sidebar, $widgets );

	// Delete -------------

}
