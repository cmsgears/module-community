<?php
namespace cmsgears\cms\common\models\traits\mappers;

// CMG Imports
use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\mappers\ModelBlock;

/**
 * BlockTrait can be used to form page using blocks.
 */
trait BlockTrait {

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii classes ---------------------------

	// CMG interfaces ------------------------

	// CMG classes ---------------------------

	// Validators ----------------------------

	// BlockTrait ----------------------------

	/**
	 * @return array - ModelBlock associated with parent
	 */
	public function getModelBlocks() {

		return $this->hasMany( ModelBlock::className(), [ 'parentId' => 'id' ] )
					->where( "parentType='$this->parentType'" );
	}

	/**
	 * @return array - Block associated with parent
	 */
	public function getBlocks() {

		return $this->hasMany( Block::className(), [ 'id' => 'blockId' ] )
					->viaTable( CmsTables::TABLE_MODEL_BLOCK, [ 'parentId' => 'id' ], function( $query ) {

						$modelCategory	= CoreTables::TABLE_MODEL_BLOCK;

						$query->onCondition( [ "$modelCategory.parentType" => $this->parentType ] );
					});
	}


	// Static Methods ----------------------------------------------

	// Yii classes ---------------------------

	// CMG classes ---------------------------

	// BlockTrait ----------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------
}
