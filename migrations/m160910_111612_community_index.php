<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

/**
 * The community index migration inserts the recommended indexes for better performance. It
 * also list down other possible index commented out. These indexes can be created using
 * project based migration script.
 *
 * @since 1.0.0
 */
class m160910_111612_community_index extends \cmsgears\core\common\base\Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	public function init() {

		// Table prefix
		$this->prefix = Yii::$app->migration->cmgPrefix;
	}

	public function up() {

		$this->upPrimary();

		$this->upDependent();
	}

	private function upPrimary() {

		// Friend
		$this->createIndex( 'idx_' . $this->prefix . 'friend_type', $this->prefix . 'cmn_friend', 'type' );

		// User Post
		$this->createIndex( 'idx_' . $this->prefix . 'user_post_type', $this->prefix . 'cmn_user_post', 'type' );

		// Chat
		$this->createIndex( 'idx_' . $this->prefix . 'chat_status', $this->prefix . 'cmn_chat', 'status' );

		// Chat Message
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_code', $this->prefix . 'cmn_chat_message', 'code' );
		//$this->createIndex( 'idx_' . $this->prefix . 'chat_message_cons', $this->prefix . 'cmn_chat_message', 'consumed' );
		//$this->createIndex( 'idx_' . $this->prefix . 'chat_message_type', $this->prefix . 'cmn_chat_message', 'type' );

		// Group
		$this->createIndex( 'idx_' . $this->prefix . 'group_name', $this->prefix . 'cmn_group', 'name' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_slug', $this->prefix . 'cmn_group', 'slug' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_type', $this->prefix . 'cmn_group', 'type' );
		//$this->createIndex( 'idx_' . $this->prefix . 'group_icon', $this->prefix . 'cmn_group', 'icon' );
		//$this->createIndex( 'idx_' . $this->prefix . 'group_status', $this->prefix . 'cmn_group', 'status' );
		//$this->createIndex( 'idx_' . $this->prefix . 'group_order', $this->prefix . 'cmn_group', 'order' );
		//$this->createIndex( 'idx_' . $this->prefix . 'group_featured', $this->prefix . 'cmn_group', 'featured' );

		// Group Meta
		$this->createIndex( 'idx_' . $this->prefix . 'group_meta_name', $this->prefix . 'cmn_group_meta', 'name' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_meta_type', $this->prefix . 'cmn_group_meta', 'type' );
		//$this->createIndex( 'idx_' . $this->prefix . 'group_meta_type_v', $this->prefix . 'cmn_group_meta', 'valueType' );
		//$this->createIndex( 'idx_' . $this->prefix . 'group_meta_mit', $this->prefix . 'cmn_group_meta', [ 'modelId', 'type' ] );
		//$this->createIndex( 'idx_' . $this->prefix . 'group_meta_mitn', $this->prefix . 'cmn_group_meta', [ 'modelId', 'type', 'name' ] );

		// Group Post
		$this->createIndex( 'idx_' . $this->prefix . 'group_post_type', $this->prefix . 'cmn_group_post', 'type' );

		// Group Message
		//$this->createIndex( 'idx_' . $this->prefix . 'group_message_cons', $this->prefix . 'cmn_group_message', 'consumed' );
		//$this->createIndex( 'idx_' . $this->prefix . 'group_message_type', $this->prefix . 'cmn_group_message', 'type' );
	}

	private function upDependent() {

		// User Follower
		$this->createIndex( 'idx_' . $this->prefix . 'user_follower_type', $this->prefix . 'cmn_user_follower', 'type' );

		// Group Follower
		$this->createIndex( 'idx_' . $this->prefix . 'group_follower_type', $this->prefix . 'cmn_group_follower', 'type' );

		// Group Member
		$this->createIndex( 'idx_' . $this->prefix . 'group_member_status', $this->prefix . 'cmn_group_member', 'status' );
	}

	public function down() {

		$this->downPrimary();

		$this->downDependent();
	}

	private function downPrimary() {

		// Friend
		$this->dropIndex( 'idx_' . $this->prefix . 'friend_type', $this->prefix . 'cmn_friend' );

		// User Post
		$this->dropIndex( 'idx_' . $this->prefix . 'user_post_type', $this->prefix . 'cmn_user_post' );

		// Chat
		$this->dropIndex( 'idx_' . $this->prefix . 'chat_status', $this->prefix . 'cmn_chat' );

		// Chat Message
		$this->dropIndex( 'idx_' . $this->prefix . 'chat_message_code', $this->prefix . 'cmn_chat_message' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'chat_message_cons', $this->prefix . 'cmn_chat_message' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'chat_message_type', $this->prefix . 'cmn_chat_message' );

		// Group
		$this->dropIndex( 'idx_' . $this->prefix . 'group_name', $this->prefix . 'cmn_group' );
		$this->dropIndex( 'idx_' . $this->prefix . 'group_slug', $this->prefix . 'cmn_group' );
		$this->dropIndex( 'idx_' . $this->prefix . 'group_type', $this->prefix . 'cmn_group' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'group_icon', $this->prefix . 'cmn_group' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'group_status', $this->prefix . 'cmn_group' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'group_order', $this->prefix . 'cmn_group' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'group_featured', $this->prefix . 'cmn_group' );

		// Group Meta
		$this->dropIndex( 'idx_' . $this->prefix . 'group_meta_name', $this->prefix . 'cmn_group_meta' );
		$this->dropIndex( 'idx_' . $this->prefix . 'group_meta_type', $this->prefix . 'cmn_group_meta' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'group_meta_type_v', $this->prefix . 'cmn_group_meta' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'group_meta_mit', $this->prefix . 'cmn_group_meta' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'group_meta_mitn', $this->prefix . 'cmn_group_meta' );

		// Group Post
		$this->dropIndex( 'idx_' . $this->prefix . 'group_post_type', $this->prefix . 'cmn_group_post' );

		// Group Message
		//$this->dropIndex( 'idx_' . $this->prefix . 'group_message_cons', $this->prefix . 'cmn_group_message' );
		//$this->dropIndex( 'idx_' . $this->prefix . 'group_message_type', $this->prefix . 'cmn_group_message' );
	}

	private function downDependent() {

		// User Follower
		$this->dropIndex( 'idx_' . $this->prefix . 'user_follower_type', $this->prefix . 'cmn_user_follower' );

		// Group Follower
		$this->dropIndex( 'idx_' . $this->prefix . 'group_follower_type', $this->prefix . 'cmn_group_follower' );

		// Group Member
		$this->dropIndex( 'idx_' . $this->prefix . 'group_member_status', $this->prefix . 'cmn_group_member' );
	}

}
