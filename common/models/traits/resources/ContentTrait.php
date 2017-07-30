<?php
namespace cmsgears\cms\common\models\traits\resources;

// CMG Imports
use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\resources\ModelContent;

/**
 * ContentTrait can be used to add seo optimised content to relevant models to form public pages.
 */
trait ContentTrait {

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii classes ---------------------------

	// CMG interfaces ------------------------

	// CMG classes ---------------------------

	// Validators ----------------------------

	// ContentTrait --------------------------

	/**
	 * @return ModelContent associated with parent.
	 */
	public function getModelContent() {

		$modelContentTable	= CmsTables::TABLE_MODEL_CONTENT;

		return $this->hasOne( ModelContent::className(), [ 'parentId' => 'id' ] )->from( "$modelContentTable as modelContent" )
					->where( "modelContent.parentType='$this->mParentType'" );
	}

	public function getTemplateViewPath() {

		$content	= $this->content;
		$template	= $content->template;

		return $template->viewPath;
	}

	// Static Methods ----------------------------------------------

	// Yii classes ---------------------------

	// CMG classes ---------------------------

	// ContentTrait --------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
