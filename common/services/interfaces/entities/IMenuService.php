<?php
namespace cmsgears\cms\common\services\interfaces\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

interface IMenuService extends \cmsgears\core\common\services\interfaces\entities\IObjectService {

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	public function getLinks( $menu );

	public function getPageLinks( $menu, $associative = false );

	public function getPageLinksForUpdate( $menu, $pages );

	// Read - Lists ----

	// Read - Maps -----

	// Create -------------

	// Update -------------

	public function updateLinks( $menu, $links, $pageLinks );

	// Delete -------------

}
