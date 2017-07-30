<?php
namespace cmsgears\cms\common\services\interfaces\resources;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

interface ITagService extends \cmsgears\core\common\services\interfaces\resources\ITagService {

	// Data Provider ------

	public function getPageWithContent( $config = [] );

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Create -------------

	// Update -------------

	// Delete -------------

}
