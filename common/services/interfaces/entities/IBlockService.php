<?php
namespace cmsgears\cms\common\services\interfaces\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\services\interfaces\base\INameService;
use cmsgears\core\common\services\interfaces\base\ISlugService;

interface IBlockService extends INameService, ISlugService {

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	public function getElements( $block, $associative = false );

	public function getElementsForUpdate( $block, $elements );

	// Read - Lists ----

	// Read - Maps -----

	// Create -------------

	// Update -------------

	public function updateElements( $block, $elements );

	// Delete -------------

}
