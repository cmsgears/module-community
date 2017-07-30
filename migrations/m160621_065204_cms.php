<?php
// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

class m160621_065204_cms extends \yii\db\Migration {

	// Public Variables

	public $fk;
	public $options;

	// Private Variables

	private $prefix;

	public function init() {

		// Table prefix
		$this->prefix		= Yii::$app->migration->cmgPrefix;

		// Get the values via config
		$this->fk			= Yii::$app->migration->isFk();
		$this->options		= Yii::$app->migration->getTableOptions();

		// Default collation
		if( $this->db->driverName === 'mysql' ) {

			$this->options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
	}

	public function up() {

		// Page
		$this->upPage();
		$this->upPageMeta();

		// Block
		$this->upBlock();

		// Resources
		$this->upModelContent();

		// Mappers
		$this->upModelBlock();

		if( $this->fk ) {

			$this->generateForeignKeys();
		}
	}

	private function upPage() {

		$this->createTable( $this->prefix . 'cms_page', [
			'id' => $this->bigPrimaryKey( 20 ),
			'siteId' => $this->bigInteger( 20 )->notNull(),
			'parentId' => $this->bigInteger( 20 ),
			'galleryId' => $this->bigInteger( 20 ),
			'createdBy' => $this->bigInteger( 20 )->notNull(),
			'modifiedBy' => $this->bigInteger( 20 ),
			'name' => $this->string( Yii::$app->core->xLargeText )->notNull(),
			'title' => $this->string( Yii::$app->core->xLargeText )->defaultValue( null ),
			'slug' => $this->string( Yii::$app->core->xxLargeText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'icon' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'description' => $this->string( Yii::$app->core->xxLargeText )->defaultValue( null ),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'visibility' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'order' => $this->smallInteger( 6 ),
			'showGallery' => $this->boolean()->notNull()->defaultValue( false ),
			'featured' => $this->boolean()->notNull()->defaultValue( false ),
			'comments' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			// Cached content, JSON data and cached widget JSON data
			'content' => $this->text(),
			'data' => $this->text(),
			'widgetData' => $this->text()
		], $this->options );

		// Index for columns site, parent, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'page_site', $this->prefix . 'cms_page', 'siteId' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_gallery', $this->prefix . 'cms_page', 'galleryId' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_parent', $this->prefix . 'cms_page', 'parentId' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_creator', $this->prefix . 'cms_page', 'createdBy' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_modifier', $this->prefix . 'cms_page', 'modifiedBy' );
	}

	private function upPageMeta() {

		$this->createTable( $this->prefix . 'cms_page_meta', [
			'id' => $this->bigPrimaryKey( 20 ),
			'modelId' => $this->bigInteger( 20 )->notNull(),
			'name' => $this->string( Yii::$app->core->largeText )->notNull(),
			'label' => $this->string( Yii::$app->core->xLargeText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText ),
			'valueType' => $this->string( CoreGlobal::TEXT_MEDIUM )->notNull()->defaultValue( 'text' ),
			'value' => $this->text()
		], $this->options );

		// Index for columns site, parent, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'page_meta_parent', $this->prefix . 'cms_page_meta', 'modelId' );
	}

	private function upBlock() {

		$this->createTable( $this->prefix . 'cms_block', [
			'id' => $this->bigPrimaryKey( 20 ),
			'siteId' => $this->bigInteger( 20 )->notNull(),
			'templateId' => $this->bigInteger( 20 ),
			'bannerId' => $this->bigInteger( 20 ),
			'textureId' => $this->bigInteger( 20 ),
			'videoId' => $this->bigInteger( 20 ),
			'createdBy' => $this->bigInteger( 20 )->notNull(),
			'modifiedBy' => $this->bigInteger( 20 ),
			'name' => $this->string( Yii::$app->core->xLargeText )->notNull(),
			'slug' => $this->string( Yii::$app->core->xxLargeText )->notNull(),
			'icon' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'description' => $this->string( Yii::$app->core->xxLargeText )->defaultValue( null ),
			'title' => $this->string( Yii::$app->core->xLargeText )->notNull(),
			'active' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'htmlOptions' => $this->text(),
			'content' => $this->text(),
			'data' => $this->text()
		], $this->options );

		// Index for columns site, parent, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'block_site', $this->prefix . 'cms_block', 'siteId' );
		$this->createIndex( 'idx_' . $this->prefix . 'block_template', $this->prefix . 'cms_block', 'templateId' );
		$this->createIndex( 'idx_' . $this->prefix . 'block_banner', $this->prefix . 'cms_block', 'bannerId' );
		$this->createIndex( 'idx_' . $this->prefix . 'block_texture', $this->prefix . 'cms_block', 'textureId' );
		$this->createIndex( 'idx_' . $this->prefix . 'block_video', $this->prefix . 'cms_block', 'videoId' );
		$this->createIndex( 'idx_' . $this->prefix . 'block_creator', $this->prefix . 'cms_block', 'createdBy' );
		$this->createIndex( 'idx_' . $this->prefix . 'block_modifier', $this->prefix . 'cms_block', 'modifiedBy' );
	}

	private function upModelContent() {

		$this->createTable( $this->prefix . 'cms_model_content', [
			'id' => $this->bigPrimaryKey( 20 ),
			'templateId' => $this->bigInteger( 20 ),
			'bannerId' => $this->bigInteger( 20 ),
			'videoId' => $this->bigInteger( 20 ),
			'parentId' => $this->bigInteger( 20 )->notNull(),
			'parentType' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText ),
			'summary' => $this->text(),
			'seoName' => $this->string( Yii::$app->core->xLargeText )->defaultValue( null ),
			'seoDescription' => $this->string( Yii::$app->core->xLargeText )->defaultValue( null ),
			'seoKeywords' => $this->string( Yii::$app->core->xLargeText )->defaultValue( null ),
			'seoRobot' => $this->string( Yii::$app->core->xLargeText )->defaultValue( null ),
			'showBanner' => $this->boolean()->notNull()->defaultValue( true ),
			'showVideo' => $this->boolean()->notNull()->defaultValue( true ),
			'views' => $this->integer( 11 )->defaultValue( 0 ),
			'referrals' => $this->integer( 11 )->defaultValue( 0 ),
			'comments' => $this->integer( 11 )->defaultValue( 0 ),
			'weight' => $this->integer( 11 )->defaultValue( 0 ),
			'rank' => $this->integer( 11 )->defaultValue( 0 ),
			'publishedAt' => $this->dateTime(),
			'content' => $this->text(),
			'data' => $this->text()
		], $this->options );

		// Index for columns base, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'model_content_template', $this->prefix . 'cms_model_content', 'templateId' );
		$this->createIndex( 'idx_' . $this->prefix . 'model_content_banner', $this->prefix . 'cms_model_content', 'bannerId' );
		$this->createIndex( 'idx_' . $this->prefix . 'model_content_video', $this->prefix . 'cms_model_content', 'videoId' );
	}

	private function upModelBlock() {

		$this->createTable( $this->prefix . 'cms_model_block', [
			'id' => $this->bigPrimaryKey( 20 ),
			'modelId' => $this->bigInteger( 20 ),
			'parentId' => $this->bigInteger( 20 )->notNull(),
			'parentType' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText ),
			'order' => $this->smallInteger( 6 ),
			'active' => $this->boolean()->notNull()->defaultValue( true )
		], $this->options );

		// Index for columns block
		$this->createIndex( 'idx_' . $this->prefix . 'model_block_parent', $this->prefix . 'cms_model_block', 'modelId' );
	}

	private function generateForeignKeys() {

		// Page
		$this->addForeignKey( 'fk_' . $this->prefix . 'page_site', $this->prefix . 'cms_page', 'siteId', $this->prefix . 'core_site', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'page_gallery', $this->prefix . 'cms_page', 'galleryId', $this->prefix . 'core_gallery', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'page_parent', $this->prefix . 'cms_page', 'parentId', $this->prefix . 'cms_page', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'page_creator', $this->prefix . 'cms_page', 'createdBy', $this->prefix . 'core_user', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'page_modifier', $this->prefix . 'cms_page', 'modifiedBy', $this->prefix . 'core_user', 'id', 'SET NULL' );

		// Page meta
		$this->addForeignKey( 'fk_' . $this->prefix . 'page_meta_parent', $this->prefix . 'cms_page_meta', 'modelId', $this->prefix . 'cms_page', 'id', 'CASCADE' );

		// Block
		$this->addForeignKey( 'fk_' . $this->prefix . 'block_site', $this->prefix . 'cms_block', 'siteId', $this->prefix . 'core_site', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'block_template', $this->prefix . 'cms_block', 'templateId', $this->prefix . 'core_template', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'block_banner', $this->prefix . 'cms_block', 'bannerId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'block_texture', $this->prefix . 'cms_block', 'textureId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'block_video', $this->prefix . 'cms_block', 'videoId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'block_creator', $this->prefix . 'cms_block', 'createdBy', $this->prefix . 'core_user', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'block_modifier', $this->prefix . 'cms_block', 'modifiedBy', $this->prefix . 'core_user', 'id', 'SET NULL' );

		// Model Content
		$this->addForeignKey( 'fk_' . $this->prefix . 'model_content_template', $this->prefix . 'cms_model_content', 'templateId', $this->prefix . 'core_template', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'model_content_banner', $this->prefix . 'cms_model_content', 'bannerId', $this->prefix . 'core_file', 'id', 'SET NULL' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'model_content_video', $this->prefix . 'cms_model_content', 'videoId', $this->prefix . 'core_file', 'id', 'SET NULL' );

		// Model Block
		$this->addForeignKey( 'fk_' . $this->prefix . 'model_block_parent', $this->prefix . 'cms_model_block', 'modelId', $this->prefix . 'cms_block', 'id', 'CASCADE' );
	}

	public function down() {

		if( $this->fk ) {

			$this->dropForeignKeys();
		}

		$this->dropTable( $this->prefix . 'cms_page' );
		$this->dropTable( $this->prefix . 'cms_page_meta' );

		$this->dropTable( $this->prefix . 'cms_block' );

		$this->dropTable( $this->prefix . 'cms_model_content' );
		$this->dropTable( $this->prefix . 'cms_model_block' );
	}

	private function dropForeignKeys() {

		// Page
		$this->dropForeignKey( 'fk_' . $this->prefix . 'page_site', $this->prefix . 'cms_page' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'page_gallery', $this->prefix . 'cms_page' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'page_parent', $this->prefix . 'cms_page' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'page_creator', $this->prefix . 'cms_page' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'page_modifier', $this->prefix . 'cms_page' );

		// Page meta
		$this->dropForeignKey( 'fk_' . $this->prefix . 'page_meta_parent', $this->prefix . 'cms_page_meta' );

		// Block
		$this->dropForeignKey( 'fk_' . $this->prefix . 'block_site', $this->prefix . 'cms_block' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'block_template', $this->prefix . 'cms_block' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'block_banner', $this->prefix . 'cms_block' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'block_texture', $this->prefix . 'cms_block' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'block_video', $this->prefix . 'cms_block' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'block_creator', $this->prefix . 'cms_block' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'block_modifier', $this->prefix . 'cms_block' );

		// Model Content
		$this->dropForeignKey( 'fk_' . $this->prefix . 'model_content_template', $this->prefix . 'cms_model_content' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'model_content_banner', $this->prefix . 'cms_model_content' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'model_content_video', $this->prefix . 'cms_model_content' );

		// Model Block
		$this->dropForeignKey( 'fk_' . $this->prefix . 'model_block_parent', $this->prefix . 'cms_model_block' );
	}
}
