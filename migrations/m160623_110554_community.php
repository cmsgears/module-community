<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

// CMG Imports
use cmsgears\core\common\base\Migration;

use cmsgears\core\common\models\base\Meta;

/**
 * The community migration inserts the database tables of community module. It also insert the foreign
 * keys if FK flag of migration component is true.
 *
 * @since 1.0.0
 */
class m160623_110554_community extends Migration {

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

		// Friend
		$this->upFriend();

		// User
		$this->upUserPost();
		$this->upUserFollower();

		// Chat
		$this->upChat();
		$this->upChatMember();
		$this->upChatMessage();

		// Group
		$this->upGroup();
		$this->upGroupPost();
		$this->upGroupFollower();
		$this->upGroupMeta();
		$this->upGroupMember();
		$this->upGroupMessage();

		if( $this->fk ) {

			$this->generateForeignKeys();
		}
    }

	private function upFriend() {

        $this->createTable( $this->prefix . 'cmn_friend', [
			'id' => $this->bigPrimaryKey( 20 ),
			'userId' => $this->bigInteger( 20 )->notNull(),
			'friendId' => $this->bigInteger( 20 )->notNull(),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'type' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns user and friend
        $this->createIndex( 'idx_' . $this->prefix . 'friend_user', $this->prefix . 'cmn_friend', 'userId' );
		$this->createIndex( 'idx_' . $this->prefix . 'friend_parent', $this->prefix . 'cmn_friend', 'friendId' );
	}

	private function upUserPost() {

        $this->createTable( $this->prefix . 'cmn_user_post', [
			'id' => $this->bigPrimaryKey( 20 ),
			'senderId' => $this->bigInteger( 20 )->notNull(),
			'recipientId' => $this->bigInteger( 20 )->notNull(),
			'visibility' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'type' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns sender and recipient
		$this->createIndex( 'idx_' . $this->prefix . 'post_user_sender', $this->prefix . 'cmn_user_post', 'senderId' );
		$this->createIndex( 'idx_' . $this->prefix . 'post_user_recipient', $this->prefix . 'cmn_user_post', 'recipientId' );
	}

	private function upUserFollower() {

        $this->createTable( $this->prefix . 'cmn_user_follower', [
			'id' => $this->bigPrimaryKey( 20 ),
			'userId' => $this->bigInteger( 20 )->notNull(),
			'modelId' => $this->bigInteger( 20 )->notNull(),
			'type' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'active' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns user and model
		$this->createIndex( 'idx_' . $this->prefix . 'user_follower_user', $this->prefix . 'cmn_user_follower', 'userId' );
		$this->createIndex( 'idx_' . $this->prefix . 'user_follower_parent', $this->prefix . 'cmn_user_follower', 'modelId' );
	}

	private function upChat() {

        $this->createTable( $this->prefix . 'cmn_chat', [
			'id' => $this->bigPrimaryKey( 20 ),
			'createdBy' => $this->bigInteger( 20 )->notNull(),
			'modifiedBy' => $this->bigInteger( 20 ),
			'sessionId' => $this->string( Yii::$app->core->largeText )->notNull(),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'chat_creator', $this->prefix . 'cmn_chat', 'createdBy' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_modifier', $this->prefix . 'cmn_chat', 'modifiedBy' );
	}

	private function upChatMember() {

        $this->createTable( $this->prefix . 'cmn_chat_member', [
			'id' => $this->bigPrimaryKey( 20 ),
			'chatId' => $this->bigInteger( 20 )->notNull(),
			'userId' => $this->bigInteger( 20 )->notNull(),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'syncedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'chat_member_chat', $this->prefix . 'cmn_chat_member', 'chatId' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_member_user', $this->prefix . 'cmn_chat_member', 'userId' );
	}

	private function upChatMessage() {

        $this->createTable( $this->prefix . 'cmn_chat_message', [
			'id' => $this->bigPrimaryKey( 20 ),
			'senderId' => $this->bigInteger( 20 )->notNull(),
			'recipientId' => $this->bigInteger( 20 ),
			'chatId' => $this->bigInteger( 20 ),
			'code' => $this->string( Yii::$app->core->mediumText )->defaultValue( null ),
			'consumed' => $this->boolean()->notNull()->defaultValue( false ),
			'type' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns sender, recipient and chat
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_sender', $this->prefix . 'cmn_chat_message', 'senderId' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_recipient', $this->prefix . 'cmn_chat_message', 'recipientId' );
		$this->createIndex( 'idx_' . $this->prefix . 'chat_message_chat', $this->prefix . 'cmn_chat_message', 'chatId' );
	}

	private function upGroup() {

        $this->createTable( $this->prefix . 'cmn_group', [
			'id' => $this->bigPrimaryKey( 20 ),
			'siteId' => $this->bigInteger( 20 )->notNull(),
			'avatarId' => $this->bigInteger( 20 ),
			'ownerId' => $this->bigInteger( 20 ),
			'createdBy' => $this->bigInteger( 20 )->notNull(),
			'modifiedBy' => $this->bigInteger( 20 ),
			'name' => $this->string( Yii::$app->core->xLargeText )->notNull(),
			'slug' => $this->string( Yii::$app->core->xxLargeText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText )->notNull(),
			'icon' => $this->string( Yii::$app->core->largeText )->defaultValue( null ),
			'title' => $this->string( Yii::$app->core->xxxLargeText )->defaultValue( null ),
			'description' => $this->string( Yii::$app->core->xtraLargeText )->defaultValue( null ),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'visibility' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'order' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'featured' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns avatar, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'group_avatar', $this->prefix . 'cmn_group', 'avatarId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_owner', $this->prefix . 'cmn_group', 'ownerId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_creator', $this->prefix . 'cmn_group', 'createdBy' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_modifier', $this->prefix . 'cmn_group', 'modifiedBy' );
	}

	private function upGroupPost() {

        $this->createTable( $this->prefix . 'cmn_group_post', [
			'id' => $this->bigPrimaryKey( 20 ),
			'senderId' => $this->bigInteger( 20 )->notNull(),
			'groupId' => $this->bigInteger( 20 )->notNull(),
			'visibility' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'type' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns sender, recipient and group
		$this->createIndex( 'idx_' . $this->prefix . 'post_group_sender', $this->prefix . 'cmn_group_post', 'senderId' );
		$this->createIndex( 'idx_' . $this->prefix . 'post_group_parent', $this->prefix . 'cmn_group_post', 'groupId' );
	}

	private function upGroupFollower() {

        $this->createTable( $this->prefix . 'cmn_group_follower', [
			'id' => $this->bigPrimaryKey( 20 ),
			'userId' => $this->bigInteger( 20 )->notNull(),
			'modelId' => $this->bigInteger( 20 )->notNull(),
			'type' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'active' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns user and model
		$this->createIndex( 'idx_' . $this->prefix . 'group_follower_user', $this->prefix . 'cmn_group_follower', 'userId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_follower_parent', $this->prefix . 'cmn_group_follower', 'modelId' );
	}

	private function upGroupMeta() {

        $this->createTable( $this->prefix . 'cmn_group_meta', [
			'id' => $this->bigPrimaryKey( 20 ),
			'modelId' => $this->bigInteger( 20 )->notNull(),
			'name' => $this->string( Yii::$app->core->xLargeText )->notNull(),
			'label' => $this->string( Yii::$app->core->xxLargeText )->notNull(),
			'type' => $this->string( Yii::$app->core->mediumText ),
			'valueType' => $this->string( Yii::$app->core->mediumText )->notNull()->defaultValue( Meta::VALUE_TYPE_TEXT ),
			'value' => $this->text()
        ], $this->options );

        // Index for columns site, parent, creator and modifier
		$this->createIndex( 'idx_' . $this->prefix . 'group_meta_parent', $this->prefix . 'cmn_group_meta', 'modelId' );
	}

	private function upGroupMember() {

        $this->createTable( $this->prefix . 'cmn_group_member', [
			'id' => $this->bigPrimaryKey( 20 ),
			'groupId' => $this->bigInteger( 20 )->notNull(),
			'userId' => $this->bigInteger( 20 )->notNull(),
			'roleId' => $this->bigInteger( 20 )->notNull(),
			'status' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'syncedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns group, user and role
		$this->createIndex( 'idx_' . $this->prefix . 'group_member_group', $this->prefix . 'cmn_group_member', 'groupId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_member_user', $this->prefix . 'cmn_group_member', 'userId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_member_role', $this->prefix . 'cmn_group_member', 'roleId' );
	}

	private function upGroupMessage() {

        $this->createTable( $this->prefix . 'cmn_group_message', [
			'id' => $this->bigPrimaryKey( 20 ),
			'senderId' => $this->bigInteger( 20 )->notNull(),
			'groupId' => $this->bigInteger( 20 ),
			'broadcasted' => $this->boolean()->notNull()->defaultValue( false ),
			'type' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'content' => $this->mediumText(),
			'data' => $this->mediumText(),
			'gridCache' => $this->longText(),
			'gridCacheValid' => $this->boolean()->notNull()->defaultValue( false ),
			'gridCachedAt' => $this->dateTime()
        ], $this->options );

        // Index for columns sender and group
		$this->createIndex( 'idx_' . $this->prefix . 'group_message_sender', $this->prefix . 'cmn_group_message', 'senderId' );
		$this->createIndex( 'idx_' . $this->prefix . 'group_message_group', $this->prefix . 'cmn_group_message', 'groupId' );
	}

	private function generateForeignKeys() {

		// Friend
		$this->addForeignKey( 'fk_' . $this->prefix . 'friend_user', $this->prefix . 'cmn_friend', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'friend_parent', $this->prefix . 'cmn_friend', 'friendId', $this->prefix . 'core_user', 'id', 'CASCADE' );

		// User Post
        $this->addForeignKey( 'fk_' . $this->prefix . 'user_post_sender', $this->prefix . 'cmn_user_post', 'senderId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'user_post_recipient', $this->prefix . 'cmn_user_post', 'recipientId', $this->prefix . 'core_user', 'id', 'CASCADE' );

		// User Follower
        $this->addForeignKey( 'fk_' . $this->prefix . 'user_follower_user', $this->prefix . 'cmn_user_follower', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'user_follower_parent', $this->prefix . 'cmn_user_follower', 'modelId', $this->prefix . 'core_user', 'id', 'CASCADE' );

		// Chat
        $this->addForeignKey( 'fk_' . $this->prefix . 'chat_creator', $this->prefix . 'cmn_chat', 'createdBy', $this->prefix . 'core_user', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_modifier', $this->prefix . 'cmn_chat', 'modifiedBy', $this->prefix . 'core_user', 'id', 'SET NULL' );

		// Chat Member
        $this->addForeignKey( 'fk_' . $this->prefix . 'chat_member_chat', $this->prefix . 'cmn_chat_member', 'chatId', $this->prefix . 'cmn_chat', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_member_user', $this->prefix . 'cmn_chat_member', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );

		// Chat Message
        $this->addForeignKey( 'fk_' . $this->prefix . 'chat_message_sender', $this->prefix . 'cmn_chat_message', 'senderId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_message_recipient', $this->prefix . 'cmn_chat_message', 'recipientId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'chat_message_chat', $this->prefix . 'cmn_chat_message', 'chatId', $this->prefix . 'cmn_chat', 'id', 'CASCADE' );

		// Group
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_avatar', $this->prefix . 'cmn_group', 'avatarId', $this->prefix . 'core_file', 'id', 'SET NULL' );
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_owner', $this->prefix . 'cmn_group', 'ownerId', $this->prefix . 'core_user', 'id', 'RESTRICT' );
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_creator', $this->prefix . 'cmn_group', 'createdBy', $this->prefix . 'core_user', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_modifier', $this->prefix . 'cmn_group', 'modifiedBy', $this->prefix . 'core_user', 'id', 'SET NULL' );

		// Group Post
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_post_sender', $this->prefix . 'cmn_group_post', 'senderId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_post_parent', $this->prefix . 'cmn_group_post', 'groupId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );

		// Group Follower
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_follower_user', $this->prefix . 'cmn_group_follower', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_follower_parent', $this->prefix . 'cmn_group_follower', 'modelId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );

		// Group Meta
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_meta_parent', $this->prefix . 'cmn_group_meta', 'modelId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );

		// Group Member
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_member_group', $this->prefix . 'cmn_group_member', 'groupId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_member_user', $this->prefix . 'cmn_group_member', 'userId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_member_role', $this->prefix . 'cmn_group_member', 'roleId', $this->prefix . 'core_role', 'id', 'CASCADE' );

		// Group Message
        $this->addForeignKey( 'fk_' . $this->prefix . 'group_message_sender', $this->prefix . 'cmn_group_message', 'senderId', $this->prefix . 'core_user', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->prefix . 'group_message_group', $this->prefix . 'cmn_group_message', 'groupId', $this->prefix . 'cmn_group', 'id', 'CASCADE' );
	}

    public function down() {

		if( $this->fk ) {

			$this->dropForeignKeys();
		}

		// Friend
		$this->dropTable( $this->prefix . 'cmn_friend' );

		// User
		$this->dropTable( $this->prefix . 'cmn_user_post' );
		$this->dropTable( $this->prefix . 'cmn_user_follower' );

		// Chat
        $this->dropTable( $this->prefix . 'cmn_chat' );
		$this->dropTable( $this->prefix . 'cmn_chat_member' );
		$this->dropTable( $this->prefix . 'cmn_chat_message' );

		// Group
        $this->dropTable( $this->prefix . 'cmn_group' );
		$this->dropTable( $this->prefix . 'cmn_group_post' );
		$this->dropTable( $this->prefix . 'cmn_group_follower' );
		$this->dropTable( $this->prefix . 'cmn_group_meta' );
		$this->dropTable( $this->prefix . 'cmn_group_member' );
		$this->dropTable( $this->prefix . 'cmn_group_message' );
    }

	private function dropForeignKeys() {

		// Friend
		$this->dropForeignKey( 'fk_' . $this->prefix . 'friend_user', $this->prefix . 'cmn_friend' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'friend_parent', $this->prefix . 'cmn_friend' );

		// User Post
        $this->dropForeignKey( 'fk_' . $this->prefix . 'user_post_sender', $this->prefix . 'cmn_user_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'user_post_recipient', $this->prefix . 'cmn_user_post' );

		// User Follower
        $this->dropForeignKey( 'fk_' . $this->prefix . 'user_follower_user', $this->prefix . 'cmn_user_follower' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'user_follower_parent', $this->prefix . 'cmn_user_follower' );

		// Chat
        $this->dropForeignKey( 'fk_' . $this->prefix . 'chat_creator', $this->prefix . 'cmn_chat' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_modifier', $this->prefix . 'cmn_chat' );

		// Chat Member
        $this->dropForeignKey( 'fk_' . $this->prefix . 'chat_member_chat', $this->prefix . 'cmn_chat_member' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_member_user', $this->prefix . 'cmn_chat_member' );

		// Chat Message
        $this->dropForeignKey( 'fk_' . $this->prefix . 'chat_message_sender', $this->prefix . 'cmn_chat_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_message_recipient', $this->prefix . 'cmn_chat_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'chat_message_chat', $this->prefix . 'cmn_chat_message' );

		// Group
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_avatar', $this->prefix . 'cmn_group' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_owner', $this->prefix . 'cmn_group' );
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_creator', $this->prefix . 'cmn_group' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_modifier', $this->prefix . 'cmn_group' );

		// Group Post
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_post_sender', $this->prefix . 'cmn_group_post' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_post_parent', $this->prefix . 'cmn_group_post' );

		// Group Follower
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_follower_user', $this->prefix . 'cmn_group_follower' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_follower_parent', $this->prefix . 'cmn_group_follower' );

		// Group Meta
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_meta_parent', $this->prefix . 'cmn_group_meta' );

		// Group Member
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_member_group', $this->prefix . 'cmn_group_member' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_member_user', $this->prefix . 'cmn_group_member' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_member_role', $this->prefix . 'cmn_group_member' );

		// Group Message
        $this->dropForeignKey( 'fk_' . $this->prefix . 'group_message_sender', $this->prefix . 'cmn_group_message' );
		$this->dropForeignKey( 'fk_' . $this->prefix . 'group_message_group', $this->prefix . 'cmn_group_message' );
	}

}
