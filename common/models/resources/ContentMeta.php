<?php
namespace cmsgears\cms\common\models\resources;

// CMG Imports
use cmsgears\cms\common\models\base\CmsTables;

use cmsgears\cms\common\models\entities\Content;

/**
 * ContentMeta Entity
 *
 * @property integer $id
 * @property integer $modelId
 * @property string $name
 * @property string $label
 * @property string $type
 * @property string $valueType
 * @property string $value
 */
class ContentMeta extends \cmsgears\core\common\models\base\ModelMeta {

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

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// ContentMeta ---------------------------

	public function getParent() {

		return $this->hasOne( Content::className(), [ 'id' => 'modelId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	/**
	 * @inheritdoc
	 */
	public static function tableName() {

		return CmsTables::TABLE_PAGE_META;
	}

	// CMG parent classes --------------------

	// ContentMeta ---------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------
}
