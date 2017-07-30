<?php
namespace cmsgears\cms\common\services\base;

// Yii Imports
use Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\config\CacheProperties;

use cmsgears\cms\common\models\base\CmsTables;

/**
 * The class Service defines several useful methods used for pagination and generating map and list by specifying the columns.
 */
abstract class ContentService extends \cmsgears\core\common\services\base\EntityService {

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

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ContentService ------------------------

	// Data Provider ------

	public function getPageForSimilar( $config = [] ) {

		$modelClass			= static::$modelClass;

		// Search Query - If hasOne config is passed, make sure that modelContent is listed in hasOne relationships
		$query				= isset( $config[ 'query' ] ) ? $config[ 'query' ] : $modelClass::find()->joinWith( 'modelContent' );
		$config[ 'query' ]	= $query;

		return parent::getPageForSimilar( $config );
	}

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function updateGalleryId( $model, $galleryId ) {

		$existingModel	= self::findById( $model->id );

		if( isset( $existingModel ) ) {

			$existingModel->galleryId	= $galleryId;

			$existingModel->update();
		}
	}

	// Delete -------------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// ContentService ------------------------

	// Data Provider ------

	public static function findPage( $config = [] ) {

		$modelClass		= static::$modelClass;
		$modelTable		= static::$modelTable;

		$contentTable	= CmsTables::TABLE_MODEL_CONTENT;

		$sort			= isset( $config[ 'sort' ] ) ? $config[ 'sort' ] : false;

		if( !$sort ) {

			$sort = new Sort([
				'attributes' => [
					'id' => [
						'asc' => [ "$modelTable.id" => SORT_ASC ],
						'desc' => [ "$modelTable.id" => SORT_DESC ],
						'default' => SORT_DESC,
						'label' => 'Id'
					],
					'cdate' => [
						'asc' => [ "$modelTable.createdAt" => SORT_ASC ],
						'desc' => [ "$modelTable.createdAt" => SORT_DESC ],
						'default' => SORT_DESC,
						'label' => 'Created At'
					],
					'udate' => [
						'asc' => [ "$modelTable.updatedAt" => SORT_ASC ],
						'desc' => [ "$modelTable.updatedAt" => SORT_DESC ],
						'default' => SORT_DESC,
						'label' => 'Updated At'
					],
					'pdate' => [
						'asc' => [ "$contentTable.publishedAt" => SORT_ASC ],
						'desc' => [ "$contentTable.publishedAt" => SORT_DESC ],
						'default' => SORT_DESC,
						'label' => 'Published At'
					]
				]
			]);

			$config[ 'sort' ]	= $sort;
		}

		return parent::findPage( $config );
	}

	/**
	 * Generate search query using tag and category tables.
	 */
	public static function findPageForSearch( $config = [] ) {

		$searchContent 	= isset( $config[ 'searchContent' ] ) ? $config[ 'searchContent' ] : false;
		$keywords 		= Yii::$app->request->getQueryParam( 'keywords' );

		// Search
		if( $searchContent && isset( $keywords ) ) {

			$modelTable	= static::$modelTable;
			$cache		= CacheProperties::getInstance()->isCaching();

			// Search in model cache
			if( $cache ) {

				$config[ 'search-col' ][] = "$modelTable.content";
			}
			// Joined with model content
			else {

				// Search Query
				$modelClass			= static::$modelClass;
				$query				= isset( $config[ 'query' ] ) ? $config[ 'query' ] : $modelClass::find()->joinWith( 'modelContent' );
				$config[ 'query' ]	= $query;

				// Search in model content
				$config[ 'search-col' ][] = 'modelContent.content';
			}
		}

		return parent::findPageForSearch( $config );
	}

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

}
