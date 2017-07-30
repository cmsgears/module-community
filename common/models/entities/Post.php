<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\base\CmsTables;

use cmsgears\core\common\models\traits\resources\CommentTrait;
use cmsgears\core\common\models\traits\mappers\CategoryTrait;
use cmsgears\core\common\models\traits\mappers\FileTrait;
use cmsgears\core\common\models\traits\mappers\TagTrait;
use cmsgears\cms\common\models\traits\resources\ContentTrait;
use cmsgears\cms\common\models\traits\mappers\BlockTrait;

class Post extends Content {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Pre-Defined Status
	const STATUS_BASIC		=  20;
	const STATUS_MEDIA		=  40;
	const STATUS_ATTRIBUTES	= 480;
	const STATUS_SETTINGS	= 490;
	const STATUS_REVIEW		= 499;

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $mParentType		= CmsGlobal::TYPE_POST;
	public $categoryType	= CmsGlobal::TYPE_POST;

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use CategoryTrait;
	use TagTrait;
	use FileTrait;
	use CommentTrait;
	use ContentTrait;
	use BlockTrait;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Post ----------------------------------

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	/**
	 * @inheritdoc
	 */
	public static function find() {

		$postTable = CmsTables::TABLE_PAGE;

		return parent::find()->where( [ "$postTable.type" => CmsGlobal::TYPE_POST ] );
	}


	public function getTabStatus() {

		$action	= Yii::$app->controller->action->id;

		switch( $action ) {

			case 'basic': {

				return self::STATUS_BASIC;
			}
			case 'media': {

				return self::STATUS_MEDIA;
			}
			case 'attributes': {

				return self::STATUS_ATTRIBUTES;
			}
			case 'settings': {

				return self::STATUS_SETTINGS;
			}
			case 'review': {

				return self::STATUS_REVIEW;
			}
		}

		return null;
	}

	public function getNextStatus( $status = null ) {

		if( !isset( $status ) ) {

			$status	= $this->status;
		}

		switch( $status ) {

			case self::STATUS_BASIC: {

				return self::STATUS_MEDIA;
			}
			case self::STATUS_MEDIA: {

				return self::STATUS_ATTRIBUTES;
			}
			case self::STATUS_ATTRIBUTES: {

				return self::STATUS_SETTINGS;
			}
			case self::STATUS_SETTINGS: {

				return self::STATUS_REVIEW;
			}
		}

		return null;
	}

	public function getPreviousTab() {

		$action		= Yii::$app->controller->action->id;
		$basePath	= Yii::$app->controller->basePath;

		switch( $action ) {

			case 'media': {

				return "$basePath/info?slug=$this->slug";
			}
			case 'attributes': {

				return "$basePath/media?slug=$this->slug";
			}
			case 'settings': {

				return "$basePath/attributes?slug=$this->slug";
			}
			case 'review': {

				return "$basePath/settings?slug=$this->slug";
			}
		}

		return null;
	}

	public function getNextTab() {

		$action		= Yii::$app->controller->action->id;
		$basePath	= Yii::$app->controller->basePath;

		switch( $action ) {

			case 'basic': {

				return "$basePath/media?slug=$this->slug";
			}
			case 'media': {

				return "$basePath/attributes?slug=$this->slug";
			}
			case 'attributes': {

				return "$basePath/settings?slug=$this->slug";
			}
			case 'settings': {

				return "$basePath/review?slug=$this->slug";
			}
		}

		return null;
	}

	// CMG parent classes --------------------

	// Post ----------------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
