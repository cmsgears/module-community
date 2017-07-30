<?php
namespace cmsgears\cms\common\services\interfaces\resources;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

interface IModelContentService extends \cmsgears\core\common\services\interfaces\base\IEntityService {

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Create -------------

	// Update -------------

	public function updateBanner( $model, $banner );

	public function updateViewCount( $model, $views );

	// Delete -------------

}
