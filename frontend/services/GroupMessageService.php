<?php
namespace cmsgears\community\frontend\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\community\common\config\CmnGlobal;
use cmsgears\community\common\models\entities\GroupMessage;

class GroupMessageService extends \cmsgears\community\common\services\GroupMessageService {

	// Static Methods ----------------------------------------------

	// Read ------------------
	
	// Create ----------------
	
	public static function create( $model ) {
		
		$model->visibility	= CmnGlobal::VISIBILITY_MEMBERS;
		$model->save();
		
		return $model;
	}
	
	// Update ----------------
	
	public static function update( $model ) {
		
		$model->update();
		
		return $model;
	}
	
	// Delete ----------------
	
}

?>