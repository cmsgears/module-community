<?php

class m160621_065815_cms_index extends \yii\db\Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	public function init() {

		// Table prefix
		$this->prefix		= Yii::$app->migration->cmgPrefix;
	}

	public function up() {

		$this->upPrimary();

		$this->upDependent();
	}

	private function upPrimary() {

		// Content
		$this->createIndex( 'idx_' . $this->prefix . 'page_name', $this->prefix . 'cms_page', 'name' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_slug', $this->prefix . 'cms_page', 'slug' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_type', $this->prefix . 'cms_page', 'type' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_icon', $this->prefix . 'cms_page', 'icon' );

		// Block
		$this->createIndex( 'idx_' . $this->prefix . 'block_name', $this->prefix . 'cms_block', 'name' );
		$this->createIndex( 'idx_' . $this->prefix . 'block_slug', $this->prefix . 'cms_block', 'slug' );
		$this->createIndex( 'idx_' . $this->prefix . 'block_title', $this->prefix . 'cms_block', 'title' );
		$this->createIndex( 'idx_' . $this->prefix . 'block_icon', $this->prefix . 'cms_block', 'icon' );
	}

	private function upDependent() {

		// Page Meta
		$this->createIndex( 'idx_' . $this->prefix . 'page_meta_name', $this->prefix . 'cms_page_meta', 'name' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_meta_type', $this->prefix . 'cms_page_meta', 'type' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_meta_type_v', $this->prefix . 'cms_page_meta', 'valueType' );
		$this->createIndex( 'idx_' . $this->prefix . 'page_meta_mit', $this->prefix . 'cms_page_meta', [ 'modelId', 'type' ] );
		$this->createIndex( 'idx_' . $this->prefix . 'page_meta_mitn', $this->prefix . 'cms_page_meta', [ 'modelId', 'type', 'name' ] );

		// Model Content
		$this->createIndex( 'idx_' . $this->prefix . 'model_content_type', $this->prefix . 'cms_model_content', 'type' );
		$this->createIndex( 'idx_' . $this->prefix . 'model_content_type_p', $this->prefix . 'cms_model_content', 'parentType' );
		$this->createIndex( 'idx_' . $this->prefix . 'model_content_piptt', $this->prefix . 'cms_model_content', [ 'parentId', 'parentType', 'type' ] );

		// Model Block
		$this->createIndex( 'idx_' . $this->prefix . 'model_block_type', $this->prefix . 'cms_model_block', 'type' );
		$this->createIndex( 'idx_' . $this->prefix . 'model_block_type_p', $this->prefix . 'cms_model_block', 'parentType' );
	}

	public function down() {

		$this->downPrimary();

		$this->downDependent();
	}

	private function downPrimary() {

		// Content
		$this->dropIndex( 'idx_' . $this->prefix . 'page_name', $this->prefix . 'cms_page' );
		$this->dropIndex( 'idx_' . $this->prefix . 'page_slug', $this->prefix . 'cms_page' );
		$this->dropIndex( 'idx_' . $this->prefix . 'page_type', $this->prefix . 'cms_page' );
		$this->dropIndex( 'idx_' . $this->prefix . 'page_icon', $this->prefix . 'cms_page' );

		// Block
		$this->dropIndex( 'idx_' . $this->prefix . 'block_name', $this->prefix . 'cms_block' );
		$this->dropIndex( 'idx_' . $this->prefix . 'block_slug', $this->prefix . 'cms_block' );
		$this->dropIndex( 'idx_' . $this->prefix . 'block_title', $this->prefix . 'cms_block' );
		$this->dropIndex( 'idx_' . $this->prefix . 'block_icon', $this->prefix . 'cms_block' );
	}

	private function downDependent() {

		// Page Meta
		$this->dropIndex( 'idx_' . $this->prefix . 'page_meta_name', $this->prefix . 'cms_page_meta' );
		$this->dropIndex( 'idx_' . $this->prefix . 'page_meta_type', $this->prefix . 'cms_page_meta' );
		$this->dropIndex( 'idx_' . $this->prefix . 'page_meta_type_v', $this->prefix . 'cms_page_meta' );
		$this->dropIndex( 'idx_' . $this->prefix . 'page_meta_mit', $this->prefix . 'cms_page_meta' );
		$this->dropIndex( 'idx_' . $this->prefix . 'page_meta_mitn', $this->prefix . 'cms_page_meta' );

		// Model Content
		$this->dropIndex( 'idx_' . $this->prefix . 'model_content_type', $this->prefix . 'cms_model_content' );
		$this->dropIndex( 'idx_' . $this->prefix . 'model_content_type_p', $this->prefix . 'cms_model_content' );
		$this->dropIndex( 'idx_' . $this->prefix . 'model_content_piptt', $this->prefix . 'cms_model_content' );

		// Model Block
		$this->dropIndex( 'idx_' . $this->prefix . 'model_block_type', $this->prefix . 'cms_model_block' );
		$this->dropIndex( 'idx_' . $this->prefix . 'model_block_type_p', $this->prefix . 'cms_model_block' );
	}
}
