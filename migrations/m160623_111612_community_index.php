<?php

class m160623_111612_community_index extends \yii\db\Migration {

	// Public Variables

	// Private Variables

	private $prefix;

	public function init() {

		// Fixed
		$this->prefix	= 'cmg_';
	}

	public function up() {

		$this->upPrimary();

		$this->upDependent();
	}

	private function upPrimary() {

		// Friend
		$this->createIndex( 'idx_' . $this->prefix . 'friend_type', $this->prefix . 'cmn_friend', 'type' );

		// Group
		$this->createIndex( 'idx_' . $this->prefix . 'group_name', $this->prefix . 'cmn_group', 'name' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_slug', $this->prefix . 'cmn_group', 'slug' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_type', $this->prefix . 'cmn_group', 'type' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_icon', $this->prefix . 'cmn_group', 'icon' );

		// Post
		$this->createIndex( 'idx_' . $this->prefix . 'cmn_post_type', $this->prefix . 'cmn_post', 'type' );

		// Chat Message
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_type', $this->prefix . 'cmn_chat_message', 'type' );

		// Group Message
		$this->createIndex( 'idx_' . $this->prefix . 'group_message_type', $this->prefix . 'cmn_group_message', 'type' );

		// Follower
		$this->createIndex( 'idx_' . $this->prefix . 'cmn_follower_type_p', $this->prefix . 'cmn_follower', 'parentType' );
	}

	private function upDependent() {

		// Group Meta
		$this->createIndex( 'idx_' . $this->prefix . 'group_meta_name', $this->prefix . 'cmn_group_meta', 'name' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_meta_type', $this->prefix . 'cmn_group_meta', 'type' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_meta_type_v', $this->prefix . 'cmn_group_meta', 'valueType' );
	}

	public function down() {

		$this->downPrimary();

		$this->downDependent();
	}

	private function downPrimary() {

		// Friend
		$this->dropIndex( 'idx_' . $this->prefix . 'friend_type', $this->prefix . 'cmn_friend' );

		// Group
		$this->dropIndex( 'idx_' . $this->prefix . 'group_name', $this->prefix . 'cmn_group' );
		$this->dropIndex( 'idx_' . $this->prefix . 'group_slug', $this->prefix . 'cmn_group' );
		$this->dropIndex( 'idx_' . $this->prefix . 'group_type', $this->prefix . 'cmn_group' );
		$this->dropIndex( 'idx_' . $this->prefix . 'group_icon', $this->prefix . 'cmn_group' );

		// Post
		$this->dropIndex( 'idx_' . $this->prefix . 'cmn_post_type', $this->prefix . 'cmn_post' );

		// Chat Message
		$this->dropIndex( 'idx_' . $this->prefix . 'chat_message_type', $this->prefix . 'cmn_chat_message' );

		// Group Message
		$this->dropIndex( 'idx_' . $this->prefix . 'group_message_type', $this->prefix . 'cmn_group_message' );

		// Follower
		$this->dropIndex( 'idx_' . $this->prefix . 'cmn_follower_type_p', $this->prefix . 'cmn_follower' );
	}

	private function downDependent() {

		// Group Meta
		$this->dropIndex( 'idx_' . $this->prefix . 'group_meta_name', $this->prefix . 'cmn_group_meta' );
		$this->dropIndex( 'idx_' . $this->prefix . 'group_meta_type', $this->prefix . 'cmn_group_meta' );
		$this->dropIndex( 'idx_' . $this->prefix . 'group_meta_type_v', $this->prefix . 'cmn_group_meta' );
	}
}